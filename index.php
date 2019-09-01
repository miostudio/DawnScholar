<!DOCTYPE html>
<html>
<head>
<title>Dawn scholar v0.3.0</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="content-type" content="text/html;charset=utf-8">

<link rel="stylesheet" href="css/scholarPage.css">
<script type="text/javascript" src="js/ajax.js"></script>

<script>
window.onload=function(){
	//获取表单
	var f=$('mySearchForm');
	
	//搜索按钮绑定事件
	$("submit").onclick=showScholar;
	
	//下拉框事件
	f.since.onchange=f.sortBy.onchange=function(){
		//执行搜索
		if(f.keyword.value=='') return;
		showScholar();
	};
	
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
		showScholar();
	}
}
</script>
</head>

<?php 
require 'common/function.php';
myLog('Visit Home Page');//登陆日志 ?>

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
	<input type="text" name="keyword" id="keyword">
	<input type="button" name="submit2" id='submit' class="btn" value="Scholar Search">
<br>

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
</form>

<span id='schloar'>Scholar ...</span>

</div>
<style>
#gs_hdr,#gs_ab_rt,#gs_gb,#gs_lnv,#gs_n,#gs_ftr,
#gs_hp_main #gs_hp_tsi {display:none;}

#gs_ccl { margin-left: 10px;}
</style>


<div style='text-align:center;' role="contentinfo">
	&copy;2019 
	<a target=_blank href=/>Dawn Scholar</a> |
	<a href="help.php">Help</a>
	<br>
	<a target=_blank href=/open_url.php>Get page</a>,
	<a target=_blank href=/open_url2.php>Get page2</a> |
	<br>
	<a target=_blank href=/getPic.php>Get pic</a>,
	<a target=_blank href=/getPic2.php>Get pic2</a>,
	<a target=_blank href=/getPic3.php>Get pic3</a> | 
</div>


</body>
</html>