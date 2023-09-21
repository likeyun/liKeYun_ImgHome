# 第三方图床

liKeYun聚合图床是一个第三方图片服务器图片上传工具，为个人网站运营者提供图片储存，图片外链生成。图片均上传至一些知名站点，长期维护。

# 图片上传API

目前有京东、阿里、360、微信、TCL的上传渠道。

# 使用方法

上传到服务器后，访问`index.html`

其中360.php、jd.php、ali.php需要登录后获取cookie并配置到源码中才可以使用。

**如何获取Cookie？** <br/>
以360图床的源站为例，打开360的图床抓包的页面，登录后，F12打开开发者工具，点击console进入控制台，输入：
```
document.cookie
```
即可弹出cookie<br/>

<img src="http://p15.qhimg.com/t01ea45ccfcf4c79b5d.jpg" />

然后将cookie配置到源码中：<br/>
<img src="https://img10.360buyimg.com/imgzone/jfs/t1/166188/6/40783/31612/650c1b4fFf8a35649/37213efccb6d4131.jpg" />
