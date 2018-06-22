<?php
include ('common/header.php');
?>
<style>
    #example_filter {
        display:none;
    }
</style>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <div class="page-content-wrapper">
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        <h3 class="page-title">
							<i class="fa fa-eye"></i> User Log Details
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
					<div class="portlet box yellow">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-list-ul"></i><?php echo date('l jS F Y'); ?>
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse">
                                    </a>                                    
                                </div>
                            </div>
                            <div class="portlet-body">
							<!-- Modal Review Read More-->
							 <div class="table-responsive">
						<table id="example" class="table datatable table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>SL.No</th>
									<th>User Name</th>
									<th>Time</th>
									<th>IP Address</th>
                                                                        <th>Role</th>
                                                                        <th>Action</th>
								</tr>
							</thead>
							<tbody>
                                                            <?php
                                                            if (count($userlogs) > 0) {
                                                            $i=1;
                                                            foreach($userlogs as $userlog) {?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $userlog['username']; ?></td>
									<td><?php echo $userlog['time']; ?></td>
									<td><?php echo $userlog['ipaddress']; ?></td>
									<td><?php echo $userlog['userrole']; ?></td>
									<td><?php echo $userlog['action']; ?></td>
								</tr>
                                                                <?php 
                                                                $i++;
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
					</div>
				</div>
			</div>
		</div>                    
	</div>
                <!-- END CONTENT -->
</div>
</div>
<?php
include('common/footer.php');
?>
