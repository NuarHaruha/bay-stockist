<?php

/** save sales bonus */
function ajax_save_stockist_sales_bonus(){

    $result = false;

    $meta = get_option(SKTYPE::MK_SALES_BONUS, array());

    foreach(array('type','state','district','mobile') as $key ){
        if (isset($_POST[$key])){
            $meta[$key] = $_POST[$key];
        }
    }

    update_option(SKTYPE::MK_SALES_BONUS, $meta);

    $result = (count($meta)>=0 ) ? 1 : 0;

    echo json_encode(array('success'=> $result));
    exit();
}

/** save bonus registration */
function ajax_save_stockist_registration_bonus(){

    $result = false;

    $meta = get_option(SKTYPE::MK_REGISTER_BONUS, array());

    foreach(array('type','state','district','mobile') as $key ){
        if (isset($_POST[$key])){
            $meta[$key] = $_POST[$key];
        }
    }

    update_option(SKTYPE::MK_REGISTER_BONUS, $meta);

    $result = (count($meta)>=0 ) ? 1 : 0;

    echo json_encode(array('success'=> $result));
    exit();
}

function json_stockist_reserved_id()
{
    $type = $_POST['type'];
    $id   = (int) $_POST['id'];

    echo json_encode(array('code'=>get_stockist_new_id($type, $id)));
    exit();
}

function get_stockist_new_id($type=SKTYPE::ST_DISTRICT, $id = false){
    global $wpdb;

    if (!$type) return false;

    $db = SKTYPE::DB(SKTYPE::DB_PRIMARY);
    $result  = 0;
    $whereto = 'district_id';

    switch ($type){
        case SKTYPE::ST_STATE:
            $whereto = 'state_id';
            break;
        case SKTYPE::ST_DISTRICT:
            $whereto = 'district_id';
           break;
        case SKTYPE::ST_MOBILE:
            $whereto = 'type';
            $id      = SKTYPE::ST_MOBILE;
            break;
        case SKTYPE::ST_HQ:
            $whereto = "type='hq' AND country_id";
            break;
    }

    $sql = "SELECT count(*) FROM $db WHERE $whereto=%d";

    $result = $wpdb->get_var($wpdb->prepare($sql, $id));

    if (empty($result)){
        $result = 0;
    }

    $code   = ($result + 1);
    $prefix = get_stockist_prefix($type, $id);
    $pad    = pad_prefix($code);

    $code   = apply_filters('get_stockist_new_id', $prefix.'-'.$pad.$code);

    return  $code;
}

function pad_prefix($code){
    $code = (int) $code;
    $pad = (($code <= 9) ? '000' : ($code <= 99) ? '00' : ($code <= 999) ? '0' : '');
    return $pad;
}

function get_stockist_prefix($type, $id){
    global $wpdb;

    if (!$type) return false;
    $prefix = $db = $whereto = false;

    switch($type){
        case SKTYPE::ST_STATE:
            $db = SKTYPE::DB(SKTYPE::DB_STATE);
            $whereto = 'state_id';
            break;
        case SKTYPE::ST_DISTRICT:
            $db = SKTYPE::DB(SKTYPE::DB_DISTRICT);
            $whereto = 'district_id';
            break;
        case SKTYPE::ST_HQ:
            $db = SKTYPE::DB(SKTYPE::DB_COUNTRY);
            $whereto = 'country_id';
            break;
        case SKTYPE::ST_MOBILE:
            $prefix = SKTYPE::PREFIX_MOBILE;
            break;
    }

    if ($type != SKTYPE::ST_MOBILE){

        $sql = "SELECT * FROM $db WHERE $whereto=%d";
        $result = $wpdb->get_results($wpdb->prepare($sql,$id));

        if ($result){
            $result = $result[0];
            switch($type){
                case SKTYPE::ST_HQ:
                    $prefix = SKTYPE::PREFIX_HQ .$result->iso;
                    break;
                case SKTYPE::ST_STATE:
                    $prefix = SKTYPE::PREFIX_STATE.$result->iso;
                    break;
                case SKTYPE::ST_DISTRICT:
                    // find state iso code
                    $db     = SKTYPE::DB(SKTYPE::DB_STATE);
                    $sql    = "SELECT iso FROM $db WHERE `state_id`=%d";
                    $iso    = $wpdb->get_var($wpdb->prepare($sql, $result->state_id));

                    $suffix = substr($result->hasc, -2);
                    $prefix = SKTYPE::PREFIX_DISTRICT.$iso.$suffix;
                    break;
            }
        }
    }

    return $prefix;
}

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