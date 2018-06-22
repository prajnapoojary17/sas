
<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<style>
    .errorClass { border:  1px solid red; } 
	
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

<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

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
            <div class="col-lg-12">
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-user-plus"></i>Add New User
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body" style="width:100%; float:left;">
                        <?php
                        echo validation_errors();
                        ?> 
                        <form class="form-horizontal" id="usermange" method="post">				
                            <p class="form-required"><i class="fa fa-asterisk text-danger"></i> Required field</p>
                            <div class="col-lg-6 col-sm-6">
                                <div id = "errormsg" style="color:red;font-size:16px"></div>
                                <div id = "errormsg1" style="color:red;font-size:16px"></div>
                                <div id = "errormsg2" style="color:red;font-size:16px"></div>
                                <div id = "errormsg4" style="color:red;font-size:16px"></div>
                                <div class="form-group has-feedback">
                                    <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control"  placeholder="Username" name="username" id="username" required="required" onChange="showUser(this.value)" maxlength="25">
                                        <i class="fa fa-asterisk text-danger form-control-feedback"></i>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control"  placeholder="Password"  onblur="showPassword()" name="password" id="password" pattern=".{8,}"  title="8 characters minimum" required="required" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">Re-Enter Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re Enter Password"   pattern=".{8,}" required title="8 characters minimum" required   onblur="showPassword()">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" id="email" name="email"  class="form-control"    onChange="showEmail(this.value)"> </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <label for="inputPassword" class="col-sm-2 control-label">Contact #</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="contact" name="contact"   class="form-control"> </div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="inputRole" class="col-sm-2 control-label">Role</label>
                                    <div class="col-sm-10"> 
                                        <select class="form-control select2me" name = 'role' id="role">          

                                            <?php if ($is_super_admin == 1) { ?>	 <option value="Admin">Admin</option> <?php } ?>
                                            <option value="Viewer">Viewer</option>
                                            <option value="Editor">Editor</option>
                                        </select>
                                        <i class="fa fa-asterisk text-danger form-control-feedback form-control-select"></i>
                                        <br>                                                                          
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputStatus" class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10">
                                        <input class="switch" type="checkbox"  checked data-on-text="Active"  data-off-text="Inactive" data-on-color="success" name='status' id="status">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit"   class="btn btn-flat btn-green"><i class="fa fa-floppy-o"></i> Save</button>
                                        <button type="reset" id="reset" class="btn btn-flat btn-dark"><i class="fa fa-repeat"></i> Reset</button>
                                    </div>
                                </div>                                        
                            </div>
                        </form>
                    </div>
                </div>
                <div style="height:30px;float:left;width:100%;"></div>
            </div>                    
            <div class="col-md-12">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-users"></i>Users List
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Contact #</th>                                                
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($records as $records_obj) {
                                        ?>
                                    <form class="form-horizontal">
                                        <tr>

                                            <td>
                                                <span class='span_models<?php echo $records_obj['id'] ?>' class='text'><?php echo $records_obj['username'] ?></span>
                                                <input type='text' name="usernames" id="usernames_<?php echo $records_obj['id']; ?>" value='<?php echo $records_obj['username'] ?>' data-original-value="<?php echo $records_obj['username'] ?>"  class='input_models<?php echo $records_obj['id'] ?>'  style="display:none; width:100px;" />
                                            </td>    


                                            <td>
                                                <span class='span_model<?php echo $records_obj['id'] ?>' class='text'><?php echo $records_obj['role'] ?></span>                    
                                                <select class="form-control select2me<?php echo $records_obj['id'] ?>" name = 'roles' id ="roles_<?php echo $records_obj['id']; ?>" data-id='<?php echo $records_obj['id']; ?>' data-original-value="<?php echo $records_obj['role'] ?>"  style="display:none">
                                                    <?php if ($is_super_admin == 1) { ?>	   <option <?php if ($records_obj['role'] == "Admin") echo 'selected="selected"'; ?> >Admin</option> <?php } ?>
                                                    <option <?php if ($records_obj['role'] == "Viewer") echo 'selected="selected"'; ?>>Viewer</option>
                                                    <option <?php if ($records_obj['role'] == "Editor") echo 'selected="selected"'; ?>>Editor</option>
                                                </select>
                                            </td>
                                            <td>
                                                <span class='span_model<?php echo $records_obj['id'] ?>' class='text'><?php echo $records_obj['email'] ?></span>                            
                                                <input type="email" onChange="showgridEmail(this.value, this.id)" name="emails" id="emails_<?php echo $records_obj['id']; ?>" value='<?php echo $records_obj['email'] ?>' data-original-value="<?php echo $records_obj['email'] ?>"  class='input_model<?php echo $records_obj['id'] ?>'  style="display:none; width:100px;" /><div class = "errormsg3<?php echo $records_obj['id'] ?>" style="color:red;font-size:16px"></div>
                                            </td>
                                            <td>
                                                <span class='span_model<?php echo $records_obj['id'] ?>' class='text'><?php echo $records_obj['contact'] ?></span>                            
                                                <input type='text' name="contacts" id="contacts_<?php echo $records_obj['id'] ?>" value='<?php echo $records_obj['contact'] ?>' data-original-value="<?php echo $records_obj['contact'] ?>"  class='input_model<?php echo $records_obj['id'] ?>' style="display:none; width:100px;" />
                                            </td>
                                            <td>
                                                <span class='span_model<?php echo $records_obj['id'] ?>' class='text' ><?php echo $records_obj['status'] ?></span>
                                                <?php if ((check_logs($records_obj['username'])) > 0) {
                                                    ?>

                                                    <span class='select2me<?php echo $records_obj['id'] ?>' name="statuss" id ="statuss_<?php echo $records_obj['id']; ?>" data-original-value="<?php echo $records_obj['status'] ?>" class='text' style="display:none; width:100px;"><?php echo $records_obj['status'] ?></span>

                                                    <div class = "select2me<?php echo $records_obj['id'] ?>" style="display:none;color:red;font-size:12px">* Selected admin has SAS application generated. Status cannot be inactive</div>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <select class="form-control select2me<?php echo $records_obj['id'] ?>" name = 'statuss' id ="statuss_<?php echo $records_obj['id']; ?>" data-id='<?php echo $records_obj['id']; ?>' data-original-value="<?php echo $records_obj['status'] ?>"  style="display:none">
                                                        <option <?php if ($records_obj['status'] == "Active") echo 'selected="selected"'; ?> >Active</option>
                                                        <option <?php if ($records_obj['status'] == "Inactive") echo 'selected="selected"'; ?>>Inactive</option>
                                                    </select>
                                                <?php } ?>

                                            </td>
                                        <input type="hidden" id="userid" name="userid" value="<?php echo $records_obj['id']; ?>"/>
                                        <td>
                                            <input type="button" name="user_edit" class="fa-fa btn btn-warning tooltips user_edit"  data-placement="left" data-id="<?php echo $records_obj['id'] ?>" title="Edit" value="&#xf044;"/>
                                            <input type="button" name="frm_submit" class="fa-fa btn btn-info tooltips frm_submit" data-placement="left" data-id="<?php echo $records_obj['id'] ?>" value="&#xf046;" title="Update" style="display:none">                                           

                                            <input type="hidden" id="userid_<?php echo $records_obj['id'] ?>" name="userid" data-id="<?php echo $records_obj['id'] ?>" value="<?php echo $records_obj['id']; ?>"/>
                                            <!--<button type="button" name="user_delete" id="user_delete" class="fa-fa btn btn-danger tooltips user_delete" data-toggle="modal" data-target="#confirm-delete" data-placement="right" title="Delete" data-id='<?php echo $records_obj['id']; ?>' value="&#xf014;"></button>-->
                                            <button type="button" class="fa-fa btn btn-danger tooltips userdelete"   data-id='<?php echo $records_obj['id']; ?>' ><i class="fa fa-trash" aria-hidden="true"></i></i>
                                            </button>

                                            <a href="#" class="btn btn-warning tooltips undo" data-placement="right" data-id="<?php echo $records_obj['id'] ?>" title="Undo" style="display:none"><i class="fa fa-undo"></i></a>
                                        </td>
                                        </tr>
                                    </form>
                                <?php } ?>    

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
</div>

