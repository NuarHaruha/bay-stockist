<?php
/**
 * @package stockist
 */
/*
Plugin Name: MDAG Stockist
Plugin URI: http://mdag.my
Description: IsraLife Stockist Module
Version: 1.0.0
Author: Nuar, MDAG Consultancy
Author URI: http://mdag.my
License: MIT License
License URI: http://mdag.mit-license.org/
*/
class Stockist
{
    /**
     * current user id
     * @var int
     */
    public $id;
    
    public $page = array();

    /**
     * stockist role 
     * @var mixed|array
     * @link http://codex.wordpress.org/Roles_and_Capabilities#Resources
     */
    public $st_role = array(
        'create_users', 'list_users'
    );
    
    /**
     * stockist user level
     * @var int
     */
    public $st_level;
    
    public $insert_id;

    public $plugin_path;

    public $plugin_libs;

    public $plugin_uri;

    /**
     * last insert user id
     * @var int
     */
    public $last_uid;

    /**
     * errors notice
     * @var mixed|array
     */
    public $errors = array();
    
    public function __construct()
    {
        $this->_init();
    }
    
    public function __destruct()
    {
        unset($this);
    }
    
    private function _init()
    {
        
        $this->_loadDefault();
        
        if (is_admin()){
            $this->_initAdmin();
            $this->_load_table_list();
        }
    }
    
    private function _initAdmin()
    {        
        add_action('admin_init', array(&$this, 'admin_stylesheets'));
        add_action('admin_init', array(&$this, 'admin_ajax_scripts'));
        add_action('admin_init', array(&$this, 'register_admin_scripts'));
        add_action('admin_menu', array(&$this,'registerAdminMenu'));
        add_action('add_meta_boxes', array(&$this,'init_settings_metabox'));
        add_action('add_meta_boxes', array(&$this,'init_add_stockist_metabox'));
    }

    /**
     * register admin ajax functions
     */
    public function admin_ajax_scripts()
    {
        /** uses at stockist settings page */
        add_action('wp_ajax_delete_country', array($this, 'delete_country_by_id'));
        add_action('wp_ajax_delete_state', array($this, 'delete_state_by_id'));
        add_action('wp_ajax_delete_district', array($this, 'delete_district_by_id'));
        add_action('wp_ajax_username_exists', 'json_is_name_valid');
        add_action('wp_ajax_reserved_id', 'json_stockist_reserved_id');
        add_action('wp_ajax_stockist_bonus_register', 'ajax_save_stockist_registration_bonus');
    }
    
    private function _loadDefault()
    {
        $this->plugin_path = dirname(__FILE__);
        $this->plugin_libs =  $this->plugin_path.'/libs/';
        $this->plugin_uri  = plugin_dir_url(__FILE__);

        $include = array('type','install','query','stockist','metabox','register');

        foreach($include as $file){
            require_once $this->plugin_libs.'mc_'.$file.'.php';
        }
    }
        
    private function _load_table_list()
    {
        require $this->plugin_path.'/mc_stockist_table.php';
    }
    
    /**
     * places stockist menu under custom post type
     */
    public function registerAdminMenu()
    {        
        $this->menu_page = add_menu_page('Stockist', 'Stockist', 'manage_options', 'mc_stockist', 
                array(&$this,'panelAdminSettings'), $this->plugin_uri.'img/store-16.png',59);

        $this->register_default_page_hook($this->menu_page);

        $this->page['add'] = add_submenu_page('mc_stockist','New Stockist', 'Add Stockist', 'manage_options', 'mc_stockist_add', array(&$this,'panel_add'));
              
        $this->page['settings'] = add_submenu_page('mc_stockist','Stockist Settings', 'Settings', 'manage_options', 'mc_stockist_settings', array(&$this,'panelStockistSettings'));

        foreach($this->page as $key => $hook){
            $this->register_default_page_hook($hook);
            unset($key);
        }

    }

