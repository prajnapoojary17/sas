<?php/**   * User Manage script   * @author = Glowtouch*/include ('common/header.php');?>        <div class="page-content-wrapper">            <div class="page-content">                <!-- BEGIN PAGE HEADER-->                <div class="row">                    <div class="col-md-12">                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->                        <h3 class="page-title">							<i class="fa fa-building"></i> Construction Rate(City)							<div class="date-display">								<i class="icon-calendar"></i>								<span id="datetime"></span>								<span id="datetime2"></span>							</div>                        </h3>                        <!-- END PAGE TITLE & BREADCRUMB-->                    </div>                </div>                <!-- END PAGE HEADER-->                <!-- BEGIN CONTENT -->                <div class="row">                    <div class="col-lg-12">					<div class="portlet box green-seagreen">                            <div class="portlet-title">                                <div class="caption">                                    <i class="fa fa-area-chart"></i>Manage - Construction Rate(City)                                </div>                                <div class="tools">                                    <a href="javascript:;" class="collapse">                                    </a>                                    <a href="javascript:;" class="remove">                                    </a>                                </div>                            </div>                            <div class="portlet-body">														<form class="form-horizontal" action="<?php echo base_url();?>constratecity/add_constratecity" method="POST">                                                            <input type="hidden" class="form-control" id="city_id" name="city_id">							  <div class="form-group">								<label class="col-sm-2 control-label">Type of Construction</label>								<div class="col-sm-4">								  <input type="text" class="form-control" id="type_of_construction" name="c_type"  placeholder="RCC, Granite Flooring" required> 								</div>							  </div>							  <div class="form-group">								<label class="col-sm-2 control-label">Ground Floor</label>								<div class="col-sm-4">								  <input type="text" class="form-control" id="ground_floor" name="g_floor"  placeholder="1200" pattern="[0-9]+(\.[0-9][0-9]?)?" required>								</div>							  </div>							  <div class="form-group">								<label class="col-sm-2 control-label">Upper Floor</label>								<div class="col-sm-4">								  <input type="text" class="form-control" id="upper_floor" name="u_floor" placeholder="1000" pattern="[0-9]+(\.[0-9][0-9]?)?" required>								</div>							  </div>														<div style="color:red;font-size:16px">	<?php echo $message= $this->session->flashdata('message');?></div>								<div class="form-group">									<div class="col-sm-offset-2 col-sm-4">										<button type="submit" class="btn btn-flat btn-green"><i class="fa fa-floppy-o"></i> Save</button>										<button type="submit" class="btn btn-flat btn-dark"><i class="fa fa-repeat"></i> Reset</button>									</div>								</div>							</form>								<hr class="arrow-line" />						<table class="table datatable">						<thead>							<tr>								<th>Type of Construction</th>								<th>Ground Floor</th>								<th>Upper Floor</th>								<th>Edit</th>							</tr>						</thead>						  <tbody><?php if(count($constratecity)>0)                                        {                                            $previous_data = "";                                                                                        	 foreach($constratecity as $constratecitys) 						{?>							<tr>								<td><?php echo $constratecitys->c_type;?></td>								<td><?php echo $constratecitys->g_floor;?></td>								<td><?php echo $constratecitys->u_floor;?></td>																<td>									<a href="#" class="btn btn-warning tooltips" data-placement="left" title="View" data-ctype="<?php echo $constratecitys->c_type ?>" data-groundfloor="<?php echo $constratecitys->g_floor ?>"  data-upperfloor="<?php echo $constratecitys->u_floor ?>" data-id="<?php echo $constratecitys->id ?>"  id="city_edit"><i class="fa fa-edit"></i></a>								</td>							</tr>						<?php	}                                        }                                        else {?>                                                                                      <tr>                                                    <td class="active" colspan="26" align="center"><span style="font-weight: bold; color: red">Sorry, No Records!</span></td>                                              </tr>                                                                                    <?php                                        }                                        ?>                                    </tbody>					</table>					</div>                        </div>						</div>                                    </div>                <!-- END CONTENT -->            </div>        </div>    </div><?php include('common/footer.php');?>	<script src="<?php echo base_url(); ?>assets/js/const_city.js"></script>    