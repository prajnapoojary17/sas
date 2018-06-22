$(document).ready(function () {
    $('#p_block').keyup(function(){
	$('#block').html($(this).val());
    });
    
    $('#door_no').keyup(function(){
	$('#door').html($(this).val());
    });
    
    $('#p_ward').change(function(){
	$('#ward').html($(this).val());
    });
    
    $('#submit').click( function(e){		
	/* $("#sasdetails").submit();*/
	e.preventDefault();
        $.ajax({
            type: "POST",
            url: baseUrl + "sasdetails/updategeneralInfo",
            data: $('#general_edit').serialize(),
            dataType:"json",
            async: false,
            success: function(data){
                if(data.status == true){
                    $("#validn").html('');
                    $("#validn").removeClass("alert-danger alert");                   
                    $("#succss").show().delay(3000).fadeOut();
                }else{
                    var obj = jQuery.parseJSON(data.msg);
                    for(var i in obj){
                        $("#validn").html(obj[i]);
                        $("#validn").addClass("alert-danger alert");			
                    }
                }

            },
            error : function(data){
                $("#validn").html('');
                $("#validn").removeClass("alert-danger alert");
                $("#building").removeClass("no-click");
                exit();
            }
	});
	return false;	
    }); 
    
    $('#changeaddr').click( function(e){        
        $('#guidance').hide();
        var ward = $('#p_ward').val();
        $.ajax({
            type: 'post',
            url: baseUrl + "sasdetails/getRoadNameList",
            data: {
                get_option:ward
            },
            success: function (response) {
                console.log(response);
                document.getElementById("road").innerHTML=response; 
            }
        });
        $('.roadlist').show();        
    });
    
    $('#road').change(function() {
        $('#roadname_message').hide();
        $('#changeaddr').hide();
        //alert($(this).val());
        if($(this).val() != ''){
            $('#n_road').val($(this).val());
        }
    });
    
    $('#reset_roadname').click(function(e){
        $('#n_road').val($('#n_roadold').val());        
    });
});