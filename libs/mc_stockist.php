<?php
/**
 * @author Nuarharuha <nhnoah+bay-isra@gmail.com>
 * @version 0.1
 * @since 0.1
 */

/**
 * heading tab for main list page
 */
function stockist_list_tabs( $current = 'general-list' ) {
    $tabs = array(
        'general-list'   => 'All Stockist',
        'state-list'     => 'State',
        'district-list'  => 'District',
        'mobile-list'  => 'Mobile',
    );

    echo '<div id="icon-stockist" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='/wp-admin/admin.php?page=mc_stockist&panel=$tab'>$name</a>";
    }
    echo '</h2>';
}

function settings_tabs( $current = 'general-settings' ) {
    $tabs = array(
        'general-settings'   => 'Settings',
        'country-settings'   => 'Country',
        'state-settings'     => 'State',
        'district-settings'  => 'District'
    );

    echo '<div id="icon-options-general" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='/wp-admin/admin.php?page=mc_stockist_settings&panel=$tab'>$name</a>";
    }
    echo '</h2>';
}

function count_stockist_members($stockist_id){
    global $wpdb;
    
    $table = $wpdb->usermeta;
    $meta_keys = SKTYPE::MK_STOCKIST_ID;
    
    $sql = "SELECT COUNT(*) FROM $table WHERE `meta_key`=%s AND `meta_value`=%s";
    
    return $wpdb->get_var($wpdb->prepare($sql, $meta_keys, $stockist_id));
}

function total_stockist_sales($stockist_id){
    global $wpdb;
    
    $stockist_id = (int) $stockist_id;
    
    $table = $wpdb->prefix.mc_products_sales::DB_TABLE_INVOICE;
    $meta_keys = SKTYPE::MK_STOCKIST_ID;
    
    $sql = "SELECT FORMAT(SUM(`total_amount`),2) FROM $table WHERE `stockist_id`=%d";
    
    return $wpdb->get_var($wpdb->prepare($sql, $stockist_id));    
}

function count_stockist_sales($stockist_id){
    global $wpdb;
    
    $stockist_id = (int) $stockist_id;
    
    $table = $wpdb->prefix.mc_products_sales::DB_TABLE_INVOICE;
    $meta_keys = SKTYPE::MK_STOCKIST_ID;
    
    $sql = "SELECT COUNT(*) FROM $table WHERE `stockist_id`=%d";
    
    return $wpdb->get_var($wpdb->prepare($sql, $stockist_id));    
}

function average_stockist_sales($stockist_id){
    global $wpdb;
    
    $stockist_id = (int) $stockist_id;
    
    $table = $wpdb->prefix.mc_products_sales::DB_TABLE_INVOICE;
    $meta_keys = SKTYPE::MK_STOCKIST_ID;
    
    $sql = "SELECT FORMAT(SUM(`total_amount`) / COUNT(*),2) as 'avg' FROM $table WHERE `stockist_id`=%d";
    
    return $wpdb->get_var($wpdb->prepare($sql, $stockist_id));    
}

function get_stockist_hq($return_code = false ){
    global $wpdb;
    
    $table      = $wpdb->usermeta;
    $meta_keys  = 'jenis_stokis_option_stokis-hq';    
    $sql        = "SELECT `user_id` AS id FROM $table WHERE `meta_key`=%s LIMIT 1";
    
    $id=  $wpdb->get_var($wpdb->prepare($sql, $meta_keys));
    
    if ($id && !empty($id)){
        $id = (int) $id;
        return ($return_code) ? get_metadata('user', $id,'account_id',true) : $id;
    } else {
        return false;
    }
}

/**
 * show disabled input
 * @uses    t()
 * @param   string      $value      value
 * @param   string|int  $size       size
 **/
function disabled_input($value, $size = 10){
    t('input','', array('value'=> $value, 'size' => $size, 'disabled'=>'disabled'));
}

/**
 *  check if current user has permission to register
 *  valid check for product id availability
 *  return bool
 */
function stockist_can_register(){

    /** rule-out non role check */
    //if (!current_user_is_stockist()) { return false; }

    // Search for available/reserved product
    // matching our starter kit

    global $wpdb;

    $uid    = _current_user_id();
    $pid    = get_option(SKTYPE::MK_STARTER_KIT, false); // @todo fallback, missing pid
    $db     = PINTYPE::DB(PINTYPE::DB_PRIMARY);
    $db2    = PINTYPE::DB(PINTYPE::DB_PIN_STOCKIST);
    $status = PINTYPE::STATUS_RESERVED;

    $sql    = "SELECT count(*) FROM $db e JOIN $db2 s ON e.pin_id = s.pin_id ".
              "WHERE e.product_id=%d AND e.status=%s AND s.stockist_id=%d";

    $result = $wpdb->get_var($wpdb->prepare($sql, $pid, $status, $uid));

    return ($result) ? true : false;

}