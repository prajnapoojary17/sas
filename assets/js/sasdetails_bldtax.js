var count = 1;
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

//accept only numbers with decimal
function forceNumber(element) {
    element
            .data("oldValue", '')
            .bind("paste", function(e) {
              var validNumber = /^[-]?\d+(\.\d{1,2})?$/;
              element.data('oldValue', element.val())
              setTimeout(function() {
                    if (!validNumber.test(element.val()))
                      element.val(element.data('oldValue'));
              }, 0);
            });
    element
            .keypress(function(event) {
              var text = $(this).val();
              if ((event.which != 46 || text.indexOf('.') != -1) && //if the keypress is not a . or there is already a decimal point
                    ((event.which < 48 || event.which > 57) && //and you try to enter something that isn't a number
                      (event.which != 45 || (element[0].selectionStart != 0 || text.indexOf('-') != -1)) && //and the keypress is not a -, or the cursor is not at the beginning, or there is already a -
                      (event.which != 0 && event.which != 8))) { //and the keypress is not a backspace or arrow key (in FF)
                    event.preventDefault(); //cancel the keypress
              }

              if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 10) && //if there is a decimal point, and there are more than two digits after the decimal point
                    ((element[0].selectionStart - element[0].selectionEnd) == 0) && //and no part of the input is selected
                    (element[0].selectionStart >= element.val().length - 2) && //and the cursor is to the right of the decimal point
                    (event.which != 45 || (element[0].selectionStart != 0 || text.indexOf('-') != -1)) && //and the keypress is not a -, or the cursor is not at the beginning, or there is already a -
                    (event.which != 0 && event.which != 8)) { //and the keypress is not a backspace or arrow key (in FF)
                    event.preventDefault(); //cancel the keypress
              }
            });
}

