# A scholar search engine cross GFW.
For those who need scholar search in mainland China.
url：http://a.biomooc.com/ 
local: http://scholar.wjl.com/

The most update version now is version0.3.

 = You can put the files on a PHP server out side the GFW.
 = Then you can use Google Scholar freely.
 = V0.3 is based on ajax, so it's easy to use.




# V0.2.5
 - 实现基本功能：学术搜索，年份，排序，翻页等。
 - 但是不够优雅 -> 打算用ajax实现以下；
 - 易用性不好 -> 重新排版。


# V0.3
 - 1.We reconstructed the whole app based on ajax, it will refresh the needed part which will promote the user's experience.
 - 2. We extract php and js code to outer file libary, which makes it much easier to read the code;
 - 3.Record user IP, browser info, OS info and keyword(s) to my_log.txt;
 - 4.增加了站长统计功能；
 - 5.增加了微信公众号[拂晓学术]和微博账号[DawnScholar]，为推广做准备；
 - 6.代码托管到github，命名为DawnScholar项目；
 - 7 在getScholarAPI.php文件中有一个debug开关；


#v0.3.1 新增看新闻功能（原始v0.2.6）
1.使用 open_url.php 输入网址，复制新闻文字。并找到需要的图片链接
2.使用 getPic.php?url=https://www.XX.com/aa.png 下载图片，定期删除图片。
3.查看图片：http://a.biomooc.com/img/aa.png ，注意 文件名和url中的一致。


#v0.3.2 添加curl_init 下载图片 getPic2.php
1.图片显示前增加下载等待时间5s；

#v0.3.3 要把url编码成ascii，传到服务器后在解码成url getPic3.php
下载图片一直报错 Connection reset by peer) in headers
或者，使用ajax

#v0.3.4 getPic3.php 使用js新建表单，并提交。只post编码过的url，比较安全。
添加新hidden input，保证UI没有异常。不好，原始、编码过的url都post出去了。

#v0.3.5 美化提交按钮，底部添加链接
#v0.3.6 open_url2.php 也是用编码过的url传输。
#v0.3.7 首页更新底部地址 
#v0.3.8 实现谷歌搜索 
	index3.php, 后台是gg.php 谷歌搜索
#v0.3.9 重写谷歌学术搜索
	index.php, 后台是gs.php 谷歌学术
	index4.php, 后台是getScholarAPI.php 谷歌学术（旧）不好用
#v0.4.0 微调文字
#v0.4.1 添加audio/目录，下载音频文件，获取可外链的音频文件
v0.4.3 微调

##---> commit 
##-------------> git push origin
#todo: 支持回车搜索
#






url: http://a.biomooc.com/
http://a001usweb.uskg3.515ip.top/index.php
local: http://scholar.wjl.com/
