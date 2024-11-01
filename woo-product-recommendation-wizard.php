<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.multidots.com
 * @since             1.0.0
 * @package           Woo_Product_Recommendation_Wizard
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Product Recommendation Wizard
 * Plugin URI:        http://www.multidots.com
 * Description:       Woo Product Recommendation Wizard let customers narrow down the product list on the basis of their choices. It enables the store owners to add a questionnaire to the product page. The product recommendations are then rendered according to the answers, given by the users. You can showcase ‘n’ number of products, matching the answers and query. 
 * Version:           1.0.0
 * Author:            Multidots
 * Author URI:        https://profiles.wordpress.org/dots
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-product-recommendation-wizard
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

if (!defined('WPRW_PLUGIN_URL')) {
    define('WPRW_PLUGIN_URL', plugin_dir_url(__FILE__));
}
if (!defined('WPRW_PLUGIN_DIR')) {
    define('WPRW_PLUGIN_DIR', dirname(__FILE__));
}
if (!defined('WPRW_PLUGIN_DIR_PATH')) {
    define('WPRW_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('WPRW_PLUGIN_BASENAME')) {
    define('WPRW_PLUGIN_BASENAME', plugin_basename(__FILE__));
}

/**
 * The core plugin include constant file for set constant.
 */
require plugin_dir_path(__FILE__) . 'includes/constant.php';
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-product-recommendation-wizard-activator.php
 */
function activate_woo_product_recommendation_wizard() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-product-recommendation-wizard-activator.php';
    Woo_Product_Recommendation_Wizard_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-product-recommendation-wizard-deactivator.php
 */
function deactivate_woo_product_recommendation_wizard() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-product-recommendation-wizard-deactivator.php';
    Woo_Product_Recommendation_Wizard_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_product_recommendation_wizard');
register_deactivation_hook(__FILE__, 'deactivate_woo_product_recommendation_wizard');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woo-product-recommendation-wizard.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_product_recommendation_wizard() {

    $plugin = new Woo_Product_Recommendation_Wizard();
    $plugin->run();
}

run_woo_product_recommendation_wizard();
