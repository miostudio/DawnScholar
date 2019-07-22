<p style="color:#ccc">1.It will take at least 5s to download the picture file.<br>

<?php
error_reporting(E_ALL);
ini_set("display_errors","On");


require 'common/function.php';
print("2.URL format: www.xx.com/getPic2.php?url=https://xx.com/xx2.png </p><pre>");


//1. get pic url
if(!empty($_GET['url'])){
	$file_url = $_GET['url'];
}else{
	$file_url = "https://www.baidu.com/img/bd_logo1.png";
}

echo "3.pic_url=".$file_url."<br>";
$arr=explode("/",$file_url);
$n=count($arr)-1;
$save_to=$arr[$n];



//2. download file using file_get_contents 
echo "4.Save_to <a target=_blank href=/img/".$save_to.">$save_to</a><br>";

$curl = curl_init($file_url);
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
$imageData = curl_exec($curl);
curl_close($curl);
$tp = fopen("img/".$save_to,"a");
fwrite($tp, $imageData);
fclose($tp);


//3.show img
sleep(5); //sleep for download
echo "<img src=img/".$save_to." /><br>";

//4. show /img/ file list
$arr_file = array();
tree($arr_file, "./img/");
print_r($arr_file);
