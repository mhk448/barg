<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Aug 5, 2013 , 8:03:02 AM
 * mhkInfo:
 */
if(isset($_REQUEST['submit']) AND isset($_REQUEST['a'])){
    $user->setAbility($_REQUEST['a']);
}
$ability=$user->getAbility();
?>



<div id="content-wrapper">
    <div id="content">
        <h1>تخصص های من</h1>
        <br>
        <form action="ability" method="POST" class="form">

            <?
            foreach ($_ENUM2FA['lang'] as $lang => $falang) {
                ?>
            <input type="checkbox" name="a[]" value="<?= $lang ?>" <?=(isset($ability[$lang]))?'checked="checked"':''?>>
                <label style="clear: none;margin: 5px">
                    <?= $falang ?>
                </label>
                <br/>
                <br/>
                <?
            }
            ?>
                <input type="submit" name="submit" value="ثبت">

        </form>
    </div>
</div>








