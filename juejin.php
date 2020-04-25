<?php
//设置 header
header("Content-type:application/json");

//初始化 CURL
$ch = curl_init();

//获取当前目录绝对路径
$filepath = realpath(dirname(__FILE__));

//获取文件
$filename = $_GET["path"];

//完整的上传路径
$upload_filepath = $filepath."/upload/".$filename;

//目标服务器地址
curl_setopt($ch, CURLOPT_URL, 'http://cdn-ms.juejin.im/v1/upload?bucket=gold-user-assets');

//设置上传的文件
curl_setopt($ch, CURLOPT_POST, true);
$data = array(
	'file' => new CURLFile($upload_filepath)
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//获取的信息以文件流的形式返回，而不是直接输出
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

echo curl_exec($ch);

//删除图片
unlink($upload_filepath);

// 解析JSON
// $arr_result = json_decode($result, true);
// $imgurl = $arr_result["url"];
// echo "{\"imgurl\":\"$imgurl\"}";

curl_close($ch);
?>