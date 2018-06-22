
<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script type="text/javascript">
    // When the document is ready
    $(document).ready(function () {

        $(function () {
            $('.btn-danger').click(function (e) {
                e.preventDefault();
                if (confirm("Are you sure")) {
                    $.ajax({
                        type: "POST",
                        url: "usermanage/delete_user",
                        data: {"id": $(this).data("id")},
                        dataType: "text",
                        success: function () {
                            alert('done');
                        }
                    });
                }
                return false;
            });
        });

    });
</script>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-user"></i> Manage User
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
            <div class="col-lg-6">
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-user-plus"></i>Add New User
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>


                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php echo validation_errors(); ?>
                        <?php echo form_open(('usermanage/create'), array('class' => 'form-horizontal', 'form-striped')); ?>    
                        <div class="form-group">
                            <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputRole" class="col-sm-2 control-label">Role</label>
                            <div class="col-sm-10">
                                <select class="form-control select2me" name = 'role'>
                                    <option>Admin</option>
                                    <option>User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputStatus" class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10">
                                <input class="switch" type="checkbox" checked data-on-text="Active"  data-off-text="Inactive" data-on-color="success" name='status'>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-flat btn-green"><i class="fa fa-file-text-o"></i> Save</button>
                                <button type="submit" class="btn btn-flat btn-dark"><i class="fa fa-file-text-o"></i> Reset</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Users List
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?php echo $success; ?>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody><?php
                                if (count($records) > 0) {
                                    $previous_data = "";
                                    foreach ($records as $records_obj) {
                                        ?>
                                        <tr>
                                            <td><input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username" value = <?php echo $records_obj['username']; ?></td>
                                            <td><input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username" value = <?php echo $records_obj['username']; ?></td>
                                            <td><input type="text" class="form-control" id="inputUsername" placeholder="Username" name="username" value = <?php echo $records_obj['username']; ?></td>
                                            <td>
                                                <a href="usermanage/delete"  class="btn btn-warning" data-id='<?php echo $records_obj['username']; ?>' ><i class="fa fa-edit" ></i></a>
                                                <a href="" class="btn btn-danger" data-id='<?php echo $records_obj['username']; ?>' ><i class="fa fa-trash-o"></i></a>
                                            </td>
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
                    </div>
                </div>
            </div>

        <!-- END CONTENT -->

    </div>

    <?php
    include('common/footer.php');
    ?>

