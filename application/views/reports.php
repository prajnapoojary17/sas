<?php
/**
 * sas details script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<style>
    #sasdetails_info {
        display:none;
    }
    #sasdetails_paginate {
        display:none;        
    }
    #sasdetails_filter {
        display:none;
    }
    #sasdetails_length {
        display:none;
    }
    .errmsg {
        color: red;
        font-size: medium;
        margin-left: 17px;  
    }
        .total_record {       
        float:right;
        margin-bottom:44px;
        margin-right:30px;
    }
</style>
<script type="text/javascript">
    var baseUrl = "<?php echo base_url(); ?>";
</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-eye"></i> User Reports
                    <div class="date-display">
                        <i class="icon-calendar"></i>
                        <span id="datetime"></span>
                        <span id="datetime2"></span>
                    </div>
                </h3>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-list-ul"></i> User Reports
                        </div>
                        <div class="tools">
                            <div class="date-display">
                                <i class="icon-calendar"></i>
                                <span id="datetime"></span>
                                <span id="datetime2"></span>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive custom_datatable">

                            <form class="form-horizontal form-striped" action="<?php echo base_url(); ?>generatereport" method="get" name="report" id="report">                          
                                <div class="errmsg"><?php if(isset($error)) echo $error; ?></div>
                                <div class="col-lg-4">            							
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">From Date</label>
                                        <div class="col-sm-6">
                                            <div>
                                                <input class="form-control"  size="16" type="text" value="<?php echo (isset($date1)) ? $date1 : ''; ?>" id="datepicker" name="date1" required>
                                            </div>
                                        </div>
                                    </div>									                                 
                                </div>
                                <div class="col-lg-4">            							
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">To Date</label>
                                        <div class="col-sm-6">
                                            <div>
                                                <input class="form-control" size="16" type="text" value="<?php echo (isset($date2)) ? $date2 : ''; ?>" id="datepicker2" name="date2" required>
                                            </div>
                                        </div>
                                    </div>									                                 
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-flat btn-green viewbtn" id="viewreports" name="id"><i class="fa fa-eye"></i> View Reports</button>
                                   
                                </div>
                            </form> <?php
                                    if (isset($records) && count($records) > 0) { ?>                             
                                    <a href="<?php echo base_url(); ?>generatereport/printreport?fromdate=<?php if(isset($_GET['date1'])) echo $_GET['date1'] ?>&todate=<?php if(isset($_GET['date2'])) echo $_GET['date2'] ?>" class="btn btn-danger tooltips pull-right" data-placement="left" title="" data-original-title="Print"><i class="fa fa-print"></i></a> <span class="total_record" style="margin-top: 14px;"> Total Records : <span style="color:red"><?php echo $total_record; ?></span></span> <?php } ?>  
                                    
                            <table class="table datatable table-long table-condensed" id="sasdetails">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($records) && count($records) > 0) {
                                        
                                        foreach ($records as $records_obj) {
                                            ?>
                                            <tr>                                                 
                                                <td><?php echo $records_obj['username']; ?></td>
                                                <td><?php echo date('d/m/Y',strtotime($records_obj['login_date'])); ?></td> 
                                                <td><?php echo $records_obj['time']; ?></td>
                                                <td><?php echo $records_obj['action']; ?></td>
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
                            <?php if(isset($page_links)) echo $page_links; ?>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript">
    $("#datepicker, #datepicker2").datepicker({});
    //$(document).on('ready',function(){
    //   $('#viewreports').on('click',function(){
     //      $fdate = $('#datepicker').val(); 
      //     alert(fdate);
           //$('#fromdate').val($fdate);
          // $('#todate').val($('#datepicker2').val());
     //  });
   // });
</script>
<!-- END CONTAINER -->
<?php
include('common/footer.php');
?>	