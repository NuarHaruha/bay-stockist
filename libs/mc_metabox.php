<?php
/**
 * stockist metabox
 *
 * @author Nuarharuha
 * @version 1.0
 * @since 0.1
 */

/**
 * section add-new
 */

/**
 *  stockist sponsor, form
 */
function mb_add_stockist_sponsor($post = false, $options = false){
    unset($post, $options); // placeholder
    ?>
<table class="widefat nobot">
    <tbody>
    <tr valign="top">
        <th scope="row" style="width:30%">
            <label for="nama_penaja">Name</label>
        </th>
        <td>
            <input id="nama_penaja" type="text" name="nama_penaja" value="" class="code" style="width: 94%">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">
            <label for="id_penaja">ID #</label>
        </th>
        <td>
            <input id="id_penaja" type="text" name="id_penaja" value="" class="code" style="width: 94%">
        </td>
    </tr>
    </tbody>
</table>
<script>
    jQuery(document).ready(function($){
    });
</script>
<?php
}

/**
 *  stockist type, form
 */
function mb_add_stockist_type($post = false, $options = false){
    unset($post, $options); // placeholder
?>
<input type="hidden" name="<?php echo SKTYPE::MK_USERTYPE_STOCKIST;?>" value="on">
<input type="hidden" name="status_option_active" value="on">
<table class="widefat nobot">
    <tbody>
    <tr valign="top">
        <th scope="row" colspan="2">
            <label for="stockist_mobile" title="Stokis Mobile">
                <input id="stockist_mobile" type="radio" name="stockist_type" value="<?php echo SKTYPE::ST_MOBILE;?>">  Mobile Stockist
            </label>
        </th>
    </tr>
    <tr valign="top">
        <th scope="row" colspan="2">
            <label for="stockist_district" title="Stokis Daerah">
                <input data-target="#daerah" id="stockist_district" type="radio" name="stockist_type" value="<?php echo SKTYPE::ST_DISTRICT;?>">  District Stockist
            </label>
        </th>
    </tr>
    <tr valign="top">
        <th scope="row" colspan="2">
            <label for="stockist_state" title="Stokis Daerah">
                <input data-target="#negeri" id="stockist_state" type="radio" name="stockist_type" value="<?php echo SKTYPE::ST_STATE;?>">  State Stockist
            </label>
        </th>
    </tr>
    <tr valign="top">
        <th scope="row" colspan="2">
            <label for="stockist_hq" title="Stokis HQ">
                <input data-target="#negara" id="stockist_hq" type="radio" name="stockist_type" value="<?php echo SKTYPE::ST_HQ;?>">  Regional Stockist <span class="muted">(HQ)</span>
            </label>
        </th>
    </tr>
    </tbody>
    <tfoot>
        <tr id="reserved_code" class="dn">
            <th colspan="2" align="center">
                <label for="reserved_id" style="padding-left: 10px">Reserved ID #</label>
                <input id="reserved_id" type="text" name="reserved_id" class="code disabled" value="" style="width: 150px;padding: 2px 2px;">
                <input type="hidden" name="account_id">
            </th>
        </tr>
    </tfoot>
</table>
<script>
    jQuery(document).ready(function($){

    });
</script>
<?php
}

/**
 * add new stockist, Bank details form
 */
function mb_add_stockist_bank_info($post= false, $options= false){
    unset($post); // placeholder

    list($country, $states, $districts) = $options['args'];
    ?>
<input type="hidden" name="section" value="add-stockist">
<table class="widefat nobot">
    <tbody>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="bank_account_name">Account Name</label>
        </th>
        <td style="width:30%">
            <input type="text" id="bank_account_name" name="bank_account_name" value="" class="regular-text code">
        </td>
        <th scope="row" style="width:20%">
            <label for="nama_bank">Bank Name</label>
        </th>
        <td style="width:30%">
            <input type="text" id="nama_bank" name="nama_bank" value="" class="regular-text code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="no_bank">Account No. #</label>
        </th>
        <td style="width:30%">
            <input type="text" id="no_bank" name="no_bank" value="" class="regular-text code">
        </td>
        <th scope="row" style="width:20%">
            <label for="cawangan_bank">Branch</label>
        </th>
        <td style="width:30%">
            <input type="text" id="cawangan_bank" name="cawangan_bank" value="" class="regular-text code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="jenis_akaun_bank">Account Type</label>
        </th>
        <td style="width:30%">
            <input type="text" id="jenis_akaun_bank" name="jenis_akaun_bank" value="" class="regular-text code">
        </td>
        <td colspan="2"></td>
    </tr>
    </tbody>
</table>
<?php
}

