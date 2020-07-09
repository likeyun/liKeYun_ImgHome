<?php
header("Content-type:application/json");
 
//获取原始文件名
$file = $_FILES["file"]["name"];
 
//获取文件后缀名
$hzm = substr($file,strpos($file,"."));
 
//设置新文件名
$newfile = md5($file);
 
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $file);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts))
{
    //上传失败
    if ($_FILES["file"]["error"] > 0)
    {
        $result = array(
            "code" => 404,
            "msg" => "上传失败"
        );
    }
    else
    {
        //上传成功
        move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfile.$hzm);

        //获取当前目录绝对路径
        $filepath = realpath(dirname(__FILE__));

        //完整的上传路径
        $upload_filepath = $filepath."/upload/".$newfile.$hzm;

        //初始化CURL，上传到远程服务器
        $ch = curl_init();

        //目标服务器地址 
        curl_setopt($ch, CURLOPT_URL, 'http://mp.toutiao.com/upload_photo/?type=json');

        //设置上传的文件
        curl_setopt($ch, CURLOPT_POST, true);
        $data = array('photo' => new CURLFile($upload_filepath));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        //获取的信息以文件流的形式返回，而不是直接输出
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //发起请求
        $uploadimg = curl_exec($ch);

        //解析JSON
        $arr_result = json_decode($uploadimg, true);
        $imgurl = $arr_result["web_url"];

        //关闭请求
        curl_close($ch);
        $result = array(
            "code" => 200,
            "msg" => "上传成功",
            "path" => $imgurl
        );

        //删除临时文件
        unlink($upload_filepath);
    }
}
else
{
    //格式不对
    $result = array(
        "code" => 403,
        "msg" => "格式不符合规则"
    );
}

//输出json
echo json_encode($result,true);
?>
