/*--
Author Rinu Madathil
The main core script which handles entire theme and core functions
Dont change the order of the functions
--*/
var Layout = function() {

    // Handles Date and Time
    var handleDateTime = function() {

        var interval = setInterval(function() {
            var momentNow = moment();
            $('#datetime').html(momentNow.format('dddd').substring(0, 3).toUpperCase() + ', ' + momentNow.format('DD MMMM YYYY '));
            $('#datetime2').html(momentNow.format('hh:mm:ss A'));
        }, 100);


    }

    // Handle Theme Settings
    var handleTheme = function() {

        var panel = $('.theme-panel');

        // handle theme colors
        var setColor = function(color) {
            var color_ = (color);
            $('#style_color').attr("href", 'css/themes/' + color_ + ".css");
            if ($.cookie) {
                $.cookie('style_color', color);
            }
            $.cookie('style_color', [cookie], {
                expires: 30
            });
        }

        $('.theme-colors > ul > li', panel).click(function() {
            var color = $(this).attr("data-style");
            setColor(color);
            $('ul > li', panel).removeClass("current");
            $(this).addClass("current");
        });

        if ($.cookie && $.cookie('style_color')) {
            setColor($.cookie('style_color'));
        }
    }

    return {

        //main function to initiate the theme
        //Dont change the order of the functions
        init: function() {
            //Core handlers
            handleDateTime(); // handles Date n Time
            handleTheme(); // handles Theme
        }

    }

}();