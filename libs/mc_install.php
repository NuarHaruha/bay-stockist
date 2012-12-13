<?php
/**
 * mc_stockist_install_db()
 * setup our database, this function should be
 * run on plugin active
 * 
 * @author  Nuarharuha <nhnoah+bay-isra@gmail.com>
 * @since   1.2
 * @return  void
 */	
function mc_stockist_install_db(){
    global $wpdb;
    
    $db = $primary_db = SKTYPE::DB(SKTYPE::DB_PRIMARY);

	if($wpdb->get_var("SHOW TABLES LIKE '".$db."'") != $db || SKTYPE::VERSION() < SKTYPE::DB_VERSION )
    {
	   /**
	    * used KEY instead of INDEX for adding
        * INDEX.
	    */
	   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
       
		$sql = "CREATE TABLE " . $db . " (
			  id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
              stockist_uid BIGINT(20) unsigned NOT NULL,
              stockist_code VARCHAR(255) NOT NULL,
              type ENUM('state','district','mobile','hq') NOT NULL,
			  prefix VARCHAR(10) NOT NULL,              
              status ENUM('active','inactive') DEFAULT 'active',              
              country_id BIGINT(20) unsigned NOT NULL,
              state_id BIGINT(20) unsigned NOT NULL,
              district_id BIGINT(20) unsigned NOT NULL,              
			  PRIMARY KEY id (id),
              KEY status (status)
			) ENGINE=INNODB;";            
          
        dbDelta($sql);
        
        /**
         *  add foreign key for our primary table
         */
        $users_table = $wpdb->users;
        $sql = "ALTER TABLE $db 
                ADD FOREIGN KEY (stockist_uid) REFERENCES $users_table(ID)
                      ON DELETE CASCADE;";
                      
        $wpdb->query($sql);         
        
        /**
         *  Meta table for stockist
         *  @link http://www.statoids.com/umy.html HASC code
         */
       $db = SKTYPE::DB(SKTYPE::DB_PRIMARY_META);
       
       if($wpdb->get_var("SHOW TABLES LIKE '".$db."'") != $db){       
    		$sql = "CREATE TABLE " . $db . " (
    			  id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,  
                  stockist_id BIGINT(20) unsigned NOT NULL,  			  
                  meta_key VARCHAR(255) DEFAULT NULL,
                  meta_value LONGTEXT,
                  PRIMARY KEY (id),                  
                  KEY meta_key (meta_key)
    			) ENGINE=INNODB;";
                
            dbDelta($sql);                     
        }
        
        $sql = "ALTER TABLE $db 
                ADD FOREIGN KEY (stockist_id) REFERENCES $primary_db(id)
                      ON DELETE CASCADE;";
                      
        $wpdb->query($sql);
        
        /**
         *  Country table
         */
       $db = $country_db = SKTYPE::DB(SKTYPE::DB_COUNTRY);;
       
       if($wpdb->get_var("SHOW TABLES LIKE '".$db."'") != $db){       
    		$sql = "CREATE TABLE " . $db . " (
    			  country_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                  name VARCHAR(255) NOT NULL,    			  			  
                  iso VARCHAR(2) NOT NULL,
    			  PRIMARY KEY id (country_id)
    			) ENGINE=INNODB;";                
              
            dbDelta($sql);
        
            /**
             * alter primary stockist db add country reference
             */
            $sql = "ALTER TABLE $primary_db 
                    ADD FOREIGN KEY (country_id) REFERENCES $country_db(country_id)
                          ON UPDATE CASCADE;";               
            $wpdb->query($sql);

            $sql = "ALTER TABLE $db
                    ADD UNIQUE (name),
                    ADD UNIQUE (iso);";
            $wpdb->query($sql);

       }
      
        /**
         *  State table
         *  @link http://www.statoids.com/umy.html HASC code
         */
       $db = $state_db = SKTYPE::DB(SKTYPE::DB_STATE);
       
       if($wpdb->get_var("SHOW TABLES LIKE '".$db."'") != $db){       
    		$sql = "CREATE TABLE " . $db . " (
    			  state_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                  country_id BIGINT(20) unsigned NOT NULL,
                  name VARCHAR(255) NOT NULL,    			  			  
                  iso VARCHAR(2) DEFAULT NULL,
                  hasc VARCHAR(32) DEFAULT NULL,
                  postcode LONGTEXT,
    			  PRIMARY KEY id (state_id)
    			) ENGINE=INNODB;";
            dbDelta($sql);                     
        }
        
        $sql = "ALTER TABLE $db 
                ADD FOREIGN KEY (country_id) REFERENCES $country_db(country_id)
                      ON DELETE CASCADE;";
                      
        $wpdb->query($sql);

        $sql = "ALTER TABLE $db
                    ADD UNIQUE (name),
                    ADD UNIQUE (iso),
                    ADD UNIQUE (hasc);";
        $wpdb->query($sql);
        
        /**
         *  District table
         *  @link http://www.statoids.com/umy.html HASC code
         */
       $db = SKTYPE::DB(SKTYPE::DB_DISTRICT);
       
       if($wpdb->get_var("SHOW TABLES LIKE '".$db."'") != $db){       
    		$sql = "CREATE TABLE " . $db . " (
    			  district_id BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                  state_id BIGINT(20) unsigned NOT NULL,
                  name VARCHAR(255) NOT NULL,  
                  hasc VARCHAR(32) NOT NULL,
                  postcode LONGTEXT,
                  division VARCHAR(255),
    			  PRIMARY KEY id (district_id)
    			) ENGINE=INNODB;"; 
                
            dbDelta($sql);                     
        }
        
        $sql = "ALTER TABLE $db 
                ADD FOREIGN KEY (state_id) REFERENCES $state_db(state_id)
                      ON DELETE CASCADE;";
                      
        $wpdb->query($sql);             
                  
                
        add_option(SKTYPE::MK_DB_VERSION, SKTYPE::DB_VERSION);   
	}    
}
/** mc_stockist_install_db() */