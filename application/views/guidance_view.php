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
                    <i class="fa fa-cubes"></i> Guidance Value In Cents
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
                            <i class="fa fa-codepen"></i>Manage - Guidance Value In Cents
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">

                        <form class="form-horizontal" action="<?php echo base_url(); ?>guidance/add_guidance" method="POST">
                            <input type="hidden" class="form-control" placeholder="Name Of the Road" name="g_id" id="g_id" >
                            <input type="hidden" class="form-control" name="gval_wardroadid" id="gval_wardroadid" >
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Name Of the Road</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Name Of the Road" name="road_name" id="road_name" maxlength="100" pattern="[a-zA-Z0-9\.\-\(\)\/\s]+" required>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-2 control-label">Ward</label>
                                <div class="col-sm-2">
                                    <select class="form-control" name="p_ward" id="p_ward" required>
                                        <option value = "" selected="selected">Select</option>
                                        <?php foreach ($ward as $wards) {
                                            ?>
                                            <option value="<?php echo $wards->ward_no; ?>"><?php echo $wards->ward_name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Guidance Value of land In Cents - Commercial </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="1" name="gvalcents_commercial" id="gvalcents_commercial" pattern="[0-9]+(\.[0-9][0-9]?)?" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Guidance Value of land In Cents - Residential </label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="1" name="gvalcents_residential" id="gvalcents_residential" pattern="[0-9]+(\.[0-9][0-9]?)?" required>
                                </div>
                            </div>
                            
                            <?php
                            $message = $this->session->flashdata('message');
                            if ($message) {
                                ?>
                                <div class="alert alert-danger alert-dismissible" role="alert"><?php echo $message ?> </div>	
                            <?php } ?>	<div class="form-group">
                                <div class="col-sm-offset-2 col-sm-4">
                                    <button type="submit" class="btn btn-flat btn-green"><i class="fa fa-floppy-o"></i> Save</button>
                                    <button type="reset" class="btn btn-flat btn-dark"><i class="fa fa-repeat"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                        <hr class="arrow-line" />
                        <div class="table-responsive">                            
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Name Of the Road</th>
                                        <th>Ward</th>
                                        <th>Guidance Value of land In Cents - Commercial</th>
                                        <th>Guidance Value of land In Cents - Residential</th>                                       
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($getguidance as $displayguidance) {
                                        ?>
                                        <tr>							
                                            <td><?php echo $displayguidance->road_name; ?></td>
                                             <?php foreach ($getwardroad as $wardroad) {
                                                 if(($wardroad['road_name'] == $displayguidance->road_name) && $wardroad['ward_no'] == $displayguidance->ward_no ){
                                                  $wardname =   $wardroad['ward_name'];
                                                  $wardid = $wardroad['ward_no'];
                                                  $wardroadid = $wardroad['id'];                                                  
                                                 }
                                         } ?>
                                            <td><?php echo $wardname; ?></td>
                                            <td><?php echo $displayguidance->gvalcents_commercial; ?></td>
                                            <td><?php echo $displayguidance->gvalcents_residential; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning tooltips" data-placement="left" data-g_id="<?php echo $displayguidance->g_id ?>" data-road_name="<?php echo $displayguidance->road_name ?>"  data-gval_cents_commercial="<?php echo $displayguidance->gvalcents_commercial ?>" data-gval_cents_residential="<?php echo $displayguidance->gvalcents_residential ?>" data-gval_wardroadid="<?php echo $wardroadid ?>" data-gval_wardid="<?php echo $wardid ?>" id="guidance_edit" title="Edit"><i class="fa fa-edit"></i></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- END CONTENT -->

    </div>
</div>

<?php
include('common/footer.php');
?>	