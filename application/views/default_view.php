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
                    <i class="fa fa-user"></i> Defaulter List
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
                            <i class="fa fa-industry"></i> Defaulter List
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <form class="form-horizontal form-striped" action="<?php echo base_url(); ?>defaultreport" method="get" name="demandtax" id="demandtax">
                                <div class="col-lg-4">            							
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Ward</label>
                                        <div class="col-sm-6">      
										
											<select class="form-control  CCInput" name="ward" id="ward" required>	
											<option  value="" selected>Select</option>											 
											 <?php
                                                for ($w = 0; $w < count($ward); $w++) {
                                                    ?>
                                                    <option  value="<?php echo $ward[$w]->ward_name; ?>" <?php
													if(isset($_GET['ward']))
													{
                                                             if (($ward[$w]->ward_name) == ($_GET['ward'])) {
                                                                 echo "selected";
                                                             }
															 }
                                                             ?>><?php echo $ward[$w]->ward_name; ?></option>
                                            <?php	
											} ?>
											</select>
                                        </div>
                                    </div>									                                 
                                </div>
                                <div class="col-lg-4">

                                  <!--  <div class="form-group">
                                        <label class="col-sm-6 control-label">From</label>
                                        <div class="col-sm-6">
                                            <select class="form-control select2me" name="fromdate" id="fromdate">	
                                                <option  value="">Select</option>											
                                                <?php
                                                for ($s = 0; $s < count($selectyear); $s++) {
                                                    ?>
                                                    <option  value="<?php echo $selectyear[$s]->e_year; ?>"><?php echo $selectyear[$s]->e_year; ?></option>                                                       
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-6 control-label">To</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control CCInput" value="" id="todate" name="todate">
                                        </div>
                                    </div>-->
                                </div>                                     									 
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-flat btn-green" id="id" name="id"><i class="fa fa-eye"></i> View Reports</button>
                                   <a   onclick="myfunction()" class="btn btn-flat btn-dark"><i class="fa fa-repeat"></i> Reset</a>
                                </div>
                            </form>
                        </div>
						<p>Total tax payable for each Assessment Year will be calculated based on date of payment selected, which will include penalty, SWM charges, etc.</p>
                        
                        <hr class="arrow-line">		
                        <br>
                        <br>	
<?php  if((isset($sidedata)) && (count($sidedata)>0))
										  { ?>
                        <div class="table-responsive defaulttable">
                            <div class="table-responsive custom_datatable">                                                         
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr><td colspan="13"><strong>Ward :<?php if(isset($_GET['ward'])) { echo $_GET['ward']; }?></strong></td></tr>
                                        
                                        <tr>
                                            <th>UPI</th>
                                            <th>Payer Name</th>
                                            <th>Address</th>
                                            <th>Assessment No</th>
                                            <th>Assessment Year</th>
                                            <th>Total Balance(Enhancement tax + Cess)</th>                                                                                  
                                        </tr>
									
                                          <?php  if(isset($sidedata))
										  {
										  foreach($sidedata as $data)
                                        { ?>
                                        <tr>
                                            <td><?php echo $data->upi ?></td>
                                            <td><?php echo getpname($data->upi) ?></td>
                                            <td><?php echo getvillage($data->upi) ?></td>
                                            <td><?php echo getassmt_no($data->upi) ?></td>
                                            <td><?php $getyears=getyears($data->upi); for($i=0; $i<count($getyears);$i++) {
											echo $year=$getyears[$i]['p_year']; 
											echo '<br>';
											} 
											?></td>
                                            <td><?php $bal=getbalance($data->upi);echo $bal[0]['total'];//echo getbalance($data->upi) ?></td>                                                                                  
                                        </tr>
                                      <?php  }
											}	 ?>

                                    </tbody></table>	
<?php
                                if (isset($page_links)) {
                                    echo $page_links;
                                }
                                ?> 									
                            </div>
							 <?php  if(isset($sidedata))
										  { ?>
                            <a href="<?php echo base_url(); ?>defaultreport/printscreen?&ward=<?php if(isset($_GET['ward'])) { echo $_GET['ward']; } ?>&per_page=<?php if(isset($_GET['per_page'])) { echo $_GET['per_page']; } ?>" target="_blank" class="btn btn-danger tooltips" data-placement="left" title="" data-original-title="Print"><i class="fa fa-print"></i> Print</a>
						<?php	} ?>
                        </div> 
						
				<?php		} ?>
                    </div>
                </div>
            </div>                 
        </div>
		
        <!-- END CONTENT -->
    </div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
function myfunction() {
//alert("in");
      // $('.defaulttable').html('');
	  // $("#ward").val('');
	  location.href="<?php echo base_url(); ?>defaultreport";
		
    }
	</script>
<!-- END CONTAINER -->
<?php
include('common/footer.php');
?>	