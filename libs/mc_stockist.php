<?php
/**
 * @author Nuarharuha
 * @version 0.1
 * @since 0.1
 */

function get_stockist_code(){

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
    $meta_keys = Stockist::MK_STOCKIST_ID;
    
    $sql = "SELECT COUNT(*) FROM $table WHERE `meta_key`=%s AND `meta_value`=%s";
    
    return $wpdb->get_var($wpdb->prepare($sql, $meta_keys, $stockist_id));
}

function total_stockist_sales($stockist_id){
    global $wpdb;
    
    $stockist_id = (int) $stockist_id;
    
    $table = $wpdb->prefix.mc_products_sales::DB_TABLE_INVOICE;
    $meta_keys = Stockist::MK_STOCKIST_ID;
    
    $sql = "SELECT FORMAT(SUM(`total_amount`),2) FROM $table WHERE `stockist_id`=%d";
    
    return $wpdb->get_var($wpdb->prepare($sql, $stockist_id));    
}

function count_stockist_sales($stockist_id){
    global $wpdb;
    
    $stockist_id = (int) $stockist_id;
    
    $table = $wpdb->prefix.mc_products_sales::DB_TABLE_INVOICE;
    $meta_keys = Stockist::MK_STOCKIST_ID;
    
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


