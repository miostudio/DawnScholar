<?php
header("Content-type: text/html; charset=utf-8"); 
define('DEBUG_MODE',true);//是否开启调试模式
require 'common/function.php';//引用库

if(!isset($_POST['submit'])){ 
	echo ('<h1>Access Denied!</h1><h2>Jump to <a href="index.php">Home</a> page in <span id=jumpTo style="color:red"></span> second(s).</h2>');
	echo "<script type='text/javascript' src='js/ajax.js'></script>
	<script>countDown(3, 'index.php');</script>";
	die();
}

//组装url参数，请求并获得google scholar
//$url="http://www.google.com.hk/search?ie=UTF-8&q=武汉";
if(isset($_POST['keyword2'])){
	$keyword1=$_POST['keyword2'];  myLog($keyword1);//记录日志
	$keyword2=urlencode($keyword1);
	
	//todo 调试
	//echo '<hr>'.$keyword1,' <hr> '.$a;	die();
	
	//获取其他参数
	$since=myIsset('since',0);
	$sortBy=myIsset('sortBy',0);
	$page=myIsset('page',1);

	//设定page的范围
	$page=$page<=10?$page:10;
	$page=$page>=1?$page:1;
	
	$url="http://scholar.google.com/scholar?";
	
	//定义页码
	if($page>1){$url .= '&start=' . ($page-1) . '0';}
	
	//加关键词
	$url .= "ie=UTF-8&q=$keyword2";
	
	//是否限制时间：年份
	if($since!=0){$url .= "&as_ylo=" . $since;}
	if($sortBy==1){$url .= "&scisbd=1";}
}else{
	$url="http://scholar.google.com/";
};

//测试是否组装好url
if(DEBUG_MODE){
	echo "<pre>"; echo "<hr>$url<hr>"; var_dump($_POST);
	echo "<hr>"; print_r($_POST); die();
}


//打开网页
	$handle = fopen("$url", "rb");

    $contents = '';
	if(!$handle){
		die("文件打开失败！");
	}
     while (!feof($handle)) { 
         $contents .= fread($handle, 8192); 
     } 
	 echo $contents;
     fclose($handle); 
?>