    public function register_default_page_hook($hook)
    {
        add_action( 'admin_print_styles-' . $hook, array(&$this,'admin_styles'));
        add_action('load-'.$hook,  array($this,'page_actions'),9);
        add_action('load-'.$hook,  array($this,'save_settings'),9);
        add_action('admin_footer-'.$hook, array($this,'footer_scripts'));
        add_action('admin_print_scripts-' . $hook, array(&$this,'admin_scripts') );

        switch($hook){
            case $this->page['add']:
                add_action('admin_print_scripts-' . $hook, array(&$this,'admin_scripts_add_stockist') );
                break;
            case $this->menu_page:
                add_action('list_stockist_body','mc_render_stockist_page');
                break;
        }
    }
    
    public function get_page()
    {        
        return $this->page;
    } 
    
	function footer_scripts()
    {
        $scripts = 'postboxes.add_postbox_toggles(pagenow);';
        $scripts .= 'jQuery(document).ready(function($){$(".fade").fadeOut(5000);});';
	   t('script',$scripts);
	}

    public function save_settings()
    {
        if (isset($_REQUEST['action'])){

            $req = foreach_push(new stdClass(), $_POST);

            switch($req->action){
                case SKTYPE::ACT_SETTINGS:
                    $this->process_action_settings($req);
                    break;
                case SKTYPE::ACT_NEW:
                    $this->process_action_register_stockist($req);
                    break;
            }
        } // end.isset($_REQUEST['action'])
    }

    /**
     *  process request for register new stockist page
     *
     *  @params     mixed|array     $req        $_REQUEST or $_POST array
     */
    public function process_action_register_stockist($req)
    {
        if (isset($req->section)){
            switch ($req->section){
                case 'add-stockist':
                    $this->section_add_stockist($req);
                    break;
            }
        }
    }

    /**
     *  process request for settings page
     *
     *  @params     mixed|array     $req        $_REQUEST or $_POST array
     */
    public function process_action_settings($req)
    {
        if (isset($req->section)){

            switch ($req->section){
                case 'country':
                    $this->section_country($req);
                    break;
                case 'state':
                    $this->section_state($req);
                    break;
                case 'district':
                    $this->section_district($req);
                    break;
                case 'usermeta-db':
                    $this->section_usermeta_db($req);
                    break;
            }
        }
    }

