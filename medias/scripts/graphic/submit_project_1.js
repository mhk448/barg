
var curForm=1;




function ChangeForm(formNum){
    if(formNum>curForm)
        if(!checkForm1()||!checkForm2()|| !checkForm3())
            return;
            
            
    $('#form1').hide();
    $('#form2').hide();
    $('#form3').hide();
    //        $('#form4').hide();
    $('#form'+formNum).slideDown();
    $('#aForm1').css({
        'border':'none',
        'opacity':'0.5'
    });
    $('#aForm2').css({
        'border':'none',
        'opacity':'0.5'
    });
    $('#aForm3').css({
        'border':'none',
        'opacity':'0.5'
    });
    //        $('#aForm4').css({'border':'none','opacity':'0.5'});
    $('#aForm'+formNum).css({
        //            'border':'solid 2px',
        'opacity':'1'
    });
        
    oldForm=curForm;
    curForm=formNum;
    if(formNum==2){
        if($("[name='out']").val()=='ONLINE'){
            fillForm2TypeOnline();
            ChangeForm(4-oldForm);
        }
        helpMaxPrice();
        getFileNameAnduploadFile();
    }else if(formNum==3){
        createFactor();
    }
}
function checkForm1(){
    
    
    //    file=$("#fl");
    //    $.post("submit-project", {
    //        enctype : "multipart/form-data",
    //        file : file
    //    }, function(data){
    //        alert(data.name); 
    //    }, "json");
    
    $("#sform").submit();
    
    switch($("[name='lan']").val()){
        case 'FA':
        case 'EN':
        case 'AR':
        case 'FA+EN':
        case 'FA+AR':
            //                $("[value='ONLINE']").show();
            //                $("[name='out']").attr("disabled",null);
            $(".out").show();
            break;
        default:
            //                $("[value='ONLINE']").hide();
            //                $("[name='out']").attr("disabled","disabled");
            $(".out").hide();
            break
    }
    
    
    if(curForm!=1){
        return true
    }
    msg='';
    if(!$("[name='t']").val().toString()){
        msg+='<li>';
        msg+='یک عنوان مناسب برای تایپ خود انتخاب نمایید<br/>';
        msg+='</li>';
        $("[name='t']").focus();
    }
    var gpn=parseInt($("[name='gpn']").val());
    if(!gpn){
        msg+='<li>';
        msg+='تعداد صفحات تایپ خود را مشخص کنید<br/>';
        msg+='</li>';
    //        $("[name='gpn']").focus();
    }
    if(!$("#fn").val().toString() && !$("#fl").val().toString()){
        msg+='<li>';
        msg+='فایل های اسکن شده ی تایپ خود را انتخاب کنید<br/>';
        msg+='</li>';
    //        $("#fl").focus();
    }
    if(!$("[name='desc']").val().toString()){
        msg+='<li>';
        msg+='توضیح مختصری از مواردی که به نظرتان باید رعایت شود را بنویسید';
        msg+='</li>';
        $("[name='desc']").focus();
    }
    if(msg==''){
        return true
    }
    msg='<ol style="text-align: justify;margin:20px;">'+msg+'</ol>';
    mhkform.info(msg);
    return false;
}
function checkForm2(){
    if(curForm!=2){
        return true
    }
    
    msg='';
    if(!$("[name='di1']").val().toString() || !$("[name='di2']").val().toString()){
        msg+='<li>';
        msg+='تاریخ تحویل تایپ خود را مشخص کنید';
        msg+='</li>';
    }
    if($('#method').val()=='Public'){
        if(!parseInt($("[name='mp']").val())){
            msg+='<li>';
            msg+=' قیمت تخمینی پروژه را مشخص کنید';
            msg+='</li>';
        }
        if($("[name='selectkarfarma']:checked").val()==null){
            msg+='<li>';
            msg+='روش انتخاب تایپست را مشخص کنید';
            msg+='</li>';
        }else{ 
            if($("[name='selectkarfarma']:checked").val()=='mr'){
                if(!$("[name='mr']").val().toString()){
                    msg+='<li>';
                    msg+='حداقل رتبه ی تایپیست را مشخص کنید';
                    msg+='</li>';
                }
            }
        }
    }else  if($('#method').val()=='Private'){
        if(!parseInt($("[name='mp']").val())){
            msg+='<li>';
            msg+=' قیمت تخمینی پروژه را مشخص کنید';
            msg+='</li>';
        }
        if(!$("[name='private_typist_id']").val().toString()){
            msg+='<li>';
            msg+='تایپیست مورد نظر خود را انتخاب نمایید';
            msg+='</li>';
        }
    }else  if($('#method').val()=='Referer'){
        if(!parseInt($("[name='mp']").val())){
            msg+='<li>';
            msg+=' قیمت تخمینی پروژه را مشخص کنید';
            msg+='</li>';
        }
        if(!$("[name='private_typist_id']").val().toString()){
            msg+='<li>';
            msg+='تایپیست مورد نظر خود را انتخاب نمایید';
            msg+='</li>';
        }
    }
    if(msg==''){
        return true
    }
    msg='<ol style="text-align: justify;margin:20px;">'+msg+'</ol>';
    mhkform.info(msg);
    return false;
}
    