/**
 * submit actions form
 */
function mb_add_stockist_actions($post = false, $options = false){
    unset($post, $options); // placeholder
?>
<input type="hidden" name="section" value="add-stockist">
    <table class="widefat nobot">
        <tbody>
            <tr valign="top" id="valid-tel" class="dn">
                <th scope="row" colspan="2">
                    <label for="send_sms">
                        <input id="send_sms" type="checkbox" name="send_sms"> Send SMS Notification
                    </label>
                </th>
            </tr>
            <tr valign="top">
                <th scope="row" colspan="2">
                    <label for="send_email">
                        <input id="send_email" type="checkbox" name="send_email"> Send Email Notification
                    </label>
                </th>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">
                    <button class="button-secondary go-back">Cancel</button>
                    <button class="button-primary">Register Stockist</button>
                </th>
            </tr>
        </tfoot>
    </table>
<script>
    jQuery(document).ready(function($){
        $('.go-back').click(function(e){ e.preventDefault(); window.history.go(-1);});
    });
</script>
<?php
}

/**
 * add new stockist, login details form
 */
function mb_add_stockist_login_info($post = false, $options = false){
    unset($post, $options); // placeholder
?>
    <table class="widefat nobot">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width:20%">
                    <label for="user_login">Login Name</label>
                </th>
                <td style="width:30%">
                    <input type="text" id="user_login" name="user_login" value="" class="regular-text code width-85">
                    <small id="msg-login-empty" class="description dn invalid"><br><i class="icon-warning-sign"></i> Required, Login Name is empty.</small>
                </td>
                <th scope="row" style="width:20%">
                    <label for="user_pass">Password</label>
                </th>
                <td style="width:30%">
                    <input type="password" id="user_pass" name="user_pass" value="" class="regular-text code width-85">
                </td>
            </tr>
        <tr valign="top">
            <td colspan="2" align="center">
                <small id="msg-login-valid" class="dn valid">
                    <i class="icon-ok-sign"></i> Username Available!
                </small>
                <small id="msg-login-invalid" class="dn invalid">
                    <i class="icon-warning-sign"></i> Username Exists! please choose different name
                </small>
                <small id="msg-min-len" class="dn invalid"><br>
                    <i class="icon-warning-sign"></i> At least 3 characters: letters, numbers, - or  _ .
                </small>
            </td>
            <th scope="row" style="width:20%">
                <label for="user_pass2">Confirm Password</label>
            </th>
            <td style="width:30%">
                <input type="password" id="user_pass2" name="user_pass2" value="" class="regular-text code width-85">
                <small id="msg-pwd" class="description dn invalid"><i class="icon-warning-sign"></i> unmatched password, please re-enter your password.</small>
                <small id="msg-pwd-empty" class="description dn invalid"><br><i class="icon-warning-sign"></i> Required, password is empty.</small>
            </td>
        </tr>
        </tbody>
    </table>

<?php
}

/**
 * add new stockist, contact details form
 */
