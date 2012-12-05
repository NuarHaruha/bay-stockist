<?php
function get_stockist_by_district($district){
    global $wpdb;

    $db         = $wpdb->usermeta;
    $district   = strtoupper($district);
    $regx       = sprintf("%s$", $district);

    $sql        = "SELECT COUNT(*) FROM $db um JOIN $db umm ON um.user_id=umm.user_id
                    WHERE um.meta_value REGEXP %s AND um.meta_key = %s
                    AND umm.meta_key=%s";

    $stockist   = $wpdb->get_var($wpdb->prepare($sql, $regx,'daerah',SKTYPE::MK_USERTYPE_STOCKIST));
    $sql        = "SELECT COUNT(*) FROM $db WHERE meta_value REGEXP %s";
    $total      = $wpdb->get_var($wpdb->prepare($sql, $regx));

    return $stockist.'/'.$total;
}

function get_predefined_district(){
    global $wpdb;

    $db = SKTYPE::DB(SKTYPE::DB_DISTRICT);

    return $wpdb->get_results("SELECT * FROM $db ORDER BY `state_id` ASC, `name` ASC");
}

function get_stockist_by_state($state){
    global $wpdb;

    $db         = $wpdb->usermeta;
    $state      = strtolower($state);
    $state      = str_replace(' ','-',$state);
    $regx       = sprintf("%s$", $state);

    $sql = "SELECT COUNT(um.user_id) FROM $db um JOIN $db umm on um.user_id=umm.user_id WHERE um.meta_key REGEXP %s AND umm.meta_key=%s";

    $stockist = $wpdb->get_var($wpdb->prepare($sql, $regx, SKTYPE::MK_USERTYPE_STOCKIST));
    $sql      = "SELECT COUNT(*) FROM $db WHERE meta_key REGEXP %s";
    $total    = $wpdb->get_var($wpdb->prepare($sql, $regx));

    return $stockist.'/'.$total;
}

function get_predefined_state(){
    global $wpdb;

    $db = SKTYPE::DB(SKTYPE::DB_STATE);

    return $wpdb->get_results("SELECT * FROM $db ORDER BY `country_id` ASC, `name` ASC");
}

function get_predefined_country(){
    global $wpdb;
    
    $db = SKTYPE::DB(SKTYPE::DB_COUNTRY);
    
    return $wpdb->get_results("SELECT * FROM $db");
}

function get_total_user_country($name){
    global $wpdb;

    $db         = $wpdb->usermeta;
    $name       = strtolower($name);
    $name       = 'negara_option_'.$name;

    $sql        = "SELECT COUNT(*) FROM $db WHERE `meta_key`=%s";
    $total      = $wpdb->get_var($wpdb->prepare($sql, $name));

    return $total;
}

function get_total_stockist_by_country($name){
    global $wpdb;

    $db         = $wpdb->usermeta;
    $country    = strtolower($name);
    $meta_key   = 'negara_option_'. $country;

    $sql        = "SELECT COUNT(*) FROM $db um JOIN $db umm ON um.user_id=umm.user_id WHERE um.meta_key=%s AND umm.meta_key=%s";
    $stockist   = $wpdb->get_var($wpdb->prepare($sql, $meta_key, SKTYPE::MK_USERTYPE_STOCKIST));

    return $stockist;
}

function get_stockist_by_country($country){

    $stockist   = get_total_stockist_by_country($country);
    $total      = get_total_user_country($country);

    return $stockist.'/'.$total;
}