    /**
     * register new stockist
     * @todo add to stockist db
     */
    public function section_add_stockist($req)
    {
        $auto_generate_email = false;

        if (empty($req->user_email) ) {
            $req->user_email = mc_get_random_email();
            $this->_add_error(sprintf(SKTYPE::ERR_NO_EMAIL,$req->user_email));

            $auto_generate_email = true;
        }

        if (!empty($req->user_login)){

            if ( empty($user_id) == (username_exists($req->user_login)) ){
                $this->_add_error(sprintf(SKTYPE::ERR_LOGIN_EXISTS,$req->user_login));
            }
        }

        if (!empty($req->user_pass)){
            // check match
            if ($req->user_pass != $req->user_pass2){
                $this->_add_error(SKTYPE::ERR_PWD_UNMATCHED);
            }
        }

        $meta = array(
            'user_login'        => $req->user_login,
            'user_pass'         => $req->user_pass,
            'user_nicename'     => sanitize_user($req->user_login),
            'user_email'        => $req->user_email,
            'display_name'      => $req->nama_penuh,
            'nickname'          => $req->user_login,
            'user_registered'   => date("Y-m-d H:i:s"),
            'role'              => SKTYPE::ST_ROLE
        );

        foreach($meta as $key=> $value){
            if (empty($value)){
                $e = false;
                switch($key){
                    case 'display_name':$e = 'Full name';break;
                    case 'user_login':$e = 'Login name';break;
                    case 'user_pass':$e = 'Password';break;
                    default:$e = $key;break;
                }

                if ('user_nicename' != $e && $e !== 'nickname'){
                    $this->_add_error(sprintf(SKTYPE::ERR_EMPTY_FIELD, (string) $e));
                }
            }
        }

        if (!empty($this->errors)){

            if (count($this->errors) == 1 && $auto_generate_email == true){
                // there is one error, with auto generate email as fallback
                // we proceed with insert
                $this->_insert_user($meta, $req);
            }

        } else {
            $this->_insert_user($meta, $req);
        }

        if (is_int($this->last_uid)){

            /**
             * insert into stockist
             */
            $code_id = false;

            switch($req->stockist_type){
                case SKTYPE::ST_DISTRICT:
                        $code_id = (int) $req->daerah;
                    break;
                case SKTYPE::ST_STATE:
                        $code_id = (int) $req->negeri;
                    break;
                case SKTYPE::ST_HQ:
                        $code_id = (int)$req->negara;
                    break;
            }


            $stockist = array(
                'stockist_uid'  => $this->last_uid,
                'stockist_code' => $req->reserved_id,
                'type'          => $req->stockist_type,
                'prefix'        => get_stockist_prefix($req->stockist_type, $code_id),
                'status'        => 'active',
                'country_id'    => (int) $req->negara,
                'state_id'      => (int) $req->negeri,
                'district_id'   => (int) $req->daerah
            );

            $this->add_stockist($stockist);

            /**
             * insert into wp usermeta
             */

            $usermeta = array();

            // prepare usermeta data items, with default value
            foreach( SKTYPE::STR_A(SKTYPE::MK_ADD_NEW) as $key){
                if (isset($req->$key)){
                    $usermeta[$key] = $req->$key;
                }
            }

            /**
             * convert to to WP-CRM  data structure
             */
            foreach($usermeta as $meta_key => $value){

                switch($meta_key):
                    case 'negeri':
                            $state = str_nospace($req->state);
                            $meta_key = sprintf('%s_option_%s',$meta_key, $state);
                            $value = 'on';
                        break;
                    case 'negara':
                            $country = str_nospace($req->country);
                            $meta_key = sprintf('%s_option_%s',$meta_key, $country);
                            $value = 'on';
                        break;
                    case 'stockist_type':
                            $type = '';
                            switch($value){
                                case SKTYPE::ST_DISTRICT: $type = 'daerah';
                                    break;
                                case SKTYPE::ST_STATE: $type = 'negeri';
                                    break;
                                case SKTYPE::ST_MOBILE: $type = 'mobile';
                                    break;
                                case SKTYPE::ST_HQ: $type = 'hq';
                                    break;
                            }

                            $meta_key = sprintf('jenis_stokis_option_stokis-%s',$type);
                            $value = 'on';
                        break;
                    case 'id_penaja':
                        $value = strtoupper($value);
                        break;
                    case 'district': $value = (int) $req->daerah; break;
                    case 'state': $value = (int) $req->negeri; break;
                    case 'country': $value = (int) $req->negara; break;
                    case 'daerah': $value = $req->district; break;
                endswitch;

                update_user_meta( $this->last_uid, $meta_key, $value);

            } //end.foreach($usermeta)

            // id
            update_user_meta( $this->last_uid, 'account_id', $req->reserved_id );
            /**
             *  disabled admin bar
             */
            update_user_meta( $this->last_uid, 'show_admin_bar_admin', 'false' );
            update_user_meta( $this->last_uid, 'show_admin_bar_front', 'false' );

        } // end.is_int($this->last_uid)

        add_action('mc_notifications', array($this,'error_notifications'));

        wp_redirect(SKTYPE::URI_LIST_STOCKIST);
        exit();

    }


    public function add_stockist($meta, $format= array('%d','%s','%s','%s','%s','%d','%d','%d'))
    {   global $wpdb;

        $db = SKTYPE::DB(SKTYPE::DB_PRIMARY);

        $meta = apply_filters('before_insert_stockist', $meta);

        $wpdb->insert($db, $meta, $format);

        do_action('after_insert_stockist', $wpdb->insert_id, $meta);

    }

