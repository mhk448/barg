<?php
$bid0 = $pager->getParamById('bids');
$bid = new Bid($bid0['id']);
$project = new Project($bid0['project_id']);
if (isset($_CONFIGS['Params'][2]) && ($_CONFIGS['Params'][2] === 'AB1' || $_CONFIGS['Params'][2] === 'AB2')) {
    $ajax = isset($_REQUEST['ajax']) ? "&ajax=1" : "";
    $project->acceptBidAndSetStakeholder($bid0);
    if ($_CONFIGS['Params'][2] === 'AB2') {
        header("Location:  earnest_" . $bid->project_id . $ajax);
    } else {
        header("Location:  project_" . $bid->project_id . $ajax);
    }
    exit;
}
?>
<div id="content-wrapper">
    <div id="content">
        <?
        $msg=' ';
        if ($user->getCredit() < $bid->earnest) {
            $msg = 'برای تایید این پیشنهاد باید مبلغ ';
            $msg.= $bid->earnest - $user->getCredit();
            $msg.='ریال به اعتبارتان بافزایید';
        }
        echo $bid->displayBid($msg);
        ?>
        <div>
            <? if ($project->can_cancel == 1) { ?>
                توجه: 
                <?= $_ENUM2FA['fa']['worker'] ?>
                انتخابی می تواند تا ۲ ساعت پس از تایید پیشنهاد آنرا لغو نماید. لذا از عدم انصراف 
                <?= $_ENUM2FA['fa']['worker'] ?>
                اطمینان حاصل نمایید.
                <br>
            <? } ?>

        </div>
        <div style="margin:20px; border:1px solid #CCC; padding:10px; text-align:center;">
            <? if ($user->getCredit() < $bid->earnest) { ?>
                <a href<?= '="add-credit?need_p=' . $bid->earnest . '&sq=accept-bid_' . $bid->id . '_AB1"'; ?>  onclick="">
                    <img src="medias/images/icons/tick.png" align="absmiddle" />
                    افزایش اعتبار
                </a>
                        <!--<a href="earnest_<?php // echo $bid0['project_id']                        ?>" class="remove" ><img src="medias/images/icons/tick.png" align="absmiddle" /> قبول پیشنهاد</a>-->
            <? } else { ?>
                <a href<?= '="accept-bid_' . $bid->id . '_AB2"' ?> class="remove popup" >
                    <img src="medias/images/icons/tick.png" align="absmiddle" />
                    <? if ($project->type == "Agency") { ?>
                        قبول پیشنهاد
                    <? } else { ?>
                        قبول پیشنهاد و گروگذاری اعتبار
                    <? } ?>
                </a>
            <? } ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a onclick="mhkform.close()"><img src="medias/images/icons/cross.png" align="absmiddle" /> انصراف</a>
        </div>
    </div>
</div>
