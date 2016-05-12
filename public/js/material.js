$(document).ready(function() {
	var server = window.location.protocol + "//" + window.location.host;
	console.log(server);
	var parts = window.location.pathname.split( '/' );
	console.log( parts);
	var newPathname = "";
	for (i = 0; i < parts.length-2; i++) {  
  		newPathname += parts[i];
  		newPathname += "/";
	}
	console.log(newPathname);
	var targetUrl=server + newPathname;
	console.log ( targetUrl);
	$(".is_download").on('change',function(){
		console.log("delagate , fire event  dynamical generated element in run time");
		var id = $(this).attr('name');
		var column=$(this).attr('class');
		if ($(this).is(':checked')) 
		{
        	console.log($(this).val() + ' is now checked');
        	console.log(id);
        	$.ajax({
			 	// edit action that will take id and value of checkbox then update
				// url: '<?= echo $this->baseUrl()?>'+'/material/edit/id/'+id+'/col/'+column,
				url: targetUrl+'material/edit/id/'+ id+'/col/'+column ,
				success: function(response)
				{
					console.log("success checked");					   
				}
			});
	

    	} else {
        	console.log($(this).val() + ' is now unchecked');
        	console.log(id);
         	$.ajax({
                url: targetUrl+'material/edit/id/'+ id+'/col/'+column ,
                success: function(response)
                {
                   console.log("success unhecked");
                   
                }
            });
		}
          
	});
	$(".is_show").on('change',function(){
		console.log("delagate , fire event  dynamical generated element in run time");
		var id = $(this).attr('name');
		var column=$(this).attr('class');
		console.log("column");
		console.log(column);
		if ($(this).is(':checked')) 
		{
	        console.log($(this).val() + ' is now show');
	        console.log(id);
	        $.ajax({
				 	// edit action that will take id and value of checkbox then update
					url: targetUrl+'material/edit/id/'+ id+'/col/'+column ,
					success: function(response)
					{
						console.log("success show");					   
					}
				});
		

	    } else {
	        console.log($(this).val() + ' is now unshow');
	        console.log(id);
	         $.ajax({
	         	    url: targetUrl+'material/edit/id/'+id+'/col/'+column ,
	                success: function(response)
	                {
	                   console.log("success unshow");
	                   
	                }
	            });
			}
	          
	});
	    
	       
});