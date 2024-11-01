<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
$plugin_name = WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_NAME;
$plugin_version = WPRW_PLUGIN_VERSION;
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <header class="dots-header">
            <div class="dots-logo-main">
                <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/wizard_logo.png'; ?>">
            </div>
            <div class="dots-header-right">
                <div class="logo-detail">
                    <strong><?php _e($plugin_name, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?> </strong>
                    <span><?php echo WPRW_FREE_PLUGIN . " " . $this->version; ?> </span>
                </div>
                <div class="button-dots">
                    <span class="">
                        <a target = "_blank" href="<?php echo esc_url(WPRW_EXPETRANL_URL); ?>" > 
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/upgrade_new.png'; ?>">
                        </a>
                    </span>
                    <span class="support_dotstore_image">
                        <a  target = "_blank" href="<?php echo esc_url(WPRW_SUPPORT_URL); ?>" > 
                            <img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/support_new.png'; ?>">
                        </a>
                    </span>
                </div>
            </div>

            <?php
            $fee_getting_started = '';
            $fee_list = isset($_GET['page']) && $_GET['page'] == 'wprw-list' ? 'active' : '';
            $fee_add = isset($_GET['page']) && $_GET['page'] == 'wprw-add-new' ? 'active' : '';
            if (!empty($_GET['page']) && ($_GET['page'] == 'wprw-get-started')) {
                $fee_getting_started = 'active';
            }
            $premium_version = isset($_GET['page']) && $_GET['page'] == 'wprw-premium' ? 'active' : '';
            $fee_information = isset($_GET['page']) && $_GET['page'] == 'wprw-information' ? 'active' : '';

            if (isset($_GET['page']) && $_GET['page'] == 'wprw-information' || isset($_GET['page']) && $_GET['page'] == 'wprw-get-started') {
                $fee_about = 'active';
            } else {
                $fee_about = '';
            }

            if (!empty($_REQUEST['action'])) {
                if ($_REQUEST['action'] == 'add' || $_REQUEST['action'] == 'edit') {
                    $fee_add = 'active';
                }
            }

            if (!empty($_REQUEST['action'])) {
                if ($_REQUEST['action'] == 'edit' && $_REQUEST['page'] == 'wprw-edit-wizard') {
                    $wizard_id = $_REQUEST['wrd_id'];
                    $wprwnonce = $_REQUEST['_wpnonce'];
                    $wizard_header_title = WPRW_EDIT_WIZARD;
                    $wizard_header_url = home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $wizard_id . '&action=edit' . '&_wpnonce=' . $wprwnonce);
                } else {
                    $wizard_header_title = WPRW_ADD_NEW_WIZARD;
                    $wizard_header_url = home_url('/wp-admin/admin.php?page=wprw-add-new');
                }
            } else {
                $wizard_header_title = WPRW_ADD_NEW_WIZARD;
                $wizard_header_url = home_url('/wp-admin/admin.php?page=wprw-add-new');
            }
            ?>
            <div class="dots-menu-main">
                <nav>
                    <ul>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($fee_list); ?>"  href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-list')); ?>"><?php _e(WPRW_LIST_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($fee_add); ?>"  href="<?php echo esc_url($wizard_header_url); ?>"> <?php _e($wizard_header_title, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin"  href="javascript:void(0);" onclick="alert('Its only pro version');"><?php _e(WPRW_GENERAL_SETTING_PAGE_TITLE, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($premium_version); ?>"  href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-premium')); ?>"> <?php _e(WPRW_PREMIUM_VERSION, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                        </li>
                        <li>
                            <a class="dotstore_plugin <?php echo esc_attr($fee_about); ?>"  href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-get-started')); ?>"><?php _e(WPRW_ABOUT_PLUGIN, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                            <ul class="sub-menu">
                                <li><a  class="dotstore_plugin <?php echo esc_attr($fee_getting_started); ?>" href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-get-started')); ?>"><?php _e(WPRW_GETTING_STARTED, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li>
                                <li><a class="dotstore_plugin <?php echo esc_attr($fee_information); ?>" href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=wprw-information')); ?>"><?php _e(WPRW_QUICK_INFO, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="dotstore_plugin"  href="#"><?php _e('Dotstore', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a>
                            <ul class="sub-menu">
                                <li><a target="_blank" href="https://store.multidots.com/go/flatrate-pro-new-interface-woo-plugins"><?php _e(WPRW_WOOCOMMERCE_PLUGINS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li>
                                <li><a target="_blank" href="https://store.multidots.com/go/flatrate-pro-new-interface-wp-plugins"><?php _e(WPRW_WORDPRESS_PLUGINS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li><br>
                                <li><a target="_blank" href="https://store.multidots.com/go/flatrate-pro-new-interface-wp-free-plugins"><?php _e(WPRW_FREE_PLUGINS, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li>
                                <li><a target="_blank" href="https://store.multidots.com/go/flatrate-pro-new-interface-free-theme"><?php _e(WPRW_FREE_THEMES, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li>
                                <li><a target="_blank" href="https://store.multidots.com/go/flatrate-pro-new-interface-dotstore-support"><?php _e(WPRW_CONTACT_SUPPORT, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>