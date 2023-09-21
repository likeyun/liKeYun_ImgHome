# 第三方图床

liKeYun聚合图床是一个第三方图片服务器图片上传工具，为个人网站运营者提供图片储存，图片外链生成。图片均上传至一些知名站点，长期维护。<br/><br/>
![](http://img.shields.io/badge/Vue.js-2.6.14-brightgreen.svg)
![](http://img.shields.io/badge/axios.js-0.21.4-brightgreen.svg)
![](http://img.shields.io/badge/ElementUI-2.15.3-brightgreen.svg)
![](http://img.shields.io/badge/VueClipboard2-0.3.3-brightgreen.svg)
![](http://img.shields.io/badge/PHP-7.4.3-brightgreen.svg)

# 图片上传API

目前有京东、阿里、360、微信、TCL的上传渠道。

# 使用方法

上传到服务器后，访问`index.html`

其中360.php、jd.php、ali.php需要登录后获取cookie并配置到源码中才可以使用。weixin.php需要配置公众号的appid和appsecret才可以使用。

**如何获取Cookie？** <br/>
以360图床的源站为例，打开360的图床抓包的页面，登录后，F12打开开发者工具，点击console进入控制台，输入：
```
document.cookie
```
**即可弹出cookie** <br/>

<img src="http://p15.qhimg.com/t01ea45ccfcf4c79b5d.jpg" />

**然后将cookie配置到源码中：** 
<br/>
<img src="https://img10.360buyimg.com/imgzone/jfs/t1/173580/16/40977/31220/650c3fccF4c18a559/e78249aaa9f9d2fb.jpg" />

将XXX替换为获取到的cookie即可，注意，单引号不需要复制。

# 界面
<img src="https://img10.360buyimg.com/imgzone/jfs/t1/218018/12/36503/19213/650c3f41F85549e87/6d83650ef2c71ea5.jpg" />
<img src="https://img10.360buyimg.com/imgzone/jfs/t1/90549/31/42966/27938/650c3f90F1fac44b9/4c2a97036426e422.jpg" />

# 声明
仅供个人学习，请勿用于非法用途，法律风险自负。
