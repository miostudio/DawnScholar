<!DOCTYPE html>
<html>
<head>
<title>Google Search - Dawn scholar v0.3.0</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-type" content="text/html;charset=utf-8">

<link rel="stylesheet" href="css/scholarPage.css">
<script type="text/javascript" src="js/ajax.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>


<script>
function string2ascii(str){
        num=[]
        for(var i=0;i<str.length;i++){
                num.push(str.charCodeAt(i))
        }
        return(num.join('_') )
}

window.onload=function(){
	//获取表单
	var f=$('mySearchForm');
	$('keyword').focus();//自动获得焦点
	

	var showSearch=function(){
		var kw=f.keyword.value;
		var submit=f.submit.value;
		
		var since=f.since.value;
		var sortBy=f.sortBy.value;
		var page=f.page.value;
		
		//如果没有输入关键词，则不查询；
		if(''==kw.replace(/\s/g, '')){
			alert('Please input at least one key word.');
			$("keyword").innerHTML="";
			$('keyword').select();
			return (false);
		}
		
		$('search').innerHTML="<center style='color:red;'>拼命加载中...请等待5s</center><br>"
		//发送请求
		axios.post('/gs.php', {
			submit: 'axios',
			since:since,
			sortBy:sortBy,
			page:page,
			//keyword: string2ascii( encodeURIComponent(kw) ) //对kw进行加密
			keyword: encodeURIComponent(kw) //对kw进行加密
		})
		.then(function (response) {
			response.data=eval('('+response.data+')'); //获取json
			//console.log(response.data);//debug
			$('search').innerHTML=response.data.html;
			$('url').innerHTML=response.data.url;
		})
		.catch(function (error) {
			console.log(error);
		});
	}
	
	//搜索按钮绑定事件
	$("submit").onclick=showSearch
	
	//下拉框事件
	f.since.onchange=f.sortBy.onchange=function(){
		//执行搜索
		if(f.keyword.value=='') return;
		showSearch();
	};
	/**/
	//上一页
	f.previous.onclick=function(){
		changePage(-1);
	}
	//下一页
	f.next.onclick=function(){
		changePage(1);
	}
	//翻页函数
	function changePage(num){
		var page=f.page.value;
		
		num>0?++page:--page;
		
		if(page<=1) page=1;
		if(page>=10) page=10;
		
		f.page.value=page;
		//执行搜索
		if(f.keyword.value=='') return;
		showSearch();
	}
}
</script>
</head>

<?php 
require 'common/function.php';
myLog('Visit google Search Page');//登陆日志 ?>

<body>
<div id="url_info" class='card announce' style="display:none;">
	<h1>免费试用</h1><h3>To 2099.10.1</h3>
	<b>红线之上可操作!</b><br><a href="help.php" target="_blank" title="帮助">帮助文档</a>.
</div>

<div id='erWeiMa'>
	<img src='images/fxxsEWM.jpg' /><br>
	<b>微信公众号</b>
</div>



<div class=myWrap>
	<form method="POST" target="" id="mySearchForm">
		<b>Keywords:</b>
		<input type="text" name="keyword" id="keyword" placeholder='Input your scholar keyword(s) here'>
		<input type="button" name="submit2" id='submit' class="btn" value="Scholar Search">
	
<center>
Since 
<select name="since">
<?php
echo "<option value='0' selected='selected'>--</option>";
//获取当前年份
date_default_timezone_set("PRC");
$thisYear = date("Y", time()); 
//打印年份列表
for($y=$thisYear; $y>1990; $y-- ){
	$opt="<option value='".$y."'>" . $y . "</option>";
	echo $opt.'\n';
}
?>
</select>

<span class="spacer"></span>

Sort by  
<select name="sortBy">
	<option value="0" selected="selected">relevance</option>
	<option value="1">date</option>
</select>


	<span class="spacer"></span>
	Page
	<input type="button" name="previous" class='btn light' value="&lt;">
	<input type='text' name='page' id='page' class='page' value="1">
	<input type="button" name="next" class='btn light' value="&gt;">
</center>

		<div id='url'></div>
	</form>
	<br>
</div>


<div id='search'> <div style="width:800px;margin:0 auto;">只有红线以上才可操作，红线以下只能看，点击可能会报错。</div> </div>

<style>
/*
#search{width:1000px; margin:0 auto;}
*/


#url{color:#eee;}
#gs_hdr,#gs_ab_rt,#gs_gb,#gs_lnv,#gs_n,#gs_ftr,
#gs_hp_main #gs_hp_tsi {display:none;}

#gs_ccl { margin-left: 10px;}

.logo{display: none;}
</style>


<?php 
include('common/footer.php');
?>