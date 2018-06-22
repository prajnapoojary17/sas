<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">
        &copy; Copyright Mangalore City Corporation. All Rights Reserved.
    </div>
    <div class="page-footer-tools">
        <span class="go-top">
            <i class="fa fa-angle-up"></i>
        </span>
    </div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>/assets/js/respond.min.js"></script>
    <script src="/assets/js/excanvas.min.js"></script>
    <![endif]-->
<script src="<?php echo base_url(); ?>/assets/js/jquery-1.11.0.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery-cookie/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/select2/select2.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatable/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-datetimepicker/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-switch/highlight.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-switch/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-switch/main.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-maxlength/bootstrap-maxlength.js" type="text/javascript"></script> 

<script src="<?php echo base_url(); ?>/assets/plugins/jquery-fullscreen/jquery.fullscreen-min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>/assets/js/mcc.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>/assets/js/layout.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function () {
        MccRinu.init();
        Layout.init();
    });
</script>
<script>


    $(document).on('click', '#guidance_edit', function ()
    {
        $("#road_name").prop("readonly", true);
        $("#gval_cents").focus();
        $("#g_id").val($(this).data('g_id'));
        $("#road_name").val($(this).data('road_name'));
        $("#gvalcents_commercial").val($(this).data('gval_cents_commercial'));
        $("#gvalcents_residential").val($(this).data('gval_cents_residential'));
        $("#p_ward").val($(this).data('gval_wardid'));
        $("#gval_wardroadid").val($(this).data('gval_wardroadid'))
    });
    $(document).on('click', '#swm_edit', function ()
    {

        $("#p_type").val($(this).data('p_type')).change();
        $('#p_typeadd').attr("disabled", true);
        $("#amt").focus();
		$("#year").val($(this).data('year'));
        $("#swm_id").val($(this).data('swm_id'));
        $("#area_building").val($(this).data('area_building')).change();
        $("#amt").val($(this).data('amt'));
    });


</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>