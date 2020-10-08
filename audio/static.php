<?php
/** 如果有list，则看文件，否则返回文件
* v2.0 支持外链，就要把header("Access-Control-Allow-Origin: *");写到前面
* v2.1 文件倒序排列
*/
//重新定义header，允许外链
header('Server: suctom-server',true);
//header('HTTP/1.1 200 OK');
header('Server: WJL_audio_server/0.4');
header('Email: jimmymall@163.com');
header('Content-Type:text/html;charset=UTF-8');//html文件类型,UTF-8类型
header("Access-Control-Allow-Origin: *");


//接收参数
$file_dir='./';
if(isset($_GET['dir'])){
	$file_dir=$_GET['dir'];
}


//使用PHP5面向对象的写法,获取文件名列表，按照时间倒序排列
//https://www.cnblogs.com/hltswd/p/6279824.html
//v1.2
function getFileList($directory){
	$files = array();
	try {
		$dir = new DirectoryIterator($directory);

	} catch (Exception $e) {
		throw new Exception($directory . ' is not readable');
	}
	foreach($dir as $file) {
		if($file->isDot()) continue;
		//print_r($file);
		$files[$file->getFileName()]=$file->getCTime();
	}
	//
	arsort($files);
	return $files;
}


//如果指定文件名
if(isset($_GET['file'])){
	$file_name=$_GET['file'];
}else{
	//如果没有指定文件名，则默认查找并返回json文件
	$files=array_keys(getFileList('./') );
	//解决中文乱码
	for($i=0; $i<count($files);$i++){
		$files[$i] = iconv("GBK", "UTF-8", $files[$i]);
	}	
	echo json_encode($files);
	die();
}


//检查文件是否存在
//解决编码问题，在window上
if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
	$file_dir = iconv("UTF-8","GBK",  $file_dir);
	$file_name = iconv("UTF-8","GBK", $file_name);
}
if (! file_exists ( $file_dir . $file_name )) {
	print('<pre>file_dir=' . $file_dir .'<br>');
	print('file_name='.$file_name);
	die('<hr>No file found.');
    //header('HTTP/1.1 404 NOT FOUND'); 
} else {
    //以只读和二进制模式打开文件  
    $file = fopen ( $file_dir . $file_name, "rb" );
     
    //告诉浏览器这是一个文件流格式的文件   
    //Header ( "Content-type: application/octet-stream" );
    //请求范围的度量单位 
    Header ( "Accept-Ranges: bytes" ); 
    //Content-Length是指定包含于请求或响应中数据的字节长度   
    Header ( "Accept-Length: " . filesize ( $file_dir . $file_name ) ); 
    //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
    Header ( "Content-Disposition: attachment; filename=" . $file_name );   
 
    //读取文件内容并直接输出到浏览器   
    echo fread ( $file, filesize( $file_dir . $file_name ) );   
    fclose ( $file );
    exit ();
}