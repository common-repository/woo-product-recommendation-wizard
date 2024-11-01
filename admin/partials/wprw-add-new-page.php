<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
global $wpdb;

//die(); 
$wizard_id = empty($_REQUEST['wrd_id']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['wrd_id']));
$question_id = empty($_REQUEST['id']) ? '' : sanitize_text_field(wp_unslash(['id']));
$retrieved_nonce = empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['_wpnonce']));

if (isset($_POST['submitWizard']) && sanitize_text_field(wp_unslash($_POST['submitWizard'])) == ADD_NEW_WIZARD_SAVE_BUTTON_NAME) {
    $post = $_POST;
    if (!wp_verify_nonce($retrieved_nonce, 'wizardfrm')) {
        die('Failed security check');
    } else {
        $this->wprw_wizard_save($post);
    }
} elseif (isset($_POST['submitWizard']) && sanitize_text_field(wp_unslash($_POST['submitWizard'])) == EDIT_NEW_WIZARD_SAVE_BUTTON_NAME) {
    $post = $_POST;
    if (!wp_verify_nonce($retrieved_nonce, 'wizardfrm')) {
        die('Failed security check');
    } else {
        $this->wprw_wizard_save($post);
    }
}

if (isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) == 'edit') {
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $btnValue = __(EDIT_NEW_WIZARD_SAVE_BUTTON_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
        $wizard_table_name = WIZARDS_TABLE;
        $get_qry = $wpdb->prepare('SELECT * FROM ' . $wizard_table_name . ' WHERE id=%d', $wizard_id);
        $get_rows = $wpdb->get_row($get_qry);
        if (!empty($get_rows) && isset($get_rows)) {
            $get_wizard_id = esc_attr($get_rows->id);
            $wizard_title = esc_attr($get_rows->name);
            $wizard_shortcode = esc_attr($get_rows->shortcode);
            $wizard_status = esc_attr($get_rows->status);
        }
    }
} else {
    $btnValue = __(ADD_NEW_WIZARD_SAVE_BUTTON_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
    $current_auto_incr_id = $this->get_current_auto_increment_id(WIZARDS_TABLE);

    $wizard_title = '';
    $wizard_shortcode = $this->create_wizard_shortcode($current_auto_incr_id);
    $wizard_status = '';
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete') {
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $questions_table_name = QUESTIONS_TABLE;
        $delete_sql = $wpdb->delete($questions_table_name, array('id' => esc_attr($question_id), 'wizard_id' => esc_attr($wizard_id)), array('%d', '%d'));
        if ($delete_sql == '1') {
            wp_redirect(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&id=' . esc_attr($wizard_id) . '&action=edit&_wpnonce=' . esc_attr($retrieved_nonce)));
            exit;
        } else {
            echo 'Error Happens.Please try again';
            wp_redirect(home_url('/wp-admin/admin.php?page=wprw-question-list&wrd_id=' . esc_attr($wizard_id . '')));
        }
    }
}

if (isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) == 'edit') {
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $questions_table_name = QUESTIONS_TABLE;
        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id=%d ORDER BY id ASC LIMIT  0,2', $wizard_id);
        $sel_rows = $wpdb->get_results($sel_qry);
    }
}
?>
<div class="wprw-main-table res-cl">
    <h2><?php _e('Wizard Configuration', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></h2>
    <form method="POST" name="wizardfrm" action="">
        <?php wp_nonce_field('wizardfrm'); ?>
        <input type="hidden" name="wizard_post_id" value="<?php echo esc_attr($wizard_id); ?>">
        <table class="form-table table-outer product-fee-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_title"><?php _e(WPRW_WIZARD_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label></th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wizard_title" class="text-class half_width" id="wizard_title" value="<?php echo!empty(esc_attr($wizard_title)) ? esc_attr($wizard_title) : ''; ?>" required="1" placeholder="<?php _e(WPRW_WIZARD_TITLE_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>">
                        <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php _e(WPRW_WIZARD_TITLE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_category"><?php _e(WPRW_WIZARD_CATEGORY_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label></th>
                    <td class="forminp mdtooltip">
                        <img src="<?php echo esc_url(WPRW_CATEGORY_PRO_IMG); ?>" onclick="alert('<?php echo WPRW_PRO_VERSION_TEXT; ?>');"/>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_shortcode"><?php _e(WPRW_WIZARD_SHORTCODE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <div class="product_cost_left_div">
                            <input type="text" name="wizard_shortcode" required="1" class="text-class" id="wizard_shortcode" value="<?php echo!empty(esc_attr($wizard_shortcode)) ? esc_attr($wizard_shortcode) : ''; ?>" readonly>
                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php _e(WPRW_WIZARD_SHORTCODE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_status"><?php _e(WPRW_WIZARD_STATUS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label></th>
                    <td class="forminp mdtooltip">
                        <label class="switch">
                            <input type="checkbox" name="wizard_status" value="on" <?php echo (!empty(esc_attr($wizard_status)) && esc_attr($wizard_status) == 'off') ? '' : 'checked'; ?>>
                            <div class="slider round"></div>
                        </label>
                    </td>
                </tr>	
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submitWizard" class="button button-primary button-large" value="<?php echo esc_html($btnValue); ?>"></p>
    </form>

    <?php
    if (isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) == 'edit') {
        ?>
        <div class="product_header_title">
            <h2>
                <?php _e(WPRW_QUESTION_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                <a class="add-new-btn"  href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . esc_attr($wizard_id) . '&_wpnonce=' . esc_attr($retrieved_nonce))); ?>"><?php _e(WPRW_ADD_NEW_QUESTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                <a id="detete_all_selected_question" class="detete-conditional-fee button-primary"  disabled="disabled"><?php _e(WPRW_DELETE_QUESTION_LIST_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
            </h2>
        </div>
        <div id="using_ajax">

        </div>
        <?php
    }
    ?>
</div>
<?php
require_once('header/plugin-sidebar.php');
?>