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
                    <i class="fa fa-line-chart"></i> CESS% 
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
                            <i class="fa fa-chart"></i>Manage - CESS%
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">

                        <form class="form-horizontal" action="<?php echo base_url(); ?>cess/add_cess" method="POST">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Year</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="2008-09" pattern="^\d{4}-\d{2}$"  name="cess_id" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">CESS%</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="24" name="cess_amt" required  pattern="[0-9]+">
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
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>CESS% </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($getcess as $displaycess) {
                                        ?>
                                        <tr>

                                            <td><?php echo $displaycess->cess_id; ?></td>
                                            <td><?php echo $displaycess->cess_amt; ?></td>                                           
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

<?php
include('common/footer.php');
?>	