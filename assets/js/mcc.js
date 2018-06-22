/*--
Author Rinu Madathil
The main core script which handles entire theme and core functions
Dont change the order of the functions
--*/
var MccRinu = function() {

    var assetsPath = '/';

    // Handles Bootstrap Tooltips.
    var handleTooltips = function() {
        $('.tooltips').tooltip();
    }

    // initializes main settings
    var handleInit = function() {

        isIE8 = !!navigator.userAgent.match(/MSIE 8.0/);
        isIE9 = !!navigator.userAgent.match(/MSIE 9.0/);
        isIE10 = !!navigator.userAgent.match(/MSIE 10.0/);

        if (isIE10) {
            $('html').addClass('ie10'); // detect IE10 version
        }

        if (isIE10 || isIE9 || isIE8) {
            $('html').addClass('ie'); // detect IE10 version
        }
    }

    // Set proper height for content
    var handleContentHeight = function() {
        var winHeight = $(window).height();
        var footerHeight = $('.page-footer').outerHeight();
        var headerHeight = $('.page-header').outerHeight();
        if ($(".page-content").length > 0) {
            $(".page-content").css({
                minHeight: winHeight - headerHeight - footerHeight
            });
        }
    }

    // Handle sidebar menu
    var handleSidebarMenu = function() {
        $('#cssmenu > ul > li > a').click(function() {
            //$('#cssmenu li').removeClass('active');
            //$(this).closest('li').addClass('active');	
			
			if($('.sub-menu').is(':visible')) {
				jQuery(this).parent("li").find(".arrow").removeClass("open");
			}
			else {
                jQuery(this).parent("li").find(".arrow").addClass("open");
			}
			
			
            $(this).closest('.arrow').addClass('o');
            var checkElement = $(this).next();
            if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                $(this).closest('li').removeClass('active');
                checkElement.slideUp('normal');
            }
            if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                $('#cssmenu ul ul:visible').slideUp('normal');
                checkElement.slideDown('normal');
            }
            if ($(this).closest('li').find('ul').children().length == 0) {
                return true;
            } else {
                return false;
            }
			
			
			
        });
    }

    // Hanles sidebar toggler
    var handleSidebarToggler = function() {
        var body = $('body');
        if ($.cookie && $.cookie('sidebar_closed') === '1' && MccRinu.getViewPort().width >= 992) {
            $('body').addClass('page-sidebar-closed');
            $('.page-sidebar-menu').addClass('page-sidebar-menu-closed');
        }

        // handle sidebar show/hide
        $('.page-sidebar, .page-header').on('click', '.sidebar-toggler', function(e) {
            var sidebar = $('.page-sidebar');
            var sidebarMenu = $('.page-sidebar-menu');
            $(".sidebar-search", sidebar).removeClass("open");

            if (body.hasClass("page-sidebar-closed")) {
                body.removeClass("page-sidebar-closed");
                sidebarMenu.removeClass("page-sidebar-menu-closed");
                if ($.cookie) {
                    $.cookie('sidebar_closed', '0');
                }
            } else {
                body.addClass("page-sidebar-closed");
                sidebarMenu.addClass("page-sidebar-menu-closed");
                if (body.hasClass("page-sidebar-fixed")) {
                    sidebarMenu.trigger("mouseleave");
                }
                if ($.cookie) {
                    $.cookie('sidebar_closed', '1');
                }
            }

            $(window).trigger('resize');
        });

        //_initFixedSidebarHoverEffect();

    }

    // Handles the go to top button at the footer
    var handleGoTop = function() {
        /* set variables locally for increased performance */
        jQuery('.page-footer').on('click', '.go-top', function(e) {
            MccRinu.scrollTo();
            e.preventDefault();
        });
    }

    // Handles portlet tools & actions
    var handlePortletTools = function() {
        $('body').on('click', '.portlet > .portlet-title > .tools > a.remove', function(e) {
            e.preventDefault();
            $(this).closest(".portlet").remove();
        });      

        $('body').on('click', '.portlet > .portlet-title > .tools > .collapse, .portlet .portlet-title > .tools > .expand', function(e) {
            e.preventDefault();
            var el = $(this).closest(".portlet").children(".portlet-body");
            if ($(this).hasClass("collapse")) {
                $(this).removeClass("collapse").addClass("expand");
                el.slideUp(200);
            } else {
                $(this).removeClass("expand").addClass("collapse");
                el.slideDown(200);
            }
        });
    }

    // Handles custom checkboxes & radios using jQuery Uniform plugin
    var handleUniform = function() {
        if (!$().uniform) {
            return;
        }
        var test = $("input[type=checkbox]:not(.toggle, .make-switch), input[type=radio]:not(.toggle, .star, .make-switch)");
        if (test.size() > 0) {
            test.each(function() {
                if ($(this).parents(".checker").size() == 0) {
                    $(this).show();
                    $(this).uniform();
                }
            });
        }
    }

    // Handle Select2 Dropdowns
    var handleSelect2 = function() {
        if ($().select2) {
            $('.select2me').select2({
                placeholder: "Select",
              //  allowClear: true
            });
        }
    }
	
    // Handle Datatable
    var handleDatatable = function() {
		$('.datatable').DataTable( {
			"aaSorting": []
		  } );

    }
	
    // Handle Switch
    var handleSwitch = function() {
		$('.switch[type="checkbox"]').bootstrapSwitch();

    }
	
    // Handle Max Length
    var handleMaxLength = function() {
		$('textarea#max300').maxlength({
			alwaysShow: true
		});
    }
	
    // Handle Wizard
    var handleWizard = function() {
		$('.rootwizard .container ul').addClass('bwizard-steps');
	  	$('.rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
			var $total = navigation.find('li').length;
			var $current = index+1;
			var $percent = ($current/$total) * 100;
			$('.rootwizard .progress-bar').css({width:$percent+'%'});
		}});
		/* $('.rootwizard .finish').click(function() {
			$('.rootwizard').find("a[href*='tab1']").trigger('click');
		}); */
		$('.rootwizard .container ul').removeClass('nav-pills nav');
		window.prettyPrint && prettyPrint()

    }

    // Handles quick sidebar toggler
    var handleQuickSidebarToggler = function() {
        // quick sidebar toggler
        $('.sidebar-toggler').click(function(e) {
            $('body').toggleClass('page-quick-sidebar-open');
        });
    }

    // Handles Full Screen
    var handleFullScreen = function() {
        $('.go-full-screen').click(function(e) {
            if ((document.fullScreenElement && document.fullScreenElement !== null) ||
                (!document.mozFullScreen && !document.webkitIsFullScreen)) {
                if (document.documentElement.requestFullScreen) {
                    document.documentElement.requestFullScreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullScreen) {
                    document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
    }


    // Handle Date 
    var handleDatePicker = function() {
        $('.form_date').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0
        });
        $('.form_year').datetimepicker({
            autoclose: 1,
            startView: 4,
            endView: 4,
            minView: 4,
            forceParse: 0
        });
        $('#maxToday').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
			endDate: '+0d'
        });
		 $('#minToday').datetimepicker({
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            minView: 2,
            forceParse: 0,
			endDate: '+0d'
        });
        $('.only_year').datetimepicker({
            autoclose: 1,
            startView: 4,
            endView: 3,
            minView: 2,
            forceParse: 0
        });
		
		 $('.input-daterange').datetimepicker({ minViewMode: 2, format: 'yyyy' });
    }

    // Handle Slim Scroll
    var handleSlimScroll = function() {
        $('.scroller').slimScroll({
            alwaysVisible: true,
            railVisible: true,
            color: '#aaa',
            railColor: '#aaa',
			height: '355px'
        });
    }




    return {

        //main function to initiate the theme
        //Dont change the order of the functions
        init: function() {
            //Core handlers
            handleTooltips(); // initialize core variables
            handleInit(); // initialize core variables
            handleContentHeight(); // Set proper height for content
            handleSidebarMenu(); // Handle sidebar menu
            handleSidebarToggler(); // Hanles sidebar toggler
            handleGoTop(); // Hanles Go Top
            handlePortletTools(); // Hanles Portlet Tools
            handleUniform(); // Hanles checkboxes & radios 
            handleSelect2(); // handles select2
            handleDatatable(); // handles Datatable
            handleSwitch(); // handles Switch
            handleMaxLength(); // handles Max Length
            handleWizard(); // handles Wizard
            handleQuickSidebarToggler(); // handles Sidebar
            handleFullScreen(); // handles Full Screen
            handleDatePicker(); // handles Date 
            handleSlimScroll(); // handles Max Length  
        },

        // MccRinu function to scroll(focus) to an element
        scrollTo: function(el, offeset) {
            var pos = (el && el.size() > 0) ? el.offset().top : 0;

            if (el) {
                if ($('body').hasClass('page-header-fixed')) {
                    pos = pos - $('.page-header').height();
                }
                pos = pos + (offeset ? offeset : -1 * el.height());
            }

            $('html,body').animate({
                scrollTop: pos
            }, 'slow');
        },

        scrollTop: function() {
            MccRinu.scrollTo();
        },

        // initializes uniform elements
        initUniform: function(els) {
            if (els) {
                $(els).each(function() {
                    if ($(this).parents(".checker").size() == 0) {
                        $(this).show();
                        $(this).uniform();
                    }
                });
            } else {
                handleUniform();
            }
        },

        //MccRinu function to update/sync jquery uniform checkbox & radios
        updateUniform: function(els) {
            $.uniform.update(els); // update the uniform checkbox & radios UI after the actual input control state changed
        },

        // To get the correct viewport width based on  http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
        getViewPort: function() {
            var e = window,
                a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return {
                width: e[a + 'Width'],
                height: e[a + 'Height']
            }
        },

        // check IE8 mode
        isIE8: function() {
            return isIE8;
        },

        // check IE9 mode
        isIE9: function() {
            return isIE9;
        },

        getAssetsPath: function() {
            return assetsPath;
        }

    }

}();