function mb_add_stockist_contact_info($post= false, $options= false){
    unset($post); // placeholder

    list($country, $states, $districts) = $options['args'];
    ?>
<input type="hidden" name="section" value="add-stockist">
<table class="widefat nobot">
    <tbody>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="nama_penuh">Full Name</label>
        </th>
        <td style="width:30%">
            <input type="text" id="nama_penuh" name="nama_penuh" value="" class="regular-text code">
            <small id="msg-name-empty" class="description dn invalid"><br><i class="icon-warning-sign"></i> Required, Full Name is empty.</small>
        </td>
        <th scope="row" style="width:20%">
            <label for="nric">NRIC No. # <span class="muted">(K/P)</span></label>
        </th>
        <td style="width:30%">
            <input type="text" id="nric" name="nric" value="" class="regular-text code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="user_email">Email</label>
        </th>
        <td style="width:30%">
            <input type="text" id="user_email" name="user_email" value="" class="regular-text code">
        </td>
        <th scope="row" style="width:20%">
            <label for="tel">Tel. <span class="muted">(Mobile)</span></label>
        </th>
        <td style="width:30%">
            <input type="text" id="tel" name="tel" value="" class="regular-text code">
        </td>
    </tr>
    <tr><td colspan="4"></td></tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="alamat">Business Address</label>
        </th>
        <td style="width:30%">
            <textarea id="alamat" name="alamat" class="large-text code width-85" rows="3" style="width:300px"></textarea>
        </td>
        <th scope="row" style="width:20%">
            <label for="daerah">District <span class="muted">(Daerah)</span></label>
        </th>
        <td style="width:30%">
            <select id="daerah" name="daerah" class="width-85 select-location" data-target="#district">
            <?php if(empty($districts)):?>
                <option>not available</option>
            <?php else: ?>
                <?php foreach($states as $index_s => $s): ?>
                    <optgroup label="<?php echo $s->name;?>">
                    <?php foreach($districts as $index_d => $d): ?>
                        <?php if ($s->state_id == $d->state_id): ?>
                        <option value="<?php echo $d->district_id; ?>" data-state="<?php echo $d->state_id;?>" data-country="<?php echo $s->country_id;?>"><?php echo $d->name; ?></option>
                        <?php endif; ?>
                    <?php endforeach; // end.districts ?>
                    </optgroup>
                <?php endforeach; // ebd.states ?>
            <?php endif; ?>
            </select>
            <a class="" href="<?php echo SKTYPE::URI_PANEL_DSETTINGS;?>"><i class="icon-plus-sign"></i> Add</a>
            <div class="inner-td">
             <input type="text" id="poskod" name="poskod" value="" class="regular-text code" placeholder="Postcode">
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="negeri">State <span class="muted">(Negeri)</span></label>
        </th>
        <td style="width:30%">
            <select id="negeri" name="negeri" class="width-85 select-location" data-target="#state">
                <?php if(empty($states)):?>
                <option>not available</option>
                <?php else: ?>
                <?php foreach($country as $index_c => $c): ?>
                    <optgroup label="<?php echo $c->name;?>">
                     <?php foreach($states as $index_s => $s): ?>
                        <?php if ($c->country_id == $s->country_id): ?>
                        <option value="<?php echo $s->state_id; ?>" data-country="<?php echo $s->country_id;?>"><?php echo $s->name; ?></option>
                        <?php endif; ?>
                     <?php endforeach; // end.states ?>
                    </optgroup>
                <?php endforeach; // end.country ?>
                <?php endif; ?>
            </select>
            <a class="" href="<?php echo SKTYPE::URI_PANEL_SSETTINGS;?>"><i class="icon-plus-sign"></i> Add</a>
        </td>
        <th scope="row" style="width:20%">
            <label for="negara">Country <span class="muted">(Negara)</span></label>
        </th>
        <td style="width:30%">
            <select id="negara" name="negara" class="width-85 select-location" data-target="#country">
                <?php if(empty($country)):?>
                <option>not available</option>
                <?php else: ?>
                <?php foreach($country as $index => $c): ?>
                    <option value="<?php echo $c->country_id; ?>"><?php echo $c->name; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <a class="" href="<?php echo SKTYPE::URI_PANEL_CSETTINGS;?>"><i class="icon-plus-sign"></i> Add</a>
        </td>
    </tr>
    </tbody>
</table>
<input id="district" type="hidden" name="district" value="">
<input id="state" type="hidden" name="state" value="">
<input id="country" type="hidden" name="country" value="">
<?php
}

/**
 * section general-settings
 */

/**
 *  stockist bonus settings metabox
 */


/** stockist product sales pv bonus */
function mb_view_stockist_sales_bonus_options($post=false, $options=false){
    unset($post); // not used, placeholder

    list($meta, $default) = $options['args'];
    $meta = (!empty($meta)) ? $meta : $default;
    $m = foreach_push(new stdClass(), $meta);
    ?>
<table class="widefat">
    <tbody>
    <tr valign="middle">
        <td colspan="2">
            <i class=" icon-bookmark-empty"></i> Bonus receive for every sales.
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="sales_bonus_type">Currency</label>
        </th>
        <td style="width: 30%">
            <select id="sales_bonus_type" name="sales_bonus_type">
                <option value="RM">RM</option>
                <option value="PV">PV</option>
                <option value="PERCENT">PERCENT</option>
            </select>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="state_sales_bonus">State</label>
        </th>
        <td style="width: 30%">
            <input type="text" value="<?php echo $m->state_sales_bonus;?>" id="state_sales_bonus" name="state_sales_bonus" class="code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width: 20%">
            <label for="district_sales_bonus">District</label>
        </th>
        <td style="width: 30%">
            <input type="text" value="<?php echo $m->district_register_bonus;?>" id="district_sales_bonus" name="district_sales_bonus" class="code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width: 20%">
            <label for="mobile_sales_bonus">Mobile</label>
        </th>
        <td style="width: 30%">
            <input type="text" value="<?php echo $m->mobile_sales_bonus;?>" id="mobile_sales_bonus" name="mobile_sales_bonus" class="code">
        </td>
    </tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">
                <div id="msg-sales"><small class="code" style="float:right;padding-right:10px"></small></div>
                <button class="button-primary save-bonus-sales">Save changes</button>
            </th>
        </tr>
    </tfoot>
</table>
<?php
}

