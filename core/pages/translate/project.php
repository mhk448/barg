<?php

//
//
// ------------ showProjectInfo -----------------
//
//
function showProjectInfo() {
    global $_ENUM2FA, $project, $user, $persiandate, $_CONFIGS, $_PRICES;
    $s_user = new User($project->user_id);
    ?>
    <div>
        <div style="width:100%;">
            <div class="pero-r1s1 bg-gradian bg-theme">
                <p id="pero-r1s1-1">وضعیت پروژه</p>
                <p id="pero-r1s1-2"><?= $_ENUM2FA['state'][$project->state] ?></p>
                <? if ($project->state == 'Open') { ?>
                    <p id="pero-r1s1-3">آماده دریافت پیشنهاد</p>
                <? } ?>

            </div>
            <div class="pero-r1s2">
                <a id="pero-r1s2" href<?= '="project_' . $project->id . '"'; ?>>
                    <?= $project->title ?>
                </a>
                <br/>
            </div>
            <p style="font-size: 13px">
                تاریخ ارسال:
                <?php echo $persiandate->date('d F Y ساعت H:i', $project->submit_date) ?> 
            </p>
            <br/>
        </div>
        <div class="pero-r2">
            <table class="pero-table">
                <tr>
                    <td style="">
                        پیشنهادات: 
                        <?= $project->getBidsCount() ?>
                        پیشنهاد
                    </td>
                    <td style="">نوع ترجمه: 
                        <?= $_ENUM2FA['type'][$project->type] ?>
                    </td>
                    <td style="">زبان ترجمه: 
                        <? $l = explode("2", $project->lang); ?>
                        <?= $_ENUM2FA['lang'][$l[0]]; ?>
                        به
                        <?= $_ENUM2FA['lang'][$l[1]]; ?>
                    </td>
<!--                    <td style="color: black;">
                        <span class="help" style="color: white;">
                            سطح ترجمه:
                            <br/>                            
                            <span>
                                <?= $_ENUM2FA['level'][$project->level]; ?>
                            </span>
                        </span>
                    </td>-->
<!--                    <td style="color: black;">
                        <span class="help" style="color: white;">
                            موضوع:
                            <br/>                            
                            <span>
                                <?= $project->subject; ?>
                            </span>
                        </span>
                    </td>-->
<!--                    <td style="color: black;">
                        <? if ($project->type == 'Agency') { ?>
                            <span class="help" style="color: white;">
                                تعداد کلمات:
                                <br/>
                                <span>
                                    <?= $project->guess_page_num; ?>
                                </span>
                                کلمه
                            </span>
                        <? } else { ?>
                            <span class="help" style="color: white;">
                                تعداد صفحات:
                                <br/>
                                حدود
                                <span>
                                    <?= $project->guess_page_num; ?>
                                </span>
                                صفحه
                            </span>
                        <? } ?>
                        <div class="help_comment" style="color: black;" >
                            این تعداد به صورت تخمینی توسط کارفرما ثبت شده است
                        </div>
                    </td>-->
                    <? if (($user->isWorker() || $user->isAdmin()) && $project->type != 'Agency') { ?>
<!--                        <td style="color: black;display: none;">
                            <span class="help" style="color: white;">
                                تخمین سیستم:
                                <br/>
                                <span class="price">
                                    <? if ($project->type == 'Agency') { ?>
                                        <?= $project->guess_page_num * $_PRICES['worker'][($project->lang)]; ?>
                                    <? } else { ?>
                                        <?= number_format($project->guess_page_num * $_PRICES['user'][$project->lang] * 0.77); ?>
                                    <? } ?>
                                </span>
                                ریال
                            </span>
                            <div class="help_comment" style="color: black;" >
                                این قیمت براساس زبان و تعداد صفحاتی که کافرما وارد کرده محاسبه می شود
                            </div>
                        </td>-->
                    <? } ?>
                    <? if ($project->output != 'ONLINE') { ?>
<!--                        <td style="">
                            <?php
                            if ($project->type == 'Agency') {
                                echo 'قیمت هر کلمه';
                                echo '<br/>';
                                echo '<span class="price">';
                                echo $_PRICES['worker'][($project->lang)];
                                echo '</span>';
                                echo '</td>';
                                echo '<td style="">';
                                echo ' مبلغ ضمانت:';
                                echo '<br/>';
                                echo '<span class="price">';
                                echo number_format($project->max_price);
                                echo '</span>';
                            } else {
                                echo 'تخمین کارفرما:';
                                echo '<br/>';
                                echo '<span class="price">';
                                echo number_format($project->max_price);
                                echo '</span>';
                            }
                            ?> ریال 
                        </td>-->
                    <? } ?>
                </tr>
            </table>
        </div>
        <div class="pero-r3">
            <div class="pero-r3s1">
                <img src<?= '="' . $_CONFIGS['Site']['Path'] . 'user/avatar/UA_' . $project->user_id . '.png"'; ?> width="100" height="100" align="right" style="margin:10px;" alt=" "/>
                <div class="clear"></div>
                <br/>
                کارفرما:
                <br/>
                <center>
                    <b>
                        <a href<?= '="user_' . $s_user->id . '"' ?>>
                            <?= $s_user->getNickname() ?>
                        </a>
                    </b>
                </center>
                <br/><br/>
            </div>
            <div id="pero-r3s2" style="">
                <table class="pero-tabler3" style="direction:rtl;width: 70%" cellpadding="0">
                    <tr id="topCounter">
                        <td style="width:30px;"><img src="medias/images/theme/timeicon1.png"/></td>
                        <td style="">مهلت اجرای پروژه:</td>
                        <? if ($project->output == 'ONLINE') { ?>
                            <td style="font-size: 14px" class="pero-r3s2-time bg-gradian">تحویل فوری</td>
                            <td style="width: 3%"> </td>
                        <? } else if ($project->state == 'Run' && $project->expire_time < time()) { ?>
                            <td style="font-size: 14px;" class="pero-r3s2-time bg-gradian">
                                اتمام مهلت
                                <br/>
                                <?
                                echo $persiandate->displayDate($project->expire_time);
                                ?>
                            </td>
                            <td style="width: 3%"> </td>
                        <? } else { ?>
                            <td class="pero-r3s2-time s bg-gradian">0</td>
                            <td style="">ثانیه</td>
                            <td class="pero-r3s2-time i bg-gradian">0</td>
                            <td style="">دقیقه</td>
                            <td class="pero-r3s2-time h bg-gradian">0</td>
                            <td style="">ساعت</td>
                            <td class="pero-r3s2-time d bg-gradian">0</td>
                            <td style="">روز</td>
                        <? } ?>
                    </tr>
                </table>
            </div>
            <? if ($project->output != 'ONLINE') { ?>
                <?php echo $persiandate->timespan(($project->state == 'Run' ? ($project->expire_time - time()) : $project->expire_interval), ($project->state == 'Run' && $project->stakeholdered == 1), 'topCounter') ?>      
            <? } ?>

            <div class="pero-r4s2">
                <b>توضیحات</b><br/>
                <?php echo nl2br($project->description) ?>
                <br/>
                <? if ($project->demo) { ?>
                    <br/>
                    <b>نمونه کار:</b><br/>
                    متن زیر را به عنوان نمونه کار ترجمه کنید
                    <br/>
                    <?php echo nl2br($project->demo) ?>
                    <br/>
                <? } ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?
}