    private function _insert_user($meta, $req)
    {
        $meta = apply_filters('before_insert_stockist', $meta);

        $this->last_uid = wp_insert_user($meta);

        // wp return int of user_id on successful insert.
        if (is_int($this->last_uid) ){
            // active hook, user_register
            do_action('after_insert_stockist', $this->last_uid, array($meta,$req) );
        } else {
            do_action('failed_insert_stockist', $this->last_uid, array($meta,$req) );
        }

        return $this->last_uid;
    }

    private function _add_error($msg)
    {
        $this->errors[] = $msg;
    }

    public function error_notifications()
    {
        $htm = '';
        if (!empty($this->errors) && has_count($this->errors)){

            foreach($this->errors as $index => $msg){
                $htm .= _t('li', $msg);
            }

            $htm = _t('ol', $htm);
            $htm = _t('h3','Notice').$htm;

            t('div', _t('div',$htm, array('class'=>'block')), array('class'=>'error','id'=>'mc_notifications'));
        }


    }

    public function section_usermeta_db($req)
    {
        if (isset($req->mk_stockist_code) && !empty($req->mk_stockist_code) ){

            $options = get_option(SKTYPE::MK_USERMETA_SETTINGS, array());

            $meta_keys = array(
                'mk_stockist_code'          => 'account_id',
                'mk_stockist_hq_id'         => 'jenis_stokis_option_stokis-hq',
                'mk_stockist_state_id'      => 'jenis_stokis_option_stokis-negeri',
                'mk_stockist_district_id'   => 'jenis_stokis_option_stokis-daerah',
                'mk_stockist_mobile_id'     => 'jenis_stokis_option_stokis-mobile'
            );

            foreach ($meta_keys as $key => $default){
                if ($default != $req->$key){
                    $meta_keys[$key] = $req->$key;
                }
            }

            if ($options !== $meta_keys){
                update_option(SKTYPE::MK_USERMETA_SETTINGS, $meta_keys );
            }

            wp_redirect(SKTYPE::URI_PANEL_GSETTINGS);
            exit();
        }

        return false;
    }

    public function section_district($req)
    {
        if (isset($req->state_id) && !empty($req->district_name) ){

            foreach($req->district_id as $index => $id){

                $meta = array(
                    'state_id'  => $req->state_id[$index],
                    'name'      => $req->district_name[$index],
                    'hasc'      => $req->district_hsac[$index],
                    'postcode'  => $req->district_postcode[$index],
                    'division'  => $req->district_division[$index]
                );

                $this->insert_district_meta($meta);
            }
        }

        wp_redirect(SKTYPE::URI_PANEL_DSETTINGS);
        exit();
    }

    public function insert_district_meta($meta, $format = array('%d','%s','%s','%s','%s'))
    {   global $wpdb;

        $db = SKTYPE::DB(SKTYPE::DB_DISTRICT);

        $this->insert_id = $wpdb->insert($db, $meta, $format);

        if ($this->insert_id){
            do_action('insert_district_meta', $wpdb->insert_id, $meta, $_REQUEST);
            return $wpdb->insert_id;
        } else {
            return false;
        }
    }

    public function section_state($req)
    {
        if (isset($req->state_id) && !empty($req->state_name) ){

            foreach($req->state_id as $index => $id){

                $meta = array(
                    'country_id'=> $req->country_id[$index],
                    'name'      => $req->state_name[$index],
                    'iso'       => $req->state_iso[$index],
                    'hasc'      => $req->state_hsac[$index],
                    'postcode'  => $req->state_postcode[$index]
                );

                $this->insert_state_meta($meta);
            }
        }

        wp_redirect(SKTYPE::URI_PANEL_SSETTINGS);
        exit();
    }

