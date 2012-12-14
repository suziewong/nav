<?php
	
	$DOUBAN_APIKEY = "0b4d214bbf7aec0321e763e33e70c409";
	//$_POST['title'] = "【龙珠新巴达克之章】【 rmvb】【848*480】 ";
	$moviename = $_POST['title'];
	preg_match_all("/【(.*)】(.*)【/",$moviename,$title);
	$moviename = $title[1][0];
	$url = 'https://api.douban.com/v2/movie/search?q='.$moviename.'&start=0&count=1&apikey='.$DOUBAN_APIKEY;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$tr = curl_exec($ch);
	/*$tr = json_decode($tr,true);
	echo "<pre>";
	var_dump($tr);
	echo "</pre>";*/

	//////trello的json
	/*	$url ="https://trello.com/board/-/505d9233525232cd3e702d3f.json";
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	$tr = curl_exec($ch);
	/*	
	* file_get_contents 不能访问https的网站
	$ch = file_get_contents($url);
	Warning: file_get_contents() [function.file-get-contents]: SSL: connection timeout 
	Warning: file_get_contents() [function.file-get-contents]: Failed to enable crypto
	 */
?>