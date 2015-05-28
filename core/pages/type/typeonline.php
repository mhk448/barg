<?php
/* @var $user User */
//define("TYPEONLINE_INIT_URL", "http://elmend.ir/type/typeonline");
//define("TYPEONLINE_INIT_URL", "http://type.elmend.ir/typeonline");
//define("TYPEONLINE_INIT_URL", $_CONFIGS['Site']['Sub']['Path'] . "type/typeonline");
//define("TYPEONLINE_INIT_URL", "http://elmend.xzn.ir/type/type/typeonline");
define("TYPEONLINE_INIT_URL", $_CONFIGS['FileServerPath'] . "type/typeonline");

if (!$user->isSignin()) {
    Report::addLog("Error page ");
    header('Location: error');
    exit;
}

$p = $pager->getParamById('projects');
$pid = (int)$p['id'];
$project = new Project($pid);

$finalfileExist = $project->getFinalFile() ? TRUE : FALSE;

function isValidUser($p) {
    global $user;
    return ($p['typist_id'] == $user->id
            || $p['user_id'] == $user->id
            || $user->isAdmin());
}

//$p['typist_id'] = 624; 
//$p['user_id'] = 720;
//$p['id'] =$pid  = 3323454;
// 
//if (!($p['user_id'] == $user->id || $p['typist_id'] == $user->id || $user->usergroup == 'Administrator')) {
//    header('Location: error');
//    exit;
//}
if ($p['typist_id'] == $user->id)
    $cur_user_type = "Worker";
else {
    $cur_user_type = "User";
}
//////////////// WORD ///////////
if (isset($_REQUEST['v']) && isValidUser($p)) {
//    if ($p['state'] != 'Finish' AND $user->id == $p['user_id'])
//        exit; // must be finished
    if ($_REQUEST['v'] == '2007') {
        include_once 'plugin/word/htmltodocx_0_6_5/mhk_html2word.php';
//        include_once 'plugin/word/PHPWord_0.6.2/mhk_html2word.php';
    } else {
        include_once 'plugin/word/mhk_html2doc/mhk_html2doc.php';
    }
    $t = $database->fetchAssoc($database->select('typeonline', 'text,chat,last_edit,img_id,finished', "WHERE pid=$pid"));
//    $t['text2']= str_replace("</p>","</p>mmm",$t['text']);
//    $t['text2']= str_replace("\r","+",$t['text2']);
    MHK_Html2Word($t['text'], $_CONFIGS['Site']['Sub']['NickPath'] . '_T' . $p['id']);
    exit;
}


//$cur_user_type = "Worker";
//$cur_user_type = "User"; 
//$cur_user_type = "Admin"; 

$folderName = substr($p['file_name'], 0, -4);
////////////// INIT //////////////////////////////
if (!$database->isRowExists('typeonline', '*', "WHERE pid = {$pid}")) {
    //typeonline_init
    if (isset($_REQUEST['otherfile'])) {
        $other_file = $_REQUEST['otherfile'];
        $database->insert('typeonline', array(
            'pid' => $pid,
            'img_id' => 0,
            'finished' => 0,
            'other_file' => (int) $other_file,
        ));
    } else {
        //    $other_file = file_get_contents($url0);
        $url0 = TYPEONLINE_INIT_URL . "?method=" . "extract" . "&file=" . $p['file_name'];
        header("Location: $url0" . '&re=' . $pid);
    }
}
//////////// SAVE ///////////////////////////////
if (isset($_REQUEST['save']) && isValidUser($p)) {
    if (isset($_REQUEST['text'])) {
        $text = $_REQUEST['text'];
        $img_id = $_REQUEST['img_id'];
//        $chat = $_REQUEST['chat'];
//        $finished = $_REQUEST['finished'];
//        $finished = $finalfileExist?1:0;

        $database->update('typeonline', array(
            'text' => $text,
            'img_id' => $img_id,
//            'chat' => $chat,
//            'finished' => $finished,
                ), "WHERE pid = " . $pid);
    }
    $t = $database->fetchAssoc($database->select('typeonline', 'last_visit,chat', "WHERE pid=$pid"));
    $t['server_time'] = (string) time();
    echo json_encode($t);
    exit;
}
//////////// FINISH ///////////////////////////////
if (isset($_REQUEST['finished']) && isValidUser($p)) {
    $database->update('typeonline', array(
        'finished' => 1,
            ), "WHERE pid = " . $pid);

    exit;
}
//////////// Load ///////////////////////////////
if (isset($_REQUEST['load'])) {
    $database->update('typeonline', array(
        'last_visit' => time(),
            ), "WHERE pid = " . $pid);
    $t = $database->fetchAssoc($database->select('typeonline', 'text,chat,last_edit,img_id,finished', "WHERE pid=$pid"));
    $t['server_time'] = (string) time();
    $t['finished'] = $finalfileExist ? 1 : 0;
    echo json_encode($t);
    exit;
}
//////////// Chat /////////////////////////////////
if (isset($_REQUEST['chat']) && isValidUser($p)) {
    if (isset($_REQUEST['msg']) && $_REQUEST['msg']) {
        $t = $database->fetchAssoc($database->select('typeonline', 'chat', "WHERE pid=$pid"));
        $chat = $t['chat'];
        $chat .= '{"id":"' . (string) (($user->isAdmin() ? 'A' : '') . $user->id) . '","msg":"' . $_REQUEST['msg'] . '"},';

        $database->update('typeonline', array(
            'chat' => $chat,
                ), "WHERE pid = " . $pid);
    }
    $t = $database->fetchAssoc($database->select('typeonline', 'chat', "WHERE pid=$pid"));
//    $t['server_time'] = (string) time();
    $out = '[' . substr($t['chat'], 0, -1) . ']';

//    $o=array();
//    $o[]['id']="sd1";
//    $o[]['id']="sd2";
//      echo json_encode($o);
//    exit;

    echo $out;
    exit;
}
////////////////////////////////////////////////////
$t = $database->fetchAssoc($database->select('typeonline', '*', "WHERE pid=$pid"));

