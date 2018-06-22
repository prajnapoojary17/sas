<?php
include ('common/header.php');
?>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-user"></i> Customer Information Edit
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
                        <div role="alert" class="alert alert-success"> <strong>Information updated successfully.</strong></div>
                    </div>
                    <form name="general_edit" id="general_edit" method="POST" action="#" class="form-horizontal">
                        <input type="hidden" name="infoid" value="<?php echo $info['sl_no'] ?>">
                        <div class="portlet box green-seagreen" style="margin-bottom:0px;">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info-circle"></i>Customer Information Edit
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>                                
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">	                                
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label" readonly>UPI</label>
                                            <div class="col-sm-6">
                                                <p class="form-control" name="upi" id="upi" readonly="" value=""><span id="ward"><?php echo $info['p_ward']; ?></span>-<span id="block"><?php echo $info['p_block']; ?></span>-<span id="door"><?php echo $info['door_no']; ?></span></p>
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>	
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Name of Owner</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="p_name" id="p_name" value="<?php echo (isset($info['p_name'])) ? $info['p_name'] : ''; ?>">
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Name of Occupier</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="o_name" id="o_name" value="<?php echo (isset($info['o_name'])) ? $info['o_name'] : ''; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Contact #</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="contact_num" id="contact_num" value="<?php
                                                if (isset($info['contact_no']) && $info['contact_no'] != '0') {
                                                    echo $info['contact_no'];
                                                } else {
                                                    echo '';
                                                }
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Aadhar Number</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="aadhar_num" id="aadhar_num" value="<?php
                                                if (isset($info['aadhar_no'])) {
                                                    echo $info['aadhar_no'];
                                                } else {
                                                    echo '';
                                                }
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Ward</label>
                                            <div class="col-sm-6">
                                                <input type="text" readonly class="form-control" name="p_ward" id="p_ward" value="<?php echo (isset($info['p_ward'])) ? $info['p_ward'] : ''; ?>">
                                                <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Name of Road &amp; Sl. No</label>
                                            <div class="col-sm-6">                                        
                                                <input type="text" readonly class="form-control" name="n_road" value="<?php echo (isset($info['n_road'])) ? $info['n_road'] : ''; ?>" id="n_road">
                                                <input type="hidden" id="n_roadold" value="<?php echo (isset($info['n_road'])) ? $info['n_road'] : ''; ?>">
                                                <span id="roadname_message" style="color:red;"><?php if($checkward_roadname == 1)echo 'Road Name Exists'; else echo 'Road Name doesnot exists'; ?></span>
                                                <a href="#" id="changeaddr"><i class="fa fa-check"></i> Change</a>                                    
                                            </div>                                            
                                        </div>
                                        <div class="form-group has-feedback roadlist" style="display:none">
                                            <label class="col-sm-6 control-label">Select New Road Name</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="road" id="road">
                                                    
                                                </select>
                                                <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                                <div id="guidance" style="display:none">
                                                    <span>residential: <span id="res"></span> </span><br />
                                                    <span>commercial: <span id="comm"></span> </span>                                                
                                                </div>
                                                <a href="#" id="reset_roadname"><i class="fa fa-check"></i>Reset Road Name</a> 
                                            </div>                                            
                                        </div>                                                                            
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Assessment No</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" readonly name="assmt_no" id="assmt_no" value="<?php echo (isset($info['assmt_no'])) ? $info['assmt_no'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Block</label>
                                            <div class="col-sm-6">
                                                <input type="text" readonly class="form-control" name="p_block" id="p_block" value="<?php echo (isset($info['p_block'])) ? $info['p_block'] : ''; ?>">
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">112C (T)</label>
                                            <div class="col-sm-6">                                     
                                                <input type="text" readonly class="form-control" name="p_112C" id="p_112C" value="<?php
                                                if (isset($info['p_112C']) && $info['p_112C'] == '1') {
                                                    echo "True";
                                                } else {
                                                    echo "False";
                                                }
                                                ?>">                                   
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">EX Servicemen</label>
                                            <div class="col-sm-6">                                          
                                                <input type="text" readonly class="form-control" name="ex_serviceman" id="ex_serviceman" value="<?php
                                                if (isset($info['ex_serviceman']) && $info['ex_serviceman'] == '1') {
                                                    echo "True";
                                                } else {
                                                    echo "False";
                                                }
                                                ?>">
                                            </div>
                                        </div>
                                        <?php if ($info['ex_serviceman'] == '1') { ?>
                                            <div class="form-group">
                                                <label class="col-sm-6 control-label">Reference No</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="ref_no" id="ref_no" value="<?php echo (isset($info['ref_no'])) ? $info['ref_no'] : ''; ?>">
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="form-group has-feedback">
                                            <label class="col-sm-6 control-label">Door No</label>
                                            <div class="col-sm-6">
                                                <input type="text" readonly class="form-control" name="door_no" id="door_no" value="<?php echo (isset($info['door_no'])) ? $info['door_no'] : ''; ?>">
                                                <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Village</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="village" id="village" value="<?php echo (isset($info['village'])) ? $info['village'] : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-6 control-label">Survey No.</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="survey_no" id="survey_no" value="<?php echo (isset($info['survey_no'])) ? $info['survey_no'] : ''; ?>">
                                            </div>
                                        </div>											
                                    </div>										
                                </div>
                            </div>
                        </div>	
                        <div class="pull-right">		
                            <ul class="pager">	
                                <li class=""><a href="#" id="submit"><i class="fa fa-check"></i> Submit</a></li>
                                <li class=""><a href=""<?php echo base_url(); ?>sasdetails/editgeneralInfo""><i class="fa fa-check"></i> Close</a></li>
                            </ul>
                        </div>
                    </form>
                </div>				
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/generalinfo_edit.js"></script>
<?php
include('common/footer.php');
?>