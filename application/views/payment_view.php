<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<style>
    .portlet-body .btn {
        margin-bottom: 3px;
        color: #fff;
    }
</style>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
  $("#errormsg").hide();
    $("#errormsg1").hide();
	  $("#errormsg1").hide();
    var baseUrl = "<?php echo base_url(); ?>";
	
	
    editPayment = function (pYear, upId, propId, maxYear,isVerfied) {
	
	
        if (pYear == '' || propId == '')
        {
            //alert("Please update sas details first, only then u can edit payment details");
			 var msg="Please contact the MCC Revenue Department to add SAS information";
						$("#errormsg2").html(msg);
						$("#errormsg2").show();
            return false;
        }
        var year = pYear;
       
		 var dataString = 'pYear=' + pYear + '&upId=' + upId + '&a_year=' + year + '&taxApplicableFromStartYear=' + maxYear;  		 
            $.ajax({
                type: "POST",
                url: "payment/check_not_payed_user",
                data: dataString,
                cache: false,
				dataType:"json",
                async: false,
                success: function (result) {
				
				if(result.st=="payed" || isVerfied==0)
				{
			
				proceedpayment(pYear,upId,propId,maxYear);
			/*$('#inset_form').html('<form action="' + baseUrl + 'payment/edit_payment" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="assmtno" value="' + assmtNo + '" /><input type="text" name="p_year" value="' + pYear + '" /><input type="text" name="upi" value="' + upId + '" /><input type="text" name="pid" value="' + propId + '" /></form>');
                        $(".driveway").submit();*/
				}
				else
				{
				
				//alert(result.msg);
				var names=[];
				var pen=[];
				 for (var i = 0; i < result.msg.length; i++) {
				 pen.push(result.msg[i]);
				
				var verification_pending=$("#drop"+result.msg[i]).val();
				
				
				if(verification_pending==1)
				{
				
				
			
				names.push(result.msg[i]);
				
				
				//$("#pendingyears").html(result.msg);
				//alert('Please Pay for ' +result.msg[i]+ 'or change the verification status to proceed');
				//return false;
				}
				
				}
				
				if(names.length>0)
				{
				//alert("Please Pay for " +names+ "or change the verification status to proceed");
				$("#pendingyears").html("Please Pay for  "  +names+  " or change the verification Pending status to Yes to proceed");
				$("#proceed").html('');
				$('#paymentModal').modal('show');
				
				return false;
				}
				else if(pen.length>0)
				{
				
				$("#pendingyears").html("Payment for "  +pen+ "  is pending,Do you want to proceed?");
				
				//$("#clickpay").html("Please Click on proceed to Pay button");
				
				$("#proceed").html('<a  onclick="proceedpayment(\'' +pYear+ '\',\''  + upId + '\',' + propId + ',\''  + maxYear + '\');"><span class="btn btn-primary">Proceed To Pay</span></button>');
				$('#paymentModal').modal('show');
				}
				
				
				
				
				}
				
				
            }
                   
		
		 });
		}
		
   
 
    viewPayment = function (pYear, upId, propId) {
        $('#view_form').html('<form action="' + baseUrl + 'payment/view_payment" name="viewpay" class="viewpay" method="post" style="display:none;"><input type="text" name="p_year" value="' + pYear + '" /><input type="text" name="upi" value="' + upId + '" /><input type="text" name="pid" value="' + propId + '" /></form>');
        $(".viewpay").submit();
    };
    
    sasPayment = function () {
	
        $("#errormsg").show();
    }
	
	  function changestatus(upId,propId) {
	var val=$('#'+upId).val();
	var dataString = 'val=' + val + '&propId=' + propId;

            $.ajax({
                type: "POST",
                url: "payment/updateverification",
                data: dataString,
                cache: false,
				dataType:"json",
                async: false,
                success: function (result) {
				//alert(result.msg);
				}
				
				});
				
	//alert(upId+propId);
	}
	
	
	function proceedpayment(pYear,upId,propId,maxYear)
	{
	
			$('#inset_form').html('<form action="' + baseUrl + 'payment/edit_payment" name="driveway" class="driveway" method="post" style="display:none;"><input type="text" name="p_year" value="' + pYear + '" /><input type="text" name="upi" value="' + upId + '" /><input type="text" name="pid" value="' + propId + '" /></form>');
                        $(".driveway").submit();
	}
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title" id="paymentEdit">
                    <i class="fa fa-edit"></i> Manage Payment Details
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
                    <div class="form-horizontal">
                        <div class="portlet box green-seagreen">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-industry"></i>Payment Details
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                                </div>
                            </div>
							<form method="get" action="<?php echo base_url(); ?>payment">
                            <div class="portlet-body" style="padding:25px;background-color:white">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">UPI</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="upi" value="<?php  if(isset($_GET['upi'])) echo $_GET['upi']; ?>">
                                            </div>
                                        </div>												
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="form-group" align="center">
                                            <button type="button" class="btn btn-primary">OR</button>
                                        </div>	
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Assessment No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="assmt_no" value="<?php if(isset($_GET['assmt_no'])) echo $_GET['assmt_no'] ?>">
                                            </div>
                                        </div>												
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="col-lg-12">
                                            <input type="submit" value="SUBMIT" class="btn btn-green">                                         
                                        </div>	
                                    </div>
                                </div>									
                            </div>
							</form>
                        </div>
                        <div id = "errormsg" style="display:none;color:red;font-size:16px">Please contact the MCC Revenue Department to add SAS information</div> 
						<div id = "errormsg1" style="display:none;color:red;font-size:16px"></div> 
						<div id = "errormsg2" style="display:none;color:red;font-size:16px"></div> 
                        <br>
                        <div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-list-ul"></i>Payment Details
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <!-- Modal Review Read More-->
                                <div class="modal fade" id="readmore1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Nagesh Alva</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
					
                                <div class="table-responsive">
                                    <table class="table datatable table-long table-condensed">
                                        <thead>
                                            <tr>	
                                                <th>UPI</th>
                                                <th>Payer Name</th>
                                                <th>Assessment No.</th>
                                                <th>Ward</th>		
                                                <th>Block</th>									
                                                <th>Door No.</th>								
                                                <th>Payment Year</th>
                                                <th>Date Of Payment</th>
                                                <th>Payment Status</th>
												<th>Verification Pending</th>
                                                <th>View / Edit</th>
                                                <th>Print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($info) > 0) {
                                                foreach ($info as $info_obj) {
											
                                                    $pyear = $info_obj['p_year'];
                                                    $b_cess = 0;
                                                    $cess = 0;
                                                    $ehnc = 0;
                                                    if ($pyear) {
                                                        $cess = get_cess($pyear);
                                                        $ehnc = $info_obj['enhn_total'];

                                                        $cess_percent = $cess / 100;
                                                        $b_cess = round($ehnc * $cess_percent);
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $upi = $info_obj['upi']; ?></td>
                                                        <td><?php echo $info_obj['p_name']; ?></td>
                                                        <td><?php echo $assmt_no=$info_obj['assmt_no']; ?></td>
                                                        <td><?php echo $info_obj['p_ward']; ?></td>
                                                        <td><?php echo $info_obj['p_block']; ?></td>
                                                        <td><?php echo $info_obj['door_no']; ?></td>
                                                        <td><?php 
                                                            echo $pyear1 = $info_obj['p_year']; ?></td>
                                                        <td><?php echo $info_obj['payment_date']; ?></td>
                                                        <?php if ($info_obj['payment_date'] == '') { ?>

                                                            <?php if ($pyear1 == '') { ?>
                                                                <td vertical-align="middle"><span class = "label label-danger"><a href="#" onclick="sasPayment()"> Pay</a></span></td>	
																
														<td>
															<select style="width:80px" onchange="changestatus('drop<?php echo $pyear1 ?>',<?php echo $info_obj['propid'] ?>);" id="drop<?php echo $pyear1 ?>">
																<option data-tokens="ketchup mustard" <?php if(($info_obj['is_verified']==0)||($info_obj['is_verified']=='')) { echo 'Selected'; }?> value="0">Yes</option>
																
															<option data-tokens="mustard" value="1" <?php if($info_obj['is_verified']==1) { echo 'Selected'; }?>>No</option>
															</select>
														</td>
													
                                                                <td>
                                                                    <a  href="#" name="nosas" id="nosas"   onclick="sasPayment()" class="btn btn-warning tooltips user_edit"  data-placement="left"  title="Edit"><i class="fa fa-edit"></i></a>									
                                                                </td>
                                                                <?php
                                                            } 
															else {
                                                             $maxyear= get_max_payment_year($upi); ?>
																
                                                                <td vertical-align="middle"><span class = "label label-danger"><a href="#" onclick="editPayment('<?php echo $pyear1 ?>', '<?php echo $upi ?>',<?php echo $info_obj['propid'] ?>, '<?php echo $maxyear; ?>')" data-toggle="modal" >Pay</a></span></td>
<td>
															<select style="width:80px" onchange="changestatus('drop<?php echo $pyear1 ?>',<?php echo $info_obj['propid'] ?>);" id="drop<?php echo $pyear1 ?>">
																<option data-tokens="ketchup mustard" <?php if(($info_obj['is_verified']==0)||($info_obj['is_verified']=='')) { echo 'Selected'; }?> value="0">Yes</option>
																
															<option data-tokens="mustard" value="1" <?php if($info_obj['is_verified']==1) { echo 'Selected'; }?>>No</option>
															</select>
														</td>																
                                                                <td>
                                                                    <a  href="#" name="edit_payment" id="edit_payment"   onclick="editPayment('<?php echo $pyear1 ?>', '<?php echo $upi ?>',<?php echo $info_obj['propid'] ?>, '<?php echo $maxyear; ?>','<?php echo $assmt_no; ?>')" class="btn btn-warning tooltips user_edit"  data-placement="left"  title="Edit"><i class="fa fa-edit"></i></a>									
                                                                </td>
                                                            <?php } ?>
                                                            <td>                                                                    
                                                                <a  class="btn btn-default tooltips" data-placement="left" title="Print"><i class="fa fa-print" style="color:black"></i></a>
                                                            </td>	
                                                            <?php
                                                        } 
														elseif(($info_obj['payment_date'] != '') && ($info_obj['is_payed'] == 0))
														{
														$maxyear= get_max_payment_year($upi); ?>
																
                                                                <td vertical-align="middle"><span class = "label label-danger"><a href="#" onclick="editPayment('<?php echo $pyear1 ?>', '<?php echo $upi ?>',<?php echo $info_obj['propid'] ?>, '<?php echo $maxyear; ?>',<?php echo $info_obj['is_payed']; ?>)">Inprogress</a></span></td>	
<td>
															<select style="width:80px" onchange="changestatus('drop<?php echo $pyear1 ?>',<?php echo $info_obj['propid'] ?>);" id="drop<?php echo $pyear1 ?>">
																<option data-tokens="ketchup mustard" <?php if(($info_obj['is_verified']==0)||($info_obj['is_verified']=='')) { echo 'Selected'; }?> value="0">Yes</option>
																
															<option data-tokens="mustard" value="1" <?php if($info_obj['is_verified']==1) { echo 'Selected'; }?>>No</option>
															</select>
														</td>																
                                                                <td>
                                                                    <a  href="#" name="edit_payment" id="edit_payment"   onclick="editPayment('<?php echo $pyear1 ?>', '<?php echo $upi ?>',<?php echo $info_obj['propid'] ?>, '<?php echo $maxyear; ?>')" class="btn btn-warning tooltips user_edit"  data-placement="left"  title="Edit"><i class="fa fa-edit"></i></a>									
                                                                </td>
                                                            
                                                            <td>                                                                    
                                                                <a  class="btn btn-default tooltips" data-placement="left" title="Print"><i class="fa fa-print" style="color:black"></i></a>
                                                            </td>	
														<?php }
														
														else {
                                                            ?>
                                                            <td>
                                                                <span class = "label label-primary">Paid</span>
                                                            </td>
<td>
															No
														</td>															
                                                            <td>
															<a href="#" class="btn btn-warning tooltips viewbtn" data-toggle="modal" data-target="#viewpayment"  data-placement="right" title="" data-upis='<?php echo $info_obj['upi']; ?>' data-pid='<?php echo $info_obj['propid']; ?>' data-original-title="View"><i class="fa fa-eye"></i></a>
                                                                
                                                            </td>
                                                            <td>
                                                                <a  href="<?php echo base_url(); ?>payment/printscreen?upi=<?php echo $upi; ?>&propid=<?php echo $info_obj['propid']; ?>" target="_blank" class="btn btn-danger tooltips" data-placement="left" title="Print"><i class="fa fa-print"></i></a>
                                                            </td>	

                                                        <?php } ?>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>											
                </div>							
                </div>
				<div class="modal fade in" id="viewpayment" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Details</h4>
            </div>
            <div class="modal-body" id="edit_pay" style="overflow-y: scroll; height: 600px;"><!-- END PAGE HEADER-->

  </div>
<!-- END CONTENT -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
      
    </div>
</div>
</div>
                <div id="inset_form">
                </div>
                <div id="view_form">
                </div>
            </div>
        </div> 					
    </div>
    <!-- END CONTENT -->
</div>
</div>
</div>
<!-- Modal -->
	<div class="modal fade modal-danger" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog " role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h3 class="modal-title" id="exampleModalLabel">Verification Pending</h3>
		  </div>
		  <div class="modal-body">
			<h4 id="pendingyears"></h4>
			
			<h4 id="clickpay"></h4>
		  </div>
		  <div class="modal-footer">
		  <div id="proceed" class="pull-left"></div>
			<span class="btn btn-default" data-dismiss="modal">Close</span>
			
		  </div>
		</div>
	  </div>
	</div>
<script>

    var clBtn = document.getElementsByClassName("close")[0];
    $(".viewbtn").on('click', function () {
	 $("#errormsg").hide();
    $("#errormsg1").hide();
	  $("#errormsg1").hide();
    $.ajax({
            type: "POST",
    url: baseUrl + "payment/view_payment",
            data: {pid: $(this).data("pid"),upis: $(this).data("upis")},
            success: function (response) {
            $('#edit_pay').html(response);
            $('#viewModal').modal('show');             }
                });
    });
    clBtn.onclick = function () {
                modal.style.display = "none";
    }
</script>
<!-- END CONTAINER -->
<?php
include('common/footer.php');
?>