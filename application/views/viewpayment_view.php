<!-- BEGIN CONTENT -->
<div class="row">           
    <div class="col-lg-12">
        <div class="rootwizard">										
            <form class="form-horizontal">	
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-info-circle"></i>Payment Details
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>                                    
                        </div>
                    </div>
					
                    <div class="portlet-body">
						<div class="row">
							<div class="col-lg-6">						
								<div class="form-group">
									<label class="col-sm-6 control-label">Property Tax</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="property_tax" id="property_tax" value="<?php echo $paydisplay[0]['property_tax']; ?>" readonly="0">
									</div>
								</div>							
								    <?php if($get_112c == 1) { ?>
								<div class="form-group">
                                                    <label class="col-sm-6 control-label">Penalty as per 112C</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="property_tax" id="property_tax" value="<?php echo $paydisplay[0]['property_tax']; ?>" readonly="0">
                                                    </div>
                                                </div>
											<?php	} ?>
								<div class="form-group">
									<label class="col-sm-6 control-label">Date of Payment</label>
									<div class="col-sm-6">
										<div class="input-group date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd" id="maxToday">
						<input class="form-control" size="16" type="text" value="<?php echo $paydisplay[0]['payment_date']; ?>" readonly="" name="payment_date" id="payment_date">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Rebate</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="rebate" id="rebate" readonly="0" value="<?php echo $paydisplay[0]['rebate']; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Cess</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="cess" readonly="0" value="<?php echo $paydisplay[0]['cess']; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Penalty</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="penalty" id="penalty" readonly="0" value="<?php echo $paydisplay[0]['penalty']; ?>">
									</div>
								</div>	
								<div class="form-group">
                                                        <label class="col-sm-6 control-label">Total Amount Payable</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" name="payable_total" id="payable_total" readonly="0" value="<?php  echo $paydisplay[0]['payable_total']; ?>">
                                                        </div>
                                                    </div>	
								<?php if ($stax_exempted == 1) {
                                                    ?>
								<div class="form-group">
                                                    <label class="col-sm-6 control-label">Service Charges<br>
                                                        <h6 class="EX-tax">( Exempted property )</h6>
                                                    </label>
                                                    <div class="col-sm-6">
													<input type="text" class="form-control" name="penalty" id="penalty" readonly="0" value=" <?php echo $paydisplay[0]['service_tax']; ?>">
                                                       
                                                    </div>
                                                </div>	
												 <?php } ?>
												  <?php if ($ex_serviceman == 1) {
                                                    ?>
												 <div class="form-group">
                                                    <label class="col-sm-6 control-label">Rebate for Ex-Serviceman</label>
                                                    <div class="col-sm-6">
													<input type="text" class="form-control" name="penalty" id="penalty" readonly="0" value=" <?php echo $paydisplay[0]['ex_service_man']; ?>">
                                                       
                                                    </div>
                                                </div>
												<?php } ?>
												<div class="form-group">
                                                    <label class="col-sm-6 control-label">SWM Cess</label>
                                                    <div class="col-sm-6">
                                                       <input type="text" class="form-control" name="penalty" id="penalty" readonly="0" value="<?php echo $paydisplay[0]['SWM_cess']; ?>">
                                                    </div>
                                                </div>											
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Adjustments if any</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="penalty" id="penalty" readonly="0" value="<?php echo $paydisplay[0]['adjustment']; ?>">
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label class="col-sm-6 control-label">Total</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="penalty" id="penalty" readonly="0" value="<?php echo $paydisplay[0]['p_total']; ?>">
                                                    </div>
                                                </div>							
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="col-sm-6 control-label">Challan No.</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="challan_no" value="<?php echo $paydisplay[0]['challan_no']; ?>"readonly="0">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Name of Bank</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="name_bank" value="<?php echo $paydisplay[0]['name_bank']; ?>" id="name_bank" readonly="0">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-6 control-label">Name of Branch</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" name="name_branch" value="<?php echo $paydisplay[0]['name_branch']; ?>" readonly="0">
									</div>
								</div>							
								
								<div class="form-group">
									<label class="col-sm-6 control-label">Remarks</label>
									<div class="col-sm-6">
										<textarea class="form-control" maxlength="50" id="max300" name="remarks"  readonly="0"><?php echo $paydisplay[0]['remarks']; ?></textarea>
									</div>								
								</div>							
														
							</div>										
						</div>	
					</div>
                </div>            
        </form>
		</div>								
    </div>
</div>
<!-- END CONTENT -->
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>