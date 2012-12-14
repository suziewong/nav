<?php
	header("Content-type:text/html; charset=utf-8");  
	session_start();
	include_once '../../sys/config/mongo-cred.inc.php';
    foreach( $M as $name => $val)
    {
        define($name, $val);   
    }
    //echo time();
    /*$_POST['action']="search";
    $_POST['keywords']= "a";*/
    $dsn = "mongodb://".DB_USER.":".DB_PASS."@".DB_HOST.":".DB_PORT."/".DB_NAME;
    
    $actions = array(
        'add' => 'keywords_add',
        'search' => 'keywords_search',
    );
    
    if(isset($actions[$_POST['action']]))
    {
        $obj = new Keywords($dsn);
        $obj->$actions[$_POST['action']]();      
    }
    
    function __autoload($class_name)
    {
        $filename = '../../sys/class/class.'
                    .$class_name.'.inc.php';
        if( file_exists($filename))
        {
            include_once $filename;
        }

    }
?>