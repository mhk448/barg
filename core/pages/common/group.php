<?php
$g_info = $pager->getParamById('groups');
$group = new Group($g_info['id']);
?>
<div id="content-wrapper">
    <div id="content">


        <div class="" style="display:inline-block;min-width: 450px;border: 1px dotted #000;padding: 10px;margin: 5px;">
            <div  class="bg-theme" style="padding: 3px;margin: -5px">


                <div style="float: left;"> 
                    <?php // echo $persiandate->displayDate($group->) ?>
                </div>
                <div style="margin-left: 30px;float: right;"> 
                </div>
                <h1>
                    <?php echo $group->title ?></h1>
                <div class="clear"></div>
            </div>
            <div style="text-align: justify;padding: 20px;min-height: 100px;">
                <img  style="border: solid 4px #CCC ;float: left;margin: 5px;" src<?= '="uploads/' . $subSite . '/group/GL_' . $group->id . '.png?v=' . rand(0, 9) . '"' ?> width="100" height="100">
                <b>سازنده گروه : </b> <?= $user->getNickname($group->creator) ?> 
                <br>
                <b>امتیاز : </b> <?= $group->displayRank() ?> 
                <br>
                <!--                <b>رتبه : </b> <? //=$u->rate        ?> 
                                <br>-->
                <?php if ($user->isAdmin()) { ?>

                    <a href<?= '="twitts_group_' . $group->id . '"'; ?> >
                        توییت اختصاصی
                    </a>
                    <br/>
                    <b>نظر مدیریت:</b>
                    <?= $report->displayAdminComment($group->admin_comment);?>
                    <br>
                <?php } ?>
            </div>
            <div class="clear"></div>
            <hr/>
            <?= $group->displayMembers(); ?>
            <div class="clear"></div>

        </div>
    </div>
</div>