function checkForm3(){
    if(curForm!=3){
        return true
    }
    msg='';
    
        
    if(msg==''){
        return true
    }
    msg='<ol style="text-align: justify;">'+msg+'</ol>';
    mhkform.info(msg);
    return false;
}
    
    
function showTypist(){
    mhkform.ajax('user-list_worker&ajax=1');
}
function fillForm2TypeOnline(){
    $("[name='di1']").val(3);
    $("[name='di2']").val(0);
    $("[name='mp']").val(helpMaxPrice());
}
function changeTypeOnline(){
    var out=$("[name='out']").val();
    if(out=='ONLINE'){
        $("#lang_select option").hide();
        $("textarea[name='desc']").html("این تایپ را به صورت آنلاین انجام دهید");
        $("#desc-div").hide();
        $("#out-div").hide();
        
        $("option[value='FA']").show();
        $("option[value='AR']").show();
        $("option[value='EN']").show();
        $("option[value='FA+EN']").show();
        $("option[value='FA+AR']").show();
    }
}
function changeMethod(){
    method=$('#method').val();
    switch(method){
        case 'Public':
            $('#monaghese').show();
            $('#specific').hide();
            $('#monaghese_specific').show();
            break;
        case 'Protected':
            $('#monaghese').hide();
            $('#specific').hide();
            $('#monaghese_specific').hide();
            break;
        case 'Private':
            $('#monaghese').hide();
            $('#specific').show();
            $('#monaghese_specific').show();
            break;
        case 'Referer':
            $('#monaghese').hide();
            $('#specific').hide();
            $('#monaghese_specific').show();
            break;
        case 'Agency':
            $('#monaghese').hide();
            $('#specific').hide();
            $('#monaghese_specific').hide();
            break;
    }
}
   
