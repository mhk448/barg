<?php
$p = $pager->getParamById('projects');
$project = new Project($p['id']);
?>
<div id="content-wrapper">
    <div id="content">
        <h1>
            <?php // echo $user->getNickname() ?>
            پروژه ی شما با عنوان 
            
            <u><?= $project->title; ?></u>
            با موفقیت ثبت شد
        </h1>
        <hr/>
        <br><br>


        راهنمایی های لازم در <a href="help"><b>صفحه راهنما</b></a> شما را در رسیدن به اهداف خود، یاری می رسانند.
        <br><br>
        در صورت بروز هرگونه مشکل می توانید از طریق <a href="support"><b>بخش پشتیبانی</b></a> مشکلتان را در اسرع وقت حل نمایید.

        <br/>
        <? if ($project->output == "ONLINE") { ?>
            <script type="text/javascript">
                setTimeout("mhkform.ajax('projects_open?typeonline=1&ajax=1','#ajax_content')", 5000);
            </script>
            <img src="medias/images/icons/loading.gif" align="absmiddle" />منتظر بمانید
        <? } else { ?>
            <br/>
            <a href="project_<?= $p['id'] ?>" class="ajax active_btn">
                مشاهده پروژه
            </a>
        <? } ?>

        <br>
        <br>
    </div>
</div>
