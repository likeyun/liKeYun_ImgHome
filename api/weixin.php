<?php

    // 编码
    header("Content-type:application/json");
     
    // 获取文件
    $file = $_FILES["file"]["name"];
     
    // 获取文件后缀名
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    
    // 上传目录
    $uploadDirectory = 'upload';
    
    // 重命名
    $newfile = uniqid() . '.' . $extension;
     
    // 允许上传的文件
    $fileType = $_FILES["file"]["type"];
    $allowedTypes = ["image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png"];
    
    if (in_array($fileType, $allowedTypes)) {
        
        // 允许上传的文件大小（10MB）
        if($_FILES["file"]["size"] <= 10485760) {
            
            // 可以上传
            move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDirectory. "/" . $newfile);
            
            // 当前文件在服务器的路径
            $filepath = realpath(dirname(__FILE__)) . "/" . $uploadDirectory . "/" . $newfile;
            
            // 上传到微信服务器
            $imgUrl = upload_img($filepath);
            
            // 验证上传结果
            if(strpos($imgUrl,'http') !== false){
                
                // 上传结果
                $result = array(
                    "code" => 200,
                    "msg" => "上传成功",
                    "path" => $imgUrl
                );
            }else{
                
                // 上传结果
                $result = array(
                    "code" => 201,
                    "msg" => "上传失败"
                );
            }
            
            // 删除临时文件
            unlink($filepath);
            
        }else {
            
            // 文件大小超出限制
            $result = array(
                "code" => 201,
                "msg" => "文件大小超出限制！最大只能上传10MB的文件！"
            );
        }
    } else {
        
        // 文件类型无效
        $result = array(
            "code" => 201,
            "msg" => "只允许上传gif、jpeg、jpg、png格式的图片文件！"
        );
    }
    
    // 获取access_token
    function getToken(){
        
        // 公众号appid和appsecret
        $appid='xxx'; // 更换为你的公众号的appid
        $appsecret='xxx'; // 更换为你的公众号的appsecret
        
        // 读取access_token
        include 'access_token.php';
        
        // 判断是否过期
        if (time() > $access_token['expires']){
            
            // 如果已经过期就得重新获取并缓存
            $access_token = array();
            $access_token['access_token'] = getNewToken($appid,$appsecret);
            $access_token['expires']=time()+7000;
            
            // 将数组写入php文件
            $arr = '<?php'.PHP_EOL.'$access_token = '.var_export($access_token,true).';'.PHP_EOL.'?>';
            $arrfile = fopen("./access_token.php","w");
            fwrite($arrfile,$arr);
            fclose($arrfile);
            
            // 返回当前的access_token
            return $access_token['access_token'];
        }else{
            
            // 如果没有过期就直接读取缓存文件
            return $access_token['access_token'];
        }
    }
    
    // 获取新的access_token
    function getNewToken($appid,$appsecret){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $access_token_Arr =  https_request($url);
        return $access_token_Arr['access_token'];
    }
    
    // curl
    function https_request ($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $out = curl_exec($ch);
        curl_close($ch);
        return  json_decode($out,true);
    }
    
    // 上传图片素材
    function upload_img($realpath){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.getToken().'&type=image');
        $data = array(
        	'media' => new CURLFile($realpath)
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $upimg = curl_exec($ch);
        return json_decode($upimg)->url;
        curl_close($ch);
    }
    
    // 输出JSON
    echo json_encode($result, true);
    
?>