<div class="modal fade" id="cannotdelete" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">MCC ALERT</h4>
            </div>
            <div class="modal-body">
                <h4 style="color:red">Cannot be deleted as it is being used</h4>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="updated" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">MCC ALERT</h4>
            </div>
            <div class="modal-body">
                <h4 style="color:red">Record Updated Successfully</h4>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="deleted" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">MCC ALERT</h4>
            </div>
            <div class="modal-body">
                <h4 style="color:red">Record deleted</h4>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="created" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">MCC ALERT</h4>
            </div>
            <div class="modal-body">
                <h4 style="color:red">Record created</h4>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">		
        <div class="modal-content">
            <input type="hidden" name="bookId" id="id" value=""/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>            
            <div class="modal-body">
                <p>Are you sure you want to delete this user</p>
                <p>Do you want to proceed?</p>
                <p class="debug-url"></p>
            </div>             
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button  type="button" id="confirm-button"  class="btn btn-danger btn-ok">Delete</a>
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
    var usercheckstatus = 0;
    var passwordmatchstatus = 0;
    var emailcheckstatus = 0;
    var emailgridstatus = 0;
    $(document).ready(function () {
        $('.close').click(function () {
            location.reload();
        });
        $(".user_edit").click(function (e) {
            var $tr = $(this).closest("tr");
            $tr.find('.user_edit').hide();
            $tr.find('.frm_submit').show();
            $tr.find('.userdelete').hide();
            $tr.find('.undo').show();
            e.preventDefault();
            var id = $(this).data('id');
            $(".select2me" + id).show();
            $(".span_model" + id).hide();
            $(".input_model" + id).show();
        });

        $('.undo').click(function (e) {
            var $tr = $(this).closest("tr");
            $tr.find('.frm_submit').hide();
            $tr.find('.user_edit').show();
            $tr.find('.undo').hide();
            $tr.find('.userdelete').show();
            e.preventDefault();
            var id = $(this).data('id');
            $(".select2me" + id).hide();
            $(".input_model" + id).hide();
            $(".span_model" + id).show();
        });

        $('.frm_submit').click(function (e) {
		 
            e.preventDefault();
            var $tr = $(this).closest("tr");
            var id = $(this).data("id")
            var username = $('#usernames_' + id + '').val();
            var role = $('#roles_' + id + '').val();
            var email = $('#emails_' + id + '').val();
            var contact = $('#contacts_' + id + '').val();
            var status = $('#statuss_' + id + '').val();
            if ((status == 'undefined') || (status == ''))
            {
                var status = $('#statuss_' + id + '').text();
            }
            if (email != '') {
                if (emailgridstatus == 0) {
                    $('#emails_' + id + '').removeClass('errorClass');
                } else {
                    alert('Email Address already exists');
                    $('#emails_' + id + '').focus();
                    $('#emails_' + id + '').addClass('errorClass');
                    return false;
                }
                if (validateEmail(email)) {
                    $('#emails_' + id + '').removeClass('errorClass');
                } else {
                    alert('Invalid Email Address');
                    $('#emails_' + id + '').focus();
                    $('#emails_' + id + '').addClass('errorClass');
                    return false;
                }
            }
            if (contact != '') {
                if (phonenumber(contact))
                {
                    $('#contacts_' + id + '').removeClass('errorClass');
                } else {
                    alert('Invalid Contact');
                    $('#contacts_' + id + '').focus();
                    $('#contacts_' + id + '').addClass('errorClass');
                    return false;
                }
            }
 $('.wait').show();
            var dataString = 'username=' + username + '&role=' + role + '&email=' + email +
                    '&contact=' + contact + '&status=' + status + '&id=' + id;
            $.ajax({
                type: "POST",
                url: "usermanage/edit_user",
                data: dataString,
                cache: false,
                success: function (data) {
				  $('.wait').hide();
                    $('#updated').modal('show')
                    window.setTimeout(function () {
                        $('#updated').modal('hide')
                    }, 1000);
                    setTimeout(function () {
                        window.location = 'usermanage';
                    }, 2000);
                }
            });
            return false;
        });

        var IdDelete = 0;
        $('.userdelete').on('click', function (e) {
            var attr = $(this).attr('data-id');
            IdDelete = attr;
            e.preventDefault();
            $('#confirm-delete').modal("show")
        });

        $('#confirm-button').on('click', function () {
            if (IdDelete > 0) {
                $.ajax({
                    type: "POST",
                    url: "usermanage/delete_user",
                    data: {"id": IdDelete},
                    dataType: "text",
                    success: function (data) {
                        if (data == 0)
                        {
                            $('#confirm-delete').modal('hide');
                            $('#cannotdelete').modal('show');
                        } else
                        {
                            $('#confirm-delete').modal('hide');
                            $('#deleted').modal('show');
                            window.setTimeout(function () {
                                $('#deleted').modal('hide')
                            }, 1000);
                            setTimeout(function () {
                                window.location = 'usermanage'; //will redirect to your blog page (an ex: blog.html)
                            }, 2000);
                        }
                    }
                });
            }
            $('#confirm-delete').modal("Hide")
            IdDelete = 0;
        });

        $("#usermange").submit(function (e) {
            e.preventDefault();
            var username = $('#username').val();
            if (usercheckstatus == 1 || passwordmatchstatus == 1 || emailcheckstatus == 1) {
                if (usercheckstatus == 1) {
                    $("#errormsg").html('Username already exists');
                } else if (passwordmatchstatus == 1) {
                    $("#errormsg1").html('Password does not match');
                } else if (emailcheckstatus == 1) {
                    $("#errormsg2").html('Email already exists');
                }

            } else {

                var password = $("#password").val();
                var confirm_password = $("#confirm_password").val();
                var password = $('#password').val();
                var role = $('#role').val();
                var email = $('#email').val();
                if (username != '') {
                    if (validateUser(username)) {
                        $("#errormsg").html('');
                    } else {
                        $("#errormsg").html('Invalid User name');
                        return false;
                    }
                }
                if (email != '') {
                    if (validateEmail(email)) {
                        $("#errormsg2").html('');
                    } else {
                        $("#errormsg2").html('Invalid Email Address');
                        return false;
                    }
                }
                var contact = $('#contact').val();
                if (contact != '') {
                    if (phonenumber(contact))
                    {
                        $("#errormsg4").html('');
                    } else {
                        $("#errormsg4").html('Invalid Contact');
                        return false;
                    }
                }
                var status = $("[name='status']").is(':checked');
				  $('.wait').show();
                var dataString = 'username=' + username + '&password=' + password + '&role=' + role + '&email=' + email +
                        '&contact=' + contact + '&status=' + status;

                $.ajax({
                    type: "POST",
                    url: "usermanage/create",
                    data: dataString,
                    success: function (data) {
					  $('.wait').hide();
                        $('#created').modal('show');
                        window.setTimeout(function () {
                            $('#created').modal('hide')
                        }, 1000);
                        setTimeout(function () {
                            window.location = 'usermanage';
                        }, 2000);
                    }
                })



            }
        });

        function validateUser(sEmail) {
            var filter = /^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }

        function validateEmail(sEmail) {
            var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }

        function validateEmail(sEmail) {
            var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }

        function phonenumber(inputtxt)
        {
            var phoneno = /^(7|8|9)\d{9}$/;
            if (phoneno.test(inputtxt))
            {
                return true;
            } else
            {
                return false;
            }
        }
    });
    function showUser(val) {
        $.ajax({
            type: "POST",
            url: "usermanage/checkuser",
            data: {'val': val},
            cache: false,
            success: function (result) {
                if (result == 1)
                {
                    $("#errormsg").html('Username already exists');
                    usercheckstatus = 1;
                    return false;
                } else
                {
                    $("#errormsg").html('');
                    usercheckstatus = 0;
                    return true;
                }
            }
        });
    }

    function showEmail(email) {
        $.ajax({
            type: "POST",
            url: "usermanage/check_email",
            data: {'email': email},
            cache: false,
            success: function (result) {
                if (result == 1)
                {
                    $("#errormsg2").html('Email already exists');
                    emailcheckstatus = 1;
                    return false;
                } else
                {
                    $("#errormsg2").html('');
                    emailcheckstatus = 0;
                    return true;
                }
            }
        });
    }

    function showPassword() {
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();
        if (password != '' && confirm_password != '') {
            if (password != confirm_password) {
                $("#errormsg1").html('Password does not match');
                passwordmatchstatus = 1;
                return false;
            } else {
                $("#errormsg1").html('');
                passwordmatchstatus = 0;
                return true;
            }
        }
    }

    function showgridEmail(email, id) {
        $.ajax({
            type: "POST",
            url: "usermanage/checkemail",
            data: {'email': email, 'id': id},
            cache: false,
            success: function (result) {
                if (result == 1)
                {
                    emailgridstatus = 1;
                    return false;
                } else
                {
                    emailgridstatus = 0;
                    return true;
                }
            }
        });
    }
</script>
<?php
include('common/footer.php');
?>