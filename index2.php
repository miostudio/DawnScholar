<!DOCTYPE html>
<html>
<head>
<title>Dawn scholar v0.3.0</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<!-- Bootstrap -->
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<style>
body{padding:0; margin:0; font-family:"Microsoft YaHei";}
div,input {vertical-align:middle}/*css里面文本框和按钮对不齐*/

#myWrap{width:1000px; margin:35px auto;  }
#mySearchLogo{
	padding:5px;
	margin:5px auto;
	width:100%;
	font-family:"Microsoft YaHei";
}
#mySearchResult{margin:0 30px;}
#mySearchResult input{border:1px solid #0096ff; height:40px;}
#mySearchResult input[type="text"]{width:70%; }
#mySearchResult input[type="submit"]{width:100px;}

#gs_nml{
	display:none;
}




.card{
	background: #0096ff;
    width: 100px;
    position: relative;
    margin: 2em 2em;
    padding: 15px;
    box-shadow: 0px 3px rgba( 0, 0, 0, 0.1);
    color: #E8E8E8;
    font-size: 14px;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
	

}
.card.announce {
    position: absolute;
    margin: 2em 5px;
    right: 0;
    top: 0;
}
.card a{
	color:#fff;
}
.light{
	background-color: #f8f8f8;
	color: #222;
    border: 1px solid #c6c6c6;
}

#erWeiMa{
	position:absolute;
	top:30px;
	padding:5px;
}
#erWeiMa img{width:120px; }


</style>
</head>
<body>



<div id="url_info" class='card announce'>
	<b>Basic版</b><h2>永久免费</h2>
	<br><a href="scholar/help.php" target="_blank" title="帮助">帮助文档</a>.
</div>

<div id='erWeiMa'>
	<img src='scholar/images/fxxsEWM.jpg' /><br>
	<b>扫一扫关注微信号</b>
</div>








<div id=myWrap>
<form method="POST" target="" id=mySearchResult>
	<b id="mySearchLogo">
	Dawn Search:
	</b>
	<input type="text" name="keyword" value="<?php 
	if(isset($_POST['keyword'])){
		echo $_POST['keyword'];
	}
	?>">
	<input type="submit" name="submit" value="Scholar">
</form>


<div class="container" style='margin:15px 0;'>


	<div class="jumbotron">
		<h1>当前为Basic版</h1>
		<p>Basic版不能检索多个关键词, 不能翻页, 不能选择年份.</p>
		<p>   
		更好体验请 <a href='scholar/index.php' type="button" class="btn btn-lg btn-danger">登录Pro版</a> scholar search.</p>
	</div>

 

	

<?php
require 'scholar/common/function.php';
define('DEBUG_MODE',true);

//$url="http://www.google.com.hk/search?ie=UTF-8&q=武汉";
if(isset($_POST['keyword'])){
	$keyword=$_POST['keyword'];
		 myLog('[Basic]'.$keyword);//登陆日志
	$url="http://scholar.google.com.cn/scholar?ie=UTF-8&q=$keyword";
}else{
	$url="http://scholar.google.com.cn/";
		myLog('[Basic] visit');//登陆日志
};

if(isset($_POST['keyword'])){
	$keyword=$_POST['keyword']; 
	if(trim($keyword)==""){
		die("Please input the keyword");
	}
}else{
	die("Please input the keyword");
}


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
?>

</div>

<style>
#gs_hdr,#gs_ab_rt,#gs_gb,#gs_lnv,#gs_n,#gs_ftr,
#gs_hp_main #gs_hp_tsi {display:none;}

#gs_ccl { margin-left: 10px;}
</style>


<div style='text-align:center;' role="contentinfo">
	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256189537'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/stat.php%3Fid%3D1256189537%26online%3D1%26show%3Dline' type='text/javascript'%3E%3C/script%3E"));</script> | 

	<a href="help.php">About Dawn Scholar</a> | 
	<a href="../index.php">Home page</a> 
</div>
</div>
</body>