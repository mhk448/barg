
function checkForm1(data){
    
    var msg=[];
    
    if(!data.title){
//        msg.push('یک عنوان مناسب برای ترجمه خود انتخاب نمایید');        
    }
    if(data.flan==data.tlan){
        msg.push('زبان مبدا و مقصد را مشخص نمایید');
    }
    if(!data.pagecount){
//        msg.push('تعداد صفحات ترجمه خود را مشخص کنید');
    }
    if((!data.files || data.files=='[]') && !data.links){
        msg.push('فایل های اسکن شده ی ترجمه خود را انتخاب کنید');
    }
    if(data.links && data.links.substr(0, 4) != "http" ){
        msg.push('لینک فایل را به درستی وارد نمایید(به همراه http)');
    }
    if(data.time_day==0 && data.time_hour==0){
        msg.push('تاریخ تحویل ترجمه خود را مشخص کنید');
    }
    if(!data.price){
//        msg.push(' مبلغ ضمانت  پروژه را مشخص کنید');
    }
    if(data.price<2000){
//        msg.push(' مبلغ ضمانت  پروژه را بیشتر کنید');
    }
    if(data.type=='Private'){
        if(!data.private_worker){
            msg.push('مترجم مورد نظر خود را انتخاب نمایید');
        }
    }
    if(!data.desc){
        msg.push('توضیح مختصری از مواردی که به نظرتان باید رعایت شود را بنویسید');
    }
    if(msg.length==0){
        return true
    }
    msgstr='<ol style="text-align: justify;margin:20px;">';
    for(i=0;i<msg.length;i++)
        msgstr+='<li>'+msg[i]+'</li>';
    msgstr+='</ol>';
    mhkform.info(msgstr);
    return false;
}

function showTypist(){
    mhkform.ajax('user-list_worker&ajax=1');
}

function changedLang(){
    if(agencyForm){
        var data={};
        data.flan=$("#flan").val().toString();
        data.tlan=$("#tlan").val().toString();
        data.lang=data.flan+'2'+data.tlan;
        if(data.lang=="FA2EN" || data.lang=="EN2FA"){
            $('#agency_type').show();
        }else{
            $('#agency_type').hide();
        }
    }
}
function changeMethod(){
    method=$('#type').val();
    switch(method){
        case 'Public':
            $('#specific').hide();
            $('.agency_m').hide();
            break;
        case 'Private':
            $('.agency_m').hide();
            $('#specific').show();
            break;
        case 'Agency':
            $('#specific').hide();
            $('.agency_m').show();
            break;
    }
}

function extractData(){
    var data={};
//    data.title=$("#title").val().toString();
    data.title="پروژه ی "+" "+ curUser.nickname;
    data.flan=$("#flan").val().toString();
    data.tlan=$("#tlan").val().toString();
    data.lang=data.flan+'2'+data.tlan;
    data.subject=$("#subject").val().toString();
//    data.pagecount=$("#pagecount").val().toString();
    data.pagecount=1;
    data.uploads=$("#files_hidden").val().toString();
    data.desc=$("#desc").val().toString();
    data.demo=$("#demo").val().toString();
    data.time_day=getInt($("#time_day").val().toString());
    data.time_hour=getInt($("#time_hour").val().toString());
    data.time_interval=(data.time_day * (24 * 60 * 60)) + (data.time_hour* (60 * 60));
    data.output=$("#output").val().toString();
    data.type=$("#type").val().toString();
    data.price=getInt($("#price").val().toString());
    data.private_worker=$("#worker").val().toString();
    data.level=$("#level").val().toString();
    data.links=$("#links").val().toString();
    data.content_count=getInt($("#content_count").val().toString());
    
    data.files=[];
    if(data.uploads){
        data.files=$.parseJSON(data.uploads);
    }
    if(data.links){
        data.files.push(data.links);
    }
    data.files=JSON.stringify(data.files);
    
    return data;
}

function getInt(val){
    val=parseInt(val);
    return val?val:0;
}
function createFactor(){
    var data= extractData();
    if(!checkForm1(data))
        return;
    
    sendForm();
    return;
    
    $("#form1").hide();
    $("#form3").show();
    
    sum=0;
    var langP=prices[data.lang];
    var langf=$("option[value='"+data.flan+"']").html();
    var langt=$("option[value='"+data.tlan+"']").html();
    var langT='ترجمه از '+langf+' به '+langt;
    $('#lang_type').html(langT);
    $('#lang_price').html(langP+' ریال');


    $('#page_price').html(data.pagecount);
              
   
    if(data.type=='Agency'){
        sum=langP*gpn;
    }else {
        sum=data.price;
    }
    
    $(".PrivateFactor").hide();
    $(".AgencyFactor").hide();
    $(".PublicFactor").hide();
    
    $("."+data.type+"Factor").show();
   
    sum=parseInt(sum);
    if(!sum){
        sum=0;
    }
    $('#sum_price').html(sum);
        
    ////////////////////////////////////////////////
    $('#project_name').html(data.title);
    /////////////////////////
    t=data.time_day+" روز و "+data.time_hour+" ساعت ";
    $('#expire_date').html(t);
  
    /////////////////////////////
    var lang_type=[];
    lang_type['Agency']='نمایندگی';
    lang_type['Private']='خصوصی';
    lang_type['Public']='مناقصه';
    
    $('#prj_type').html(lang_type[data.type]);
    $('#prj_out').html($("option[value='"+data.output+"']").html());
    
    if(data.type=='Private'){
        sm="خصوصی"+" "+$('#typistusername').val();
        $('#sel_worker').html(sm);
    }
    
    
}

function selectUser(id,username){
    $('#worker').val(id);
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
    sum=Math.round((gpn*langP)/100)*100;
    $('#helpMaxPrice').html(sum);
    return sum;
}

function sendForm(){
    mhkform.loading();
    $.post("/submit-project?ajax=1",{
        data: JSON.stringify(extractData()),
        submit:'s',
        formName: 'SubmitProjectForm'
    },
    function(data) {
        $('#ajax_content').html(data);
        mhkform.close();
    }
    );
    return false;  
}