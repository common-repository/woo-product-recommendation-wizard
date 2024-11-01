<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once('header/plugin-header.php');
global $wpdb;
$current_user = wp_get_current_user();
if (!get_option('wprw_free_plugin_notice_shown')) {
    ?>
    <div id="wprw_free_dialog">
        <p><?php _e('Subscribe for latest plugin update and get notified when we update our plugin and launch new products for free!', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
        <p><input type="text" id="txt_user_sub_wprw_free" class="regular-text" name="txt_user_sub_wprw_free" value="<?php echo $current_user->user_email; ?>"></p>
    </div>
<?php } ?>

<div class="wprw-main-table res-cl">
    <h2><?php _e('Thanks For Installing ' . WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_NAME, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></h2>
    <table class="table-outer">
        <tbody>
            <tr>
                <td class="fr-2">
                    <p class="block gettingstarted"><strong><?php _e('Getting Started', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?> </strong></p>
                    <p class="block textgetting">
                        <?php _e('Woo Product Recommendation Wizard let customers narrow down the product list on the basis of their choices. It enables the store owners to add a questionnaire to the product page. The product recommendations are then rendered according to the answers, given by the users. You can showcase ‘n’ number of products, matching the answers and query.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                    </p>
                    <p class="block textgetting">
                        <strong><?php _e('Step 1', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?> :</strong> <?php _e('Create Wizard (Questions and answers)', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                    <p class="block textgetting"><?php _e('Before add wizard you will have to select product attribute in particular product.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/add_attribute_in_product.png'; ?>">										
                        </span>
                    </p>
                    <p class="block textgetting"><?php _e('Enter Wizard title, select category and enable status.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>

                        <span class="gettingstarted">
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/Getting_Started_01.png'; ?>">										
                        </span>
                    </p>
                    <p class="block gettingstarted textgetting">
                        <strong><?php _e('Step 2', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?> :</strong> <?php _e('Manage Question: Add New Question', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                    <p class="block textgetting"><?php _e('Create question option like a radio button or Multi-select check box.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/free_edit_wizard.png'; ?>">
                        </span>
                    </p>
                    <p class="block textgetting"><?php _e('Provide Corresponding answers (options), upload pictures, select Attributes name and attribute values.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/free_option.png'; ?>">
                        </span>
                    </p>
                    </p>
                    <p class="block gettingstarted textgetting">
                        <strong><?php _e('Step 3', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?> :</strong> <?php _e('Global General Setting', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                    <p class="block textgetting"><?php _e('With this General Setting, you can change the defaule setting as per below:', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    <p class="block textgetting"><?php _e('How many attribute show per Product in product recommendation Wizard page.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    <p class="block textgetting"><?php _e('How many products displays per page.(on Recommendation Wizard page).', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></p>
                    <span class="gettingstarted">
                        <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/free_general_setting.png'; ?>">
                    </span>
                    </p>
                    <p class="block gettingstarted textgetting">
                        <strong><?php _e('Step 4', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?> :</strong> <?php _e('Copy and past Wizard shortcode in page/ post and publish Product Recommendation Wizard', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                    <p class="block textgetting"><?php _e('All you need to do is to copy & paste Wizard shortcode page or post.', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/edit_page.png'; ?>">
                        </span>
                    </p>
                    <p class="block textgetting"><?php _e('Product result display as per below screenshot', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?>
                        <span class="gettingstarted">
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/Getting_Started_05.png'; ?>">
                        </span>
                    </p>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php require_once('header/plugin-sidebar.php'); ?>