/** stockist registration bonus */
function mb_view_stockist_register_bonus_options($post=false, $options=false){
    unset($post, $options); // not used, placeholder

    $meta = get_option(SKTYPE::MK_REGISTER_BONUS, array());
    $m = foreach_push(new stdClass(), $meta);
    ?>
<input type="hidden" name="section" value="stockist-register-bonus">
<table class="widefat">
    <tbody>
    <tr valign="middle">
        <td colspan="2">
            <i class=" icon-bookmark-empty"></i> Bonus receive for every members registration.
        </td>
    </tr>
    <tr valign="top">
    <th scope="row" style="width:20%">
        <label for="sales_bonus_type">Currency</label>
    </th>
    <td style="width: 30%">
        <select id="register_bonus_type" name="register_bonus_type">
            <option value="RM">RM</option>
            <option value="PV">PV</option>
            <option value="PERCENT">PERCENT</option>
        </select>
        <?php if(isset($m->type)):?>
        <script>
            (function($) {
                $('#register_bonus_type').val('<?php echo $m->type; ?>');
            })(jQuery);
        </script>
        <?php endif; ?>
    </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width:20%">
            <label for="state_register_bonus">State</label>
        </th>
        <td style="width: 30%">
            <input type="text" value="<?php echo $m->state;?>" id="state_register_bonus" name="state_register_bonus" class="code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width: 20%">
            <label for="district_register_bonus">District</label>
        </th>
        <td style="width: 30%">
            <input type="text" value="<?php echo $m->district;?>" id="district_register_bonus" name="district_register_bonus" class="code">
        </td>
    </tr>
    <tr valign="top">
        <th scope="row" style="width: 20%">
            <label for="mobile_register_bonus">Mobile</label>
        </th>
        <td style="width: 30%">
            <input type="text" value="<?php echo $m->mobile;?>" id="mobile_register_bonus" name="mobile_register_bonus" class="code">
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2">
            <div id="msg-register"><small class="code" style="float:right;padding-right:10px"></small></div>
            <button class="button-primary save-bonus-register">Save changes</button>
        </th>
    </tr>
    </tfoot>
</table>
    <script></script>
<?php
}


function mb_view_stockist_general_options($post=false, $options=false){
    unset($post); // not used, placeholder

    list($meta, $default) = $options['args'];
    $meta = (!empty($meta)) ? $meta : $default;
    $m = foreach_push(new stdClass(), $meta);
?>
<input type="hidden" name="section" value="usermeta-db">
<table class="widefat">
    <thead>
        <tr>
            <th colspan="4">Meta Keys</th>
        </tr>
    </thead>
    <tbody>
        <tr valign="top">
            <th scope="row" style="width:20%">
                <label for="mk_stockist_code">Stockist ID:</label>
            </th>
            <td style="width: 30%">
                <input type="text" value="<?php echo $m->mk_stockist_code;?>" id="mk_stockist_code" name="mk_stockist_code" class="regular-text code">
                <small class="description db">Permanent settings, meta key for stockist code.</small>
            </td>
            <th scope="row" style="width: 20%">
                <label for="mk_stockist_state_id">State:</label>
            </th>
            <td style="width: 30%">
                <input type="text" value="<?php echo $m->mk_stockist_state_id;?>" id="mk_stockist_state_id" name="mk_stockist_state_id" class="regular-text code">
                <small class="description db">Stockist State meta key.</small>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" style="width: 20%">
                <label for="mk_stockist_hq_id">Primary:</label>
            </th>
            <td style="width: 30%">
                <input type="text" value="<?php echo $m->mk_stockist_hq_id;?>" id="mk_stockist_hq_id" name="mk_stockist_hq_id" class="regular-text code">
                <small class="description db">Primary stockist HQ meta key.</small>
            </td>
            <th scope="row" style="width: 20%">
                <label for="mk_stockist_district_id">District:</label>
            </th>
            <td style="width: 30%">
                <input type="text" value="<?php echo $m->mk_stockist_district_id;?>" id="mk_stockist_district_id" name="mk_stockist_district_id" class="regular-text code">
                <small class="description db">Stockist District meta key.</small>
            </td>
        </tr>
        <tr valign="top">
            <td colspan="2"></td>
            <th scope="row" style="width: 20%">
                <label for="mk_stockist_mobile_id">Mobile:</label>
            </th>
            <td style="width: 30%">
                <input type="text" value="<?php echo $m->mk_stockist_mobile_id;?>" id="mk_stockist_mobile_id" name="mk_stockist_mobile_id" class="regular-text code">
                <small class="description db">Stockist Mobile meta key.</small>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" align="right">
                <button class="button-secondary reset-default-db">Reset default</button>
                <button class="button-primary save-stockist-db">Save changes</button>
            </th>
        </tr>
    </tfoot>
</table>
<script>
    jQuery(document).ready(function($){
       $('.reset-default').click(function(e){
           e.preventDefault();
           $.post(ajaxurl,{'action':'reset_stockist_settings'}, function(data){
           }).success(function(){ // redirect
              window.location.replace(window.location.href);
           });
       });
    });
</script>
<?php
}

