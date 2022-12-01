(function ($) {
    "use strict";
    if ($(window).width() > 767) {
        if ($('.theiaStickySidebar').length > 0) {
            $('.theiaStickySidebar').theiaStickySidebar({additionalMarginTop: 30});
        }
    }
    if ($(window).width() <= 991) {
        var Sidemenu = function () {
            this.$menuItem = $('.main-nav a');
        };

        function init() {
            var $this = Sidemenu;
            $('.main-nav a').on('click', function (e) {
                if ($(this).parent().hasClass('has-submenu')) {
                    e.preventDefault();
                }
                if (!$(this).hasClass('submenu')) {
                    $('ul', $(this).parents('ul:first')).slideUp(350);
                    $('a', $(this).parents('ul:first')).removeClass('submenu');
                    $(this).next('ul').slideDown(350);
                    $(this).addClass('submenu');
                } else if ($(this).hasClass('submenu')) {
                    $(this).removeClass('submenu');
                    $(this).next('ul').slideUp(350);
                }
            });
        }

        init();
    }
    $(window).on('load', function () {
        $('#loader').delay(100).fadeOut('slow');
        $('#loader-wrapper').delay(500).fadeOut('slow');
        $('body').delay(500).css({'overflow': 'visible'});
    });
    $('body').append('<div id="sidebar-overlay" class="sidebar-overlay"></div>');
    $(document).on('click', '#mobile-btn', function () {
        $('main-wrapper').toggleClass('slide-nav');
        $('.sidebar-overlay').toggleClass('opened');
        $('html').addClass('menu-opened');
        return false;
    });
    $(document).on('click', '#menu-close', function () {
        $('html').removeClass('menu-opened');
        $('.sidebar-overlay').removeClass('opened');
        $('main-wrapper').removeClass('slide-nav');
    });
    $(document).on('click', '.sidebar-overlay', function () {
        $('html').removeClass('menu-opened');
        $(this).removeClass('opened');
        $('main-wrapper').removeClass('slide-nav');
    });
})(jQuery);
$(document).ready(function () {
    $(".package-close").click(function () {
        $("#package-block").slideUp(100);
    });
});
if ($('.aos').length > 0) {
    AOS.init({
        duration: 1200, once: true, disable: function () {
            var maxWidth = 991;
            return window.innerWidth < maxWidth;
        }
    });
}
var edit_save = document.getElementById(".main-img");
const mediaQuery = window.matchMedia('(max-width: 991.98px)');
const mediaQuery_1 = window.matchMedia('(max-width: 1390px)');
if (mediaQuery_1.matches) {
    $(".main-img").attr("src", "./assets/img/responsive-center-img.png");
}
if (mediaQuery.matches) {
    $(".main-img").attr("src", "./assets/img/res.png");
}
$(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 500) {
        $(".scroll-top").addClass("active");
    } else {
        $(".scroll-top").removeClass("active");
    }
});
$(window).scroll(function () {
    var sticky = $('.site-header'), scroll = $(window).scrollTop();
    if (scroll >= 200) sticky.addClass('fixed'); else sticky.removeClass('fixed');
});
