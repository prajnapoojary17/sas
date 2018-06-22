//for exiting payer
function payer_yes(){   
    var ward = $('#p_ward').val().split(',');    
    var wardname = ward[1];
    var block = $('#p_block').val();
    var doorno = $('#door_no').val();
    $('#inset_form').html('<form action="'+ baseUrl+'sasdetails/check_payer" name="payer_yes" class="payer_yes" method="post" style="display:none;"><input type="text" name="p_ward" value="' + wardname + '" /><input type="text" name="p_block" value="' + block + '" /><input type="text" name="door_no" value="' + doorno + '" /></form>');
    $( ".payer_yes" ).submit(); 
 }  

function fetch_roadname(val){
    $('#guidance').hide();
    $.ajax({
        type: 'post',
        url: baseUrl + "sasdetails/getRoadNames",
        data: {
            get_option:val
        },
        success: function (response) {
            console.log(response);
            document.getElementById("n_road").innerHTML=response; 
        }
    });
}

$(document).ready(function () {
    $('#p_block').keyup(function(){
	$('#block').html($(this).val());
    });
    
    $('#door_no').keyup(function(){
	$('#door').html($(this).val());
    });
    
    $('#p_ward').change(function(){
	$('#ward').html($("#p_ward option:selected").text());
    });
    
    $('#submit').click( function(e){     
	e.preventDefault();
        $.ajax({
            type: "POST",
            url: baseUrl + "sasdetails/savegeneralInfo",
            data: $('#sasdetails_general').serialize(),
            dataType:"json",
            async: false,
            success: function(data){
                if(data.status == true){                      
                    $(".alert-success").html('UPI succeesfully generated. Refer the UPI <strong>'+data.wardname+'-'+$('#p_block').val()+'-'+$('#door_no').val()+' </strong>to enter Property details of the owner');
                    $("#validn").html('');
                    $("#validn").removeClass("alert-danger alert");
                    $('#ward').html('');
                    $('#block').html('');
                    $('#door').html('');
                    $('#sasdetails_general').find('input:text').val('');
                    $('#n_road').val('0');
                    $("#p_ward").val('0');
                    $("#p_112C").val('0'); 
                    $("#ex_serviceman").val('0');
                    $('#guidance').hide();
                    $("#succss").show().delay(7000).fadeOut();
                }else{                 
                    var obj = jQuery.parseJSON(data.msg);
                    for(var i in obj){
                        $("#validn").html(obj[i]);
                        $("#validn").addClass("alert-danger alert");			
                    }
                }

            },
            error : function(data){             
                $("#validn").html('Something went wrong. Please try again');
                $("#validn").addClass("alert-danger alert");              
                exit();
            }
	});
	return false;	
    });    
    
    $('#submitandcontinue').click( function(e){       
	e.preventDefault();
        $.ajax({
            type: "POST",
            url: baseUrl + "sasdetails/savegeneralInfo",
            data: $('#sasdetails_general').serialize(),
            dataType:"json",
            async: false,
            success: function(data){
                if(data.status == true){               
                    payer_yes();
                }else{                  
                    var obj = jQuery.parseJSON(data.msg);
                    for(var i in obj){
                        $("#validn").html(obj[i]);
                        $("#validn").addClass("alert-danger alert");			
                    }
                }

            },
            error : function(data){               
                $("#validn").html('Something went wrong. Please try again');
                $("#validn").addClass("alert-danger alert");               
                exit();
            }
	});
	return false;	
    });
    
    $('#ex_serviceman').change(function() {
        if (this.value == "1") {
            $("#serviceman-container").slideDown('slow');
        }else {
            $("#serviceman-container").slideUp('slow');
        }
       
    });
    
    $('#n_road').change(function() {
        $('#guidance').hide();
        var roadname = $('#n_road').val();
        var ward_no = $('#p_ward').val();
        $.ajax({
            type: 'post',
            dataType:"json",
            url: baseUrl + "sasdetails/getGuidanceValue",
            data: {
                roadname : roadname,
                ward_no: ward_no
            },
            success: function (response) {
                console.log(response); 
                $('#guidance').show();
                $('#comm').html(response.commercial);
                $('#res').html(response.residential);
            }
        });
       
    });
});
