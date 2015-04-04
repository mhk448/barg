<?php

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $event Event */
/* @var $message Message */
/* @var $persiandate PersianDate */
/* @var $project Project */
include_once 'core/classes/common/base_project.class.php';

class Project extends BaseProject {

    public function submit() {
        global $_PRICES, $database, $user, $message, $event;
        $data = json_decode($_POST['data'], TRUE);

        $bid_type = BaseBid::$TYPE_FULL;
        switch ($data['type']) {
            case "Agency":
                if (!$user->isAgency()) {
                    $message->addError('نوع پروژه را مشخص کنید');
                    return false;
                }
                $bid_type = BaseBid::$TYPE_PERWORD;
                $data['pagecount'] = $data['content_count'];
//                $data['price'] = $data['pagecount'] * $_PRICES['agency'][$data['lang']];
                break;
        }

        $database->insert('projects', array(
            'user_id' => (int) $user->id,
            'state' => 'Open',
            'submit_date' => time(),
            'title' => $data['title'],
            'level' => $data['level'],
            'subject' => $data['subject'],
            'lang' => $data['lang'],
            'guess_page_num' => $data['pagecount'],
            'description' => $data['desc'],
            'demo' => $data['demo'],
            'file_name' => $data['files'],
//            'expire_time' => $expire_date_time,
            'expire_interval' => $data['time_interval'],
            'output' => $data['output'],
            'type' => $data['type'],
            'bid_type' => $bid_type,
            'selection_method' => 'li',
            'max_price' => $data['price'],
            'lock_price' => $data['price'],
            'min_rate' => 0,
            'private_typist_id' => $data['private_worker'],
            'discount_code' => '',
            'earnest' => 0,
            'can_cancel' => 1,
            'verified' => ($user->isAgency()) ? 1 : Event::$V_AUTO_ACC,
        ));
        $pid = $database->getInsertedId();


        $event->call($user->id, Event::$T_PROJECT, Event::$A_SUBMIT
                , array(
            'prjtitle' => $data['title'],
            'prjid' => $pid,
        ));

        // nc? send sms for private and protected project
        if ($data['type'] == "Private") {
            $event->call($data['private_worker'], Event::$T_PROJECT, Event::$A_PRIVATE
                    , array(
                'prjtitle' => $data['title'],
                'prjid' => $pid,
            ));
        }

//        if ($type == "Referer") {
        $refer = $user->getDiscountReferer();
        if ($refer && $refer > 0) {
            $event->call($refer, Event::$T_PROJECT, Event::$A_REFERER
                    , array(
                'prjtitle' => $data['title'],
                'prjid' => $pid,
            ));
        }
//        $discount->deleteReferer();
        return $pid;
    }

    public function getOldProjectFiles($age = 10) {
        global $database;
        $keepFile = array();
        $ti = time() - $age * 24 * 60 * 60;
        $ps = $database->fetchAll($database->select('projects', 'file_name', "WHERE state='Run' OR state='Open' OR submit_date > '$ti' "));
        foreach ($ps as $p) {
            if (strpos($p['file_name'], ']')) {
                $b = json_decode($p['file_name'], TRUE);
                foreach ($b as $value) {
                    if (substr($value, 0, 4) != "http") {
                        $keepFile[$value] = 1;
                    }
                }
            } else {
                if (substr($p['file_name'], 0, 4) != "http") {
                    $keepFile[$p['file_name']] = 1;
                }
            }
        }

        Report::addLog($keepFile);
        return $keepFile;
    }

}
