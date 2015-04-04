/* 
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Dec 6, 2013 , 9:55:47 PM
 * mhkInfo:
 */
mhktwitt ={
    twittResponse:{},
    start:function(ref_page,ref_id,maxBox){
        mhktwitt.ref_page = ref_page;
        mhktwitt.ref_id = ref_id;
        mhktwitt.maxBox = maxBox;
        mhktwitt.refresh();
    },
    refresh:function(){
        $.getJSON("webservice"
            ,{
                ajax:1,
                update:1,
                ver:curVer['twitt'],
                ref_page: mhktwitt.ref_page,
                ref_id: mhktwitt.ref_id,
                maxBox:mhktwitt.maxBox,
                type: 'twitt'
            }
            , function(data) {
                if(data){
                    mhktwitt.adds(data.twitts);
                    curVer['twitt']=data.ver;
                    setTimeout(mhktwitt.refresh, 20*1000);
                }else{
                    setTimeout(mhktwitt.refresh, 60*1000);
                }
            })
        .error(function(data) {
            setTimeout(mhktwitt.refresh, 60*1000);
        })
        .complete(function(data) {
            
            });
    },
    adds:function(twitts){
        if(twitts.length){
            //            var e=twitts.shift();
            var e=twitts.pop();
            mhktwitt.add(e);
            $(".timeago").timeago();
            setTimeout(mhktwitt.adds, 20,twitts);
            initAjaxLinks();
        }
    },
    add:function(twitt){
        if(mhktwitt.twittResponse[twitt.reply_id]){
            mhktwitt.twittResponse[twitt.reply_id] = mhktwitt.twittResponse[twitt.reply_id]+1;
        }else{
            mhktwitt.twittResponse[twitt.reply_id]=1;
        }
        
        if(mhktwitt.twittResponse[twitt.reply_id]>5){
            $('#a_answer_twitt_id_'+twitt.reply_id).hide();
            if(!$('#text_input_'+twitt.reply_id).val())
               $('#div_answer_twitt_id_'+twitt.reply_id).hide();
        }

        e='<div id="div_content_twitt_id_'+twitt.id+'" style="display:none;border-width:1px;border-top-style:dashed;padding: 10px;background-color:'+(twitt.reply_id==0?'#EEE':'#DDD')+'" class="twitt-content br-theme" >'
        +'<img class="user-avator" style="float: right;margin: 0 5px 5px 5px;" src="http://bargardon.ir/user/avatar/UA_' +twitt.user_id+ '.png" width="40" height="40" >'
        +'<div style="text-align:right;">'
        +'<a href="user_' +twitt.user_id+ '" style="color: green;float: right;" class="popup" target="_blank" >'
        +  twitt.user_nickname
        +'</a>'
        +'<a href="twitt_'+twitt.id+'" style="color: blue;float: left;font-size:12px" title="'+twitt.date+'" class="timeago popup" >'
        +  ''
        +'</a>'
        +'<br/>'
        +'<p>'
        + twitt.text
        +'</p>'
        +'</div>';
        if(curUser.id){
            if(twitt.reply_id==0){
                e+=' <a id="a_answer_twitt_id_'+twitt.id+'" style="color: green;float: left;" onclick="$(\'#div_answer_twitt_id_'+twitt.id+'\').slideToggle()" >'
                +'پاسخ</a>';
            }
            if((twitt.user_id==curUser.id && twitt.reply_id!=0 )|| hasFeature("FTA")){
                e+=' <a style="color: red;float: left;margin-left:5px;" onclick="mhktwitt.remove('+twitt.id+')" >'
                +'حذف</a>';
            }
        }
        e+='<div class="clear"></div>'
        
        +'<div style="display: none;margin-right: 55px;padding:10px;background-color:#DDD;" id="div_answer_twitt_id_'+twitt.id+'">'
        +'<img class="user-avator" style="float: right;margin: 0 5px 5px 5px;"'
        +'src="http://bargardon.ir/user/avatar/UA_'+curUser.id+'.png" '
        +'width="40" height="40" />'
        +'<input type="hidden" id="reply_id_input_'+twitt.id+'" value="'+twitt.id+'"/>'
        +'<div style="float: right;">'
        +'<textarea id="text_input_'+twitt.id+'" maxlength="500" style="width: 98%;height: 30px;padding: 5px"></textarea>'
        +'<a style="padding: 0px 10px;float: right" class="active_btn"  onclick="mhkform.ajax(\'twitts?timg='+twitt.id+'&ajax=1\');" >افزودن تصویر</a>'
        +'<a style="padding: 0px 10px;float: right" class="active_btn"  onclick="mhktwitt.displaySmiley('+twitt.id+');" > شکلک</a>'
        +'<br/><a style="padding: 0px 18px;float: left" class="active_btn" id="twitt_send_btn_'+twitt.id+'" onclick="mhktwitt.send(\'#text_input_'+twitt.id+'\', \'#reply_id_input_'+twitt.id+'\',\'#twitt_send_btn_'+twitt.id+'\',\'#twitt_send_loader_'+twitt.id+'\');" >ثبت</a>'
        +'<img  style="display: none;padding: 0px 18px;float: left" id="twitt_send_loader_'+twitt.id+'"'
        +'src="medias/images/icons/loader.gif"'
        +'width="15" height="15" />'
        +'</div>'
        +'<div class="clear"></div>'
        +'</div>'
        
        
        +'<div id="div_twitt_id_'+twitt.id+'" class="" style="margin-right: 55px;">'
        +'</div>'
        +'</div>';
        
        $("#div_content_twitt_id_"+twitt.id).remove();
        var cid='#div_twitt_id_'+twitt.reply_id;
        if($(cid).children('div').length>0){
            $(cid).children('div').first().before(e);
            if($(cid).children('div').length > 10 ||($(cid).children('div').length > 12 && twitt.reply_id<1)){
                $(cid).children('div').last().fadeOut();
                $(cid).children('div').last().remove();
            }
        }else{
            $(cid).append(e);
        }
        $("#div_content_twitt_id_"+twitt.id).slideDown();
       
    },
    send:function(text_key,reply_id_key,send_btn_key,send_loader_key){
        var _text=$(text_key).val();
        var _reply_id=$(reply_id_key).val();
        
        if(_text=='')
            return;
        
        $(send_btn_key).hide();
        $(send_loader_key).show();
        $(text_key).attr("disabled", "disabled");
        
        $.post("webservice"
            ,{
                ajax:1,
                add:1,
                ver:curVer['twitt'],
                text:_text,
                reply_id:_reply_id,
                ref_page: mhktwitt.ref_page,
                ref_id: mhktwitt.ref_id,
                maxBox: mhktwitt.maxBox,
                type:'twitt'
            }
            , function(data) {
                if(data){
                    mhktwitt.adds(data.twitts);
                    curVer['twitt']=data.ver;
                    $(text_key).val('');
                    
                    $(send_btn_key).show();
                    $(send_loader_key).hide();
                    $(text_key).removeAttr("disabled");
        
                }else{
                }
            }, "json")
        .error(function(data) {
            })
        .complete(function(data) {
            });
        
            
    },
    remove:function(tid){
        mhkform.confirm('آیا مطمئنید؟','$.getJSON(\'webservice\',{ajax:1,remove:1,tid:'+tid+',type: \'twitt\'});mhkform.close();$(\'#div_content_twitt_id_'+tid+'\').remove()');
    },
    displaySmiley:function(tid){
        var smileis= '    شکلک'
        +'<hr/>'
        +'<div>'
        +'<img src="medias/images/icons/smiley/gomen_nasai.png" onclick="mhktwitt.appendSmiley('+tid+',\':)\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/XD.png" onclick="mhktwitt.appendSmiley('+tid+',\':XD\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/ashamed.png" onclick="mhktwitt.appendSmiley('+tid+',\':-S\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/cry.png" onclick="mhktwitt.appendSmiley('+tid+',\':((\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/dangerous.png" onclick="mhktwitt.appendSmiley('+tid+',\':(\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/evil.png" onclick="mhktwitt.appendSmiley('+tid+',\':LL\')" class="smiley" />'
        +'<br/>'
        +'<img src="medias/images/icons/smiley/hoho.png" onclick="mhktwitt.appendSmiley('+tid+',\':D\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/nyu.png" onclick="mhktwitt.appendSmiley('+tid+',\'(:|\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/really_angry.png" onclick="mhktwitt.appendSmiley('+tid+',\':-L\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/so_cute.png" onclick="mhktwitt.appendSmiley('+tid+',\'=((\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/sorry.png" onclick="mhktwitt.appendSmiley('+tid+',\':\\\'(\')" class="smiley" />'
        +'<img src="medias/images/icons/smiley/what.png" onclick="mhktwitt.appendSmiley('+tid+',\':O\')" class="smiley" />'
        +'</div>';
        mhkform.open(smileis);
    },
    appendImage:function(tid){
        var postfix='';
        if(tid)
            postfix='_'+tid;
        
        var link=''
        if($('#timg_hidden').val()){
            link='[['+$('#timg_hidden').val().substr(2, $('#timg_hidden').val().length-4)+']]';
        }else if($('#imgLink').val() && $('#imgLink').val()!='http://'){
            link='{{'+$('#imgLink').val()+'}}';
        }
        if(link!='')
            $('#text_input'+postfix).val($('#text_input'+postfix).val()+'\n'+link+'\n');
        mhkform.close();
    },
    appendSmiley:function(tid,smiley){
        var postfix='';
        if(tid)
            postfix='_'+tid;
        
        if(smiley!='')
            $('#text_input'+postfix).val($('#text_input'+postfix).val()+' '+smiley+' ');
        mhkform.close();
    }
    
    
}
//
//function selectUser(id,username){
//    $('#text_input').val($('#text_input').val()+'@'+username+'');
//    mhkform.close();
//}
