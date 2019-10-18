<?php
/** 如果有list，则看文件，否则返回文件
*/

//接收参数
$file_dir='./';
if(isset($_GET['dir'])){
	$file_dir=$_GET['dir'];
}


//使用PHP5面向对象的写法,获取文件名列表
function getFileList($directory) {
	$files = array();
	try {
		$dir = new DirectoryIterator($directory);
	} catch (Exception $e) {
		throw new Exception($directory . ' is not readable');
	}
	foreach($dir as $file) {
		if($file->isDot()) continue;
		$files[] = $file->getFileName();
	}
	return $files;
}



//如果指定文件名
if(isset($_GET['file'])){
	$file_name=$_GET['file'];
}else{
	//如果没有指定文件名，则默认查找并返回json文件
	echo json_encode(getFileList($file_dir));
	die();
}




header('Server: suctom-server',true);
//header('HTTP/1.1 200 OK');
header('Server: WJL_audio_server/0.4');
header('Email: jimmymall@163.com');
//header('Content-Type:text/html;charset=UTF-8');//html文件类型,UTF-8类型
header("Access-Control-Allow-Origin: *");


//检查文件是否存在
if (! file_exists ( $file_dir . $file_name )) {   
    header('HTTP/1.1 404 NOT FOUND'); 
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