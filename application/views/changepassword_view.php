<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<style>
.error-msg{
   background-color: #FF0000;
}
</style>
<div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title">
							<i class="fa fa-user"></i> Change Password
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
                                    <i class="fa fa-user-plus"></i>Update New Password
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>
                                    <a href="javascript:;" class="remove">
                                    </a>
                                </div>
                            </div>
							
                            <div class="portlet-body" style="width:100%; float:left;">
							
							<div id = "msg" style="display:none;color:red;font-size:16px">The Password you have entered does not match your current one</div> 
							<div id = "msg1" style="display:none;color:red;font-size:16px">Passwords do not match</div> 
							<div id = "msg2" style="display:none;color:red;font-size:16px">Password shouldn't be same as the old password</div> 
                             <form class="form-horizontal" id="id" autocomplete="off">
								
									<p class="form-required"><i class="fa fa-asterisk text-danger"></i> Required field</p>
									<div class="col-lg-6 col-sm-6">
										<div class="form-group">
											<label for="inputPassword" class="col-sm-4 control-label">Current Password</label>
											<div class="col-sm-8">
												<input type="password" autocomplete="off" class="form-control" id="currentpswd" value="" required="required" placeholder="Current Password"  onChange="showUser(this.value)">
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword" class="col-sm-4 control-label">Enter New Password</label>
											<div class="col-sm-8">
												<input type="password" class="form-control"    id="txtPassword" name="txtPassword"pattern=".{8,10}"  title="8 to 10 characters" placeholder="Enter New Password" onChange="comparePassword(this.value)" required>
											</div>
										</div>
										<div class="form-group">
											<label for="inputPassword" class="col-sm-4 control-label">Confirm New Password</label>
											<div class="col-sm-8">
												<input type="password" class="form-control"  id="txtConfirmPassword" name="txtConfirmPassword" pattern=".{8,10}"  title="8 to 10 characters"  placeholder="Re Enter Password" required>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-4 col-sm-8">
												<button type="submit"  name="id" class="btn btn-flat btn-green"><i class="fa fa-floppy-o"></i> Save</button>
												<button type="reset" class="btn btn-flat btn-dark" id="reset"><i class="fa fa-repeat"></i> Reset</button>
											</div>
										</div>
									</div>						
                             </form>
                            </div>
						</div>
                    </div>					                  
                </div>
                <!-- END CONTENT -->
            </div>
        </div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
$("#reset").on("click", function () {
location.reload();
});
</script>
<script>
$( document ).ready(function() {
$('#currentpswd').val("a");
$('#currentpswd').val("");
$("#msg").hide();
	});
  $("#id").submit(function (e) {
	 e.preventDefault();     
	 var password = document.getElementById("txtPassword").value;

		 var currentpswd = document.getElementById("currentpswd").value;

        var confirmPassword = document.getElementById("txtConfirmPassword").value;

		if(currentpswd)
		{
		if (password != confirmPassword) {
            $("#msg1").show();
            return false;
        }
		 $("#msg1").hide();
		$.ajax({
            type: "POST",
            url: "changepassword/verifycurrentpassword",
            data: {'val':currentpswd},
            cache: false,
            success: function (result) {
			
			if(result == 'notmatch')
			{
			$("#msg").show();
			return false;
			}
			else
			{
		
			$.ajax({
            type: "POST",
            url: "changepassword",
            data: {'txtPassword':password},
            cache: false,
            success: function (result1) {		
			
               alert("password changed");
			   window.location = 'changepassword';
            }
        });
			}
            }
        });
		
		}
		
		
        return true;
    });

    function showUser(val) {

	$.ajax({
            type: "POST",
            url: "changepassword/verifycurrentpassword",
            data: {'val':val},
            cache: false,
            success: function (result) {
			
			if(result == 'notmatch')
			{
			$("#msg").show();
			return false
			}
			else
			{
			$("#msg").hide();
			}
                //alert("Payment details updated sucessfully");
            }
        });
	}
	
	 function comparePassword(val) {
		 var password = document.getElementById("txtPassword").value;
var currentpswd = document.getElementById("currentpswd").value;

		$.ajax({
            type: "POST",
            url: "changepassword/verifycurrentpassword",
            data: {'val':password},
            cache: false,
            success: function (result) {
		if(result == 'notmatch')
			{
			$("#msg2").hide();
			return false
			}
			else
			{
			$("#msg2").show();
			}
	}
	});
	}

</script>	

<?php
include('common/footer.php');
?>	