<?php
$p = $pager->getParamById('projects');


if ($auth->validate('ReviewRequestForm', array(
            array('b', 'Required', 'متن درخواست را وارد نمایید.'),
        ))) {
    $project = new Project($p['id']);
    $project->addReviewRequest($user->id);
    $_CONFIGS['Params'][1] = $p['id'];
    include 'core/pages/'.$subSite.'/project.php';
} else {
    ?>
    <div id="content-wrapper">
        <div id="content">
            <h1>درخواست بازبینی</h1>
            <?php $message->display() ?>
            <br>
            <table width="90%" align="center" class="projects">
                <tr>
                    <td><b>عنوان پروژه:</b> <?php echo $p['title'] ?></td>
                    <td><b>نوع پروژه:</b> <?php echo (($p['type'] == 'Public') ? 'عمومی' : (($p['type'] == 'Private') ? 'خصوصی' : 'مرکز ')) ?></td>
                </tr>
            </table>
            <br>
            در صورتی که نیاز به بازبینی در مورد پروژه، فایل نهایی و یا کاربر خاصی دارید ، متن درخواست خود را ارسال کنید تا سریعا مورد بازبینی قرار بگیرد.
            <br>
            <form class="form" method="post" action="review-request_<? echo $p['id']; ?>">
                <input type="hidden" name="formName" value="ReviewRequestForm" />
                <label>درخواست بازبینی</label>
                <textarea name="b" style="width:300px; height:120px;"></textarea>
                <label>کد امنیتی : <img src="captcha.php" align="left" /></label>
                <input type="text" style="width:100px" id="captcha" name="captcha" />
                <label> </label>
                <input type="submit" value="ثبت درخواست" name="submit" id="submit" />
            </form>
            <div class="clear"> </div>
        </div>
    </div>
<?
}?>