/**
 * section district-settings
 */

function mb_view_district_summary($posts, $options){
    list($country, $states, $districts) = $options['args'];
    unset($country);
    $cnt_district = array();
    ?>
<table class="widefat">
    <thead>
    <tr>
        <th style="width:60%">District</th>
        <th style="width:40%">Stockist(s)</th>
    </tr>
    </thead>
    <tbody>
        <?php if (empty($states) && !empty($districts)): ?>
    <tr id="no-country-summary-msg">
        <td colspan="2">Sorry there is no state district added on this list yet, please add one.</td>
    </tr>
        <?php else: ?>
        <?php foreach($states as $index => $s) :?>
        <tr>
            <?php $attributes = array('href'=>'#','class'=>'toggle-district db','data-target'=>'.district-'.$s->state_id);?>
            <td><?php $cnt = _t('span','',array('class'=>'muted','id'=>'cnt-'.$s->state_id));?>
                <?php t('a','<i class="icon-chevron-down"></i>  '.$s->name.' '.$cnt, $attributes); ?>
            </td>
            <td><?php echo get_stockist_by_state($s->name);?></td>
        </tr>

            <?php $cnt_district[$s->state_id] = 0; ?>
            <?php foreach($districts as $d_index => $d):?>

            <?php if ($d->state_id == $s->state_id): ?>
        <tr class="district-<?php echo $s->state_id;?>">
            <td style="padding-left:20px"><?php echo $d->name; ?></td>
            <td><?php echo get_stockist_by_district($d->name);?></td>
        </tr>
                <?php $cnt_district[$s->state_id]++; ?>
                <?php endif; ?>
                <?php endforeach;?>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
    <script>
        jQuery(document).ready(function($){
           $('.toggle-district').click(function(e){
               e.preventDefault();
               var el = $(this).data('target');
               $(el).slideToggle('slow');
               $(this).children('i').toggleClass('icon-chevron-down icon-chevron-up');
           });
           $('.toggle-district').each(function(){
               var el = $(this).data('target');
               $(el).slideToggle('fast');
           }) ;
           <?php if (!empty($cnt_district)): ?>
           <?php foreach($cnt_district as $sid => $cnt): ?>
            $('#cnt-<?php echo $sid;?>').html('(<?php echo $cnt;?>)');
           <?php endforeach; ?>
           <?php endif;?>
        });
    </script>
<?php
}

/**
 * view stockist district form
 *
 * @todo    live edit functions
 * @param   $posts
 * @param   $options
 */
