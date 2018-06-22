<?php
include ('common/header.php');
?>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
    var numberOfItemsNeeded = <?php echo BUILDING_AGE_LIMIT; ?>;
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title" id="paymentEdit">
                    <i class="fa fa-edit"></i> Manage Property / Building / Tax Calculation
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
        <div class="row">
            <div class="col-lg-12">
                <div id = "validn"></div> 
                <div class="rootwizard">
                    <?php
                    echo validation_errors();
                    if (isset($message))
                        echo $message;
                    ?>
                    <div class="col-md-12 collapse" id="succss" style="display:none;">
                        <div role="alert" class="alert alert-success">  </div>
                    </div>
                    <div class="navbar">
                        <div class="navbar-inner">
                            <div class="container">
                                <ul>                                   
                                    <li><a href="#tab1" data-toggle="tab"><span class="label">1</span> Property Details</a></li>
                                    <li class="no-click"><a href="#tab2" data-toggle="tab"><span class="label">2</span> Building Details/Tax Calculation</a></li>							
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="bar" class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <form name="sasdetails_buildtax" id="sasdetails_buildtax" method="POST" action="#" class="form-horizontal" >
                        <div class="tab-content">
                            <div class="tab-pane" id="tab1">
                                <div class="portlet box green-seagreen">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-industry"></i>Property Details
                                        </div>
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>                                            
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">UPI</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" name="upi" id="upi" class="form-control" value="<?php echo (isset($upi)) ? $upi : ''; ?>">
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Total area of Land in Cents</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="area_cents" id="a_cents" value="<?php echo (isset($area_cents)) ? $area_cents : ''; ?>">
                                                      <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>  
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Total area of Land in Sq.Ft</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="area_sqft" id="a_sqft" readonly value="<?php echo (isset($area_sqft)) ? $area_sqft : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Area of Land occupied by Building</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="area_build" id="area_build" onkeypress="return isNumber(event)" value="<?php echo (isset($area_build)) ? $area_build : ''; ?>">
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Area including all floors</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="area_floors" id="area_floors" onkeypress="return isNumber(event)" value="<?php echo (isset($area_floors)) ? $area_floors : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Area ratio / undivided right (Plinth Factor)</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="area_ratio" id="area_ratio" value="<?php echo (isset($area_ratio)) ? $area_ratio : ''; ?>">
                                                        <input type="hidden" class="form-control" readonly name="area_ratio_original" id="area_ratio_original">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Undivided right as per Sale Deed or Schedule </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="undiv_right" id = "undiv_right" value="<?php echo (isset($undiv_right)) ? $undiv_right : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Use of Property</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="p_use" id="p_use" >
                                                            <option value="0">Select</option>
                                                            <?php foreach ($proptype as $proptypes) {
                                                                ?>
                                                                <option value = "<?php echo $proptypes->p_type; ?>" <?php if (isset($p_use) AND $p_use == $proptypes->p_type) echo "selected='selected'"; ?>><?php echo $proptypes->p_type; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group" id="exempted" style="display:none;">
                                                    <label class="col-sm-6 control-label">Exempted Property</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="stax_exempted" id="stax_exempted" tabindex="-1" title="">
                                                            <option value="0">No</option>						
                                                            <option value="1">Yes</option>                                                      
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Tax Applicable From</label>
                                                    <div class="col-sm-6">
                                                        <div class="taxApplicable">
                                                        <select class="form-control" name="tax_applicablefrom" id="tax_applicablefrom">
                                                            <option value="0">Select</option>
                                                            <?php foreach ($enhance as $enhances) {
                                                                ?>
                                                                <option value="<?php echo $enhances->e_year; ?>" <?php if (isset($tax_applicablefrom) AND $tax_applicablefrom == $enhances->e_year) echo "selected='selected'"; ?>><?php echo $enhances->e_year; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <input type="text" class="form-control" style="display:none;" readonly name= "tax_applicablefrom" id="tax_applicablefromtextbox" value="<?php echo (isset($tax_applicablefrom)) ? $tax_applicablefrom : ''; ?>">
                                                        </div>
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Rate of Tax</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name= "tax_rate" id="tax_rate" value="<?php echo (isset($tax_rate)) ? $tax_rate : ''; ?>">
                                                    </div>
                                                </div>                                                
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Payment Year</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="p_year" id="p_year" >
                                                            <option value="0">Select</option>
                                                            <?php foreach ($enhance as $enhances) {
                                                                ?>
                                                                <option value="<?php echo $enhances->e_year; ?>" <?php if (isset($tax_rate) AND $tax_rate == $enhances->e_year) echo "selected='selected'"; ?>><?php echo $enhances->e_year; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Enhancement rate of Tax</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="enhancement_tax" id = "enhancement_tax">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Guidance Value of Land in Cents</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="value_cents" id="guide_cents" value="<?php echo (isset($value_cents)) ? $value_cents : ''; ?>" onkeypress="return isNumber(event)" readonly>
                                                        <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Guidance Value of Land in Sq. Ft</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="value_sqft" id="guide_sqft" value="<?php echo (isset($value_sqft)) ? $value_sqft : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Is property Corner Site ?</label>
                                                    <div class="col-sm-6">
                                                        <div class="radio-group">
                                                            <label class="control control-radio"> <input type="radio" name="corner" value="0" checked="true" id="not-corner" /> No
                                                                <div class="control_indicator"></div>
                                                            </label>
                                                            <label class="control control-radio"> <input type="radio" name="corner" value="1" id="yes-corner" /> Yes
                                                                <div class="control_indicator"></div>
                                                            </label>
                                                        </div>                                            
                                                    </div>                                          
                                                </div>
                                                <div id="corner-container" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="col-sm-6 control-label">Corner Site value</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" readonly name="value_corn" id="value_corn" value="<?php echo (isset($value_corn)) ? $value_corn : ''; ?>">
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Total Guidance Value</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name = "value_total" id="value_total" value="<?php echo (isset($value_total)) ? $value_total : ''; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">50% of the Guidance Value</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="guide_50" id="guide_50" value="<?php echo (isset($guide_50)) ? $guide_50 : ''; ?>">
                                                        <input type="hidden" class="form-control" readonly name="guide_50_original" id="guide_50_original" value="0">
                                                    </div>
                                                </div>												
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2">
                                <input type="hidden" name="count" value="1" id="count">
                                <input type="hidden" name="olddata_1" value="0" id="olddata_1">
                                <div class="portlet box green-seagreen">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-calculator"></i>Building Details/Tax Calculation  - Floor 1
                                        </div>                                        
                                        <div class="tools">
                                            <a href="javascript:;" class="collapse"></a>                                           
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Floor</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="floor_1" value="0" id="floor_1">
                                                        <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Construction Year</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="c_year_1" placeholder="2008-09" id="c_year_1">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Age of Building (as on 2008-09)</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="age_build_1" id ="age_build_1">
                                                            <option value="">Select</option>
                                                            <?php foreach ($depreciation as $depreciations) {
                                                                ?>
                                                                <option value="<?php echo $depreciations->b_age; ?>"><?php echo $depreciations->b_age; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Depreciation Rate</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="depreciation_rate_1" id = "depreciation_rate_1">
                                                    </div>
                                                </div>
                                                <div class="form-group c_rate_1">
                                                    <label class="col-sm-6 control-label">Construction Rate</label>
                                                        <div class="col-sm-6">
                                                            <label>
                                                                <span class="checked"><input type="radio" name="const_rate_1" id="const_rate_1" value="city"></span>
                                                                <span class="Cons-top">City</span>
                                                            </label>
                                                            <label>
                                                                <span><input type="radio" name="const_rate_1" id="const_rate_1" value="rural"></span>
                                                                <span class="Cons-top"> Rural</span>
                                                            </label>
                                                        </div>
						</div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Type of Construction</label>
                                                    <div class="col-sm-6">
                                                      <select class="form-control" name="type_const_1" id="type_const_1">                                                            
                                                      </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Building value per Sq.Ft</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly="" name="b_value_sqft_1" id="b_value_sqft_1" onkeypress="return isNumber(event)">
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">50% of the Guidance value</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="b_guide_50_1" onkeypress="return isNumber(event)" id="b_guide_50_1">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Building area in Sq.Ft</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" name="b_area_sqft_1" onkeypress="return isNumber(event)" id="b_area_sqft_1">
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Own (0.5) / Rented or Commercial (1.0)</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="build_type_1" id="build_type_1" >
                                                            <option value="0">Select</option>                                                                                                                       <option value="0.50">0.50</option>
                                                            <option value="1.00">1.00</option>                                                            
                                                        </select>
                                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Taxable value of the Land</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="land_tax_value_1" id = "land_tax_value_1">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Taxable value of the Building</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="build_tax_value_1" id="build_tax_value_1">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Applicable Tax</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="app_tax_1" id="app_tax_1">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 control-label">Enhanced Tax</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" readonly name="b_enhc_tax_1" id="b_enhc_tax_1">
                                                    </div>
                                                </div>                                                
                                                <input type="hidden" class="form-control" readonly name="b_cess_1" id = "b_cess_1">
                                                <input type="hidden" class="form-control" name="cess_percent" id="cess_percent">				</div>
                                        </div>
                                    </div>
                                </div>							
                                <div id="multiple" style=" display:none;">

                                </div>
                                <div class="addmoreflore">
                                    <button type="button" class="btn btn-danger tooltips multipleRadioOptions" data-original-title="Do you have multiple Floor"><i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>                                
                            </div>												
                            <ul class="pager wizard">								
                                <li class="next"><a href="javascript:;" class="nextclick">Next <i class="fa fa-arrow-right"></i></a></li><li style="margin-left:10px;">&nbsp;&nbsp; </li>

                                <li class="finish"><a href="#" class="submit" style="margin-right:10px;"><i class="fa fa-check"></i> Save</a></li>
                            </ul>							
                        </div>                   							
                    </form>						
                </div>
            </div> 					
        </div>
        <!-- END CONTENT -->
    </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sasdetails_bldtax.js"></script>
<?php
include('common/footer.php');
?>