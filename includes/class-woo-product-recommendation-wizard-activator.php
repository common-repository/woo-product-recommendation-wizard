<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Product_Recommendation_Wizard
 * @subpackage Woo_Product_Recommendation_Wizard/includes
 * @author     Multidots <inquiry@multidots.in>
 */
class Woo_Product_Recommendation_Wizard_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {
        global $wpdb, $woocommerce;

        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && !is_plugin_active_for_network('woocommerce/woocommerce.php')) {
            wp_die("<strong> " . WOO_PRODUCT_RECOMMENDATION_WIZARD_PLUGIN_NAME . "</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . get_admin_url(null, 'plugins.php') . "'>Plugins page</a>.");
        } else {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            $charset_collate = $wpdb->get_charset_collate();
            
            /*Plugin's table prefix*/
            $wprw_prefix = WIZARDS_TABLE_PREFIX;
            
            /*Table name*/
            $wp_wizard_table = $wprw_prefix . "wizard";
            $wp_questions_table = $wprw_prefix . "questions";
            $wp_questions_options_table = $wprw_prefix . "questions_options";
            
            /*Setup table*/
            if ($wpdb->get_var("show tables like '" . $wp_wizard_table . "'") != $wp_wizard_table) {
                $sql = "CREATE TABLE " . $wp_wizard_table . " (
              id int(11) NOT NULL AUTO_INCREMENT,
              name text NOT NULL,
              wizard_category varchar(255) NOT NULL,
              shortcode text NOT NULL,
              status varchar(255) NOT NULL,
              created_date varchar(255) NOT NULL,
              updated_date varchar(255) NOT NULL,
              PRIMARY KEY  (id)
              );";
            }
            dbDelta($sql);

            if ($wpdb->get_var("show tables like '" . $wp_questions_table . "'") != $wp_questions_table) {
                $sql = "CREATE TABLE " . $wp_questions_table . " (
            id int(11) NOT NULL AUTO_INCREMENT,
            wizard_id int(11) NOT NULL,
            name text NOT NULL,
            option_type varchar(255) NOT NULL,
            sortable_id int(11) NOT NULL,
            created_date varchar(255) NOT NULL,
            updated_date varchar(255) NOT NULL,
            PRIMARY KEY  (id)
            );";
            }
            dbDelta($sql);

            if ($wpdb->get_var("show tables like '" . $wp_questions_options_table . "'") != $wp_questions_options_table) {
                $sql = "CREATE TABLE " . $wp_questions_options_table . " (
            id int(11) NOT NULL AUTO_INCREMENT,
            wizard_id int(11) NOT NULL,
            question_id int(11) NOT NULL,
            option_name text NOT NULL,
            option_image varchar(255) NOT NULL,
            option_attribute varchar(255) NOT NULL,
            option_attribute_value text NOT NULL,
            sortable_id int(11) NOT NULL,
            created_date varchar(255) NOT NULL,
            updated_date varchar(255) NOT NULL,
            PRIMARY KEY  (id)
            );";
            }
            dbDelta($sql);

            set_transient('_welcome_screen_activation_redirect_wprw', true, 30);
            add_option('wprw_version', Woo_Product_Recommendation_Wizard::WPRW_VERSION);
        }
    }

}
