/*--
 Author Diya Systems
 The main core script which handles tax calculation functions
 --*/

//accept only numbers
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
            .bind("paste", function (e) {
                var validNumber = /^[-]?\d+(\.\d{1,2})?$/;
                element.data('oldValue', element.val())
                setTimeout(function () {
                    if (!validNumber.test(element.val()))
                        element.val(element.data('oldValue'));
                }, 0);
            });
    element
            .keypress(function (event) {
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

    $('#property_tax').keyup(function () {
        var property_tax = $('#property_tax').val();
        var b_enhc_tax = $('#b_enhc_tax').val();
        var difference = parseInt(b_enhc_tax) - parseInt(property_tax);


        if (isNaN(difference)) {
            $('#difference').val(0);
        } else {
            $('#difference').val(difference);
        }

        if ($('#p_112C').val() == 1) {
            var penalty_112C = property_tax;
            $('#penalty_112C').val(penalty_112C);
        } else {
            $('#penalty_112C').val('');
        }
    });



    $('#p_year').change(function () {

        $.ajax({
            type: "POST",
            url: "sasdetails/get_enhance",
            data: $('#sasdetails').serialize(),
            //data: {"year":$('#p_year').val()},
            dataType: "json",
            success: function (data) {
                var check_pay = JSON.parse(data.st);
                if (check_pay == 1) {
                    var obj = jQuery.parseJSON(data.msg);
                    for (var i in obj) {
                        $("#validn").html(obj[i]);
                        $("#validn").addClass("alert-danger alert");
                    }
                    /*$("#p_year").val([]);*/
                    $('#p_year').val('0').trigger('change');
                } else {
                    $("#validn").html('');
                    $("#validn").removeClass("alert-danger alert");
                }

                $('#enhancement_tax').val(JSON.parse(data.rate));
                var g_cents = parseFloat($('#guide_cents').val());
                if (g_cents > 0) {
                    var value_corn = parseFloat($('#value_corn').val());

                    if (isNaN(value_corn)) {
                        value_corn = 0;
                    }

                    var guide_sqft = g_cents / 435.6;
                    guide_sqft = guide_sqft.toFixed(2);

                    if (isNaN(guide_sqft)) {
                        guide_sqft = 0;
                    }

                    $('#guide_sqft').val(guide_sqft);

                    var value_total = parseFloat(guide_sqft) + parseFloat(value_corn);
                    $('#value_total').val(value_total);

                    var total_50 = parseFloat($('#value_total').val()) * 0.5;
                    var total_50_fix = total_50.toFixed(2);

                    if (isNaN(total_50_fix)) {
                        var total_50_fix = 0;
                    }

                    $('#guide_50').val(total_50_fix);
                    $('#guide_50_original').val(total_50);

                }

            }
        });
    });

    $('#payment_date').change(function () {
  $('#error').hide();
        var payment_date = $('#payment_date').val();
		
        var p_year = $('#p_year').val();
        $.ajax({

            type: "POST",
            url: "get_penalty",
            data: {'payment_date': payment_date, 'p_year': p_year},
            dataType: "json",
            async: false,
            success: function (data) {
                var payment_date = $('#payment_date').val();
				var selectdate = payment_date.split("-");				
				var assesmentdate = p_year.split("-");		
				
				if(selectdate[0] < assesmentdate[0])
				{
				
				  $('#error').show();
				$('#rebate').val('');
				  $('#penalty').val('');
				 $('#ex_rebate').val('');
				 $('#payable_total').val('');
				  $('#service_tax').val('');
				    $('#p_total').val('');
					  $('#payment_date').val('');
					
				return false;
				}
				if(payment_date != '')
				{
				
                var month = JSON.parse(data.month);

                var r_month = JSON.parse(data.r_month);

                var property_tax = isNaN(parseInt($('#property_tax').val())) ? 0 : parseInt($('#property_tax').val());
                var penalty_112C = isNaN(parseInt($('#penalty_112C').val())) ? 0 : parseInt($('#penalty_112C').val());
                var swm_cess = isNaN(parseInt($('#swm_cess').val())) ? 0 : parseInt($('#swm_cess').val());
                var cess = isNaN(parseInt($('#cess').val())) ? 0 : parseInt($('#cess').val());
                var adjustment = isNaN(parseInt($('#adjustment').val())) ? 0 : parseInt($('#adjustment').val());
                if (month > 0) {
                    var penalty = (property_tax * 2 * month) / 100;
                    penalty = Math.floor(penalty);
                    var rebate = 0;
                    $('#penalty').val(penalty);
                    $('#rebate').val('');

                } else {
                    $('#penalty').val('');
                }

                if (r_month <= 4 && r_month != 0) {
                    var rebate = (property_tax * 5) / 100;
                    rebate = Math.floor(rebate);
                    var penalty = 0;
                    $('#rebate').val(rebate);
                    $('#penalty').val('');
                } else {
                    $('#rebate').val('');
                }

                var stax_exempted = $('#stax_exempted').val();
                var ex_serviceman = $('#ex_serviceman').val();
				  var penalty112cval = $('#penalty112cval').val();
                if (stax_exempted == 1)
                {
					 var payable_total = (property_tax + cess + penalty - rebate);
					  $('#payable_total').val(payable_total);
                    var service_tax = (payable_total * 25) / 100;
					
					 $('#service_tax').val(service_tax);
					 var p_total = service_tax + swm_cess + adjustment;
                }
               else if (ex_serviceman == 1)
                {
					 var payable_total = (property_tax + cess + penalty - rebate);
					  $('#payable_total').val(payable_total);
                    var ex_rebate = (payable_total * 50) / 100;
					
					  $('#ex_rebate').val(ex_rebate);
					  var p_total = ex_rebate + swm_cess + adjustment;
                }
				else if(penalty112cval == 1)
				{
					 var payable_total = (property_tax + penalty_112C + cess + penalty - rebate);
					 $('#payable_total').val(payable_total);
					var penalty_112c = payable_total;
					
					
					 var p_total = penalty_112c + swm_cess +  adjustment;
				}
				else
				{
				 var payable_total = (property_tax + cess + penalty - rebate) ;
				 $('#payable_total').val(payable_total);
				 //var penalty_112c = payable_total;
					
					
					 var p_total = payable_total + swm_cess +  adjustment;
				}

             

                $('#p_total').val(p_total);
				}
				else
				{

				 $('#rebate').val('');
				  $('#penalty').val('');
				 $('#ex_rebate').val('');
				 $('#payable_total').val('');
				  $('#service_tax').val('');
				    $('#p_total').val('');
				}
            }
        });
    });


    $("#adjustment").on("keyup", function (event) {
        event.preventDefault();

        var penalty = isNaN(parseInt($('#penalty').val())) ? 0 : parseInt($('#penalty').val());
        var rebate = isNaN(parseInt($('#rebate').val())) ? 0 : parseInt($('#rebate').val());
        var property_tax = isNaN(parseInt($('#property_tax').val())) ? 0 : parseInt($('#property_tax').val());
        var penalty_112C = isNaN(parseInt($('#penalty_112C').val())) ? 0 : parseInt($('#penalty_112C').val());
        var swm_cess = isNaN(parseInt($('#swm_cess').val())) ? 0 : parseInt($('#swm_cess').val());
        var cess = isNaN(parseInt($('#cess').val())) ? 0 : parseInt($('#cess').val());

        var adjustment = isNaN(parseInt($('#adjustment').val())) ? 0 : parseInt($('#adjustment').val());

         var stax_exempted = $('#stax_exempted').val();
                var ex_serviceman = $('#ex_serviceman').val();
				  var penalty112cval = $('#penalty112cval').val();
                if (stax_exempted == 1)
                {
					 var payable_total = (property_tax + cess + penalty - rebate);
					  $('#payable_total').val(payable_total);
                    var service_tax = (payable_total * 25) / 100;
					
					 $('#service_tax').val(service_tax);
					 var p_total = service_tax + swm_cess + adjustment;
                }
               else if (ex_serviceman == 1)
                {
					 var payable_total = (property_tax + cess + penalty - rebate);
					  $('#payable_total').val(payable_total);
                    var ex_rebate = (payable_total * 50) / 100;
					
					  $('#ex_rebate').val(ex_rebate);
					  var p_total = ex_rebate + swm_cess + adjustment;
                }
				else if(penalty112cval == 1)
				{
					 var payable_total = (property_tax + penalty_112C + cess + penalty - rebate);
					
					 $('#payable_total').val(payable_total);
					var penalty_112c = payable_total;
					
					
					 var p_total = penalty_112c + swm_cess +  adjustment;
				}
				else
				{
				 var payable_total = (property_tax + cess + penalty - rebate) ;
				 $('#payable_total').val(payable_total);
				 //var penalty_112c = payable_total;
					
					
					 var p_total = payable_total + swm_cess +  adjustment;
				}

                $('#p_total').val(p_total);


    });
    
    $(function () {

        $('#submit').click(function (e) {
            if ($('#name_bank').val().length > 0) {
                $('#is_payed').val('1');
            }
            /* $("#sasdetails").submit();*/
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "sasdetails/gen_info",
                data: $('#sasdetails').serialize(),
                dataType: "json",
                async: false,
                success: function (data) {
                    var obj = jQuery.parseJSON(data.msg);
                    for (var i in obj) {
                        $("#validn").html(obj[i]);
                        $("#validn").addClass("alert-danger alert");
                    }
                },
                error: function (data) {
                    window.location = 'sas'
                }
            });

            return false;

            return false;
        });



    });

});
