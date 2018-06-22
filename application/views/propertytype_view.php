<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-calculator"></i> Property Type
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
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-plus-square-o"></i>Manage - Add Property Type
                        </div>                       
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal" action="<?php echo base_url(); ?>proptype/InsertUser" method="POST">
                            <div class="form-group has-feedback">
                                <label class="col-sm-2 control-label">Property Type  </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="p_type" required maxlength="20" pattern="[A-Z]+" placeholder="COM">
                                    <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-2 control-label">Use of Property</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="p_use" required maxlength="20" pattern="[A-Za-z/\s]+" placeholder="Commercial">
                                    <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                </div>
                            </div>
                            <?php
                            $message = $this->session->flashdata('message');
                            if ($message) {
                                ?>
                                <div class="alert alert-danger alert-dismissible" role="alert"><?php echo $message ?> </div>	
                            <?php } ?>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="submit" class="btn btn-flat btn-green" name="Save"><i class="fa fa-floppy-o"></i> Save</button>
                                    <button type="reset" class="btn btn-flat btn-dark"><i class="fa fa-repeat"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                        <hr class="arrow-line" />
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>Property Type</th>
                                            <th>Use of Property</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($displayproptype as $displayprop) {
                                            ?>
                                            <tr>
                                                <td><?php echo $displayprop->p_type; ?></td>
                                                <td><?php echo $displayprop->p_use; ?></td>                                                
                                            </tr>
                                        <?php } ?>                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- END CONTENT -->
    </div>
</div>
</div>
<?php
include('common/footer.php');
?>	