function createFactor(){
    sum=0;
    langS=$("[name='lan']").val();
    langP=prices[langS];
    langT=$("option[value='"+langS+"']").html();
            
    $('#lang_type').html(langT);
    $('#lang_price').html(langP+' ریال');
        
    var gpn=$("[name='gpn']").val();
    if(!gpn){
        gpn=0;
    }
    gpn=parseInt(gpn);
    $('#page_price').html(gpn);
        
    //    if($("[name='out']").val()=='ONLINE'){
    //        $(".noOnlineFactor").hide();
    //    }else{
    //        $(".noOnlineFactor").show();
    //    }        
    $(".page_tr").show();
    $(".noAgencyFactor").show();
    $(".noEarnestFactor").show();
    if($('#method').val()=='Agency'){
        sum=langP*gpn;
        $(".noAgencyFactor").hide();
    }else {
        sum=$("[name='mp']").val();
        if($('#method').val()=='Public' 
            && $("[name='selectkarfarma']:checked").val()=='li'){
            $(".noEarnestFactor").hide();
        }else if($('#method').val()=='Private'){
            $(".noEarnestFactor").hide();
        }else if($('#method').val()=='Referer'){
            $(".noEarnestFactor").hide();
        }else{
            $(".page_tr").hide();
        }
    }
    if($("[name='out']").val()=='ONLINE')
        $(".noOnlineFactor").hide();
    
    sum=parseInt(sum);
    if(!sum){
        sum=0;
    }
    /////////////////////////////////////////////////
    discount_code=$("[name='discount']").val();
    var discount_p=0;
    var discount_e=0;
    if(discount_code){
        discount_method=discount_code[0];
        if(discount_method=='p'||discount_method=='P'){
            discount_value=discount_code[1]+discount_code[2];
            discount_p= parseInt(discount_value);
            $('#discount_box').html(discount_p);
            discount_p/=100;
            $('#sum_price_discount_box').show();
        }
    }
        
    if(!discount_p){
        discount_p=0;
        $('#discount_box').html(0);
        $('#sum_price_discount_box').hide();
    }
        
    ////////////////////////////////////////////////
    project_name=$("[name='t']").val();
    $('#project_name').html(project_name);
            
    /////////////////////////////////////////////////
    //earnest=$('#earnest_select').val();
    $('#sum_price').html(sum);
    $('#max_price').html(sum);
        
    sum=sum*(1-discount_p)-discount_e;
    sum=Math.round(sum/100)*100;
    if($('#method').val()=='Agency'){
        earnest=0;
    }else{
        earnest=sum*percent;
        earnest=Math.round(earnest/100)*100;
        $('#minEarnest').html(earnest);
        
        earnest2=$("[name='earnest']").val();
        earnest2=parseInt(earnest2);
        if(earnest2 && earnest2!=0){
            if(earnest2>=earnest){
                earnest=earnest2;
            }else{
                var msg='شما باید حداقل '
                msg+='<b>';
                msg+=earnest;
                msg+='</b>';
                msg+=' ریال پرداخت نمایید.';
                mhkform.info(msg);
            }
        }
    }
    $('[name="earnest"]').val(earnest);
    $('#sum_price_discount').html(sum);
        
    $('#earnest_price').html(earnest);
    $('#earnest_price2').html(earnest);
    sub=sum - earnest;
    $('#sub_price').html(sub);
    //$('#sum_price_t').html(sum/10);
    /////////////////////////
    
    //    t=$("[value='"+($("[name='d2']").val())+"']").html();
    //    $('#expire_date').html($("[name='d1']").val()+" ساعت "+t);
    if($("[name='out']").val()=='ONLINE'){
        $('#expire_date').html('فوری');
    }else{
        t=$("[name='di1']").val()+" روز و "+$("[name='di2']").val()+" ساعت ";
        $('#expire_date').html(t);
    }
    /////////////////////////
    var out=$("[name='out']").val();
    if(out=='DOCX')
        out='فایل ورد';
    else if(out=='PPTX')
        out='فایل پاورپوینت';
    else if(out=='XLSX')
        out='فایل اکسل';
    else if(out=='ONLINE')
        out='تایپ آنلاین';
    $('#prj_type').html(out);
    /////////////////////////////
    var sm= "نمایندگی";
    if($('#method').val()=='Public'){
        sm= $("[name='selectkarfarma']:checked").next(".label").text();
        if($("[name='selectkarfarma']:checked").val()=="mr")
            sm+=$("[name='mr']").val();
    } else if($('#method').val()=='Private'){
        sm="خصوصی"+" "+$('#typistusername').val();
    } else if($('#method').val()=='Referer'){
        sm="پیشنهادی از جانب تایپایران";
    //        $('#sel_method').hide()
    }
    $('#sel_method').html(sm);
    
    
}
    
function addDiscount(){
    var msg='<p class="form">';
    msg+='کد تخفیف را وارد نمایید:';
    msg+='<br/><input id="discount" class="numberfild" style="float: none;"></p>';
    var action="$('[name=\\\'discount\\\']').val($('#discount').val());";
    action+="$('[name=\\\'earnest\\\']').val('0');";
    action+="mhkform.close();";
    action+="createFactor();";
    mhkform.confirm(msg, action, "تایید", "لغو");
}
function addEarnest(){
    var min=$('#minEarnest').html();
    min=parseInt(min);
        
    var msg='<p class="form">';
    msg+='شما می توانید مبلغ ';
    msg+='<b>';
    msg+=min;
    msg+='</b>';
    msg+=' و یا بیشتر را به عنوان بیعانه پرداخت نمایید';
    msg+='<br><br>';
    msg+='مبلغ بیعانه ای را که مایلید پرداخت کنید:';
    msg+='<br/><input id="newEarnest" class="numberfild" style="float: none;"></p>';
    var action="$('[name=\\\'earnest\\\']').val($('#newEarnest').val());";
    action+="mhkform.forceClose();";
    action+="createFactor();";
    mhkform.confirm(msg, action, "تایید", "لغو");
    initInputNumber();
}
    
