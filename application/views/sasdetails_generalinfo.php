<?php
include ('common/header.php');
?>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="loader wait" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-user"></i> Self Assessment Property Tax 
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
                <div class="rootwizard">
                    <?php
                    echo validation_errors();
                    if (isset($message))
                        echo $message;
                    ?>
                    <div id = "validn"></div>                    
                    <div class="col-md-12 collapse" id="succss" style="display:none;">
                        <div role="alert" class="alert alert-success"></div>
                    </div>
                    <form name="sasdetails_general" id="sasdetails_general" method="POST" action="#" class="form-horizontal" >
                        <div class="portlet box green-seagreen" style="margin-bottom:0px;">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info-circle"></i>General Information
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>                                            
                                </div>
                            </div>
                            <div class="portlet-body" ng-app="">
                                <div class="row">									
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label" readonly>UPI</label>
                                            <div class="col-sm-6">
                                                <p class="form-control" name="upi" id="upi" readonly="" value=""><span id="ward"></span>-<span id="block"></span>-<span id="door"></span></p>                                               
                                            </div>                                                
                                        </div>	
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Name of Owner</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="p_name" id="p_name">
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>											
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Name of Occupier</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="o_name" id="o_name" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Contact #</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="contact_num" id="contact_num">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Aadhar Number</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="aadhar_num" id="aadhar_num">
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Ward</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="p_ward" id="p_ward" onchange="fetch_roadname($(this).val());">
                                                    <option value = "0" selected="selected">Select</option>
                                                    <?php foreach ($ward as $wards) {
                                                        ?>
                                                        <option value="<?php echo $wards->ward_no; ?>,<?php echo $wards->ward_name; ?>"><?php echo $wards->ward_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Name of Road &amp; Sl. No</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="n_road" id="n_road">
                                                    
                                                </select>
                                                <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                <div id="guidance" style="display:none">
                                                    <span>residential: <span id="res"></span> </span><br />
                                                    <span>commercial: <span id="comm"></span> </span>
                                                
                                            </div>
                                            </div>                                            
                                        </div>
                                                                               
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Assessment No</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control"  name="assmt_no" id="assmt_no">
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Block</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="p_block" id="p_block">
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">112C (T)</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="p_112C" id="p_112C" tabindex="-1" title="">
                                                    <option value="0" selected="selected">Select</option>                                                                                                   <option value="1">T</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">EX Servicemen</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="ex_serviceman" id="ex_serviceman" tabindex="-1" title="">
                                                    <option value="0" selected="selected">Select</option>
                                                    <option value="1">Y</option>                                                        
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div id="serviceman-container" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">Reference No</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="ref_no" id="ref_no" value="<?php echo (isset($ref_no)) ? $ref_no : ''; ?>">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Door No</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="door_no" id="door_no">
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Village</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="village" id="village">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Survey No.</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="survey_no" id="survey_no">
                                            </div>
                                        </div>											
                                    </div>										
                                </div>
                            </div>
                        </div>	
                        <div class="pull-right">		
                            <ul class="pager">								
                                <li class=""><a href="#" id="submit"><i class="fa fa-check"></i> Submit</a></li>
                                <li class=""><a href="#" id="submitandcontinue"><i class="fa fa-check"></i> Submit and Continue</a></li>
                            </ul>
                        </div>
                    </form>
                </div>                    
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<div id="inset_form"></div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/readonly.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sasdetails_geninfo.js"></script>
<?php
include('common/footer.php');
?>