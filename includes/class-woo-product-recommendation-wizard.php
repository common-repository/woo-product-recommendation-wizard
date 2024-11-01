<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/includes
 * @author     Multidots <inquiry@multidots.in>
 */
if (!defined('ABSPATH')) {
    exit;
}
class Woo_Product_Recommendation_Wizard {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Woo_Product_Recommendation_Wizard_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    const WPRW_VERSION = '1.0.0';

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {

        $this->plugin_name = 'woo-product-recommendation-wizard';
        $this->version = WPRW_PLUGIN_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Woo_Product_Recommendation_Wizard_Loader. Orchestrates the hooks of the plugin.
     * - Woo_Product_Recommendation_Wizard_i18n. Defines internationalization functionality.
     * - Woo_Product_Recommendation_Wizard_Admin. Defines all hooks for the admin area.
     * - Woo_Product_Recommendation_Wizard_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-product-recommendation-wizard-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-product-recommendation-wizard-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woo-product-recommendation-wizard-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woo-product-recommendation-wizard-public.php';

        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woo-wizard-public-shortcode-creator.php';

        $this->loader = new Woo_Product_Recommendation_Wizard_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Woo_Product_Recommendation_Wizard_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Woo_Product_Recommendation_Wizard_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Woo_Product_Recommendation_Wizard_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

        $this->loader->add_action('admin_menu', $plugin_admin, 'dot_store_menu_wprw');
        $this->loader->add_action('admin_init', $plugin_admin, 'welcome_wprw_screen_do_activation_redirect');
        $this->loader->add_action('admin_head', $plugin_admin, 'wprw_remove_admin_submenus');

        $this->loader->add_action('wp_ajax_get_attributes_value_based_on_attribute_name', $plugin_admin, 'get_attributes_value_based_on_attribute_name');
        $this->loader->add_action('wp_ajax_nopriv_get_attributes_value_based_on_attribute_name', $plugin_admin, 'get_attributes_value_based_on_attribute_name');

        $this->loader->add_action('wp_ajax_remove_option_data_from_option_page', $plugin_admin, 'remove_option_data_from_option_page');
        $this->loader->add_action('wp_ajax_nopriv_remove_option_data_from_option_page', $plugin_admin, 'remove_option_data_from_option_page');

        $this->loader->add_action('wp_ajax_delete_selected_wizard_using_checkbox', $plugin_admin, 'delete_selected_wizard_using_checkbox');
        $this->loader->add_action('wp_ajax_nopriv_delete_selected_wizard_using_checkbox', $plugin_admin, 'delete_selected_wizard_using_checkbox');

        $this->loader->add_action('wp_ajax_delete_single_wizard_using_button', $plugin_admin, 'delete_single_wizard_using_button');
        $this->loader->add_action('wp_ajax_nopriv_delete_single_wizard_using_button', $plugin_admin, 'delete_single_wizard_using_button');

        $this->loader->add_action('wp_ajax_delete_selected_question_using_checkbox', $plugin_admin, 'delete_selected_question_using_checkbox');
        $this->loader->add_action('wp_ajax_nopriv_delete_selected_question_using_checkbox', $plugin_admin, 'delete_selected_question_using_checkbox');

        $this->loader->add_action('wp_ajax_delete_single_question_using_button', $plugin_admin, 'delete_single_question_using_button');
        $this->loader->add_action('wp_ajax_nopriv_delete_single_question_using_button', $plugin_admin, 'delete_single_question_using_button');

        $this->loader->add_action('wp_ajax_get_admin_question_list_with_pagination', $plugin_admin, 'get_admin_question_list_with_pagination');
        $this->loader->add_action('wp_ajax_nopriv_get_admin_question_list_with_pagination', $plugin_admin, 'get_admin_question_list_with_pagination');

        $this->loader->add_action('wp_ajax_sortable_question_list_based_on_id', $plugin_admin, 'sortable_question_list_based_on_id');
        $this->loader->add_action('wp_ajax_nopriv_sortable_question_list_based_on_id', $plugin_admin, 'sortable_question_list_based_on_id');

        $this->loader->add_action('wp_ajax_sortable_option_list_based_on_id', $plugin_admin, 'sortable_option_list_based_on_id');
        $this->loader->add_action('wp_ajax_nopriv_sortable_option_list_based_on_id', $plugin_admin, 'sortable_option_list_based_on_id');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Woo_Product_Recommendation_Wizard_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

        $this->loader->add_action('wp_ajax_get_next_questions_front_side', $plugin_public, 'get_next_questions_front_side');
        $this->loader->add_action('wp_ajax_nopriv_get_next_questions_front_side', $plugin_public, 'get_next_questions_front_side');

        $this->loader->add_action('wp_ajax_get_previous_questions_front_side', $plugin_public, 'get_previous_questions_front_side');
        $this->loader->add_action('wp_ajax_nopriv_get_previous_questions_front_side', $plugin_public, 'get_previous_questions_front_side');

        $this->loader->add_action('wp_ajax_get_ajax_woocommerce_product_list', $plugin_public, 'get_ajax_woocommerce_product_list');
        $this->loader->add_action('wp_ajax_nopriv_get_ajax_woocommerce_product_list', $plugin_public, 'get_ajax_woocommerce_product_list');

        $this->loader->add_action('wp_ajax_get_final_woocommerce_product_list', $plugin_public, 'get_final_woocommerce_product_list');
        $this->loader->add_action('wp_ajax_nopriv_get_final_woocommerce_product_list', $plugin_public, 'get_final_woocommerce_product_list');

        $this->loader->add_action('wp_ajax_get_front_html_list_with_pagination', $plugin_public, 'get_front_html_list_with_pagination');
        $this->loader->add_action('wp_ajax_nopriv_get_front_html_list_with_pagination', $plugin_public, 'get_front_html_list_with_pagination');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Woo_Product_Recommendation_Wizard_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
