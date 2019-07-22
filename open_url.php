<?php
header("Content-type: text/html; charset=utf-8"); 
?>

<head>
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
<form method="POST" target="" id=mySearchResult>
<b id="mySearchLogo">
Web URL:
</b>
<input type="text" name="keyword" value="<?php 
if(isset($_POST['keyword'])){
	echo $_POST['keyword'];
}
?>">
<input type="submit" name="submit" class=btn value="Load Page">
</form>



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
if(isset($_POST['keyword'])){
	$url=$_POST['keyword'];
	if(trim($url)==""){
		die("Pls input the URL");
	}
}else{
	die("Pls input the URL");
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
</body>