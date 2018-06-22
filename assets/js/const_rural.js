$(document).on('click', '#city_edit', function ()
{
    //$("#road_name").prop("readonly", true);
    $("#c_type").focus();
    $("#c_type").val($(this).data('ctype'));
    $("#g_floor").val($(this).data('groundfloor'));
    $("#u_floor").val($(this).data('upperfloor'));
    $("#rural_id").val($(this).data('id'));        
});