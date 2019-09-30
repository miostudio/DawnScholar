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


//组装url参数，请求并获得google scholar
//$url="http://www.google.com.hk/search?ie=UTF-8&q=武汉";
if(isset($data['keyword'])){
	$kw=$data['keyword']; myLog($kw);//记录日志
	//$keyword2=urlencode($keyword1);
	//todo 调试
	//echo '<hr>'.$keyword1,' <hr> '.$a;	die();

	//获取其他参数
	$since=$data['since'];
	$sortBy=$data['sortBy'];

	$page=$data['page'];
	//设定page的范围
	$page=$page<=10?$page:10;
	$page=$page>=1?$page:1;

	$url="https://scholar.google.com/scholar?";

	//定义页码
	if($page>1){
		//$url .= '&start=' . ($page-1) . '0';
		$url .= "&start=".($page-1)*10;
	}

	//加关键词
	$url .= "ie=UTF-8&q=$kw";

	//是否限制时间：年份
	if($since!=0){$url .= "&as_ylo=" . $since;}
	if($sortBy==1){$url .= "&scisbd=1";}
}else{
	$url="https://scholar.google.com/";
};

//测试是否组装好url
if(DEBUG_MODE){
	echo "<pre>"; echo "<hr>$url<hr>"; var_dump($_POST);
	echo "<hr>"; print_r($_POST); //die();
}


#$url="https://www.showmyip.com/";
$arr=array(
	'status'=>"ok", 
	'msg'=>"a msg here;", 
	'kw'=>urldecode( $data['keyword'] ),
	'page'=>$page,
	'url'=>$url,
	#'html'=>'html <a>code here</a>',#curl_get_contents($url),
	'html'=>curl_get_contents($url),
);
echo json_encode( $arr );

#


