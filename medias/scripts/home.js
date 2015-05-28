function closeBlock(imgDOM){
    $(imgDOM).parent().parent().slideToggle();
}
function minimizeBlock(imgDOM){
    var bid=$(imgDOM).parent().parent().attr("id");
    $("#"+bid+".block_body"). slideToggle();
}
function slider_2_leyer(domO){
    var type=$(domO).attr('class');
    var pid=$(domO).parent().attr('id');
    if(type=='back_box'){
        $("#"+pid+' .front_box').slideDown();
        $("#"+pid+' .back_box').slideUp();
    } else{
        $("#"+pid+' .back_box').slideDown();
        $("#"+pid+' .front_box').slideUp();
    }
}

curVer=0;
function update(){
    $.getJSON("webservice"
        ,{
            ajax:1,
            update:1,
            ver:curVer,
            type:'hometable'
        }
        , function(data) {
            if(data.list.length){
                setUpdatedTable('livetbody',data.list,curVer,14);
                mhkevent.playSound('event');
            }
            updateCounter(data.count);
            curVer=data.ver;
            setTimeout("update()", 60*1000);
        })
    .error(function(data) {
        setTimeout("update()", 60*1000);
    })
    .complete(function(data) {
        
        });
}

function updateCounter(countList){

    if(countList){
        project=priceFormat(null,countList.project, null);
        typist=priceFormat(null,countList.typist, null);
        price=priceFormat(null,countList.price, null);
        page=priceFormat(null,countList.page, null);
        
        c_project=$('#prj_count').html();
        c_typist=$('#typist_count').html();
        c_price=$('#sum_price_count').html();
        c_page=$('#sum_page_count').html();
        
        if(c_project!=project){
            splashCounter('#prj_count',project);
        }
        if(c_typist!=typist){
            splashCounter('#typist_count',typist);
        }
        if(c_price!=price){
            splashCounter('#sum_price_count',price);
        }
        if(c_page!=page){
            splashCounter('#sum_page_count',page);
        }
    }
}
function splashCounter(id,val){
    mhkevent.playSound('event');
    $(id)
    .animate({
        color:'#F00'
    }, "slow")
    .animate({
        color:'#FFF'
    }, "slow")
    .animate({
        color:'#F00'
    }, "slow")
    .animate({
        color:'#FFF'
    }, "slow",function() {
        $(id).html(val)
    })
    .fadeIn("slow")
    .animate({
        color:'#F00'
    }, "slow")
    .animate({
        color:'#FFF'
    }, "slow")
    .animate({
        color:'#F00'
    }, "slow")
    .animate({
        color:'#FFF'
    }, 3000);

}