<?php
header("Content-type: text/html; charset=utf-8"); 
error_reporting(E_ALL);
ini_set("display_errors","On");

require '../common/function.php';

/*
local: http://scholar.wjl.com/audio/
server: http://a2.biomooc.com/audio/
* v2.0微调，增加hidden input
* v0.3.6 可以下载静态文件，并可以外链了
* v0.3.7 排序，按照时间倒序排序
*/
?>

<head>
<title>Index and-or getAudio - v0.3.6</title>
<link rel="stylesheet" href="../css/scholarPage.css">
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

/*链接样式*/
a {
    color:#0593d3; /*#366799;*/
    text-decoration: none;
}
a:hover {text-decoration: underline;}
</style>
</head>

<body>
<div id=myWrap>
<form method="POST" target="" id=mySearchResult onsubmit="return checkForm()">
	<b id="mySearchLogo">Audio URL:</b>
	<input type="text" name="keyword" value="<?php 
	if(isset($_POST['keyword2'])){
		echo ascii2str($_POST['keyword2']);
	}
	?>">
	<input type="submit" name="submit" class=btn value="Download">
</form>


<p style="color:#ccc">1.It will take at least 5s to download the audio file.<br>
2.URL format:  https://downdb.51voa.com/201908/icrc-laws-war-remain-relevant-today-despite-new-challenges.mp3</p>


<script>
//外链点击提醒右击
function outer(event){
	alert('请右击-复制链接！');
	event.preventDefault();
	return false;
}


//string2ascii
function string2ascii(str){
        num=[]
        for(var i=0;i<str.length;i++){
                num.push(str.charCodeAt(i))
        }
        return(num.join('_') )
}

//去除前后的空格
function trim(str){ 
 return str.replace(/(^\s*)|(\s*$)/g, ""); 
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
	opt.value = string2ascii( trim(form['keyword'].value) );//去除两端空格
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



//打印当前文件
function printDir(){
	//$arr_file = array();
	//tree($arr_file, "./");
	$arr_fileR=getFileList('./');
	$arr_file=array_keys( $arr_fileR );

	echo '<hr>Useful links: ';
	echo '<a target="_blank" href="http://ielts.biomooc.com/listening/player.html">AB复读机</a> | ';
	//<a target=_blank href='https://www.51voa.com/'>https://www.51voa.com/</a>
	echo '<a target="_blank" href="https://www.51voa.com/">51voa</a> | ';
	echo '<a target="_blank" href="https://www.scientificamerican.com/podcast/60-second-science/">科学60秒</a> | ';
	echo '<a target="_blank" href="https://www.mprnews.org/arts/art-hounds">art-hounds</a> | ';
	echo '<a target="_blank" href="static.php">查看文件API</a> | <hr>';
	
	print('Available Audio on the server:<br>');
	//循环打印外链地址
	for ($x=0; $x<count($arr_file); $x++) {
		//$fname2=substr($arr_file[$x],1);
		$fname2=$arr_file[$x];
		$fname2 = iconv("GBK", "UTF-8", $fname2);//防中文乱码
		
		$arr=explode('.', $fname2);		
		if( array_pop( $arr )!="php"){
			$outer='//'.$_SERVER['HTTP_HOST'].'/audio/static.php?file='.$fname2;
			echo $x." <a target=_blank href=".$fname2.'>audio/'.$fname2."</a>"." [<a href=".$outer." onclick='outer(event)'>右击复制外链</a>]<br>";
		}
	}
}


if(isset($_POST['keyword2'])){
	$url=$_POST['keyword2'];
	if(trim($url)==""){
		printDir();
		die("Pls input the URL");
	}
}else{
	printDir();
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
echo "4.Save_to <a target=_blank href=./".$save_to.">$save_to</a><br>";
downloadfile($file_url, "./".$save_to);

//3.show Nothing.
//sleep(5); //sleep for download

//4. show ./ file list
printDir();
?>
</div>
</body>