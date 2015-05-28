<?php

/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Feb 7, 2014 , 5:12:58 PM
 * mhkInfo:
 */
$out = array();
$info = isset($_REQUEST['info']) ? json_decode(commandDecode($_REQUEST['info']), TRUE) : array();
$fileName = isset($_REQUEST['name']) ? $_REQUEST['name'] : NULL;
if (isset($_REQUEST['func'])) {
    switch ($_REQUEST['func']) {
        case 'upload':
            $out = upload($info, $fileName);
            break;
        case 'delete':
            $out = delete($info, $fileName);
            break;
        case 'progress':
            $out = progress($info, $fileName);
            break;
    }
    echo json_encode($out);
    exit;
}

/////////////////////////////////////////////////////
function upload($data, $fileName) {
    global $_CONFIG;

//    $fileName = $data['name'];
    $path = $data['path'];
//    $subSite = $data['subsite'];
    $valid = $data['valids'];
    $maxSize = $data['maxsize'];

    $files = new Files();
    if (isset($_FILES['qqfile']['name']) && $_FILES['qqfile']['name'] != '') {
        $out['url'] = $_CONFIG['path'] . '/uploads/' . $path . '/' . $fileName;
        $out['name'] = $fileName;
        if (!$files->upload('qqfile', $fileName, 'uploads/' . $path . '/', $maxSize, $valid)) {
            $out['msg'] = ('فایل مورد نظر معتبر نمی باشد.');
            $out['percent'] = 0;
            $out["success"] = FALSE;
        } else {
            $out['percent'] = 100;
            $out['msg'] = 'فایل شما با موفقیت دریافت شد';
            $out["success"] = true;
        }
    }
    return $out;
}

function delete($data, $fileName) {
    $out["success"] = true;
    return $out;
}

function progress($data, $fileName) {

//   $out= uploadprogress_get_info($out['name']);
//    $out['name'] = $data['name'];
    $out['name'] = $fileName;
//    try {
//        $status = apc_fetch('upload_' . $out['name']);
//        $out['percent'] = $status['current'] / $status['total'] * 100;
//    } catch (Exception $exc) {
//        $out['msg2'] = $exc->getTraceAsString();
    $out['percent'] = rand(0, 100);
//    }
    return $out;


//    $out['percent']=  rand(0, 100);

    if ($out['percent'] < 30)
        $out['msg'] = 'لطفا منتظر بمانید';
    elseif ($out['percent'] < 60)
        $out['msg'] = 'و همچنان منتظر بمانید';
    elseif ($out['percent'] < 90)
        $out['msg'] = 'یخورده دیگه منتظر بمانید';

    return $out;
}

