<?php

/**
 * 图片跳板
 * 用于绕过防盗链
 */

 class ImgBridge{
    private $water='';
    private $imgUrl=''; 
    private $referer='';
    private $ua='MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';
    private $imgCode='';
    private $imgHeader='';
    private $imgBody='';
    private $imgType='';

    public function __construct($config=array()){
        foreach($config as $key=>$value){
            $this->$key=$value;
        }
    }
    
    public function getImg($imgUrl){
        $this->imgUrl=$imgUrl;
        /** 处理url */
        if(substr($this->imgUrl,0,7)!=='http://' && substr($this->imgUrl,0,8)!=='https://'){
            $this->imgUrl='http://'.$this->imgUrl;
        }
        /** 解析url中的host */
        $url_array=parse_url($this->imgUrl);
        /** 设置referer */
        $this->referer=$this->referer==""?'http://'.$url_array['host']:$this->referer;
        /**开始获取 */
        $this->urlOpen();
        $this->imgBody;
        /**处理错误 */
        if($this->imgCode!=200){
            $this->error(1);
            exit();
        }
        
        /**获取图片格式 */
        preg_match("/Content-Type: image\/(.+?)\n/sim",$this->imgHeader,$result);
        /**看看是不是图片 */
        if(!isset($result[1])){
            $this->error(2);
            exit();
        }else{
            $this->imgType=$result[1];
        }
        /** 输出内容 */
        $this->out();        
    }
    private function out(){
        /** gif 不处理，直接出图 */
        if($this->imgType=='gif'){
            header("Content-Type: image/gif");
            echo $this->imgBody;
            exit();
        }
        header("Content-Type: image/png");
        /** 其他类型的，加水印 */
        $im=imagecreatefromstring($this->imgBody);
        $white = imagecolorallocate($im, 255, 255, 255);
        /*加上水印*/
        if($this->water){
            imagettftext($im, 12, 0, 20, 20, $white, "/fonts/hwxh.ttf", $this->water);            
        }
        imagepng($im);
        
    }
    private function error($err){
        header("Content-Type: image/jpeg");
        $im=imagecreatefromstring(file_get_contents('./default.jpg'));
        imagejpeg($im);
    }

    private function urlOpen()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->imgUrl);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->ua);
        curl_setopt ($ch,CURLOPT_REFERER,$this->referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        /**跳转也要 */
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        /**  支持https */
        $opt[CURLOPT_SSL_VERIFYHOST] = 2;
        $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
        curl_setopt_array($ch, $opt);
        $response = curl_exec($ch);
        $this->imgCode=curl_getinfo($ch, CURLINFO_HTTP_CODE) ;
        if ($this->imgCode == '200') {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $this->imgHeader = substr($response, 0, $headerSize);
            $this->imgBody = substr($response, $headerSize);
            return ;
        }
        curl_close($ch);
    }

 }

 $img=new ImgBridge(array('water'=>''));
 $img->getImg(strstr($_SERVER["QUERY_STRING"], "http"));