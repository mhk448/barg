/* 
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Apr 29, 2015 , 6:56:29 AM
 * mhkInfo:
 */




function mhkhelp(selector, text) {
    var r={
        "background-color": "red"
    };
     var w={
        "background-color": "transparent"
    };
    
   var s= $(selector).css({
        "z-index": 1100,
        "border": "1px solid rgb(255, 0, 0)"
    });
    
    for (var i=0;i<20;i++){
        s=s.animate(r,200).animate(w,200);
    }
    
    
    mhkform.open(text);
}

//mhkhelp(".sidebar-toggle", "test");