$user_id = $user->getNickname($p['user_id']);
$typist_id = $user->getNickname($p['typist_id']);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $_CONFIGS['Page']['Title'] ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <meta name="description" content="<?php echo $_CONFIGS['Page']['Description'] ?>" />
        <meta name="keywords" content="<?php echo $_CONFIGS['Page']['Keywords'] ?>" />
        <link rel="shortcut icon" href="type_favicon.ico" />
        <!--<script type="text/javascript" src="medias/scripts/jquery-2.0.0.min.js"></script>-->
        <link rel="stylesheet" type="text/css" media="all" href="medias/styles/typeonline.css"/>
        <link rel="stylesheet" type="text/css" media="all" href="medias/styles/style.css"/>
        <link href="medias/styles/jquery-ui-typeonline.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="medias/scripts/jquery-typeonline.js"></script>
        <script type="text/javascript" src="plugin/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="medias/scripts/type/typeonline.js?v=2" ></script>
        <script type="text/javascript" src="medias/scripts/jquery-ui.min.js" ></script>
        <script type="text/javascript" src="medias/scripts/mhkform.js?v=2"></script>
        <!--<script type="text/javascript" src="medias/scripts/events.js?v=2"></script>-->
    </head>
    <body bgcolor="blue">
        <center>
            <div align="center" >
                <div dir="rtl" style="height: 100%;overflow: hidden;background-color: white">

                    <div style="background-color: white; cursor: pointer;" id="draggable">
                        <img class="slide teta0" 
                             style="width: 100%;" 
                             id="scanedtext" 

                             <?= 'src0="' . TYPEONLINE_INIT_URL . "/files/" . $folderName . '"'; ?>
                             <?= 'imgid="' . $t['img_id'] . '"'; ?>
                             src="<?= TYPEONLINE_INIT_URL . "/files/" . $folderName . "/img_" . $t['img_id'] . ".png"; ?>"/>
                    </div>

                    <div id="line"  >.</div>

                    <div class="right_menu" style="" >
                        <div  id="logo">
                            <img style="width: 180px;" src="medias/images/icons/logo_typeonline.png" alt="Logo" onclick="$('#menu').slideToggle();"/>
                        </div>

                        <div id="menu">
                            <!--<img style="width: 160px;" src="medias/images/icons/menu_typeonline.png" alt="Logo"/>-->


                            <div class="trans user" >
                                <img  alt="D" src="medias/images/icons/typeonline_date.png"/>
                                تاریخ: 
                                <?= $persiandate->date("Y/m/d", $p['expire_time']) ?>
                            </div>
                            <div class="user" >
                                <img src="medias/images/icons/typeonline_user.png" alt="D"/>
                                کارفرما:
                                <span>
                                    <?= $user_id ?>
                                </span>
                            </div>                                
                            <div class="user" >
                                <img  src="medias/images/icons/typeonline_user.png" alt="D"/>
                                مجری:
                                <span>
                                    <?= $typist_id ?>
                                </span>
                            </div>   
                            <div class="trans" >
                                کلمات تایپ شده:
                                <span id="word_counter"></span>
                            </div>    

                            <div class="btn" >
                                <img src="medias/images/icons/typeonline_zoom_in.png" title="بزرگنمایی"     alt="ZoomIn"      onclick="MHKZoomIn();"  />
                                <img src="medias/images/icons/typeonline_zoom_out.png" title=""             alt="ZoomOut"     onclick="MHKZoomOut();" />
                                <img src="medias/images/icons/typeonline_rotate.png"  title="چرخش"          alt="Rotate"      onclick="Rotate();"     />
                                <img src="medias/images/icons/typeonline_line.png"    title="خط نشان"              alt="Down"        onclick="HideLine();"   />

