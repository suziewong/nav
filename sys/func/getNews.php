<?php
header("Content-Type:text/xml"); //php

    //$url = 'http://news.zjut.com/?action-rss';
    $url = 'http://news.zjut.com/?q=rss.xml';
    $news = file_get_contents($url);

   /*$xml = simplexml_load_file($url);
   $news = array();
    $i = 0;
    foreach($xml->channel->item as $a) 
	{ 
		$news[$i] = array("title");
		$i ++;
	} 
   echo "<pre>";
   print_r($news);
   	echo  "</pre>";*/
   	echo $news;
    /*echo "<pre>";
    var_dump($ip);
    echo "</pre>";*/