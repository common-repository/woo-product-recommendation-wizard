<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/admin
 * @author     Multidots <inquiry@multidots.in>
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

//require plugin_dir_path(__FILE__) . 'includes/constant.php';

class Woo_Product_Recommendation_Wizard_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Product_Recommendation_Wizard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Product_Recommendation_Wizard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-list' || $_GET['page'] == 'wprw-add-new' || $_GET['page'] == 'wprw-premium' ||
                $_GET['page'] == 'wprw-get-started' || $_GET['page'] == 'wprw-information' || $_GET['page'] == 'wprw-edit-wizard' || $_GET['page'] == 'wprw-add-new-question' ||
                $_GET['page'] == 'wprw-question-list' || $_GET['page'] == 'wprw-edit-question' || $_GET['page'] == 'wprw-add-new-options' || $_GET['page'] == 'wprw-general-setting')) {
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-product-recommendation-wizard-admin.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'main-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-jquery-ui-css', plugin_dir_url(__FILE__) . 'css/jquery-ui.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-webkit-css', plugin_dir_url(__FILE__) . 'css/webkit.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . 'media-css', plugin_dir_url(__FILE__) . 'css/media.css', array(), $this->version, 'all');
        }
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-add-new-options' || $_GET['page'] == 'wprw-add-new-question' || $_GET['page'] == 'wprw-add-new' || $_GET['page'] == 'wprw-edit-wizard')) {
            wp_enqueue_style($this->plugin_name . 'chosen-css', plugin_dir_url(__FILE__) . 'css/chosen.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Product_Recommendation_Wizard_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Product_Recommendation_Wizard_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if (isset($_GET['page']) && !empty($_GET['page']) && ($_GET['page'] == 'wprw-list' || $_GET['page'] == 'wprw-add-new' || $_GET['page'] == 'wprw-premium' ||
                $_GET['page'] == 'wprw-get-started' || $_GET['page'] == 'wprw-information' || $_GET['page'] == 'wprw-edit-wizard' || $_GET['page'] == 'wprw-add-new-question' ||
                $_GET['page'] == 'wprw-question-list' || $_GET['page'] == 'wprw-edit-question' || $_GET['page'] == 'wprw-add-new-options' || $_GET['page'] == 'wprw-general-setting')) {
            wp_enqueue_script('jquery');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('jquery-ui-accordion');
            wp_enqueue_media();
            wp_enqueue_style('wp-jquery-ui-dialog');
            wp_enqueue_script('productRecommendationWizard', plugin_dir_url(__FILE__) . 'js/woo-product-recommendation-wizard-admin.js', array('jquery'), $this->version, false); //, 'jquery-ui-dialog', 'jquery-ui-accordion', 'jquery-ui-sortable'
            wp_localize_script('productRecommendationWizard', 'adminajax', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_icon' => plugin_dir_url(__FILE__) . '/images/ajax-loader.gif'));
            wp_enqueue_script($this->plugin_name . 'tablesorter', plugin_dir_url(__FILE__) . 'js/jquery.tablesorter.js', array('jquery'), $this->version, true);


            wp_enqueue_script('chosen_custom', plugin_dir_url(__FILE__) . 'js/chosen.jquery.js', array('jquery'), $this->version, false);


            ################ GET Wizard Id and Question ID #################
            $get_wizard_id = isset($_REQUEST['wrd_id']) ? sanitize_text_field(wp_unslash($_REQUEST['wrd_id'])) : '';
            $get_question_id = isset($_REQUEST['que_id']) ? sanitize_text_field(wp_unslash($_REQUEST['que_id'])) : '';

            ################ Option ID ######################
            $fetchOptionValueID = $this->get_custom_options_id_from_database();
            $OptionValueIDArray = !empty($fetchOptionValueID) ? json_encode($fetchOptionValueID) : json_encode(array());
            wp_localize_script('chosen_custom', 'option_value_id', array('OptionValueIDArray' => $OptionValueIDArray));

            ################ Attribute Value ######################
            $attributeValueArrayFromDB = $this->get_custom_attribute_value_from_database();
            if (!empty($attributeValueArrayFromDB) && $attributeValueArrayFromDB != '') {
                foreach ($attributeValueArrayFromDB as $key => $value) {
                    $value1 = explode(',', trim($value));
                    $fetchWooCoomerceOption = !empty($value1) ? $value1 : '';
                    wp_localize_script('chosen_custom', 'allAttributeValue' . $key, array(
                        'attribute_option_id' => 'attribute_option_' . $key,
                        'attributeOptionArray' => $fetchWooCoomerceOption
                    ));
                }
            }

            ################ Attribute Name ######################
            $fetchOptionNameFromDB = $this->get_custom_options_name_from_database();
            if (!empty($fetchOptionNameFromDB) && $fetchOptionNameFromDB != '') {
                foreach ($fetchOptionNameFromDB as $key => $value) {
                    $fetchWooCoomerceAttributename = !empty($value) ? $value : '';
                    wp_localize_script('chosen_custom', 'allAttributename' . $key, array(
                        'attribute_name_id' => 'attribute_name_' . $key,
                        'attributeAttributeArray' => $fetchWooCoomerceAttributename
                    ));
                }
            }

            ################ Total Count Option ID ######################
            $total_count_option_id = $this->get_total_option_id_for_question();
            ################ Option Label Name Dynamically When Add New Option ######################
            wp_localize_script('chosen_custom', 'optionLabelDetails', array(
                'option_label' => json_encode(WPRW_WIZARD_OPTIONS),
                'option_lable_description' => json_encode(WPRW_WIZARD_OPTIONS_DESCRIPTION),
                'option_lable_placeholder' => json_encode(WPRW_WIZARD_OPTIONS_PLACEHOLDER),
                'option_name_error' => json_encode(WPRW_WIZARD_OPTIONS_ERROR_MESSAGE),
                'option_image_lable' => json_encode(WPRW_WIZARD_OPTIONS_IMAGE),
                'option_image_pro' => json_encode(WPRW_OPTIONS_PRO_IMG),
                'option_pro_version_text' => json_encode(WPRW_PRO_VERSION_TEXT),
                'option_image_upload_image' => json_encode(WPRW_WIZARD_OPTIONS_UPLOAD_IMAGE),
                'option_image_remove_image' => json_encode(WPRW_WIZARD_OPTIONS_REMOVE_IMAGE),
                'option_image_description' => json_encode(WPRW_WIZARD_OPTIONS_IMAGE_DESCRIPTION),
                'option_attribute_lable' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME),
                'option_attribute_description' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME_DESCRIPTION),
                'option_attribute_placeholder' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME_PLACEHOLDER),
                'option_attribute_error' => json_encode(WPRW_WIZARD_ATTRIBUTE_NAME_ERROR_MESSAGE),
                'option_value_lable' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE),
                'option_value_description' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE_DESCRIPTION),
                'option_value_placeholder' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE_PLACEHOLDER),
                'option_value_error' => json_encode(WPRW_WIZARD_ATTRIBUTE_VALUE_ERROR_MESSAGE),
                'total_count_option_id' => json_encode($total_count_option_id)
            ));

            ################ All Attribute Name List Disply In Select Dropdwon When Add New Option ######################
            $fetchAttributeName = $this->get_woocommerce_product_attribute_name_list($get_wizard_id);
            $fetchAttributeNameWithExplode = explode(',', $fetchAttributeName);
            $fetchAllAttributeName = !empty($fetchAttributeNameWithExplode) ? $fetchAttributeNameWithExplode : '';
            $attributeArray = !empty($fetchAllAttributeName) ? json_encode($fetchAllAttributeName) : json_encode(array());
            wp_localize_script('chosen_custom', 'all_attribute_name', array('attributeArray' => $attributeArray));
        }
    }

    /**
     * Register the Page for the admin area.
     *
     * @since    1.0.0
     */
    public function dot_store_menu_wprw() {
        global $GLOBALS;
        if (empty($GLOBALS['admin_page_hooks']['dots_store'])) {
            add_menu_page(
                    'DotStore Plugins', __('DotStore Plugins'), 'manage_option', 'dots_store', array($this, 'wprw_wizrd_list_page'), WPRW_PLUGIN_URL . 'admin/images/menu-icon.png', 25
            );
        }
        add_submenu_page('dots_store', 'Get Started', 'Get Started', 'manage_options', 'wprw-get-started', array($this, 'wprw_get_started_page'));
        add_submenu_page('dots_store', 'Premium Version', 'Premium Version', 'manage_options', 'wprw-premium', array($this, 'premium_version_wprw_page'));
        add_submenu_page('dots_store', 'Introduction', 'Introduction', 'manage_options', 'wprw-information', array($this, 'wprw_information_page'));
        add_submenu_page('dots_store', 'Woo Product Recommendation Wizard', __('Woo Product Recommendation Wizard'), 'manage_options', 'wprw-list', array($this, 'wprw_wizrd_list_page'));
        add_submenu_page('dots_store', 'Add New', 'Add New', 'manage_options', 'wprw-add-new', array($this, 'wprw_add_new_wizard_page'));
        add_submenu_page('dots_store', 'Edit Wizard', 'Edit Wizard', 'manage_options', 'wprw-edit-wizard', array($this, 'wprw_edit_wizard_page'));
        add_submenu_page('dots_store', 'Add New', 'Add New', 'manage_options', 'wprw-add-new-question', array($this, 'wprw_add_new_question_page'));
        add_submenu_page('dots_store', 'Edit Question', 'Edit Question', 'manage_options', 'wprw-edit-question', array($this, 'wprw_edit_question_page'));
    }

    /**
     * Register the Menu Page for the admin area.
     *
     * @since    1.0.0
     */
    public function dot_store_menu_page() {
        
    }

    /**
     * Register the Information Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_information_page() {
        require_once('partials/wprw-information-page.php');
    }

    /**
     * Register the Premium Version Page for the admin area.
     *
     * @since    1.0.0
     */
    public function premium_version_wprw_page() {
        require_once('partials/wprw-premium-version-page.php');
    }

    /**
     * Register the Wizard List for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_wizrd_list_page() {
        require_once('partials/wprw-list-page.php');
    }

    /**
     * Register the Add New Wizard for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_add_new_wizard_page() {
        require_once('partials/wprw-add-new-page.php');
    }

    /**
     * Register the Edit Wizard Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_edit_wizard_page() {
        require_once('partials/wprw-add-new-page.php');
    }

    /**
     * Register the Get Started Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_get_started_page() {
        require_once('partials/wprw-get-started-page.php');
    }

    /**
     * Register the Add New Question for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_add_new_question_page() {
        require_once('partials/wprw-add-new-question-page.php');
    }

    /**
     * Register the Edit Question for the admin area.
     *
     * @since    1.0.0
     */
    public function wprw_edit_question_page() {
        require_once('partials/wprw-add-new-question-page.php');
    }

    /**
     * Welcome Screen Redirect.
     *
     * @since    1.0.0
     */
    public function welcome_wprw_screen_do_activation_redirect() {
        // if no activation redirect
        if (!get_transient('_welcome_screen_activation_redirect_wprw')) {
            return;
        }

        // Delete the redirect transient
        delete_transient('_welcome_screen_activation_redirect_wprw');

        // if activating from network, or bulk
        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }
        // Redirect to extra cost welcome  page

        wp_safe_redirect(add_query_arg(array('page' => 'wprw-get-started'), admin_url('admin.php')));
    }

    /**
     * Remove Menu from toolbar which is display in admin section.
     *
     * @since    1.0.0
     */
    public function wprw_remove_admin_submenus() {
        remove_submenu_page('dots_store', 'wprw-information');
        remove_submenu_page('dots_store', 'wprw-premium');
        remove_submenu_page('dots_store', 'wprw-add-new');
        remove_submenu_page('dots_store', 'wprw-edit-wizard');
        remove_submenu_page('dots_store', 'wprw-get-started');
        remove_submenu_page('dots_store', 'wprw-add-new-question');
        remove_submenu_page('dots_store', 'wprw-edit-question');
        remove_submenu_page('dots_store', 'wprw-question-list');
        remove_submenu_page('dots_store', 'wprw-general-setting');
    }

    /**
     * Get custom attribute value from option table for admin are.
     *
     * @since    1.0.0
     * @return array
     */
    public function get_custom_attribute_value_from_database() {
        global $wpdb;
        $wizard_id = isset($_REQUEST['wrd_id']) ? sanitize_text_field(wp_unslash($_REQUEST['wrd_id'])) : '';
        $question_id = isset($_REQUEST['que_id']) ? sanitize_text_field(wp_unslash($_REQUEST['que_id'])) : '';

        $option_att_arr = array();
        $questions_options_table_name = OPTIONS_TABLE;
        $sel_options_qry = $wpdb->prepare('SELECT * FROM ' . $questions_options_table_name . ' WHERE wizard_id=%d AND question_id=%d', array($wizard_id, $question_id));
        $sel_options_rows = $wpdb->get_results($sel_options_qry);
        if (!empty($sel_options_rows) && $sel_options_rows != '') {
            foreach ($sel_options_rows as $sel_options_data) {
                $options_id = $sel_options_data->id;
                $option_attribute = $sel_options_data->option_attribute;
                $option_attribute_value = $sel_options_data->option_attribute_value;
                $option_att_arr[$options_id] = $option_attribute_value;
            }
        }
        return $option_att_arr;
    }

    /**
     * Get custom options id from option table for admin are.
     *
     * @since    1.0.0
     * @return array
     */
    public function get_custom_options_id_from_database() {
        global $wpdb;
        $wizard_id = isset($_REQUEST['wrd_id']) ? sanitize_text_field(wp_unslash($_REQUEST['wrd_id'])) : '';
        $question_id = isset($_REQUEST['que_id']) ? sanitize_text_field(wp_unslash($_REQUEST['que_id'])) : '';

        $option_id_arr = array();
        $questions_options_table_name = OPTIONS_TABLE;
        $sel_options_qry = $wpdb->prepare('SELECT * FROM ' . $questions_options_table_name . ' WHERE wizard_id=%d AND question_id=%d', array($wizard_id, $question_id));
        $sel_options_rows = $wpdb->get_results($sel_options_qry);
        if (!empty($sel_options_rows) && $sel_options_rows != '') {
            foreach ($sel_options_rows as $sel_options_data) {
                $options_id = $sel_options_data->id;
                $option_id_arr[] = "attribute_option_" . $options_id;
            }
        }
        return $option_id_arr;
    }

    /**
     * Get custom options name from option table for admin are.
     *
     * @since    1.0.0
     * @return string
     */
    public function get_custom_options_name_from_database() {
        global $wpdb;
        $wizard_id = isset($_REQUEST['wrd_id']) ? sanitize_text_field(wp_unslash($_REQUEST['wrd_id'])) : '';
        $question_id = isset($_REQUEST['que_id']) ? sanitize_text_field(wp_unslash($_REQUEST['que_id'])) : '';

        $options_attribute_name = array();
        $questions_options_table_name = OPTIONS_TABLE;
        $sel_options_qry = $wpdb->prepare('SELECT * FROM ' . $questions_options_table_name . ' WHERE wizard_id=%d AND question_id=%d', array($wizard_id, $question_id));
        $sel_options_rows = $wpdb->get_results($sel_options_qry);
        if (!empty($sel_options_rows) && $sel_options_rows != '') {
            foreach ($sel_options_rows as $sel_options_data) {
                $options_id = $sel_options_data->id;
                $options_attribute_name[$options_id] = $sel_options_data->option_attribute;
            }
        }
        return $options_attribute_name;
    }

    /**
     * Woocommerce all product attribute value list that is custom add or attribute section in product.
     *
     * @since    1.0.0
     * @return array
     */
    public function get_woocommerce_product_attribute_value_list() {
        global $product;
        $attributeValueArray_implode = '';
        $full_product_list = array();
        $loop = new WP_Query(array('post_type' => array('product'), 'post_status' => 'publish', 'posts_per_page' => -1));
        while ($loop->have_posts()) : $loop->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            $variation_data = $product->get_attributes();

            foreach ($variation_data as $attribute) {
                if (($attribute['is_taxonomy'])) {
                    $values = wc_get_product_terms($theid, $attribute['name'], array('fields' => 'names'));
                    $att_val = apply_filters('woocommerce_attribute', wptexturize(implode(' | ', $values)), $attribute, $values);
                    $att_val_ex = trim($att_val);
                } else {
                    $att_val_ex = trim($attribute['value']);
                }
                $custom_product_attributes[] = explode('|', $att_val_ex);
                $custom_product_attributes_arr[wc_attribute_label($attribute['name'])] = $att_val_ex;
            }

        endwhile;
        wp_reset_query();

        if (!empty($custom_product_attributes) && isset($custom_product_attributes)) {
            $attributeValueArray_implode = implode(',', call_user_func_array('array_merge', $custom_product_attributes));
        } else {
            $attributeValueArray_implode = '';
        }
        return $attributeValueArray_implode;
    }

    /**
     * Woocommerce all product attribute value list that is custom add or attribute section in product.
     *
     * @since    1.0.0
     * @param      integer    $wizard_id   wizard id.
     * @return array
     */
    public function get_woocommerce_product_attribute_name_list($wizard_id) {
        global $wpdb, $product;

        $wizard_id = isset($wizard_id) ? $wizard_id : '';

        $args = array(
            'post_type' => array('product'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        //$full_product_list = array();
        $loop = new WP_Query($args);
        $custom_product_attributes_name_arr = array();
        while ($loop->have_posts()) : $loop->the_post();
            $theid = get_the_ID();
            $product = new WC_Product($theid);
            $variation_data = $product->get_attributes();
            foreach ($variation_data as $attribute) {
                $custom_product_attributes_name_arr[] = explode('|', wc_attribute_label($attribute['name']));
            }
        endwhile;
        wp_reset_query();

        $custom_product_attributes_name = array_map("unserialize", array_unique(array_map("serialize", $custom_product_attributes_name_arr)));
        if (!empty($custom_product_attributes_name) && isset($custom_product_attributes_name)) {
            $attributeNameArray_implode = implode(',', call_user_func_array('array_merge', $custom_product_attributes_name));
        } else {
            $attributeNameArray_implode = '';
        }
        return $attributeNameArray_implode;
    }

    /**
     * Woocommerce all product attribute value list based on attribute name.
     *
     * @since    1.0.0
     * @return array
     */
    public function get_attributes_value_based_on_attribute_name() {

        global $product;

        $attribute_name = isset($_REQUEST['attribute_name']) ? sanitize_text_field(wp_unslash($_REQUEST['attribute_name'])) : '';
        $wizard_id = isset($_REQUEST['current_wizard_id']) ? sanitize_text_field(wp_unslash($_REQUEST['current_wizard_id'])) : '';

        $args = array(
            'post_type' => array('product'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $loop = new WP_Query($args);
        if ($loop->have_posts()) {
            $custom_product_attributes_arr = array();
            $taxonomy_product_attributes_arr = array();
            while ($loop->have_posts()) : $loop->the_post();
                $theid = get_the_ID();
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();

                foreach ($variation_data as $attribute) {
                    if (($attribute['is_taxonomy'] && !taxonomy_exists($attribute_name))) {
                        $values = wc_get_product_terms($theid, $attribute['name'], array('fields' => 'names'));
                        $att_val = apply_filters('woocommerce_attribute', wptexturize(implode(' | ', $values)), $attribute, $values);
                        $att_val_ex = trim($att_val);
                    } else {
                        $att_val_ex = trim($attribute['value']);
                    }
                    $custom_product_attributes_arr[][wc_attribute_label($attribute['name'])] = $att_val_ex;
                }
            endwhile;
        }

        wp_reset_query();

        $all_attribute_value = array();
        $all_attribute_value_implode = array();
        if (!empty($custom_product_attributes_arr) && isset($custom_product_attributes_arr)) {
            foreach ($custom_product_attributes_arr as $arr_items => $arr_values) {
                foreach ($arr_values as $items => $values) {
                    if ($attribute_name == $items) {
                        $all_attribute_value[] = explode('|', $values);
                    }
                }
            }
        }

        ####### Implode array value #######
        if (!empty($all_attribute_value) && isset($all_attribute_value)) {
            foreach ($all_attribute_value as $innerValue) {
                $all_attribute_value_implode[] = implode(',', $innerValue);
            }
        }

        ####### Join Array value with comma #######
        $result_attribute_value = '';
        if (!empty($all_attribute_value_implode) && isset($all_attribute_value_implode)) {
            foreach ($all_attribute_value_implode as $sub_array) {
                $result_attribute_value .= $sub_array . ',';
            }
        }

        $result_attribute_value = trim($result_attribute_value, ',');
        $result_attribute_value_explode = explode(',', trim($result_attribute_value));
        $dropdwon_list = '';
        $dropdwon_list .= '<option value=""></option>';
        if (!empty($result_attribute_value_explode) && isset($result_attribute_value_explode)) {
            foreach (array_unique(array_map('trim', $result_attribute_value_explode)) as $key => $final_value) {
                $dropdwon_list .= '<option value="' . trim($final_value) . '">' . trim($final_value) . '</option>';
            }
        }

        echo $dropdwon_list;
        wp_die();
    }

    /**
     * Display attribute value where chages attribute name
     *
     * @since    1.0.0
     * @param int $wizard_id Wizard id
     * @param string $attribute_name Attribute name
     */
    public function display_attributes_value_based_on_attribute_name($wizard_id, $attribute_name) {
        global $wpdb, $product;
        $attribute_name = trim($attribute_name);

        $args = array(
            'post_type' => array('product'),
            'post_status' => 'publish',
            'posts_per_page' => -1,
        );

        $loop = new WP_Query($args);

        if ($loop->have_posts()) {
            $custom_product_attributes_arr = array();
            while ($loop->have_posts()) : $loop->the_post();
                $theid = get_the_ID();
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();

                if (!empty($variation_data) && isset($variation_data)) {
                    foreach ($variation_data as $attribute) {
                        if (($attribute['is_taxonomy'] && !taxonomy_exists($attribute_name))) {
                            $values = wc_get_product_terms($theid, $attribute['name'], array('fields' => 'names'));
                            $att_val = apply_filters('woocommerce_attribute', wptexturize(implode(' | ', $values)), $attribute, $values);
                            $att_val_ex = trim($att_val);
                        } else {
                            $att_val_ex = trim($attribute['value']);
                        }
                        $custom_product_attributes_arr[][wc_attribute_label($attribute['name'])] = $att_val_ex;
                    }
                }
            endwhile;
        }

        wp_reset_query();

        $all_attribute_value = array();
        $all_attribute_value_implode = array();
        if (!empty($custom_product_attributes_arr) && isset($custom_product_attributes_arr)) {
            foreach ($custom_product_attributes_arr as $arr_items => $arr_values) {
                foreach ($arr_values as $items => $values) {
                    if ($attribute_name == $items) {
                        $all_attribute_value[] = explode('|', $values);
                    }
                }
            }
        }

        ####### Implode array value #######
        if (!empty($all_attribute_value) && isset($all_attribute_value)) {
            foreach ($all_attribute_value as $all_att_key => $innerValue) {
                $all_attribute_value_implode[] = implode(',', $innerValue);
            }
        }

        ####### Join Array value with comma #######
        $result_attribute_value = '';
        if (!empty($all_attribute_value_implode) && isset($all_attribute_value_implode)) {
            foreach ($all_attribute_value_implode as $sub_array) {
                $result_attribute_value .= $sub_array . ',';
            }
        }

        $result_attribute_value = trim($result_attribute_value, ',');

        return $result_attribute_value;
    }

    /**
     * Delete Option data from option page in admin area.
     *
     * @since    1.0.0
     */
    public function remove_option_data_from_option_page() {
        global $wpdb;

        $option_id = isset($_REQUEST['option_id']) ? sanitize_text_field(wp_unslash($_REQUEST['option_id'])) : '';

        $questions_options_table_name = OPTIONS_TABLE;
        $delete_result = $wpdb->delete($questions_options_table_name, array('id' => $option_id), array('%d'));
        echo $delete_result;
        wp_die();
    }

    /**
     * Delete checked wizard id from wizard page.
     *
     * @since    1.0.0
     */
    public function delete_selected_wizard_using_checkbox() {
        global $wpdb;

        $selected_wizard_id = isset($_REQUEST['selected_wizard_id']) ? $_REQUEST['selected_wizard_id'] : '';

        $wizard_table_name = WIZARDS_TABLE;
        $questions_table_name = QUESTIONS_TABLE;
        $questions_options_table_name = OPTIONS_TABLE;
        $success_delete = array();
        if (!empty($selected_wizard_id) && isset($selected_wizard_id)) {
            foreach ($selected_wizard_id as $key => $value) {
                $delete_wizard_result = $wpdb->delete($wizard_table_name, array('id' => $value), array('%d'));
                $delete_questions_result = $wpdb->delete($questions_table_name, array('wizard_id' => $value), array('%d'));
                $delete_options_result = $wpdb->delete($questions_options_table_name, array('wizard_id' => $value), array('%d'));
                $success_delete[] = $delete_wizard_result;
            }

            if (in_array("1", $success_delete)) {
                echo 'true';
                wp_die();
            }
        }
    }

    /**
     * Delete single wizard id from wizard page.
     *
     * @since    1.0.0
     */
    public function delete_single_wizard_using_button() {
        global $wpdb;
        $single_selected_wizard_id = isset($_REQUEST['single_selected_wizard_id']) ? sanitize_text_field(wp_unslash($_REQUEST['single_selected_wizard_id'])) : '';

        $wizard_table_name = WIZARDS_TABLE;
        $questions_table_name = QUESTIONS_TABLE;
        $questions_options_table_name = OPTIONS_TABLE;

        $delete_wizard_result = $wpdb->delete($wizard_table_name, array('id' => $single_selected_wizard_id), array('%d'));
        $delete_questions_result = $wpdb->delete($questions_table_name, array('wizard_id' => $single_selected_wizard_id), array('%d'));
        $delete_options_result = $wpdb->delete($questions_options_table_name, array('wizard_id' => $single_selected_wizard_id), array('%d'));

        if ($delete_wizard_result == '1') {
            echo 'true';
            wp_die();
        }
    }

    /**
     * Delete selected questions from questions page.
     *
     * @since    1.0.0
     */
    public function delete_selected_question_using_checkbox() {
        global $wpdb;

        $selected_question_id = isset($_POST['selected_question_id']) ? $_POST['selected_question_id'] : '';

        $questions_table_name = QUESTIONS_TABLE;
        $questions_options_table_name = OPTIONS_TABLE;
        $success_delete = array();
        if (!empty($selected_question_id) && isset($selected_question_id)) {
            foreach ($selected_question_id as $key => $value) {
                $delete_questions_result = $wpdb->delete($questions_table_name, array('id' => $value), array('%d'));
                $delete_options_result = $wpdb->delete($questions_options_table_name, array('question_id' => $value), array('%d'));
                $success_delete[] = $delete_questions_result;
            }
            if (in_array("1", $success_delete)) {
                echo 'true';
                wp_die();
            }
        }
    }

    /**
     * Delete single question using delete button.
     *
     * @since    1.0.0
     */
    public function delete_single_question_using_button() {
        global $wpdb;

        $single_selected_question_id = isset($_REQUEST['single_selected_question_id']) ? sanitize_text_field(wp_unslash($_REQUEST['single_selected_question_id'])) : '';

        $wizard_table_name = WIZARDS_TABLE;
        $questions_table_name = QUESTIONS_TABLE;
        $questions_options_table_name = OPTIONS_TABLE;

        //$delete_wizard_result = $wpdb->delete($wizard_table_name, array('id' => $single_selected_question_id), array('%d'));
        $delete_questions_result = $wpdb->delete($questions_table_name, array('id' => $single_selected_question_id), array('%d'));
        $delete_options_result = $wpdb->delete($questions_options_table_name, array('question_id' => $single_selected_question_id), array('%d'));

        if ($delete_questions_result == '1') {
            echo 'true';
            wp_die();
        }
    }

    /**
     * General setting.
     *
     * @since    1.0.0
     * @param WP_Post $post
     */
    public function wprw_general_setting_save($post) {
        global $wpdb;
        if (empty($post)) {
            return false;
        }
        $general_setting = array(
            'perfect_match_title' => trim(stripslashes(sanitize_text_field(wp_unslash($_POST['perfect_match_title'])))),
            'recent_match_title' => trim(stripslashes(sanitize_text_field(wp_unslash($_POST['recent_match_title'])))),
        );
        update_option('wizard_general_option', $general_setting);
    }

    /**
     * Save wizard data
     *
     * @since    1.0.0
     * @param WP_Post $post
     */
    public function wprw_wizard_save($post) {
        global $wpdb;
        $wcpfcnonce = wp_create_nonce('wppfcnonce');
        if (empty($post)) {
            return false;
        }
        $wizard_table_name = WIZARDS_TABLE;

        if (isset($post['wizard_status']) && !empty($post['wizard_status'])) {
            $wizard_status = 'on';
        } else {
            $wizard_status = 'off';
        }

        if (isset($post['wizard_title'])) {
            if (intval($post['wizard_post_id']) == '') {
                $wpdb->query($wpdb->prepare("INSERT INTO " . $wizard_table_name . "( name, wizard_category, shortcode, status, created_date, updated_date ) VALUES ( %s, %s, %s, %s, %s, %s )", trim(stripslashes(sanitize_text_field($post['wizard_title']))), '', trim(sanitize_text_field($post['wizard_shortcode'])), trim($wizard_status), date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));
                $last_wizard_id = $wpdb->insert_id;
            } else {
                $wpdb->query($wpdb->prepare("UPDATE " . $wizard_table_name . " SET name = %s, shortcode=%s, status=%s, created_date=%s, updated_date=%s WHERE id = %d", trim(stripslashes(sanitize_text_field($post['wizard_title']))), trim(sanitize_text_field($post['wizard_shortcode'])), trim($wizard_status), date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), intval($post['wizard_post_id'])));
                $last_wizard_id = intval(sanitize_text_field(wp_unslash($post['wizard_post_id'])));
            }
        }
        $latest_url = esc_url(home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $last_wizard_id . '&action=edit&_wpnonce=' . $wcpfcnonce));
        $newUrl = html_entity_decode($latest_url);

        wp_safe_redirect($newUrl);
        exit();
    }

    /**
     * Save question data
     *
     * @since    1.0.0
     * @param varchar $post check post or not.
     * @param int $wizard_id which questions are saved for wizard.
     */
    public function wprw_wizard_question_save($post, $wizard_id) {
        global $wpdb;
        $wcpfcnonce = wp_create_nonce('wppfcnonce');
        if (empty($post)) {
            return false;
        }

        $questions_table_name = QUESTIONS_TABLE;
        if (isset($post['question_type'])) {
            $question_type = sanitize_text_field(wp_unslash($post['question_type']));
        }

        if (isset($post['question_name'])) {
            if ($post['question_id'] == '') {
                $max_sortable_number = $this->get_last_max_sortabl_question_insert_time($wizard_id);
                $wpdb->query($wpdb->prepare("INSERT INTO " . $questions_table_name . "( name, wizard_id, option_type, sortable_id, created_date, updated_date ) VALUES ( %s, %d, %s, %d, %s, %s )", trim(stripslashes(sanitize_text_field(wp_unslash($post['question_name'])))), trim($wizard_id), trim($question_type), trim($max_sortable_number), date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));
                $last_question_id = $wpdb->insert_id;
                $this->wprw_wizard_options_save($post['options_id'], $post['options_name'], $post['attribute_name'], $post['attribute_value'], $wizard_id, $last_question_id);
            } else {
                $sortable_number = $this->get_last_max_sortabl_question_insert_update($wizard_id, sanitize_text_field(wp_unslash($post['question_id'])));
                $wpdb->query($wpdb->prepare("UPDATE " . $questions_table_name . " SET name = %s, option_type=%s, created_date=%s, updated_date=%s WHERE id = %d AND wizard_id = %d", trim(stripslashes($post['question_name'])), trim($question_type), date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $post['question_id'], $wizard_id));
                $this->wprw_wizard_options_save($post['options_id'], $post['options_name'], $post['attribute_name'], $post['attribute_value'], $wizard_id, sanitize_text_field(wp_unslash($post['question_id'])));
                $last_question_id = sanitize_text_field(wp_unslash($post['question_id']));
            }
        }
        $latest_url = esc_url(home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . '&que_id=' . $last_question_id . '&action=edit&_wpnonce=' . $wcpfcnonce));
        $newUrl = html_entity_decode($latest_url);
        wp_safe_redirect($newUrl);
        exit();
    }

    /**
     * Save options data
     *
     * @since    1.0.0
     * @param varchar $post check post or not.
     * @param int $options_id posted option id
     * @param string $options_name which posted option name
     * @param image $hf_option_single_image_src posted option image
     * @param string $attribute_name posted attribute name
     * @param string $attribute_value posted attribute value
     * @param int $wizard_id which options are saved for wizard.
     * @param int $questions_id which options are saved for questions.
     */
    public function wprw_wizard_options_save($options_id, $options_name, $attribute_name, $attribute_value, $wizard_id, $questions_id) {
        global $wpdb;

        $main_options_id = $options_id;
        $main_options_name = $options_name;
        $main_attribute_name = $attribute_name;
        $main_attributr_value = $attribute_value;

        if (!empty($main_options_id)) {
            foreach ($main_options_id as $main_options_id_key => $main_options_id_value) {
                foreach ($main_options_id_value as $options_key => $options_value) {
                    if (!empty($main_options_name)) {
                        foreach ($main_options_name as $main_options_name_key => $main_options_name_value) {
                            foreach ($main_options_name_value as $options_name_key => $options_name_value) {
                                if (!empty($main_attribute_name)) {
                                    foreach ($main_attribute_name as $attribute_name_key => $attribute_name) {
                                        foreach ($attribute_name as $an_key => $an_value) {
                                            if (!empty($main_attributr_value)) {
                                                $original_attributr_value = '';
                                                foreach ($main_attributr_value as $attributr_value_key => $attributr_value) {
                                                    foreach ($attributr_value as $av_key => $av_value) {
                                                        if ($options_key == $options_name_key && $options_key == $an_key && $options_key == $av_key && $options_name_key == $an_key && $options_name_key == $av_key && $an_key == $av_key) {
                                                            $original_attributr_value .= ',' . $av_value;
                                                            $final_results[$options_key][$options_value] = trim($options_name_value) . "||" . trim($an_value) . "||" . ltrim($original_attributr_value, ',');
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $result_option = '';
        $options_table_name = OPTIONS_TABLE;
        if (isset($final_results)) {
            foreach ($final_results as $key => $value) {
                foreach ($value as $v_key => $v_value) {
                    if ($v_key == '') {
                        $max_option_sortable_number = $this->get_last_max_sortabl_option_insert_time($wizard_id, $questions_id);
                        $other_option_data = explode('||', trim($v_value));
                        $wpdb->query($wpdb->prepare("INSERT INTO " . $options_table_name . "( wizard_id, question_id, option_name,option_image, option_attribute, option_attribute_value, sortable_id, created_date, updated_date ) VALUES ( %d, %d, %s,%s, %s, %s, %d, %s, %s )", trim($wizard_id), trim($questions_id), trim(stripslashes($other_option_data[0])), '', trim($other_option_data[1]), trim($other_option_data[2]), trim($max_option_sortable_number), date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));
                    }
                }
            }
            foreach ($final_results as $key => $value) {
                foreach ($value as $v_key => $v_value) {
                    $check_options_qry = $wpdb->prepare('SELECT * FROM ' . $options_table_name . ' WHERE wizard_id=%d AND question_id=%d AND id=%d', array($wizard_id, $questions_id, $v_key));
                    $check_options_rows = $wpdb->get_row($check_options_qry);
                    if (!empty($check_options_rows)) {
                        $exist_option_id = $check_options_rows->id;
                        $sortable_number = $this->get_last_max_sortabl_question_insert_update($wizard_id, $questions_id, $exist_option_id);
                        if (!empty($exist_option_id) && $exist_option_id != '') {
                            $other_option_data = explode('||', trim($v_value));
                            $wpdb->query($wpdb->prepare("UPDATE " . $options_table_name . " SET option_name = %s, option_attribute=%s, option_attribute_value=%s, created_date=%s, updated_date=%s WHERE id = %d AND wizard_id = %d AND question_id = %d", trim(stripslashes($other_option_data[0])), trim($other_option_data[1]), trim(stripslashes($other_option_data[2])), date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), $v_key, $wizard_id, $questions_id));
                        }
                    } else {
                        $other_option_data = explode('||', trim($v_value));
                        $max_option_sortable_number = $this->get_last_max_sortabl_option_insert_time($wizard_id, $questions_id);
                        $wpdb->query($wpdb->prepare("INSERT INTO " . $options_table_name . "( wizard_id, question_id, option_name,option_image, option_attribute, option_attribute_value, sortable_id, created_date, updated_date ) VALUES ( %d, %d, %s, %s, %s, %s, %d, %s, %s )", trim($wizard_id), trim($questions_id), trim(stripslashes($other_option_data[0])), '', trim($other_option_data[1]), trim($other_option_data[2]), trim($max_option_sortable_number), date("Y-m-d H:i:s"), date("Y-m-d H:i:s")));
                    }
                }
            }
        }
        return $result_option;
    }

    /**
     * Questions list with pagination
     *
     * @since    1.0.0
     * @return html Its return html
     */
    public function get_admin_question_list_with_pagination() {
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;
        if (isset($_REQUEST["wizard_id"]) && !empty($_REQUEST['wizard_id'])) {
            $wizard_id = sanitize_text_field(wp_unslash($_REQUEST["wizard_id"]));
        } else {
            $wizard_id = '';
        }

        if (isset($_REQUEST["pagenum"]) && !empty($_REQUEST['pagenum'])) {
            $page = intval(sanitize_text_field(wp_unslash($_REQUEST['pagenum'])));
        } else {
            $page = 1;
        }

        $limit = (sanitize_text_field(wp_unslash($_REQUEST["limit"])) <> "" && is_numeric(sanitize_text_field(wp_unslash($_REQUEST["limit"]))) ) ? intval(sanitize_text_field(wp_unslash($_REQUEST["limit"]))) : 5;

        $sel_page_qry = $wpdb->prepare('SELECT COUNT(*) AS total_id FROM ' . $questions_table_name . ' WHERE wizard_id=%d', $wizard_id);
        $page_result = $wpdb->get_row($sel_page_qry);
        $total_records = $page_result->total_id;

        $last = ceil($total_records / $limit);

        if ($page < 1) {
            $page = 1;
        } elseif ($page > $last) {
            $page = $last;
        }

        if ($page > 1) {
            $lower_limit = ($page - 1) * $limit;
        } else {
            $lower_limit = '0';
        }

        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id=%d ORDER BY sortable_id ASC LIMIT %d, %d', array($wizard_id, $lower_limit, $limit));

        $sel_rows = $wpdb->get_results($sel_qry);
        $pagination_question_list = '';
        $pagination_question_list .='<table class="table-outer form-table all-table-listing" id="question_list_table">';
        $pagination_question_list .='<thead>';
        $pagination_question_list .='<tr class="wprw-head">';
        $pagination_question_list .='<th><input type="checkbox" name="check_all" class="chk_all_question_class" id="chk_all_question"></th>';
        $pagination_question_list .='<th>' . __('Name', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</th>';
        $pagination_question_list .='<th>' . __('Type', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</th>';
        $pagination_question_list .='<th>' . __('Action', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</th>';
        $pagination_question_list .='</tr>';
        $pagination_question_list .='</thead>';
        $pagination_question_list .='<tbody>';
        if (!empty($sel_rows)) {
            $i = 1;
            foreach ($sel_rows as $sel_data) {
                $question_id = $sel_data->id;
                $wizard_id = $sel_data->wizard_id;
                $question_name = $sel_data->name;
                $question_type = ucfirst($sel_data->option_type);
                $wprwnonce = wp_create_nonce('wppfcnonce');

                $edit_url = home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . '&que_id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce);
                $new_edit_url = html_entity_decode($edit_url);

                $pagination_question_list .='<tr id="after_updated_question_' . $question_id . '">';
                $pagination_question_list .='<td width="10%">';
                $pagination_question_list .='<input type="checkbox" name="chk_single_question_name" class="chk_single_question" value="' . $question_id . '">';
                $pagination_question_list .='</td>';
                $pagination_question_list .='<td>';
                $pagination_question_list .='<a href="' . $new_edit_url . '">' . __($question_name, WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='</td>';
                $pagination_question_list .='<td>' . $question_type . '</td>';
                $pagination_question_list .='<td>';
                //$pagination_question_list .='<a class="fee-action-button button-primary" href="' . home_url('/wp-admin/admin.php?page=wprw-add-new-question&wrd_id=' . $wizard_id . '&que_id=' . $question_id . '&action=edit' . '&_wpnonce=' . $wprwnonce) . '" id="questions_edit_' . $question_id . '">' . __('Edit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                //$pagination_question_list .='<a class="fee-action-button button-primary" href="' . home_url('/wp-admin/admin.php?page=wprw-edit-wizard&wrd_id=' . $wizard_id . '&id=' . $question_id . '&action=delete' . '&_wpnonce=' . $wprwnonce) . '">' . __('Delete', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='<a class="fee-action-button button-primary" href="' . $new_edit_url . '" id="questions_edit_' . $question_id . '">' . __('Edit', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='<a class="fee-action-button button-primary delete_single_question_using_button" href="javascript:void(0);" id="delete_single_selected_question_' . $question_id . '">' . __('Delete', WOO_PRODUCT_RECOMMENDATION_WIZARD_TEXT_DOMAIN) . '</a>';
                $pagination_question_list .='</td>';
                $pagination_question_list .='</tr>';
                $i++;
            }
        } else {
            $pagination_question_list .='<tr>';
            $pagination_question_list .='<td colspan="4">No List Available</td>';
            $pagination_question_list .='</tr>';
        }
        $pagination_question_list .= '</tbody>';
        $pagination_question_list .= '</table>';
        $pagination_question_list .=$this->admin_ajax_pagination($wizard_id, $limit, $page, $last, $total_records);
        echo $pagination_question_list;
        wp_die();
    }

    /**
     * Ajax Pagination
     *
     * @since    1.0.0
     * @param varchar $post check post or not.
     * @param int $wizard_id which options are saved for wizard.
     * @param int $limit which how many data display in list.
     * @param int $page Current page id
     * @param int $last Last page id
     * @param int $total_records Total data
     * @return html Its return html
     */
    public function admin_ajax_pagination($wizard_id, $limit, $page, $last, $total_records) {
        $pagination_list = '';
        $pagination_list .='<div class="tablenav">';
        $pagination_list .='<div class="tablenav-pages" id="custom_pagination">';
        $pagination_list .='<span class="displaying-num">' . $total_records . ' items</span>';
        $pagination_list .='<span class="pagination-links">';
        $page_minus = $page - 1;
        $page_plus = $page + 1;
        if (($page_minus) > 0) {
            $pagination_list .='<a class="first-page" href="javascript:void(0);" class="links" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_1">';
            $pagination_list .='<span class="screen-reader-text">First page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_1" class="pagination_span">«</span></a>';
            $pagination_list .='<a class="prev-page" href="javascript:void(0);" class="links" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_minus . '">';
            $pagination_list .='<span class="screen-reader-text">Previous page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_minus . '" class="pagination_span">‹</span></a>';
        }
        $pagination_list .='<span class="screen-reader-text">Current Page</span>';
        $pagination_list .='<span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' . $page . ' of <span class="total-pages">' . $last . '</span></span></span>';
        if (($page_plus) <= $last) {
            $pagination_list .='<a class="next-page" href="javascript:void(0);" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_plus . '" class="links">';
            $pagination_list .='<span class="screen-reader-text">Next page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $page_plus . '" class="pagination_span">›</span>';
            $pagination_list .='</a>';
        } if (($page) != $last) {
            $pagination_list .='<a class="last-page"href="javascript:void(0);" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $last . '" class="links">';
            $pagination_list .='<span class="screen-reader-text">Last page</span><span aria-hidden="true" id="wd_' . $wizard_id . '_lmt_' . $limit . '_que_' . $last . '" class="pagination_span">»</span>';
            $pagination_list .='</a>';
        }
        $pagination_list .='</span>';
        $pagination_list .='</div>';
        $pagination_list .='</div>';
        return $pagination_list;
    }

    /**
     * Current auto increment id for wizard table
     *
     * @since    1.0.0
     * @param string $table_name Wizard table name.
     * @return int
     */
    public function get_current_auto_increment_id($table_name) {
        global $wpdb;
        $get_current_auto_incr = $wpdb->prepare('SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=%s AND TABLE_NAME=%s', array(DB_NAME, $table_name));
        $get_current_auto_incr_rows = $wpdb->get_row($get_current_auto_incr);
        $current_auto_incr_id = $get_current_auto_incr_rows->AUTO_INCREMENT;
        return $current_auto_incr_id;
    }

    /**
     * Generate auto shortcode
     *
     * @since    1.0.0
     * @param int $current_auto_incr_id Current auto increment wizard id.
     * @return string
     */
    public function create_wizard_shortcode($current_auto_incr_id) {
        $current_shortcode = '[wprw_' . $current_auto_incr_id . ']';
        return $current_shortcode;
    }

    /**
     * Drag and drop question list
     *
     * @since    1.0.0
     */
    public function sortable_question_list_based_on_id() {
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;

        $wizard_id = isset($_REQUEST['wizard_id']) ? sanitize_text_field(wp_unslash($_REQUEST['wizard_id'])) : '';
        $pagenum = isset($_REQUEST['pagenum']) ? sanitize_text_field(wp_unslash($_REQUEST['pagenum'])) : '';
        $limit = isset($_REQUEST['limit']) ? sanitize_text_field(wp_unslash($_REQUEST['limit'])) : '';
        $question_sortable_data = explode(',', isset($_REQUEST['question_sortable_data']) ? sanitize_text_field(wp_unslash($_REQUEST['question_sortable_data'])) : '');

        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id=%d ORDER BY id ASC', $wizard_id);
        $sel_results = $wpdb->get_results($sel_qry);

        $i = 0;
        $j = 0;
        foreach ($question_sortable_data as $value) {
            foreach ($sel_results as $sel_value) {
                $question_id = $sel_value->id;
                if ($value == $question_id) {
                    $j++;
                    $wpdb->query($wpdb->prepare("UPDATE " . $questions_table_name . " SET sortable_id = %d WHERE id = %d AND wizard_id = %d", $j, $question_id, $wizard_id));
                }
            }
            $i++;
        }
        wp_die();
    }

    /**
     * Get last sortable id before updated new wizard sortable record
     *
     * @since    1.0.0
     * @param int $wizard_id wizard id.
     * @return int
     */
    public function get_last_max_sortabl_question_insert_time($wizard_id) {
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;
        $sel_qry = $wpdb->prepare('SELECT MAX(sortable_id) AS max FROM ' . $questions_table_name . ' WHERE wizard_id=%d', $wizard_id);
        $sel_results = $wpdb->get_row($sel_qry);
        $max_question_sortable_number = $sel_results->max;
        $max_question_sortable_number++;
        return $max_question_sortable_number;
    }

    /**
     * After drag and drop updated new sortable question id
     *
     * @since    1.0.0
     * @param int $wizard_id wizard id.
     * @param int $question_id question id.
     * @return int
     */
    public function get_last_max_sortabl_question_insert_update($wizard_id, $question_id) {
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;
        $sel_qry = $wpdb->prepare('SELECT sortable_id FROM ' . $questions_table_name . ' WHERE wizard_id=%d AND id=%d', array($wizard_id, $question_id));
        $sel_results = $wpdb->get_row($sel_qry);
        $current_question_sortable_number = $sel_results->sortable_id;
        return $current_question_sortable_number;
    }

    /**
     * Sortable Option list based on option id
     *
     * @since    1.0.0
     */
    public function sortable_option_list_based_on_id() {
        global $wpdb;
        $options_table_name = OPTIONS_TABLE;

        $wizard_id = isset($_REQUEST['wizard_id']) ? sanitize_text_field(wp_unslash($_REQUEST['wizard_id'])) : '';
        $question_id = isset($_REQUEST['question_id']) ? sanitize_text_field(wp_unslash($_REQUEST['question_id'])) : '';
        $option_sortable_data = explode(',', isset($_REQUEST['option_sortable_data']) ? sanitize_text_field(wp_unslash($_REQUEST['option_sortable_data'])) : '');

        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $options_table_name . ' WHERE wizard_id=%d AND question_id=%d ORDER BY id ASC', array($wizard_id, $question_id));
        $sel_results = $wpdb->get_results($sel_qry);

        $i = 0;
        $j = 0;
        foreach ($option_sortable_data as $value) {
            foreach ($sel_results as $sel_value) {
                $option_id = $sel_value->id;
                if ($value == $option_id) {
                    $j++;
                    $wpdb->query($wpdb->prepare("UPDATE " . $options_table_name . " SET sortable_id = %d WHERE id = %d AND question_id = %d AND wizard_id = %d", $j, $option_id, $question_id, $wizard_id));
                }
            }
            $i++;
        }
        wp_die();
    }

    /**
     * Get last sortable question id before updated new questions sortable record
     *
     * @since    1.0.0
     * @param int $wizard_id wizard id.
     * @param int $question_id question id.
     * @return int
     */
    public function get_last_max_sortabl_option_insert_time($wizard_id, $question_id) {
        global $wpdb;
        $options_table_name = OPTIONS_TABLE;

        $sel_qry = $wpdb->prepare('SELECT MAX(sortable_id) AS max FROM ' . $options_table_name . ' WHERE wizard_id=%d AND question_id=%d', array($wizard_id, $question_id));
        $sel_results = $wpdb->get_row($sel_qry);
        $max_option_sortable_number = $sel_results->max;
        $max_option_sortable_number++;
        return $max_option_sortable_number;
    }

    /**
     * After drag and drop updated new sortable option id
     *
     * @since    1.0.0
     * @param int $wizard_id wizard id.
     * @param int $question_id question id.
     * @param int $option_id option id.
     * @return int
     */
    public function get_last_max_sortabl_option_insert_update($wizard_id, $question_id, $option_id) {
        global $wpdb;
        $options_table_name = OPTIONS_TABLE;

        $sel_qry = $wpdb->prepare('SELECT sortable_id FROM ' . $options_table_name . ' WHERE wizard_id=%d AND question_id=%d AND id=%d', array($wizard_id, $question_id, $option_id));
        $sel_results = $wpdb->get_row($sel_qry);
        $current_option_sortable_number = $sel_results->sortable_id;
        return $current_option_sortable_number;
    }

    /**
     * Total option id for particular question
     *
     * @since    1.0.0
     * @return int
     */
    public function get_total_option_id_for_question() {
        global $wpdb;
        $options_table_name = OPTIONS_TABLE;

        $sel_qry = $wpdb->prepare('SELECT COUNT(id) AS total_option_id FROM ' . $options_table_name . '', '');
        $sel_results = $wpdb->get_row($sel_qry);
        if (!empty($sel_results) && isset($sel_results)) {
            $total_option_id = $sel_results->total_option_id;
        }
        return $total_option_id;
    }

}
