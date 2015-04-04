<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Oct 18, 2013 , 9:07:57 PM
 * mhkInfo:
 */
if (!$_CONFIGS['TestMode']) {
    ?>



    <div style="font-size: 16px ;text-align: center;padding: 10px;" id="i6">
        <form action="panel" method="POST">
            <input type="hidden" name="qid" value="5">
            <input type="hidden" name="formName" value="userlevel">
            <h1>
                <img src="medias/images/icons/poll.png" alt="" height="32" width="32" align="absmiddle"  />
                تغییرات سیستم
            </h1>
            <hr style="width: 100%"/>
            تایپیست های عزیز
            <hr style="width: 100%"/>
            <div id="f1">
                از این پس در قسمت ارسال پیشنهاد برای انجام پروژه، مبلغ مورد نظر خود را به ازای
                <span style="color: red">
                    هر صفحه
                </span>
                وارد نمایید

                <br/>

            </div>
        </form>
    </div>



    <div style="font-size: 16px ;text-align: center;padding: 10px;" id="i6">
        <form action="panel" method="POST">
            <input type="hidden" name="qid" value="5">
            <input type="hidden" name="formName" value="userlevel">
            <h1>
                <img src="medias/images/icons/poll.png" alt="" height="32" width="32" align="absmiddle"  />
                افتتاح شد
            </h1>
            <hr style="width: 100%"/>
            سامانه ی «تایپ توئیت» افتتاح شد
            <hr style="width: 100%"/>
            <div id="f1">
                از امروز می توانید اطلاعات و نظرات خود را در مورد امور تایپ، سایت تایپایران و... با دیگران به اشتراک بگذارید.
                <br/><br/><hr style="width: 100%"/>
                <a class="active_btn" href="/twitt">
                    ورود به «تایپ توئیت»
                </a>
            </div>
        </form>
    </div>













    <div style="font-size: 14px ;padding: 10px;" id="i7">
        <form action="panel" method="POST" class="form">
            <input type="hidden" name="qid" value="10">
            <input type="hidden" name="formName" value="userlevel">
            <div id="f1" style="display: none;">

                <h1>
                    کاربر ویژه(
                    همکاری در بخش طراحی سایت تایپایران
                    )
                </h1>
                <br/>
                از کلیه کاربران سایت که توانایی همکاری در بخش طراحی گرافیکی و
                یا برنامه نویسی (HTML,CSS,jQuery) سایت دارند دعوت به همکاری میشود.        

                <br/>
                <a class="active_btn" onclick="$('#f1').slideUp();$('#f2').slideDown();">
                    بعدی
                </a>
            </div>

            <div id="f2" style="display: none;">

                <label>
                    سابقه و رزومه خود را وارد نمایید
                </label>
                <textarea rows="2" name="a3" ></textarea>

                <label>
                    مدت زمانی که می توانید روزانه به این کار اختصاص دهید:

                </label>
                <textarea rows="2" name="a4" ></textarea>
                <label>
                    زمینه های همکاری:
                </label>
                <textarea rows="2" name="a5" ></textarea>
                <div class="clear"></div>
                <label></label>
                <input type="submit" name="" value="تایید و ارسال">
                </form>
            </div>
    </div>















    <div class="clear"></div>
    <hr/>


    <div style="font-size: 16px ;text-align: center;padding: 10px;" id="i6">
        <form action="panel" method="POST">
            <input type="hidden" name="qid" value="5">
            <input type="hidden" name="formName" value="userlevel">
            <h1>
                <img src="medias/images/icons/poll.png" alt="" height="32" width="32" align="absmiddle"  />
                آیا میدانید؟
            </h1>
            <hr style="width: 100%"/>
            چگونه می توانید پروژه های بیشتری جذب کنید؟ 
            <hr style="width: 100%"/>
            <div id="f1">
                1.
                نام مستعار مناسبی برای خود انتخاب کنید
                <br/>
                <small>
                    از قسمت "تنظیمات" به بخش ویرایش اطلاعات مراجعه کنید و یک نام مستعار مناسب انتخاب کنید
                </small>
                <br/><br/><hr style="width: 100%"/>
                <a class="active_btn" onclick="$('#i6 #f1').slideUp();$('#i6 #f2').slideDown();">
                    بعدی
                </a>
            </div>
            <div id="f2" style="display: none;">
                2.
                تصویر مناسبی برای حساب کاربری خود انتخاب کنید
                <br/>
                <small>
                    کارفرمایان به تابپیستهایی که دارای مشخصات کامل تری هستند اعتماد بیشتری می کنند
                </small>
                <br/>
                <br/><hr style="width: 100%"/>
                <a class="active_btn" onclick="$('#i6 #f2').slideUp();$('#i6 #f1').slideDown();">
                    قبلی 
                </a> 

                <a class="active_btn" onclick="$('#i6 #f2').slideUp();$('#i6 #f3').slideDown();">
                    بعدی
                </a>
            </div>
            <div id="f3" style="display: none;">
                3.
                در هنگام ارسال پیشنهاد به مبلغ تخمینی پروژه دقت کنید
                <br/>
                <small>
                    فایل پروژه را حتما بررسی نمایید و قیمتی منصفانه پیشنهاد دهید 
                    شما می توانید قیمتی بالاتر و یا پایین تر از هزینه ی تخمینی کارفرما
                    پیشنهاد دهید
                </small>

                <br/>
                <br/><hr style="width: 100%"/>
                <a class="active_btn" onclick="$('#i6 #f3').slideUp();$('#i6 #f2').slideDown();">
                    قبلی 
                </a> 

                <a class="active_btn" onclick="$('#i6 #f3').slideUp();$('#i6 #f4').slideDown();">
                    بعدی
                </a>
            </div>
            <div id="f4" style="display: none;">
                4.
                پیشنهاد خود را با دقت وارد نمایید
                <br/>
                <small>
                    در کادر مخصوص پیشنهاد قیمت پروژه، مبلغ مورد نظر را وارد نمایید
                    دقت نمایید مبلغ وارد شده به ازای کل پروژه در نظر گرفته   
                    خواهد شد.
                    از وارد کردن قیمت در قسمت توضیحات بپرهیزید
                    در صورت وارد کردن قیمت در قسمت توضیحات از امتیاز شما کسر
                    خواهد شد و مبلغ پروژه به حساب شما واریز نمی شود
                </small>
                <br/>
                <br/><hr style="width: 100%"/>
                <a class="active_btn" onclick="$('#i6 #f4').slideUp();$('#i6 #f3').slideDown();">
                    قبلی 
                </a> 

                <a class="active_btn" onclick="$.ajax({url:'panel?qid=6&formName=userlevel&a0=1'});$('#i6 #f4').slideUp();$('#i6 #f5').slideDown();">
                    بعدی
                </a>
            </div>
            <div id="f5" style="display: none;">
                این راهنمایی چطور بود؟
                <br/>
                <br/>
                <br/><hr style="width: 100%"/>
                <a class="active_btn" onclick="$.ajax({url:'panel?qid=6&formName=userlevel&a1=dontUsed'});$('#i6').slideUp();">
                    مفید نبود 
                </a> 
                <a class="active_btn" onclick="$.ajax({url:'panel?qid=6&formName=userlevel&a1=useful'});$('#i6').slideUp();">
                    مفید بود
                </a>
            </div>
        </form>
    </div>
    <br/>
    <br/>











    <?
}?>