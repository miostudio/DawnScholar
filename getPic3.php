<?php
header("Content-type: text/html; charset=utf-8"); 
error_reporting(E_ALL);
ini_set("display_errors","On");

require 'common/function.php';
//v2.0微调，增加hidden input
?>

<head>
<title>getPic3 - v0.3.4</title>
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
	<b id="mySearchLogo">Picture URL:</b>
	<input type="text" name="keyword" value="<?php 
	if(isset($_POST['keyword2'])){
		echo ascii2str($_POST['keyword2']);
	}
	?>">
	<input type="submit" name="submit" value="Get">
</form>


<p style="color:#ccc">1.It will take at least 5s to download the picture file.<br>
2.Picture URL format: https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png </p>

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

<pre>
<?php
if(isset($_POST['keyword2'])){
	$url=$_POST['keyword2'];
	if(trim($url)==""){
		die("Pls input the URL");
	}
}else{
	die("Pls input the URL");
}

// 从ascii还原url为string
$file_url=ascii2str($url);

//获取最后的文件名
echo "3.pic_url=".$file_url."<br>";
$arr=explode("/",$file_url);
$n=count($arr)-1;
$save_to=$arr[$n];

//2. download file using file_get_contents 
echo "4.Save_to <a target=_blank href=/img/".$save_to.">$save_to</a><br>";
downloadfile($file_url, "img/".$save_to);

//3.show img
sleep(5); //sleep for download
echo "<img src=img/".$save_to." /><br>";

//4. show /img/ file list
$arr_file = array();
tree($arr_file, "./img/");

//循环打印成链接
for ($x=0; $x<count($arr_file); $x++) {
	echo $x." <a target=_blank href=img".$arr_file[$x].">img".$arr_file[$x]."</a><br>";
}
?>

</div>
</body>