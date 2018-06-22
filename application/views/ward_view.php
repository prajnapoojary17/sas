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
                    <i class="fa fa-cubes"></i> Ward
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
                            <i class="fa fa-codepen"></i>Manage - Ward
                        </div>                       
                    </div>
                    <div class="portlet-body">

                        <form class="form-horizontal" action="<?php echo base_url(); ?>ward/add_ward" method="POST">                          
                            <div class="form-group has-feedback">
                                <label class="col-sm-2 control-label">Ward Name</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="ward_name" maxlength="100"  pattern="[a-zA-Z0-9\.\-/\s]+" required >
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
                                    <button type="submit" class="btn btn-flat btn-green"><i class="fa fa-floppy-o"></i> Save</button>
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
                                            <th>Ward No.</th>
                                            <th class="sort-hide">Ward Name</th>                                
                                        </tr>
                                    </thead>
                                    <tbody><?php
                                        if (count($ward) > 0) {
                                            $previous_data = "";

                                            foreach ($ward as $wards) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $wards->ward_no; ?></td>
                                                    <td><?php echo $wards->ward_name; ?></td>                                                 
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td class="active" colspan="26" align="center"><span style="font-weight: bold; color: red">Sorry, No Records!</span></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
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
<!-- END CONTAINER -->
<?php
include('common/footer.php');
?>	