<br/>
</div>
</div>

<div class="clear"></div>
</div>
</section>

<div id="footer-wrapper" class="br-theme">
    <div id="footer">
        <div  >
            <div id="footer-right" style="">
                <p>
                    <img src="medias/images/theme/<?= $subSite; ?>iran_logo.png" class="" alt="<?= $subSite; ?>" width="150" style="margin-bottom:9px;margin-top:-10px;"/>
                </p> 
                <p>
                    <img src="medias/images/theme/<?= $subSite; ?>_qr_info.png" class="grow transition" alt="<?= $subSite; ?>" width="80" style="margin-left:7px;float: right"/>
                </p>
                <p>آدرس دفتر مرکزی:
                    <br/>
                    بندرعباس، بلوار امام خمینی،
                    <br/>
                    مجتمع تجاری نخل،
                    پلاک d22،
                    <br/>
                    مرکز پشتیبانی 
                    <?= $_CONFIGS['Site']['Sub']['NickName'] ?>
                </p>
                <p>سامانه پیامک : 
                    8900
                    8900
                    3000
                </p>
                <p>ایمیل : 
                    <?= $_CONFIGS['Site']['Sub']['Email'] ?>

                </p>
                <p>تلفن: 6661235 - 0761</p>
            </div>
            <div class="right-links">
                <h2><?= $_CONFIGS['Site']['Sub']['NickName'] ?></h2>
                <br/>
                <ul>
                    <li>
                        <a href="<?php echo $_CONFIGS['Site']['Sub']['Path'] ?>"> صفحه نخست <?= $_CONFIGS['Site']['Sub']['NickName'] ?></a>
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-about" . '"'; ?> target="_blank" >درباره ما</a> 
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-sub/type-contact" . '"'; ?> target="_blank" >تماس با ما</a> 
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Pathes']['Blog'] . '"'; ?> target="_blank" >وبلاگ <?= $_CONFIGS['Site']['Sub']['NickName'] ?></a>
                    </li>
<!--                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Forum'] . '"'; ?> target="_blank" >تالار گفتمان</a>
                    </li>-->
                    <li>
                        <a href<?= '="' ."http://internet.ir/law.html" . '"'; ?> target="_blank" > قانون جرائم رایانه‌ای</a>
                    </li>
                </ul>
            </div>
            <div class="right-links">
                <h2><?= $_CONFIGS['Site']['Sub']['NickName']; ?></h2>
                <br/>
                <ul>
                    <li>
                        <a href="<?php echo $_CONFIGS['Site']['Sub']['Path'] ?>"> صفحه نخست <?= $_CONFIGS['Site']['Sub']['NickName'] ?></a>
                    </li>
                    <li>
                        <a href="#">لیست پروژه ها</a> 
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "-help" . '"'; ?> target="_blank" >بخش راهنمای سایت</a> 
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "-learn" . '"'; ?> target="_blank">بخش آموزش</a>
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "-news" . '"'; ?> target="_blank" >اخبار و اطلاعیه ها</a>
                    </li>
                </ul>
            </div>
            <div class="right-links">
                <h2>راهنما</h2>
                <br/>
                <ul>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/submit-project" . '"'; ?> target="_blank">راهنمای ثبت سفارش</a>
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/typist" . '"'; ?> target="_blank">راهنمای <?= $_ENUM2FA['fa']['workers'] ?></a> 
                    </li>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/panel" . '"'; ?> target="_blank">راهنمای کار با پنل </a> 
                    </li>
                    <? if (isSubType()) { ?>
                        <li>
                            <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/typeonline" . '"'; ?> target="_blank">راهنمای تایپ آنلاین</a>
                        </li>
                    <? } ?>
                    <li>
                        <a href<?= '="' . $_CONFIGS['Site']['Sub']['Blog'] . "/type-help/select-typist" . '"'; ?> target="_blank">راهنمای انتخاب <?= $_ENUM2FA['fa']['worker'] ?> </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>


</div>
<div  style="background-color: #242424;border-top: 1px solid #111;">
    <div class="copy-right">
        <? if (!$user->isAdmin()) { ?>
            تمامی كالاها و خدمات این فروشگاه، حسب مورد دارای مجوزهای لازم از مراجع مربوطه می‌باشند.
            <br/>
            فعالیت‌های این سایت تابع قوانین و مقررات جمهوری اسلامی ایران است.
        <? } else { ?>
            <?= count(Database::$querys) ?>
        <? } ?>
        <br/>
    </div>

    <div class="right-links" style="float: right;padding: 5px;margin-right: 18px;">
        <div class="copy-right" style="">
            &copy; تمامی حقوق متعلق به مرکز <?= $_CONFIGS['Site']['Sub']['NickName'] ?> است.<br />
        </div>
        <div class="social1 social img-split24-1"></div>
        <div class="social2 social img-split24-2"></div>
        <div class="social3 social img-split24-3"></div>
    </div>
    <!-- Begin WebGozar.com Counter code -->
<!--    <script type="text/javascript" language="javascript" src="http://www.webgozar.ir/c.aspx?Code=2554794&amp;t=counter" ></script>
    <noscript><a href="http://www.webgozar.com/counter/stats.aspx?code=2554794" target="_blank">&#1570;&#1605;&#1575;&#1585;</a></noscript>-->
    <!-- End WebGozar.com Counter code -->	

    <div class="clear"></div>
</div>
</center>
<!--<div class="clear">-->
<!--</div>-->
<audio id="audio-event">
    <source src="/medias/sounds/splash/event.wav" type="audio/mp3">
</audio>
<audio id="audio-confirm">
    <source src="/medias/sounds/splash/confirm.mp3" type="audio/mp3">
</audio>
<? if (!$user->isAdmin()) { ?>
    <!-- Iran Web Festival -->
    <!--    <script>var _mxvtmw_position = 'right', _mxvtmw_domain = 'bargardoon.com'</script>
    <script src="http://iwfcdn.iranwebfestival.com/js/mx.vtmw.min.js?37275" async="async"></script>-->
    <!-- Iran Web Festival -->
<? } ?>
</body>
</html>