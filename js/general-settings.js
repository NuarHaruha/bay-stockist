/**
 * @author Nuarharuha
 * @version 0.1
 */

var stg = {};

jQuery(document).ready(function($){

    $('button.save-bonus-register').click(function(e){
        e.preventDefault();

        params ={
            action: 'stockist_bonus_register',
            type: $('#register_bonus_type').val(),
            state:  $('#state_register_bonus').val(),
            district: $('#district_register_bonus').val(),
            mobile: $('#mobile_register_bonus').val()
        };

        $.post(ajaxurl, params, function(data){
            if (data.success){
                $('#msg-register small').html('<i class="icon-ok-sign"></i> Update Success').
                fadeOut(3000);
            } else {
                $('#msg-register small').html('<i class="icon-warning-sign"></i> Update Failed').
                fadeOut(3000);
            }

        },'JSON');

    });

    $('button.save-bonus-sales').click(function(e){
        e.preventDefault();
    });

    params ={
      action: 'wp_ajax_stockist_bonus_register',
      type: $('#register_bonus_type').val(),
      state:  $('#state_register_bonus').val(),
      district: $('#district_register_bonus').val(),
      mobile: $('#mobile_register_bonus').val()
    };


});