<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
global $wpdb;
$wizard_post_id = empty($_REQUEST['wrd_id']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['wrd_id']));
$retrieved_nonce = empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['_wpnonce']));

if (isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) == 'delete') {
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $wizard_table_name = WIZARDS_TABLE;
        $delete_sql = $wpdb->delete($wizard_table_name, array('id' => esc_attr($wizard_post_id)), array('%d'));
        if ($delete_sql = '1') {
            wp_redirect(esc_url(home_url('/wp-admin/admin.php?page=wprw-list')));
            exit;
        } else {
            echo 'Error Happens.Please try again';
            wp_redirect(esc_url(home_url('/wp-admin/admin.php?page=wprw-list')));
        }
    }
}
$wizard_table_name = WIZARDS_TABLE;
$sel_qry = $wpdb->prepare('SELECT * FROM ' . $wizard_table_name . ' ORDER BY created_date', '');
$sel_rows = $wpdb->get_results($sel_qry);

wp_nonce_field('delete');
?>
<div class="wprw-main-table res-cl">
    <div class="product_header_title">
        <h2>
            <?php _e(WPRW_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
            <a class="add-new-btn"  href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-add-new')); ?>"><?php _e(WPRW_ADD_NEW_WIZARD, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
            <a id="detete_all_selected_wizard" class="detete_all_select_wizard_list button-primary" href="javascript:void(0);" disabled="disabled"><?php _e(WPRW_DELETE_LIST_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
        </h2>
    </div>
    <table id="wizard-listing" class="table-outer form-table all-table-listing tablesorter">
        <thead>
            <tr class="wprw-head">
                <th><input type="checkbox" name="check_all" class="chk_all_wizard_class" id="chk_all_wizard"></th>
                <th><?php _e('Name', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Shortcode', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Status', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
                <th><?php _e('Action', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sel_rows) && isset($sel_rows)) {
                $i = 1;
                foreach ($sel_rows as $sel_data) {
                    $wizard_id = esc_attr($sel_data->id);
                    $wizard_title = esc_attr($sel_data->name);
                    $wizard_shortcode = esc_attr($sel_data->shortcode);
                    $wizard_status = esc_attr($sel_data->status);
                    $wprwnonce = wp_create_nonce('wppfcnonce');
                    ?>
                    <tr id="wizard_row_<?php echo $wizard_id; ?>">
                        <td width="10%">
                            <input type="checkbox" class="chk_single_wizard" name="chk_single_wizard_chk" value="<?php echo esc_attr($wizard_id); ?>">
                        </td>
                        <td>
                            <a href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . esc_attr($wizard_id) . '&action=edit' . '&_wpnonce=' . esc_attr($wprwnonce))); ?>"><?php _e($wizard_title, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </td>
                        <td>
                            <?php echo esc_attr($wizard_shortcode); ?>
                        </td>
                        <td>
                            <?php echo (!empty(esc_attr($wizard_status)) && esc_attr($wizard_status) == 'on') ? '<span class="active-status">' . _e('Enabled', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</span>' : '<span class="inactive-status">' . _e('Disabled', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</span>'; ?>
                        </td>
                        <td>
                            <a class="fee-action-button button-primary" href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . esc_attr($wizard_id) . '&action=edit' . '&_wpnonce=' . esc_attr($wprwnonce))); ?>"><?php _e('Edit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                            <a class="fee-action-button button-primary delete_single_selected_wizard" href="javascript:void(0);" id="delete_single_selected_wizard_<?php echo esc_attr($wizard_id); ?>" data-attr_name="<?php echo esc_attr($wizard_title); ?>"><?php _e('Delete', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">
                        <?php _e('No List Available', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php require_once('header/plugin-sidebar.php'); ?>