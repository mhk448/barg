<?php

include_once 'core/classes/common/base_bid.class.php';

class Bid extends BaseBid {

    public function checkValidate($project, $price) {
        global $database, $user, $event, $_PRICES, $subSite;
        $accepted = 0;
        return $accepted;
    }

}
