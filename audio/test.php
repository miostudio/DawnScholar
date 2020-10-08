<?php 

//使用PHP5面向对象的写法,获取文件名列表，按照时间倒序排列
//https://www.cnblogs.com/hltswd/p/6279824.html
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

$files1=getFileList('./');
$files2=array_keys( $files1 );
print('<pre>');
print_r( $files1 );
print_r( $files2 );