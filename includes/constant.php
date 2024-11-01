<?php

/**
 * define constant variabes
 * define admin side constant
 * @since 1.0.0
 * @author Multidots
 * @param null
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// define constant for plugin slug
define('WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_SLUG', 'woo-product-recommendation-wizard');
define('WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_NAME', __('Woo Product Recommendation Wizard'));
define('WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN', 'woo-product-recommendation-wizard');
define('WPRW_PLUGIN_VERSION', '1.0.0');
define('WPRW_FREE_PLUGIN', 'Free Version');
define('WPRW_EXPETRANL_URL', 'https://store.multidots.com/woocommerce-product-recommandation-wizard/');
define('WPRW_SUPPORT_URL', 'https://store.multidots.com/dotstore-support-panel/');
define('WPRW_PRO_VERSION_TEXT', 'Its only pro version');

####### Header Section #######
define('WPRW_GENERAL_SETTING_PAGE_TITLE', 'General Setting');
define('WPRW_PREMIUM_VERSION', 'Premium Version');
define('WPRW_ABOUT_PLUGIN', 'About Plugin');
define('WPRW_GETTING_STARTED', 'Getting Started');
define('WPRW_QUICK_INFO', 'Quick info');

####### Sidebar Section #######
define('WPRW_WOOCOMMERCE_PLUGINS', 'WooCommerce Plugins');
define('WPRW_WORDPRESS_PLUGINS', 'Wordpress Plugins');
define('WPRW_FREE_PLUGINS', 'Free Plugins');
define('WPRW_FREE_THEMES', 'Free Themes');
define('WPRW_CONTACT_SUPPORT', 'Contact Support');

####### Wizard Page Constant #######
define('WPRW_LIST_PAGE_TITLE', 'Manage Wizards');
define('WPRW_DELETE_LIST_NAME', 'Delete (Selected)');
define('WPRW_ADD_NEW_WIZARD', 'Add New Wizard');
define('WPRW_EDIT_WIZARD', 'Edit Wizard');
define('WPRW_BACK_TO_WIZARD_LIST', 'Back to wizard list');
define('WPRW_BACK_TO_EDIT_WIZARD_CONFIGURATION', 'Back to wizard configuration');

define('WPRW_WIZARD_TITLE', 'Wizard Title');
define('WPRW_WIZARD_TITLE_PLACEHOLDER', 'Enter Wizard Title Here');
define('WPRW_CATEGORY_PRO_IMG', esc_url(WPRW_PLUGIN_URL) . 'admin/images/wizard_category.png');
define('WPRW_OPTIONS_PRO_IMG', esc_url(WPRW_PLUGIN_URL) . 'admin/images/options_image.png');
define('WPRW_WIZARD_CATEGORY_TITLE', 'Wizard Category');
define('WWPRW_WIZARD_CATEGORY_TITLE_DESCRIPTION', 'Wizard category description');
define('WPRW_WIZARD_SHORTCODE', 'Wizard shortcode');
define('WPRW_WIZARD_STATUS', 'Status');
define('WPRW_WIZARD_TITLE_DESCRIPTION', 'Wizard title description');
define('WPRW_WIZARD_SHORTCODE_DESCRIPTION', 'Wizard shortcode description');

####### Question Page Constant #######
define('WPRW_QUESTION_LIST_PAGE_TITLE', 'Manage Questions');
define('WPRW_DELETE_QUESTION_LIST_NAME', 'Delete (Selected)');
define('WPRW_ADD_NEW_QUESTION', 'Add New Question');

define('WPRW_WIZARD_QUESTION', 'Question Title');
define('WPRW_WIZARD_QUESTION_PLACEHOLDER', 'Enter Question Title Here');
define('WPRW_WIZARD_QUESTION_DESCRIPTION', 'Question Description Here');
define('WPRW_WIZARD_QUESTION_TYPE', 'Question Type');
define('WPRW_WIZARD_QUESTION_TYPE_DESCRIPTION', 'Question description');
define('WPRW_WIZARD_QUESTION_TYPE_RADIO', 'Radio');
define('WPRW_WIZARD_QUESTION_TYPE_CHECKBOX', 'Checkbox');

####### Option Page Constant #######
define('WPRW_OPTIONS_LIST_PAGE_TITLE', 'Manage Options');
define('WPRW_DELETE_OPTIONS_LIST_NAME', 'Delete (Selected)');
define('WPRW_ADD_NEW_OPTIONS', 'Add New Option');

define('WPRW_WIZARD_OPTIONS', 'Options Title');
define('WPRW_WIZARD_OPTIONS_DESCRIPTION', 'Options Description Here');
define('WPRW_WIZARD_OPTIONS_PLACEHOLDER', 'Enter Options Title Here');

define('WPRW_WIZARD_OPTIONS_IMAGE', 'Options Image');
define('WPRW_WIZARD_OPTIONS_UPLOAD_IMAGE', 'Upload File');
define('WPRW_WIZARD_OPTIONS_REMOVE_IMAGE', 'Remove File');
define('WPRW_WIZARD_OPTIONS_SELECT_FILE', 'Select File');
define('WPRW_WIZARD_OPTIONS_IMAGE_DESCRIPTION', 'Upload Options Image Here');

define('WPRW_WIZARD_ATTRIBUTE_NAME', 'Attribute Name');
define('WPRW_WIZARD_ATTRIBUTE_NAME_DESCRIPTION', 'Attribute Description Here');
define('WPRW_WIZARD_ATTRIBUTE_NAME_PLACEHOLDER', 'Select Attribute Name');

define('WPRW_WIZARD_ATTRIBUTE_VALUE', 'Attribute Value');
define('WPRW_WIZARD_ATTRIBUTE_VALUE_DESCRIPTION', 'Attribute Description Here');
define('WPRW_WIZARD_ATTRIBUTE_VALUE_PLACEHOLDER', 'Select Attribute Value');


######## Table Name ########
define('WIZARDS_TABLE_PREFIX', "wprw_");
define('WIZARDS_TABLE', WIZARDS_TABLE_PREFIX . "wizard");
define('QUESTIONS_TABLE', WIZARDS_TABLE_PREFIX . "questions");
define('OPTIONS_TABLE', WIZARDS_TABLE_PREFIX . "questions_options");

######## Button Name ########
define('ADD_NEW_WIZARD_SAVE_BUTTON_NAME', "Save & Continue");
define('EDIT_NEW_WIZARD_SAVE_BUTTON_NAME', "Update");
define('ADD_NEW_QUESTION_SAVE_BUTTON_NAME', "Save");
define('EDIT_NEW_QUESTION_SAVE_BUTTON_NAME', "Update");
define('BACK_TO_TOP_PRODUCT_BUTTON_NAME', "Back To Top Product");


######## General Setting ########
define('WPRW_PERFECT_MATCH_TITLE', "Top Product(s)");
define('WPRW_PERFECT_MATCH_TITLE_PLACEHOLDER', "Top Product(s)");
define('WPRW_PERFECT_MATCH_TITLE_DESCRIPTION', "Enter top product description");
define('WPRW_RECENT_MATCH_TITLE', "Products meeting most of your requirements");
define('WPRW_RECENT_MATCH_TITLE_PLACEHOLDER', "Products meeting most of your requirements");
define('WPRW_RECENT_MATCH_TITLE_DESCRIPTION', "Enter recent product description");
define('WPRW_TOTAL_PAGES', "Products Per Page");
define('WPRW_TOTAL_PAGES_PLACEHOLDER', "Products Per Page");
define('WPRW_TOTAL_PAGES_DESCRIPTION', "Total Page Description");
define('WPRW_GENERAL_SETTING_SAVE', "Save");
define('WPRW_SHOW_ATTRIBUTE_TITLE', "Display Attribute Per Product");
define('WPRW_SHOW_ATTRIBUTE_PLACEHOLDER', "Display Attribute");
define('WPRW_SHOW_ATTRIBUTE_DESCRIPTION', "Attribute Description");
define('WPRW_SHOW_ATTRIBUTE_DEFAULT', "3");

######## DEFAULT VALUE ########
define('WPRW_DEFAULT_PAGINATION_NUMBER', "5");

######## Error Message ########
define('WPRW_WIZARD_OPTIONS_ERROR_MESSAGE', 'Please Enter Options Title Here');
define('WPRW_WIZARD_ATTRIBUTE_NAME_ERROR_MESSAGE', 'Please select Attribute Name');
define('WPRW_WIZARD_ATTRIBUTE_VALUE_ERROR_MESSAGE', 'Please select Attribute Value');