function mb_view_district($posts, $options = array('args'=>false)){

    list($country, $states, $districts) = $options['args'];
    ?>
<input type="hidden" name="section" value="district">
<table class="widefat">
    <thead>
    <tr>
        <th style="width:151px">State</th>
        <th>District</th>
        <th style="width:126px"><abbr title="Hierarchical Administrative Subdivision Codes">HSAC</abbr></th>
        <th style="width:151px">Postcode <small>(range)</small></th>
        <th style="width:101px">Division</th>
        <th style="width:85px;text-align: center">Actions</th>
    </tr>
    </thead>
    <tbody id="districts-list">
        <?php if (empty($districts) ): ?>
    <tr id="no-district-msg">
        <td colspan="6">Sorry there is no state district added on this list yet, please add one.</td>
    </tr>
        <?php else: ?>
        <?php foreach($districts as $index => $d) :?>
        <tr>
            <td>
                <select id="cstate-<?php echo $d->district_id; ?>" disabled>
                    <?php foreach($states as $i => $s):?>
                    <option value="<?php echo $s->state_id; ?>"><?php echo $s->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <script>
                    jQuery(document).ready(function($){
                        $('#cstate-<?php echo $d->district_id; ?>').val(<?php echo $d->state_id;?>);
                    });
                </script>
            </td>
            <td align="left"><?php disabled_input($d->name, 35);?></td>
            <td><?php disabled_input($d->hasc, 15);?></td>
            <td><?php disabled_input($d->postcode, 20);?></td>
            <td><?php disabled_input($d->division, 10);?></td>
            <td align="center">
                <button class="button-secondary do-delete-district" data-id="<?php echo $d->district_id; ?>"><i class="icon-remove-sign"></i> delete</button>
            </td>
        </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6">
            <button class="button-secondary add-district"><i class="icon-plus-sign"></i> Add District</button>
            <button type="submit" class="button-primary">Save Changes</button>
        </th>
    </tr>
    </tfoot>
</table>
<script>
    var counter_id = 1;
    jQuery(document).ready(function($){

        function add_district()
        {
            htm = '<tr>';

            htm += '<td><select name="state_id['+counter_id+']">';
            <?php if (!empty($states)):  ?>
            <?php foreach($states as $x => $s):?>
                htm += '<option value="<?php echo $s->state_id; ?>"><?php echo $s->name; ?></option>';
                <?php endforeach; ?>
            <?php else: ?>
            htm += '<option>not available</option>';
            <?php endif; ?>
            htm += '</select></td>';
            htm += '<td><input type="text" name="district_name['+counter_id+']" value="" size="40"><input type="hidden" name="district_id['+counter_id+']" value="'+counter_id+'"></td>';
            htm += '<td><input type="text" name="district_hsac['+counter_id+']" value="" size="15"></td>';
            htm += '<td><input type="text" name="district_postcode['+counter_id+']" value="" size="20"></td>';
            htm += '<td><input type="text" name="district_division['+counter_id+']" value="" size="10"></td>';
            htm += '<td align="center"><button class="button-secondary" onclick="jQuery(jQuery(this).closest(\'tr\')).remove();"><i class="icon-remove-sign"></i> delete</button></td>';
            htm += '</tr>';

            $(htm).appendTo('#districts-list');
            counter_id++;
        }

        $('.add-district').click(function(e){
            e.preventDefault();
            if ( $('#no-district-msg') ) {
                $('#no-district-msg').fadeOut(200);
            }
            add_district();
        });

        $('.do-delete-district').click(function(e){
            e.preventDefault();
            params = {
                'district_id': $(this).data('id'),
                'action': '<?php echo SKTYPE::ACT_DEL_DISTRICT; ?>'
            };

            $.post(ajaxurl, params, function(data){
            }).success(function(){
                        window.location.replace(window.location.href);
                    });

        });
    });
</script>
<?php
}

/**
 * section state-settings
 */

function mb_view_state_summary($posts, $options){
    list($country, $states) = $options['args'];
    unset($country);
    ?>
<table class="widefat">
    <thead>
    <tr>
        <th style="width:60%">State</th>
        <th style="width:40%">Stockist(s)</th>
    </tr>
    </thead>
    <tbody>
        <?php if (empty($states) ): ?>
    <tr id="no-country-summary-msg">
        <td colspan="2">Sorry there is no state added on this list yet, please add one.</td>
    </tr>
        <?php else: ?>
        <?php foreach($states as $index => $s) :?>
        <tr>
            <td><?php echo $s->name; ?></td>
            <td><?php echo get_stockist_by_state($s->name);?></td>
        </tr>
            <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>
<?php
}

/**
 * view stockist state form
 * @param $posts
 * @param $options
 */
