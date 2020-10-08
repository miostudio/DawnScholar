<?php
header("Content-type: text/html; charset=utf-8"); 
error_reporting(E_ALL);
ini_set("display_errors","On");

require 'common/function.php';
//v2.0微调，增加hidden input
?>

<head>
<title>LoadPage - v0.3.5</title>
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


	$handle = fopen($url, "rb", false);

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