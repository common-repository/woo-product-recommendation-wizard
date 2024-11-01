<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/public
 * @author     Multidots <inquiry@multidots.in>
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Woo_Product_Recommendation_Wizard_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     * @access public
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
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-product-recommendation-wizard-public.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'font-awesome', WPRW_PLUGIN_URL . 'admin/css/font-awesome.min.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
        wp_register_script('productFrontRecommendationWizard', plugin_dir_url(__FILE__) . 'js/woo-product-recommendation-wizard-public.js', array('jquery'), $this->version, false);
        wp_localize_script('productFrontRecommendationWizard', 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php'), 'ajax_icon' => plugin_dir_url(__FILE__) . '/images/ajax-loader.gif'));
        wp_enqueue_script('productFrontRecommendationWizard');
    }

    /**
     * Get the next question when click on next button based on ajax in front side
     *
     * @since    1.0.0
     * @return   html  Its return html for next questions with multiple parameter (sequences : string, html,array with encoded questions id)
     */
    public function get_next_questions_front_side() {
        global $wpdb;
        if (!empty($_REQUEST['current_wizard_id']) && isset($_REQUEST['current_wizard_id'])) {
            $wizard_id = sanitize_text_field(wp_unslash($_REQUEST['current_wizard_id']));
        } else {
            $wizard_id = '';
        }
        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $current_question_id = sanitize_text_field(wp_unslash($_REQUEST['current_question_id']));
        } else {
            $current_question_id = '';
        }
        if (!empty($_REQUEST['sortable_id']) && isset($_REQUEST['sortable_id'])) {
            $sortable_id = sanitize_text_field(wp_unslash($_REQUEST['sortable_id']));
        } else {
            $sortable_id = '';
        }
        ############ Question Result ############
        $question_result = $this->get_all_question_list($wizard_id);
        $question_id_array = array();
        if (!empty($question_result)) {
            foreach ($question_result as $question_result_data) {
                $question_id_array[] = $question_result_data->id;
            }
        }

        ############ All Selected Value ############
        if (!empty($_REQUEST['all_selected_value_id']) && isset($_REQUEST['all_selected_value_id'])) {
            $all_selected_value_id = $_REQUEST['all_selected_value_id'];
        } else {
            $all_selected_value_id = '';
        }

        ############ Get Next Questions ID ############
        $next_question_html = $this->get_next_button_front_side($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id);

        ############ Get Previous Questions ID ############
        $previous_question_html = $this->get_previous_button_front_side($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id);

        ############ Get Next Record ############
        $next_html = '';
        $next_html .= $this->ajax_get_question_option_list_based_on_next_and_previous($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id);
        $next_html .= '<div class="wprw-page-nav-buttons">';
        $next_html .= $previous_question_html;
        $next_html .= $next_question_html;
        $next_html .= '</div>';
        echo json_encode(array('next_html' => $next_html, 'question_id_array' => $question_id_array));
        wp_die();
    }

    /**
     * Get the previous question when click on next button based on ajax in front side
     *
     * @since    1.0.0
     * @return   html  Its return html for previous questions with multiple parameter (sequences : string, html,array with encoded questions id)
     */
    public function get_previous_questions_front_side() {
        global $wpdb;
        if (!empty($_REQUEST['current_wizard_id']) && isset($_REQUEST['current_wizard_id'])) {
            $wizard_id = sanitize_text_field(wp_unslash($_REQUEST['current_wizard_id']));
        } else {
            $wizard_id = '';
        }
        if (!empty($_REQUEST['current_question_id']) && isset($_REQUEST['current_question_id'])) {
            $current_question_id = sanitize_text_field(wp_unslash($_REQUEST['current_question_id']));
        } else {
            $current_question_id = '';
        }
        if (!empty($_REQUEST['sortable_id']) && isset($_REQUEST['sortable_id'])) {
            $sortable_id = sanitize_text_field(wp_unslash($_REQUEST['sortable_id']));
        } else {
            $sortable_id = '';
        }
        ############ Question Result ############
        $question_result = $this->get_all_question_list($wizard_id);
        $question_id_array = array();
        if (!empty($question_result)) {
            foreach ($question_result as $question_result_data) {
                $question_id_array[] = $question_result_data->id;
            }
        }

        ############ All Selected Value ############
        if (!empty($_REQUEST['all_selected_value_id']) && isset($_REQUEST['all_selected_value_id'])) {
            $all_selected_value_id = $_REQUEST['all_selected_value_id'];
        } else {
            $all_selected_value_id = '';
        }

        ############ Get Next Questions ID ############
        $next_question_html = $this->get_next_button_front_side($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id);

        ############ Get Previous Questions ID ############
        $previous_question_html = $this->get_previous_button_front_side($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id);

        ############ Get Previous Record ############
        $previous_html = '';
        $previous_html .= $this->ajax_get_question_option_list_based_on_next_and_previous($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id);
        $previous_html .= '<div class="wprw-page-nav-buttons">';
        $previous_html .= $previous_question_html;
        $previous_html .= $next_question_html;
        $previous_html .= '</div>';
        echo json_encode(array('previous_html' => $previous_html, 'question_id_array' => $question_id_array));
        wp_die();
    }

    /**
     * Get the previous button in front side
     *
     * @since    1.0.0
     * @return   html  Its return previous button with previous question id
     */
    public function get_previous_button_front_side($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id) {
        ############ Get Previous Questions ID ############
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;
        $get_previous_id_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE sortable_id < %d AND wizard_id=%d ORDER BY sortable_id DESC LIMIT %d', array($sortable_id, $wizard_id, '1'));

        $get_previous_id_rows = $wpdb->get_row($get_previous_id_qry);
        $previous_question_html = '';
        if (!empty($get_previous_id_rows) && $get_previous_id_rows != '0') {
            $get_previous_question_id = $get_previous_id_rows->id;
            $get_previous_sortable_id = $get_previous_id_rows->sortable_id;
            $previous_question_html .= '<a class="wprw-button wprw-button-previous" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($get_previous_question_id) . '_cur_' . esc_attr($get_previous_question_id) . '_sortable_' . esc_attr($get_previous_sortable_id) . '" href="javascript:void(0);">';
            $previous_question_html .= '<span class="wprw-back-advisor-label">' . esc_html('Back') . '</span>'; // . $get_previous_question_id
            $previous_question_html .= '</a>';
        } else {
            $get_previous_sortable_id = '';
            $previous_question_html .='';
        }
        return $previous_question_html;
    }

    /**
     * Get the next button in front side
     *
     * @since    1.0.0
     * @return   html  Its return next button with next question id
     */
    public function get_next_button_front_side($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id) {
        ############ Get Next Questions ID ############
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;
        $get_next_id_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE sortable_id>%d AND wizard_id=%d ORDER BY sortable_id ASC LIMIT %d', array($sortable_id, $wizard_id, '1'));

        $get_next_id_rows = $wpdb->get_row($get_next_id_qry);
        $next_question_html = '';
        if (!empty($get_next_id_rows) && $get_next_id_rows != '0') {
            $get_next_question_id = $get_next_id_rows->id;
            $get_next_sortable_id = $get_next_id_rows->sortable_id;
            $next_question_html .= '<a class="wprw-button wprw-button-next wprw-button-inactive" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($get_next_question_id) . '_cur_' . esc_attr($get_next_question_id) . '_sortable_' . esc_attr($get_next_sortable_id) . '" href="javascript:void(0);">';
            $next_question_html .= '<span class="">' . esc_html('Next') . '</span>'; // . $get_next_question_id
            $next_question_html .= '</a>';
        } else {
            $get_next_sortable_id = '';
            $next_question_html .= '';
        }
        return $next_question_html;
    }

    /**
     * Get option list with questions based on next and prev button in front side
     *
     * @since    1.0.0
     * @return   html  Its return question list with options
     */
    public function ajax_get_question_option_list_based_on_next_and_previous($wizard_id, $current_question_id, $all_selected_value_id, $sortable_id) {
        global $wpdb;
        $wizard_table_name = WIZARDS_TABLE;
        $questions_table_name = QUESTIONS_TABLE;
        $options_table_name = OPTIONS_TABLE;

        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id=%d AND id=%d ORDER BY id ASC', array($wizard_id, $current_question_id));
        $sel_rows = $wpdb->get_results($sel_qry);
        $ajax_html = '';
        if (!empty($sel_rows)) {
            foreach ($sel_rows as $sel_data) {
                $question_id = $sel_data->id;
                $question_name = $sel_data->name;
                $option_type = trim($sel_data->option_type);

                $sel_qry = $wpdb->prepare('SELECT * FROM ' . $options_table_name . ' WHERE wizard_id=%d AND question_id=%d ORDER BY sortable_id ASC', array($wizard_id, $question_id));
                $sel_rows = $wpdb->get_results($sel_qry);

                $ajax_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . esc_attr($question_id) . '">';
                ############ Question Result ############
                $ajax_html .= '<div class="wprw-question-text-panel">';
                $ajax_html .= '<div class="wprw-question-text">' . esc_html($question_name) . '</div>';
                $ajax_html .= '</div>';
                $ajax_html .= '<ol wprw-radiobutton="" class="wprw-answers">';

                if (!empty($sel_rows)) {
                    $i = 0;
                    foreach ($sel_rows as $sel_data) {
                        $i++;
                        $option_id = $sel_data->id;
                        $option_name = $sel_data->option_name;
                        $option_attribute = $sel_data->option_attribute;
                        $option_attribute_value = $sel_data->option_attribute_value;

                        if ($option_type == 'radio') {
                            $div_answer_action_class = 'radio';
                        }
                        $ajax_html .= '<li class="wprw-answer wprw-selected-answer" id="opt_attr_' . esc_attr($option_id) . '">';
                        $ajax_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                        $ajax_html .= '<div class="wprw-answer-action wprw-action-element wprw-' . esc_attr($div_answer_action_class) . '">';
                        $ajax_html .= '<span class="wprw-answer-selector">';
                        if ($option_type == 'radio') {
                            $ajax_html .= '<div class="roundedTwo"><input class="wprw-input" type="radio" value="' . esc_attr($option_id) . '" name="option_name" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '"><label class="label_input"></label></div> ';
                        }
                        $ajax_html .= '<span class="wprw-label-element wprw-answer-label">';
                        $ajax_html .= '<span class="wprw-answer-label wprw-label-element">' . esc_html($option_name) . '</span>';
                        $ajax_html .= '</span>';
                        $ajax_html .= '</span>';
                        $ajax_html .= '</div>';
                        $ajax_html .= '</div>';
                        $ajax_html .= '</li>';
                    }
                }
                $ajax_html .= '</ol>';
                $ajax_html .= '</li>';
            }
        }
        return $ajax_html;
    }

    /**
     * Get Product list when select option in front side
     *
     * @since    1.0.0
     * @return   html  Its return html for get product results with multiple parameter (sequences : string, matched product html,recently matched product html,pagination html,array with encoded attribute value for passing jquery,array with encoded attribute value)
     */
    public function get_ajax_woocommerce_product_list() {
        global $product, $wpdb;

        ######################### General Setting ########################
        $wizard_general_option = get_option('wizard_general_option');
        $perfect_match_title = isset($wizard_general_option['perfect_match_title']) ? sanitize_text_field(wp_unslash($wizard_general_option['perfect_match_title'])) : WPRW_PERFECT_MATCH_TITLE;
        $recent_match_title = isset($wizard_general_option['recent_match_title']) ? sanitize_text_field(wp_unslash($wizard_general_option['recent_match_title'])) : WPRW_RECENT_MATCH_TITLE;
        if (isset($wizard_general_option['backend_limit']) && !empty($wizard_general_option['backend_limit']) && sanitize_text_field(wp_unslash($wizard_general_option['backend_limit'])) != '0') {
            $backend_limit = sanitize_text_field(wp_unslash($wizard_general_option['backend_limit']));
        } else {
            $backend_limit = WPRW_DEFAULT_PAGINATION_NUMBER;
        }

        ######################### Request Data ########################
        $wizard_id = isset($_REQUEST['current_wizard_id']) ? sanitize_text_field(wp_unslash($_REQUEST['current_wizard_id'])) : '';
        $question_id = isset($_REQUEST['current_question_id']) ? sanitize_text_field(wp_unslash($_REQUEST['current_question_id'])) : '';
        $option_id = isset($_REQUEST['current_option_id']) ? sanitize_text_field(wp_unslash($_REQUEST['current_option_id'])) : '';
        $all_selected_value = isset($_REQUEST['all_selected_value']) ? $_REQUEST['all_selected_value'] : '';
        $current_selected_value = isset($_REQUEST['current_selected_value']) ? sanitize_text_field(wp_unslash($_REQUEST['current_selected_value'])) : $all_selected_value;


        $options_table_name = OPTIONS_TABLE;

        $wizard_attribute_id = '';
        $category_name = array();
        $wizard_attribute_category = array();
        $wizard_attribute_id = array();

        $wizard_table_name = WIZARDS_TABLE;

        $sel_wizard_qry = $wpdb->prepare('SELECT * FROM ' . $wizard_table_name . ' WHERE id=%d', $wizard_id);
        $sel_wizard_rows = $wpdb->get_results($sel_wizard_qry);

        if (!empty($sel_wizard_rows) && $sel_wizard_rows != '') {
            foreach ($sel_wizard_rows as $sel_wizard_data) {
                $get_wizard_id = $sel_wizard_data->id;
                if (!empty($get_wizard_id)) {
                    $wizard_attribute_id[$get_wizard_id] = $sel_wizard_data->wizard_category;
                }
            }
        }

        if (!empty($wizard_attribute_id)) {
            $wizard_attribute_id = implode(" ,", $wizard_attribute_id);
        }

        ################################### Start Category Wise Product in Wizard #####################################
        $category_wise = "";
        $category_wise .= "SELECT GROUP_CONCAT(DISTINCT {$wpdb->prefix}posts.ID) AS category_wise_product";
        $category_wise .= " FROM {$wpdb->prefix}posts";
        $category_wise .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $category_wise .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        if (!empty($wizard_attribute_id)) {
            $category_wise .= " INNER JOIN {$wpdb->prefix}term_relationships";
            $category_wise .= " ON ({$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id)";
        }
        $category_wise .= " WHERE";
        $category_wise .= " {$wpdb->prefix}posts.post_type =%s";
        $category_wise .= " AND {$wpdb->prefix}posts.post_status = %s";
        if (!empty($wizard_attribute_id)) {
            $category_wise .= " AND ({$wpdb->prefix}term_relationships.term_taxonomy_id IN ($wizard_attribute_id))";
        }
        $category_wise .= " GROUP BY {$wpdb->prefix}posts.post_author";
        $category_wise_sql = $wpdb->prepare($category_wise, array('product', 'publish'));
        $category_wise_result = $wpdb->get_row($category_wise_sql);
        $category_wise_product = $category_wise_result->category_wise_product;
        ################################### End Category Wise Product in Wizard #####################################
        $check_its_meta_attribute_or_not = $this->checkMetaAttributeOrNot($wizard_id, $all_selected_value, $wizard_attribute_id);

        if (!empty($check_its_meta_attribute_or_not)) {
            $check_its_meta_attribute_or_not = implode(" ,", $check_its_meta_attribute_or_not);
        }

        $single_opion_value_frm_db = $this->get_option_value_based_on_option_id($all_selected_value, $wizard_id);
        $single_opion_name_frm_db = $this->get_option_name_based_on_option_id($all_selected_value, $wizard_id);

        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE wizard_id=%d";
        $sel_qry .= " AND id IN (" . stripslashes($all_selected_value) . ")";
        $sel_qry .= " ORDER BY id DESC";
        $sel_qry_prepare = $wpdb->prepare($sel_qry, array($wizard_id));
        $sel_rows = $wpdb->get_results($sel_qry_prepare);

        $fetch_attribute_value_array = array();
        $fetch_attribute_value_pass_jquery = array();
        $option_attribute_arr = array();
        $fetch_option_attribute_value_arr = array();
        $fetch_attribute_value_pass_jquery_merge = array();
        foreach ($sel_rows as $sel_data) {
            $option_attribute = trim($sel_data->option_attribute);
            $fetch_option_attribute_value = trim(str_replace(", ", ",", $sel_data->option_attribute_value));
            //$fetch_attribute_value_array[] = trim($fetch_option_attribute_value);
            $option_attribute_arr[] = trim($sel_data->option_attribute);
            $fetch_option_attribute_value_arr[] = trim(str_replace(", ", ",", $sel_data->option_attribute_value));
            $fetch_option_attribute_value = str_replace(', ', ",", $fetch_option_attribute_value);
            $fetch_attribute_value_array[][trim($option_attribute)] = trim($fetch_option_attribute_value); //for function
            if (!empty($fetch_attribute_value_pass_jquery)) {
                $fetch_attribute_value_pass_jquery_merge[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
                if (array_key_exists(trim(strtolower($option_attribute)), $fetch_attribute_value_pass_jquery)) {
                    foreach ($fetch_attribute_value_pass_jquery as $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value) {
                        $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value . "," . trim(strtolower(str_replace(", ", ",", $sel_data->option_attribute_value)));
                    }
                } else {
                    $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
                }
            } else {
                $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
            }
        }

        $all_fetch_attribute_value_array = array();
        $all_option_attribute = array();
        $all_fetch_option_attribute_value_arr = array();
        $all_fetch_match_attribute_value_array = array();
        foreach ($sel_rows as $all_sel_data) {
            $all_option_single_id = trim($all_sel_data->id);
            $all_option_single_attribute = trim($all_sel_data->option_attribute);
            $all_fetch_option_attribute_value = trim(str_replace(", ", ",", $all_sel_data->option_attribute_value));
            $all_fetch_option_attribute_value_arr[][$all_option_single_id] = trim(str_replace(", ", ",", $all_sel_data->option_attribute_value));
            $all_option_attribute[] = trim($all_sel_data->option_attribute);
            $all_fetch_attribute_value_array[][trim($all_option_single_attribute)] = trim($all_fetch_option_attribute_value); //for function
            $all_fetch_match_attribute_value_array[trim($all_option_single_attribute)] = trim($all_fetch_option_attribute_value); //for function
        }

        $all_fetch_oopt_att_val_n_arr = array();
        $all_check_oopt_att_val_n_arr = array();
        foreach ($all_option_attribute as $all_opt_name_key => $all_opt_name_value) {
            foreach ($all_fetch_option_attribute_value_arr as $all_key => $all_value) {
                foreach ($all_value as $all_value_key => $all_value_value) {
                    if ($all_opt_name_key == $all_key) {
                        $all_fetch_oopt_att_val_n_arr[] = $all_opt_name_value . "||" . $all_value_value;
                        $all_check_oopt_att_val_n_arr[] = $all_opt_name_value . "||" . $all_value_value;
                    }
                }
            }
        }

        ################################### Get All Product Attribute ###################################
        $get_all_prd_attr = $this->get_all_attribute_value();
        $get_all_product_id = $this->get_all_product_id();
        if (!empty($get_all_product_id)) {
            $get_all_product_id_with_comma = implode(" ,", $get_all_product_id);
        }

        $check_combine_qry = "";
        $check_combine_qry .= "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}posts.ID";
        $check_combine_qry .= " FROM {$wpdb->prefix}posts";
        $check_combine_qry .= " WHERE";
        $check_combine_qry .= " {$wpdb->prefix}posts.post_type =%s";
        $check_combine_qry .= " AND {$wpdb->prefix}posts.post_status =%s";
        $check_combine_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $check_combine_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $check_combine_qry .= " ASC";
        $check_combine_qry_prepare = $wpdb->prepare($check_combine_qry, array('product', 'publish'));
        $check_combine_products_result = $wpdb->get_results($check_combine_qry_prepare);

        $test_prev_result_value = array();
        $test_value_arr = array();
        $test_custom_product_attributes_name = array();
        $test_custom_product_attributes = array();
        $test_custom_product_attributes_arr = array();
        $test_custom_product_attributes_arr_arr = array();

        $fetch_attribute_value_pass_jquery_test = $fetch_attribute_value_pass_jquery;
        $fetch_attribute_value_pass_jquery_test_result_data = array();
        $arr_fetch_record_custom_array = array();

        $arr_fetch_record_custom_array_for_class = array();

        //ug code for make order query
        foreach ($fetch_attribute_value_pass_jquery_test as $fetch_attribute_value_pass_jquery_test_result_key => $fetch_attribute_value_pass_jquery_test_result) {
            $fetch_attribute_value_pass_jquery_test_resultkey = $fetch_attribute_value_pass_jquery_test_result_key;
            $data_array = explode(',', $fetch_attribute_value_pass_jquery_test_result);
            $fetch_attribute_value_pass_jquery_test_result = implode(',', array_unique(explode(',', $fetch_attribute_value_pass_jquery_test_result)));
            foreach (explode(',', $fetch_attribute_value_pass_jquery_test_result) as $line) {
                $arr_fetch_record_custom_array[][$fetch_attribute_value_pass_jquery_test_resultkey] = trim($line);
            }
            $arr_fetch_record_custom_array_for_class[][$fetch_attribute_value_pass_jquery_test_resultkey] = $fetch_attribute_value_pass_jquery_test_result;
            $fetch_attribute_value_pass_jquery_test_result_data[$fetch_attribute_value_pass_jquery_test_resultkey] = $fetch_attribute_value_pass_jquery_test_result;
        }

        if (!empty($check_combine_products_result) && isset($check_combine_products_result) && $check_combine_products_result != 'false') {
            $prev_result_value = array();
            $value_arr = array();
            $array_install_id_to_order_by_product = array();
            $array_install_id_to_order_by_not_match_product = array();
            $store_id = array();
            $arr_fetch_record_custom_array_test = $arr_fetch_record_custom_array;
            $convert_two_dimesioanl_array = new RecursiveIteratorIterator(new RecursiveArrayIterator($arr_fetch_record_custom_array_test));
            $convert_two_dimesioanl_array_into_one = iterator_to_array($convert_two_dimesioanl_array, false);

            foreach ($check_combine_products_result as $prd_data) {
                $theid = $prd_data->ID;
                $match_id_and_counter = 0;
                $not_match_id_and_counter = 0;
                $currency = '$';
                $regular_price = get_post_meta($theid, '_regular_price', true);
                $sale_price = get_post_meta($theid, '_sale_price', true);

                if (!empty($get_all_prd_attr) && isset($get_all_prd_attr)) {
                    foreach ($get_all_prd_attr as $all_key => $all_value) {
                        if ($all_key == $theid) {
                            foreach ($all_value as $key => $value) {
                                if (strpos($value, '|') !== false) {
                                    $attribute_value_ex = explode('|', trim($value));
                                } else {
                                    $attribute_value_ex = array($value);
                                }
                                foreach ($attribute_value_ex as $att_key => $att_value) {
                                    if (!empty($att_value) && isset($att_value)) {
                                        $get_option_id = $this->get_option_id_based_on_option_value(trim($att_value), trim($key), $wizard_id);
                                        if (!empty($get_option_id)) {
                                            if (strpos($get_option_id, ',') !== false) {
                                                $att_option_id = str_replace(',', '_', $get_option_id);
                                            } else {
                                                $att_option_id = $get_option_id;
                                            }
                                        } else {
                                            $att_option_id = '';
                                        }
                                        if (!empty($arr_fetch_record_custom_array)) {
                                            foreach ($arr_fetch_record_custom_array as $arr_fetch_record_custom_array_result) {
                                                foreach ($arr_fetch_record_custom_array_result as $arr_fetch_record_custom_array_key => $arr_fetch_record_custom_array_for_match_product_id) {
                                                    if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key) && (in_array(trim(strtolower($att_value)), $arr_fetch_record_custom_array_result))) {// 
                                                        $match_id_and_counter++;
                                                        $array_install_id_to_order_by_product[$theid] = $match_id_and_counter;
                                                    } else if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key ) && (!in_array(trim(strtolower($att_value)), $convert_two_dimesioanl_array_into_one) ) && (!in_array($theid . "," . $att_option_id, $store_id))) {
                                                        $not_match_id_and_counter++;
                                                        $store_id[] = $theid . "," . $att_option_id;
                                                        $array_install_id_to_order_by_not_match_product[$theid] = $not_match_id_and_counter;
                                                    } else if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key ) && (!in_array(trim(strtolower($att_value)), $convert_two_dimesioanl_array_into_one) ) && (!in_array($theid . "," . $att_option_id, $store_id))) {
                                                        $not_match_id_and_counter++;
                                                        $store_id[] = $theid . "," . $att_option_id;
                                                        $array_install_id_to_order_by_not_match_product[$theid] = $not_match_id_and_counter;
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

        $order_result_by_id = '';
        if (!empty($array_install_id_to_order_by_product) || !empty($array_install_id_to_order_by_not_match_product)) {
            $result_order_by_id = $array_install_id_to_order_by_product;
            arsort($result_order_by_id);
            $array = $result_order_by_id;
            // match the product logic
            $counts = array_count_values($array);
            $filtered = array_filter($array, function ($value) use ($counts) {
                return $counts[$value] > 1;
            });
            // make the match array
            $test = array();
            foreach ($filtered as $filtered_key => $filtered_val) {
                $test[$filtered_key] = ($filtered_key);
            }

            //check the array with match value
            $global_not_match_array = array();
            foreach ($test as $test_val) {
                if (array_key_exists($test_val, $array_install_id_to_order_by_not_match_product)) {
                    $global_not_match_array[$test_val] = $array_install_id_to_order_by_not_match_product[$test_val];
                }
            }
            asort($global_not_match_array);
            ######### Find Commom Key From Match Array and Not Match Array #########
            arsort($array_install_id_to_order_by_product);
            $array_common_key = array_intersect_key($array_install_id_to_order_by_product, $array_install_id_to_order_by_not_match_product);
            ######### Combine Match Key And Commom Key  #########
            $com_match_comm_key = $array_install_id_to_order_by_product + $array_common_key;
            ######### Find Diff Key From Match Array and Not Match Array  #########
            $diff_from_match_and_not_match = array_diff_key($array_install_id_to_order_by_not_match_product, $array_install_id_to_order_by_product);
            ######### Combine  #########
            $all_combine = $com_match_comm_key + $diff_from_match_and_not_match;
            ############### diff key from all product key and combine key ##################
            $all_id_result = array_diff_key($get_all_product_id, $all_combine);
            $final_result = $all_combine + $all_id_result;
            $order_result_test = implode(", ", array_keys($final_result)); //$result12
            ############### New code ##################

            $order_result_by_id = '';
            if (!empty($result_order_by_id)) {
                $order_result_by_id = implode(", ", array_keys($result_order_by_id));
            }
        }

        update_option('woocommerce_recommoded_product_record', $order_result_by_id);

        ##################### Start For Both Perfect And Recently Pagination #####################  
        $total_count_qry = "";
        $total_count_qry .= "SELECT count(post_table.ID) AS total_id"; //count(*) AS total_id
        $total_count_qry .= " FROM (SELECT {$wpdb->prefix}posts.ID";
        $total_count_qry .= " FROM {$wpdb->prefix}posts";
        $total_count_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $total_count_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $total_count_qry .= " WHERE";
        $total_count_qry .= " {$wpdb->prefix}posts.post_type =%s";
        $total_count_qry .= " AND {$wpdb->prefix}posts.post_status =%s";
        if (!empty($check_its_meta_attribute_or_not)) {
            $total_count_qry .= " AND ({$wpdb->prefix}posts.ID IN ($check_its_meta_attribute_or_not))";
        } else {
            $total_count_qry .= " AND ({$wpdb->prefix}posts.ID NOT IN (" . $get_all_product_id_with_comma . "))";
        }
        $total_count_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $total_count_qry .= " union all";
        $total_count_qry .= " SELECT {$wpdb->prefix}posts.ID";
        $total_count_qry .= " FROM {$wpdb->prefix}posts";
        $total_count_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $total_count_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $total_count_qry .= " WHERE";
        $total_count_qry .= " {$wpdb->prefix}posts.post_type =%s";
        $total_count_qry .= " AND {$wpdb->prefix}posts.post_status =%s";
        if (!empty($check_its_meta_attribute_or_not)) {
            $total_count_qry .= " AND ({$wpdb->prefix}posts.ID NOT IN ($check_its_meta_attribute_or_not))";
        } else {
            $total_count_qry .= " AND ({$wpdb->prefix}posts.ID IN (" . $get_all_product_id_with_comma . "))";
        }
        $total_count_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $total_count_qry .=" )";
        $total_count_qry .=" as post_table";
        $total_count_qry_prepare = $wpdb->prepare($total_count_qry, array('product', 'publish', 'product', 'publish'));

        $page_result = $wpdb->get_row($total_count_qry_prepare);
        $total_records = $page_result->total_id;

        $page = isset($_REQUEST['pagenum']) ? sanitize_text_field(wp_unslash($_REQUEST['pagenum'])) : '1';
        $limit = isset($_REQUEST['limit']) ? sanitize_text_field(wp_unslash($_REQUEST['limit'])) : $backend_limit;

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

        ################################### Final Result based on noth query ###################################
        $perfect_page_qry = "";
        $perfect_page_qry .= " SELECT  pq.ID AS common_id,pq.ID AS perfect_id,0 as recently_id"; //,null as recently_id
        $perfect_page_qry .= " FROM {$wpdb->prefix}posts AS pq";
        $perfect_page_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $perfect_page_qry .= " ON (pq.ID = m1.post_id)";
        $perfect_page_qry .= " WHERE";
        $perfect_page_qry .= " pq.post_type =%s";
        $perfect_page_qry .= " AND pq.post_status =%s";
        if (!empty($check_its_meta_attribute_or_not)) {
            $perfect_page_qry .= " AND (pq.ID IN ($check_its_meta_attribute_or_not))";
        } else {
            $perfect_page_qry .= " AND (pq.ID NOT IN (" . $get_all_product_id_with_comma . "))";
        }
        $perfect_page_qry .= " GROUP by common_id";

        $recently_page_qry = "";
        $recently_page_qry .= " SELECT rq.ID AS common_id,0 as perfect_id, rq.ID AS recently_id"; //,null as perfect_id
        $recently_page_qry .= " FROM {$wpdb->prefix}posts AS rq";
        $recently_page_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $recently_page_qry .= " ON (rq.ID = m1.post_id)";
        $recently_page_qry .= " WHERE";
        $recently_page_qry .= " rq.post_type =%s";
        $recently_page_qry .= " AND rq.post_status =%s";
        if (!empty($check_its_meta_attribute_or_not)) {
            $recently_page_qry .= " AND (rq.ID NOT IN ($check_its_meta_attribute_or_not))";
        } else {
            $recently_page_qry .= " AND (rq.ID IN (" . $get_all_product_id_with_comma . "))";
        }
        $recently_page_qry .= " GROUP by common_id";

        $combine_qry = "";
        $combine_qry .= " (";
        $combine_qry .= $perfect_page_qry;
        $combine_qry .= " )";
        $combine_qry .= " union all";
        $combine_qry .= " (";
        $combine_qry .= $recently_page_qry;
        $combine_qry .= " )";
        if (!empty($result_order_by_id) && !empty($order_result_test)) {
            $combine_qry .= " ORDER BY FIELD(common_id ,$order_result_test)";
        }
        $combine_qry .= " LIMIT %d,%d";
        $combine_qry_prepare = $wpdb->prepare($combine_qry, array('product', 'publish', 'product', 'publish', $lower_limit, $limit));
        $combine_products_result = $wpdb->get_results($combine_qry_prepare);
        ##################### End For Both Perfect And Recently Pagination #####################        

        if (!empty($combine_products_result) && isset($combine_products_result) && $combine_products_result != 'false') {
            $product_html = '';
            $store_product_html = '';
            $product_title_class = 'style="display:none;';
            $recently_title_class = 'style="display:none;';
            foreach ($combine_products_result as $prd_data) {
                $perfect_id = $prd_data->perfect_id;
                $recently_id = $prd_data->recently_id;
                if (!empty($perfect_id) && isset($perfect_id) && $perfect_id != '0') {
                    $product_title_class = 'style="display:block"';
                } else if (!empty($perfect_id) && !empty($recently_id)) {
                    $product_title_class = 'style="display:block;"';
                    $recently_title_class = 'style="display:block;"';
                } else if (!empty($recently_id) && isset($recently_id) && $recently_id != '0') {
                    $recently_title_class = 'style="display:block;"';
                } else {
                    $recently_title_class = 'style="display:none;"';
                    $product_title_class = 'style="display:none;"';
                }
            }
            $product_html .= '<div class="wprw-product-headline" id="perfect_fit_product_id" ' . wp_kses_post($product_title_class) . '>' . esc_html($perfect_match_title) . '</div>';
            $store_product_html .= '<div class="wprw-product-headline" id="recently_fit_product_id" ' . wp_kses_post($recently_title_class) . '>' . esc_html($recent_match_title) . '</div>';

            $store_whole_html_into_jsone = array();
            $i = 0;
            foreach ($combine_products_result as $prd_data) {
                $i++;
                $perfect_id = $prd_data->perfect_id;
                if (!empty($perfect_id) && isset($perfect_id) && $perfect_id != '0') {
                    $product = new WC_Product($perfect_id);
                    $_product = wc_get_product($perfect_id);
                    $variation_data = $product->get_attributes();
                    if (!empty($variation_data) && isset($variation_data)) {
                        foreach ($variation_data as $attribute) {
                            $custom_product_attributes_name[] = explode('|', $attribute['name']);
                            $custom_product_attributes[] = explode('|', $attribute['value']);
                            $custom_product_attributes_arr[][$perfect_id] = $attribute['name'] . "||" . $attribute['value'];
                            $custom_product_attributes_arr_arr[$attribute['name']] = $attribute['value'];
                        }
                    }
                    ######### Product Div Structure #########
                    $product_html .= '<div class="prd_section" id="prd_' . esc_attr($perfect_id) . '">';
                    $product_html .= '<div class="prd_detail">';
                    $product_html .= '<div class="prd_top_detail">';
                    $product_html .= '<div class="prd_title left_title">';
                    $product_html .= '<a class="woo-product-detail-link" href="' . esc_url(get_the_permalink($perfect_id)) . '">' . esc_html(get_the_title($perfect_id)) . '</a>';
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_compare right_compare">';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_middle_detail">';
                    $product_html .= '<div class="prd_image left_image">';
                    if (has_post_thumbnail($perfect_id)) {
                        $product_html .= '<a class="woo-product-detail-link" href="' . esc_url(get_the_permalink($perfect_id)) . '">' . wp_kses_post(get_the_post_thumbnail($perfect_id, 'shop_thumbnail')) . '</a>';
                    } else {
                        $product_html .= '<a class="woo-product-detail-link" href="' . esc_url(get_the_permalink($perfect_id)) . '"><img src="' . esc_url(wc_placeholder_img_src()) . '" alt="Awaiting product image" class="wp-post-image" /></a>';
                    }
                    $product_html .= '</div>';
                    $product_html .= '<div class="main_prd_attribute middle_attribute">';
                    $product_html .= '<div class="prd_attribute_list">';
                    $product_html .= '<div class="prd-overlay-attributes">';
                    if (!empty($get_all_prd_attr) && isset($get_all_prd_attr)) {
                        foreach ($get_all_prd_attr as $all_key => $all_value) {
                            if ($all_key == $perfect_id) {
                                foreach ($all_value as $key => $value) {
                                    if (strpos($value, '|') !== false) {
                                        $attribute_value_ex = explode('|', trim(strtolower(str_replace(' ', '', $value))));
                                    } else {
                                        $attribute_value_ex = array(trim(strtolower(str_replace(' ', '', $value))));
                                    }
                                    $class = '';
                                    $match_or_not_id = '';
                                    if (!empty($arr_fetch_record_custom_array_for_class)) {
                                        foreach ($arr_fetch_record_custom_array_for_class as $arr_fetch_record_custom_array_result) {
                                            foreach ($arr_fetch_record_custom_array_result as $arr_fetch_record_custom_array_key => $arr_fetch_record_custom_array_for_match_product_id) {
                                                if (strpos($arr_fetch_record_custom_array_for_match_product_id, ',') !== false) {
                                                    $arr_fetch_record_custom_array_for_match_product_id_ex = explode(',', trim(strtolower(str_replace(' ', '', $arr_fetch_record_custom_array_for_match_product_id))));
                                                } else {
                                                    $arr_fetch_record_custom_array_for_match_product_id_ex = array(trim(strtolower(str_replace(' ', '', $arr_fetch_record_custom_array_for_match_product_id))));
                                                }
                                                if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key) && array_intersect($arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex)) {// 
                                                    $class = 'prd-positive-attr';
                                                    $match_or_not_id = 'match_id';
                                                } else if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key ) && !array_intersect($arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex)) {// )) {// 
                                                    $class = 'prd-negative-attr';
                                                    $match_or_not_id = 'not_match_id';
                                                }
                                            }
                                        }
                                    }
                                    $product_html .= '<div class="prd-attribute ' . esc_attr($class) . '"><span id="' . esc_attr(trim(strtolower($key))) . '" class="prd_attribute_name">' . esc_html($key) . ': </span><span id="' . esc_attr(trim(strtolower($value))) . '" class="prd_attribute_value">' . esc_html($value) . '</span></div>';
                                }
                            }
                        }
                    }
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_view_more_attribute">';
                    $product_html .= '<a class="view_more_btn" href="javascript:void(0);" id="view_more_btn_' . esc_attr($perfect_id) . '" style="display:none;">' . esc_html('View More') . '</a>';
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_show_less_attribute">';
                    $product_html .= '<a class="show_less_btn" href="javascript:void(0);" id="show_less_btn_' . esc_attr($perfect_id) . '" style="display:none;">' . esc_html('Show Less') . '</a>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_price right_bottom_price">';
                    $product_html .= '<div class="product-details">';
                    $product_html .= '<div class="wprw-product-price">';
                    $product_html .= '<span class="prd_sale_price">';
                    if ($_product->is_type('simple')) {
                        $product_html .= wp_kses_post($product->get_price_html());
                    } else {
                        $prices = $_product->get_variation_prices(true);
                        $min_price = current($prices['price']);
                        $max_price = end($prices['price']);
                        $min_reg_price = current($prices['regular_price']);
                        $max_reg_price = end($prices['regular_price']);

                        if ($min_price !== $max_price) {
                            $price = wc_format_price_range($min_price, $max_price);
                        } elseif ($min_reg_price === $max_reg_price) {
                            $price = wc_format_sale_price(wc_price($max_reg_price), wc_price($min_price));
                        } else {
                            $price = wc_price($min_price);
                        }
                        $product_html .= wp_kses_post($price);
                    }

                    $product_html .= '</span>';
                    $product_html .= '</div>';
                    $product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . esc_url(get_the_permalink($perfect_id)) . '">';
                    $product_html .= '<span class="prd_detail_name">Details</span>';
                    $product_html .= '</a>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                }
                $recently_id = $prd_data->recently_id;
                if (!empty($recently_id) && isset($recently_id) && $recently_id != '0') {
                    $product = new WC_Product($recently_id);
                    $_product = wc_get_product($recently_id);
                    $variation_data = $product->get_attributes();
                    foreach ($variation_data as $attribute) {
                        $custom_product_attributes_name[] = explode('|', $attribute['name']);
                        $custom_product_attributes[] = explode('|', $attribute['value']);
                        $custom_product_attributes_arr [][$recently_id] = $attribute['name'] . "||" . $attribute['value'];
                        $custom_product_attributes_arr_arr[$recently_id][$attribute['name']] = $attribute['value'];
                    }

                    /* html for store product in json */
                    $store_product_html .= '<div class="prd_section" id="prd_' . esc_attr($recently_id) . '">';
                    $store_product_html .= '<div class="prd_detail">';
                    $store_product_html .= '<div class="prd_top_detail">';
                    $store_product_html .= '<div class="prd_title left_title">';
                    $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url(get_the_permalink($recently_id)) . '">' . esc_html(get_the_title($recently_id)) . '</a>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd_compare right_compare">';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd_middle_detail">';
                    $store_product_html .= '<div class="prd_image left_image">';
                    if (has_post_thumbnail($recently_id)) {
                        $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url(get_the_permalink($recently_id)) . '">' . wp_kses_post(get_the_post_thumbnail($recently_id, 'shop_thumbnail')) . '</a>';
                    } else {
                        $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url(get_the_permalink($recently_id)) . '"><img src="' . esc_url(wc_placeholder_img_src()) . '" alt="Awaiting product image" class="wp-post-image" /></a>';
                    }
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="main_prd_attribute middle_attribute">';
                    $store_product_html .= '<div class="prd_attribute_list">';
                    $store_product_html .= '<div class="prd-overlay-attributes">';

                    if (!empty($get_all_prd_attr) && isset($get_all_prd_attr)) {
                        foreach ($get_all_prd_attr as $all_key => $all_value) {
                            if ($all_key == $recently_id) {
                                foreach ($all_value as $key => $value) {
                                    if (strpos($value, '|') !== false) {
                                        $attribute_value_ex = explode('|', trim(strtolower(str_replace(' ', '', $value))));
                                    } else {
                                        $attribute_value_ex = array(trim(strtolower(str_replace(' ', '', $value))));
                                    }
                                    $class = '';
                                    $match_or_not_id = '';
                                    if (!empty($arr_fetch_record_custom_array_for_class)) {
                                        foreach ($arr_fetch_record_custom_array_for_class as $arr_fetch_record_custom_array_result) {
                                            foreach ($arr_fetch_record_custom_array_result as $arr_fetch_record_custom_array_key => $arr_fetch_record_custom_array_for_match_product_id) {
                                                if (strpos($arr_fetch_record_custom_array_for_match_product_id, ',') !== false) {
                                                    $arr_fetch_record_custom_array_for_match_product_id_ex = explode(',', trim(strtolower(str_replace(' ', '', $arr_fetch_record_custom_array_for_match_product_id))));
                                                } else {
                                                    $arr_fetch_record_custom_array_for_match_product_id_ex = array(trim(strtolower(str_replace(' ', '', $arr_fetch_record_custom_array_for_match_product_id))));
                                                }
                                                if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key) && array_intersect($arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex)) {// 
                                                    $class = 'prd-positive-attr';
                                                    $match_or_not_id = 'match_id';
                                                } else if (!empty($arr_fetch_record_custom_array_key) && (strtolower($key) == $arr_fetch_record_custom_array_key ) && !array_intersect($arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex)) {// )) {// 
                                                    $class = 'prd-negative-attr';
                                                    $match_or_not_id = 'not_match_id';
                                                }
                                            }
                                        }
                                    }
                                    $store_product_html .= '<div class="prd-attribute ' . esc_attr($class) . '"><span id="' . esc_attr(trim(strtolower($key))) . '" class="prd_attribute_name">' . esc_html($key) . ': </span><span id="' . esc_attr(trim(strtolower($value))) . '" class="prd_attribute_value">' . esc_html($value) . '</span></div>';
                                }
                            }
                        }
                    }
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd-view_more_attribute">';
                    $store_product_html .= '<a class="view_more_btn" href="javascript:void(0);" id="view_more_btn_' . esc_attr($recently_id) . '" style="display:none;">' . esc_html('View More') . '</a>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd_show_less_attribute">';
                    $store_product_html .= '<a class="show_less_btn" href="javascript:void(0);" id="show_less_btn_' . esc_attr($recently_id) . '" style="display:none;">' . esc_html('Show Less') . '</a>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd_price right_bottom_price">';
                    $store_product_html .= '<div class="product-details">';
                    $store_product_html .= '<div class="wprw-product-price">';
                    $store_product_html .= '<span class="prd_sale_price">';
                    if ($_product->is_type('simple')) {
                        $store_product_html .= wp_kses_post($product->get_price_html());
                    } else {
                        $store_product_prices = $_product->get_variation_prices(true);
                        $store_product_min_price = current($store_product_prices['price']);
                        $store_product_max_price = end($store_product_prices['price']);
                        $store_product_min_reg_price = current($store_product_prices['regular_price']);
                        $store_product_max_reg_price = end($store_product_prices['regular_price']);

                        if ($store_product_min_price !== $store_product_max_price) {
                            $store_product_price = wc_format_price_range($store_product_min_price, $store_product_max_price);
                        } elseif ($store_product_min_reg_price === $store_product_max_reg_price) {
                            $store_product_price = wc_format_sale_price(wc_price($store_product_max_reg_price), wc_price($store_product_min_price));
                        } else {
                            $store_product_price = wc_price($store_product_min_price);
                        }
                        $store_product_html .= wp_kses_post($store_product_price);
                    }
                    $store_product_html .= '</span>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . esc_url(get_the_permalink($recently_id)) . '">';
                    $store_product_html .= '<span class="prd_detail_name">Details</span>';
                    $store_product_html .= '</a>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                }
            }
        }
        $pagination_html = $this->front_ajax_pagination($wizard_id, $question_id, $option_id, $current_selected_value, $limit, $page, $last, $total_records);

        echo json_encode(array('product_html' => $product_html, 'store_product_html' => $store_product_html, 'pagination_html' => $pagination_html));

        wp_die();
    }

    /**
     * Ajax pagination in front side
     *
     * @since    1.0.0
     * @param      int    $wizard_id                wizard id.
     * @param      int    $question_id              question id.
     * @param      int    $option_id                option id.
     * @param      int    $current_selected_value   Selected current value from attribute selection.
     * @param      int    $limit                    limit for display list (Like Display 4 products in front side).
     * @param      int    $page                     Page number (Current page number).
     * @param      int    $last                     Last Page Number.
     * @param      int    $total_records            Total Records (How many records in product).
     * @return     html Its return pagination html in front side
     */
    public function front_ajax_pagination($wizard_id, $question_id, $option_id, $current_selected_value, $limit, $page, $last, $total_records) {
        $pagination_list = '';
        if (($page) != '1' && !empty($page)) {
            $pagination_list .='<div class="top_product_btn front_pagination">';
            $pagination_list .='<a class="first-page wprw-button wprw-detail-button wprw-product-detail-link" href="javascript:void(0);" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_1">';
            $pagination_list .='<span class="prd_detail_name">' . esc_html(BACK_TO_TOP_PRODUCT_BUTTON_NAME) . '</span></a>';
            $pagination_list .='</div>';
        }
        $pagination_list .='<div class="tablenav">';
        $pagination_list .='<div class="tablenav-pages front_pagination" id="front_pagination">';
        $pagination_list .='<span class="displaying-num">' . esc_html($total_records) . ' items</span>';
        $pagination_list .='<span class="pagination-links">';
        $page_minus = $page - 1;
        $page_plus = $page + 1;
        if (($page_minus) > 0) {
            $pagination_list .='<a class="first-page" href="javascript:void(0);" class="links" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_1">';
            $pagination_list .='<span class="screen-reader-text">' . esc_html('First page') . '</span><span aria-hidden="true" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_1" class="pagination_span">' . esc_html('«') . '</span></a>';
            $pagination_list .='<a class="prev-page" href="javascript:void(0);" class="links" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . esc_attr($page_minus) . '">';
            $pagination_list .='<span class="screen-reader-text">' . esc_html('Previous page') . '</span><span aria-hidden="true" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . esc_attr($page_minus) . '"  class="pagination_span">' . esc_html('‹') . '</span></a>';
        }
        for ($i = 1; $i <= $last; $i++) {
            if ($i == $page) {
                $pagination_list .= '<a href="javascript:void(0);" class="selected" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . esc_attr($i) . '">' . esc_html($i) . '</a>';
            } else {
                $pagination_list .='<a href="javascript:void(0);" class="links"  id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . esc_attr($i) . '">' . esc_html($i) . '</a>';
            }
        }
        $pagination_list .='<span class="screen-reader-text">' . esc_html('Current Page') . '</span>';
        $pagination_list .= '<span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' . $page . ' of <span class="total-pages">' . $last . '</span></span></span>';
        if (($page_plus) <= $last) {
            $pagination_list .= '<a class="next-page" href="javascript:void(0);" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . $page_plus . '" class="links">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html('Next page') . '</span><span aria-hidden="true" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . esc_attr($page_plus) . '" class="pagination_span">' . esc_html('›') . '</span>';
            $pagination_list .='</a>';
        }
        if (($page) != $last) {
            $pagination_list .= '<a class="last-page"href="javascript:void(0);" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . $last . '" class="links">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html('Last page') . '</span><span aria-hidden="true" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '_cur_' . esc_attr($current_selected_value) . '_lmt_' . esc_attr($limit) . '_que_' . esc_attr($last) . '" class="pagination_span">' . esc_html('»') . '</span>';
            $pagination_list .='</a>';
        }
        $pagination_list .='</span>';
        $pagination_list .='</div>';
        $pagination_list .='</div>';
        return $pagination_list;
    }

    /**
     * Get Option value based on option id
     *
     * @since    1.0.0
     * @param      int    $option_id  option id.
     * @param      int    $wizard_id  wizard id.
     * @return array
     */
    public function get_option_value_based_on_option_id($option_id, $wizard_id) {
        global $wpdb;
        $option_attribute_value = array();
        $options_table_name = OPTIONS_TABLE;
        if (!empty($wizard_id) && isset($wizard_id)) {
            $and = " AND wizard_id=%d";
        }
        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $options_table_name . ' WHERE id IN (' . stripslashes($option_id) . ') ' . $and . '', $wizard_id);
        $sel_rows = $wpdb->get_results($sel_qry);
        if (!empty($sel_rows) && $sel_rows != '0' && isset($sel_rows)) {
            foreach ($sel_rows as $sel_data) {
                $options_id = $sel_data->id;
                if (strpos($sel_data->option_attribute_value, ',') !== false) {
                    $option_attribute_value_ex = explode(',', trim($sel_data->option_attribute_value));
                } else {
                    $option_attribute_value_ex = array($sel_data->option_attribute_value);
                }
                foreach ($option_attribute_value_ex as $key => $value) {
                    $option_attribute_value[] = $value;
                }
            }
        }
        return $option_attribute_value;
    }

    /**
     * Get Option name based on option id
     *
     * @since    1.0.0
     * @param      int    $option_id  option id.
     * @param      int    $wizard_id  wizard id.
     * @return array
     */
    public function get_option_name_based_on_option_id($option_id, $wizard_id) {
        global $wpdb;
        $option_attribute = array();
        $options_table_name = OPTIONS_TABLE;
        if (!empty($wizard_id) && isset($wizard_id)) {
            $and = " AND wizard_id=%d";
        }
        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $options_table_name . ' WHERE id IN (' . stripslashes($option_id) . ') ' . $and . '', $wizard_id);
        $sel_rows = $wpdb->get_results($sel_qry);
        if (!empty($sel_rows) && $sel_rows != '0' && isset($sel_rows)) {
            foreach ($sel_rows as $sel_data) {
                $options_id = $sel_data->id;
                $option_attribute[$options_id] = $sel_data->option_attribute;
            }
        }
        return $option_attribute;
    }

    /**
     * Get all questions list
     *
     * @since    1.0.0
     * @param      int    $wizard_id  wizard id.
     * @return array Its return whole results set
     */
    public function get_all_question_list($wizard_id) {
        global $wpdb;
        $questions_table_name = QUESTIONS_TABLE;
        $sel_qry = $wpdb->prepare('SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id=%d ORDER BY id ASC', $wizard_id);
        $sel_rows = $wpdb->get_results($sel_qry);
        if (!empty($sel_rows) && $sel_rows != '0' && isset($sel_rows)) {
            return $sel_rows;
        }
    }

    /**
     * Get Option id based on option value
     *
     * @since    1.0.0
     * @param      string    $option_name       Option Name.
     * @param      string    $option_attribute  Option Attribute.
     * @param      int    $wizard_id         Wizard Id.
     * @return int
     */
    public function get_option_id_based_on_option_value($option_name, $option_attribute, $wizard_id) {
        global $wpdb;
        $options_table_name = OPTIONS_TABLE;
        if (!empty($option_name) && $option_name != '' && isset($option_name)) {
            $where = " WHERE FIND_IN_SET('" . trim($option_name) . "', option_attribute_value) <> 0";
        }
        if (!empty($option_attribute) && $option_attribute != '' && isset($option_attribute)) {
            $and = " AND option_attribute=%d";
        }
        if (!empty($wizard_id) && $wizard_id != '' && isset($wizard_id)) {
            $and2 = " AND wizard_id=%d";
        }
        $sel_qry = $wpdb->prepare('SELECT GROUP_CONCAT(id) as all_id FROM ' . $options_table_name . ' ' . $where . ' ' . $and . ' ' . $and2 . '', array($option_attribute, $wizard_id));
        $get_option_result = $wpdb->get_row($sel_qry);
        if (!empty($get_option_result) && $get_option_result != '' && isset($get_option_result)) {
            $get_option_id = $get_option_result->all_id;
            return $get_option_id;
        }
    }

    /**
     * Get all attribute value
     *
     * @since    1.0.0
     * @param      array    $category_wise_product       Category ID.
     * @return array
     */
    public function get_all_attribute_value() {
        global $wpdb;
        $sel_qry = "";
        $sel_qry .= "SELECT {$wpdb->prefix}posts.ID";
        $sel_qry .= " FROM {$wpdb->prefix}posts";
        $sel_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $sel_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $sel_qry .= " WHERE";
        $sel_qry .= " {$wpdb->prefix}posts.post_type =%s";
        $sel_qry .= " AND {$wpdb->prefix}posts.post_status =%s";
        $sel_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $sel_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $sel_qry .= " ASC";
        $sel_qry_prepare = $wpdb->prepare($sel_qry, array('product', 'publish'));
        $sel_result = $wpdb->get_results($sel_qry_prepare);
        $sel_result_count = count($sel_result);

        $custom_product_attributes_arr_arr = array();
        if (!empty($sel_result) && isset($sel_result)) {
            foreach ($sel_result as $prd_data) {
                $theid = $prd_data->ID;
                $product = new WC_Product($theid);
                $variation_data = $product->get_attributes();

                if (!empty($variation_data) && isset($variation_data)) {
                    foreach ($variation_data as $attribute) {
                        if (($attribute['is_taxonomy'])) {
                            $values = wc_get_product_terms($theid, $attribute['name'], array('fields' => 'names'));
                            $att_val = apply_filters('woocommerce_attribute', wptexturize(implode(' | ', $values)), $attribute, $values);
                            $att_val_ex = trim($att_val);
                        } else {
                            $att_val_ex = trim($attribute['value']);
                        }
                        $custom_product_attributes[] = explode('|', $att_val_ex);
                        $custom_product_attributes_arr_arr[$theid][wc_attribute_label($attribute['name'])] = $att_val_ex;
                    }
                }
            }
        }
        return $custom_product_attributes_arr_arr;
    }

    /**
     * Get all product id
     *
     * @since    1.0.0
     * @param      array    $category_wise_product     Category ID.
     * @return int Its return custom product id
     */
    public function get_all_product_id() {
        global $wpdb;
        $sel_qry = "";
        $sel_qry .= "SELECT {$wpdb->prefix}posts.ID";
        $sel_qry .= " FROM {$wpdb->prefix}posts";
        $sel_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $sel_qry .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        $sel_qry .= " WHERE";
        $sel_qry .= " {$wpdb->prefix}posts.post_type =%s";
        $sel_qry .= " AND {$wpdb->prefix}posts.post_status =%s";
        $sel_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $sel_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $sel_qry .= " ASC";
        $sel_qry_prepare = $wpdb->prepare($sel_qry, array('product', 'publish'));
        $sel_result = $wpdb->get_results($sel_qry_prepare);
        $sel_result_count = count($sel_result);

        $custom_product_id = array();
        if (!empty($sel_result) && isset($sel_result)) {
            foreach ($sel_result as $prd_data) {
                $theid = $prd_data->ID;
                $custom_product_id[$theid] = $theid;
            }
        }
        return $custom_product_id;
    }

    /**
     * Check attribute is custom attribute or attribute term
     *
     * @since    1.0.0
     * @param      int    $wizard_id                Wizard ID.
     * @param      string    $attribute_value       Attribute Value.
     * @param      array    $category_wise_product  Category ID.
     * @param      array    $wizard_attribute_id    Attribute ID.
     * @return array Its return unique product id which is match multiple attribute value
     */
    public function checkMetaAttributeOrNot($wizard_id, $attribute_value, $wizard_attribute_id) {
        global $wpdb;
        $options_table_name = OPTIONS_TABLE;
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE wizard_id=%d";
        $sel_qry .= " AND id IN (" . stripslashes($attribute_value) . ")";
        $sel_qry .= " ORDER BY id DESC";
        $sel_qry_prepare = $wpdb->prepare($sel_qry, $wizard_id);
        $sel_rows = $wpdb->get_results($sel_qry_prepare);
        $fetch_attribute_value_array = array();
        $fetch_attribute_value_pass_jquery = array();
        $option_attribute_arr = array();
        $fetch_option_attribute_value_arr = array();
        $fetch_attribute_value_pass_jquery_merge = array();

        /* Fetch option attribute name and value in array */
        foreach ($sel_rows as $sel_data) {
            $option_attribute = trim($sel_data->option_attribute);
            $fetch_option_attribute_value = trim(str_replace(", ", ",", $sel_data->option_attribute_value));
            $option_attribute_arr[] = trim($sel_data->option_attribute);
            $fetch_option_attribute_value_arr[] = trim(str_replace(", ", ",", $sel_data->option_attribute_value));
            $fetch_option_attribute_value = str_replace(', ', ",", $fetch_option_attribute_value);
            $fetch_attribute_value_array[][trim($option_attribute)] = trim($fetch_option_attribute_value); //for function
            if (!empty($fetch_attribute_value_pass_jquery)) {
                $fetch_attribute_value_pass_jquery_merge[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
                if (array_key_exists(trim(strtolower($option_attribute)), $fetch_attribute_value_pass_jquery)) {
                    foreach ($fetch_attribute_value_pass_jquery as $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value) {
                        $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value . "," . trim(strtolower(str_replace(", ", ",", $sel_data->option_attribute_value)));
                    }
                } else {
                    $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
                }
            } else {
                $fetch_attribute_value_pass_jquery[trim(strtolower($option_attribute))] = trim(strtolower($fetch_option_attribute_value));
            }
        }

        /* Check attribute is custom add or not and get custom meta attribute */
        $and = '';
        foreach ($fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value) {
            $serialized_attribute_name = serialize('name') . serialize($all_fetch_key);
            $and .= " AND m1.meta_value REGEXP '[[:<:]]" . $serialized_attribute_name . "[[:>:]]'";
            if (strpos($all_fetch_value, ',') !== false) {
                $attribute_name_key = explode(',', trim($all_fetch_value));
                $i = 0;
                foreach ($attribute_name_key as $opt_ex_key => $opt_ex_value) {
                    if ($i == 0) {
                        $and .= " AND (m1.meta_value REGEXP '[[:<:]]" . trim($opt_ex_value) . "[[:>:]]'";
                    } else if ($i > 0) {
                        $and .= " OR m1.meta_value REGEXP '[[:<:]]" . trim($opt_ex_value) . "[[:>:]]')";
                    }
                    $i++;
                }
            } else {
                $and .= " AND m1.meta_value REGEXP '[[:<:]]" . trim($all_fetch_value) . "[[:>:]]'";
            }
        }
        $prd_chk_meta_qry = $wpdb->prepare(
                "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}posts.ID FROM {$wpdb->prefix}posts 
                INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)
                WHERE {$wpdb->prefix}posts.post_type =%s
                AND {$wpdb->prefix}posts.post_status =%s
                AND (m1.meta_key = '_product_attributes')
                " . $and . " GROUP BY {$wpdb->prefix}posts.ID ORDER BY {$wpdb->prefix}posts.post_date ASC", array('product', 'publish')
        );

        $prd_meta_result = $wpdb->get_results($prd_chk_meta_qry);
        foreach ($prd_meta_result as $key => $value) {
            $prd_meta_id[$value->ID] = $value->ID;
        }

        $term_meta_id = array();
        $tax_meta_query = array('relation' => 'AND');

        /* Fetch both custom add attribute and taxonomy attribute */
        foreach ($fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value) {
            $taxonomy = strtolower(str_replace(' ', '-', $all_fetch_key));
            if (strpos($all_fetch_value, ',') !== false) {
                $attribute_value_exp = explode(',', trim($all_fetch_value));
                foreach ($attribute_value_exp as $opt_ex_key => $opt_ex_value) {
                    $tax_meta_query[] = array(
                        'taxonomy' => 'pa_' . $taxonomy,
                        'field' => 'name',
                        'terms' => trim($opt_ex_value), //the taxonomy terms I'd like to dynamically query
                    );
                }
            } else {
                $tax_meta_query[] = array(
                    'taxonomy' => 'pa_' . $taxonomy,
                    'field' => 'name',
                    'terms' => trim($all_fetch_value), //the taxonomy terms I'd like to dynamically query
                );
            }
        }

        $taxonomy_query = new WP_Query(
                array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'tax_query' => $tax_meta_query,
            'orderby' => 'title',
            'order' => 'ASC',
                )
        );

        $term_meta_result = $taxonomy_query->posts;
        foreach ($term_meta_result as $key => $value) {
            $term_meta_id[$value->ID] = $value->ID;
        }

        $term_unique_id = array();
        $tax_unique_query = array('relation' => 'OR');
        foreach ($fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value) {
            $taxonomy = strtolower(str_replace(' ', '-', $all_fetch_key));
            $tax_unique_query[] = array(
                'taxonomy' => 'pa_' . $taxonomy,
                'field' => 'name',
                'terms' => $all_fetch_value, //the taxonomy terms I'd like to dynamically query
            );
        }

        $taxonomy_unique_query = new WP_Query(
                array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'tax_query' => $tax_unique_query,
            'orderby' => 'title',
            'order' => 'ASC',
                )
        );

        $term_meta_result = $taxonomy_unique_query->posts;
        foreach ($term_meta_result as $key => $value) {
            $term_unique_id[$value->ID] = $value->ID;
        }

        /* Fetch common product id (If product attribute is in custom add and taxonomy add) */
        $prd_unique_id = array();

        $unique_and = '';
        foreach ($fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value) {
            $serialized_attribute_name = serialize('name') . serialize($all_fetch_key);
            $unique_and .= " AND m1.meta_value REGEXP '[[:<:]]" . $serialized_attribute_name . "[[:>:]]'";
            if (strpos($all_fetch_value, ',') !== false) {
                $attribute_name_key = explode(',', trim($all_fetch_value));
                $i = 0;
                foreach ($attribute_name_key as $opt_ex_key => $opt_ex_value) {
                    if ($i == 0) {
                        $unique_and .= " AND (m1.meta_value REGEXP '[[:<:]]" . trim($opt_ex_value) . "[[:>:]]'";
                    } else if ($i > 0) {
                        $unique_and .= " OR m1.meta_value REGEXP '[[:<:]]" . trim($opt_ex_value) . "[[:>:]]')";
                    }
                    $i++;
                }
            } else {
                $unique_and .= " AND m1.meta_value REGEXP '[[:<:]]" . trim($all_fetch_value) . "[[:>:]]'";
            }
        }
        $prd_unique_meta_qry = $wpdb->prepare(
                "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}posts.ID FROM {$wpdb->prefix}posts 
                INNER JOIN {$wpdb->prefix}postmeta m1 ON ({$wpdb->prefix}posts.ID = m1.post_id)
                WHERE {$wpdb->prefix}posts.post_type =%s
                AND {$wpdb->prefix}posts.post_status =%s
                AND (m1.meta_key = '_product_attributes')
                " . $unique_and . " GROUP BY {$wpdb->prefix}posts.ID ORDER BY {$wpdb->prefix}posts.post_date ASC", array('product', 'publish')
        );
        $prd_unique_meta_result = $wpdb->get_results($prd_unique_meta_qry);
        foreach ($prd_unique_meta_result as $key => $value) {
            $prd_unique_id[$value->ID] = $value->ID;
        }


        if (!empty($prd_unique_id) && !empty($term_unique_id)) {
            $prd_term_common_id = array_intersect_key($term_unique_id, $prd_unique_id);
        }
        if (!empty($prd_unique_id) && !empty($prd_meta_id)) {
            $prd_meta_common_id = array_intersect_key($prd_meta_id, $prd_unique_id);
        }
        if (!empty($term_unique_id) && !empty($term_meta_id)) {
            $term_meta_common_id = array_intersect_key($term_meta_id, $term_unique_id);
        }

        $final_match_product_id = '';

        if (!empty($prd_meta_common_id) && !empty($term_meta_common_id) && !empty($prd_term_common_id)) {
            $final_match_product_id = array_merge($prd_meta_common_id, $term_meta_common_id, $prd_term_common_id);
        }
        if (!empty($prd_meta_common_id) && !empty($term_meta_common_id) && empty($prd_term_common_id)) {
            $final_match_product_id = array_merge($prd_meta_common_id, $term_meta_common_id);
        }
        if (!empty($prd_meta_common_id) && empty($term_meta_common_id) && empty($prd_term_common_id)) {
            $final_match_product_id = $prd_meta_common_id;
        }
        if (empty($prd_meta_common_id) && !empty($term_meta_common_id) && !empty($prd_term_common_id)) {
            $final_match_product_id = array_merge($prd_term_common_id, $term_meta_common_id);
        }
        if (empty($prd_meta_common_id) && empty($term_meta_common_id) && !empty($prd_term_common_id)) {
            $final_match_product_id = $prd_term_common_id;
        }
        if (empty($prd_meta_common_id) && !empty($term_meta_common_id) && empty($prd_term_common_id)) {
            $final_match_product_id = $term_meta_common_id;
        }

        if (!empty($final_match_product_id)) {
            return array_unique(array_filter($final_match_product_id));
        }
    }

    /**
     * Get wizard title based on id.
     *
     * @since    1.0.0
     * @param int $wizard_id wizard id
     * @return string
     */
    public function get_wizard_id_based_on_id($wizard_id) {
        global $wpdb;

        $wizard_table_name = WIZARDS_TABLE;
        $sel_wizard_qry = $wpdb->prepare('SELECT * FROM ' . $wizard_table_name . ' WHERE id=%d', $wizard_id);
        $sel_wizard_rows = $wpdb->get_row($sel_wizard_qry);
        if (!empty($sel_wizard_rows) && $sel_wizard_rows != '') {
            $wizard_name = $sel_wizard_rows->name;
        }
        return $wizard_name;
    }

}

?>
