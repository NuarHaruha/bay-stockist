<?php
/**
 * stockist add new panel
 * Date: 12/5/12
 * Time: 1:44 PM
 */
?>
<div class="wrap stockist add-stockist">
    <div id="icon-people" class="icon32"></div>
    <h2 class="">New Stockist</h2>
    <?php settings_errors(); ?>
    <?php do_action('mc_notifications',$_REQUEST);?>
    <form id="stockist_add" name="stockist_add" method="post">
        <input type="hidden" name="action" value="<?php echo SKTYPE::ACT_NEW;?>">
        <?php wp_nonce_field(SKTYPE::NONCES_STOCKIST);
        /* Used to save closed meta boxes and their order */
        wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
        wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
        <!-- Rest of admin page here -->
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">
                <div id="post-body-content">
                    <?php do_action('stockist_add_body') ?>
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