            // When the document is ready
            $(document).ready(function () {
			
  $(function() {
  
	  $('.btn-warning').click( function(e){
	  $("#payers").submit();
	 	/*	 e.preventDefault();
	
			$.ajax({
			type: "POST",
			url: "sasdetails/edit_pay",
			data: {"id":$(this).data("id")},
			dataType:"text",
			success: function(data){
				alert(data);
			//window.location='sasdetails';
			}
			});*/
	  
	 return false;
});


		
		
});
                    
            });