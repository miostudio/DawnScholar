<?php
//函数库

/**
* 如果没有值，就用默认值
*/
function myIsset($para,$default,$method='request'){
	if('get'==$method){
		return isset($_GET[$para])? $_GET[$para]:$default;
	}
	if('post'==$method){
		return isset($_POST[$para])? $_POST[$para]:$default;
	}
	if('request'==$method){
		return isset($_REQUEST[$para])? $_REQUEST[$para]:$default;
	}
	//如果不是以上，则返回错误
	return false;
}


/**
* 调试类和对象
*/
function myDebug($var, $classOrInstance=''){
	if(!DEBUG_MODE) return;
	
	echo "<pre>";
	echo 'print_r($var);<br>';
	print_r($var);
	echo '<hr>';
	echo 'var_dump($var);<br>';
	var_dump($var);
	echo '<hr>';
	
	if('instance'==$classOrInstance or 'i'==$classOrInstance){
		echo "<br>get_class<br>";
		print_r(get_class($var));
		
		echo "<br>get_object_vars<br>";
		print_r(get_object_vars($var));
		
		echo "<br>get_parent_class<br>";
		print_r(get_parent_class($var));
	}elseif('class'==$classOrInstance or 'c'==$classOrInstance){
		echo "<br>get_class_methods<br>";
		print_r(get_class_methods($var));
		
		echo "<br>get_class_vars<br>";
		print_r(get_class_vars($var));
	}
	echo '<hr>';
}

/**
记录日志信息
*/
function myLog($keyWord=''){
	$agent=$_SERVER["HTTP_USER_AGENT"];
	//引入用户信息类
	include('common/myAgentInfo.class.php');
	$u=new myAgentInfo();

	$browser=$u->getBrowser_2();
	$os=$u->getOS_3();
	$ip=$u->getIP();

	//记录时间
	date_default_timezone_set('PRC');
	$time=date('Y-m-d H:i:s',time());
	//写入日志
	$fh=fopen('my_log.txt','a');
	fwrite($fh,"\r\n===============================\r\n");
	fwrite($fh,"{$time}------IP: {$ip}\r\n");
	fwrite($fh,"-------------------------------\r\n");
	fwrite($fh,$agent."\r\n");
	fwrite($fh,"-------------------------------\r\n");
	fwrite($fh,"{$os}\r\n");
	fwrite($fh,"{$browser}\r\n");
	fwrite($fh,"-------------------------------\r\n");
	fwrite($fh,"keyWord: {$keyWord}\r\n");
	fwrite($fh,"===============================\r\n");
	fclose($fh);

}


// show file list in this dir
function tree(&$arr_file, $directory, $dir_name='')
{
 
    $mydir = dir($directory);
    while($file = $mydir->read())
    {
        if((is_dir("$directory/$file")) AND ($file != ".") AND ($file != ".."))
        {
            tree($arr_file, "$directory/$file", "$dir_name/$file");
        }
        else if(($file != ".") AND ($file != ".."))
        {
            $arr_file[] = "$dir_name/$file";
        }
    }
    $mydir->close();
}

// 下载文件函数
function downloadfile($file_url, $save_to){
	$content = file_get_contents($file_url);
	//print_r($content);
	file_put_contents($save_to, $content);
}


// ascii2str
function ascii2str($ascii_url){
        $arr=explode("_",$ascii_url);
        #print_r($arr);
        
        $url="";
        for ($x=0; $x<count($arr); $x++) {
                $url.=chr($arr[$x]);
        }
        //echo "url=$str<br>";
        return $url;
}
