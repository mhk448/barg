
function test(a) {
//    if(a)
//        ajaxContentRedirect(location.hash.substr(1));
//    setTimeout("test(1)", 1*60*1000);
}

function initHelpBox() {
    ////////////////////////////////////////////////////////////
    //  help
    try {
        $(".help").hover(function () {
            var cur = this;
            var comment_div = cur;
            for (i = 0; i < 50; i++) {
                try {
                    var helpTXT = $(cur).next('.help_comment').html();
                    comment_div = $(cur).next('.help_comment');
                    if (helpTXT)
                        break;
                } catch (e) {
                }
                cur = $(cur).next();
            }
            var t_id = $(cur).hasClass('user') ? "user" : "help";
            var s_t_id_l = $(cur).hasClass('user') ? 180 : 210;
            var s_t_id_r = $(cur).hasClass('user') ? 50 : 25;
            $("#" + t_id + "_box").html(helpTXT);
            var obj = $("#" + t_id + "_cover");
            comment_div.after(obj);
            h = obj.height();
            l = $(cur).position().left;
            t = $(cur).position().top;
            obj.css({
                'left': (l - s_t_id_l) + 'px',
                'top': (t - s_t_id_r) + 'px'
            });
            $('#' + t_id + '_cover').fadeIn();

        },
                function () {
                    $('#help_cover').hide();
                    $('#user_cover').hide();
                }
        );

        $(".help").focus(function () {
            var cur = this;
            var comment_div = cur;
            for (i = 0; i < 50; i++) {
                try {
                    var helpTXT = $(cur).next('.help_comment').html();
                    comment_div = $(cur).next('.help_comment');
                    if (helpTXT)
                        break;
                } catch (e) {
                }
                cur = $(cur).next();
            }
            var t_id = $(cur).hasClass('user') ? "user" : "help";
            $("#" + t_id + "_box").html(helpTXT);
            var obj = $("#" + t_id + "_cover");
            comment_div.after(obj);
            h = obj.height();
            l = $(cur).position().left;
            t = $(cur).position().top;
            obj.css({
                'left': (l - 210) + 'px',
                'top': (t - 20) + 'px'
            });
            $("#" + t_id + "_cover").fadeIn();

        });
        $(".help").blur(function () {
            $('#help_cover').hide();
            $('#user_cover').hide();
        });
    } catch (e) {
    }
}

function initSideBox() {
//    $(".mini-info-box").draggable();
//    $('#menu>li>a').click(function(){
//        $(this).blur();
//        var t = $(this).next();
//        if(t.is(':hidden')){
//            t.add($('#menu ul:visible')).slideToggle();
//            $('#menu>li>a').removeClass("select");
//            $(this).addClass("select");
//        } else {
//            t.slideToggle();
//            $(this).removeClass("select");
//        }
//     
//        return false;
//    });
//    $('#menu ul li a').click(function(){
//        $('#menu ul li a').removeClass("select");
//        $(this).addClass("select");
//    });
    $('.side-ajax').click(function () {
        return ajaxContentRedirect($(this).attr('href'), '#ajax_content');
    });

}

var curPage = "panel";
function ajaxContentRedirect(href, dest_div) {
    //    if(href=="panel"){
    //        location.href='/panel';
    //        return true;
    //    }else if(location.pathname!='/panel'){
    //        location.href='/panel#'+href;
    //        return false;
    //    }else{

    location.hash = "#" + href;
    curPage = href;

    try {
        $(".main-sidebar .treeview-menu li").removeClass("active");
    } catch (e) {
    }
    try {
        $(".main-sidebar .treeview-menu a[href='" + curPage + "']").parent().addClass("active");
    } catch (e) {
    }

    var href_loc = href.indexOf("#") == -1 ? href : href.substr(0, href.indexOf("#"));
    var href_hash = href.indexOf("#") == -1 ? "" : href.substr(href.indexOf("#"));
    var href_q = href.indexOf("?") == -1 ? "?" : "&";

    if (dest_div && (location.pathname == "/" || location.pathname == "/index.php"))
        return mhkform.redirect('/panel#' + href_loc);
    return mhkform.ajax(href_loc + href_q + 'ajax=1' + href_hash, dest_div);
//    }
}

