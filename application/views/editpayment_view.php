<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<style>
    .rootwizard .pager .finish input{
        border-radius: 10px;
        background-color: #16a086;
        border: none;
        border-bottom: 5px solid #12806b;
        color: #fff;
        padding: 10px 20px; 
    }

</style>
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>

<div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title" id="paymentEdit">
							<i class="fa fa-edit"></i>Payment Details
							<div class="date-display">
								<i class="icon-calendar"></i>
								<span id="datetime"></span>
								<span id="datetime2"></span>
							</div>
                        </h3>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN CONTENT -->
				
				<div class="payment-detail-buttons">
					<label><input type="radio" checked name="colorRadio" value="old"> Old Data</label>
					<label><input type="radio" name="colorRadio" value="new"> New Data</label>
				</div>
       <div class="old optionpayment">
					<form class="form-horizontal">
						<div class="portlet box green-seagreen">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-credit-card"></i>Payment Details
								</div>
							</div>
							<?php 
							if($checkpayment) {  $checkpayment[0]['datas']; };
							
						?>
						<input type="hidden" value="<?php if($checkpayment) { echo $checkpayment[0]['datas']; } ?>" name="data" id="data">
							<div class="portlet-body">
								<div class="row">
									<div class="col-lg-6">											
										<div class="form-group">
											<label class="col-sm-6 control-label">Property Tax</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="property_taxs" id="property_taxs" onkeypress="return isNumber(event)" value="<?php if($checkpayment) { echo $checkpayment[0]['property_tax']; }?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Date of Payment</label>
											<div class="col-sm-6">
												<div class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" id="minToday">
													<input class="form-control" size="16" type="text"  name="payment_dates" id="payment_dates" value="<?php if($checkpayment) { echo $checkpayment[0]['payment_date']; } ?>">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Rebate</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="rebates" id="rebates" onkeypress="return isNumber(event)" value="<?php if($checkpayment) {echo $checkpayment[0]['rebate'];}?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Cess</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="cesss" id="cesss" onkeypress="return isNumber(event)" value="<?php if($checkpayment) {echo $checkpayment[0]['cess'];}?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Penalty</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="penaltys" id="penaltys" onkeypress="return isNumber(event)" value="<?php if($checkpayment) {echo $checkpayment[0]['penalty'];}?>">
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-6 control-label">Total Amount Payable</label>
											<div class="col-sm-6">
												<input type="text" class="form-control"  onkeypress="return isNumber(event)" name="payable_totals" id="payable_totals" value="<?php if($checkpayment) {echo $checkpayment[0]['p_total'];}?>">
											</div>
										</div>																						
										<div class="form-group">
											<label class="col-sm-6 control-label">Penalty as per 112C</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="penalty_112Cs" id="penalty_112Cs" onkeypress="return isNumber(event)" value="<?php if($checkpayment) {echo $checkpayment[0]['penalty_112C'];}?>">
											</div>
										</div>	
										 <?php if ($stax_exempted == 1) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Service Charges<br>
                                                            <h6 class="EX-tax">( Exempted property )</h6>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="service_taxs" id="service_taxs" value="<?php if($checkpayment) {echo $checkpayment[0]['service_tax'];}?>" readonly="0">
                                                        </div>
                                                    </div>	
                                                <?php } ?>
                                                <?php if ($ex_serviceman == 1) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Rebate for Ex-Serviceman</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="ex_rebates" id="ex_rebates"  readonly="0" value="<?php  if ($checkpayment) { echo $checkpayment[0]['ex_service_man']; } ?>" readonly="0">
                                                        </div>
                                                    </div>
                                                <?php } ?>																																	
										<div class="form-group">
											<label class="col-sm-6 control-label">SWM Cess</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="swm_cesss"  id="swm_cesss"onkeypress="return isNumber(event)" value="<?php if($checkpayment) {echo $checkpayment[0]['SWM_cess'];}?>">
											</div>
										</div>												
										<div class="form-group">
											<label class="col-sm-6 control-label">Adjustments if any</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="adjustments" id="adjustments" value="<?php  if($checkpayment) { echo $checkpayment[0]['adjustment'];}?>">
											</div>
										</div>																								
										<div class="form-group">
											<label class="col-sm-6 control-label">Total</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="p_totals" id="p_totals" onkeypress="return isNumber(event)" value="<?php if($checkpayment) {echo $checkpayment[0]['p_total'];}?>">
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label class="col-sm-6 control-label">Challan No.</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="challan_nos" id="challan_nos" value="<?php  if($checkpayment) { echo $checkpayment[0]['challan_no']; }?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Name of Bank</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="name_banks" id="name_banks" value="<?php if($checkpayment) { echo $checkpayment[0]['name_bank'];}?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Name of Branch</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="name_branchs" id="name_branchs" value="<?php if($checkpayment) { echo $checkpayment[0]['name_branch'];}?>">
											</div>
										</div>												
										<div class="form-group">
											<label class="col-sm-6 control-label">Difference if any</label>
											<div class="col-sm-6">
												<input type="text" class="form-control" name="differences" id="differences" value="<?php if($checkpayment) { echo $checkpayment[0]['difference']; }?>">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-6 control-label">Remarks</label>
											<div class="col-sm-6">
												<textarea class="form-control" maxlength="50"  name="remarkss" id="remarkss"><?php if($checkpayment) {echo $checkpayment[0]['remarks'];}?></textarea>
												
											</div>													
										</div>												
										<input type="hidden" class="form-control" readonly="" name="is_payed" id="is_payed" value="0">											
									</div>										
								</div>
								<ul class="DSH-L text-ul">
									<li>If amount already deducted by bank & not updated in Mangaluru City Corporation (MCC) system, please wait till end of the next working day.</li>
								</ul>	
							</div>					
						</div>
					</form>
				</div>
        <div class="new optionpayment" style="display:none">
					<form class="form-horizontal">
						<div class="portlet box green-seagreen">
							<div class="portlet-title">
								<div class="caption">
                                            <i class="fa fa-credit-card"></i>Payment Details
                                        </div>
                                    </div>
                                    <?php
									
									
                                    foreach ($get_build_area_property_type as $gb) {
                                        $area_build = $gb->area_build;
                                        $p_use = $gb->p_use;										
										$p_years = explode("-", $p_year);
										if($p_years[0] >= 2015)
										{
										$build = build_area_prop_type($area_build, $p_use,$p_year);
										}
										else
										{
										$build = 0;
										}
                                        $p_tax = $info[0]['b_enhc_tax'];
                                        $cess_percent = $cess / 100;
                                        $b_cess = round($p_tax * $cess_percent);
                                        $penalty_112c = (($p_tax * 2) + ($b_cess));
                                    }
                                    ?>
									
									
									<input type="hidden" class="form-control" name="assmtno" id="assmtno" value="<?php echo $assmtno; ?>">
                                    <input type="hidden" class="form-control" name="ex_serviceman" id="ex_serviceman" value="<?php echo $ex_serviceman; ?>">
                                    <input type="hidden" class="form-control" name="stax_exempted" id="stax_exempted" value="<?php echo $stax_exempted; ?>">
                                    <input type="hidden" class="form-control" name="cess_percent" id="cess_percent" value="<?php echo $cess; ?>">
                                    <input type="hidden" class="form-control" name="penalty112cval" id="penalty112cval" value="<?php echo $get_112c; ?>">
									
								
                                    <div class="portlet-body">
									<div id = "error" style="display:none;color:red;font-size:16px">Payment year cannot be less than the assessment year</div>
									<br>
                                        <div class="row">
											 
                                            <div class="col-lg-6">											
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Property Tax</label>
                                                    <div class="col-sm-6">		   
                                                        <input type="text" class="form-control" name="property_tax" id="property_tax" value="<?php echo $p_tax; ?>" readonly="0">
                                                    </div>
                                                </div>
                                                <?php if ($get_112c == 1) { ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Penalty as per 112C</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="penalty_112C" id="penalty_112C" value="<?php echo $p_tax; ?>" readonly="0">

                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <input type="hidden" class="form-control"  name= "p_year" id="p_year" value="<?php echo $p_year; ?>" readonly>
                                                <input type="hidden" class="form-control"  name= "propId" id="propId" value="<?php echo $propId; ?>" readonly>
                                                <input type="hidden" class="form-control"  name= "upi" id="upi" value="<?php echo $upi; ?>" readonly>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Date of Payment</label>
                                                    <div class="col-sm-6">
                                                        <div class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" id="maxToday">
                                                            <input class="form-control" size="16" type="text" value="<?php
                                                            if ($infos) {
                                                                echo $infos[0]['payment_date'];
                                                            }
                                                            ?>"  name="payment_date" id="payment_date" required>
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        </div>
							
                                                    </div>
													
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Rebate</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="rebate" id="rebate" readonly="0" value="<?php  if ($infos) { echo $infos[0]['rebate']; } ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Cess</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="cess"  id="cess" value="<?php echo $b_cess; ?>" readonly="0">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Penalty</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="penalty" id="penalty" value="<?php
                                                        if ($infos) {
                                                            echo $infos[0]['penalty'];
                                                        }
                                                        ?>" readonly="0" required>
                                                    </div>
                                                </div>
                                                <?php //if (($stax_exempted == 1) || ($ex_serviceman == 1)) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Total Amount Payable</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="payable_total" id="payable_total" readonly="0" value="<?php  if ($infos) { echo $infos[0]['payable_total']; } ?>">
                                                        </div>
                                                    </div>		
                                                <?php //} ?>												

                                                <?php if ($stax_exempted == 1) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Service Charges<br>
                                                            <h6 class="EX-tax">( Exempted property )</h6>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="service_tax" id="service_tax" value="<?php  if ($infos) { echo $infos[0]['service_tax'];} ?>" readonly="0">
                                                        </div>
                                                    </div>	
                                                <?php } ?>
                                                <?php if ($ex_serviceman == 1) {
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Rebate for Ex-Serviceman</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="ex_rebate" id="ex_rebate"  readonly="0" value="<?php  if ($infos) { echo $infos[0]['ex_service_man']; } ?>" readonly="0">
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">SWM Cess</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="swm_cess" id="swm_cess" value="<?php echo $build ?>" readonly="0">
                                                    </div>
                                                </div>											
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Adjustments if any</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="adjustment"  id="adjustment" value="<?php
                                                        if ($infos) {
                                                            echo $infos[0]['adjustment'];
                                                        }
                                                        ?> " />
                                                    </div>
                                                </div>																								
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Total</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="p_total" id="p_total" value="<?php
                                                        if ($infos) {
                                                            echo $infos[0]['p_total'];
                                                        }
                                                        ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <!--<div class="form-group">
                                                    <label class="col-sm-6 control-label">Challan No.</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="challan_no" id="challan_no" value="<?php
                                                       /* if ($infos) {
                                                            echo $infos[0]['challan_no'];
                                                        }*/
                                                        ?>" maxlength="10" required>
                                                    </div>
                                                </div>-->
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Name of Bank</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="name_bank" id="name_bank" value="<?php
                                                        if ($infos) {
                                                            echo $infos[0]['name_bank'];
                                                        }
                                                        ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Name of Branch</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="name_branch" id="name_branch" value="<?php
                                                        if ($infos) {
                                                            echo $infos[0]['name_branch'];
                                                        }
                                                        ?>">
                                                    </div>
                                                </div>												                                              
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Remarks</label>
                                                    <div class="col-sm-6"> 
                                                        <textarea class="form-control" maxlength="50"  name="remarks" id="remarks"><?php
                                                            if ($infos) {
                                                                echo $infos[0]['remarks'];
                                                            }
                                                            ?></textarea>
                                                    </div>													
                                                </div>											
                                                <input type="hidden" class="form-control" readonly="" name="is_payed" id="is_payed" value="0">											
                                            </div>										
                                        </div>
                                        <ul class="DSH-L text-ul">
										<li>Challan will be generated only after realization of cheque/DD</li>
                                            <li>If amount already deducted by bank & not updated in Mangaluru City Corporation (MCC) system, please wait till end of the next working day.</li>
                                        </ul>	
                                    </div>	

                                </div>
                     </form>
				</div>
				<div class="rootwizard">
                            <ul class="pager wizard">
							
                              		
                           

                                <li class="finish" ><input type="button" id="generatechallan" value="Generate Challan and Pay"  data-placement="left" title="" />  </li>		
                                <?php if ($infos) { ?>
                                    
									<li class="finish"><a class="disable-btn" href=""><i class="fa fa-check"></i> Saved</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <li class="finish" id="save">	 <input type="button" id="paymentsubmit" value="Save and Close" style="margin-right:10px" />  </li> 
									
                                <?php } ?>
                               
								<li class="finish"  style="display:none"><a class="disable-btn" href=""><i class="fa fa-check"></i> Saved</a></li>
                            			</ul>
										</div>
				</div>
            </div>
                <!-- END CONTENT -->
           </div>
       </div>
   </div>


<?php

function build_area_prop_type($area_build, $p_use,$p_year) {

    switch (true) {

        case (($area_build <= 500) && ($p_use == 'IND' || $p_use == 'RES' || $p_use == 'NRS') && $p_year):
            // I'm guessing this is an error
            return getvalue(0, 500, $p_use,$p_year);
            break;
        case (($area_build >= 501 && $area_build <= 1000) && ($p_use == 'IND' || $p_use == 'RES' || $p_use == 'NRS') && $p_year ):
            return getvalue(501, 1000, $p_use,$p_year);
            break;

        case (($area_build >= 1001 && $area_build) <= 2000 && ($p_use == 'IND' || $p_use == 'RES' || $p_use == 'NRS') && $p_year):
            return getvalue(1001, 2000, $p_use,$p_year);
            break;

        case (($area_build > 2000) && ($p_use == 'IND' || $p_use == 'RES' || $p_use == 'COM-VAC') && $p_year):

            return getvalue(2000, 0, $p_use,$p_year);
            break;

        default:
            return 0;
    }
}
?>


<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

<script>
    function add_number() {

        var penalty = isNaN(parseInt(document.getElementById('#penalty').value)) ? 0 : parseInt(document.getElementById('#penalty').val());
        var rebate = isNaN(parseInt(document.getElementById('#rebate').val())) ? 0 : parseInt(document.getElementById('#rebate').val());
        var property_tax = isNaN(parseInt(document.getElementById('#property_tax').val())) ? 0 : parseInt(document.getElementById('#property_tax').val());
        var penalty_112C = isNaN(parseInt(document.getElementById('#penalty_112C').val())) ? 0 : parseInt(document.getElementById('#penalty_112C').val());
        var swm_cess = isNaN(parseInt(document.getElementById('#swm_cess').val())) ? 0 : parseInt(document.getElementById('#swm_cess').val());
        var cess = isNaN(parseInt(document.getElementById('#cess').val())) ? 0 : parseInt(document.getElementById('#cess').val());
        var service_tax = isNaN(parseInt(document.getElementById('#service_tax').val())) ? 0 : parseInt(document.getElementById('#service_tax').val());
        var ex_rebate = isNaN(parseInt(document.getElementById('#ex_rebate').val())) ? 0 : parseInt(document.getElementById('#ex_rebate').val());
        var adjustment = isNaN(parseInt(document.getElementById('#adjustment').val())) ? 0 : parseInt(document.getElementById('#adjustment').val());
        var p_total = property_tax + penalty_112C + swm_cess + service_tax + cess + penalty - rebate - ex_rebate;
        $('#p_total').val(p_total);

    }
</script>
<script type="text/javascript">
    $("#paymentsubmit").click(function () {
	var colorRadio=$('input[name=colorRadio]:checked').val()

	  var upi = $("#upi").val();
	   var assmtno = $("#assmtno").val();
 if(assmtno=='undefined')
 {
 var assmtno='';
 }
 if(colorRadio=='new')
		{
		 var payable_total = $("#payable_total").val();
        var property_tax = $("#property_tax").val();
        var penalty_112C = $("#penalty_112C").val();
        var service_tax = $("#service_tax").val();
        var ex_rebate = $("#ex_rebate").val();
        var cess = $("#cess").val();
        var swm_cess = $("#swm_cess").val();
        var adjustment = $("#adjustment").val();
        var penalty = $("#penalty").val();
        var rebate = $("#rebate").val();
        var p_total = $("#p_total").val();
       //var challan_no = $("#challan_no").val();
        var name_bank = $("#name_bank").val();
        var name_branch = $("#name_branch").val();
        var p_year = $("#p_year").val();
        var payment_date = $("#payment_date").val();
        var difference = $("#difference").val();
        var remarks = $("textarea#remarks").val();

        var propId = $("#propId").val();
        var dataString = 'property_tax=' + property_tax + '&payable_total=' + payable_total + '&penalty_112C=' + penalty_112C + '&service_tax=' + service_tax + '&ex_rebate=' + ex_rebate + '&cess=' + cess + '&swm_cess=' + swm_cess + '&adjustment=' + adjustment + '&penalty=' + penalty + '&rebate=' + rebate + '&p_total=' + p_total + 
                '&name_bank=' + name_bank + '&name_branch=' + name_branch + '&payment_date=' + payment_date +  '&upi=' + upi + '&difference=' + difference + '&remarks=' + remarks + '&propId=' + propId + '&p_year=' + p_year + '&colorRadio=' +colorRadio;

			//return false;
        if (payment_date == "")
        {
            $("#payment_date").focus();
            return false;
        }
		}
		else
		{
		
		 var payable_total = $("#payable_totals").val();
        var property_tax = $("#property_taxs").val();
        var penalty_112C = $("#penalty_112Cs").val();
        var service_tax = $("#service_taxs").val();
        var ex_rebate = $("#ex_rebates").val();
        var cess = $("#cesss").val();
        var swm_cess = $("#swm_cesss").val();
        var adjustment = $("#adjustments").val();
        var penalty = $("#penaltys").val();
        var rebate = $("#rebates").val();
        var p_total = $("#p_totals").val();
        var challan_no = $("#challan_nos").val();
        var name_bank = $("#name_banks").val();
        var name_branch = $("#name_branchs").val();
        var p_year = $("#p_year").val();
        var payment_date = $("#payment_dates").val();
        var difference = $("#differences").val();
        var remarks = $("textarea#remarkss").val();

        var propId = $("#propId").val();
        var dataString = 'property_tax=' + property_tax + '&payable_total=' + payable_total + '&penalty_112C=' + penalty_112C + '&service_tax=' + service_tax + '&ex_rebate=' + ex_rebate + '&cess=' + cess + '&swm_cess=' + swm_cess + '&adjustment=' + adjustment + '&penalty=' + penalty + '&rebate=' + rebate + '&p_total=' + p_total + 
                '&name_bank=' + name_bank + '&name_branch=' + name_branch + '&payment_date=' + payment_date +  '&upi=' + upi + '&difference=' + difference + '&remarks=' + remarks + '&propId=' + propId + '&p_year=' + p_year + '&colorRadio=' +colorRadio+ '&challan_no=' +challan_no;
			
			//return false;
      /*  if (payment_date == "")
        {
            $("#payment_date").focus();
            return false;
        }*/
		if (property_tax == "")
        {
            $("#property_taxs").focus();
            return false;
        }
		
		if (cess == "")
        {
            $("#cesss").focus();
            return false;
        }
		if (payable_total == "")
        {
            $("#payable_totals").focus();
            return false;
        }
		if (p_total == "")
        {
            $("#p_totals").focus();
            return false;
        }
		
	/*	
      if (challan_no == "")
        {
            $("#challan_nos").focus();
            return false;
        }
        if (name_bank == "")
        {
            $("#name_banks").focus();
            return false;
        }
        if (name_branch == "")
        {
            $("#name_branchs").focus();
            return false;
        }*/
		}

        // AJAX Code To Submit Form.
        $.ajax({
            type: "POST",
            url: "insertpayment",
            data: dataString,
            cache: false,
            success: function () {
                alert("Payment details inserted sucessfully");
				
                $('#save').hide();
                $('#saved').show();
				 window.location.href = '' + baseUrl + 'payment?upi=' + upi + '&assmt_no=' + assmtno;
            }
        });

        return false;
    });

    $("#generatechallan").click(function () {
	
	var colorRadio=$('input[name=colorRadio]:checked').val()
	
        var baseUrl = "<?php echo base_url(); ?>";
        var generatechallan = 1;
 var assmtno = $("#assmtno").val();
 if(assmtno=='undefined')
 {
 var assmtno='';
 }
 if(colorRadio=='new')
		{
      
 var payable_total = $("#payable_total").val();
        var upi = $("#upi").val();
        var property_tax = $("#property_tax").val();
        var penalty_112C = $("#penalty_112C").val();
        var service_tax = $("#service_tax").val();
        var ex_rebate = $("#ex_rebate").val();
        var cess = $("#cess").val();
        var swm_cess = $("#swm_cess").val();
        var adjustment = $("#adjustment").val();
        var penalty = $("#penalty").val();
        var rebate = $("#rebate").val();
        var p_total = $("#p_total").val();
        //var challan_no = $("#challan_no").val();
        var name_bank = $("#name_bank").val();
        var name_branch = $("#name_branch").val();
        var payment_date = $("#payment_date").val();
        var difference = $("#difference").val();
        var remarks = $("textarea#remarks").val();
		
        var propId = $("#propId").val();
        var p_year = $("#p_year").val();
        var dataString = 'property_tax=' + property_tax + '&payable_total=' + payable_total + '&penalty_112C=' + penalty_112C + '&service_tax=' + service_tax + '&ex_rebate=' + ex_rebate + '&cess=' + cess + '&swm_cess=' + swm_cess + '&adjustment=' + adjustment + '&penalty=' + penalty + '&rebate=' + rebate + '&p_total=' + p_total + 
                '&name_bank=' + name_bank + '&name_branch=' + name_branch + '&payment_date=' + payment_date + '&difference=' + difference + '&remarks=' + remarks + '&propId=' + propId + '&generatechallan=' + generatechallan + '&upi=' + upi + '&p_year=' + p_year + '&colorRadio=' +colorRadio;
				
        if (payment_date == "") {
            $("#payment_date").focus();
            return false;
        }
		
		
        if (name_bank == "")
        {
            $("#name_bank").focus();
            return false;
        }
		
        if (name_branch == "")
        {
            $("#name_branch").focus();
            return false;
        }
		}
		
		else
		{
		var payable_total = $("#payable_totals").val();
		
        var upi = $("#upi").val();
        var property_tax = $("#property_taxs").val();
        var penalty_112C = $("#penalty_112Cs").val();
        var service_tax = $("#service_taxs").val();
        var ex_rebate = $("#ex_rebates").val();
        var cess = $("#cesss").val();
        var swm_cess = $("#swm_cesss").val();
        var adjustment = $("#adjustments").val();
        var penalty = $("#penaltys").val();
        var rebate = $("#rebates").val();
        var p_total = $("#p_totals").val();
        var challan_no = $("#challan_nos").val();
        var name_bank = $("#name_banks").val();
        var name_branch = $("#name_branchs").val();
        var payment_date = $("#payment_dates").val();
        var difference = $("#differences").val();
        var remarks = $("textarea#remarkss").val();
		
        var propId = $("#propId").val();
        var p_year = $("#p_year").val();
        var dataString = 'property_tax=' + property_tax + '&payable_total=' + payable_total + '&penalty_112C=' + penalty_112C + '&service_tax=' + service_tax + '&ex_rebate=' + ex_rebate + '&cess=' + cess + '&swm_cess=' + swm_cess + '&adjustment=' + adjustment + '&penalty=' + penalty + '&rebate=' + rebate + '&p_total=' + p_total + 
                '&name_bank=' + name_bank + '&name_branch=' + name_branch + '&payment_date=' + payment_date + '&difference=' + difference + '&remarks=' + remarks + '&propId=' + propId + '&generatechallan=' + generatechallan + '&upi=' + upi + '&p_year=' + p_year + '&colorRadio=' + colorRadio +'&challan_no=' +challan_no;
				
			/*	 if (payment_date == "")
        {
            $("#payment_dates").focus();
            return false;
        }*/
		if (challan_no == "")
        {
            $("#challan_nos").focus();
            return false;
        }
		
        
		
		
        if (name_bank == "")
        {
            $("#name_banks").focus();
            return false;
        }
		
        if (name_branch == "")
        {
            $("#name_branchs").focus();
            return false;
        }
		
		}
	
//alert("hi");
        // AJAX Code To Submit Form.
        $.ajax({
            type: "POST",
            url: "generatepayment",
            async: false,
            data: dataString,
            cache: false,
            success: function (result) {
			//alert(result);
                window.open('' + baseUrl + 'payment/printscreen?upi=' + upi + '&propid=' + propId, '_blank');
                // newTab.location;
                window.location.href = '' + baseUrl + 'payment?upi=' + upi + '&assmt_no=' + assmtno;
				//alert("payment submitted");
            }
        });

        return false;
    });

   /* $("#saved").click(function () {
var upi = $("#upi").val();
 var assmtno = $("#assmtno").val();
 if(assmtno=='undefined')
 {
 var assmtno='';
 }
        var property_tax = $("#property_tax").val();
        var penalty_112C = $("#penalty_112C").val();
        var service_tax = $("#service_tax").val();
        var ex_rebate = $("#ex_rebate").val();
        var cess = $("#cess").val();
        var swm_cess = $("#swm_cess").val();
        var adjustment = $("#adjustment").val();
        var penalty = $("#penalty").val();
        var rebate = $("#rebate").val();
        var p_total = $("#p_total").val();
        var challan_no = $("#challan_no").val();
        var name_bank = $("#name_bank").val();
        var name_branch = $("#name_branch").val();
        var payment_date = $("#payment_date").val();
        var difference = $("#difference").val();
        var remarks = $("textarea#remarks").val();
        var propId = $("#propId").val();
        var p_year = $("#p_year").val();
        var dataString = 'property_tax=' + property_tax + '&penalty_112C=' + penalty_112C + '&service_tax=' + service_tax + '&ex_rebate=' + ex_rebate + '&cess=' + cess + '&swm_cess=' + swm_cess + '&adjustment=' + adjustment + '&penalty=' + penalty + '&rebate=' + rebate + '&p_total=' + p_total + '&challan_no=' + challan_no +
                '&name_bank=' + name_bank + '&name_branch=' + name_branch + '&payment_date=' + payment_date + '&difference=' + difference + '&remarks=' + remarks + '&propId=' + propId + '&upi=' + upi +  '&p_year=' + p_year;
 
		if (payment_date == "")
        {
            $("#payment_date").focus();
            return false;
        }
       /* if (challan_no == "")
        {
            $("#challan_no").focus();
            return false;
        }
        if (name_bank == "")
        {
            $("#name_bank").focus();
            return false;
        }
        if (name_branch == "")
        {
            $("#name_branch").focus();
            return false;
        }*/

        // AJAX Code To Submit Form.
     /*   $.ajax({
            type: "POST",
            url: "insertpayment",
            data: dataString,
            cache: false,
            success: function (result) {
                alert("Payment details updated sucessfully");
				  window.location.href = '' + baseUrl + 'payment?upi=' + upi + '&assmt_no=' + assmtno;
            }
        });

        return false;
    });*/



</script>

<script type="text/javascript">
	$(document).ready(function(){
	var data=$("#data").val();

	if(data=='old')
	{
	
	$("input[name=colorRadio][value='old']").prop("checked",true);
	$("input[type=radio][value='new']").prop("disabled",true);
	 var inputValue = 'old';
	
        var targetBox = $("." + inputValue);
		 $(".optionpayment").not(targetBox).hide();
        $(targetBox).show();
	}
	else if(data=='new')
	{
	
	$("input[name=colorRadio][value='new']").prop("checked",true);
	$("input[type=radio][value='old']").prop("disabled",true);
	 var inputValue = 'new';
	
        var targetBox = $("." + inputValue);
		 $(".optionpayment").not(targetBox).hide();
        $(targetBox).show();
	}
    $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
		
        var targetBox = $("." + inputValue);
        $(".optionpayment").not(targetBox).hide();
        $(targetBox).show();
    });
});
</script>
<script src="<?php echo base_url(); ?>assets/js/readonly.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sascalculation.js"></script>
<?php
include('common/footer.php');
?>	