    public function insert_state_meta($meta, $format = array('%d','%s','%s','%s','%s'))
    {   global $wpdb;

        $db = SKTYPE::DB(SKTYPE::DB_STATE);

        $this->insert_id = $wpdb->insert($db, $meta, $format);

        if ($this->insert_id){
            do_action('insert_state_meta', $wpdb->insert_id, $meta, $_REQUEST);
            return $wpdb->insert_id;
        } else {
            return false;
        }
    }

    /**
     * this method is call via ajax request
     * delete district by id
     */
    public function delete_district_by_id()
    {
        if (isset($_POST['action'])){

            $req = foreach_push(new stdClass(), $_POST);

            if ($req->action == SKTYPE::ACT_DEL_DISTRICT){
                global $wpdb;

                $db = SKTYPE::DB(SKTYPE::DB_DISTRICT);
                $id = (int) $req->district_id;
                $sql = "DELETE FROM $db WHERE district_id=%d";

                $result = $wpdb->query($wpdb->prepare($sql, $id));

                echo (($result) ? 1 : 0);
            }
        }
        exit();
    }

    public function delete_state_by_id()
    {
        if (isset($_POST['action'])){
            $req            = foreach_push(new stdClass(), $_POST);

            if ($req->action == SKTYPE::ACT_DEL_STATE){
                global $wpdb;

                $db = SKTYPE::DB(SKTYPE::DB_STATE);

                $sql = "DELETE FROM $db WHERE state_id=%d";

                $result = $wpdb->query($wpdb->prepare($sql, (int) $req->state_id));

                echo (($result) ? 1 : 0);
            }
        }
        exit();
    }

    public function section_country($req)
    {
        if (isset($req->country_id) && !empty($req->country_name) ){

            foreach($req->country_id as $index => $id){

                $meta = array(
                    'name'      => $req->country_name[$index],
                    'iso'       => $req->country_iso[$index]
                );

                $this->insert_country_meta($meta);
            }
        }
        wp_redirect(SKTYPE::URI_PANEL_CSETTINGS);
        exit();
    }

    public function delete_country_by_id()
    {
        if (isset($_POST['action'])){
            $req            = foreach_push(new stdClass(), $_POST);

            if ($req->action == SKTYPE::ACT_DEL_COUNTRY){
                global $wpdb;

                $db = SKTYPE::DB(SKTYPE::DB_COUNTRY);

                $sql = "DELETE FROM $db WHERE country_id=%d";

                $result = $wpdb->query($wpdb->prepare($sql, (int) $req->country_id));

                echo (($result) ? 1 : 0);
            }
        }
        exit();
    }

    public function insert_country_meta($meta, $format = array('%s','%s'))
    {   global $wpdb;

        $db = SKTYPE::DB(SKTYPE::DB_COUNTRY);

        $this->insert_id = $wpdb->insert($db, $meta, $format);

        if ($this->insert_id){
            do_action('insert_country_meta', $wpdb->insert_id, $meta, $_REQUEST);
            return $wpdb->insert_id;
        } else {
            return false;
        }
    }

    public function notice_update()
    {
        t('div',_t('p','Settings Updated!'),array('class'=>'updated fade'));
    }

   /**
	* Actions to be taken prior to page loading. This is after headers have been set.
    * call on load-$hook
	* This calls the add_meta_boxes hooks, adds screen options and enqueues the postbox.js script.   
	*/
	function page_actions()
    {
	   
        foreach($this->page as $hook => $name){
		  do_action('add_meta_boxes_'.$name, null);
		  do_action('add_meta_boxes', $name, null);
        }

		/* User can choose between 1 or 2 columns (default 2) */
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );

