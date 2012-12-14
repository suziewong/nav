<?php
	class Keywords
    {  
    	protected $db;
    	public function __construct($dbo=NULL)
       {
            $this->db = new Mongo($dbo);
       }
       public function keywords_search()
       {
       		$keywords = $_POST['keywords'];
       		$url = $this->db->url;
       		$nav = $url->nav;
			//$arr =	array("keywords"=>new MongoRegex("/".$keywords.".*/i"),"keywords"=>1);
     // $keys = array("key"=>array("keywords"=>true));
			$arr =	array("keywords"=>new MongoRegex("/".$keywords.".*/i"));
   //   $initial = array("initial"=>array("clicks"=>0));
   //   $reduce = array("reduce"=>"function (obj, prev) { prev.clicks +=obj.clicks }");
			try { 
      // $rst  = $nav->distinct("keywords",$arr);
				$rst = $nav->find($arr)->sort(array('date' => -1))->limit(10);
       
			}
			catch (MongoCursorException $e) { 
 				die("Insert failed ".$e->getMessage()); 
			} 

			$str = "";
			foreach ($rst as $val ) {
				  
				$str.='<tr><td>'.$val['keywords'].'</td></tr>';
			}

			echo $str2="<table>$str</table>";
       }

       public function keywords_add()
       {
       		$keywords = $_POST['keywords'];
       	/*	echo $keywords;
       		exit;*/
       		if(isset($_SESSION['user']['uid']))
       			$uid = $_SESSION['user']['uid'];
       		else
       			$uid = "";
       		$date = new MongoDate();
       		$url = $this->db->url;
       		$nav = $url->nav;
			$arr =  array("keywords"=>$keywords,"uid"=>$uid,"date"=>$date,"clicks"=>1);			
			$options = array('safe'=>true);
			try { 
				$rst = $nav->insert($arr,$options);
			}
			catch (MongoCursorException $e) { 
 				die("Insert failed ".$e->getMessage()); 
			} 
       }

    }

?>