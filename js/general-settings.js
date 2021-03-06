/**
 * @author Nuarharuha <nhnoah+bay-isra@gmail.com>
 * @version 0.1
 */

var stg = {};

jQuery(document).ready(function($){

    stg.msg = function(data, elm){
        if (data.success){
            $(elm).html('<i class="icon-ok-sign"></i> Update Success')
                .fadeIn(2500)
                .fadeOut(3000);
        } else {
            $(elm).html('<i class="icon-warning-sign"></i> Update Failed')
                .fadeIn(2500)
                .fadeOut(3000);
        }
    };

    $('button.save-bonus-register').click(function(e){
        e.preventDefault();

        params ={
            action: 'stockist_bonus_register',
            type: $('#register_bonus_type').val(),
            state:  $('#state_register_bonus').val(),
            district: $('#district_register_bonus').val(),
            mobile: $('#mobile_register_bonus').val()
        };

        $.post(ajaxurl, params, function(data){  stg.msg(data,'#msg-register small');
        },'JSON');

    });

    $('button.save-bonus-sales').click(function(e){
        e.preventDefault();

        params ={
            action: 'stockist_bonus_sales',
            type: $('#sales_bonus_type').val(),
            state:  $('#state_sales_bonus').val(),
            district: $('#district_sales_bonus').val(),
            mobile: $('#mobile_sales_bonus').val()
        };

        $.post(ajaxurl, params, function(data){  stg.msg(data,'#msg-sales small');
        },'JSON');
    });

    params ={
      action: 'wp_ajax_stockist_bonus_register',
      type: $('#register_bonus_type').val(),
      state:  $('#state_register_bonus').val(),
      district: $('#district_register_bonus').val(),
      mobile: $('#mobile_register_bonus').val()
    };

    $('button.save-starter-kit').click(function(e){
        e.preventDefault();

        $.post(ajaxurl, {action: 'stockist_starter_kit',pid: $('#starter_kit').val()},
            function(data){
                stg.msg(data,'#msg-starter-kit small');
        },'JSON');
    });


});