$(document).ready(function () {     
    $('#upi').trigger('focus');
    forceNumber($("#a_cents"));
    forceNumber($("#value_corn"));
    forceNumber($("#undiv_right"));
    //convert area to cents
    $('#a_cents').keyup(function(){
        var  a_sqft = $('#a_cents').val() * 435.6;  
        a_sqft =  Math.round(a_sqft);		
        $('#a_sqft').val(a_sqft);
    });
		 
    //calculate area_ratio
    $('#area_build').keyup(function(){
        var  area_ratio = parseFloat($('#area_build').val() / $('#area_floors').val());   
        area_ratio = area_ratio.toFixed(3);
        if(!isFinite(area_ratio)) {		
            $('#area_ratio').val('');
        }else{
            $('#area_ratio').val(area_ratio);
        }
    });
			
    //calculate area_ratio	
    $('#area_floors').keyup(function(){		
        var  area_ratio = parseFloat($('#area_build').val() / $('#area_floors').val());
        $('#area_ratio_original').val(area_ratio);				
        area_ratio = area_ratio.toFixed(3);
        if(!isFinite(area_ratio)) {
            $('#area_ratio').val('');
        }else{
            $('#area_ratio').val(area_ratio);
        }      
    });			
			
    //calculate Guidance Value of Land in Sq. Ft
    //calculate Total Guidance Value
    //calculate 50% of the Guidance Value			
    $('#guide_cents').keyup(function(){			
        var g_cents = parseFloat($('#guide_cents').val());
        var value_corn = parseFloat($('#value_corn').val());	
        if(isNaN(value_corn)) {
            value_corn = 0;
        }
        var  guide_sqft = g_cents / 435.6;  
        guide_sqft = guide_sqft.toFixed(2);
        if(isNaN(guide_sqft)) {
            guide_sqft = 0;
        }
        $('#guide_sqft').val(guide_sqft);
        var value_total =  parseFloat(guide_sqft) + parseFloat(value_corn);
        $('#value_total').val(value_total);
        var total_50 = parseFloat($('#value_total').val()) * 0.5;			
        var total_50_fix = total_50.toFixed(2);
        if(isNaN(total_50_fix)) {
            var total_50_fix = 0;
        }
        $('#guide_50').val(total_50_fix);
        $('#guide_50_original').val(total_50);
    });
			
			
    //calculate Guidance Value of Land in Sq. Ft
    //calculate Total Guidance Value
    //calculate 50% of the Guidance Value
    $('#value_corn').keyup(function(){
        var value_corn = parseFloat($('#value_corn').val());
            if(isNaN(value_corn)) {
                value_corn = 0;
            }
        var total = value_corn + parseFloat($('#guide_sqft').val())
        total = total.toFixed(2);			
        $("#value_total").val(total);
        var total_50 = total* 0.5;
        var total_50_fix = total_50.toFixed(2);	
        if(isNaN(total_50_fix)) {
            var total_50 = 0;
        }
        $('#guide_50').val(total_50_fix);
        $('#guide_50_original').val(total_50);
    });

			
    //calculate Taxable value of the Land
    //calculate Taxable value of the Building
    //calculate Applicable Tax
    //calculate Cess (24%)
    //calculate Total payable Property Tax	
	
    $('#p_use').change(function() {
        var prop_type = $('#p_use').val();
        var upi = $('#upi').val();
        $.ajax({
                type: "POST",
                url: baseUrl + "sasdetails/check_guidance",
                data: {"upi": upi,"prop_type":prop_type},
                dataType:"json",
                success: function(data){
                    if($('#p_use').val() == 'COM'){
                    $('#guide_cents').val(data.gval_commercial).keyup();
                    $("#guide_cents").attr('readonly','readonly');
                    $('#stax_exempted').val('0');
                    $('#exempted').hide();           
                    var tax_rate = '1.5';
                    }                    
                    else if($('#p_use').val() == 'RES'){
                        $('#guide_cents').val(data.gval_residential).keyup();
                        $("#guide_cents").attr('readonly','readonly');
                        $('#stax_exempted').val('0');
                        $('#exempted').hide();
                         var tax_rate = '0.5';
                    } else if($('#p_use').val() == 'NRS'){
                        $('#guide_cents').val(data.gval_commercial).keyup();
                        $("#guide_cents").attr('readonly','readonly');
                        $('#exempted').show();
                        var tax_rate = '1';
                    }
                    else{
                        $('#guide_cents').val(data.gval_commercial).keyup();
                        $("#guide_cents").attr('readonly','readonly');
                        $('#stax_exempted').val('0');
                        $('#exempted').hide();
                         var tax_rate = '1';
                    }
                    $('#tax_rate').val(tax_rate);
                            }                
        });
        
        
    });
	
			
    $('#p_year').change(function() {        
        if($('#tax_applicablefrom').val() != '0'){
        if(($('#p_year').val() != '0') && ($('#upi').val() != '')) {
            $.ajax({
                type: "POST",
                url: baseUrl + "sasdetails/get_enhance",
                data: $('#sasdetails_buildtax').serialize(),                
                dataType:"json",
                async: false,
                success: function(data){       
                            if(data.st == 'invalid'){
                                $("#validn").html(data.msg);
                                $("#validn").addClass("alert-danger alert");                           				
                                $('#p_year').val('0').change();
                            } else if(data.st == 'payed'){                            
                                $("#validn").html(data.msg);
                                $("#validn").addClass("alert-danger alert");                           				
                                $('#p_year').val('0').change(); 
                            } else if(data.st == 'notpayed'){                            
                                var html = '';
                                html+= 'SAS Calculation is not done for following year/s <br>';
                                cities = data.msg;
                                cities.forEach(function(city) {											
                                    html += city+'<br>';
                                });
                                $("#validn").html(html);                        
                                $("#validn").addClass("alert-danger alert");                               					
                                 $('#p_year').val('0').change();
                                } else {
                                    $("#validn").html('');
                                    $("#validn").removeClass("alert-danger alert");
                                    $('#enhancement_tax').val(JSON.parse(data.e_rate));
                                    $('#cess_percent').val(JSON.parse(data.cess));
                                    var g_cents = parseFloat($('#guide_cents').val());
                                    if(g_cents >0){
                                        var value_corn = parseFloat($('#value_corn').val());
                                        if(isNaN(value_corn)) {
                                            value_corn = 0;
                                        }
                                        var  guide_sqft = g_cents / 435.6;  
                                        guide_sqft = guide_sqft.toFixed(2);	
                                        if(isNaN(guide_sqft)) {
                                            guide_sqft = 0;
                                        }
                                        $('#guide_sqft').val(guide_sqft);
                                        var value_total =  parseFloat(guide_sqft) + parseFloat(value_corn);
                                        $('#value_total').val(value_total);
                                        var total_50 = parseFloat($('#value_total').val()) * 0.5;			
                                        var total_50_fix = total_50.toFixed(2);
                                        if(isNaN(total_50_fix)) {
                                            var total_50_fix = 0;
                                        }
                                        $('#guide_50').val(total_50_fix);
                                        $('#guide_50_original').val(total_50);
                                    }
                                }
                    },
                error:function(data){
                    $("#validn").html('Error in Enhacement rate of Tax calculation or Cess amount. Kindly contact Admin');
                    $("#validn").addClass("alert-danger alert");
                    $('#p_year').val('0').change();
                }
            });
        }
    }else {
        $("#validn").html('Please enter Tax Applicable From Year before selecting Payment Year');
        $("#validn").addClass("alert-danger alert");
        $('#p_year').val('0').change();
    }
    });

    $(function() {   
        $('.nextclick').click( function(e){
            if($('#olddata_1').val() == '1'){               
                for(i=1; i<=count; i++){                       
                    $('#age_build_'+i).trigger("change");
                }                
            }
            e.preventDefault();           
            $.ajax({
                type: "POST",
                url: baseUrl + "sasdetails/property",
                data: $('#sasdetails_buildtax').serialize(),
                dataType:"json",
                async: false,
                success: function(data){
                    var obj = jQuery.parseJSON(data.msg);
                    for(var i in obj){
                        $("#validn").html(obj[i]);
                        $("#validn").addClass("alert-danger alert");
                    }
                },
                error : function(data){
                    $("#validn").html('');
                    $("#validn").removeClass("alert-danger alert");
                    $("#payment").removeClass("no-click");
                    exit();
                }
            });
            return false;  
        });  

        $('.multipleRadioOptions').click(function() {    
            $.ajax({
                type: "POST",
                url: baseUrl + "sasdetails/building",
                data: $('#sasdetails_buildtax').serialize(),
                dataType:"json",
                async: false,
                success: function(data){                            
                    if(data.status == true){
                        $("#validn").html('');
                        $("#validn").removeClass("alert-danger alert");
                        if(count >1){
                            $('.remove_'+count).hide();
                        }
                        count++;
                        $("#multiple").show();
                        $("#count").val(count);
                        var content =   '<input type="hidden" name="olddata_'+ count +'" value="0" id="olddata_'+ count +'">'
                                        +'<div class="portlet box blue" id="multiple_details">'
								+'<div class="portlet-title">'
									+'<div class="caption">'
										+'<i class="fa fa-calculator"></i>Building Details/Tax Calculation - Floor'
                                                                        + count
									+'</div>'
									+'<div class="tools">'
										+'<a href="javascript:;" class="collapse">'
										+'</a>'
										+'<a href="#" class="remove remove_'+ count +'" onclick="myfunction()">'
										+'</a>'
									+'</div>'
								+'</div>'
								+'<div class="portlet-body">'
									+'<div class="row">'
											+'<div class="col-lg-6">'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Floor</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" name="floor_'+ count +'" id="floor_'+ count +'">'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Construction Year</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" name="c_year_'+ count +'" id="c_year_'+ count +'">'
													+'</div>'
												+'</div>'
                                                                                                +'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Tax Applicable From</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" name="tax_fromyear_'+ count +'" id="tax_fromyear_'+ count +'" >'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Age of Building (as on 2008-09)</label>'
													+'<div class="col-sm-6">'
													  +'<select class="form-control" name="age_build_'+ count +'" id="age_build_'+ count +'">'														
													  +'</select>'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Depreciation Rate</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" readonly name="depreciation_rate_'+ count +'" id = "depreciation_rate_'+ count +'">'
													+'</div>'
												+'</div>'
                                                                                                +'<div class="form-group c_rate_'+ count +'">'
                                                                                                    +'<label class="col-sm-6 control-label">Construction Rate</label>'
                                                                                                        +'<div class="col-sm-6">'
                                                                                                            +'<label>'
                                                                                                                +'<span class="checked"><input type="radio" name="const_rate_'+ count +'" id="const_rate_'+ count +'" value="city"></span>'
                                                                                                                +'<span class="Cons-top">City</span>'
                                                                                                            +'</label>'
                                                                                                            +'<label>'
                                                                                                                +'<span><input type="radio" name="const_rate_'+ count +'" id="const_rate_'+ count +'" value="rural"></span>'
                                                                                                                +'<span class="Cons-top"> Rural</span>'
                                                                                                            +'</label>'
                                                                                                        +'</div>'
                                                                                                +'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Type of Construction</label>'
													+'<div class="col-sm-6">'
                                                                                                            +'<select class="form-control" name="type_const_'+ count +'" id="type_const_'+ count +'">'
                                                                                                            +'<select>'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Building value per Sq.Ft</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" readonly name="b_value_sqft_'+ count +'" id="b_value_sqft_'+ count +'">'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">50% of the Guidance value</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" readonly name="b_guide_50_'+ count +'" id="b_guide_50_'+ count +'">'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Building area in Sq.Ft</label>'
													+'<div class="col-sm-6">'
													 +'<input type="text" class="form-control" name="b_area_sqft_'+ count +'" id="b_area_sqft_'+ count +'">'
													+'</div>'
												+'</div>'
											+'</div>'
											+'<div class="col-lg-6">'
											+'<div class="form-group">'
											+'<label class="col-sm-6 control-label">Own (0.5) / Rented or Commercial (1.0)</label>'
													+'<div class="col-sm-6">'
													  +' <select class="form-control" name="build_type_'+ count +'" id="build_type_'+ count +'" >'
                                                                                                  +'<option value="0">Select</option>'
                                                                                                  +'<option value="0.5">0.5</option> '                                                                                     
                                                                                          +'<option value="1.0">1.0</option>'
                                                                                          +'</select>'
                                                                                  +'<i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Taxable value of the Land</label>'
													+'<div class="col-sm-6">'
													 +' <input type="text" class="form-control" readonly name="land_tax_value_'+ count +'" id = "land_tax_value_'+ count +'">'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Taxable value of the Building</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" readonly name="build_tax_value_'+ count +'" id="build_tax_value_'+ count +'">'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Applicable Tax</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" readonly name="app_tax_'+ count  +'" id="app_tax_'+ count  +'">'
													+'</div>'
												+'</div>'
												+'<div class="form-group">'
													+'<label class="col-sm-6 control-label">Enhanced Tax</label>'
													+'<div class="col-sm-6">'
													  +'<input type="text" class="form-control" readonly name="b_enhc_tax_'+ count +'" id="b_enhc_tax_'+ count +'">'
													+'</div>'
												+'</div>' 
                                                                                        +'<input type="hidden" class="form-control" readonly name="b_cess_'+ count +'" id = "b_cess_'+ count +'">'
											+'</div>'
									+'</div>'
								+'</div>'
							+'</div>';
                        $('#multiple').append(content);
                        var options="";
                        options+="<option value=''>Select</option>";
                        for(var i=0;i<=numberOfItemsNeeded;i++)
                        {
                            options+="<option value='"+i+"'>"+i+"</option>";
                        }       
                        $("#age_build_"+ count).html(options);
                       // $("#const_rate_"+ count).prop('checked', true);
                        var c_rate = $('input[name=const_rate_1]:checked').val();
                        if(c_rate == 'city'){          
                            $('input:radio[name=const_rate_'+count+'][value=city]').prop('checked', true);
                            var type = 'city';
                            getTypeofConstuction(count,type);
                          //  $('input:radio[name=const_rate_'+count+'][value=city]').change();
                        }else {                            
                            $('input:radio[name=const_rate_'+count+'][value=rural]').prop('checked', true);
                            var type = 'rural';
                            getTypeofConstuction(count,type);
                           // $('input:radio[name=const_rate_'+count+'][value=rural]').change(); 
                        }
                        $('input[name=const_rate_'+count+']').attr("disabled",true);
                    }else {
                        var obj = jQuery.parseJSON(data.msg);
                        for(var i in obj){
                            $("#validn").html(obj[i]);
                            $("#validn").addClass("alert-danger alert");
                        }
                        $('html, body').animate({scrollTop: '0px'}, 300);
                    }			
                },
                error : function(data){
                    $("#validn").html('');
                    $("#validn").removeClass("alert-danger alert");
                    exit();
                }
            }); 
        });
        
        $('.submit').click( function(e){        
            $("#validn").html('');
            $("#validn").removeClass("alert-danger alert");
            var url_path = baseUrl + "sasdetails/buildingtaxcalInfo";
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: baseUrl + "sasdetails/savebldtaxInfo",
                data: $('#sasdetails_buildtax').serialize(),
                dataType:"json",
                async: false,
                success: function(data){
                    if(data.status == true){                    
                        $(".alert-success").html('SAS Application generated successfully for the year '+$('#p_year').val());
                        $("#succss").show().delay(2000).fadeOut();
                        $('html, body').animate({scrollTop: '0px'}, 300);
                        setTimeout(function(){ window.location.href = url_path; }, 2000);
                    }else{                     
                        var obj = jQuery.parseJSON(data.msg);
                        for(var i in obj){
                            $("#validn").html(obj[i]);
                            $("#validn").addClass("alert-danger alert");			
                        }
                        $('html, body').animate({scrollTop: '0px'}, 300);
                    }
                },				
                error : function(data){                 
                    $("#validn").html('Something went wrong. Please try again');
                    $("#validn").addClass("alert-danger alert");
                    $('html, body').animate({scrollTop: '0px'}, 300);
                }
            });
            return false;           
        });	 
    });
    
    $('#tab2').on("change",'[id^=age_build]', function(e){   
    e.preventDefault();
    var aid = $(this).attr('id').replace(/age_build_/, '');
    if($('#age_build_'+aid).val() == ''){        
        $('#depreciation_rate_'+aid).val('');				 
    }else{
        $.ajax({
            type: "POST",
            url: baseUrl + "sasdetails/get_deprcn",
            data: {"age_build":$('#age_build_'+aid).val()},
            dataType:"json",
            success: function(data){
                    $('#depreciation_rate_'+aid).val(JSON.parse(data.rate)); 
                    if($('#build_type_'+aid).val() != '0') {         
                        var area_ratio = $('#area_ratio').val();        
                        var a_sqft = $('#a_sqft').val();
                        var guide_50 = $('#guide_50').val();            
                        var b_area_sqft = $('#b_area_sqft_'+aid).val();
                        var build_type = $('#build_type_'+aid).val();
                        var depreciation_rate = $('#depreciation_rate_'+aid).val();
                        var b_guide_50 = $('#b_guide_50_'+aid).val();        
                        var tax_rate = $('#tax_rate').val();
                        var tax_rate = $('#tax_rate').val().replace('%', '');
                        var enhancement_tax = $('#enhancement_tax').val();
                        var undiv_right = $('#undiv_right').val();
                        var land_tax_value = '';
                        var build_tax_value = '';				
                        if(area_ratio == '' || area_ratio == 0){
                            land_tax_value = (a_sqft * undiv_right * guide_50 * build_type)/100;					
                            var land_tax_value_fx = land_tax_value.toFixed(2);
                            $('#land_tax_value_'+aid).val(land_tax_value_fx);
                        }else{
                            land_tax_value = b_area_sqft * guide_50 * area_ratio * build_type;
                            var land_tax_value_fx = land_tax_value.toFixed(2);					
                            $('#land_tax_value_'+aid).val(land_tax_value_fx);
                        }
                        if(depreciation_rate == 1){				 
                            build_tax_value = (depreciation_rate)* b_area_sqft * b_guide_50 * build_type;
                            build_tax_value = build_tax_value.toFixed(2);
                            $('#build_tax_value_'+aid).val(build_tax_value);
                        }
                        if(depreciation_rate<1){				 
                            build_tax_value = (1-depreciation_rate)* b_area_sqft * b_guide_50 * build_type;
                            build_tax_value = build_tax_value.toFixed(2);
                            $('#build_tax_value_'+aid).val(build_tax_value);
                        }
                        var app_tax = Math.round(land_tax_value+parseFloat(build_tax_value))*tax_rate/100;				
                        app_tax = Math.round(app_tax);
                        $('#app_tax_'+aid).val(app_tax);      
                        var b_enhc_tax = Math.round((app_tax*enhancement_tax)/100)+app_tax;
                        b_enhc_tax = Math.round(b_enhc_tax);    
                        $('#b_enhc_tax_'+aid).val(b_enhc_tax);
                        var cess = $('#cess_percent').val();
                        var cess_percent = (cess/100);
                        var b_cess = Math.round(b_enhc_tax*cess_percent);       
                        $('#b_cess_'+aid).val(b_cess);                       
                    }
            }
        });
    }
});
    



    
//calculate 50% of the Guidance value(Market Value)
//$('#tab2').on("keyup",'[id^=b_value_sqft]', function(e){
 //   if ( $(this).is('[readonly]') ) {     
 //    return true;
