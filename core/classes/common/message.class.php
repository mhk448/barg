<?php

class Message {

    public $messages;
    public $messages_count;
    public $errors;
    public $errors_count;

    public function __construct() {
        $this->clear();
    }

    public function clear() {
        $this->messages = array();
        $this->messages_count = 0;
        $this->errors = array();
        $this->errors_count = 0;
    }

    public function addMessage($message) {
        $this->messages[$this->messages_count++] = $message;
    }

    public function addError($message) {
        $this->errors[$this->errors_count++] = $message;
    }

    public function display() {
        if ($this->errors_count > 0) {
            echo '<div class="alert callout alert-danger" style="text-align:right;">';
            for ($i = 0; $i < $this->errors_count; $i++){
                echo '<p><i class="icon fa fa-warning"></i>' . $this->errors[$i] . '</p>';
            }
            echo '</div>';
        }
        if ($this->messages_count > 0) {
            echo '<div class="alert callout alert-success" style="text-align:right;">';
            for ($i = 0; $i < $this->messages_count; $i++){
                echo '<p><i class="icon fa fa-check"></i>' . $this->messages[$i] . '</p>';
            }
            echo '</div>';
        }
    }

    public function displayMessage($message) {
        $m = new Message();
        $m->addMessage($message);
        $m->display();
    }

    public function displayError($message = "خطا در انجام عملیات") {
        $m = new Message();
        $m->addError($message);
        $m->display();
    }

    public function displayOk($message = "انجام شد") {
        $m = new Message();
        $m->addMessage($message);
        $m->display();
    }

    public function conditionDisplay($condition) {
        if ($condition === TRUE)
            $this->displayOk();
        elseif ($condition)
            $this->displayMessage($condition);
        else
            $this->displayError();
    }

    //HHHHHHHH rate HHHHHHHHHHHHHHHHHHHHHHHHHHHHH
    public function displayRank($rank, $rankers = 1, $max = 10) {
        $rankers = ($rankers == 0 ? 1 : $rankers);
        $rank = round(($rank*10) / $rankers)/10;
//        $rank = 10;
        ?>
        <div class="bg-user-rate transition" style="">
            <div class="star-user-rate transition" style="width: <?= ($rank / $max) * 100 ?>px;">
            </div>
            <div class="text-user-rate bg-trans transition" style="" >
                <?= $rank ?>
                امتیاز
                از
                <?= $max ?>
            </div>
        </div>
        <?
    }

    //HHHHHHHH  Refresh HHHHHHHHHHHHHHHHHHHHHHHHh
    public function refreshMenu($time = 1) {
        $this->refresh(); //nc?
    }

    public function refreshBody($time = 1) {
        $this->refresh(); //nc?
    }

    public function refresh($time = 1) {
        echo '<script type="text/javascript"> location.reload(true); </script>';
    }

    public function runScripts($scripts, $time = 1) {
        echo '<script type="text/javascript">'
        . 'setTimeout(\''
        . $scripts
        . '\','.($time*1000).');'
        . '</script>';
    }

}