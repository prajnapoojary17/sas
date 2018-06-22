<?php include ('common/header_login.php'); ?>

<body class="login" onload="startTime()">

    <div class="welcome-text"><img alt="MCC" src="<?php echo base_url(); ?>assets/img/welcome.png"></div>

    <div class="lock-wrapper">


        <div id="time"></div>


        <div class="lock-box text-center">
            <?php echo validation_errors(); ?>
            <?php echo form_open('verifylogin', array('class' => 'form-inline')); ?>       
            <div class="clearfix">
                <div class="lock-usr">
                    <div class="form-group">
                        <input type="text" class="form-control lock-input" id="exampleInputUsername" placeholder="Username" name="username">
                    </div>
                </div>
                <img alt="lock avatar" src="<?php echo base_url(); ?>assets/img/avatar.png">
                <div class="lock-pwd">
                    <div class="form-group">
                        <input type="password" class="form-control lock-input" id="exampleInputPassword2" placeholder="Password" name = "password">
                        <button type="submit" class="btn btn-lock">
                            <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>	

            </form>

        </div>
    </div>
    <?php include ('common/footer_login.php'); ?>