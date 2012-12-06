<?php
/**
 * Date: 12/6/12
 * Time: 12:43 AM
 *
 * User registration functions
 *
 * @author Nuarharuha
 * @version 0.1
 * @since 0.1
 */

/**
 *  generate random email
 *  @return string random email
 */
function mc_get_random_email(){
    $str = str_pad((string )mt_rand(0, 99999999999), 7, '0', STR_PAD_LEFT);
    return 'isra'.$str . '@isralife.baydura.my';
}

/**
 *  check username exist via admin-ajax call
 */
function json_is_name_valid(){

    if (isset($_POST['login'])){

        $user_id = username_exists($_POST['login']);

        $user_id = (empty($user_id)) ? true : false;

        echo json_encode(array('valid'=> $user_id));
    }

    exit();
}