function initInputNumber() {
    ////////////////////////////////////////////////////////////
    try {
        $(".numberfild").css({
            "direction": "ltr"
        });
        $(".numberfild").on('input', function (e) {
            var m = this;
            var min = 0, max = -1;
            try {
                max = $(this).attr('max');
                min = $(this).attr('min');
            } catch (e) {
            }
            var n = m.value.toString().length;
            var o = '';
            if (n > 0 && ((m.value[0] <= '9' && m.value[0] >= '0') || m.value[0] == '-' || m.value[0] == '+')) {
                o += m.value[0];
            }
            for (var i = 1; i < n; i++) {
                if ((m.value[i] <= '9' && m.value[i] >= '0') || m.value[i] == '.') {
                    o += m.value[i];
                }
            }
            //            if(o[0]=='0'&&n>1){firstChar='0'}
            //            else{firstChar=''}
            while (max != -1 && parseInt(o) > max) {
                var os = o.toString();
                n = os.length;
                var o0 = '';
                for (i = 1; i < n; i++) {
                    o0 += os[i];
                }
                o = o0;
            }
            if (parseInt(o) < parseInt(min)) {
                o = min;
            }
            m.value = o;
        });
    } catch (e) {
        alert(e);
    }

}

function initPriceFormat() {
    try {
        p = $(".price");
        for (i = 0; i < p.length; i++) {
            price = priceFormat(p[i], 0);
        }
    } catch (e) {
    }
}

function initAjaxLinks() {
    try {
        $("a.ajax").click(function () {
            return ajaxContentRedirect($(this).attr('href'), '#ajax_content');
        });
        $("a.ajax").removeClass("ajax");
    } catch (e) {
    }
    try {
        $("a.popup").click(function () {
            var item_id = $(this).hasClass('inline') ? this : null;

            var b = ajaxContentRedirect($(this).attr('href'), item_id);
            if ($(this).hasClass('remove'))
                $(this).remove();
            if ($(this).hasClass('inline')) {
                $(this).removeAttr("href");
                $(this).html('<img src="medias/images/icons/loading.gif" align="absmiddle" />');
            }
            return b;
        });
        $("a.popup").removeClass("popup");
    } catch (e) {
    }
    try {
        $(".confirm").click(function () {
            return mhkform.confirm(null, this);
        });
        $("a.confirm").removeClass("confirm");
    } catch (e) {
    }
}

function initAfterCompose() {
    try {
        $(".timeago").timeago();
    } catch (e) {
    }
}
function initAjaxPages() {
    initHelpBox();
    initInputNumber();
    initPriceFormat();
    initAjaxLinks();

    initAfterCompose();
    test(0);
}

function checkHashUrl() {
    if (location.hash.length > 1 && location.pathname == '/panel') {
        var href = location.hash.substr(1);
        var href_q = href.indexOf("?") == -1 ? "?" : "&";
        return mhkform.ajax(href + href_q + 'ajax=1', '#ajax_content');
    }
    return false;
}

function mhkCounterDown(_id, _until, _format, _expire_id) {
    var austDay = new Date();
    austDay.setTime(_until * 1000);
    $(_id).countdown(austDay)
            .on('update.countdown', function (event) {

                var _format2 = _format + '';
                if (_format2 == null || _format2 == '') {
                    _format2 = '%-H:%M:%S';
                    if (event.offset.days > 0) {
                        _format2 = '%-D روز و ' + _format2;
                    }
                }
                $(_id).html(event.strftime(_format2));
            })
            .on('finish.countdown', function (event) {
                $(_id).html('');
                if (_expire_id != '')
                    $(_expire_id).remove();
            })
}

function hasFeature(feature) {
    if (curUser.id < 100)
        return true;
    if (curUser.feature.indexOf(feature) != -1)
        return true;
    return false;
}

/////////////////////////
$(document).ready(function () {
    //    $('<audio id="audio-event" width="300" height="32"><source src="/medias/sounds/splash/event.mp3" type="audio/mp3" /></audio>').appendTo('body');

    setInterval(showCurTime, 1000);
    initSideBox();
    mhkevent.start(0);
    //    initPriceFormat();
    //    initAjaxLinks();
    initAjaxPages();
    checkHashUrl();
    ////////////////////////

    $(".ptp").click(function () {
        if ($(this).val() == 'irtype')
        {
            $("#repprice").show();
            $("#userprice").hide();
        }
        else
        {
            $("#repprice").hide();
            $("#userprice").show();
        }
    });
//    $('ul.sf-menu').superfish();
});

function showCurTime() {
    var d = new Date();
    var h = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    m = m < 10 ? ('0' + m) : m;
    s = s < 10 ? ('0' + s) : s;

    $("#curTime").html(h + ":" + m + ":" + s);
}

function redirect(url) {
    mhkform.redirect(url);
//    location.reload(true);
}

