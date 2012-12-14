jQuery(function($){
	window.onload =function(){
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
                
              }
            });       
          }
     }

});