/**
 * Simple form validation
 * dependencies jQuery 1.6+
 *
 * @package isralife
 * @category form
 *
 * @author Nuarharuha
 * @version 0.1
 */
var stvalid = {}, releaseSubmit = false;
jQuery(document).ready(function($){

    stvalid.form = $('#stockist_add');
    stvalid.input = {
        login: $('#user_login'), pwd: $('#user_pass'), pwd2: $('#user_pass2'), fname: $('#nama_penuh'),
        tel: $('#tel'), nric: $('#nric'),
        stype: $("input[name='stockist_type']"),
        sldistrict:$('#daerah'),slstate:$('#negeri'),slcountry:$('#negara'),
        district:$('#district'),state:$('#state'),country:$('#country'),
        location: $('select.select-location')
    };

    /**
     * validation rules
     */
    stvalid.check = {
        /** validated username, check if username exists */
        login: function(){
            if (stvalid.input.login.val() == ''){
                releaseSubmit = false;
                $('#msg-login-empty').fadeIn('slow').fadeOut(2000);
            } else {
                releaseSubmit = true;

                params = {action:'username_exists', login: stvalid.input.login.val()};
                $.post(ajaxurl,params,function(username){
                    if (username.valid){
                        $('#msg-login-valid').fadeIn('slow').fadeOut(6000);
                        releaseSubmit = true;
                    } else {
                        $('#msg-login-invalid').fadeIn('fast').fadeOut(3000);
                        releaseSubmit = false;
                    }


                },'JSON');
            }
            return this;
        },
        password:function(){
          if (stvalid.input.pwd.val() != stvalid.input.pwd2.val()){
              releaseSubmit = false;
              $('#msg-pwd').fadeIn('fast').fadeOut(3000);
          } else {
              releaseSubmit = true;
          }

          if (stvalid.input.pwd.val() == '' || stvalid.input.pwd2.val() == ''){
              releaseSubmit = false;
              $('#msg-pwd-empty').fadeIn('fast').fadeOut(3000);
          } else {
              releaseSubmit = true;
          }

          return this;
        },
        name:function(){
            if (stvalid.input.fname.val() == ''){
                releaseSubmit = false;
                $('#msg-name-empty').fadeIn('fast').fadeOut(3000);
            } else {
                releaseSubmit = true;
            }

            return this;
        },
        all: function(){
            this.login().password().name();
        }
    };

    /** filters */
    stvalid.str = {
        toLowerTrim:function(str){
            return str.toLowerCase().replace(/ /g, '');
        }
    }

    /**
     * filter & formatting
     */

    stvalid.input.nric.mask("999999-99-9999");
    stvalid.input.tel.mask("(999) 999-9999? x99999");

    stvalid.input.login.keyup(function(){
        $(this).val( stvalid.str.toLowerTrim($(this).val()) );
        if ($(this).val().length <= 2){
            $('#msg-min-len').fadeIn('fast').fadeOut(2000);
            releaseSubmit = false;
        }
    }).focusout(function(){
            if ($(this).val().length >= 3){
                stvalid.check.login();
            }
        });

    stvalid.input.pwd2.focusout(function(){
        stvalid.check.password();
    });

    stvalid.input.fname.focusout(function(){
        stvalid.check.name();
    });

    stvalid.input.stype.click(function(){
        hiderow = $('#reserved_code');
        if (hiderow.hasClass('dn')){
            hiderow.slideDown('slow').removeClass('dn');
        }

        type_id = $(this).data('target');
        bid  = false

        if (type_id == ''){
            bid = 0;
        } else {
            bid = $(type_id).val();
        }

        var params = { action:'reserved_id', type: $(this).val(), id: bid };
        $.post(ajaxurl, params, function(data){
                $('#reserved_id').val(data.code);
            }
        ,'JSON');
    });

    /**
     * show send sms notification options
     * if tel has value with len >= 5
     * */
    stvalid.input.tel.focusout(function(){
        if ($(this).val().length >=5 ){
            if ($('#valid-tel').hasClass('dn')){
                $('#valid-tel').fadeIn('slow').removeClass('dn');
            }
        }
    });

    // select location, update input.targer value
    // with option:selected text
    stvalid.input.location.each(function(){
        update = $(this).data('target'),value  = $(this).find("option:selected").text();
        $(update).val(value); // set default value on load

        $(this).change(function(){
            // update hidden data-target value with selected text
            $($(this).data('target')).val($(this).find("option:selected").text());
        if (typeof console != "undefined" ){
            console.log('updated: %s => %s',
                $(this).data('target'),$($(this).data('target')).val());
        }
       });
    });

    stvalid.input.sldistrict.change(function(){
        state = $(this).find("option:selected").data('state');
        console.log('state id: %s', state);
        stvalid.input.slstate.val(state);

        // update state data
        cstate = stvalid.input.slstate.find("option:selected").text()
        stvalid.input.state.val(cstate);
    });

    stvalid.form.submit(function(e){
       if (releaseSubmit){
           return true;
       } else {
           e.preventDefault();
           stvalid.check.all();
           return false;
       }
    });
});