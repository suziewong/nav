
            var namelist=[

				"大排套餐","今晚不吃饭","大肉套餐","酱鸭套餐","鸡腿套餐",
				"口水鸡","白切鸡","黑椒牛扒","今晚不吃饭","葱爆肥肠","菊花点菜"
				];
			
			var mytime=null;
			
            function doit(){
                var bt=window.document.getElementById("bt");
                if(mytime==null){
                    bt.innerHTML="停止点菜";
                    show();                    
                }else{
                    bt.innerHTML="开始点菜";
                    clearTimeout(mytime);
                    mytime=null;                    
                }
            }
            
            function show(){
                var box=window.document.getElementById("box");
                var num=Math.floor((Math.random()*100000))%namelist.length;
                box.innerHTML=namelist[num];
                mytime=setTimeout("show()",1);
            } 
			
		//修改的代码
		
		window.onload=function(){
			var oImagebg=window.document.getElementById("imagebg");
			var oBt=window.document.getElementById("bt");
			var bstop = true;
			oImagebg.onkeydown=function(ev){
				  var ev = ev || window.event;
				  if(ev.keyCode == 13 && bstop ){
						 show();
						 bstop=false;
						 bt.innerHTML="停止点菜";
				  }else{
						clearTimeout(mytime);
						mytime=null; 
						bt.innerHTML="开始点菜";
						bstop = true; 
				  }
			};
		};