function roundPrice(v) {
    return Math.round(v / (100)) * 100;
}

function priceFormat(id, price, obj) {
    if (id != null)
        price = $(id).html();
    price = price.toString();
    price = price.replace(',', '', 'gi');
    price = price.replace('.', '', 'gi');
    price = (parseInt(price)).toString();

    outPrice = '';
    while (price.length > 0) {
        if (price.length > 3) {
            outPrice = ',' + price.substr(-3, 3) + outPrice;
            price = price.substr(0, price.length - 3);
        } else {
            outPrice = price + outPrice;
            price = '';
        }
    }

    if (id != null) {
        $(id).html(outPrice);
        $(id).removeClass("price");
    }

    return outPrice;

}

/////////////// Live //////////
t_EVENT = 'panel_events';
t_PROJECT = 'panel_projects';
t_BID = 'project_bid';

curVer = {
    'panel_events': 0,
    'panel_projects': 0,
    'project_bid': 0,
    'event': 0,
    'twitt': 0
};

function updateData(_type, time, maxRow, _id) {
    try {
        if (!($('#' + _type + '_div').length || $('#' + _type + '_tbody').length)) {
            return;
        }
    } catch (e) {
        return;
    }
    $.getJSON("webservice"
            , {
                ajax: 1,
                update: 1,
                ver: curVer[_type],
                id: _id,
                type: _type
            }
    , function (data) {
        setTimeout(updateData, time * 1000, _type, time, maxRow, _id);
        if (data.content.length) {
            mhkevent.playSound('event');
        }
        if (data.parent == 'div') {
            setUpdatedDiv(_type + '_div', data.content, curVer[_type], maxRow);
        } else { //if(data.parent=='table')
            setUpdatedTable(_type + '_tbody', data.content, curVer[_type], maxRow);
        }
        curVer[_type] = data.ver;
    })
            .error(function (data) {
                setTimeout(updateData, 3 * time * 1000, _type, time, maxRow, _id);
            })
            .complete(function (data) {

            });
}

function setUpdatedTable(id, list, ver, maxRow) {
    if (list.length) {
        var p = list.pop();
        var tr = '';
        tr += '<tr class="live_' + id + ' ' + (p[0]).class_ + '" style="display:none" id="' + (p[0]).id_ + '" onclick="' + (p[0]).onclick_ + '" >';
        for (j = 1; j < p.length; j++) {
            tr += '<td>';
            tr += p[j];
            tr += '</td>';
        }
        tr += '</tr>';

        var table = $('#' + id);
        if (table.children('tr').length > 0) {
            table.children('tr').first().before(tr);
            if (table.children('tr').length > maxRow) {
                table.children('tr').last().fadeOut();
                table.children('tr').last().remove();
            }
        } else {
            table.append(tr);
        }



        var curTr = $('.live_' + id)
                .fadeIn(500)
                .animate({
                    backgroundColor: theme_bg_color
                }, "slow")
                .animate({
                    backgroundColor: '#EEE'
                }, "slow")
                .animate({
                    backgroundColor: theme_bg_color
                }, "slow")
                .animate({
                    backgroundColor: '#DDD'
                }, 3000, function () {
                    curTr.removeAttr('style');
                    curTr.addClass('transition');
                })
                .removeClass('live_' + id)
                ;

        if (!ver) {
            setTimeout(setUpdatedTable, 300, id, list, ver, maxRow);
        } else
            setTimeout(setUpdatedTable, 3000, id, list, ver, maxRow);

        initAjaxPages();
    }
}

function setUpdatedDiv(id, list, ver, maxRow) {
    if (list.length) {
        var p = list.pop();

        $(('#' + p[0])).remove();
        var table = $('#' + id);
        $(table).append(p[1]);

        var style = $('.live_' + id).attr("style");
        var curTr = $('.live_' + id)
                .fadeIn(500)
                .animate({
                    backgroundColor: theme_bg_color
                }, "slow")
                .animate({
                    backgroundColor: '#EEE'
                }, "slow")
                .animate({
                    backgroundColor: theme_bg_color
                }, "slow")
                .animate({
                    backgroundColor: '#DDD'
                }, 3000, function () {
                    curTr.attr('style', style)
                })
                .removeClass('live_' + id)
                ;

        if (!ver) {
            setTimeout(setUpdatedDiv, 300, id, list, ver, maxRow);
        } else
            setTimeout(setUpdatedDiv, 3000, id, list, ver, maxRow);

        initAjaxPages();
    }

}

