<?php 

require_once 'base.php';
require_once 'File.php';



//获取图片
$file = $_FILES["file"];
//图片hash
$hash = trim($_POST['hash']);
$hash = str_split($hash,2);

//图片扩展名
$ext = strrchr($file["name"], '.');
//图片保存相对路径
$rUrl = DIRECTORY_SEPARATOR.$uploadUrl.DIRECTORY_SEPARATOR.$hash[0].DIRECTORY_SEPARATOR.$hash[1].DIRECTORY_SEPARATOR.time().File::hash().$ext;
//绝对图片保存路径
$path = $baseUrl.$rUrl;

//生成目录
File::makeDir(dirname($path),$baseUrl);
//保存原图
move_uploaded_file($file['tmp_name'],$path);
//生成缩略图
if(isset($_POST['thumb_type'])){
	$sizeType = trim($_POST['thumb_type']);
	if(array_key_exists($sizeType, $sizeSta)){
		//原图规格
		$size = getimagesize($path) ;
		$realityWidth = $size[0];//实际宽度 
		$realityheight = $size[1];//实际高度
		//缩略图目录
		$thumbPath = str_replace($uploadUrl,$thumbUrl,$rUrl);
		//缩放图片规格
		$sta = $sizeSta[$sizeType];

		$size = getimagesize($path);

		foreach($sta as $val){
			$width = $val[0];
			$height = $val[1];
			$thumbUrl = str_replace("$ext","_resize_{$width}_{$height}$ext",$thumbPath);
			//生成目录
			$tPath = $baseUrl.DIRECTORY_SEPARATOR.$thumbUrl;
			File::makeDir(dirname($tPath),$baseUrl);

			//无缩放初始值
			$targetWidth = $realityWidth;
			$targetHeight = $realityheight;
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
                    $image = @imagecreatefromgif($path);
                    break;
                case 2:
                    $image = @imagecreatefromjpeg($path);
                    break;
                case 3:
                    $image = @imagecreatefrompng($path);
                    break;
                case 6:
					$image = @imagecreatefrombmp($path); 
					break;
				default:
					# code...
					break;
            }
			imagecopyresampled($im,$image,0,0,0,0,$targetWidth,$targetHeight,$size[0],$size[1]);
 			$cr = imagejpeg($im, $tPath,100);
		}
	}
}

$rUrl = str_replace('\\', '/', $rUrl);
echo $domain.$rUrl;


?>