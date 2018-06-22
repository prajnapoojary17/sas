    $(document).ready(function () {
				$('#property_tax').keyup(function(){
				  var property_tax = $('#property_tax').val();
				  var b_enhc_tax = $('#b_enhc_tax').val();
				  var difference = parseInt(b_enhc_tax) - parseInt(property_tax);

					
					if(isNaN(difference)) {
						$('#difference').val(0);
						}
						else{
						$('#difference').val(difference);
						}
					
				if($('#p_112C').val() == 1){
				  var penalty_112C = property_tax;
					$('#penalty_112C').val(penalty_112C);
					}
					else{
					$('#penalty_112C').val('');
					}
				});
				
	$('#payment_date').change(function() {
    
					$.ajax({
						type: "POST",
						url: "../get_penalty",
						data: $('#saspayedit').serialize(),
						dataType:"json",
						async: false,
						success: function(data){												
						 var payment_date = $('#payment_date').val();						
						 var month = JSON.parse(data.month);	
						 var r_month = JSON.parse(data.r_month);								 
						 var property_tax = $('#property_tax').val();						
						 if(month>0){
							//var month_late = month - 6;
							var penalty = (property_tax * 2 * month)/100;
							penalty = Math.floor(penalty);
					
						  $('#penalty').val(penalty);
						  $('#rebate').val('');
						 }
						 else{
						  $('#penalty').val('');
						 }
						 
						 if(r_month<=4 && r_month!=0){
							var rebate = (property_tax * 5)/100;
							rebate = Math.floor(rebate);
						    $('#rebate').val(rebate);
							 $('#penalty').val('');
						 }
						 else if(r_month == 0){
						  $('#rebate').val('');						 
						 }
						
						}
					});
            });
	});