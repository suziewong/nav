<!DOCTYPE html>
<html>
	<head>
		<title>Search Engine</title>
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/metro.css">
		<link rel="stylesheet" type="text/css" media="screen,projection" href="assets/css/overlay.css"/>
		<script src="assets/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<meta charset="utf-8"/>
		<script type="text/javascript" src="assets/js/main.js" ></script>
		 <script type="text/javascript" src="assets/js/init.js"></script>
		 <script type="text/javascript" src="assets/js/pagecontrol.js"></script>
		
		 <script type="text/javascript" src="assets/js/eat.js"></script>
		 <!--导航栏插件
		 <script type="text/javascript" src="http://www.douban.com/js/api.js?v=2"></script>
		 <script type="text/javascript" src="http://www.douban.com/js/api-parser.js?v=1"></script>
		 <script type="text/javascript" src="http://s.zjut.in/site-nav/page/site-nav.js"></script>
		 <link rel="stylesheet" href="http://s.zjut.in/site-nav/page/site-nav.css">
		-->
		<!--renren-->
		<script type="text/javascript" src="http://static.connect.renren.com/js/v1.0/FeatureLoader.jsp"></script>
  		<script type="text/javascript">
    	XN_RequireFeatures(["EXNML"], function()
    	{
      		XN.Main.init("5ba5327e39da4651b848c207e039e5ea", "/nav/xd_receiver.html");
    	});
		</script>
	</head>
	<body>
		 
		<div class="horizontal-menu" id="u">
			<?PHP
				session_start();
				if(isset($_SESSION['user']))
				{
			echo <<<metrouser
			 <ul>
            <li class="sub-menu"><a href="#">{$_SESSION["user"]["name"]}</a>
                <ul>
                	<li class="sub-menu"><a href="#">我的主页</a>
                		<ul>
                   			<li><a href="#">主页</a></li>
                    		<li><a href="#">博客</a></li>
                		</ul>
            		</li>
                    <li><a href="http://mail.zjut.com/index.php">我的邮箱</a></li>
                    <li><a href="assets/inc/process.inc.php?action=user_logout">退出</a></li>
                </ul>
            </li>
            <li><a href="#">我的主页</a></li>
            <li><a href="#">精弘网络</a></li>
        </ul>
metrouser;
				}
	if(isset($_COOKIE['5ba5327e39da4651b848c207e039e5ea_user']))
				{
					echo <<<renrenuser
			 <ul>
            <li class="sub-menu"><span><a style='padding-top:2px;'><xn:name uid="loggedinuser"></xn:name></a></span>
                <ul>
                	<li><a><xn:profile-pic uid="loggedinuser" size="normal" linked="true" connect-logo="true"></xn:profile-pic>我的主页</a></li>
                    <li><a href="http://mail.zjut.com/index.php">我的邮箱</a></li>
                    <li><a href="assets/inc/process.inc.php?action=user_logout" onclick="XN.Connect.logout(function(){logoutSite();});return false;">退出</a></li>
                </ul>
            </li>
        </ul>
renrenuser;
				}
				else
				{

					echo "<ul id='is_out'>
							<li>
							
							<ul id='soc'>
                   				<li><xn:name uid='loggedinuser'></xn:name></li>
                   				<li><xn:login-button autologoutlink='true'></xn:login-button></xn:login-button></li>            
                			</ul>
                			</li>
                			<li><a href='login.html'>登录(使用学号登录)</a></li>
                		</ul>";	
					
				}
			?>
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
		<div id="m" style="width:720px;">
			<p id="lg"><h1><a style="color:#000;" href="index.php">Search Engine</a></h1>
				<!-- doodle
				<img src="logo.png" width="270" height="129">
				<img src="http://www.baidu.com/img/baidu_sylogo1.gif" width="270" height="129">
				-->
			</p>
			<div class="horizontal-menu" id="nv">
        		<ul>
            		<li><a name="all" style="color:red;font-size:20px;">网页</a></li>
           			<li><a name="bbs">BBS</a></li>
            		<li><a name="pt">PT</a></li>
            		<li><a name="library">图书馆</a></li>
            		<li><a name="paper">学术论文</a></li>
        		</ul>
    		</div>
			<div id="fm">
				<form name="f" id="ff" action="find.php" method="get" >
					<input type="text" id="kw" name="wd" autocomplete="off"/>

					<input type="hidden" id="searchtype" name="type" value="all"/>
					<span class="btn_wr">
						<input type="submit" class="btn" value="Search">
					</span>
				</form>
				<div id="first_a"></div>
			</div>
		</div>
		<!-- 自定义导航-->	
		<div id="s_wrap">
			<div class="s_close"><a id="switchtheme">换皮肤</a>&nbsp;&nbsp;&nbsp;<a id="closetools">关闭工具栏</a></div>
			<div id="s_main" class="main">
				<div class="ip"></div>
				<div class='weather'></div>
				<div class='eat'></div>
				<div class='news'></div>
				<div class='feel'></div>
				<div class='labs'></div>
				<div class="s-container" >
					<div class="s-title">
						<em>我的导航</em>
						<span>全部|热门</span>
						<input type="button" value="test"/>
						<a href="#" id="navhide" alt="隐藏">关闭</a>
						<a href="#" id="action">添加</a>
						<a href="#" id="fast">编辑</a>
					</div>
					<div id="fastinput"></div>
					<div class="s-content">
						<?php
           					include_once './sys/core/init.inc.php';
            				$nav = new Nav();
            				$nav->buildNav();
	
						?>	
					</div>
				</div>
				
			</div>
		</div>
		<!-- 底部-->		
		<div class="bottom-line1">
			<a href="#">加入精弘</a>
			<span>|</span>
			<a href="#">加入精弘</a>
			<span>|</span>
			<a href="#">加入精弘</a>
			<span>|</span>
			<a href="#">加入精弘</a>
		</div>
		<div class="bottom-line2">
		<span>©2012 精弘网络</span>
		<a href="README.txt">使用精弘前必读</a>
		<a href="#">浙ICP备10001</a>
		</div>

		<!--
		<img id="daren" src="assets/images/daren.png" style="z-index:-1;">
		<img id="yuanfang" src="assets/images/yuanfang.png" style="z-index:-1;">
		-->
		<!--自定义导航overlay-->
