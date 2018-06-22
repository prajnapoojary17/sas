<?php
include ('common/header.php');
?>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<style>
    /* Loader */
.loader {
    background: rgba(0, 0, 0, 0.8) none repeat scroll 0 0;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999;
}
.loader-container {
    font-size: 12px;
    height: 60px;
    margin: 30vh auto;
    text-align: center;
    text-transform: uppercase;
    width: auto;
}
.spinner {
  width: 60px;
  height: 60px;
  margin: 0 auto;
  -webkit-animation: rotate 1.4s infinite ease-in-out, background 1.4s infinite ease-in-out alternate;
          animation: rotate 1.4s infinite ease-in-out, background 1.4s infinite ease-in-out alternate;
}

@-webkit-keyframes rotate {
  0% {
    -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg);
            transform: perspective(120px) rotateX(0deg) rotateY(0deg);
  }
  50% {
    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(0deg);
            transform: perspective(120px) rotateX(-180deg) rotateY(0deg);
  }
  100% {
    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-180deg);
            transform: perspective(120px) rotateX(-180deg) rotateY(-180deg);
  }
}

@keyframes rotate {
  0% {
    -webkit-transform: perspective(120px) rotateX(0deg) rotateY(0deg);
            transform: perspective(120px) rotateX(0deg) rotateY(0deg);
  }
  50% {
    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(0deg);
            transform: perspective(120px) rotateX(-180deg) rotateY(0deg);
  }
  100% {
    -webkit-transform: perspective(120px) rotateX(-180deg) rotateY(-180deg);
            transform: perspective(120px) rotateX(-180deg) rotateY(-180deg);
  }
}
@-webkit-keyframes background {
  0% {
  background-color: #27ae60;
  }
  50% {
    background-color: #9b59b6;
  }
  100% {
    background-color: #c0392b;
  }
}
@keyframes background {
  0% {
  background-color: #27ae60;
  }
  50% {
    background-color: #9b59b6;
  }
  100% {
    background-color: #c0392b;
  }
}
</style>
<div class="loader wait" style="display: none">
    <div class="loader-container">
        <div class="spinner"></div>
        Please wait...
    </div>
</div>
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title">
							<i class="fa fa-eye"></i> Import
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
										<i class="fa fa-industry"></i>Upload files
									</div>
									<div class="tools">
										<a href="javascript:;" class="collapse">
										</a>
										<a href="javascript:;" class="remove">
										</a>
									</div>
								</div>                                                    
								<div class="portlet-body">
                                                                    
								<br>                                                                
                                                                <div id = "validn"></div>
                                                                 <form action="" method="POST" enctype="multipart/form-data" name="importform" id="importform">  
										<div class="input-group image-preview col-lg-6  filesec">
											<input type="file" name="userfile" pattern="^.+\.(xlsx|xls|csv)$" class="fileinput"/>
											<span class="input-group-btn"> 
											<button type="submit" class="upload btn btn-labeled btn-primary" value="upload" name="upload"> <span class="btn-label"><i class="glyphicon glyphicon-upload"></i> </span>Upload</button>
											</span> 
										</div>
										<br>
                                                                 </form>
                                                                <div class="alert alert-info">Mandatory fields cannot be empty
while importing the CSV file to database</div>
                                                                </div>										
								</div>
							</div>
					</div>
				</div>
			</div>
<?php
include('common/footer.php');
?>
<script>
    var baseUrl = "<?php echo base_url(); ?>";
    $("input[name='userfile']").click(function () {
        $('#validn').html('');
        $("#validn").removeClass("alert-danger alert");
        $("#validn").removeClass("alert alert-success"); 
    });

$("#importform").submit(function (e) {
        $('.wait').show();
        var formDataVal = document.forms.namedItem("importform");
        var formVals = new FormData(formDataVal);
	e.preventDefault();
        $.ajax({
            type: "POST",
            url: baseUrl + "importdata/importdataadd",
            data: formVals,
            dataType:"json",
            contentType: false,
            cache: false,
            processData: false,           
            success: function(data){
                $('.wait').hide();
                if(data.status == true){               
                    $("#validn").html(data.msg);
                    $("#validn").addClass("alert alert-success");                    
                }else{ 
                    $("#validn").html(data.msg);
                    $("#validn").addClass("alert-danger alert");
                }
            },
            error : function(data){
                $('.wait').hide();
                $("#validn").html('Please upload file with valid data');
                $("#validn").addClass("alert-danger alert");               
                exit();
            }
	});
	return false;	
    });
</script>