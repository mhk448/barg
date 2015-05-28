<?php
$p = $pager->getParamById('projects');
$project=new Project($p['id']);
if ($p['typist_id'] != $user->id && !$user->isAdmin()) {
    header('Location: PermissionDenied');
    exit;
}
?>
<div id="content-wrapper">
    <div id="content">
        <h1>انصراف از پروژه</h1>
        <br>
        <?
        if ($project->cancelBid()) { // checking time at $project->cancelBid
            $message->display();
            ?>
            پیشنهاد شما با موفقیت لغو گردید.
            <?
        } else {
            $message->display();
            ?>
            شما اجازه ندارید پروژه را لغو نمایید
            <?
        }
        ?>   
    </div>
</div>