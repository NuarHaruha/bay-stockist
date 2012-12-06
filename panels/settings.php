<div class="wrap stockist stockist-settings">
<?php if (!isset($_REQUEST['panel'])): settings_tabs(); else: settings_tabs($_REQUEST['panel']); endif; ?>
    <?php settings_errors(); ?> 
    <?php do_action('mc_notifications',$_REQUEST);?>
    <form name="stockist_settings" method="post">
    <input type="hidden" name="action" value="<?php echo SKTYPE::ACT_SETTINGS;?>">
    <?php wp_nonce_field( 'mc-action-stockist' );
    /* Used to save closed meta boxes and their order */
    wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
    wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
    <!-- Rest of admin page here -->
    
				<div id="poststuff">
		
					 <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>"> 

						  <div id="post-body-content">
							<?php //call_user_func('sh_example_body_content'); ?>                                
						  </div>    

						  <div id="postbox-container-1" class="postbox-container">
						        <?php do_meta_boxes('','side',null); ?>
						  </div>    

						  <div id="postbox-container-2" class="postbox-container">
						        <?php do_meta_boxes('','normal',null);  ?>
						        <?php do_meta_boxes('','advanced',null); ?>
						  </div>
					 </div> <!-- #post-body -->
				 </div> <!-- #poststuff -->
    </form>
</div>