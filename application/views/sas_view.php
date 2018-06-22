<?php
/**
 * sas details script
 * @author = Glowtouch
 */
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
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-eye"></i> View SAS Details
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
                            <i class="fa fa-list-ul"></i> SAS Details
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

                            <form method="get" enctype="multipart/form-data" action="<?php echo base_url(); ?>sas" name="form_sas" id="form_sas">    
                                <span class="date_btn">Search By</span>	
                                <select name="search_by" class="select_style">
                                    <option value="p_name" <?php if (isset($search_by) AND $search_by == 'p_name') echo "selected='selected'"; ?>>Name</option>
                                    <option value="upi" <?php if (isset($search_by) AND $search_by == 'upi') echo "selected='selected'"; ?>>UPI</option>								  
                                    <option value="assmt_no" <?php if (isset($search_by) AND $search_by == 'assmt_no') echo "selected='selected'"; ?>>Assesment No</option>								   
                                </select>
                                <input type="text" id="sas_search" name="sas_search" value="<?php echo (isset($sas_search)) ? $sas_search : ''; ?>">
                                <button type="submit" class="btn btn-default bt-grey" id="id" name="id">Search</button>                                                                 <button class="btn btn-default bt-grey" style="margin-left:15px" type="button"onclick="location.href = '<?php echo base_url(); ?>sas';">Cancel</button>      
                            </form>
                            <?php echo $page_links; ?>
                            <span class="total_record" style="margin-top: 14px;"> Total Records : <span style="color:red"><?php echo $total_record; ?></span></span>
                            <table class="table datatable table-long table-condensed" id="sasdetails">
                                <thead>
                                    <tr>                                        
                                        <th>UPI</th>
                                        <th>Payer Name</th>
                                        <th>Assessment No</th>
                                        <th>Ward</th>
                                        <th>Block</th>								
                                        <th>Door No.</th>                                                                
                                        <th>Payment Year</th>
                                        <th>Enhanced Tax</th>                                                                                                                                   <th> View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($records) > 0) {
                                        $previous_data = "";
                                        foreach ($records as $records_obj) {
                                            ?>
                                            <tr> 
                                                <td><?php echo $records_obj['upi']; ?></td>
                                                <td><?php echo $records_obj['p_name']; ?></td>
                                                <td><?php echo $records_obj['assmt_no']; ?></td> 
                                                <td><?php echo $records_obj['p_ward']; ?></td>
                                                <td><?php echo $records_obj['p_block']; ?></td>
                                                <td><?php echo $records_obj['door_no']; ?></td>
                                                <td><?php echo $records_obj['p_year']; ?></td>
                                                <td><?php echo $records_obj['b_enhc_tax']; ?></td>                                                    
                                                <td>
                                                    <a href="#" class="btn btn-warning tooltips viewbtn" data-toggle="modal" data-target="#viewModal" data-placement="left" title="View" data-pid='<?php echo $records_obj['pid']; ?>' data-bid='<?php echo $records_obj['bid']; ?>'><i class="fa fa-eye"></i></a>
                                                    &nbsp;</td>
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
                            <?php echo $page_links; ?>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>
        <!-- END CONTENT -->
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
            </div>
            <div class="modal-body" id="edit_pay" style="overflow-y: scroll; height: 600px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    var clBtn = document.getElementsByClassName("close")[0];
    $(".viewbtn").on('click', function () {
    $.ajax({
            type: "POST",
    url: baseUrl + "sasdetails/view_sas",
            data: {pid: $(this).data("pid"), bid: $(this).data("bid")},
            success: function (response) {
            $('#edit_pay').html(response);
            $('#viewModal').modal('show');             }
                });
    });
    clBtn.onclick = function () {
                modal.style.display = "none";
    }
</script>    
<?php
include('common/footer.php');
?>	