$(document).ready(function(){
					$("#s_username_top").click(function(){
						alert("xx");
				});
					$("a#s_username_top").mousemove(function(){
						$("#s_username_menu").css("display","block");
				});
					$("#s_username_top").mouseout(function(){
						$("#s_username_menu").css("display","none");
				});
					$("#s_username_menu").mousemove(function(){
						$("#s_username_menu").css("display","block");
				});
					$("#s_username_menu").mouseout(function(){
						$("#s_username_menu").css("display","none");
				});
			
});
