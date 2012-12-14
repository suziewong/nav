<?php
		include ("sphinxapi.php");
		$keywords = $_GET['wd'];
		$page = isset($_GET['page'])?$_GET['page']:1;
		$offset = 0;
		$pagesize = 10;
		$maxRows;
		$maxPage;
		//$offset = ($page-1)*$pagesize;
		$pagesize = $pagesize;

		if($_GET['wd']=="")
		{
			header("Location:index.php");
		}

		if(isset($_GET['type']))
		{
		$type = htmlspecialchars($_GET['type']);
		$type = addslashes($type);
		}
		else{
			$type ="all";
		}

		switch($type)
		{
			case 'all':
				$source = "posts";
				$dbname = "discuzx";				
				break;
			case 'bbs':
				$source = "posts";
				$dbname = "discuzx";
				break;
			case 'pt':
				$source = "torrents";
				$dbname = "pt";
				break;	
			default:
				$source = "posts";
				$dbname = "discuzx";						
		}
		
		
		$sphinx = new SphinxClient();
		
		$sphinx->SetServer('localhost',9312);

		//$sphinx->SetLimits(0,1);
		$sphinx->SetMatchMode(SPH_MATCH_ANY);
		//$sphinx-> setSortMode(SPH_SORT_EXTENDED,"@id DESC");
		//$sphinx-> setSortMode(SPH_SORT_RELEVANCE);
		
		//$sphinx->SetLimits(0,1000);
		//查询舍得相当蛋疼，权重待考量
		$result = $sphinx->query("$keywords",$source);	
		//$result = $sphinx->query("$keywords","threads,posts");	
	/*	echo "<pre>";
		var_dump($result);
		echo "</pre>";
		exit;*/
		if($result === false)
		{
			echo "查询错误".$sphinx->GetLastError();

		}
		else
		{
			if($sphinx->GetLastWarning())
			{
				echo "查询错误".$sphinx->GetLastError();

			}
			
			if($result['total_found'] != 0)
			{
				
			

/*echo "<pre>";
	var_dump($result);
echo "</pre>";
		exit;*/
		
	$ids = join(",",array_keys($result['matches']));
	$time = $result['time'];
	$total_found = $result['total_found'];
	
	$maxRows =  sizeof($result['matches']);
	//echo $maxRows;
	$maxPage = ceil($maxRows/$pagesize);
	if($page > $maxPage)
	{
		$page = $maxPage;
	}
	if($page < 1)
	{

		$page = 1;
		//echo $page;
	}
	//echo "Coreseek为你搜到".$total_found."篇文档（用时".$time."s)<br/>";
	mysql_connect("210.32.200.91","suzie","123456");
	mysql_select_db($dbname);

	//$sql = "select pid,tid,fid,subject,message,position from pre_forum_post where  pid in ({$ids})  order by substring_index('{$ids}',pid,1) limit ".($page-1)*$pagesize.",".$pagesize;
	/*$sql = "select pid,tid,fid,subject,position from pre_forum_post where  pid in ({$ids})  order by substring_index('{$ids}',pid,1) limit ".($page-1)*$pagesize.",".$pagesize;
		//$sql = "select id,name,descr,size,last_action from torrents where id in ({$ids}) order by last_action desc limit ".($page-1)*$pagesize.",".$pagesize;
	echo $sql;*/
	/*echo "<pre>";
	var_dump($result);
echo "</pre>";
		exit;*/
		switch($type)
		{
			case 'all':
			$sql = "select pid,tid,fid,subject,message,position from pre_forum_post where  pid in ({$ids})  order by substring_index('{$ids}',pid,1) limit ".($page-1)*$pagesize.",".$pagesize;
				break;
			case 'bbs':
				$sql = "select pid,tid,fid,subject,message,position from pre_forum_post where  pid in ({$ids})  order by substring_index('{$ids}',pid,1) limit ".($page-1)*$pagesize.",".$pagesize;
				break;
			case 'pt':
				$sql = "select id,name,descr,size,last_action from torrents where id in ({$ids})  order by substring_index('{$ids}',id,1) limit ".($page-1)*$pagesize.",".$pagesize;
				break;	
			default:
				$sql = "select pid,tid,fid,subject,message,position from pre_forum_post where  pid in ({$ids})  order by substring_index('{$ids}',pid,1) limit ".($page-1)*$pagesize.",".$pagesize;
		}
	$rst = mysql_query($sql);
	//var_dump($rst);
	/*echo "<pre>";
	var_dump($rst);
echo "</pre>";
		exit;*/

	$opts = array(
			"before_match"=>"<font style='color:red;font-weight:bold'>",
			"after_match"=>"</font>"
		);
			} 
		}
	?>
