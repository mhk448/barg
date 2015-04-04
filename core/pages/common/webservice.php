<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Aug 3, 2013 , 11:00:50 PM
 * mhkInfo:
 */
if (!isset($_REQUEST['type'])) {
    echo '0';
    exit;
}
/////////////// hometable  ///////////////////
if ($_REQUEST['type'] == "hometable") {

    $a = ENUM2FA_Event();
    $ver = (int) $_REQUEST['ver'];
    $list = $pager->getList('events', '*', "WHERE (`type`='" . Event::$T_PROJECT
            . "' OR `type`='" . Event::$T_BID
            . "') AND `action`<>'" . Event::$A_RECEIVE
            . "' AND `action`<>'" . Event::$A_P_FINAL_FILE_SUBMIT
            . "' AND `action`<>'" . Event::$A_P_RUN
            . "' AND `action`<>'" . Event::$V_DELETE
            . "' AND `action`<>'" . Event::$A_EDIT
            . "' AND `action`<>'" . Event::$V_NEED_EDIT
            . "' AND `action`<>'" . Event::$A_PRIVATE
            . "' AND `action`<>'"
            . "' AND dateline > " . $ver
            . " AND dateline < " . (time() -(60*3))
            . " ", 'ORDER BY dateline DESC', NULL, 16);

    $prj_count = $database->selectCount('projects');
    $typist_count = $database->selectCount('users_sub', "WHERE usergroup='Worker'");
    $sum_price_count = $database->selectField('projects', 'sum(`accepted_price`)');
    $sum_page_count = $database->selectField('final_files', 'sum(`pages`)');

//    $sum_page_count = $database->selectField('final_files', 'sum(`pages`)',"WHERE type='".Bid::$TYPE_FULL ."' OR type='".Bid::$TYPE_PERPAGE."'");
//    $sum_page_count += round($database->selectField('final_files', 'sum(`pages`)',"WHERE type='".Bid::$TYPE_PERWORD."'")/250);

    if (isset($_REQUEST['update'])) {
        $out = array();


        $out['count'] = array();
        $out['count']['project'] = $prj_count;
        $out['count']['typist'] = $typist_count;
        $out['count']['price'] = $sum_price_count;
        $out['count']['page'] = $sum_page_count;

        if (isSubType()) {
            $out['count']['project'] += 2021; //old site;
            $out['count']['price'] += 79603100; //old site;
            $out['count']['page'] += 29296; //old site;
        } elseif (isSubTranslate()) {
            $out['count']['page'] = round($sum_page_count / 250);
        }

        $tick_img = '<img src="medias/images/icons/open.png" align="absmiddle"/> ';
        $user_img = '<img src="medias/images/icons/user.png" align="absmiddle"/> ';

        $l = array();
        $index = 0;
        $ver = 0;
        foreach ($list as $e) {
            $p = new Project($e['ref_id']);
            $l[$index][] = getJsonTableInfo('hp_' . $p->id);
            if ($p->verified > 0 || $p->user_id == $user->id || $p->typist_id == $user->id) {
                $l[$index][] = $tick_img . '<a class="active_btn2" href="project_' . $p->id . '" class="dark">' . $p->title . '</a>';
            } else {
                $l[$index][] = $tick_img . '<a class="active_btn2" href="#" class="dark">' . $p->title . '</a>';
            }
            $l[$index][] = $_ENUM2FA['state'][$p->state];
            $l[$index][] = $p->guess_page_num;
            if (isSubType()) {
                $l[$index][] = $_ENUM2FA['lang'][$p->lang];
            }
//            $l[$index][] = $_ENUM2FA['type'][$p->type];
            $l[$index][] = $p->max_price . ' ' . 'ریال';
            $l[$index][] = '<a class="dark" href="user_' . $p->user_id . '">' . $user_img . $user->getNickname($p->user_id) . '</a>';

//            if ($p->typist_id)
//                $l[$index][] = '<a class="dark" href="user_' . $p->typist_id . '">' . $user_img . $user->getNickname($p->typist_id) . '</a>';
//            else {
//                $l[$index][] = $user->getNickname($p->typist_id);
//            }
            $l[$index][] = $persiandate->date('j F y ساعت: G:i', $e['dateline']);
            $l[$index][] = $tick_img . $a[$e['type']][$e['action']];

            $ver = $ver > $e['dateline'] ? $ver : $e['dateline'];
            $index++;
        }
        $ver = $ver ? $ver : time();
        $out['ver'] = $ver;
        $out['list'] = $l;

        echo json_encode($out);
    }
}
/////////////// panel_events ////////////////////////
if ($_REQUEST['type'] == "panel_events") {

    $a = ENUM2FA_Event();
    $ver = (int) $_REQUEST['ver'];
    $list = $pager->getList('events', '*', "WHERE user_id='{$user->id}'" . " AND dateline>" . $ver . " ", 'ORDER BY dateline DESC', NULL, 5);

    if (isset($_REQUEST['update'])) {
        $out = array();

        $l = array();
        $index = 0;
        $ver = 0;
        foreach ($list as $e) {
            $t = explode("::", $e['title']);
            $l[$index][] = getJsonTableInfo('event_' . $e['id']);
            $l[$index][] = '<a onclick="mhkform.ajax(\'event_' . $e['id'] . '?ajax=1\')" class="dark">' . $e['id'] . '</a>';
            $l[$index][] = '<a onclick="mhkform.ajax(\'event_' . $e['id'] . '?ajax=1\')" class="dark">' . $e['title'] . '</a>';
            $l[$index][] = $persiandate->date('d F Y', $e['dateline']) .
                    '<p style="font-size: 10px;">ساعت: ' . $persiandate->date('H:i:s', $e['dateline']) . '</p>';
//            $l[$index][] = $a[$e['type']][$e['action']];
            $l[$index][] = '<a onclick="mhkform.ajax(\'event_' . $e['id'] . '?ajax=1\')" class="dark"><img src="medias/images/icons/view.png" align="absmiddle" />  نمایش  </a>';

            $ver = $ver > $e['dateline'] ? $ver : $e['dateline'];
            $index++;
        }
        $ver = $ver ? $ver : time();
        $out['ver'] = $ver;
        $out['content'] = $l;
        $out['parent'] = 'table';

        echo json_encode($out);
    }
}
/////////////// panel_projects ////////////////////////
if ($_REQUEST['type'] == "panel_projects") {

    $ver = (int) $_REQUEST['ver'];

    $id = (int) $_REQUEST['id'];
    $_CONFIGS['Params'][2] = $user->id;
    $prj = new Project();
    $list = $prj->getList(5, 'submit_date > ' . $ver);

    if (isset($_REQUEST['update'])) {
        $out = array();

        $l = array();
        $index = 0;
        $ver = 0;
        foreach ($list as $p) {
            $p = new Project($p['id']);
            $l[$index][] = getJsonTableInfo('project_' . $p->id);
            if ($p->verified > 0 || $p->user_id == $user->id || $p->typist_id == $user->id) {
                $l[$index][] = '<a href="project_' . $p->id . '" class="dark">' . $p->title . '</a>';
            } else {
                $l[$index][] = '<a href="#" class="dark">' . $p->title . '</a>';
            }
            $l[$index][] = $_ENUM2FA['type'][$p->type] .
                    '<p style="font-size: 10px;">' . $_ENUM2FA['output'][$p->output] . '</p>';
            $l[$index][] = $_ENUM2FA['state'][$p->state];
            $l[$index][] = $persiandate->date('d F Y', $p->submit_date) .
                    '<p style="font-size: 10px;">ساعت: ' . $persiandate->date('H:i:s', $p->submit_date) . '</p>';
            $l[$index][] = $p->getBidsCount();

            $ver = $ver > $p->submit_date ? $ver : $p->submit_date;
            $index++;
        }
        $ver = $ver ? $ver : time();
        $out['ver'] = $ver;
        $out['content'] = $l;
        $out['parent'] = 'table';

        echo json_encode($out);
    }
}
/////////////// project_bid ////////////////////////
if ($_REQUEST['type'] == "project_bid") {

    $ver = (int) $_REQUEST['ver'];

    if (isset($_REQUEST['update'])) {
        $out = array();

        $id = (int) $_REQUEST['id'];
        $p = new Project($id);
        $list = $bid->getProjectBids($p, $ver);

        $l = array();
        $index = 0;
        $ver = 0;
        for ($index1 = 0; $index1 < 1; $index1++) {//for graphic test
            foreach ($list as $bid0) {
                $u = new User($bid0['user_id']);
                $b = new Bid($bid0['id']);
                $div = $b->displayBid();

//            $l[$index][] = ($bid0['attached_file']) ? ('<a href="uploads/bid/' . $bid0['attached_file'] . '">دانلود</a>') : '-';
                $l[$index][0] = 'bid_' . $bid0['id'];
                $l[$index][1] = $div;
                $ver = $ver > $bid0['dateline'] ? $ver : $bid0['dateline'];
                $index++;
            }
        }
        $ver = $ver ? $ver : time();
        $out['ver'] = $ver;
        $out['content'] = $l;
        $out['parent'] = 'div';

        echo json_encode($out);
    }
}
/////////////// projects_list ////////////////////////
if ($_REQUEST['type'] == "typeonline_projects") {

    $ver = (int) $_REQUEST['ver'];
//    $ver = 0;

    if (isset($_REQUEST['update'])) {
        $out = array();
//        $id = (int) $_REQUEST['id'];
        $prj = new Project();
        $list = $prj->getList(30, 'submit_date > ' . $ver);
        $my_prj = ($project->E_user_id > 0); // boolean

        $l = array();
        $index = 0;
        $ver = 0;

        foreach ($list as $p) {
            $u = new User($p['user_id']);
            if ($my_prj)
                $class_ = 'pointer my-project';
            else
                $class_ = 'pointer ';

            $onclick_ = "mhkform.ajax('project_" . $p['id'] . "?ajax=1','#ajax_content')";
            $l[$index][] = getJsonTableInfo($p['id'], $class_, $onclick_);
            $l[$index][] = '<br/><p class="number" style="text-align: right;">T' . $p['id'] . '</p><br/>';
            $l[$index][] = '<a class="ajax" ' . 'href="project_' . $p['id'] . '"' . ' style="display:block" target="_blank">'
                    . $p['title'] .
                    '</a>';
            $l[$index][] = $_ENUM2FA['type'][$p['type']]
                    . '<p style="font-size: 10px;">' . $_ENUM2FA['output'][$p['output']] . '</p>';

            $l[$index][] = $p['verified'] == 1 ? $_ENUM2FA['state'][$p['state']] : ( $_ENUM2FA['verified'][$p['verified']] );


            $l[$index][] = $persiandate->displayDate($p['submit_date']);

            $l[$index][] = $u->getNickname() . '<br/>' . $u->displayCups();

            $l[$index][] = $p['guess_page_num'];

            $l[$index][] = '<span class="price">' . $p['max_price'] . '</span>' . '
                        ریال    
                    ';

            $l[$index][] = $project->getBidsCount($p['id']);


            $tmp = '<a class="ajax" href="project_' . $p['id'] . '" target="_blank">'
                    . '<img src="medias/images/icons/bid.png" align="absmiddle" />
                            نمایش جزئیات
                        </a><br/>';
            if ($p['state'] == 'Open' AND !$my_prj) {
                $tmp.= '<a  onclick="mhkform.ajax(\'project_' . $p['id'] . '?ajax=1&showBidForm=1\')">'
                        . '<img src="medias/images/icons/bid.png" align="absmiddle" />
                                ارسال پیشنهاد
                            </a><br/>';
            }

            $l[$index][] = $tmp;

//            $ver = $ver > $bid0['dateline'] ? $ver : $bid0['dateline'];
            $index++;
        }
        $ver = $ver ? $ver : time();
        $out['ver'] = $ver;
        $out['content'] = $l;
        $out['parent'] = 'table';

        echo json_encode($out);
    }
}
/////////////// event ////////////////////////
if ($_REQUEST['type'] == "event") {

    $out = array();
    $ver = (int) $_REQUEST['ver'];
    $out['ver'] = time();

    if (isset($_REQUEST['update'])) {
        if ($user->isSignin()) {
            $list = $pager->getList('events', '*', "WHERE user_id='{$user->id}'" . " AND dateline>" . $ver . " ", ' ORDER BY readed ASC , dateline DESC ', NULL, 5);
        } else {
            $list = null;
        }
        $out['events'] = $list;
//        $out['content'] = $l;
//        $out['parent'] = 'div';

        echo json_encode($out);
    }
}
/////////////// twitt ////////////////////////
if ($_REQUEST['type'] == "twitt") {

    $out = array();
    $ver = (int) $_REQUEST['ver'];
    $out['ver'] = time();
    $ref_page = $_REQUEST['ref_page'];
    $ref_id = (int) $_REQUEST['ref_id'];
    $maxBox = (int) (isset($_REQUEST['maxBox']) ? $_REQUEST['maxBox'] : 1);

    if (isset($_REQUEST['add'])) {
        if ($user->isSignin()) {
            $twitt->add($user->id, $ref_page, $ref_id, $_REQUEST['text'], $_REQUEST['reply_id']);
        }
    }

    if (isset($_REQUEST['remove'])) {
        if ($user->isSignin()) {
            echo $twitt->delete($_REQUEST['tid']);
        }
    }

    if (isset($_REQUEST['update']) || isset($_REQUEST['add'])) {
        $list = $pager->getList('twitts', '*', "WHERE dateline>=" . $ver . " AND verified>=0 AND ref_page='" . $ref_page . "' AND ref_id='" . $ref_id . "' ", ' ORDER BY dateline DESC, id ASC ', NULL, $maxBox);
        foreach ($list as $key => $t) {
            $t['user_nickname'] = $user->getNickname($t['user_id']);
//            $t['persiandate'] = $persiandate->date('G:i:s', $t['dateline']);
            $t['date'] = date(DATE_ISO8601, $t['dateline']);
            $list[$key] = $t;
        }

        $out['twitts'] = $list;

        echo json_encode($out);
    }
}
/////////////// file ////////////////////////
if ($_REQUEST['type'] == "file") {
    include 'service/file.php';
}

function getJsonTableInfo($id_, $class_ = "", $onclick_ = "") {
    $out = array();
    $out['id_'] = $id_;
    $out['class_'] = $class_;
    $out['onclick_'] = $onclick_;
    return $out;
}

////////////
