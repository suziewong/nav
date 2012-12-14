jQuery(function($){
    //加载服务器端处理ajax请求的文件
     var processFile = 'assets/inc/nav.inc.php';
           $("#fastinput").hide();
     $("#fast").live("click",function(event){
     //阻止表单提交
			
           event.preventDefault();
           var fastinputtext = "<form action='assets/inc/p.php' method='post'>";
           fastinputtext += "名称：<input type='text' style='margin-top:5px; color:black;' name='urlname'/>";
           fastinputtext += "网址：<input type='text' style=' margin-top:5px;color:black;' name='urllink'>";
          fastinputtext += "<input type='submit' name='fast' value='add' class='admin'/>"; 
          fastinputtext += "</form>";
           $("#fastinput")
                          .html(fastinputtext)
                          .slideToggle();
                        // .slideToggle("fast");
           // var urledit = "<a href='#'>delete</a>";

         $("#s-nav-li #change_nav").toggleClass("change_nav").slideDown();
         $("#s-nav-li #del_nav").toggleClass("del_nav").slideDown();
        // $("#s-nav-li #change_nav").delClass("change_nav").slideUp();
         //.replaceWith("<a id='change_nav'></a><a id='del_nav'></a>")
                      //   .attr("href","del.php")
                            
          /* $("#s-nav-li a").html("change")
                       //  .attr("href","del.php")
                      .slideToggle();*/
		
    });
     $("input.admin").live("click",function(event){
     //阻止表单提交
           event.preventDefault();
        // alert("input");
          //载入用于ajax请求的action
           var action = $(event.target).attr("name") || "fast";
          //将input元素中的event_id保存到变量id中
           urlname = $(event.target)
                           .siblings("input[name=urlname]")
                              .val();
           urllink = $(event.target)
                           .siblings("input[name=urllink]")
                              .val();
          if(urlname.length == 0)
          {
            alert("请输入网址名称");
            return false;
          }
          var urlreg=/^((https|http|ftp|rtsp|mms)?:\/\/)+[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/;  
          if(!urlreg.test(urllink))
          {
            alert("请输入正确的网址格式");
            return false;
          }
          else
          {
            alert("yes");
          }

           var newurl = "<li id='s-nav-li'><a href='"+urllink+"'><img width='16' height='16' src='"+urllink+"/favicon.ico'><em>"+urlname+"</em></a></li>";
			

		
           var  formdata = "action=add&urlname="+urlname+"&urllink="+urllink;
		
           // 将表单数据送往处理程序
      $.ajax({
            type: "POST",
            url: processFile,
            data: formdata,
            success: function(data) {
                 // alert("www");
			$("#s-nav-ul li:last").after(newurl);
                  // alert(data);
                }
       });

        
    });
     $("#del_nav").live("click",function(event){
     //阻止表单提交
           event.preventDefault();
          // alert("admin");
          $(this).parent().hide("slow");
          
            var url_link_val =$(this).parent().find("a").attr("href");
            var url_name_val =$(this).parent().find("em").html();
            //alert(url_name_val); 
           // var url_name_val =$(this).parent().find("a").html();
            //var url_name_val =$(this).parent().find("a").html();
       //     alert(url_name_val);
        formdata ="action=del&url_link="+url_link_val+"&url_name="+url_name_val;
      $.ajax({
            type: "POST",
            url: processFile,
            data: formdata,
            success: function(data) {
            	     //alert(data);        
                }
       });
    });
     $("#change_nav").live("click",function(event){
     //阻止表单提交
           event.preventDefault();
          // alert("admin");
        //  $(this).parent().hide("slow");
           var text = $(this).parent().find("em").text();
           //alert(text);
            var text_url_link = $(this).parent().find("a:first").attr("href");
            //alert(text_url_link);
           // alert(text_url_link);
           var input_change = "<input autofocus type='text' value='"+text+"' id='url_change' name='"+ text_url_link+"'/>";
           //alert(input_change);
          $(this).parent().find('em').html(input_change);
    });
    
    $("#url_change").live("blur",function(event){
       
           var urllink = $(this).attr("name");
           var urlname = $(this).val();
          // alert(urllink);      
           //alert(urlname);
           //var newurl = "<a href='"+urllink+"'>"+urlname+"</a><a id='del_nav'>del</a>&nbsp;<a id='change_nav'>change</a></li>";

          var formdata = "action=edit&url_name=" + urlname +"&url_link=" + urllink;
      $.ajax({
            type: "POST",
            url: processFile,
            data: formdata,
            success: function(data) {
                    $("#url_change").parent().find('#url_change').replaceWith(urlname);
                }
       });
    });


    //////jquery的模态窗口，或者是弹出层
     $("#admin").live("click",function(event){
     //阻止表单提交
           event.preventDefault();
           alert("admin");
    });



    ////Ajax统计  每个超链接的数目
    $(".metro-button").live("click",function(event){
          event.preventDefault();
//		alert("xx");
       var url_name = $(this).text();
       var url_link = $(this).attr("href");
      //  alert(url_name);
      //
      var formdata = "action=tongji&url_name=" + url_name +"&url_link=" + url_link;
      $.ajax({
            type: "POST",
            url: processFile,
            data: formdata,
            success: function(data) {
                   // alert(data); 
					window.location.href= url_link;
                }
         
    });
    });

        var h = $(document).height();
    $(".overlay").css({"height": h });  
    
    $("#action").click(function(){
    
        $(".overlay").css({'display':'block'}).animate({'opacity':'0.2'});
        
        $(".destroy").stop(true).animate({'margin-top':'40px','opacity':'1'},400);
        
    });
    
    $(".close").click(function(){
    
        $(".destroy").stop(true).animate({'margin-top':'-792px','opacity':'0'},800);

        $(".overlay").css({'display':'none'}).animate({'opacity':'0'});
        
    });
     $("#overlay_url").live("click",function(event){
     //阻止表单提交
          event.preventDefault();
        //  alert("input");
          //载入用于ajax请求的action
     //     var action = $(event.target).attr("name") || "fast";
          //将input元素中的event_id保存到变量id中
          var  urlname = $(this).text();
           var urllink = $(this).attr("href");

           var newurl = "<li style='list-style-type:none;'><a class='metro-button' href='"+urllink+"'>"+urlname+"</a></li>";


     //               $("#navul li:last").after(newurl);   

       var  formdata = "action=add&urlname="+urlname+"&urllink="+urllink;
           // 将表单数据送往处理程序
      $.ajax({
            type: "POST",
            url: processFile,
            data: formdata,
            success: function(data) {
                 // alert("www");
                    $("#navul li:last").after(newurl);   
                  //  alert(data);
                }
       });
      
       });

      $("#navhide").live("click",function(event){

          $(".s-container").slideUp();
          //alert("sd ");
      });


      /*
      **点击标签标红放大
      */
      $("#m .horizontal-menu li a").live("click",function(event){

          //$(".s-container").slideUp();
         // alert(location.href);

          if($(this).css("color","black"))
          { 
            $(this).parent().parent().find("a").css({"color":"black","font-size":"14px"});
            $(this).css({"color":"red","font-size":"20px"});
            var searchtype = $(this).attr("name");
            $("#searchtype").attr("value",searchtype);
          }

      });
     $(".jh_nav .horizontal-menu li a").live("click",function(event){

          //$(".s-container").slideUp();

          if($(this).css("color","black"))
          { 
            $(this).parent().parent().find("a").css({"color":"black","font-size":"14px"});
            $(this).css({"color":"red","font-size":"20px"});
            var searchtype = $(this).attr("name");
            $("#searchtype").attr("value",searchtype);
          }

      });

 /* window.onload = function(){ 
    // 在这里写你的代码...
          var name = request("type");
          thisname = ".jh_nav .horizontal-menu li a [name="+name+"]";
          //alert(thisname);
         // var thisname = $();
          
          if($(this).css("color","black"))
          { 
            $(this).parent().parent().find("a").css({"color":"black","font-size":"14px"});
            $(this).css({"color":"red","font-size":"20px"});
            var searchtype = $(this).attr("name");
            $("#searchtype").attr("value",searchtype);
          }

  };*/
     $("#soc").live("click",function(event){
          
        XN.Connect.requireSession(function(){
         $("[href='login.html']").parent().remove();
        });
     });
     $(".xnconnect_login_button").live("click",function(event){
          
          $(".XN_Link").remove();
     });
     $("[src='http://a.xnimg.cn/connect/img/login_buttons/renren/logout_large.gif']").live("click",function(event){
          
          
          var newss = "<li><a href='login.html'>登录(使用学号登录)</a></li>"
          $("#is_out .sub-menu").after(newss);

     });
    $("[href='login.html']").live("click",function(event){
      
      event.preventDefault();

       $("#login").slideToggle();
    });


     $("#login [name='submit']").live("click",function(event){
      
      event.preventDefault();

      //$("#login").slideToggle();
       var username = $("input[name='username']").val();
       var password = $("input[name='password']").val();
      // alert(username);
      //alert(password);
      var processFile = 'assets/inc/process.inc.php?action=user_login&from=js' ;
      var formdata = 'username='+username+"&password="+password;
      
      $.ajax({
            type: "POST",
            url: processFile,
            data: formdata,
            success: function(data) {
                 //   alert(data); 
          //window.location.href= url_link;
          if(data != "Your username is not found!")
          {
          var adduser ="<ul><li class='sub-menu'><a href='#'>"+data+"</a><ul><li class='sub-menu'><a href='#'>我的主页</a><ul><li><a href='#'>主页</a></li><li><a href='#'>博客</a></li></ul></li><li><a href='http://mail.zjut.com/index.php'>我的邮箱</a></li><li><a href='assets/inc/process.inc.php?action=user_logout'>退出</a></li></ul></li><li><a href='#''>我的主页</a></li><li><a href='#'>精弘网络</a></li></ul>";
           $("#login").slideUp();
          $("#is_out").slideUp();
          $("#u").html(adduser).slideDown();
          }
          else
          {
            alert(data);
          }

            }         
        });

    });
    /*
    * Ajax 注销用户资料
    */
    $("[href='assets/inc/process.inc.php?action=user_logout']").live("click",function(event){
      
      event.preventDefault();
      var processFile = 'assets/inc/process.inc.php?action=user_logout&from=js';    
      $.ajax({
            type: "GET",
            url: processFile,
            success: function(data) {
          $("#u").find("ul").remove();
          var loginuser ="<ul id='is_out'><li class='sub-menu'><a href='#'>使用社交账号登陆</a><ul id='soc'><li><xn:login-button autologoutlink='true'></xn:login-button></li></ul></li><li><a href='login.html'>登录(使用学号登录)</a></li></ul><span>";
          $("#u").html(loginuser).slideDown();
          $("#is_out").slideDown();
            }         
        });

    });
      //JS 无法拿到客户端IP地址
     $.get('sys/func/getIP.php', function(ip) {   
                   var ip = "<a>"+ip+"</a><span>城市</span>";

                  $(".ip").html(ip);
              });

      ///天气的Jquery插件
         $.extend({
            weather:function(){
        $.getJSON("http://s.zjut.in/weather-api/raychou-api/data.json", function(data){                
               var test = eval(data);     
                var city = test[0].title;
                // 这里有空的话，拓展一下Object to String的 转换函数
                var cityweather =test[0].item[0].description;

                var weather = "<img class='toolimage' src='assets/images/sun-128.png'/><a>"+cityweather+"</a><span>天气</span>";
                $(".weather").html(weather);
          });

        /* $.getJSON("http://s.zjut.in/weather-api/hangzhou-24/data.json", function(data){                
               var test = eval(data);     
                var temp = test[23].temp;
                // 这里有空的话，拓展一下Object to String的 转换函数
               // var cityweather =test[0].item[0].description;
               // var weather = "<span>"+cityweather+"</span>";
               // $(".weather").html(weather);
               alert(city);
          });*/
//    });
       }
     });
    $.weather();
    setInterval("$.weather()",1000*60*10);
     $("#closetools").live("click",function(event){
        //alert($("#s_main").is(":visible"));
        if($("#s_main").is(":visible") == true)
            $(this).html("尝试工具栏");
          else
            $(this).html("关闭工具栏");
          $("#s_main").slideToggle();

          
     });
     ////今晚吃什么？
      $.extend({
            eat:function(){
            var eat = "<a id='box'>鸡腿套餐</a><span>今晚吃神马？<input type='button' id='bt' onclick='doit()'' value='开始点菜'/></span>";

                  $(".eat").html(eat);  
       }
     });
      $.eat();
      //news
      $.extend({
            news:function(){
              var enews = "<ul>";
            $.ajax({
              /// Access-Control-Allow-Origin.
                  url:"sys/func/getNews.php",
                  type:"post",
                  DataType:"xml",
                  success:function(xml){
                    $(xml).find("item").each(function(i){

                        var title = $(this).children("title").text();
                        var link = $(this).children("link").text();
                        enews += "<li><span><a href='"+link+"'>"+title+"</a></span></li>";
                        if( i >2  )
                        { 
                          enews = enews +"</ul><span>资讯</span>";
                          $(".news").html(enews);
                          return false;
                        }
                    });
                    //alert(typeof(xml));
                    //echo 
                 //  alert($(xml).find("files[name='"+filename+"']").find("key[name='"+keyname+"']").text());
                 //var news = "<a>省长要来审查寝室了，大家注意</a><span>资讯</span>";
                  //title = news.find("title").text();
                 // 
                 }
              });

          /*    */
       }
     });
      $.news();
      //feel
      $.extend({
            feel:function(){
                $.getJSON("http://feel.zjut.com/data/list.json", function(data){                
                  var name = data[0].name;
                  var intro = data[0].intro;
                var feel = "<img class='toolimage' src='assets/images/Music.png'/><a href='http://feel.zjut.com/'>"+name+"</a><p>"+intro+"</p><span>FEEL</span>";
                  $(".feel").html(feel); 

          });
           
       }
     });
      $.feel();
      //labs
      $.extend({
            labs:function(){
            var eat = "<img class='toolimage' src='assets/images/Games.png'/><ul><li><a href='http://210.32.200.89:11063/zjuthelper/'>工大助手</a></li><li><a href='http://pages.zjut.in/'>Wiki</a></li><li><a>ETC...</a></li></ul><span>精弘实验室</span>";

                  $(".labs").html(eat);  
       }
     });
      $.labs();
    /*
    *  处理页面跳转是连接不变
    *
    */
    
     window.onload =function(){
        //alert(request("type"));
        var type = ".jh_nav .horizontal-menu li a[name='"+request("type")+"']";
        type = $(type);
        if($(type).css("color","black"))
          { 
            
            $(type).css({"color":"red","font-size":"20px"});
            $(type).parent().parent().find("a").css({"color":"black","font-size":"14px"});
            $(type).css({"color":"red","font-size":"20px"});
            var searchtype = $(type).attr("name");
            $("#searchtype").attr("value",searchtype);
          }


        

     }
    /*
    
*/





    function request(paras)
    { 
        var url = location.href; 
        var paraString = url.substring(url.indexOf("?")+1,url.length).split("&"); 
        var paraObj = {} 
        for (i=0; j=paraString[i]; i++){ 
        paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length); 
        } 
        var returnValue = paraObj[paras.toLowerCase()]; 
        if(typeof(returnValue)=="undefined"){ 
        return ""; 
        }else{ 
        return returnValue; 
        } 
    }


     $("input[value='test']").live("click",function(event){
          DOUBAN.apikey = '0b4d214bbf7aec0321e763e33e70c409';
          //alert("22");
          DOUBAN.getMovie({
    id:'2340927',
    callback:function(re){
        var subj = DOUBAN.parseSubject(re)
        //var tl = subj.title ? subj.title : "";
        //var author = subj.author ? subj.author : "";
        //var di = subj.attribute.director ? subj.attribute.director.join(' / ') : "";
        var tmp = "<img src="+subj.link.image+" style='margin:10px;float:left'>";
        /*tmp += "<div>Title : <a href="+subj.link.alternate+" target='_blank'>"+tl+"</a></div>";
        if (subj.attribute.author) tmp += "<div>Authors : "+(subj.attribute.author.join(' / '))+"</div>";
        if (subj.attribute.director) tmp += "<div>Director : "+(subj.attribute.director.join(' / '))+"</div>";
        if (subj.attribute.cast) tmp += "<div>Casts : "+(subj.attribute.cast.join(' / '))+"</div>";
        if (subj.attribute.aka) tmp += "<div>A.k.a : "+(subj.attribute.aka.join(' <br/>   '))+"</div>";
        if (subj.attribute.language) tmp += "<div>Language : "+(subj.attribute.language.join(' / '))+"</div>";
        if (subj.attribute.country) tmp += "<div>Country : "+(subj.attribute.country.join(' / '))+"</div>";
        if (subj.rating.average)
            tmp +="<div>Rating: "+subj.rating.average+" / "+subj.rating.numRaters+decodeURI("%E4%BA%BA")+ "</div>"
        tmp += "<p>"+(subj.summary ? subj.summary : "")+"</p>";*/
        document.body.innerHTML = tmp;
    }
  });
});
      //});
       

       ////自动补全
        $("input[name='wd']").focus().live('keyup',function(){

        //获取keyup传输进来的值
        var nkey=$.trim($(this).val());
        //alert(nkey);

        //若值为空则不显示;
        if(nkey==''||nkey==null){
            $("#first_a").hide();
        }else{
            //异步传输
            var processFile = 'assets/inc/ac.inc.php' ;
            var formdata = 'keywords='+nkey+"&action=search";
      
         $.ajax({
                type: "POST",
               url: processFile,
              data: formdata,
              success: function(v) {
                 if(v.length > 0)
                {
                $("#first_a").html(v);
              //  $("#first_a").show("slow");
                $("#first_a").slideDown("fast");
                //对生成出来的表格里面的值进行操作
                $("#first_a table tr td").click(function(){
                    $("input[name='wd']").val($(this).html()) ;
                    $("#first_a").hide() ;
                })
                }
              }
            });       
          }
            
        });
    
        ///////mongo插入
        $(".btn_wr input[type='submit']").live('click',function(){
          
          /*alert(window.location.href);
          event.preventDefault();*/
        //获取keyup传输进来的值
        //var nkey=$("input[name='wd']").trim($("input[name='wd']").val());
        var nkey=$("input[name='wd']").val();
        //若值为空则不显示;
        if(nkey!=''||nkey!=null)
        {
            //异步传输
            
            var processFile = 'assets/inc/ac.inc.php' ;
            var formdata = 'keywords='+nkey+"&action=add";
      
         $.ajax({
                type: "POST",
               url: processFile,
              data: formdata,
              success: function(v) {
                alert(v);
              }
            });       
          }
            
        });





    $("").mouseover(function(event){
           
            
    });


    /////DOUBAN
    $("#douban").live("click",function(event){
           if ($("div.doubanmovie").length > 0)
            {     // 找到对应id=div的元素，然后执行此块代码 
                  $("div.doubanmovie").remove();                  
            } 
            var postdata = "title="+$(this).parent().parent().find("a:first").text();
            
           //  doubanmoviediv = "<div class='doubanmovie'><span>"+title+"</span></div>";
             $.ajax({
            type: "POST",
            url: "sys/func/douban.func.php",
            data: postdata,
            success: function(data) {
                 //var subj = DOUBAN.parseSubject(re);
               var data = eval("(" + data + ")");  //由JSON字符串转换为JSON对象
               //var id = data.movies[0].alt;
               //DOUBAN提供的是错误的
               var id = data.movies[0].alt.match(/(\d)+/)[0];
               var url = "http://movie.douban.com/subject/"+id+"/";
              var title = data.movies[0].title;
              var alt_title = data.movies[0].alt_title;
               var average = data.movies[0].rating.average; 
               var image =  data.movies[0].image;
            //  var author = data.movies[0].author[0].name;
               var country = data.movies[0].attrs.country[0];
              var pubdate = data.movies[0].attrs.pubdate[0];
              //var movie_duration= data.movies[0].attrs.movie_duration[0];
              // alert(average);
                var  doubanmoviediv = "<div class='doubanmovie'>"+
                                          "<a href='"+url+"''>豆瓣连接</a><br/>"+
                                          "<strong>标题:"+title+"("+pubdate+")"+"</strong><br/>"+
                                          "副标题:"+alt_title+"<br/>"+
                                       //  "作者:"+author+"<br/>"+
                                          "豆瓣评分:"+average+"<br/>"+
                                          "<img src='"+image+"'/></div>";
              //$(this).parent().parent().append(doubanmoviediv);
                  $("#douban").parent().parent().append(doubanmoviediv);
                }
            });
              

    });

     $("#switchtheme").live("click",function(event){
      
        //$('body').css("background", "#0D232E");
        $('body').css("background", "#004050");
        alert("待完善");
    
  });


           


});
