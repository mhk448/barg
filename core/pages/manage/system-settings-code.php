<?php

//if (!$user->isSuperAdmin())
if (!$user->isAdmin())
    exit;



if (isset($_REQUEST['code'])) {
    if ($_REQUEST['code'] == "adduser") {
        adduser();
//    } elseif ($_POST['code']=="adduser")) {
    } else {
        
    }
    $message->addMessage('کد به انتها شد');
}

//////////////////////////////////////////
function adduser() {
    global $cdatabase, $database, $creditlog, $_CONFIGS, $message, $event;
    return;
//    $oldDatabase = new Database($_CONFIGS['Database']['Server'], $_CONFIGS['Database']['User'], $_CONFIGS['Database']['Password'], 'mhk_elmend_old');

    $res = $cdatabase->fetchAll($cdatabase->select('old_users', '*', 'where added=0 Limit 50'));

    // id, usergroup, username, userpass, email,
    // state, login_key, last_login, this_login,
    // credits, locked_credits, reg_date, fullname,
    // ssn, gender, phone, mobile, state1, city,
    // address, bank_name, bank_account, bank_card,
    // bank_shaba, send_notify_email, send_projects_list,
    // rank, finished_projects, rankers, run_projects, signs, specs, 

    foreach ($res as $oldRes) {

        $oldRes['id'] = $oldRes['id'] + 100;

        foreach ($oldRes as $key => $value) {
            if ($oldRes[$key] === NULL)
                $oldRes[$key] = '';
        }

        $comArray = array(
            'id' => $oldRes['id'],
            'username' => $oldRes['username'],
            'userpass' => $oldRes['userpass'],
            'email' => $oldRes['email'],
            'state' => $oldRes['state'],
            'login_key' =>'',// $oldRes['login_key'],
            'credits' => $oldRes['credits'],
            'locked_credits' => $oldRes['locked_credits'],
            'reg_date' => $oldRes['reg_date'],
            'fullname' => $oldRes['fullname'],
            'nickname' => '',
            'ssn' => $oldRes['ssn'],
            'gender' => $oldRes['gender'],
            'phone' => $oldRes['phone'],
            'mobile' => $oldRes['mobile'],
            'city' => $oldRes['city'],
            'address' => $oldRes['address'],
            'bank_name' => $oldRes['bank_name'],
            'bank_account' => $oldRes['bank_account'],
            'bank_card' => $oldRes['bank_card'],
            'bank_shaba' => $oldRes['bank_shaba'],
            'send_notify_email' => 1,
            'send_projects_list' => 0,
            'send_bid_email' => 1,
            'send_sms_system' => 1,
            'send_sms_user' => 1,
            'detail' => '',
            'signs' => $oldRes['signs'],
            'specs' => $oldRes['specs']
        );


        $ug = ($oldRes['usergroup'] == 'Typist' ? (User::$G_WORKER) :
                        ($oldRes['usergroup'] == 'Representative' ? (User::$G_AGENCY) : $oldRes['usergroup']));

        $subArray = array(
            'id' => $oldRes['id'],
            'usergroup' => $ug,
            'rank' => $oldRes['rank'],
            'rankers' => $oldRes['rankers'],
            'rate' => 0,
            'finished_projects' => 0,
            'rejected_projects' => 0,
            'presenter_id' => User::$BARGARDOON,
            'level' => 2,
            'verified' => Event::$V_ACC,
        );

        $cdatabase->insert('users', $comArray);
        $database->insert('users_sub', $subArray);
        $cdatabase->update('old_users'
                , array('added' => 1)
                , $cdatabase->whereId($oldRes['id'] - 100));

        $event->call($oldRes['id'], Event::$T_USER, Event::$A_U_SIGNUP, NULL, FALSE, FALSE, TRUE, TRUE);

        if ($oldRes['credits']) {
            $message->addMessage(' credits: ' . $oldRes['credits'] . ' id is: ' . $oldRes['id'] . ' added ');
            $creditlog->add($oldRes['id'], $oldRes['credits'], 'users', User::$BARGARDOON, "انتقال وجه از نسخه قدیم تایپایران");
            $creditlog->sub(User::$BARGARDOON, $oldRes['credits'], 'users', $oldRes['id'], "انتقال وجه از نسخه قدیم تایپایران");
        }
        if ($oldRes['locked_credits']) {
            $message->addMessage(' locked_credits: ' . $oldRes['locked_credits'] . ' id is: ' . $oldRes['id'] . ' added ');

            $cdatabase->insert('lock_credit', array(
                'user_id' => $oldRes['id'],
                'subsite' => $_CONFIGS['subsite'],
                'prj_id' => 0,
                'price' => $oldRes['locked_credits'],
                'locked' => 1,
                'date' => time()));
        }
        $message->addMessage(' user: ' . $oldRes['username'] . ' id is: ' . $oldRes['id'] . ' added ');
    }
}