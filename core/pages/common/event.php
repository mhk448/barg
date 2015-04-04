<?php
$e = $pager->getParamById('events');

if ($user->id == $e['user_id']) {
    $event->setRead($e['id']);
} elseif ($user->isAdmin()) {
    
} else {
    header('Location: permission-denied');
}
?>

<div id="content-wrapper" >
    <div id="content" class="event-body">
        <h1>
            <!--<a href="events">رخدادها</a>-->
            <?php
            echo $e['title'];
            ?>
        </h1>
        <hr/>
        <?php echo $persiandate->date('d F Y ساعت H:i:s', $e['dateline']) ?>
        <br>
        <div style="padding:20px; line-height:280%">
            <?php echo nl2br($e['body']) ?>
        </div>
    </div>
</div>