//    }
 //   e.preventDefault();  
 //   var bid = $(this).attr('id').replace(/b_value_sqft_/, '');       
 //   b_guide_50 =Math.round( $('#b_value_sqft_'+bid).val()/2);
 //   $('#build_type_'+bid).val('0').change();
 //   $('#b_guide_50_'+bid).val(b_guide_50);
//});


$('#tab2').on("keyup",'[id^=b_area_sqft]', function(e){
    if ( $(this).is('[readonly]') ) {     
     return true;
    }
    e.preventDefault();  
    var bid = $(this).attr('id').replace(/b_area_sqft_/, '');       
    $('#build_type_'+bid).val('0').change();   
});


$('#tab2').on("focusout",'[id^=c_year]', function(e){
    var aid = $(this).attr('id').replace(/c_year_/, '');     
    $construction_year = $(this).val();
    if($construction_year >= '2008-09'){
       $('#age_build_'+aid).val('0');
       $('#age_build_'+aid).trigger("change");
       $('#age_build_'+aid+' option:not(:selected)').prop('disabled', true);
    }
    else{
        $('#age_build_'+aid).val('');
       // $('#age_build_'+aid).trigger("change");
        $('#depreciation_rate_'+aid).val('');
       // $('#age_build_'+aid+' option:(:selected)').prop('disabled', false);
        $('#age_build_'+aid+' option:not(:selected)').prop('disabled', false);
    }   
    
});
   
