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
**即可弹出cookie** <br/>

<img src="http://p15.qhimg.com/t01ea45ccfcf4c79b5d.jpg" />

**然后将cookie配置到源码中：** 
<img src="https://sc01.alicdn.com/kf/H81918f5a89e844a9a5115206143532e4r.png" />

将XXX替换为获取到的cookie即可，注意，单引号不需要复制。

# 界面
<img src="https://sc01.alicdn.com/kf/Hbff92229f08c47be84e5875d633b9537D.png" />
<img src="https://sc01.alicdn.com/kf/H8588d4d1f2ca49889dd56822b432536bh.png" />

# 用到的技术
前端：Vue.js 2.6.14、axios、element-ui
后端：php

# 声明
仅供个人学习，请勿用于非法用途，法律风险自负。
