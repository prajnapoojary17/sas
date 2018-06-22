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
                    <i class="fa fa-calculator"></i> SWM Cess Masters
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
                            <i class="fa fa-plus-square-o"></i>Manage - SWM Cess Masters
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <form class="form-horizontal"  action="<?php echo base_url(); ?>swmcess/add_swmcess" method="POST">
                            <input type="hidden" class="form-control" placeholder="Name Of the Road" name="swm_id" id="swm_id" >
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Year</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control"  name="year" id="year" placeholder="2008-09" pattern="^\d{4}-\d{2}$" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Property Type</label>
                                <div class="col-sm-4">
                                    <select class="form-control select2me CCInput select2-offscreen" name="p_type" id="p_type" tabindex="-1" title="" required>	
                                        <option value="">Select</option>                                        
                                        <option value="RES">Residential</option>
                                        <option value="NRS">Non-Commercial</option>
                                        <option value="IND">Industrial</option>      
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Area of Land occupied by Building (Plinth Area)</label>
                                <div class="col-sm-4">
                                    <select class="form-control select2me CCInput select2-offscreen" name="area_building" id="area_building"  tabindex="-1" title="" required>	
                                        <option value="" selected="selected">Select</option>                                        
                                        <option value="500">Upto 500 Sq.Ft</option>
                                        <option value="501">501 Sq.Ft to 1000 Sq.Ft</option>
                                        <option value="1001">1001 Sq.Ft to 2000 Sq.Ft</option>
                                        <option value="2000">Above 2000 Sq.Ft</option>   
                                    </select>
                                </div>
                            </div>	
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Amount</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="Amount" name="amt" id="amt" pattern="[0-9]+" required >
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
                                    <button type="button" id="reset" class="btn btn-flat btn-dark"><i class="fa fa-repeat"></i> Reset</button>
                                </div>
                            </div>
                        </form>
                        <hr class="arrow-line" />

                        <?php if ($checkyear == 0) { ?>
                            <button type="button" class="btn btn-flat btn-green" id="checkprevyear" style="margin-left: 860px;">Do u want insert data same as previous years</button>
                        <?php } ?>
						<!--else { ?>
                            <a  class="btn btn-flat disable-btn"   style="    margin-left: 850px;" ><i class="fa fa-check"></i>Swm cess is already entered for this year</a>

                        <?php //} ?>-->

                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Property Type</th>
                                        <th>Plinth Area</th>
                                        <th>Amount</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($getswmcess as $displayswmcess) { ?>
                                        <tr>
                                            <td><?php echo $displayswmcess->year; ?></td>
                                            <td><?php echo $displayswmcess->p_type; ?></td>
                                            <td><?php echo $displayswmcess->area_building; ?></td>
                                            <td><?php echo $displayswmcess->amt; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning tooltips" data-placement="left" data-swm_id="<?php echo $displayswmcess->swm_id ?>" data-year="<?php echo $displayswmcess->year ?>" data-p_type="<?php echo $displayswmcess->p_type ?>"  data-area_building="<?php echo $displayswmcess->area_building ?>" data-amt="<?php echo $displayswmcess->amt ?>" id="swm_edit" title="Edit"><i class="fa fa-edit"></i></a>
                                            </td>

                                        </tr>
                                    <?php } ?> 
                                </tbody>
                            </table>
                        </div></div>
                </div>
            </div>                    
        </div>
        <!-- END CONTENT -->
    </div>
</div>
</div>

</div>
</div>
</div>

<div class="modal fade" id="created" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">MCC ALERT</h4>
            </div>
            <div class="modal-body">
                <h4 style="color:red">Data Inserted</h4>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    $("#reset").on("click", function () {
        location.reload();
    });
    $("#checkprevyear").on("click", function () {

        $.ajax({
            type: "POST",
            url: "swmcess/checkswm",
            cache: false,
            success: function (result) {

                if (result != 1)
                {
                    $.ajax({
                        type: "POST",
                        url: "swmcess/insertdata",
                        cache: false,
                        success: function (result1) {
                            $('#created').modal('show');
                            window.setTimeout(function () {
                                $('#created').modal('hide')
                            }, 1000);
                            setTimeout(function () {
                                window.location = 'swmcess';
                            }, 2000);
                        }
                    });

                } else
                {

                }
            }
        });
    });

</script>
<?php
include('common/footer.php');
?>