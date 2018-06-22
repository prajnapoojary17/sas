<!-- END PAGE HEADER-->
<!-- BEGIN CONTENT -->
<div class="row">           
    <div class="col-lg-12">
        <div class="rootwizard">										
            <form class="form-horizontal">	
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-info-circle"></i>General Information
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
                                    <label class="col-sm-6 control-label" readonly>UPI</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['upi'];?>">
                                    </div>
                                </div>	
                                <div class="form-group has-feedback">
                                    <label class="col-sm-6 control-label">Name of Owner</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['p_name']; ?>">
                                        <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                    </div>
                                </div>											
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Name of Occupier</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['o_name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Contact #</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['contact_no']; ?>">
                                    </div>
                                </div>	
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Aadhar Number</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['aadhar_no']; ?>">
                                    </div>
                                </div>																	
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Name of Road &amp; Sl. No</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['n_road']; ?>">
                                    </div>									                           
                                </div>												
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Assessment No</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="assmt_no" id="assmt_no" readonly="" value="<?php echo $records[0]['assmt_no']; ?>">
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group has-feedback">
                                    <label class="col-sm-6 control-label">Ward</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="assmt_no" id="assmt_no" readonly="" value="<?php echo $records[0]['p_ward']; ?>">                                               
                                    </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-6 control-label">Block</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="p_block" id="p_block" readonly="" value="<?php echo $records[0]['p_block']; ?>">                                                
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">112C (T)</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="p_block" id="p_block" readonly="" value="<?php echo ($records[0]['p_112C']) == 1 ? 'True' : 'False'; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">EX Servicemen</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="p_block" id="p_block" readonly="" value="<?php echo ($records[0]['ex_serviceman']) == 1 ? 'Yes' : 'No'; ?>">
                                    </div>
                                </div> 
                                <?php if ($records[0]['ex_serviceman'] == 1) { ?>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Reference No</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="ref_no" id="ref_no" readonly="" value="<?php echo (isset($records[0]['ref_no'])) ? $records[0]['ref_no'] : ''; ?>">
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="form-group has-feedback">
                                    <label class="col-sm-6 control-label">Door No</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="door_no" id="door_no" readonly="" value="<?php echo $records[0]['door_no']; ?>">
                                        <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Village</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="village" id="village" readonly="" value="<?php echo $records[0]['village']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Survey No.</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="survey_no" id="survey_no" readonly="" value="<?php echo $records[0]['survey_no']; ?>">
                                    </div>
                                </div>											
                            </div>										
                        </div>
                    </div>
                </div>
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-industry"></i>Property Details
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
                                    <label class="col-sm-6 control-label">Total area of Land in Cents</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['area_cents']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Total area of Land in Sq.Ft</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['area_sqft']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Area of Land occupied by Building</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['area_build']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Area including all floors</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['area_floors']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Area ratio / undivided right (Plinth Factor)</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly readonly="" value="<?php echo $records[0]['area_ratio']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Undivided right as per Sale Deed or Schedule </label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['undiv_right']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Use of Property</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="p_block" id="p_block" readonly="" value="<?php echo $records[0]['p_use']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Tax Applicable From</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['tax_applicablefrom']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Rate of Tax</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['tax_rate']; ?>">
                                    </div>
                                </div>                                
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Payment Year</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="p_block" id="p_block" readonly="" value="<?php echo $records[0]['p_year']; ?>">
                                    </div>										                           
                                </div>																																					
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Enhancement rate of Tax</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['enhancement_tax']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Guidance Value of Land in Cents</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['value_cents']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Guidance Value of Land in Sq. Ft</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['value_sqft']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Corner Site value</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['value_corn']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Total Guidance Value</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['value_total']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">50% of the Guidance Value</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $records[0]['guide_50']; ?>">
                                    </div>
                                </div>												
                            </div>
                        </div>
                    </div>
                </div>
                <?php foreach ($records as $record) { ?>
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-calculator"></i>Building Details/Tax Calculation
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
                                    <label class="col-sm-6 control-label">Floor</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['floor']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Construction Year</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['c_year']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Tax Applicable From</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['tax_applicable_floor']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Age of Building (as on 2008-09)</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['age_build']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Depreciation Rate</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['depreciation_rate']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Type of Construction</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['type_const']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Building value per Sq.Ft</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['b_value_sqft']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">50% of the Guidance value</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['b_guide_50']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Building area in Sq.Ft</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['b_area_sqft']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Own (0.5) / Rented or Commercial (1.0)</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['build_type']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Taxable value of the Land</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['land_tax_value']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Taxable value of the Building</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['build_tax_value']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Applicable Tax</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['app_tax']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Enhanced Tax</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" readonly="" value="<?php echo $record['b_enhc_tax']; ?>">
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
        </div>							
        </form>						
    </div>
</div>
<!-- END CONTENT -->
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>