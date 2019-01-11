$(document).ready(function() {
    "use strict";

    /*------------- preloader js --------------*/
    $(window).on('load', function() {
        setTimeout(function() {
            $('.loader-wraper').fadeOut();
        }, 3000);
    });


    /*------------ Start site menu  ------------*/

    // Start sticky header
    $(window).on('scroll', function() {
        if ($(window).scrollTop() >= 150) {
            $('#sticky-header').addClass('sticky-menu');
        } else {
            $('#sticky-header').removeClass('sticky-menu');
        }
    });

    $('#category-table').DataTable({
        'responsive': true,
        'details':true
    });
    $('#qz-question-table').DataTable();

    $('.sidebarToggler').on('click', function(){
        $('.qz-sidebar').toggleClass('sidebarToggle')
    })

    $('.qz-sidebar').scrollbar();

});