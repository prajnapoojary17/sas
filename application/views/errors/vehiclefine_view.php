<?php
# -----------------------------------------------------------------------------------------
# Created by: Glowtouch
# File description: settraffic View
# -----------------------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Vehicle Fine</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="../assets/css/bootstrap.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
          <script src="../assets/js/respond.min.js"></script>
        <![endif]-->

    </head> 

    <body>
        <div class="container">
            <h2 class="sub-header">Vehicle Fine</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Vehicle Number</th>
                            <th>No Of fines</th>
                            <th>Amount Due</th>
                            <th>&nbsp;</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($records as $records_obj) {
                            echo 'test';
                            ?>
                        <form id="form_vehiclefine" name="form_vehiclefine" action="<?php echo base_url(); ?>vehiclefine/" method="post">
                            <tr>                       
                                <td>
                                    <input class="form-control input_bg" style="background:none;padding-left:10px" type="text" id="v_number" name="v_number" value="<?php echo $records_obj->v_number; ?>"/>
                                </td>
                                <td>
                                    <input class="form-control input_bg" style="background:none;padding-left:10px" type="text" id="n_fine" name="n_fine" value="<?php echo $records_obj->n_fine; ?>"/>
                                </td>
                                <td>
                                    <input class="form-control input_bg" style="background:none;padding-left:10px" type="text" id="amount_due" name="amount_due" value="<?php echo $records_obj->amount_due; ?>"/>
                                </td>
                                <td>
                                    <input type="submit" id="frm_submit" name="frm_submit" class="btn  btn-sm btn-primary" value="Update">
                                </td>
                            </tr>
                        </form>

                    <?php } ?>
                    </tbody>

                </table>




            </div>	

        </div><!-- /container -->	

    </body>

</html>