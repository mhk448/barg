


<div  id="form3" style="display: none">

    <br/>
    <br/>
    <table width="60%"  class="projects">
        <tr>
            <th colspan="2" style="text-align: center;">
                صورت حساب مربوط به پروژه ی
                [<span id="project_name"></span>]
            </th>
        </tr>
        <tr>
            <td style="width: 50%" >زبان تایپ: </td>
            <td id="lang_type" style="">0</td>
        </tr>
        <tr class="page_tr noEarnestFactor">
            <td>قیمت هر صفحه</td>
            <td id="lang_price" style="">0</td>
        </tr>
        <tr class="noOnlineFactor">
            <td>تاریخ تحویل</td>
            <td id="expire_date" style="">0</td>
        </tr>
        <tr class="">
            <td>نوع پروژه</td>
            <td id="prj_type" style="">0</td>
        </tr>
        <tr class="noAgencyFactor">
            <td>روش انتخاب تایپیست</td>
            <td id="sel_method" style="">0</td>
        </tr>
        <tr id="page_box"  class="noEarnestFactor">
            <td id="page_type">تعداد صفحات</td>
            <td  style="font-weight: bold;">
                حدود
                <span id="page_price">1</span>
                صفحه
            </td>
        </tr>
        <tr class="page_tr noEarnestFactor">
            <td style="background-color: #ff88ff" class="help">
                جمع کل (تقربی)
            </td>
            <td style="background-color: #f8f;" class="help" >
                <span id="sum_price" style="font-weight: bold;"></span>
                <p style="float: left;font-size: 9pt">
                    ریال
                </p>
            </td>
            <td class="help_comment"> 
این مبلغ به صورت تقریبی است و پس از انجام پروژه بر اساس تعداد صفحات تایپ شده محاسبه خواهد شد
            </td>
        </tr>
        <tr class="noAgencyFactor noOnlineFactor">
            <td style="background-color: #ff88ff" > تخمین قیمت </td>
            <td style="background-color: #f8f;">
                <span id="max_price" style="font-weight: bold;"></span>
                <p style="float: left;font-size: 9pt">
                    ریال
                </p>
            </td>
        </tr>
        <tr  class="" style="display: none">
            <td onclick="addDiscount();" class="help" >تخفیف</td>
            <td onclick="addDiscount();" class="help" >
                <span id="discount_box" style="font-weight: bold;"></span>
                در صد
                <p style="float: left;font-size: 9pt;cursor: pointer;">
                    [                                افزودن کد تخفیف]
                </p>
            </td>

            <td class="help_comment"> 
                در صورت داشتن کد تخفیف در این قسمت وارد نمایید
            </td>
        </tr>
        <tr id="sum_price_discount_box"  class="noEarnestFactor">
            <td style="background-color: #ff88ff" >قیمت با تخفیف</td>
            <td style="background-color: #f8f;">
                <span id="sum_price_discount" style="font-weight: bold;"></span>
                <p style="float: left;font-size: 9pt">
                    ریال
                </p>
            </td>
        </tr>
        <tr  class="noEarnestFactor noAgencyFactor">
            <td onclick="addEarnest();" class="help">بیعانه</td>
            <td onclick="addEarnest();" class="help" >
                <span id="earnest_price" style="font-weight: bold;color: red"></span>
                <span id="minEarnest" style="display: none"></span>
                <p onclick="addEarnest();" style="float: left;font-size: 9pt">
                    [تغییر مبلغ بیعانه]
                </p>
            </td>
            <td class="help_comment"> 
                در این قسمت می توانید مبلغ بیعانه را تغییر دهید
            </td>
        </tr>
        <tr class="noEarnestFactor noAgencyFactor">
            <td class="help" style="" >مانده حساب</td>
            <td class="help" >
                <span id="sub_price" style="font-weight: bold;"></span>
                <p style="float: left;font-size: 9pt">
                    ریال
                </p>
            </td>
            <td class="help_comment"> 
                در هنگام تحویل پروژه 
                باید حساب خود را تصفیه کنید
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <ul>
        <li  class="noEarnestFactor noAgencyFactor">
            شما باید مبلغ 
            <b><span id="earnest_price2" style="color: red" ></span></b>
            ریال را به عنوان بیعانه پرداخت نمایید
        </li>
        <li class="noEarnestFactor noAgencyFactor">
            پس از به پایان رسیدن تایپ، مابقی حساب را پرداخت نمایید
        </li>
        <li>
            با کلیک بر روی دکمه ثبت نام،  تمام 
            <a href="rules" target="blank">
                شرایط و قوانین تایپایران
            </a>
            را می پذیرید.
        </li>
    </ul>
    <br/>

    <!--<label> </label>-->
    <input style="float: none;width: 20px;margin-left: 5px;padding: 3px 0px;" title="مرحله قبل" type="button" value="<" onclick="ChangeForm(2);">
    <input type="hidden" name="discount" <? echo ((isset($p['discount_code']) && $p['discount_code']) ? 'value="' . $p['discount_code'] . '"' : ''); ?> />
    <input type="hidden" name="earnest"  <? echo ((isset($p['earnest']) && $p['earnest']) ? 'value="' . $p['earnest'] . '"' : ''); ?>/>
    <input type="hidden" name="submit" value="1" />
    <input style="float: none;" type="button" value=" ثبت پروژه  "  onclick="sendForm()"/>
</div> 