$("#tax_applicablefrom").on('change',function(){
    $('#p_year').val('0').change();
    $('#tax_applicablefromtextbox').val($(this).val());
});
$('#tab2').on("change",'[id^=build_type]', function(e){  
    e.preventDefault();
    var tid = $(this).attr('id').replace(/build_type_/, '');
    var area_ratio = $('#area_ratio').val();        
    var a_sqft = $('#a_sqft').val();
    var guide_50 = $('#guide_50').val();
    var b_area_sqft = $('#b_area_sqft_'+tid).val();
    var build_type = $('#build_type_'+tid).val();
    var depreciation_rate = $('#depreciation_rate_'+tid).val();
    var b_guide_50 = $('#b_guide_50_'+tid).val();
    var tax_rate = $('#tax_rate').val();
    var tax_rate = $('#tax_rate').val().replace('%', '');
    var enhancement_tax = $('#enhancement_tax').val();
    var undiv_right = $('#undiv_right').val();
    var land_tax_value = '';
    var build_tax_value = '';				
    if(area_ratio == '' || area_ratio == 0){
        land_tax_value = (a_sqft * undiv_right * guide_50 * build_type)/100;					
        var land_tax_value_fx = land_tax_value.toFixed(2);
        $('#land_tax_value_'+tid).val(land_tax_value_fx);
    }else{
        land_tax_value = b_area_sqft * guide_50 * area_ratio * build_type;
        var land_tax_value_fx = land_tax_value.toFixed(2);					
        $('#land_tax_value_'+tid).val(land_tax_value_fx);
    }
    if(depreciation_rate == 1){				 
        build_tax_value = (depreciation_rate)* b_area_sqft * b_guide_50 * build_type;
        build_tax_value = build_tax_value.toFixed(2);
        $('#build_tax_value_'+tid).val(build_tax_value);
    }
    if(depreciation_rate<1){				 
        build_tax_value = (1-depreciation_rate)* b_area_sqft * b_guide_50 * build_type;
        build_tax_value = build_tax_value.toFixed(2);
        $('#build_tax_value_'+tid).val(build_tax_value);
    }
    var app_tax = Math.round(land_tax_value+parseFloat(build_tax_value))*tax_rate/100;				
    app_tax = Math.round(app_tax);
    $('#app_tax_'+tid).val(app_tax);
    var b_enhc_tax = Math.round((app_tax*enhancement_tax)/100)+app_tax;
    b_enhc_tax = Math.round(b_enhc_tax);
    $('#b_enhc_tax_'+tid).val(b_enhc_tax);
    var cess = $('#cess_percent').val();
    var cess_percent = (cess/100);        
    var b_cess = Math.round(b_enhc_tax*cess_percent);
    $('#b_cess_'+tid).val(b_cess);        
});
    
