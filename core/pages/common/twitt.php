<?php

$t = $pager->getParamById('twitts',FALSE);
//if(!$t) 
    header('Location: twitts');
    return;
?>
<div id="content-wrapper">
    <div id="content">
        <div style="width: 500px;">
            <script type="text/javascript" src="medias/scripts/jquery.timeago.js" ></script>

            <?
            $e = '<div id="div_content_twitt_id_' . $t['id'] . '" style="border-width:1px;border-top-style:dashed;padding: 10px;background-color:' . ($t['reply_id'] == 0 ? '#EEE' : '#DDD') . '" class="twitt-content br-theme" >'
                    . '<img class="user-avator" style="float: right;margin: 0 5px 5px 5px;" src="http://bargardoon.com/user/avatar/UA_' . $t['user_id'] . '.png" width="40" height="40" >'
                    . '<div style="text-align:right;">'
                    . '<a href="user_' . $t['user_id'] . '" style="color: green;float: right;" class="popup" target="_blank" >'
                    . $user->getNickname($t['user_id'])
                    . '</a>'
                    . '<a href="twitt_' . $t['id'] . '" style="color: blue;float: left;font-size:12px" title="' . date(DATE_ISO8601, $t['dateline']) . '" class="timeago popup" >'
                    . ''
                    . '</a>'
                    . '<br/>'
                    . '<p>'
                    . $t['text']
                    . '</p>'
                    . '</div>';
            echo $e;
            ?>
        </div>
        <script type="text/javascript">
            $(".timeago").timeago();    
        </script>
    </div>
</div>