function mb_view_state($posts, $options = array('args'=>false)){

    list($country, $states) = $options['args'];
?>
<input type="hidden" name="section" value="state">
<table class="widefat">
    <thead>
    <tr>
        <th style="width:20%">Country</th>
        <th style="width:25%">State</th>
        <th style="width:10%"><abbr title="ISO 3166-2">ISO</abbr></th>
        <th style="width:10%"><abbr title="Hierarchical Administrative Subdivision Codes">HSAC</abbr></th>
        <th style="width:15%">Postcode <small>(range)</small></th>
        <th style="width:20%;text-align: center">Actions</th>
    </tr>
    </thead>
    <tbody id="state-list">
        <?php if (empty($states) ): ?>
    <tr id="no-state-msg">
        <td colspan="6">Sorry there is no state added on this list yet, please add one.</td>
    </tr>
        <?php else: ?>
        <?php foreach($states as $index => $s) :?>
        <tr>
            <td>
                <select id="cstate-<?php echo $s->state_id; ?>" disabled="disabled">
                    <?php foreach($country as $index => $c):?>
                    <option value="<?php echo $c->country_id; ?>"><?php echo $c->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <script>
                    jQuery(document).ready(function($){
                        $('#cstate-<?php echo $s->state_id; ?>').val(<?php echo $s->country_id;?>);
                    });
                </script>
            </td>
            <td>
                <?php t('input','', array(
                'value'     => $s->name,
                'size'      => 43,
                'disabled'  => 'disabled') ); ?>
            </td>
            <td>
                <?php t('input','', array(
                'value'     => $s->iso,
                'size'      => 20,
                'disabled'  => 'disabled') ); ?>
            </td>
            <td>
                <?php t('input','', array(
                'value'     => $s->hasc,
                'size'      => 10,
                'disabled'  => 'disabled') ); ?>
            </td>
            <td>
                <?php t('input','', array(
                'value'     => $s->postcode,
                'size'      => 20,
                'disabled'  => 'disabled') ); ?>
            </td>
            <td align="center">
                <button class="button-secondary do-delete-state" data-id="<?php echo $s->state_id; ?>"><i class="icon-remove-sign"></i> delete</button>
            </td>
        </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6">
            <button class="button-secondary add-state"><i class="icon-plus-sign"></i> Add State</button>
            <button type="submit" class="button-primary">Save Changes</button>
        </th>
    </tr>
    </tfoot>
</table>
<script>
    var counter_id = 1;
    jQuery(document).ready(function($){

        function add_state()
        {
            htm = '<tr>';

            htm += '<td><select name="country_id['+counter_id+']">';
            <?php if (!empty($country)):  ?>
            <?php foreach($country as $index => $c):?>
            htm += '<option value="<?php echo $c->country_id; ?>"><?php echo $c->name; ?></option>';
            <?php endforeach; ?>
            <?php else: ?>
            htm += '<option>no country yet</option>';
            <?php endif; ?>
            htm += '</select></td>';
            htm += '<td><input type="text" name="state_name['+counter_id+']" value="" size="45"><input type="hidden" name="state_id['+counter_id+']" value="'+counter_id+'"></td>';
            htm += '<td><input type="text" name="state_iso['+counter_id+']" value="" size="20"></td>';
            htm += '<td><input type="text" name="state_hsac['+counter_id+']" value="" size="10"></td>';
            htm += '<td><input type="text" name="state_postcode['+counter_id+']" value="" size="20"></td>';
            htm += '<td align="center"><button class="button-secondary" onclick="jQuery(jQuery(this).closest(\'tr\')).remove();"><i class="icon-remove-sign"></i> delete</button></td>';
            htm += '</tr>';

            $(htm).appendTo('#state-list');
            counter_id++;
        }

        $('.add-state').click(function(e){
            e.preventDefault();
            if ( $('#no-state-msg') ) {
                $('#no-state-msg').fadeOut(500);
            }
            add_state();
        });

        $('.do-delete-state').click(function(e){
            e.preventDefault();
            params = {
                'state_id': $(this).data('id'),
                'action': 'delete_state'
            };

            $.post(ajaxurl, params, function(data){
            }).success(function(){
                        window.location.replace(window.location.href);
                    });

        });
    });
</script>
<?php
}

/**
 * section country-settings
 */

/**
 * issue #1
 * @links http://code.mdag.my/baydura_isralife/issue/1/
 */
