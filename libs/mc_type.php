<?php
/**
 * STOCKIST type enum & Constant
 * 
 * @package     isralife
 * @category    stockist
 * 
 * @author      Nuarharuha 
 * @copyright   Copyright (C) 2012, Nuarharuha, MDAG Consultancy
 * @license     http://mdag.mit-license.org/ MIT License
 * @filesource  http://code.mdag.my/baydura_isralife/src
 * @version     0.1
 * @access      public
 */
 
final class SKTYPE
{
    const VERSION                   = 0.1;
    
    const DB_VERSION                = 1.2;
    
    /**
     *  table name
     */
    
    const DB_PRIMARY                = 'mc_stockist';
    
    const DB_PRIMARY_META           = 'mc_stockist_meta';
    
    const DB_COUNTRY                = 'mc_country';
    
    const DB_STATE                  = 'mc_state';
    
    const DB_DISTRICT               = 'mc_district'; 

    /**
     * db version metakey stored in
     * wp options table
     * 
     * @var string
     */
    const MK_DB_VERSION             = 'mc_stockist_db_version';    
    
    /**
     *  usermeta key
     */

    const MK_USERTYPE_STOCKIST      = 'user_type_option_stokis';
    
    const MK_STATE_STOCKIST         = 'jenis_stokis_option_stokis-negeri';
    
    const MK_CITY_STOCKIST          = 'jenis_stokis_option_stokis-daerah';
    
    const MK_MOBILE_STOCKIST        = 'jenis_stokis_option_stokis-mobile';
    
    const MK_STOCKIST_ID            = 'stockist_id';

    const MK_DEFAULT_SETTINGS       = 'stockist_default_settings';

    const MK_USERMETA_SETTINGS      = 'stockist_usermeta_settings';

    const MK_ADD_NEW                = "tel,nama_penuh,nric,alamat,daerah,poskod,negeri,negara,nama_bank,no_bank,cawangan_bank,jenis_akaun_bank,id_penaja,nama_penaja,send_sms,send_email,stockist_type,status_option_active,user_type_option_stokis,district,state,country,account_id,reserved_id";
    
    /**
     * slug 
     */   
     
     const SLUG_PRIMARY             = 'mc_stockist';

    /**
     *  action request
     */
    const ACT_SETTINGS              = 'stockist_settings';

    const ACT_NEW                   = 'stockist_add';

    const ACT_DEL_COUNTRY           = 'delete_country';

    const ACT_DEL_STATE             = 'delete_state';

    const ACT_DEL_DISTRICT          = 'delete_district';

    /**
     * URI REDIRECT
     */
    const URI_SETTINGS              = '/wp-admin/admin.php?page=mc_stockist_settings';

    const URI_PANEL_CSETTINGS       = '/wp-admin/admin.php?page=mc_stockist_settings&panel=country-settings';

    const URI_PANEL_SSETTINGS       = '/wp-admin/admin.php?page=mc_stockist_settings&panel=state-settings';

    const URI_PANEL_DSETTINGS       = '/wp-admin/admin.php?page=mc_stockist_settings&panel=district-settings';

    const URI_PANEL_GSETTINGS       = '/wp-admin/admin.php?page=mc_stockist_settings&panel=general-settings';

    const URI_LIST_STOCKIST         = '/wp-admin/admin.php?page=mc_stockist';

    /**
     * Tab Panel
     */
    const PANEL_SETTINGS            = 'general-settings';

    const PANEL_COUNTRY             = 'country-settings';

    const PANEL_STATE               = 'state-settings';

    const PANEL_DISTRICT            = 'district-settings';

    /**
     *  Stockist type, register enum
     */
    const ST_MOBILE                 = 'mobile';
    const ST_DISTRICT               = 'district';
    const ST_STATE                  = 'state';
    const ST_HQ                     = 'hq';

    const PREFIX_MOBILE             = 'SM';
    const PREFIX_DISTRICT           = 'SD';
    const PREFIX_STATE              = 'SN';
    const PREFIX_HQ                 = 'HQ';

    /**
     *  custom error message
     */

    const ERR_NO_EMAIL              = "Email field is empty, system auto generate temporary email: %s";

    const ERR_EMPTY_FIELD           = "Required, <b>%s</b> field is empty.";

    const ERR_LOGIN_EXISTS          = "Username taken, <b>%s</b> is not available. Please choose different login name.";

    const ERR_PWD_UNMATCHED         = "Unmatched <b>Password</b>, please re-enter your password again.";

    const ERR_NO_STATE_STOCKIST     = 'Error, No state stockist available';
    /**
     * nonces
     */
    const NONCES_STOCKIST           = 0x15e1;

    const ST_ROLE                   = 'stockist';
    /**
     * @uses $wpdb wp database object
     * @author Nuarharuha
     * @since 0.1
     * 
     * @param string $name const of STYPE::DB_{$}
     * @return string db table name with base prefix
     */
    public static function DB($name)
    {   global $wpdb;
        return $wpdb->base_prefix.$name;
    }
    
    /**
     * @return int|float db version  
     */
    public static function VERSION()
    { 
        return (float) get_option(self::MK_DB_VERSION);
    } 
    
    public static function get($name){
        
        if (isset(self::$name)){
            return self::$name;
        }

        return $name;
    }

    public static function STR_A($str)
    {
        $str = trim(strem(' ',$str));
        return explode(',',$str);
    }
}