<!--<img src="image/Down.png"    title="حرکت به پایان"   alt="Down"        onclick="MoveLine(lineTop+10);"/>-->
<!--<img src="image/Up.png"      title="حرکت به بالا" alt="Up"          onclick="MoveLine(lineTop-10);"/>-->
                                <? if (isValidUser($p)) { ?>
                                    <img src="medias/images/icons/typeonline_chat.png"  title="گفت و گو"      alt=""   onclick="$('#chat').slideToggle();" />
                                <? } ?>
<!--<img src="medias/images/icons/typeonline_Image1.png"  title="افزایش نور"    alt="Add Opacity"  onclick="AddOpacity();" />-->
<!--<img src="medias/images/icons/typeonline_Image2.png"  title="کاهش نور"      alt="Sub Opacity"  onclick="SubOpacity();" />-->
                                <? if ($cur_user_type == User::$G_WORKER) { ?>
                                    <img src="medias/images/icons/typeonline_next.png"  title=""      alt=""  onclick="ChangePic(1)" />
                                    <img src="medias/images/icons/typeonline_perv.png"  title=""      alt=""  onclick="ChangePic(-1)" />
                                <? } ?>
                                <? if (isValidUser($p)) { ?>
                                    <? if ($cur_user_type == User::$G_WORKER) { ?>
                                        <a onclick="mhkform.ajax('project_<?= $pid ?>?ajax=1&showFinalForm=1');" target="_blank" >
                                            <img src="medias/images/icons/typeonline_save.png"  title="اتمام پروژه و تحویل فایل"  alt="" />
                                        </a>
                                        <!--                                        <a href="?v=2007" target="_blank">
                                                                                    <img src="medias/images/icons/typeonline_save.png"  title="دانلود"  alt="" />
                                                                                </a>-->
                                    <? } elseif ($p['state'] != 'Finish') { ?>
                                        <a onclick="mhkform.ajax('finish-project_<?= $pid ?>?ajax=1');" >
                                            <img src="medias/images/icons/typeonline_save.png"  title="اتمام پروژه "  alt="" />
                                        </a>
                                    <? } else { ?>
                                        <a href="?v=2007" target="_blank">
                                            <img src="medias/images/icons/typeonline_save.png"  title="دانلود"  alt="" />
                                        </a>
                                    <? } ?>
                                <? } ?>
                            </div> 
                            <br/>
                            <br/>


                            <div id="chat">
                                <div id="content">
                                    <br/>
                                </div>
                                <input type="submit" value="«" onclick="SendChat();"/>
                                <input type="text" name="msg" id="msg"/>
                            </div>



                        </div>
                    </div>


                </div>
                <? if ($cur_user_type != "User") { ?>
                    <div style="position: fixed;top: 60%;  width: 100%;font-family: tahoma;">
                        <form method="POST" action="save.php" >
                            <textarea id="maintypetext" name="maintypetext" class="ckeditor" >
                                <?
                                echo $t['text'];
                                ?>
                            </textarea>
                        </form>
                    </div>
                <? } else { ?>
                    <div id="textveiw" class="textview">
                        <div class="textview2">
                            <div id="maintext" style="padding: 10px">
                                <?
                                echo $t['text'];
                                ?>
                            </div>
                        </div>
                    </div>
                <? } ?>


            </div>
        </center>
        <script>
            $(document).ready(function() {
                $("#draggable").draggable();
                $("#line").draggable();
<?
echo 'cur_id="' . $user->id . '" ;' . "\n";
echo 'user_id="' . $p['user_id'] . '" ;' . "\n";
echo 'worker_id="' . $p['typist_id'] . '" ;' . "\n";
echo 'project_id="' . $pid . '" ;' . "\n";

//echo 'user_type="' . strtolower($cur_user_type) . '";';
if (isValidUser($p)) {
    echo ' StartChat(); ' . "\n";
} else {
    echo 'setInterval("$(\'#chat\').remove()",2000);' . "\n";
}

if ($cur_user_type == "User") {
//    echo 'setInterval(StartLoad,1000);';
    if ($finalfileExist) {
        echo 'save_time=9999999;' . "\n";
        echo 'load_time=9999999;' . "\n";
    }
    echo 'showFinishMsg=' . ((isValidUser($p) && $project->state == "Run") ? 'true' : 'false') . ';' . "\n";
    echo 'StartLoad();' . "\n";
} else {
    echo 'StartSave();' . "\n";
}
?>
    });
        </script>
    </body>
</html>