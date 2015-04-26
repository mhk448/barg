<?php

$width = 100;
$height = 28;
$length = 4;
@session_start();
$_SESSION['_CAPTCHA_'] = rand(1000, 9999);

if (isset($_SESSION['_CAPTCHA_'])) {
    header("Content-type: image/gif");
    $img = imagecreate($width, $height);
    $white = imagecolorallocate($img, 255, 255, 255);
    $fore_color = imagecolorallocate($img, 100, 100, 100);
    for ($i = 0; $i < 30; $i++) {
        $line_color = imagecolorallocate($img, rand(150, 255), rand(150, 255), rand(150, 255));
        imageline($img, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
    }
    $str = (string) $_SESSION['_CAPTCHA_'];
    for ($i = 0; $i < $length; $i++)
        imagettftext($img, 20, rand(-30, 30), (($i * 20) + 10), 20, $fore_color, "medias/fonts/COOPBL.TTF", $str[$i]);
    imagecolortransparent($img, $white);
    imagegif($img);
}
?>