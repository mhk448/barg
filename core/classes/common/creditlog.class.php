<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Jul 25, 2013 , 10:26:16 PM
 * mhkInfo:
 */

/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

class CreditLog {

    public function add($user_id, $price, $ref_table, $ref_id, $comment) {
        global $cdatabase, $user, $_CONFIGS;
//        if (!$price)
//            Report::addLog("add 0 rial price! user_idd=" . $user_id . ' ref_table: ' . $ref_table . ' ref_id:' . $ref_id . ' com:' . $comment);

        $cdatabase->insert('credits', array(
            'user_id' => (int) $user_id,
            'price' => (int) $price,
            'subsite' => $_CONFIGS['subsite'],
            'ref_table' => $ref_table,
            'ref_id' => (int) $ref_id,
            'comment' => $comment,
            'dateline' => time()));

        return User::addCredit($user_id, $price);
    }

    public function sub($user_id, $price, $ref_table, $ref_id, $comment) {
        return $this->add($user_id, $price * -1, $ref_table, $ref_id, $comment);
    }

    public function getCredit($user_id, $firstDay, $lastDate) {
        global $cdatabase;
        return intval($cdatabase->selectField('credits', ' sum(`price`) as s ', $cdatabase->whereId($user_id, "user_id") . ' AND dateline > ' . intval($firstDay) . ' AND dateline < ' . intval($lastDate)));
    }

    public function getCash($user_id, $firstDay, $lastDate) {
        global $cdatabase;
        return intval($cdatabase->selectField('credits', ' sum(`price`) as s ', $cdatabase->whereId($user_id, "user_id") . ' AND dateline > ' . intval($firstDay) . ' AND dateline < ' . intval($lastDate) . ' AND price > 0'));
    }
    
    public function getExpense($user_id, $firstDay, $lastDate) {
        global $cdatabase;
        return intval($cdatabase->selectField('credits', ' sum(`price`) as s ', $cdatabase->whereId($user_id, "user_id") . ' AND dateline > ' . intval($firstDay) . ' AND dateline < ' . intval($lastDate) . ' AND price < 0'));
    }
    
    public function addPayouts($payout_id, $transaction_id, $date, $comment, $verified = 1) {
        global $cdatabase, $event, $message;
        $pay = $cdatabase->fetchAssoc($cdatabase->select('payouts', '*', $cdatabase->whereId($payout_id)));
        if ($pay) {
            if ($cdatabase->update('payouts', array(
                        'verified' => (int) $verified,
                        'transaction_id' => $transaction_id,
                        'pay_date' => $date,
                            ), $cdatabase->whereId($payout_id) . " LIMIT 1")) {
                $chenger = ' _AI' . $user->id . 'CT_'; //admin id ... change this
                if ($pay['verified'] == Event::$V_NONE || $pay['verified'] == Event::$V_REJECT) {
                    if ($verified == Event::$V_ACC) {
                        $this->sub($pay['user_id'], $pay['price'], 'payouts', $payout_id, $comment . $chenger);
                        $event->call($pay['user_id'], Event::$T_PAYOUT, $verified, array('price' => $pay['price'], 'com' => $comment), TRUE);
                    } elseif ($verified == Event::$V_REJECT) {
                        $event->call($pay['user_id'], Event::$T_PAYOUT, $verified, array('price' => $pay['price'], 'com' => $comment));
                    }
                } else if ($pay['verified'] == Event::$V_ACC) {
                    if ($verified == Event::$V_REJECT) {
                        $this->add($pay['user_id'], $pay['price'], 'payouts', $payout_id, $comment . $chenger);
                        $event->call($pay['user_id'], Event::$T_PAYOUT, $verified, array('price' => $pay['price'], 'com' => $comment));
                    }
                }
                $message->displayMessage("عملیات انجام شد");
                return TRUE;
            }
        }

        $message->displayError("خطا در انجام عملیات");
        $message->displayError("عدم وجود شتاسه ی پرداخت");
        return FALSE;
    }

    public function addPayments($payment_id, $transaction_id, $date, $comment, $verified = 1) {
        global $cdatabase, $event;

        $pay = $cdatabase->fetchAssoc($cdatabase->select('payments', '*', $cdatabase->whereId($payment_id)));
        if ($pay) {
            $cdatabase->update('payments', array(
                'verified' => (int) $verified,
                'pay_date' => $date,
                'tref' => $transaction_id
                    ), $cdatabase->whereId($payment_id) . " LIMIT 1");
            if ($pay['verified'] == Event::$V_NONE || $pay['verified'] == Event::$V_REJECT) {
                if ($verified == Event::$V_ACC) {
                    $this->add($pay['user_id'], $pay['price'], 'payments', $payment_id, $comment);
                    $event->call($pay['user_id'], Event::$T_PAYMENT, $verified, array('price' => $pay['price'], 'com' => $comment));
                } elseif ($verified == Event::$V_REJECT) {
//                    $event->call($pay['user_id'], Event::$T_PAYMENT, $verified, array('price' => $pay['price'], 'com' => $comment)); dont need
                }
            } else if ($pay['verified'] == Event::$V_ACC) {
                if ($verified == Event::$V_REJECT) {
                    $this->sub($pay['user_id'], $pay['price'], 'payments', $payment_id, $comment);
                    $event->call($pay['user_id'], Event::$T_PAYMENT, $verified, array('price' => $pay['price'], 'com' => $comment));
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function bank_addPayments($payment_id, $tref, $i_date) {
        return $this->addPayments($payment_id, $tref, $i_date, 'online auto accept', 1);
    }

}

?>
