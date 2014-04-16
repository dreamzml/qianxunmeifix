<?php 

require_once 'base.php';
require_once 'File.php';


$imgPath = trim($_POST['imgPath']);
$ext = strrchr($imgPath, '.');
$width = (int)$_POST['width'];
$height = (int)$_POST['height'];

$thumbPath = str_replace($uploadUrl,$thumbUrl,$imgPath);
$thumbUrl = str_replace("$ext","_resize_{$width}_{$height}$ext",$thumbPath);

$tPath = $baseUrl.$thumbUrl;
$iPath = $baseUrl.$imgPath;
//生成目录
File::makeDir(dirname($tPath),$baseUrl);

$size = getimagesize($iPath) ;
$realityWidth = $size[0];//实际宽度 
$realityheight = $size[1];//实际高度

//等比缩放到最大宽度
if($realityWidth > $width && $width > 0){
    $targetWidth = $width;
    $targetHeight = ceil($realityheight*($width/$realityWidth));
}
//等比缩放到最大高度
if($targetHeight > $height && $height > 0){
    $targetWidth = ceil($targetWidth*($height/$targetHeight));
    $targetHeight = $height;
}

$im = imagecreatetruecolor($targetWidth, $targetHeight);

switch ($size[2])
{
    case 1:
        $image = @imagecreatefromgif($iPath);
        break;
    case 2:
        $image = @imagecreatefromjpeg($iPath);
        break;
    case 3:
        $image = @imagecreatefrompng($iPath);
        break;
    case 6:
		$image = @imagecreatefrombmp($iPath); 
		break;
	default:
		# code...
		break;
}

imagecopyresampled($im,$image,0,0,0,0,$targetWidth,$targetHeight,$size[0],$size[1]);
if(imagejpeg($im, $tPath,100)){
    $thumbUrl = str_replace('\\', '/', $thumbUrl);
	echo $domain.$thumbUrl;
}else{
	echo $domain.$imgPath;
}

?>