$("#upi").focusout(function(){    
    if($(this).val()){
        var upi = $('#upi').val();
        $('#sasdetails_buildtax').trigger("reset");
        count = 1;
        $("#olddata_1").val('0');
        $("#count").val(count);
        $('#multiple').empty();
        $("#a_cents").attr('readonly',false);
        $("#area_build").attr('readonly',false);
        $("#area_floors").attr('readonly',false);
        $("#undiv_right").attr('readonly',false);
        $("#p_use").attr('readonly',false);
        $("#tax_applicablefrom").show();
        $("#tax_applicablefromtextbox").hide();
        $("#exempted").hide();
        $('.c_rate_1').show();
        $('input[name=corner]').attr("disabled",false);
        $("#floor_1").attr('readonly',false);
        $("#c_year_1").attr('readonly',false);
        $("#type_const_1").attr('readonly',false);
        //$("#b_value_sqft_1").attr('readonly',false);       
        $("#b_area_sqft_1").attr('readonly',false);
        $("#build_type_1").attr('readonly',false);
        $.ajax({
                type: "POST",
                url: baseUrl + "sasdetails/check_upi",
                data: {"upi": upi},
                dataType:"json",
                success: function(data){
                    $("#validn").html('');
                    $("#validn").removeClass("alert-danger alert");  
                    if(data.upistatus == '0') { 
                        $('#upi').val(data.upi);
                        $("#validn").html('UPI number not exists. Kindly add Tax payer General Information first.');
                        $("#validn").addClass("alert-danger alert");  
                    }
                    else if(data.st == '1') {                      
                        $('#upi').val(data.prop['upi']);                       
		        $('#a_cents').val(data.prop['area_cents']);
                        $("#a_cents").attr('readonly','readonly');	
                        $('#a_sqft').val(data.prop['area_sqft']);
                        $("#a_sqft").attr('readonly','readonly');	
                        $('#area_build').val(data.prop['area_build']);
                        $("#area_build").attr('readonly','readonly');	
                        $('#area_floors').val(data.prop['area_floors']);
                        $("#area_floors").attr('readonly','readonly');	
                        $('#area_ratio').val(data.prop['area_ratio']);
                        $("#area_ratio").attr('readonly','readonly');	
                        $('#undiv_right').val(data.prop['undiv_right']);
                        $("#undiv_right").attr('readonly','readonly');	
                        $('#p_use').val(data.prop['p_use']).change();    
                        $("#p_use").attr('readonly','readonly');
                        $('#stax_exempted').val(data.prop['stax_exempted']);    
                        $("#stax_exempted").attr('readonly','readonly');
                        $("#tax_applicablefrom").hide();
                        $("#tax_applicablefromtextbox").show();
                        $('#tax_applicablefromtextbox').val(data.prop['tax_applicablefrom']); 
                        $('#tax_applicablefrom').val(data.prop['tax_applicablefrom']).change();                         
                        $('#p_year').val('0').change();
                       // $('#guide_cents').val(data.prop['value_cents']);			
                       // $('#guide_sqft').val(data.prop['value_sqft']);                        
                        if(data.prop['is_corn'] == '1'){                            
                           $('input:radio[name=corner][value=1]').prop('checked', true);
                        $('input:radio[name=corner][value=1]').click();
                        }else {                            
                            $('input:radio[name=corner][value=0]').prop('checked', true);
                            $('input:radio[name=corner][value=0]').click(); 
                        }
                        $('input[name=corner]').attr("disabled",true);
                        $('.radio-group').append('<input type="hidden" name="corner" value="'+data.prop['is_corn'] +'"/>');
                        $('#value_corn').val(data.prop['value_corn']);                        
                      //  $('#value_total').val(data.prop['value_total']);			
                      //  $('#guide_50').val(data.prop['guide_50']);                        
                        bldtax = data.bld;
                        bldtax.forEach(function(bld) {
                            $('#olddata_'+count).val('1');
                            $('.c_rate_'+count).hide();
                            $('#floor_'+count).val(bld['floor']);
                            $('#floor_'+count).attr('readonly','readonly');
                            if(bld['c_year'] == 0){
                                $('#c_year_'+count).val('');
                            }else {
                                $('#c_year_'+count).val(bld['c_year']);
                            }
                            $('#c_year_'+count).trigger('focusout');
                            $('#c_year_'+count).attr('readonly','readonly');
                            if(bld['tax_applicable_floor'] != '') {
                                $('#tax_fromyear_'+count).val(bld['tax_applicable_floor']);
                               
                            }
                            $('#tax_fromyear_'+count).attr('readonly','readonly');
                            var optn="";
                            optn+="<option value='"+bld['type_const']+"'>"+bld['type_const']+"</option>";
                            $('#type_const_'+count).html(optn);
                            $('#type_const_'+count).attr('readonly','readonly');
                            $('#b_value_sqft_'+count).val(bld['b_value_sqft']);
                            $('#b_value_sqft_'+count).attr('readonly','readonly');
                            $('#b_guide_50_'+count).val(bld['b_guide_50']);
                            $('#b_guide_50_'+count).attr('readonly','readonly');
                            $('#b_area_sqft_'+count).val(bld['b_area_sqft']);
                            $('#b_area_sqft_'+count).attr('readonly','readonly');                          
                            $('#build_type_'+count).val(bld['build_type']);
                            $('#build_type_'+count).attr('readonly','readonly');             
                            if(data.bldcount != count){
                                count++;
                                $("#multiple").show();
                                $("#count").val(count);
                                var content = '<input type="hidden" name="olddata_'+ count +'" id="olddata_'+ count +'">'
                                        +'<div class="portlet box blue" id="multiple_details">'
                                            +'<div class="portlet-title">'
                                                    +'<div class="caption">'
                                                            +'<i class="fa fa-calculator"></i>Building Details/Tax Calculation - Floor'
                                                    + count
                                                    +'</div>'
                                                    +'<div class="tools">'
                                                            +'<a href="javascript:;" class="collapse">'
                                                            +'</a>'
                                                            +'<a href="javascript:;" class="remove">'
                                                            +'</a>'
                                                    +'</div>'
                                            +'</div>'
                                            +'<div class="portlet-body">'
                                                    +'<div class="row">'
                                                                    +'<div class="col-lg-6">'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Floor</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" name="floor_'+ count +'" id="floor_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Construction Year</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" name="c_year_'+ count +'" id="c_year_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Tax Applicable From</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" name="tax_fromyear_'+ count +'" id="tax_fromyear_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Age of Building (as on 2008-09)</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<select class="form-control" name="age_build_'+ count +'" id="age_build_'+ count +'">'														
                                                                                      +'</select>'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Depreciation Rate</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" readonly name="depreciation_rate_'+ count +'" id = "depreciation_rate_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'                                                                   
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Type of Construction</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                        +'<select class="form-control" name="type_const_'+ count +'" id="type_const_'+ count +'">'
                                                                                        +'<select>'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Building value per Sq.Ft</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" name="b_value_sqft_'+ count +'" id="b_value_sqft_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">50% of the Guidance value</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" readonly name="b_guide_50_'+ count +'" id="b_guide_50_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Building area in Sq.Ft</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                     +'<input type="text" class="form-control" name="b_area_sqft_'+ count +'" id="b_area_sqft_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                    +'</div>'
                                                                    +'<div class="col-lg-6">'
                                                                    +'<div class="form-group">'
                                                                    +'<label class="col-sm-6 control-label">Own (0.5) / Rented or Commercial (1.0)</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +' <select class="form-control" name="build_type_'+ count +'" id="build_type_'+ count +'" >'
                                                                              +'<option value="0">Select</option>'
                                                                              +'<option value="0.50">0.50</option> '                                                                                     
                                                                      +'<option value="1.00">1.00</option>'
                                                                      +'</select>'
                                                              +'<i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Taxable value of the Land</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                     +' <input type="text" class="form-control" readonly name="land_tax_value_'+ count +'" id = "land_tax_value_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Taxable value of the Building</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" readonly name="build_tax_value_'+ count +'" id="build_tax_value_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Applicable Tax</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" readonly name="app_tax_'+ count  +'" id="app_tax_'+ count  +'">'
                                                                                    +'</div>'
                                                                            +'</div>'
                                                                            +'<div class="form-group">'
                                                                                    +'<label class="col-sm-6 control-label">Enhanced Tax</label>'
                                                                                    +'<div class="col-sm-6">'
                                                                                      +'<input type="text" class="form-control" readonly name="b_enhc_tax_'+ count +'" id="b_enhc_tax_'+ count +'">'
                                                                                    +'</div>'
                                                                            +'</div>' 
                                                                    +'<input type="hidden" class="form-control" name="b_cess_'+ count +'" id = "b_cess_'+ count +'">'
                                                                    +'</div>'
                                                    +'</div>'
                                            +'</div>'
                                    +'</div>';
                                $('#multiple').append(content);
                                var options="";
                                options+="<option value=''>Select</option>";                               
                                for(var i=0;i<=numberOfItemsNeeded;i++)
                                {
                                    options+="<option value='"+i+"'>"+i+"</option>";
                                }       
                                $("#age_build_"+ count).html(options);
                            }                            
                        });                        
		    }
                    else if(data.st == '0') {
                        $('#upi').val(data.upi);
                   //     $('#guide_cents').val(data.gval).keyup();
                   //     $("#guide_cents").attr('readonly','readonly');
                    }
                }                
        });
    }
   });
    
    $('input[name=corner]').click(function () {
            if (this.id == "yes-corner") {
                    var guide_sqft = parseFloat($('#guide_sqft').val());
                    var cornerval = guide_sqft*0.10;
                    cornerval = cornerval.toFixed(2);
                    if(isNaN(cornerval)) {
                        $('#value_corn').val('0');
                    }else{
                        $('#value_corn').val(cornerval);
                    }
                    $("#corner-container").slideDown('slow');
                    var value_corn = parseFloat($('#value_corn').val());
                    if(isNaN(value_corn)) {
                        value_corn = 0;
                    }
                    var total = value_corn + parseFloat($('#guide_sqft').val());
                    total = total.toFixed(2);
                    if(isNaN(total)) {
                        var total = 0;                       
                    }
                    $("#value_total").val(total);
                    var total_50 = total* 0.5;
                    var total_50_fix = total_50.toFixed(2);	
                    if(isNaN(total_50_fix)) {
                        var total_50_fix = 0;
                        var total_50 = 0;
                    }
                    $('#guide_50').val(total_50_fix);
                    $('#guide_50_original').val(total_50);
            } else {
                    $('#value_corn').val('');
                    $("#corner-container").slideUp('slow');
                    var cornerval = 0;
                    var total = cornerval + parseFloat($('#guide_sqft').val());
                    total = total.toFixed(2);                    
                    $("#value_total").val(total);
                    var total_50 = total* 0.5;
                    var total_50_fix = total_50.toFixed(2);	
                    if(isNaN(total_50_fix)) {
                        var total_50_fix = 0;
                        var total_50 = 0;
                    }
                    $('#guide_50').val(total_50_fix);
                    $('#guide_50_original').val(total_50);
            }
    });
    
    $('#tab2').on("change",'[name^=const_rate]', function(e){    
        var aid = $(this).attr('id').replace(/const_rate_/, '');
        $('#b_value_sqft_'+aid).val('');
        $('#build_type_'+aid).val('0').change();
        $('#b_guide_50_'+aid).val(''); 
        var const_rate = $(this).val();
            $.ajax({
            type: 'post',
            url: baseUrl + "sasdetails/getConstructionNames",
            data: {
                get_option:$(this).val()
            },
            success: function (response) {
               // console.log(response);
                $("#type_const_"+ aid).html(response);
                if(count > 1) {
                    for(i=2; i<=count; i++){                       
                        if(const_rate == 'city'){          
                            $('input:radio[name=const_rate_'+i+'][value=city]').prop('checked', true);
                            //$('input:radio[name=const_rate_'+i+'][value=city]').change();
                        }else {                            
                            $('input:radio[name=const_rate_'+i+'][value=rural]').prop('checked', true);
                            //$('input:radio[name=const_rate_'+i+'][value=rural]').change(); 
                        }
                        $("#type_const_"+ i).html(response);
                        $('#b_value_sqft_'+i).val('');
                        $('#build_type_'+i).val('0').change();
                        $('#b_guide_50_'+i).val('');
                    }
                }                
               // document.getElementById("type_const_"+aid+"").innerHTML=response;
            }
        });
    });
    
    $('#tab2').on("change",'[name^=type_const]', function(e){    
        var aid = $(this).attr('id').replace(/type_const_/, '');        
       var c_rate = $('input[name=const_rate_'+aid+']:checked').val();       
        var c_type = $("#type_const_"+aid).val();
        if(c_type != ''){
        var floor = $("#floor_"+aid).val();
            $.ajax({
            type: 'post',
            url: baseUrl + "sasdetails/getBuildingValue",
            data: {
                c_rate : c_rate,
                c_type : c_type,
                floor : floor
            },
            success: function (response) {
                console.log(response); 
                $('#b_value_sqft_'+aid).val(response);
                b_guide_50 =Math.round( $('#b_value_sqft_'+aid).val()/2);
                $('#build_type_'+aid).val('0').change();
                $('#b_guide_50_'+aid).val(b_guide_50);               
            }
        });
    }else {
        $('#b_value_sqft_'+aid).val('');
        $('#b_guide_50_'+aid).val('');
        $('#build_type_'+aid).val('0').change();        
    }
    });
    
    $('#tab2').on("keyup",'[name^=floor]', function(e){        
        var aid = $(this).attr('id').replace(/floor_/, '');        
            $("#type_const_"+aid).val('');
            $('#b_value_sqft_'+aid).val('');
            $('#build_type_'+aid).val('0').change();
            $('#b_guide_50_'+aid).val('');        
    });
    
});
   
function myfunction() {     
    count--;
    if(count >1){
        $('.remove_'+count).show();
    }
    $("#count").val(count);     
}

function getTypeofConstuction(cnt,val) {    
    $.ajax({
            type: 'post',
            url: baseUrl + "sasdetails/getConstructionNames",
            data: {
                get_option:val
            },
            success: function (response) {
               // console.log(response);
                $("#type_const_"+ cnt).html(response);                
               // document.getElementById("type_const_"+aid+"").innerHTML=response;
            }
        });
    
   // $('input:radio[name=const_rate_'+cnt+'][value='+val+']').change();   
}

$(window).load(function () {   
    setTimeout(function() {
        $('#upi').focus();
    }, 100);
});