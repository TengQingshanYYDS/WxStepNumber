<?php 
include_once "wxBizDataCrypt.php";

$appid = '你的appid';
$appsecret = '你的appsecret';
$encryptedData = $_GET['encryptedData'];
$iv = $_GET['iv'];


$url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$_GET['code'].'&grant_type=authorization_code';

$content = file_get_contents($url);
$content = json_decode($content);

$sessionKey = $content->session_key;
$openId = $content->openid;


$pc = new WXBizDataCrypt($appid, $sessionKey);
$errCode = $pc->decryptData($encryptedData, $iv, $sp );

$sp = json_decode($sp);

$raw_data = array('openid' => $openId, 'sp' => $sp);
$res_data = json_encode($raw_data);

header('Content-Type:application/json');

if ($errCode == 0) {
	echo ($res_data);

} else {
print($errCode . "\n");
}

?>