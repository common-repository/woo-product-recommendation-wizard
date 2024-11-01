<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
require_once('header/plugin-header.php');
?>
<div id="main-tab">
    <div class="wrapper">
        <div class="tab-dot">
            <div class="wprw-main-table res-cl key-featured">
                <h2><?php esc_html_e('Free vs Pro'); ?> </h2>
                <table class="table-outer premium-free-table" align="center">
                    <thead>
                        <tr class="blue">
                            <th><?php esc_html_e('KEY FEATURES LIST'); ?></th>
                            <th><?php esc_html_e('FREE'); ?></th>
                            <th><?php esc_html_e('PRO'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Create a questionnaire and show recommendations according to user answers'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Enable Wizards'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Add any number of Questions and related options to Created Wizard'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/trash.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Create Unlimited Question'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/trash.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Create category based wizards'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/trash.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Set how many Products you want to show Per Page (General Setting)'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/trash.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>

                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Display Attribute Per Product (General Setting)'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/trash.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Manage Multiple Wizards'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Create New Wizards'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Auto create Wizard shortcode'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Create Question'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Add Multiple options with image'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Create question option like radio button or Multi-select check box'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Manage Option: Add Title, Image, Select Attribute Name and select Attribute value'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Easy to Customize'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Quick setup'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="dark">
                            <td class="pad"><?php esc_html_e('Questionnaire Based Searches'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr>
                            <td class="pad"><?php esc_html_e('Add Multiple options with image'); ?></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                            <td><img src="<?php echo esc_url(WPRW_PLUGIN_URL) . 'admin/images/check-mark.png'; ?>"></td>
                        </tr>
                        <tr class="pad radius-s">
                            <td class="pad"></td>
                            <td></td>
                            <td class="green red"><a href="<?php echo esc_url(WPRW_EXPETRANL_URL); ?>" target="_blank"><?php esc_html_e('UPGRADE TO'); ?> <br> <?php esc_html_e('PREMIUM VERSION'); ?> </a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require_once('header/plugin-sidebar.php'); ?>
    </div>
</div>


