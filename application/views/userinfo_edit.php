<?php
include ('common/header.php');
?>
<style>
    .total_record {       
        float:right;
        margin-bottom:44px;
    }   

    
    #sasdetails_wrapper .row {
        display:none;
    }
    #sasdetails_wrapper {
        margin-top: 36px;
    }
</style>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
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
                    <div class="portlet box green-seagreen">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-industry"></i>Customer Information Edit
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>                               
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-horizontal" method="post" action="">  
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">UPI</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="upi" class="form-control">
                                            </div>
                                        </div>												
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group" align="right">
                                            <button type="button" class="btn btn-primary">OR</button>												
                                        </div>	
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Assessment No</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="assessment_no" class="form-control">
                                            </div>
                                        </div>												
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="col-lg-12">
                                            <input type="submit" value="SUBMIT" class="btn btn-flat btn-green">
                                        </div>	
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div style="color:red; font-size: 15px; float:none;">
                        <?php
                        echo validation_errors();
                        if (isset($message))
                            echo $message;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list-ul"></i>Customer Information
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>                            
                        </div>
                    </div>
                    <div class="portlet-body">
                        <!-- Modal Review Read More-->
                        <div class="table-responsive">
                            <?php echo $page_links; ?>
                            <span class="total_record" style="margin-top: 14px;"> Total Records : <span style="color:red"><?php echo $total_record; ?></span></span>
                            <table class="table datatable table-long table-condensed" id="sasdetails" role="grid" aria-describedby="_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 69px;">UPI</th>
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 74px;">Payer Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 74px;">Name of Road</th>		
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 74px;">Contact No</th>
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 95px;">Assessment No</th>
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 95px;">Ward</th>
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 32px;">Block</th>
                                        <th class="sorting" tabindex="0" aria-controls="" rowspan="1" colspan="1" aria-label="" style="width: 33px;">Door No</th>							

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $record) { ?>
                                        <tr role="row" class="odd">
                                            <td><?php echo $record['upi']; ?></td>                                            
                                            <td><?php echo $record['p_name']; ?></td>
                                            <td><?php echo $record['n_road']; ?></td>
                                            <td><?php echo $record['contact_no']; ?></td>
                                            <td><?php echo $record['assmt_no']; ?></td>
                                            <td><?php echo $record['p_ward']; ?></td>
                                            <td><?php echo $record['p_block']; ?></td>
                                            <td><?php echo $record['door_no']; ?></td>                               
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php echo $page_links; ?>
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    <?php
    include('common/footer.php');
    ?>