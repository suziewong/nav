<?php
    class Nav extends DB_Connect
    {  
       public function __construct($dbo=NULL)
       {
            parent::__construct($dbo);
       }


       public function buildNav()
       {
           if(isset($_SESSION['user']['uid']))
           {
                $uid = $_SESSION['user']['uid'];
                $sql = "select url_name,url_link from nav where uid=:uid order by url_clicks desc";

       try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
            $stmt->execute();
            $urls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
       }
       catch(Exception $e)
       {
            die($e->getMessage());

       }
            $urlssize = sizeof($urls);
            $i = 0;
           echo "<ul id='s-nav-ul'>";
           if($urlssize ==0)
           {
        	 //   echo "<li ><a></a></li>"; 
           }
           while($i < $urlssize)
           {
            echo "<li id='s-nav-li'>
					<a href='{$urls[$i]['url_link']}'>
					<img width='16' height='16' src='{$urls[$i]['url_link']}/favicon.ico'>
					<em>{$urls[$i]['url_name']}</em>
					</a>
          <a id='del_nav'></a><a id='change_nav'></a>
          </li>";
            $i++;
            }
            echo "</ul>";
        //    echo "</div>";<a id='del_nav'></a>&nbsp;<a id='change_nav'></a>
         }
         else
         {

			echo <<<default
			<ul id="s-nav-ul">
            	<li id="s-nav-li">
					<a href="http://weibo.com/">
					<img width="16" height="16" src="http://weibo.com/favicon.ico">
					<em>新浪微博</em>
					</a>
			</li>
      <li id="s-nav-li">
					<a href="http://www.baidu.com/">
					<img width="16" height="16" src="http://www.baidu.com/favicon.ico">
					<em>baidu</em>
					</a>
				</li>
        <li id="s-nav-li">
					<a href="http://www.zjut.com/">
					<img width="16" he    ight="16" src="http://www.zjut.com/favicon.ico">
					<em>精弘主页</em>
					</a>
				</li>
       <li id="s-nav-li">
          <a href="http://www.php100.com/">
          <img width="16" height="16" src="http://www.php100.com/favicon.ico">
          <em>PHP100</em>
          </a>
      </li>
      <li id="s-nav-li">
          <a href="http://bbs.phpchina.com/">
          <img width="16" height="16" src="http://bbs.phpchina.com/favicon.ico">
          <em>PHPChina</em>
          </a>
      </li>
      <li id="s-nav-li">
          <a href="http://www.oschina.net/">
          <img width="16" height="16" src="http://www.oschina.net/favicon.ico">
          <em>开源中国</em>
          </a>
      </li>
      <li id="s-nav-li">
          <a href="http://www.douban.com/">
          <img width="16" height="16" src="http://www.douban.com/favicon.ico">
          <em>CSDN</em>
          </a>
      </li>
			</ul>
       

default;
 
         }
       }
       public function url_add()
       {
          
         if( !isset($_SESSION['user']['uid']))
          {
            return "you should login ";
          }
      //    var_dump($_POST);  
      //    var_dump($_SESSION);  
          $uid = $_SESSION['user']['uid'];
          $url_name = $_POST['urlname'];
          $url_link = $_POST['urllink'];


          $sql = "insert into nav(uid,url_name,url_link) values(:uid,:url_name,:url_link)"; 
        //  var_dump($_SESSION);
     // echo $sql;
	//	exit;
       try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
            $stmt->bindParam(':url_name',$url_name,PDO::PARAM_STR);
            $stmt->bindParam(':url_link',$url_link,PDO::PARAM_STR);
            $stmt->execute();
          //  $user = array_shift($stmt->fetchAll());
            $stmt->closeCursor();
       }
       catch(Exception $e)
       {
            die($e->getMessage());
       }
        }
       public function url_del()
       {
          
         if( !isset($_SESSION['user']['uid']))
          {
            return "you should login ";
          }
          $uid = $_SESSION['user']['uid'];
          $url_link = $_POST['url_link'];
          $url_name = $_POST['url_name'];

         $sql = "delete from nav where uid=:uid and url_link =:url_link and url_name =:url_name"; 
          //$sql = "delete from nav where uid=$uid and url_link ='$url_name'"; 
//		echo $url_name;
		//echo $sql;
		//echo $uid;
	//	echo $url_name;
		//exit;
		
       try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
            $stmt->bindParam(':url_link',$url_link,PDO::PARAM_STR);
            $stmt->bindParam(':url_name',$url_name,PDO::PARAM_STR);
            $stmt->execute();
          //  $user = array_shift($stmt->fetchAll());
            $stmt->closeCursor();
       }
       catch(Exception $e)
       {
            die($e->getMessage());
       }
        }


        public function url_edit()
        {
         if( !isset($_SESSION['user']['uid']))
          {
            return "you should login ";
          }
          $uid = $_SESSION['user']['uid'];
          $url_name = $_POST['url_name'];
          $url_link = $_POST['url_link'];


          $sql = "update nav set url_name=:url_name where uid=:uid and url_link=:url_link"; 
       try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
            $stmt->bindParam(':url_name',$url_name,PDO::PARAM_STR);
            $stmt->bindParam(':url_link',$url_link,PDO::PARAM_STR);
            $stmt->execute();
          //  $user = array_shift($stmt->fetchAll());
            $stmt->closeCursor();
       }
       catch(Exception $e)
       {
            die($e->getMessage());
            
        }
        }
        public function url_tongji()
        {
         if( !isset($_SESSION['user']['uid']))
          {
            return "you should login ";
          }
          $uid = $_SESSION['user']['uid'];
          $url_name = $_POST['url_name'];
          $url_link = $_POST['url_link'];


          $sql = "update nav set url_clicks = url_clicks + 1 where uid=:uid and url_link=:url_link and url_name=:url_name"; 
       try{
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':uid',$uid,PDO::PARAM_STR);
            $stmt->bindParam(':url_name',$url_name,PDO::PARAM_STR);
            $stmt->bindParam(':url_link',$url_link,PDO::PARAM_STR);
            $stmt->execute();
          //  $user = array_shift($stmt->fetchAll());
            $stmt->closeCursor();
       }
       catch(Exception $e)
       {
            die($e->getMessage());
            
        }
        }
    }
?>
  
