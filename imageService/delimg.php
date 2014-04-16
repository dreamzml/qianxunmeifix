<?php 

require_once 'base.php';
require_once 'File.php';


$imgPath = trim($_POST['path']);
$imgPath = $baseUrl.DIRECTORY_SEPARATOR.$imgPath;
echo $imgPath;
//删除文件
File::delFile($imgPath);




?>