<?php
/*
 * In The Name of GOD
 * @author MHK448
 * Email: MHK448@gmail.com
 * Created at: Dec 6, 2013 , 9:01:23 PM
 * mhkInfo:
 */

/* @var $database Database */
/* @var $cdatabase Database */
/* @var $user User */
/* @var $message Message */

class Twitt {

    private $_info = array();

    public function __construct($id = NULL) {
        $this->_info['id'] = $id;
    }

    public function __get($name) {
        switch ($name) {
            case 'id':
                return $this->_info[$name];
            default :
                if ($this->_info['id']) {
                    if (!isset($this->_info['dateline']))
                        $this->_setInfo();
                    if (isset($this->_info[$name]))
                        return $this->_info[$name];
                }
        }
        return NULL;
    }

    public function add($user_id, $ref_page, $ref_id, $text, $reply_id = 0, $blocked = 0, $verified = 1) {
        global $database, $subSite;

        $text = htmlentities($text, ENT_COMPAT, "UTF-8", false);
        $text = nl2br($text);
        $text = preg_replace('/(\[\[)(.*)(\]\])/', '<img src="uploads/' . $subSite . '/twitt/\2" class="twitt-img"/>', $text);
        $text = preg_replace('/(\{\{)(.*)(\}\})/', '<img src="\2" class="twitt-img"/>', $text);

        $icons = array(
            ':LL' => '<img src="medias/images/icons/smiley/evil.png"  class="smiley" />',
            ':)' => '<img src="medias/images/icons/smiley/gomen_nasai.png"  class="smiley" />',
            ':XD' => '<img src="medias/images/icons/smiley/XD.png"  class="smiley" />',
            ':-S' => '<img src="medias/images/icons/smiley/ashamed.png"  class="smiley" />',
            ':((' => '<img src="medias/images/icons/smiley/cry.png"  class="smiley" />',
            ':(' => '<img src="medias/images/icons/smiley/dangerous.png"  class="smiley" />',
            ':D' => '<img src="medias/images/icons/smiley/hoho.png"  class="smiley" />',
            '(:|' => '<img src="medias/images/icons/smiley/nyu.png"  class="smiley" />',
            ':-L' => '<img src="medias/images/icons/smiley/really_angry.png"  class="smiley" />',
            '=((' => '<img src="medias/images/icons/smiley/so_cute.png"  class="smiley" />',
            ':\'(' => '<img src="medias/images/icons/smiley/sorry.png"  class="smiley" />',
            ':O' => '<img src="medias/images/icons/smiley/what.png"  class="smiley" />',
        );
        $text = strtr($text, $icons);

        if ($reply_id) {
            $this->addReply($reply_id);
        }
        return $database->insert('twitts', array(
                    'user_id' => (int) $user_id,
                    'ref_page' => $ref_page,
                    'ref_id' => $ref_id,
                    'text' => $text,
                    'reply_id' => $reply_id,
                    'verified' => $verified,
                    'last_reply' => time(),
                    'dateline' => time()));
    }

    public function update() {
        
    }

    public function addReply($id) {
        global $database;
        return $database->update('twitts', array(
                    'last_reply' => time()), $database->whereId($id)
        );
    }

    public function delete($tid) {
        global $user, $database;
        return $database->update('twitts', array(
                    'verified' => Event::$V_DELETE), $database->whereId($tid)
                        . ' AND (user_id = ' . $user->id . ' OR ' . ($user->hasFeature(User::$F_TWIIT_ADMIN) ? 'TRUE' : 'FALSE') . ')');
    }

    public function display($ref_page, $ref_id, $maxBox) {
        global $user;
        ?>
        <script type="text/javascript" src="medias/scripts/twitt.js?v=5" ></script>
        <? if ($user->isSignin()) { ?>
            <div class="br-theme" style="border-bottom-style:solid;padding: 10px">
                <img class="user-avator" style="float: right;margin: 0 5px 5px 5px;"
                     src<?= '="http://bargardoon.com/user/avatar/UA_' . $user->id . '.png"'; ?> 
                     width="40" height="40" />
                <input type="hidden" id="reply_id_input" value="0"/>
                <div style="float: right;width: 86%;">
                    <textarea id="text_input" maxlength="500" style="width: 99%;height: 50px;padding: 5px"></textarea>
                    <a style="padding: 0px 18px;float: left" class="active_btn" id="twitt_send_btn" onclick="mhktwitt.send('#text_input', '#reply_id_input','#twitt_send_btn','#twitt_send_loader');" >ثبت</a>
                    <a style="padding: 0px 10px;float: right" class="active_btn" id="twitt_send_btn" onclick="mhkform.ajax('twitts?timg=0&ajax=1');" >افزودن تصویر</a>
                    <a style="padding: 0px 10px;float: right" class="active_btn" id="twitt_send_btn" onclick="mhktwitt.displaySmiley(0)" >شکلک</a>
                    <!--<a style="padding: 0px 18px;float: right" class="active_btn" id="twitt_send_btn" onclick="mhkform.ajax('user-list_worker?ajax=1');" >افزودن کاربر</a>-->
                    <!--<a style="padding: 0px 18px;float: right" class="active_btn" id="twitt_send_btn" onclick="mhkform.ajax('projects_all?ajax=1');" >افزودن پروژه</a>-->
                    <img  style="display: none;padding: 0px 18px;float: left" id="twitt_send_loader"
                          src="medias/images/icons/loading.gif"
                          width="15" height="15" />
                </div>
                <div class="clear"></div>
            </div>
        <? } ?>
        <div id="div_twitt_id_0"></div>
        <script type="text/javascript">
            mhktwitt.start(<?= "'" . $ref_page . "'," . $ref_id . ',' . $maxBox ?>);
        </script>
        <?php
    }

    public function myTwitt() {
        
    }

    public function countReplies() {
        
    }

}
?>
