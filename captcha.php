<?php

session_start();
$permitted_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabdefghijlmnpqrstuy123456789';

function generate_string($input, $strength = 7) {
    $inputLen = strlen($input);
    $randomStr = '';

    for($i = 0; $i < $strength; $i++) {
        $randomChar = $input[random_int(0, $inputLen - 1)];
        $randomStr .= $randomChar;
    }

    return $randomStr;
}

$image = imagecreatetruecolor(200, 50);
imageantialias($image, true);

$colours = [];
$r = rand(125, 175);
$g = rand(125, 175);
$b = rand(125, 175);

for($i = 0; $i < 5; $i++) {
  $colours[] = imagecolorallocate($image, $r - 20 * $i, $g - 20 * $i, $b - 20 * $i);
}

imagefill($image, 0, 0, $colours[0]);

for($i = 0; $i < 10; $i++) {
  imagesetthickness($image, rand(2, 10));
  $lineColor = $colours[rand(1, 4)];
  imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $lineColor);
}

$black = imagecolorallocate($image, 0, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$textcolours = [$black, $white];

$stringLen = 6;
$captchaStr = generate_string($permitted_chars, $stringLen);
$_SESSION['captcha_text'] = $captchaStr;

$fontSize = 5;
$letterSpace = 170 / $stringLen;
$initial = 10;

for ($i = 0; $i < $stringLen; $i++) {
    $x = $initial + $i * $letterSpace;
    $y = rand(5, 15);
    $textColor = $textcolours[rand(0, 1)];
    imagestring($image, $fontSize, $x, $y, $captchaStr[$i], $textColor);
}

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>