/* 
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Apr 26, 2013 , 12:14:39 PM
 * mhkInfo:
 */


function MHKZoomIn(){
    h=document.getElementById("scanedtext").style.width;
    h=parseInt(h)+10;
    //            alert(h);
    document.getElementById("scanedtext").style.width=(h)+"%";
}
function MHKZoomOut(){
    h=document.getElementById("scanedtext").style.width;
    h=parseInt(h)-10;
    document.getElementById("scanedtext").style.width=(h)+"%";
}

function ChangePic(ver){
    c_img_id=parseInt(c_img_id)+ parseInt(ver);
    $('#scanedtext').attr("imgid",c_img_id);
    src0=$("#scanedtext").attr("src0");
    $("#scanedtext").attr("src",src0+"/img_"+c_img_id+".png");

}

teta=0;
function Rotate(){
    tetaold="teta"+teta;
    teta=(teta+90)%360;
    tetanew="teta"+teta;
    t=document.getElementById("scanedtext").getAttribute('class');
    t=t.replace(tetaold,tetanew,'m');
    document.getElementById("scanedtext").setAttribute('class', t);
}
opa=1;
function AddOpacity(){
    opa=(opa>=1)?(1):(opa+0.1);
    document.getElementById("scanedtext").style.opacity=opa;
}
function SubOpacity(){
    opa=(opa<=0)?(0):(opa-0.1);
    document.getElementById("scanedtext").style.opacity=opa;
}
lineTop=100;
function MoveLine(newTop){
    lineTop=newTop;
    document.getElementById("line").style.top=lineTop+"px";
}
function HideLine(){
    MoveLine(100);
    LineHide=document.getElementById("line").style.visibility;
    LineHide=(LineHide!='visible')?'visible':'hidden';
    document.getElementById("line").style.visibility=LineHide;
}
function CountWord(){
    try{
        text=CKEDITOR.instances.maintypetext.getData();
        var mydiv = document.createElement("div");
        mydiv.innerHTML = text;
        if (document.all) // IE Stuff
            text2= mydiv.innerText;
        else // Mozilla does not work with innerText
            text2= mydiv.textContent;
    }catch(ex){
        text2=$('#maintext').text();
    }

    text2=text2.replace(/\n/g, ' ');
    text2=text2.replace(/\t/g, ' ');
    text2=text2.replace(/\r/g, ' ');
    text2=text2.replace('-', ' ');
    text2=text2.replace('.', ' ');
    text2=text2.replace('?', ' ');
    text2=text2.replace('!', ' ');
    text2=text2.replace('؟', ' ');
    text2=text2.replace('!', ' ');
    text2=text2.replace('  ', ' ');
    text2=text2.replace('  ', ' ');
    //    alert(text2);
    var c=0;
    var ar=text2.split(' ');
    var l=ar.length;
    for(i=0;i<l;i++){
        //ar[i]=trim(ar[i]);
        if(ar[i].length>1){
            //alert(ar[i]+(ar[i].length));
            c++;
        }
    }
    
    document.getElementById("word_counter").innerHTML=c;

}
/////////////////////////////////////////////////////
cke_skin='office2003';
function ChangeStyle(){
    cke_skin=(cke_skin=="office2003")?'v2':(cke_skin=="v2"?"kama":"office2003");
    CKEDITOR.replace( 'MHK448Message',
    {
        skin : cke_skin
    });
}
/////////////////////////////////////////////////////
c_maintext="";
c_chat="";
c_img_id=0;
c_finished=0;
load_time =5*1000;
save_time =5*1000;
cur_time=0;
min_time=5*1000;

function StartSave(){
    
    //    cur_time=cur_time+1000;
    //    if(cur_time<save_time)
    //        return;
    //    else
    //        cur_time=0;
    
    change=false;
    s_maintext='';
    s_chat=c_chat;
    s_img_id=0;
    s_finished=c_finished;
    try{
        s_maintext=CKEDITOR.instances.maintypetext.getData();
        s_img_id=$("#scanedtext").attr("imgid");
    }catch(e){
        setTimeout(function(){
            StartSave();
        },save_time);
        return;
    }
    
    
    if(c_maintext!=s_maintext ||
        c_chat!=s_chat ||
        c_img_id!=s_img_id ||
        c_finished!=s_finished){
        change = true ;
    }

    if(change){
        //    alert("Data: "  + "\nStatus: " );
        $.post("?save=1",
        {
            text:s_maintext,
            img_id:s_img_id,
            chat:s_chat,
            finished:s_finished
        },
        function(data,status){
            if(status=="success"){
                fillContent(data);
            }
        }, "json")
        .error(function() {
            connectionError("ارتباط شما با اینترنت قطع شده است<br> لطفا اتصالات اینترنت را بررسی نمایید.<br>از ادامه ی تایپ بپرهیزید<br>");
        })
        .complete(function() {
            setTimeout(function(){
                StartSave();
            },save_time);
        })
    ;
    }else{
        setTimeout(function(){
            StartSave();
        },save_time);
    }
}

