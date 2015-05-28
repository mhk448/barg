<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Oct 18, 2013 , 5:50:21 PM
 * mhkInfo:
 */

class UserLevel {

    public function saveLevel($user, $qid, $a0, $a1, $a2, $a3, $a4, $a5) {
        global $database;

        $a0 = $a0 ? $a0 : 0;
        $a1 = $a1 ? $a1 : '';
        $a2 = $a2 ? $a2 : '';
        $a3 = $a3 ? $a3 : '';
        $a4 = $a4 ? $a4 : '';
        $a5 = $a5 ? $a5 : '';

        return $database->insert('level_a', array(
                    'q_id' => (int) $qid,
                    'user_id' => (int) $user->id,
                    'answer_0' => (int) $a0,
                    'answer_1' => $a1,
                    'answer_2' => $a2,
                    'answer_3' => $a3,
                    'answer_4' => $a4,
                    'answer_5' => $a5,
                    'dateline' => time()));
    }

    private function getNextLevel($user) {
        
    }

    public function displayLevelQuestion($user, $default = '') {
        global $database;
//        include '/core/test/userlevel.php'; //nc?
//        return;
        $res = $database->join('level_a', 'level_q', 'q_id', 'id', '*', $database->whereId($user->id, 'user_id') . ' ORDER BY dateline DESC LIMIT 1');
        $rows = $database->fetchAssoc($res);

        if ($rows) {
            $last_date = $rows['dateline'];
            $next_level = $rows['next_level'];
        } else {
            $last_date = $user->reg_date;
            if ($user->isAdmin())
                $next_level = 1;
            elseif ($user->isAgency())
                $next_level = 2;
            elseif ($user->isWorker())
                $next_level = 3;
            elseif ($user->isUser())
                $next_level = 4;
        }

        if ($next_level) {
            $next_q = $database->fetchAssoc($database->select('level_q', '*', $database->whereId($next_level)));
            if ($next_q) {
                if (($last_date + $next_q['interval']) < time()) {
                    echo $next_q['question'];
                } else {
                    echo $default;
                }
            } else {
                echo $default;
            }
        } else {
            echo $default;
        }
    }

    public function getAnswer($qid = NULL) {
        global $database;
        if ($qid)
            $res = $database->join('level_a', 'level_q', 'q_id', 'id', '*,`level_a`.`id` AS aid', 'WHERE readed=0 AND q_id=' . $qid . ' ORDER BY dateline DESC LIMIT 1');
        else {
            $res = $database->join('level_a', 'level_q', 'q_id', 'id', '*,`level_a`.`id` AS aid', 'WHERE readed=0  ORDER BY dateline DESC LIMIT 1');
        }
        return $database->fetchAssoc($res);
    }

    public function countNewAnswer($qid = NULL) {
        global $database;
        $database = new Database();
        if ($qid)
            $res = $database->selectCount('level_a', $database->whereId($qid, 'q_id') . 'AND readed=0');
        else {
            $res = $database->selectCount('level_a', $database->whereId(0, 'readed'));
        }
        return $res;
    }

    public function countAllAnswer($qid = NULL) {
        global $database;
        $database = new Database();
        if ($qid)
            $res = $database->selectCount('level_a', $database->whereId($qid, 'q_id'));
        else {
            $res = $database->selectCount('level_a');
        }
        return $res;
    }

    public function setRead($id) {
        global $database;
        return $database->update('level_a', array(
                    'readed' => 1
                        ), $database->whereId($id));
    }

    public function reset($qid) {
        global $database;
        return $database->update('level_a', array(
                    'readed' => 0
                        ), $database->whereId($qid,'q_id'));
    }
}

?>
