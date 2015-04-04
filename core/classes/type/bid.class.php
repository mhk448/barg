<?php

include_once 'core/classes/common/base_bid.class.php';

class Bid extends BaseBid {

    public function checkValidate($project, $price) {
        global $database, $user, $event, $_PRICES, $subSite;
        $accepted = 0;
        if ($project->bid_type == Bid::$TYPE_PERPAGE) {
            if ($price < $_PRICES['user'][$project->lang] * ((100 - rand(16, 18)) / 100) && $price != 0) {
                $accepted = -2;
//            $pr = 1000;
                $event->call($user->id, Event::$T_BID, Event::$V_NEED_EDIT
                        , array(
                    'prjtitle' => $project->getTitle($_POST['pid']),
                    'prjid' => (int) $_POST['pid'],
                        ), FALSE, FALSE);
            }
        }
        return $accepted;
    }

}
