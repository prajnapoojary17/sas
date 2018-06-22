<?php
/**
 * sas details script
 * @author = Glowtouch
 */
include ('common/header.php');
?>

<!-- BEGIN CONTENT -->        <div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">                   
                    <i class="fa fa-dashboard"></i> Dashboard
                    <div class="date-display">
                        <i class="icon-calendar"></i>
                        <span id="datetime"></span>
                        <span id="datetime2"></span>
                    </div>
                </h3>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
	<?php  $today=date("d-m-y");
		$marchdate=date("30-02-y");
		?>
		 
		
        <!-- END PAGE HEADER-->
        <!-- BEGIN CONTENT -->
        <div class="row"><?php if ($role == 'Admin') { ?>
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-stat blue-madison">
                        <div class="stat-icon">
                            <i class="icon-users"></i>
                        </div>

                        <div class="details">
                            <div class="number">Payers</div>
                            <div class="desc"><?php echo $users; ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($role == 'Admin') { ?>
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-stat red-madison">
                        <div class="stat-icon">
                            <i class="icon-book-open "></i>
                        </div>

                        <div class="details">
                            <div class="number">Total Sas Records</div>
                            <div class="desc"><?php echo $sasdetails; ?></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($role == 'Editor' || $role == 'Admin') { ?>
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-stat dark-madison">
                        <div class="stat-icon">
                            <i class="fa fa-file-text"></i>
                        </div>
                        <div class="details">
                            <div class="number">Generated Challan</div>
                            <div class="desc"><?php echo $challans; ?></div>
                        </div>
                    </div>
                </div>	
            <?php } ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-industry"></i>Tax Payment Instruction
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"></a>
                            <a href="javascript:;" class="remove"></a>
                        </div>
                    </div>
                    <div class="portlet-body" style="min-height:300px;">
                        <div class="row">	
                            <div class="col-lg-12">
                                <ul class="DSH-L">
                                    <li>5% rebate on total tax paid can be availed if the property tax is paid before 30th April.</li>

                                    <li>2% penalty will be charged on a monthly basis from July if the tax is not paid for the current assessment year. </li>

                                    <li>If you are making payment for previous years, payment shall be made after generating challan for each previous year. </li>

                                    <li>If a owner is a defaulter, system will calculate the interest automatically for the defaulted period at the rate of 2% per month. </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
    <!-- END CONTENT -->
</div>
</div>
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                 <h4 class="modal-title" id="memberModalLabel">Alert</h4>

            </div>
            <div class="modal-body">
              <?php if($swmcess != 12) { ?>
					<p style="font-size:16px;color:red">Please update swm cess masters</p>
				<?php	} 
				if($cess != 1 ) { ?> 
					<p style="font-size:16px;color:red">Please update cess masters</p>
					<?php } 
					if($enhance != 1 ) { ?>
					<p style="font-size:16px;color:red">Please update enhance masters</p>
					
					<?php }  ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
  <?php  if (empty($_SESSION['saw_js'])) { echo 'in'; ?>
   

   <script type="text/javascript">
        $(document).ready(function () {
		
var is_super_admin=<?php echo $is_super_admin; ?>;
var role="<?php echo $role; ?>";
var swmcess=<?php echo $swmcess; ?>;
//var cess='';
var cess=<?php echo $cess; ?>;
var enhance=<?php echo $enhance; ?>;

//var marchdate=<?php echo $marchdate; ?>;
var d = new Date();
    var curr_date = d.getDate();
    var curr_month = d.getMonth() + 1; //Months are zero based
    var curr_year = d.getFullYear();
   var today=curr_date + "-" + curr_month + "-" + curr_year;
var marchdate="30-02-"+ curr_year;
if ((is_super_admin == 1) && (role == 'Admin')  && (marchdate > today)) {

if((swmcess != 12) || (cess != 1) || (enhance != 1) ) { 
  $('#memberModal').modal('show');						
           
		}
}
        });
</script>
<?php $_SESSION['saw_js'] = 'set'; } 
 else 
{ 
$_SESSION['saw_js'] = 'set'; } ?>


<?php
include('common/footer.php');
?>	