<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
global $wpdb;

$wizard_id = empty($_REQUEST['wrd_id']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['wrd_id']));
$question_id = empty($_REQUEST['que_id']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['que_id']));
$options_id = empty($_REQUEST['opt_id']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['opt_id']));
$retrieved_nonce = empty($_REQUEST['_wpnonce']) ? '' : sanitize_text_field(wp_unslash($_REQUEST['_wpnonce']));

if (isset($_POST['submitWizardQuestion']) && $_POST['submitWizardQuestion'] == ADD_NEW_QUESTION_SAVE_BUTTON_NAME) {
    $post = $_POST;
    if (!wp_verify_nonce($retrieved_nonce, 'wizardquestionfrm')) {
        die('Failed security check');
    } else {
        $this->wprw_wizard_question_save($post, $wizard_id);
    }
} elseif (isset($_POST['submitWizardQuestion']) && $_POST['submitWizardQuestion'] == EDIT_NEW_QUESTION_SAVE_BUTTON_NAME) {
    $post = $_POST;
    if (!wp_verify_nonce($retrieved_nonce, 'wizardquestionfrm')) {
        die('Failed security check');
    } else {
        $this->wprw_wizard_question_save($post, $wizard_id);
    }
}

if (isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) == 'edit') {
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce'))
        die('Failed security check');
    $btnValue = __(EDIT_NEW_QUESTION_SAVE_BUTTON_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
    $questions_table_name = QUESTIONS_TABLE;
    $get_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE id=%d AND wizard_id=%d', array($question_id, $wizard_id));
    $get_rows = $wpdb->get_row($get_qry);
    if (!empty($get_rows) && isset($get_rows)) {
        $get_wizard_id = esc_attr($get_rows->id);
        $question_name = esc_attr($get_rows->name);
        $question_type = esc_attr($get_rows->option_type);
    }
} else {
    $btnValue = __(ADD_NEW_QUESTION_SAVE_BUTTON_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN);
    $question_name = '';
    $question_type = '';
}

if (isset($_REQUEST['action']) && sanitize_text_field(wp_unslash($_REQUEST['action'])) == 'delete') {
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $questions_table_name = QUESTIONS_TABLE;
        $delete_sql = $wpdb->delete($questions_table_name, array('id' => esc_attr($question_id), 'wizard_id' => esc_attr($wizard_id)), array('%d', '%d'));
        if ($delete_sql == '1') {
            wp_redirect(esc_url(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&id=' . esc_attr($wizard_id) . '&action=edit&_wpnonce=' . esc_attr($retrieved_nonce))));
            exit;
        } else {
            echo 'Error Happens.Please try again';
            wp_redirect(esc_url(home_url('/wp-admin/admin.php?page=wprw-question-list&wrd_id=' . esc_attr($wizard_id) . '')));
        }
    }
}

################# Options save ######################
if (isset($_POST['submitOptions']) && sanitize_text_field(wp_unslash($_POST['submitOptions'])) == 'Submit') {
    $post = $_POST;
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $this->wprw_wizard_options_save($post, $wizard_id, $question_id);
    }
} elseif (isset($_POST['submitOptions']) && sanitize_text_field(wp_unslash($_POST['submitOptions'])) == 'Update') {
    $post = $_POST;
    if (!wp_verify_nonce($retrieved_nonce, 'wppfcnonce')) {
        die('Failed security check');
    } else {
        $this->wprw_wizard_options_save($post, $wizard_id, $question_id);
    }
}

$questions_options_table_name = OPTIONS_TABLE;
$sel_options_qry = $wpdb->prepare('SELECT * FROM ' . $questions_options_table_name . ' WHERE wizard_id=%d AND question_id=%d ORDER BY sortable_id ASC', array($wizard_id, $question_id));
$sel_options_rows = $wpdb->get_results($sel_options_qry);
$total_options_count = count($sel_options_rows);
if ($total_options_count != "0" && $total_options_count != "") {
    $total_options_count = count($total_options_count);
} else {
    $total_options_count = '0';
}

$testObject = new Woo_Product_Recommendation_Wizard_Admin($this->plugin_name, $this->version);

$attributeNameArray = explode(',', $testObject->get_woocommerce_product_attribute_name_list($wizard_id));
$fetchSelecetedAttributeName = !empty($attributeNameArray) ? $attributeNameArray : '';
?>
<div class="wprw-main-table res-cl">
    <h2>
        <?php _e('Question Configuration', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
        <a class="add-new-btn back-button"  id="back_button" href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-list')); ?>"><?php _e(WPRW_BACK_TO_WIZARD_LIST, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
        <a class="add-new-btn back-button"  id="back_button" href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . esc_attr($wizard_id) . '&action=edit&_wpnonce=' . esc_attr($retrieved_nonce))); ?>"><?php _e(WPRW_BACK_TO_EDIT_WIZARD_CONFIGURATION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
    </h2>
    <form method="POST" name="wizardquestionfrm" action="" id="wizardquestionfrm">
        <?php wp_nonce_field('wizardquestionfrm'); ?>
        <input type="hidden" name="question_id" value="<?php echo esc_attr($question_id) ?>">
        <table class="form-table table-outer question-table all-table-listing">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="question_name"><?php _e(WPRW_WIZARD_QUESTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="question_name" class="text-class half_width" id="question_name" value="<?php echo!empty(esc_attr($question_name)) ? esc_attr($question_name) : ''; ?>" required="1" placeholder="<?php _e(WPRW_WIZARD_QUESTION_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>">
                        <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php _e(WPRW_WIZARD_QUESTION_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="question_type"><?php _e(WPRW_WIZARD_QUESTION_TYPE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <select name="question_type" id="question_type">
                            <option value="radio" <?php echo!empty(esc_attr($question_type)) && esc_attr($question_type) == 'radio' ? 'selected="selected"' : '' ?>><?php _e(WPRW_WIZARD_QUESTION_TYPE_RADIO, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></option>
                            <option value="radio" onclick="alert('Its only pro version')"><?php _e(WPRW_WIZARD_QUESTION_TYPE_CHECKBOX, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></option>
                        </select>
                        <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description">
                            <?php _e(WPRW_WIZARD_QUESTION_TYPE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="option_header_title" id="option_header_title">
            <h2>
                <?php _e(WPRW_OPTIONS_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                <a class="add-new-btn"  id="add_new_options" href="javascript:void(0);"><?php _e(WPRW_ADD_NEW_OPTIONS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
            </h2>
        </div>

        <div id="accordion" class="accordian_custom_class">
            <?php
            if (!empty($sel_options_rows) && $sel_options_rows != '' && isset($sel_options_rows)) {
                foreach ($sel_options_rows as $sel_options_data) {
                    $options_id = sanitize_text_field($sel_options_data->id);
                    $wizard_id = sanitize_text_field($sel_options_data->wizard_id);
                    $question_id = sanitize_text_field($sel_options_data->question_id);
                    $option_name = sanitize_text_field($sel_options_data->option_name);
                    $option_attribute = sanitize_text_field($sel_options_data->option_attribute);
                    $option_attribute_value = explode(',', sanitize_text_field($sel_options_data->option_attribute_value));
                    $wcpfcnonce = wp_create_nonce('wppfcnonce');

                    if (!empty($option_image) && $option_image != '' && isset($option_image)) {
                        $image_display_none = 'block';
                    } else {
                        $image_display_none = 'none';
                    }

                    $attributeValueArray = explode(',', $testObject->display_attributes_value_based_on_attribute_name($wizard_id, $option_attribute));
                    $fetchSelecetedAttributeValue = !empty(array_map('trim', $attributeValueArray)) ? array_map('trim', $attributeValueArray) : '';
                    ?>
                    <div class="options_rank_class" id="options_rank_<?php echo esc_attr($options_id); ?>">
                        <input type="hidden" name="options_id[][<?php echo esc_attr($options_id); ?>]" value="<?php echo esc_attr($options_id) ?>">
                        <h3>
                            <?php _e($option_name, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                            <a href="javascript:void(0);" class="remove_option_row delete" id="remove_option_<?php echo esc_attr($options_id) ?>">Remove</a>
                        </h3>
                        <div>
                            <table class="form-table table-outer option-table all-table-listing" id="option_section">
                                <tbody>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="options_name"><?php _e(WPRW_WIZARD_OPTIONS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <input type="text" name="options_name[][<?php echo esc_attr($options_id); ?>]" class="text-class half_width" id="options_name_id_<?php echo esc_attr($options_id); ?>" value="<?php echo esc_attr($option_name); ?>" required="1" placeholder="<?php _e(WPRW_WIZARD_OPTIONS_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>">
                                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php _e(WPRW_WIZARD_OPTIONS_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                            <br/><span class="error_msg" id="error_option_name_<?php echo esc_attr($options_id); ?>" style="display:none;"><?php _e(WPRW_WIZARD_OPTIONS_ERROR_MESSAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></span>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="options_image"><?php _e(WPRW_WIZARD_OPTIONS_IMAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></label>
                                        </th>
                                        <td class="forminp mdtooltip option_image_section">
                                            <img src="<?php echo esc_url(WPRW_OPTIONS_PRO_IMG); ?>" onclick="alert('<?php echo WPRW_PRO_VERSION_TEXT; ?>');"/>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="attribute_name"><?php _e(WPRW_WIZARD_ATTRIBUTE_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_name_<?php echo esc_attr($options_id); ?>" data-placeholder="<?php _e(WPRW_WIZARD_ATTRIBUTE_NAME_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>" name="attribute_name[][<?php echo esc_attr($options_id); ?>]" class="chosen-select-attribute-value category-select chosen-rtl attribute_name" aria-required="true">
                                                <option value=""></option>
                                                <?php
                                                if (!empty($fetchSelecetedAttributeName) && $fetchSelecetedAttributeName != '') {
                                                    foreach ($fetchSelecetedAttributeName as $key => $values) {
                                                        ?>
                                                        <option value="<?php echo esc_attr(trim($values)); ?>"><?php echo esc_attr(trim($values)); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php _e(WPRW_WIZARD_ATTRIBUTE_NAME_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                            <br/><span class="error_msg" id="error_attribute_name_<?php echo esc_attr($options_id); ?>" style="display:none;"><?php _e(WPRW_WIZARD_ATTRIBUTE_NAME_ERROR_MESSAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></span>
                                        </td>
                                    </tr>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="attributr_value"><?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_value_<?php echo esc_attr($options_id); ?>" data-placeholder="<?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE_PLACEHOLDER, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>" name="attribute_value[][<?php echo esc_attr($options_id); ?>]" multiple="true" class="chosen-select-attribute-value category-select chosen-rtl attribute_value" required>
                                                <option value=""></option>
                                                <?php
                                                if (!empty($fetchSelecetedAttributeValue) && $fetchSelecetedAttributeValue != '') {
                                                    foreach (array_unique($fetchSelecetedAttributeValue) as $key => $values) {
                                                        ?>
                                                        <option value="<?php echo esc_attr(trim($values)); ?>"><?php echo esc_attr(trim($values)); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE_DESCRIPTION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                                            <br/><span class="error_msg" id="error_attribute_value_<?php echo esc_attr($options_id); ?>" style="display:none;"><?php _e(WPRW_WIZARD_ATTRIBUTE_VALUE_ERROR_MESSAGE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div id="extra_div">
            </div>
        </div>

        <p class="submit"><input type="submit" name="submitWizardQuestion" id="submitWizardQuestion" class="button button-primary button-large" value="<?php echo esc_html($btnValue); ?>"></p>
    </form>
</div>
<?php
require_once('header/plugin-sidebar.php');
?>