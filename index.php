<?php

#Event Image
$event 			= ($_GET['e'] == '' ? '1' : $_GET['e']);
$eventWidth 	= 624;

try {
	#Canvas
	$canvas 	= new Imagick("images/event".$event.".png");
	$height		= 830;

	#Overlay
	$overlay	= new ImagickDraw();
	$color 		= new ImagickPixel('#000000');
	$height		= 128;
	$alpha		= .36;
	$overlay->setFillOpacity($alpha);
	$overlay->rectangle(0, 0, $eventWidth, $height);

	#Top Blur
	$blur 		= $canvas->clone();
	$blur->gaussianBlurImage(18, 10);
	$blur->cropImage($eventWidth, $height, 0, 0);
	$blur->drawImage($overlay);

	#Social info
	$user 		= rand(1, 5);
	$social 	= new Imagick("users/user".$user.".png");

	#Gradient cover
	$cover 	= new Imagick("images/gradient.png");

	#Compose layers
	$canvas->compositeImage($blur, Imagick::COMPOSITE_DEFAULT, 0, 0);
	$canvas->compositeImage($social, Imagick::COMPOSITE_DEFAULT, 0, 0);
	$canvas->compositeImage($cover, Imagick::COMPOSITE_DEFAULT, 0, 267);

	#Draw image
	$canvas->setImageFormat('png');
	header('Content-type: image/png');
	echo $canvas;
}
catch (Exception $e) { echo "Oops! Something went wrong (-__- )"; }

?>