<?php

/**
 * Create shortcode for particular wizard
 *
 * @since    1.0.0
 */
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
global $wpdb;
$wizard_table_name = WIZARDS_TABLE;
$sel_qry = $wpdb->prepare('SELECT * FROM ' . $wizard_table_name, '');
$wizard_rows = $wpdb->get_results($sel_qry);

if (!empty($wizard_rows)) {
    foreach ($wizard_rows as $wizard_data) {
        $wizard_id = $wizard_data->id;
        $wizard_title = $wizard_data->name;
        $wizard_shortcode = $wizard_data->shortcode;
        $wizard_status = $wizard_data->status;

        $cb = function() use ($wizard_id) {
            global $wpdb;
            $wizard_table_name = WIZARDS_TABLE;
            $questions_table_name = QUESTIONS_TABLE;
            $options_table_name = OPTIONS_TABLE;

            $sel_qry = "";
            $sel_qry .= "SELECT ";
            $sel_qry .= " wizard.*,";
            $sel_qry .= " qustions.id AS question_id,qustions.name,qustions.option_type,qustions.sortable_id";
            $sel_qry .= " FROM " . $wizard_table_name . " wizard";
            $sel_qry .= " LEFT JOIN " . $questions_table_name . " AS qustions";
            $sel_qry .= " ON qustions.wizard_id=wizard.id";
            $sel_qry .= " WHERE wizard.id=%d";
            $sel_qry .= " AND wizard.status=%s";
            $sel_qry .= " ORDER BY qustions.sortable_id ASC";
            $sel_qry .= " LIMIT %d,%d";
            $sel_qry_prepare = $wpdb->prepare($sel_qry, array($wizard_id, 'on', '0', '1'));
            $sel_rows = $wpdb->get_results($sel_qry_prepare);
            if (!empty($sel_rows)) {
                $publicObj = new Woo_Product_Recommendation_Wizard_Public($this->plugin_name, $this->version);

                $wizard_title = $publicObj->get_wizard_id_based_on_id($wizard_id);
                $front_html = '';
                $i = 0;
                $front_html .= '<div class="wprw_list" id="wprw_list_new_' . esc_attr($wizard_id) . '">';
                $front_html .= '<div class="wprw-question-text-panel wizard_title_class">';
                $front_html .= '<div class="wprw-question-text">';
                $front_html .= wp_kses_post($wizard_title);
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '<div class="wprv-list-restart">';
                $front_html .= '<a class="wprv-list-hover-button wprv-list-restart-button" href="javascript:void(0);">';
                $front_html .= '<i class="fa fa-refresh" aria-hidden="true"></i><span class="wprv-list-hover-label wprv-list-round wprv-list-hover-left wprv-list-icon">' . esc_html('Restart') . '</span>';
                $front_html .= '</a>';
                $front_html .= '</div>';
                $front_html .= '<ol class="wprw-questions" id="wprw_question_list_new_' . esc_attr($wizard_id) . '">';
                foreach ($sel_rows as $sel_data) {
                    $i++;
                    $question_id = $sel_data->question_id;
                    $question_name = $sel_data->name;
                    $option_type = trim($sel_data->option_type);
                    $sortable_id = $sel_data->sortable_id;

                    ############ Get Next Questions ID ############
                    $get_next_id_qry = "";
                    $get_next_id_qry .= "SELECT *";
                    $get_next_id_qry .= " FROM " . $questions_table_name;
                    $get_next_id_qry .= " WHERE sortable_id=" . "(select min(sortable_id) from " . $questions_table_name . " where sortable_id >%d)";
                    $get_next_id_qry .= " AND wizard_id =%d";
                    $get_next_id_qry_prepare = $wpdb->prepare($get_next_id_qry, array($sortable_id, $wizard_id));
                    $get_next_id_rows = $wpdb->get_row($get_next_id_qry_prepare);
                    $next_question_html = '';
                    if (!empty($get_next_id_rows) && $get_next_id_rows != '0') {
                        $get_next_question_id = $get_next_id_rows->id;
                        $next_sortable_id = $get_next_id_rows->sortable_id;
                        $next_question_html .= '<a class="wprw-button wprw-button-next wprw-button-inactive" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($get_next_question_id) . '_cur_' . esc_attr($get_next_question_id) . '_sortable_' . esc_attr($next_sortable_id) . '" href="javascript:void(0);">';
                        $next_question_html .= '<span class="">' . esc_html('Next') . '</span>';
                        $next_question_html .= '</a>';
                    } else {
                        $next_sortable_id = '';
                    }

                    $front_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . esc_attr($question_id) . '">';
                    $front_html .= '<div class="wprw-mandatory-message" style="display: none;">Please answer the question.</div>';
                    $front_html .= '<div class="wprw-question-text-panel">';
                    $front_html .= '<div class="wprw-question-text">' . esc_html($question_name) . '</div>';
                    $front_html .= '</div>';
                    $front_html .= '<ol wprw-radiobutton="" class="wprw-answers">';
                    $sel_qry = $wpdb->prepare('SELECT * FROM ' . $options_table_name . ' WHERE wizard_id=%d AND question_id=%d ORDER BY id ASC', array($wizard_id, $question_id));
                    $sel_rows = $wpdb->get_results($sel_qry);
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
                            $front_html .= '<li class="wprw-answer wprw-selected-answer" id="opt_attr_' . esc_attr($option_id) . '">';
                            $front_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                            $front_html .= '<div class="wprw-answer-action wprw-action-element wprw-' . esc_attr($div_answer_action_class) . '">';
                            $front_html .= '<span class="wprw-answer-selector">';
                            if ($option_type == 'radio') {
                                $front_html .= '<div class="roundedTwo"> <input class="wprw-input" type="radio" value="' . esc_attr($option_id) . '" name="option_name" id="wd_' . esc_attr($wizard_id) . '_que_' . esc_attr($question_id) . '_opt_' . esc_attr($option_id) . '"><label class="label_input"></label></div>';
                            }
                            $front_html .= '<span class="wprw-label-element wprw-answer-label">';
                            $front_html .= '<span class="wprw-answer-label wprw-label-element">' . esc_html($option_name) . '</span>';
                            $front_html .= '</span>';
                            $front_html .= '</span>';
                            $front_html .= '</div>';
                            $front_html .= '</div>';
                            $front_html .= '</li>';
                        }
                    }
                    $front_html .= '</ol>';
                    $front_html .= '</li>';
                    $front_html .= '<div class="wprw-page-nav-buttons">';
                    $front_html .= $next_question_html;
                    $front_html .= '</div>';
                }
                $front_html .= '</ol>';
                $test_obj = new Woo_Product_Recommendation_Wizard_Public($this->plugin_name, $this->version);
                $question_result = $test_obj->get_all_question_list($wizard_id);
                if (!empty($question_result)) {
                    foreach ($question_result as $question_result_data) {
                        $all_question_id = $question_result_data->id;
                        $front_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . esc_attr($all_question_id) . '" value=""/>';
                    }
                }
                $front_html .= '<input type="hidden" name="all_selected_value" id="all_selected_value" value=""/>';
                $front_html .= '<div class="product_list" id="product_list_id_' . esc_attr($wizard_id) . '">';
                $front_html .= '<div class="main_all_prd_section">';
                $front_html .= '<div class="sub_prd_section" id="sub_prd_section_id_' . esc_attr($wizard_id) . '">';
                $front_html .= '<img src="' . esc_url(WPRW_PLUGIN_URL) . '/images/ajax-loader.gif" id="ajax_loader_wizard">';
                $front_html .= '<div id="perfect_product_div_' . esc_attr($wizard_id) . '">';
                $front_html .= '</div>';
                $front_html .= '<div id="recently_product_div_' . esc_attr($wizard_id) . '">';
                $front_html .= '</div>';
                $front_html .= '<div id="front_pagination_div_' . esc_attr($wizard_id) . '">';
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '</div>';
                return $front_html;
            }
        };

        add_shortcode("wprw_" . $wizard_id, $cb);
    }
}

