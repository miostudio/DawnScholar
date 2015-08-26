# A scholar search engine cross GFW.
For those who need scholar search in mainland China.
url：http://dawn.16mb.com/google/ 

The most update version now is version0.3.

 = You can put the files on a PHP server out side the GFW.
 = Then you can use Google Scholar freely.
 = V0.3 is based on ajax, so it's easy to use.



# V0.3
 - 1.We reconstructed the whole app based on ajax, it will refresh the needed part which will promote the user's experience.
 - 2. We extract php and js code to outer file libary, which makes it much easier to read the code;
 - 3.Record user IP, browser info, OS info and keyword(s) to my_log.txt;
 - 4.增加了站长统计功能；
 - 5.增加了微信公众号[拂晓学术]和微博账号[DawnScholar]，为推广做准备；
 - 6.代码托管到github，命名为DawnScholar项目；
 - 7 在getScholarAPI.php文件中有一个debug开关；



# V0.2.5
 - 实现基本功能：学术搜索，年份，排序，翻页等。
 - 但是不够优雅 -> 打算用ajax实现以下；
 - 易用性不好 -> 重新排版。

