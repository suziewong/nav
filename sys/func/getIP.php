<?php
    $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$_SERVER['REMOTE_ADDR'];
    $ip = file_get_contents($url);
    $ip =json_decode($ip,true);
    /*echo "<pre>";
    var_dump($ip);
    echo "</pre>";*/
    echo $ip['data']['country'].$ip['data']['region'].$ip['data']['city'].$ip['data']['isp'];
           
   
    