		/* Enqueue WordPress' script for handling the metaboxes */
		wp_enqueue_script('postbox'); 
	}    


    public function init_add_stockist_metabox()
    {   global $current_screen;
        $hook   = $this->page['add'];

        $country    = get_predefined_country();
        $states     = get_predefined_state();
        $districts  = get_predefined_district();

        $args       = array($country, $states, $districts);

        /** normal placement */
        $mid    = 'opt_login';
        $title  = 'Login Details';
        $cb     = 'mb_add_stockist_login_info';
        add_meta_box($mid, $title, $cb, $hook, 'normal', 'high', $args);

        $mid    = 'opt_contact';
        $title  = 'Contact Information';
        $cb     = 'mb_add_stockist_contact_info';
        add_meta_box($mid, $title, $cb, $hook, 'normal', 'high', $args);

        $mid    = 'opt_bank';
        $title  = 'Registrant Bank Acc. Information';
        $cb     = 'mb_add_stockist_bank_info';
        add_meta_box($mid, $title, $cb, $hook, 'normal', 'default', $args);


        /** side placement */
        $mid    = 'opt_submit_btn';
        $title  = 'Actions';
        $cb     = 'mb_add_stockist_actions';
        add_meta_box($mid, $title, $cb, $hook, 'side', 'high', $args);

        $mid    = 'opt_stockist_type';
        $title  = 'Account Type';
        $cb     = 'mb_add_stockist_type';
        add_meta_box($mid, $title, $cb, $hook, 'side', 'default', $args);

        $mid    = 'opt_stockist_sponsor';
        $title  = 'Sponsor';
        $cb     = 'mb_add_stockist_sponsor';
        add_meta_box($mid, $title, $cb, $hook, 'side', 'low', $args);

        /** help screen */
        if ($current_screen->id == $hook){
            $this->add_help_tab(array(
                'id'     => 'help_login',
                'title' => 'Login',
                'content' => _t('p','Login Name, Kata Laluan bagi pengguna untuk masuk.')
            ));
        }


    }

    public function init_settings_metabox()
    {
        $hook       = $this->page['settings'];
        $default    = $this->get_default_db_settings();
        $settings   = get_option(SKTYPE::MK_USERMETA_SETTINGS);
        $options    = array($settings,$default);

        if (isset($_REQUEST['panel'])){

            $country    = get_predefined_country();
            $states     = get_predefined_state();
            $districts  = get_predefined_district();

            $args       = array($country, $states, $districts);

            switch($_REQUEST['panel']){
                case SKTYPE::PANEL_COUNTRY:
                    $this->country_settings_metabox($hook, $args);
                    break;
                case SKTYPE::PANEL_STATE:
                    $this->state_settings_metabox($hook, $args);
                    break;
                case SKTYPE::PANEL_DISTRICT:
                    $this->district_settings_metabox($hook, $args);
                    break;
                default:
                    $this->default_settings_metabox($hook, $options);
                    break;
            }
        } else { // load for general settings
            $this->default_settings_metabox($hook, $options);
        }
    }

    public function get_default_db_settings()
    {
        $options = get_option(SKTYPE::MK_DEFAULT_SETTINGS, false);

        if (empty($options)){
            $options = array(
                'mk_stockist_code'          => 'account_id',
                'mk_stockist_hq_id'         => 'jenis_stokis_option_stokis-hq',
                'mk_stockist_state_id'      => 'jenis_stokis_option_stokis-negeri',
                'mk_stockist_district_id'   => 'jenis_stokis_option_stokis-daerah',
                'mk_stockist_mobile_id'     => 'jenis_stokis_option_stokis-mobile'
            );

            add_option(SKTYPE::MK_DEFAULT_SETTINGS, $options );
        }

        return $options;
    }

    public function default_settings_metabox($hook, $args)
    {
        /* main screen normal */
        $mid    = 'opt_general_options';
        $title  = 'Database Settings';
        $cb     = 'mb_view_stockist_general_options';
        add_meta_box($mid, $title, $cb, $hook, 'normal', 'high', $args);

        /*  side screen normal */
        $mid    = 'opt_stockist_register_bonus';
        $title  = 'Stockist Registration Bonus';
        $cb     = 'mb_view_stockist_register_bonus_options';
        add_meta_box($mid, $title, $cb, $hook, 'side', 'high', $args);

        $mid    = 'opt_stockist_sales_bonus';
        $title  = 'Stockist Sales Bonus';
        $cb     = 'mb_view_stockist_sales_bonus_options';
        add_meta_box($mid, $title, $cb, $hook, 'side', 'low', $args);

        if ($_REQUEST['page'] == 'mc_stockist_settings'){

            if (isset($_REQUEST['panel'])){
                if ($_REQUEST['panel'] == 'general-settings'){
                    wp_enqueue_script( 'general-settings' );
                }
            } else {
                wp_enqueue_script( 'general-settings' );
            }

        }



    }

    public function district_settings_metabox($hook, $args)
    {
        add_meta_box('options_district','Districts', 'mb_view_district', $hook, 'normal', 'high', $args);
        add_meta_box('options_district_summary','Stockists by Districts', 'mb_view_district_summary', $hook, 'side', 'high', $args);
        // help screen
        $this->default_help_resources();

        $this->add_help_tab(array(
            'id'     => 'help_district_resource',
            'title' => 'District',
            'content' => _t('p','Malaysia district info please check this external <a href="http://www.statoids.com/ymy.html">page</a>.')
        ));
    }

    public function state_settings_metabox($hook, $args)
    {
        add_meta_box('options_state','State by Countries', 'mb_view_state', $hook, 'normal', 'high', $args);
        add_meta_box('options_state_summary','Stockists by States', 'mb_view_state_summary', $hook, 'side', 'high', $args);
        // help screen
        $this->default_help_resources();
    }

    public function country_settings_metabox($hook, $args)
    {
        /* main screen normal */
        $mid    = 'opt_country';
        $title  = 'List of Countries';
        $cb     = 'mb_view_country';
        add_meta_box($mid, $title, $cb, $hook, 'normal', 'high', $args);

        /**
         * disabled
         * fixes issue #1, changeset 63d820a6dc30
         */
        //add_meta_box('opt_country_debug','Debug', 'mb_view_country_summary_debug', $hook, 'advanced', 'default');

        /* sidebar */
        $mid    = 'opt_country_summary';
        $title  = 'Stockists by Countries';
        $cb     = 'mb_view_country_summary';
        add_meta_box($mid, $title, $cb, $hook, 'side', 'high', $args);

        /* help screen */
        $this->default_help_resources();
    }

    public function add_help_tab($args=array('id','title','content'))
    {
        $screen = get_current_screen();
        $screen->add_help_tab($args);
    }

    public function default_help_resources()
    {
        $this->add_help_tab( array(
            'id'	=> 'help_ext_resources',
            'title'	=> 'Resource',
            'content'	=> '<p>' . __( 'for more info regarding iso & hsac code please checkout this <a href="//www.statoids.com/umy.html">page</a>.' ) . '</p>',
        ) );
    }
    
    public function admin_stylesheets()
    {
        wp_register_style( 'mc_base_stylesheet', plugins_url('/libs/stylesheet.css', __FILE__), array('font-awesome') );
    }

    public function register_admin_scripts()
    {
        $src = plugins_url('/js/jquery.maskedinput-1.3.min.js', __FILE__);
        wp_register_script('jquery-mask', $src, array('jquery'),false,true);

        $src = plugins_url('/js/form-validation.js', __FILE__);
        wp_register_script('stockist-validation', $src, array('jquery'),false,true);

        $src = plugins_url('/js/general-settings.js', __FILE__);
        wp_register_script('general-settings', $src, array('jquery','jquery-mask'),false,true);

    }
    
    public function admin_styles()
    {
       wp_enqueue_style( 'thickbox' );
       wp_enqueue_style( 'mc_base_stylesheet' );
    }

    public function admin_scripts()
    {
        wp_enqueue_script( 'thickbox' );
    }

    public function admin_scripts_add_stockist()
    {
        wp_enqueue_script( 'jquery-mask' );
        wp_enqueue_script( 'stockist-validation' );
    }

    public function panel_add()
    {
       require $this->plugin_path.'/panels/add_stockist.php';
    }

    public function panelStockistSettings()
    {
        require $this->plugin_path.'/panels/settings.php';        
    }
    
    public function panelAdminSettings()
    {
        require dirname(__FILE__).'/panels/lists.php';
    }
    
    public function get_data($type)
    {
        switch($type){
            case 'state':
                $stockist = $this->get_state_stockist();
                return $stockist->user;
            break;
            case 'all':
                $stockist = $this->get_all_stockist();
                return $stockist->user;
            break;            
        }    
    }

    /**
     * List all stockist
     */
    public function get_all_stockist()
    {   global $wpdb;        
        
        $stockist = new stdClass();
        
        $table = $wpdb->usermeta;
        
        $sql = "SELECT `user_id` FROM $table WHERE `meta_key`=%s ORDER BY `user_id` DESC";
        
        $results = $wpdb->get_results($wpdb->prepare($sql, SKTYPE::MK_USERTYPE_STOCKIST));
        
        if (!$results) return SKTYPE::ERR_NO_STATE_STOCKIST;
            
        // check return array for our loop            
        if ( has_count($results) ){
            
            $stockist->count = count($results);
            $stockist->user = array();
            
            foreach($results as $index => $user){
                $id = (int) $user->user_id;
                
                $code = mc_get_userinfo($id, 'code');
                
                $stockist->user[] = array(
                    'id'        => $id,
                    'code'      => $code,
                    'type'      => ucwords(mc_get_userinfo($id,'stockist_type')),
                    'name'      => mc_get_userinfo($id, 'name'),
                    'tel'       => mc_get_userinfo($id, 'tel'),
                    'city'      => mc_get_userinfo($id, 'city'),
                    'state'     => mc_get_userinfo($id, 'state'),
                    'country'     => mc_get_userinfo($id, 'country'),
                    'date'      => mc_get_userinfo($id, 'register_date'),
                    'total_members' => count_stockist_members($code),
                    'total_sales' => total_stockist_sales($id),
                    'sales_count' => count_stockist_sales($id),
                    'sales_average' => average_stockist_sales($id)                                        
                    );
                
            }
        }
        
       return $stockist;
        
    }
        
    /**
     * List all state stockist
     */
    public function get_state_stockist()
    {   global $wpdb;
        
        
        $stockist = new stdClass();
        
        $table = $wpdb->usermeta;
        
        $sql = "SELECT user_id FROM $table WHERE `meta_key`=%s ORDER BY `user_id` DESC";
        
        $results = $wpdb->get_results($wpdb->prepare($sql, SKTYPE::MK_STATE_STOCKIST));
        
        if (! $results) return SKTYPE::ERR_NO_STATE_STOCKIST;
            
        // check return array for our loop            
        if ( has_count($results) ){
            
            $stockist->count = count($results);
            $stockist->user = array();
            
            foreach($results as $index => $user){
                $id = (int) $user->user_id;
                
                $code = mc_get_userinfo($id, 'code');
                
                $stockist->user[] = array(
                    'id'        => $id,
                    'code'      => $code,
                    'name'      => mc_get_userinfo($id, 'name'),
                    'tel'       => mc_get_userinfo($id, 'tel'),
                    'city'      => mc_get_userinfo($id, 'city'),
                    'state'     => mc_get_userinfo($id, 'state'),
                    'country'     => mc_get_userinfo($id, 'country'),
                    'date'      => mc_get_userinfo($id, 'register_date'),
                    'total_members' => count_stockist_members($code),
                    'total_sales' => total_stockist_sales($id),
                    'sales_count' => count_stockist_sales($id),
                    'sales_average' => average_stockist_sales($id)
                                        
                    );
                
            }
        }
        
       return $stockist;
        
    }
}

$stockist = new Stockist();

/** plugin setup installation, run once */
register_activation_hook( __FILE__ , 'mc_stockist_activate');
function mc_stockist_activate(){	mc_stockist_install_db(); }