function mb_view_country_summary_debug(){
    global $wpdb;

    $country    = 'Malaysia';

    $db         = $wpdb->usermeta;
    $country    = strtolower($country);
    $regx       = sprintf("negara_option_%s$", $country);

    $sql        = "SELECT COUNT(*) FROM $db um JOIN $db umm ON um.user_id=umm.user_id
                    WHERE um.meta_key REGEXP %s
                    AND umm.meta_key=%s AND umm.meta_value='on'";
    $stockist   = $wpdb->get_var($wpdb->prepare($sql, $regx, SKTYPE::MK_USERTYPE_STOCKIST));

    t('h4','stockist in malaysia');
    $results = array(
        'query' => $sql,
        'prepare query' => $wpdb->prepare($sql, $regx, SKTYPE::MK_USERTYPE_STOCKIST),
        'result' => $stockist
    );
    echo '<pre>';
    print_r($results);
    echo '</pre><br>';
    $sql        = "SELECT COUNT(*) FROM $db WHERE meta_key REGEXP %s";
    $total      = $wpdb->get_var($wpdb->prepare($sql, $regx));
    t('h4','total users in malaysia');
    echo '<pre>';
    $results = array(
        'query' => $sql,
        'prepare query' => $wpdb->prepare($sql, $regx),
        'result' => $total
    );
    print_r($results);
    echo '</pre>';
}

function mb_view_country_summary($posts, $options){
    list($country, $states, $districts) = $options['args'];
    unset($posts, $states, $districts);

?>
    <table class="widefat">
        <thead>
        <tr>
            <th style="width:60%">Country</th>
            <th style="width:40%">Stockist(s)</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($country) ): ?>
            <tr id="no-country-summary-msg">
                <td colspan="2">Sorry there is no country added on this list yet, please add one.</td>
            </tr>
        <?php else: ?>
        <?php foreach($country as $index => $c) :?>
            <tr class="row-<?php echo $index?>">
                <td><?php echo $c->name; ?></td>
                <td><?php echo get_stockist_by_country($c->name);?></td>
            </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
    </table>
<?php
}

/**
 * view stockist country form
 * @param $posts
 * @param $options
 */
function mb_view_country($posts, $options){
 $country = $options['args'][0];
?>
<input type="hidden" name="section" value="country">
    <table class="widefat">
        <thead>
            <tr>
                <th style="width:60%">Country Name</th>
                <th style="width:20%">ISO</th>
                <th style="width:20%;text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody id="country-list">
            <?php if (empty($country) ): ?>
                <tr id="no-country-msg">
                    <td colspan="4">Sorry there is no country added on this list yet, please add one.</td>
                </tr>
            <?php else: ?>
            <?php foreach($country as $index => $c) :?>
            <tr>
                <td>
                    <?php t('input','', array(
                                            'value'     => $c->name,
                                            'name'      => 'country_name['.$c->country_id.']',
                                            'size'      => 100,
                                            'disabled'  => 'disabled') ); ?>
                </td>
                <td>
                    <?php t('input','', array(
                    'value'     => $c->iso,
                    'name'      => 'country_iso['.$c->country_id.']',
                    'size'      => 20,
                    'disabled'  => 'disabled') ); ?>
                </td>
                <td align="center">
                    <button class="button-secondary do-delete" data-id="<?php echo $c->country_id; ?>"><i class="icon-remove-sign"></i> Delete</button>
                </td>
            </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">
                    <button class="button-secondary add-country"><i class="icon-plus-sign"></i> Add Country</button>
                    <button type="submit" class="button-primary">Save Changes</button>
                </th>
            </tr>
        </tfoot>
    </table>
    <script>
        var country_id = 1;
        jQuery(document).ready(function($){
            
            function add_country()
            {
                htm = '<tr>';
                htm += '<td><input type="text" name="country_name['+country_id+']" value="" size="100"><input type="hidden" name="country_id['+country_id+']" value="'+country_id+'"></td>';
                htm += '<td><input type="text" name="country_iso['+country_id+']" value="" size="20"></td>';
                htm += '<td align="center"><button class="button-secondary" onclick="jQuery(jQuery(this).closest(\'tr\')).remove();"><i class="icon-remove-sign"></i> delete</button></td>';
                htm += '</tr>';
                
                $(htm).appendTo('#country-list');
    	        country_id++;
            }
            
            $('.add-country').click(function(e){
                e.preventDefault();
                if ( $('#no-country-msg') ) {
                    $('#no-country-msg').fadeOut(500);
                }
                add_country(); 
            });

            $('.do-delete').click(function(e){
                e.preventDefault();
                params = {
                    'country_id': $(this).data('id'),
                    'action': 'delete_country'
                };

                $.post(ajaxurl, params, function(data){
                }).success(function(){
                            window.location.replace(window.location.href);
                        });
            });
        });
    </script>
<?php     
}