function StartLoad(){
    
    //    cur_time=cur_time+1000;
    //    if(cur_time<load_time)
    //        return;
    //    else
    //        cur_time=0;
    
    s_chat="h";

    $.post("?load=1",
    {
        chat:s_chat
    },
    function(data,status){
        if(status=="success"){
            fillContent(data);
        }
    }, "json")
    .error(function() {
        connectionError("ارتباط شما با اینترنت قطع شده است<br> لطفا اتصالات اینترنت را بررسی نمایید.");
    })
    .complete(function() {
        setTimeout(function(){
            StartLoad();
        },load_time);
    });
        
}

function SendChat(){
    
    s_chat=$("#msg").val();
    $("#msg").val("");
    
    $.post("?chat=1",
    {
        msg:s_chat
    },
    function(data,status){
        if(status=="success"){
            fillChat(data);
        }
    }, "json")
    .error(function() {
        connectionError("ارتباط شما با اینترنت قطع شده است<br> لطفا اتصالات اینترنت را بررسی نمایید.");
    });
}


function StartChat(){
    //    cur_time=cur_time+1000;
    //    if(cur_time<load_time)
    //        return;
    //    else
    //        cur_time=0;
    
    //    s_chat=$("#msg").val();
    //    $("#msg").val("");
    
    $.post("?chat=1",
    {
        chat:''
    },
    function(data,status){
        if(status=="success"){
            fillChat(data);
        }
    }, "json")
    .error(function() {
        connectionError("ارتباط شما با اینترنت قطع شده است<br> لطفا اتصالات اینترنت را بررسی نمایید.");
    })
    .complete(function() {
        setTimeout(function(){
            StartChat();
        },load_time);
    });
}
/////////////////////////////////
showFinishMsg=false;
function fillContent(input){
    var result=(input);
    CountWord();
    //    var result=$.parseJSON(input);
    if(result['text']!=undefined){
        maintext=result['text'];
        if( c_maintext!=maintext){
            $("#maintext").html(maintext);
            c_maintext=maintext;
        }
    }
    if(result['chat']!=undefined){
        chat=result['chat']; 
        if(c_chat!=chat){
            //            StartChat(chat);
            c_chat=chat;
        }
    }
    if(result['img_id']!=undefined){
        img_id=result['img_id'];
        if(c_img_id!=img_id){
            c_img_id=img_id;
            ChangePic(0);
        }
    }
    if(result['finished']!=undefined){
        var finished=result['finished'];
        if(showFinishMsg && finished){
//        if(finshed && user_id==cur_id && !showFinishMsg){
            $("#finish").show();
            var msg='پروژه ی شما به پایان رسید'
                +'<br/><br/><input type="button" onclick="mhkform.ajax(\'finish-project_'+project_id+'?ajax=1\');" value="'
            +'تایید و دریافت فایل'
            +'"/>';
            mhkform.open(msg);
            showFinishMsg=false;
        }
    }
    if(result['last_edit']!=undefined){
        len=result['last_edit']-result['server_time'];
        if(len<(30*60)){
            load_time=2000;
        }else{
            load_time=30*(60*1000);
        }
    }
    if(result['last_visit']!=undefined){
        len=result['last_visit']-result['server_time'];
        if(len<(30*60)){
            save_time=2000;
        }else{
            save_time=1*(60*1000);
        }
    }
}
cur_id=-1;
user_id=-2;
worker_id=-3;
function fillChat(result){
    if(result!=undefined){
        $('#content').html("");
        $.each(result, function(index,obj) {
            user_id0=obj.id;
            msg0=obj.msg;
            if(user_id0==cur_id){
                type="user";
                name='من';
            }else if(user_id0[0]=='A'){
                type="admin";
                name='مدیر';
            }else{
                type="typist";
                if(user_id0==worker_id)
                    name='تایپیست';
                else
                    name='کارفرما';
            }
            sender='<span>'+name+': </span>';
            $('#content').append( $('<p  class="'+type+'" >', {}).append(sender).append(msg0) );
        });
    }
}

function connectionError(msg){
    if(!mhkform.isOpen())
        mhkform.confirm(msg,"load_time=min_time;save_time=min_time;","سعی مجدد");
    save_time=15*60*1000;
    load_time=15*60*1000;
}
$(window).keydown(function(event){
    switch(event.keyCode){
        case 40:
            MoveLine(lineTop+5);
            break;
        case 38:
            MoveLine(lineTop-5);
            break;
    }
});
           
       