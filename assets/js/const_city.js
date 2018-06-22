$(document).on('click', '#city_edit', function ()
{
    //$("#road_name").prop("readonly", true);
    $("#type_of_construction").focus();
    $("#type_of_construction").val($(this).data('ctype'));
    $("#ground_floor").val($(this).data('groundfloor'));
    $("#upper_floor").val($(this).data('upperfloor'));
    $("#city_id").val($(this).data('id'));        
});