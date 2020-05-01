<?require_once($_SERVER['DOCUMENT_ROOT']. "/bitrix/modules/main/include/prolog_before.php");

	session_start();
	// создаем случайное число и сохраняем в сессии
	$randomnr = rand(1000, 9999);
	$_SESSION['randomnr2'] = $randomnr;
	//создаем изображение
	$im = imagecreatetruecolor(150, 60);
	//цвета:
	$white = imagecolorallocate($im, 255, 255, 255);
	$grey = imagecolorallocate($im, 128, 128, 128);
	$black = imagecolorallocate($im, 0, 0, 0);
	imagefilledrectangle($im, 0, 0, 200, 35, $black);

	//путь к шрифту:
 
	$font = '../fonts/Montserrat-ExtraLight.ttf';

	//рисуем текст:
	imagettftext($im, 35, 0, 22, 40, $grey, $font, $randomnr);

	imagettftext($im, 35, 0, 15, 46, $white, $font, $randomnr);
 
	// предотвращаем кэширование на стороне пользователя
	header("Expires: Wed, 1 Jan 1997 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
 
	//отсылаем изображение браузеру
	header ("Content-type: image/gif");
	imagegif($im);
	imagedestroy($im);