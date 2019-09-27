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

//发出curl请求
function curl_get_contents($url = '', $ispost = 0, $post_data = array())
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	
	//curl_setopt($ch,CURLOPT_REFERER,"https://www.google.com");//伪造来源地址
    //curl_setopt($ch,CURLOPT_COOKIESESSION,true); //能保存cookie
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    //curl_setopt($ch, CURLOPT_PROXY, 'https://120.55.40.41:80');//伪造请求IP,可以为要请求的网站ip
	
	#
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); // 设置超时限制防止死循环
    curl_setopt($ch, CURLOPT_HEADER, 0); // 查询显示返回的Header区域内容
	//CURLOPT_RETURNTRANSFER 为true，它就将使用PHP curl获取页面内容或提交数据，作为变量储存，而不是直接输出。
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
	
    if ($ispost)
    {        
        curl_setopt($ch, CURLOPT_POST, $ispost);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    $output = curl_exec($ch);
	// 返回一个保护当前会话最近一次错误的字符串
	$error = curl_error($ch);
	if($error){
		return 'Error: '.$error;
	}
    curl_close($ch);
    return $output;
}