<?php
header('Content-Type:application/json; charset=utf-8'); #返回json
#header("Content-type: text/json; charset=utf-8"); 
define('DEBUG_MODE',false);//是否开启调试模式
require 'common/function.php';//引用库

$data=file_get_contents('php://input') ; //获取非表单数据;
$data = (array)json_decode( $data );// 并转为json对象

//echo json_encode($data); die();

if(!isset($data['submit'])){ 
	echo ('<h1>Access Denied!</h1><h2>Jump to <a href="index.php">Home</a> page in <span id=jumpTo style="color:red"></span> second(s).</h2>');
	echo "<script type='text/javascript' src='js/ajax.js'></script>
	<script>countDown(3, 'index.php');</script>";
	die();
}

$kw=$data['keyword']; myLog($kw);
$page=$data['page'];


//设定page的范围
$page=$page<=10?$page:10;
$page=$page>=1?$page:1;


#$kw2=urldecode( $kw );
//构造url
//$url="https://www.baidu.com/s?wd=".$kw;
$url="https://www.google.com/search?q=".$kw;
if($page>=2){
	$url=$url."&start=".($page-1)*10;
}

//$url="https://cn.bing.com/search?q=".$kw;
//$url="https://www.bing.com/search?q=".$kw;

#$url="https://www.showmyip.com/";
$arr=array(
	'status'=>"ok", 
	'msg'=>"a msg here;", 
	'kw'=>urldecode( $data['keyword'] ),
	'page'=>$page,
	'url'=>$url,
	#'html'=>'html <a>code here</a>',#curl_get_contents($url),
	'html'=>curl_get_contents($url),
	#'kw'=>urlencode( ascii2str($data['keyword'])  )
);
echo json_encode( $arr );

#


