<?php
/* @var $user User */
/* @var $message Message */
/* @var $pager Pager */
/* @var $content Content */

if (isset($_POST['submit'])) {
    if ($_POST['id'] == '') {
        $message->conditionDisplay($content->add($_POST['ut'], $_POST['t'], $_POST['b']));
    } else {
        $content = new Content($_POST['id']);
        $c_info['id'] = $_POST['id'];
        $message->conditionDisplay($content->update($_POST['ut'], $_POST['t'], $_POST['b']));
    }
}


$c_info = $pager->getParamById('contents', FALSE);
$con = new Content($c_info['id']);
?>
<script type="text/javascript" src="plugin/ckeditor4/ckeditor.js"></script>
<div id="content-wrapper">
    <div id="content">
        <h1>ارسال مطلب</h1>
        <?php $message->display() ?>
        <form method="post" class="form" action="manage-content">
            <input type="hidden" name="id" value="<?= $con->id; ?>"/>
            <!--<label>متن مطلب</label>-->
            <textarea name="b" style="width:500px; height:120px;"  class="ckeditor"><?= $con->body; ?></textarea>
            <br/>
            <label>عنوان مطلب</label>
            <input type="text" name="t" style="width:500px" value="<?= $con->title; ?>"/>
            <label>مخاطب</label>
            <select name="ut">
                <option value="All" <?= $con->user_type == "All" ? 'selected="selected"' : ''; ?>>
                    همه اعضاء
                </option>
                <option value="Agency" <?= $con->user_type == "Agency" ? 'selected="selected"' : ''; ?>>
                    نمایندگان
                </option>
                <option value="User" <?= $con->user_type == "User" ? 'selected="selected"' : ''; ?>>
                    کاربران
                </option>
                <option value="Worker" <?= $con->user_type == "Worker" ? 'selected="selected"' : ''; ?>>
                    تایپیستها
                </option>
            </select>
            <label> </label>
            <input type="submit" value="ارسال مطلب" name="submit" id="submit" />
        </form>

    </div>
</div>
