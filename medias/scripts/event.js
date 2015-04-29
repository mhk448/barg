/* 
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: May 22, 2013 , 12:11:48 PM
 * mhkInfo:
 */

mhkevent = {
    start: function () {
        $.getJSON("webservice"
                , {
                    ajax: 1,
                    update: 1,
                    ver: curVer['event'],
                    type: 'event'
                }
        , function (data) {
            if (data) {
                mhkevent.adds(data.events);
                curVer['event'] = data.ver;
                setTimeout(mhkevent.start, 40 * 1000);
            } else {
                setTimeout(mhkevent.start, 120 * 1000);
            }
        })
                .error(function (data) {
                    setTimeout(mhkevent.start, 60 * 1000);
                })
                .complete(function (data) {

                });
    },
    open: function () {
        try {
            $('.mhkevent-win').slideDown();
            return true;
        } catch (e) {
        }
        return false;
    },
    adds: function (events) {
        if (events.length) {
            var e = events.pop();
            mhkevent.add(e);
            setTimeout(mhkevent.adds, 2000, events);
        }
    },
    add: function (event) {
        if (event.readed == "0") {
            mhkevent.runAction(event);
        }
        if (event.readed == "0") {
            mhkevent.addCounter();
        }

        var unread = (event.readed == "1") ? '' : 'unread';
//        e='<div style="" class="'+unread+'" onclick="mhkevent.setRead(this);mhkform.ajax(\'/event_'+event.id+'?ajax=1\')" >'+
//        '<a id="event_id_'+event.id+'" class="event-content">'+event.title+'</a></div>';
        e = '<li style="" class="' + unread + '" onclick="mhkevent.setRead(this);mhkform.ajax(\'/event_' + event.id + '?ajax=1\')" >' +
                '<a id="event_id_' + event.id + '" class="event-content">' +
                '<small class="left"><i class="fa fa-clock-o ' + mhkevent.getColor[event.type] + '"></i> <span class="timeago" title="' + event.dateline + '000">' + $.timeago(new Date(event.dateline * 1000)) + '</span></small>' +
                '<i class="fa fa-' + mhkevent.getIcon[event.type] + ' ' + mhkevent.getColor[event.type] + '"></i>' + event.title + '</a></li>';

        var cid = '.mhkevent-win .content';
        if ($(cid).children('li').length > 0) {
            $(cid).children('li').first().before(e);
            if ($(cid).children('li').length > 5) {
                $(cid).children('li').last().fadeOut();
                $(cid).children('li').last().remove();
            }
        } else {
            $(cid).append(e);
        }


    },
    runAction: function (event) {
        ////  bids  ////
        if (event.type == 'bid') {
            if (event.action == 'submit') {
                return true;
            } else if (event.action == 'receive') {
                mhkevent.setServerRead(event);
                //                mhkform.open('<h2>پیشنهاد انجام کار</h2>'+'<div id="project_bid_div" class="pb" style="width:600px;height:400px"></div>');
                //                updateData('project_bid',1000,25, event.ref_id );
                mhkform.ajax("ajax-pages?page=project_bid&pid=" + event.ref_id);
            } else {
                mhkevent.setServerRead(event);
                mhkevent.open();
                mhkevent.show(event);
            }
        } else if (event.type == 'project') {
            if (event.action == 'run') {
                $.get("event_" + event.id, {
                    ajax: 1
                }, function () {
                    mhkform.redirect('project_' + event.ref_id + '?start=1', true);
                });
            } else if (event.action == 'cancel') {
                mhkform.ajax('project_' + event.ref_id, 'ajax_content');
                mhkevent.setServerRead(event);
                mhkevent.open();
                mhkevent.show(event)
            }
        }
        mhkevent.playSound('event');
        return true;
    },
    addCounter: function () {
        c = parseInt($("#mhkevent-counter").html());
        $("#mhkevent-counter").html(c + 1);
        $("#mhkevent-counter-img").addClass("img-split18-2-2");
    },
    subCounter: function () {
        c = parseInt($("#mhkevent-counter").html()) - 1;
        if (c <= 0) {
            $('.mhkevent-win').fadeOut();
            c = 0;
            $("#mhkevent-counter-img").removeClass("img-split18-2-2");
        }
        $("#mhkevent-counter").html(c);
    },
    setServerRead: function (event) {
        event.readed = "1";
        $.get("event_" + event.id, {
            ajax: 1
        });
    },
    setRead: function (cur) {
        $(cur).removeClass("unread");
        mhkevent.subCounter();
    },
    playSound: function (type) {
        try {
            $('#audio-' + type)[0].play();
        } catch (e) {
        }
    },
    show: function (event) {
        if (!mhkform.isOpen()) {
            mhkform.ajax("event_" + event.id + '?ajax=1');
        } else {
            setTimeout(mhkevent.show, 1000, event);
        }
    },
    runScript: function () {
    },
    getIcon: {
        'payment': 'money',
        'payout': 'money',
        'message': 'envelope',
        'project': 'briefcase',
        'bid': 'lightbulb-o',
        'user': 'bolt',
        'group': 'group',
        'admin': 'bolt'
    },
    getColor: {
        'payment': 'text-red',
        'payout': 'text-yellow',
        'message': 'text-green',
        'project': 'text-aqua',
        'bid': 'text-yellow',
        'user': 'text-aqua',
        'group': 'text-yellow',
        'admin': 'text-red'
    }
}