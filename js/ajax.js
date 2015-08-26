/*===================================================
//发送搜索的函数
//获取参数，发送ajax
//===================================================*/
function showScholar(){
	//获取表格参数
	var f=$("mySearchForm");
	var kw=f.keyword.value;
	
	var since=f.since.value;
	var sortBy=f.sortBy.value;
	var page=f.page.value;
	var submit=f.submit.value;
	
	//如果没有输入关键词，则不查询；
	if(''==kw.replace(/\s/g, '')){
		alert('Please input at least one key word.');
		$("keyword").innerHTML="";
		$('keyword').select();
		return (false);
	}
	
	//等待界面
	$("schloar").innerHTML='玩命加载中...';
	
	//对url进行编码:包括用%20替换掉空格
	kw=encodeURIComponent(kw);//关键词OK
	submit=encodeURIComponent(submit);
	
	//组装url和参数
	var url="getScholarAPI.php";
	var postStr="keyword2="+kw+
			'&since='+since+
			'&sortBy='+sortBy+
			'&page='+page+
			'&submit='+submit;


	//获得ajax对象
	ajax=GetXmlHttpObject()
	if (ajax==null){
		alert ("您的浏览器不支持AJAX！");
		return;
	}

	//打开请求
	ajax.open("POST",url,true);
	//定义传输的文件HTTP头信息  
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");  
	
	//状态变化后的回调函数
	ajax.onreadystatechange=function(){
		if (ajax.readyState==4 && ajax.status==200){ 
			$("schloar").innerHTML=ajax.responseText;
		}else{
			$("schloar").innerHTML='请求失败。';
		}
	}
	//发送请求
	ajax.send(postStr);
}





/*===================================================
// below is my tool kit
//===================================================*/
//传入id返回对象
function $(s){
	if('object'==typeof(s)) return s;
	return document.getElementById(s);
}

//获得ajax对象
function GetXmlHttpObject(){
	var xmlHttp=null;
	try{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}catch (e){
		// Internet Explorer
		try{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}catch (e){
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}


//若干秒后自动跳转
function countDown(secs,surl){     
	//alert(surl);
	secs=secs||3;//默认值
	var jumpTo = document.getElementById('jumpTo');
	jumpTo.innerHTML=secs;  
	if(--secs>0){    
		setTimeout("countDown("+secs+",'"+surl+"')",1000);     
	}else{       
		location.href=surl;     
	}     
} 