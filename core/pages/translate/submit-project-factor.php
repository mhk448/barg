


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
            <td style="width: 50%" >زبان ترجمه: </td>
            <td id="lang_type" style="">0</td>
        </tr>
        <tr class="AgencyFactor">
            <td>قیمت هر صفحه</td>
            <td id="lang_price" style="">0</td>
        </tr>
        <tr class="">
            <td>زمان تحویل</td>
            <td id="expire_date" style="">0</td>
        </tr>
        <tr class="">
            <td> روش انجام پروژه</td>
            <td id="prj_type" style="">0</td>
        </tr>
        <tr class="">
            <td>نوع پروژه</td>
            <td id="prj_out" style="">0</td>
        </tr>
        <tr class="PrivateFactor">
            <td>مترجم</td>
            <td id="sel_worker" style="">0</td>
        </tr>
        <tr id="page_box"  class="">
            <td id="page_type">تعداد صفحات</td>
            <td  style="font-weight: bold;">
                حدود
                <span id="page_price">1</span>
                صفحه
            </td>
        </tr>
        <tr class="">
            <td style="background-color: #ff88ff" >  مبلغ ضمانت </td>
            <td style="background-color: #f8f;" class="help" >
                <span id="sum_price" style="font-weight: bold;"></span>
                <p style="float: left;font-size: 9pt">
                    ریال
                </p>
            </td>
            <td class="help_comment"> 
این مبلغ به صورت تقریبی است و پس از انجام پروژه بر اساس تعداد صفحات ترجمه شده محاسبه خواهد شد
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <ul>
        <li>
            قمیت نمایش داده شده تخمینی است و پس از اتمام کار مبلغ پروژه مشخص خواهد شد
        </li>
        <li>
            با کلیک بر روی دکمه ثبت نام،  تمام 
            <a href="rules" target="blank">
                شرایط و قوانین این مرکز
            </a>
            را می پذیرید.
        </li>
    </ul>
    <br/>

    <label></label>
    <input style="" type="button" value="  ویرایش  "  onclick="$('#form1').show();$('#form3').hide();"/>
    <input style="margin-right: 10px;" type="button" value=" ثبت پروژه  "  onclick="sendForm()"/>
</div> 