function selectUser(id,username){
    $('[name="private_typist_id"]').val(id);
    //        username='<span class="username">'+username+"</span>";
    $('#typistusername').val("ارجاع به: "+username);
    mhkform.close();
}
    
function helpMaxPrice(){
    langS=$("[name='lan']").val();
    langP=prices[langS];
    var gpn=$("[name='gpn']").val();
    if(!gpn){
        gpn=0;
    }
    gpn=parseInt(gpn);
    sum=Math.round((gpn*langP*0.9)/100)*100;
    $('#helpMaxPrice').html(sum);
    return sum;
}
    
//function uploadFile(){
//    //nc?
//    $.post("upl", {
//        func: "getNameAndTime"
//    },
//    function(data){
//        alert(data.name); 
//        console.log(data.time); 
//    }, "json");
//}
filename='';
fileserver="http://file.bargardoon.xzn.ir";
function getFileNameAnduploadFile(){
    $.getJSON(fileserver,
    {
        getname: 1,
        filename: filename
    },
    function(data) {
        filename=data.filename;
        uploadFile();
    }
    );
}
uploading=false;
function uploadFile(){
    if(uploading)
        return;
    
    if(!$("#fl").val().toString())
        return;
    
    uploading=true;
    
    var p=fileserver+'';
    p+='?upload=1';
    p+='&filename='+filename;
    p+='&filepath=project';
    p+='&subsite=type';
    //    $('#fl').upload('/submit-project?ajax=1&upload=1', function(res) {
    $('#fl').upload(p, function(res) {
        //        alert(res.filename);
        $("#fn").val(res.fileurl);
        $('#message').html(res.msg);
        $('#message').show();
        $("#fl").val("");
        if(res.uploaded==1){
            setTimeout(function(){
                $('#message').hide(); 
            }, 2000);
        }
    //        uploading=false;
    }, 'json');
    //    $('#fl').hide();
    $('#message').html('<img src="medias/images/icons/loader.gif" />'+'در حال ارسال فایل...'+'<br/>'+'');
    $('#message').show();
    
//    setInterval(function(){
//        filename0=$("#fn").val();
//        $.post('/submit-project?ajax=1&upload=1&loading=1', {
//            filename:filename0
//        }, function(data){
//            if(data.uploaded==0){
//                
//            }
//            $('#hhh').html(data);
//        }, "json");
//    }, 5000);
}

function checkFile(){
    $("#fn").val("");
    fileName=$("#fl").val().toLowerCase();
    var ext = fileName.split('.').pop();
    var Valid = "zip,rar,xls,xlsx,ppt,pptx,doc,docx,pdf,png,jpg,gif,jpeg".split(',');
    if(Valid.indexOf(ext)==-1){
        mhkform.info("فرمت فایل انتخاب شده معتبر نیست!");
        $("#fl").val("");
        $('#fsn').html("انتخاب فایل");
    }else{
        $('#fsn').html(fileName);
    }
}

function sendForm(){
    if(!$("#fn").val().toString()){
        if(!mhkform.isOpen()){
            mhkform.loading("در حال ارسال فایل");
        }
        setTimeout("sendForm()",2000);
        return false;
    }
    var pid=$("[name='pid']").val();
    pids=pid ? ('_'+pid) : '';
    mhkform.loading();
    form = $("#sform").serialize();
    $.ajax({ 
        type: "POST",
        url: "/submit-project"+pids+"?ajax=1",
        data: form,
        success: function(data) {
            $('#ajax_content').html(data);
            mhkform.close();
        }, 
        error: function (xhr, ajaxOptions, thrownError) {
            if(mhkform.isOpen())
                mhkform.confirm('در اتصال به اینترنت مشکل به وجود آمده است!', action, 'سعی مجدد', ' لغو ');
        }
            
    });
    return false;  
}