<html>
	<head>
		<title>Search </title>
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/metro.css">
		<script src="assets/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="assets/js/init.js"></script>
		<script type="text/javascript" src="assets/js/find.js"></script>
		<script type="text/javascript" src="http://www.douban.com/js/api-parser.js?v=1"></script>
	</head>
	<body>

		<div id="u" class="horizontal-menu " >
		<ul>
			<?php 

				session_start();
            	if(isset($_SESSION['user']))
            	{	
            	echo <<<metrouser
            <li class="sub-menu">
            	<a href="#">
            			{$_SESSION["user"]["name"]}           			
            	</a>
                <ul>
                	<li class="sub-menu"><a href="#">我的主页</a>
                		<ul>
                   			<li><a href="#">主页</a></li>
                    		<li><a href="#">博客</a></li>
                		</ul>
            		</li>
                    <li><a href="#">我的主页</a></li>
                    <li><a href="assets/inc/process.inc.php?action=user_logout">退出</a></li>
                </ul>
            </li>
            <li><a href="#">我的主页</a></li>
            <li><a href="#">精弘网络</a></li>
metrouser;
        		}
        		else
        		{
        			echo "<ul><li><a href='login.html''>登录(使用学号登录)</a></li></ul>";
        		}
        		?>
        </ul>
        </div>
		<div id='login'>
			<form action="assets/inc/process.inc.php?action=user_login" method="post">
			 <div class="input-control text">
        		<h3>Username</h3>
        		 <input type="text" name="username"/>
       			 <span class="helper"></span>
   			 </div>
			<div class="input-control password">
        		<h3>Password</h3>
        		<input type="password" name="password"/>
        		<span class="helper"></span>
    		</div>
			<input type='submit'name="submit"/>
		</form>
		</div>
		<div id="head">
			<div class="jh_nav">
				<a href="./" class="jh_logo">
					<h2>Search</h2>
					<!--说好的logo呢
					<img src="http://www.baidu.com/img/baidu_jgylogo3.gif" width="117" height="38"/>
					-->
				</a>
				<div class="horizontal-menu" id="nv">
        		<ul>
            		<li><a  name="all" style="color:red;font-size:20px;">网页</a></li>
           			<li><a  name="bbs">BBS</a></li>
            		<li><a  name="pt">PT</a></li>
            		<li><a  name="library">图书馆</a></li>
            		<li><a  name="paper">学术论文</a></li>
        		</ul>
    			</div>
				<!--
				<div class="jh_tab">
					<a href="#">BBS</a>
					<a href="#">PT</a>
					<a href="#">FEEL</a>
					<a href="#">更多</a>
				</div>
				-->
			</div>
			<div id="fm">
				<form name="f" id="ff" action="find.php" method="get" >
					<input type="text" id="kw"  name="wd" autocomplete="off" value=<?php echo $_GET['wd']; ?> />
					<div id="first_a" style="margin-left:0px;" ></div>
					<input type="hidden" id="searchtype" name="type" value="all"/>
					<span class="btn_wr">
						<input type="submit" class="btn" value="Search">
					</span>
					<span class="tools">
						<span class="shouji">
							<strong>推荐</strong>
							<a href="http://210.32.200.89:11063/bustime/">用手机也能查校车时刻表哦</a>
						</span>
					</span>
				</form>

			</div>
		</div>
		<br/>
		<div id="container">
		<?php
			function delhtml($str)
			{   //清除HTML标签
				$st=-1; //开始
				$et=-1; //结束
				$stmp=array();
				$stmp[]="&nbsp;";
				$len=strlen($str);
				for($i=0;$i<$len;$i++)
				{
   					$ss=substr($str,$i,1);
   					if(ord($ss)==60)
   					{ //ord("<")==60
    					$st=$i;
   					}
   					if(ord($ss)==62)
   					{ //ord(">")==62
    					$et=$i;
    					if($st!=-1)
    					{
    						 $stmp[]=substr($str,$st,$et-$st+1);
    					}
   					}
				}
			$str=str_replace($stmp,"",$str);
			return $str;
			}

			function strcut($str,$start,$len)
			{  
   				 if($start < 0)  
        			$start = strlen($str)+$start;  
      
   				 $retstart = $start+getOfFirstIndex($str,$start);  
 //   echo $retstart;  
    			$retend = $start + $len -1 + getOfFirstIndex($str,$start + $len);  
   // echo $retend;  
    			return substr($str,$retstart,$retend-$retstart+1);  
			}  
			//判断字符开始的位置  
			function getOfFirstIndex($str,$start)
			{  
    			$char_aci = ord(substr($str,$start-1,1));  
    			if(223<$char_aci && $char_aci<240)  
        			return -1;  
    			$char_aci = ord(substr($str,$start-2,1));  
    			if(223<$char_aci && $char_aci<240)  
       				 return -2;  
   				 return 0;  
			}  
					//	var_dump($result['words']);	
			if($result['total_found'] != 0)
			{
					while($row=mysql_fetch_assoc($rst))
					{
						//var_dump($row);
						switch ($type) {
							case 'all':
							case 'bbs':
													$content = trim($row['message']);
						$content = addslashes($content);
						$content = strip_tags($content);
						$content = delhtml($content);
						$row['message'] = preg_replace('/\[[^\[\]]{1,}\]/','',$content);

						$position = ceil($row['position']/20);
						//echo $position;
						if(empty($row['subject']))
						{
							$sql2 = "select subject from pre_forum_post where tid = {$row['tid']} and first = 1";
							//echo $sql2;
							//echo 
							$rstsubject = mysql_query($sql2);
							//var_dump($rstsubject);
							$rstsubj = mysql_fetch_assoc($rstsubject);
							//	var_dump($rstsubj);
							$row['subject'] = $rstsubj['subject'];
							//var_dump($row);
						}
						$rst2 = $sphinx->buildExcerpts($row,"threads",$keywords,$opts);



						$content = trim($rst2[4]);
						//$content = strip_tags($content);
						$content = strcut($content,0,400)."...";
						echo <<<aaa
						<table cellpadding="0" cellspacing="0" class="result" id="2">
				<tbody>
					<tr>
						<td class="f">
							<h3 class="t">
								<a href="http://bbs.zjut.com//forum.php?mod=viewthread&tid={$rst2[1]}&page={$position}#pid{$rst2[0]}">{$rst2[3]}</a>
							</h3>
							<font size="-1">
								{$content}								
							</font>
							<br/>
							<span class="g">
								http://bbs.zjut.com//forum.php?mod=viewthread&tid={$rst2[1]}&extra=&page={$position} ... -精弘搜索 
							</span>
						</td>
					</tr>
				</tbody>
			</table>
			<br/>
aaa;
							break;						
							case 'pt':
						$rst2 = $sphinx->buildExcerpts($row,"torrents",$keywords,$opts);
						$content = substr($rst2[2],0,200)."...";
						$content = $rst2[2];
						$filesize = round($rst2[3]/pow(1024,3),2);
						$content = addslashes($content);
					//	preg_match_all("/【(.*)】(.*)【/",$rst2[1],$title);
					//	var_dump($title[1][0]);
						/*$title = preg_match_all("\【(.*)】\",);	*/	
						//echo $rst2[1];
						/*preg_match_all("/\](.*)\[/", $row['descr'],$imgurl);
						var_dump($imgurl[1][0]);*/
						//Douban
						/*$doubanapikey = "0b4d214bbf7aec0321e763e33e70c409";
						$movieurl = "https://api.douban.com/v2/movie/search?q=".$rst2[1]."&apikey=".$doubanapikey;
						$doubanmovie = file_get_contents($movieurl);
						$movie = json_decode($doubanmovie,true);
						$imageurl = $movie['movies']['0']['image']; */
						/*echo "<pre>";
						var_dump($movie['movies']['0']['image']);
						echo "</pre>";*/
						echo <<<aaa
						<table cellpadding="0" cellspacing="0" class="result" id="2">
				<tbody>
					<tr>
						<td class="f">
							<h3 class="t">								
								<a href="http://pt.zjut.com/details.php?id={$rst2[0]}">{$rst2[1]}</a>
								<font style="color:blue">{$filesize} GB</font>
							</h3>
							<div>
							<font size="-1">
								{$content}								
							</font>
							<br/>
							<span class="g">
								http://pt.zjut.com/details.php?id={$rst2[0]} ... $rst2[4] -精弘搜索 
							</span>
							<input type="button" id="douban" value="看豆瓣">
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<br/>
aaa;
								break;
							default:
								break;
								
						}

					
					}
			}
			?>
			<div id="jh-search-bottom">
			<div id="page">
				<?php
				if($result['total_found'] != 0)
				{
					echo "当前第 {$page}/{$maxPage} 页";
					echo "共计 {$maxRows} 条";
					echo "<a href='find.php?wd={$keywords}&type={$type}&page=1'> &nbsp;首页 &nbsp;</a>";

				}
			
				$keywords = str_replace(" ","+", $_GET['wd']);
				if($page > 1)
				{	
					echo "<a class='nums' href=find.php?wd=".$keywords."&type=".$type."&page=".($page-1).">上一页</a>";

				}
				if(isset($maxPage) && $maxPage > 1)
				{
					for ($i=1; $i <= $maxPage ; $i++) { 
						# code...
						if($page == $i)
						{
							echo "<a class='rnums' href=find.php?wd=".$keywords."&type=".$type."&page=".($i)." >".($i)."&nbsp;&nbsp;</a>";
						}
						else
						{
							echo "<a class='nums' href=find.php?wd=".$keywords."&type=".$type."&page=".($i).">".($i)."&nbsp;&nbsp;</a>";
						}
					}
				}
				if(isset($page) && isset($maxPage) && $page < $maxPage)
				{	
					echo "<a class='nums' href=find.php?wd=".$keywords."&type=".$type."&page=".($page+1).">下一页</a>";
					

				}
			
				if(($result['total_found'] != 0))
					echo "<a href='find.php?wd={$keywords}&type={$type}&page={$maxPage}'> &nbsp;末页</a>";
				else
				{
					echo "<h1>对不起，没找到任何您需要的文档,请移步<a href='http://www.google.com.hk/'>这里</a></h1>";
				}
			?>
			<span style="margin-left:40px">
			<?php
			if(($result['total_found'] != 0))
				echo "精弘为你搜到".$total_found."篇文档（用时".$time."s)<br/>";
			
			?>
			</span>
		</div>
		<div id="xg">
			相关搜索:
			<?php
				foreach ($result['words'] as $keys => $value ) {
					echo "<a class='xgkeys' href=find.php?wd=".$keys.">".$keys."</a>";
				}
			?>
		</div>

			<div id="fm">
				<form name="f" id="ff" action="find.php" method="get" >
					<input type="text" id="kw" name="wd" autocomplete="off" value=<?php echo $_GET['wd']; ?> />

					<span class="btn_wr">
						<input type="submit" class="btn" value="Search">
						<input type="hidden" id="searchtype" name="type" value="all"/>
					</span>
					<span class="tools">
						<span class="shouji">
							<a href="#">结果中找</a>
							<a href="#">帮助</a>
							<a href="#">举报</a>
							<a href="#">高级搜索</a>
						</span>
					</span>
				</form>
			</div>
		</div>

		</div>

	</div>

   </body>
   
</html>
