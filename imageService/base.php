<?php 

$dir = dirname(__FILE__);
$baseUrl = dirname($dir);
$domain = "http://".$_SERVER['SERVER_NAME'];

//上传文件保存地址
$uploadUrl = "upload";
//缩略图地址
$thumbUrl = "thumb";

//服务器密钥，上传图片权限验证使用
$key = "F746E5BE0F4A2226BC44C4964E";

//生成缩略图规格
$sizeSta = array(
			'normal'=>array(array(100,100),array(170,170),array(220,0),array(260,0)),//一般，
			'noavatar'=>array(array(32,32),array(64,64),array(100,100)),//头像
			);


$userkey = trim($_POST['key']);
if($userkey != $key){
	echo "图片服务器配置不正确！";
	exit;
}





?>