<?php
header("Content-type: text/html; charset=utf-8"); 
error_reporting(E_ALL);
ini_set("display_errors","On");

require 'common/function.php';
//v2.0微调，增加hidden input
?>

<head>
<title>LoadPage - v0.3.5-2</title>
<link rel="stylesheet" href="css/scholarPage.css">
<style>
#myWrap{width:1000px; margin:35px auto;  }
#mySearchLogo{
	padding:5px;
	margin:5px auto;
	width:100%;
	font-family:"Microsoft YaHei";
}
#mySearchResult input[type="text"]{width:60%; border:1px solid #0096ff;
	height:40px;
	padding:0 7px;
}
#mySearchResult input[type="submit"]{width:100px; border:1px solid #0096ff;
	height:40px;
}

#gs_nml{
	display:none;
}
</style>
</head>

<body>
<div id=myWrap>
<form method="POST" target="" id=mySearchResult onsubmit="return checkForm()">
	<b id="mySearchLogo">
	Web URL:
	</b>
	<input type="text" name="keyword" value="<?php 
	if(isset($_POST['keyword2'])){
		echo ascii2str($_POST['keyword2']);
	}
	?>">
	<input type="submit" name="submit" class=btn value="Load Page">
</form>

<span class=lighter>Example URL: https://www.google.com/search?q=Snap+shares+soar+back+above+IPO+price+as+turnround+takes+hold</span><br>
<script>
//string2ascii
function string2ascii(str){
        num=[]
        for(var i=0;i<str.length;i++){
                num.push(str.charCodeAt(i))
        }
        return(num.join('_') )
}

//js提交表单
function checkForm(){
    var form = document.getElementById('mySearchResult');
    //form['keyword2'].value = string2ascii(form['keyword'].value) 
	
	//新建表单
	var temp = document.createElement('form');
    temp.action = '';
    temp.method = 'post';
    temp.style.display = 'none';
	// 新建域
	opt = document.createElement('input');
	opt.name = "keyword2";
	opt.value = string2ascii(form['keyword'].value);
	//加入到文档结构
	temp.appendChild(opt);
	document.body.appendChild(temp);
	temp.submit();//提交新临时表单
	//原表单不提交
    return false;
}
</script>


<?php
/*/$url="http://www.google.com.hk/search?ie=UTF-8&q=武汉";
if(isset($_POST['keyword'])){
	$keyword=$_POST['keyword'];
	$btn=$_POST['submit'];
	if('Scholar'==$btn){
		//$url="http://scholar.google.com/search?ie=UTF-8&q=$keyword";
		//$url="http://scholar.google.com.cn/scholar?q=%E7%BB%9F%E8%AE%A1";
		$url="http://scholar.google.com.cn/scholar?ie=UTF-8&q=$keyword";
	}else{
		//$url="http://www.baidu.com/s?ie=UTF-8&wd=$keyword";
		$url="http://www.google.com/search?ie=UTF-8&q=$keyword";
	}
}else{
	$url="http://scholar.google.com.cn/";
};
*/
if(isset($_POST['keyword2'])){
	$url2=$_POST['keyword2'];
	if(trim($url2)==""){
		die("Pls input the URL");
	}
}else{
	die("Pls input the URL");
}
// 从ascii还原url为string
$url=ascii2str($url2);
echo $url."<hr>"; //debug


$ch = curl_init();
 
//设置选项，包括URL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

//$headers = ['User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.142 Safari/537.36']; //设置一个你的浏览器agent的header
//curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
$headers = array(
    #'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9) Gecko/2008052906 Firefox/3.0',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36',
    'Referer: https://www.baidu.com',
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
}
curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer

curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 40);

curl_setopt($ch, CURLOPT_HEADER, false); // 查询显示返回的Header区域内容 //返回response头部信息
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回 //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。

curl_setopt($ch, CURLINFO_HEADER_OUT, true); //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header
curl_setopt($ch, CURLOPT_REFERER, 'https://www.baidu.com');
//curl_setopt($ch, CURLOPT_SSLVERSION, 2);


try {
	//执行并获取HTML文档内容
	$output = curl_exec($ch);

	//获取错误编码
	$curlErrno = curl_errno($ch);
	if ($curlErrno) {
		throw new Exception(curl_error($ch) . '(' . $curlErrno . ')' . date('Y-m-d H:i:s',time()) );
	}


	//释放curl句柄
	curl_close($ch);
	 
	//打印获得的数据
	print_r($output);
} catch (\Exception $e) {
	echo $e->getMessage();
}

/*
	$handle = fopen($url, "rb");

    $contents = '';
	if(!$handle){
		die("文件打开失败！");
	}
     while (!feof($handle)) { 
         $contents .= fread($handle, 8192); 
     }
	 echo $contents;
     fclose($handle); 
*/
?>

</div>
</body>