<div class="overlay" style="height: 1424px; display: none; opacity: 0; "></div>
<div class="destroy" style="opacity: 0; margin-top: -492px;">
    <div class="sheet">
        <div class="head">
           <h2>常用网址</h2>  
        </div>
        <div class="body">
    	<div class="page-control" data-role="page-control" style="margin-top: -23px;">
        <ul>
            <li class="active"><a href="#frame1">Page1</a></li>
            <li><a href="#frame2">Page2</a></li>
            <li><a href="#frame3">Page3</a></li>
            <li><a href="#frame4">Page4</a></li>
            <li><a href="#frame5">Page5</a></li>
        </ul>
        <div class="frames">
            <div class="frame active" id="frame1">
            <?php
                for($i=0;$i<20;$i++)
                echo "
            		<img width='32' height='32' src='http://weibo.com/favicon.ico'>
            		<a href='http://weibo.com/'  alt='点击增加' id='overlay_url'>Weibo</a>";
            ?>	
            </div>          
            <div class="frame" id="frame2">
            </div>
            <div class="frame" id="frame3">
            <?php
                for($i=0;$i<20;$i++)
                echo "
            		<img width='32' height='32' src='http://www.imsuzie.com/favicon.ico'>
            		<a href='http://www.imsuzie.com/'  alt='点击增加' id='overlay_url'>Suzie</a>";
            ?>	
            </div>
            <div class="frame" id="frame4"></div>
            <div class="frame" id="frame5"></div>
        </div>
    </div>
            


           
            <h2>点击添加到自定义导航</h2>
        </div>
        <a class="close" title="关闭" href="#"></a>
    </div>
</div><!--sheet end-->
	</body>
</html>
