<?php
//https://www.economist.com/sites/default/files/images/print-edition/20190615_CNP003_1.jpg

print("note: www.xx.com?url=https://xx.com/xx2.png <hr>");

if(!empty($_GET['url'])){
	$file_url = $_GET['url'];
}else{
	$file_url = "https://www.baidu.com/img/bd_logo1.png";
}

echo "file_url=".$file_url."<br><pre>";

//1. 使用file_get_contents
function downloadfile($file_url, $save_to){
	$content = file_get_contents($file_url);
	//print_r($content);
	file_put_contents($save_to, $content);
}

$arr=explode("/",$file_url);
$n=count($arr)-1;
$save_to=$arr[$n];

echo "save_to=".$save_to."<br>";


downloadfile($file_url, "img/".$save_to);

echo "<img src=img/".$save_to." />";