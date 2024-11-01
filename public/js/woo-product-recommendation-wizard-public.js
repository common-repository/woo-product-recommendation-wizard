(function($) {
    'use strict';
    $(window).load(function() {
        jQuery('#ajax_loader_wizard').hide();
        jQuery(".wprw-button-previous").hide();
        jQuery(".wprw-button-previous").hide();
        jQuery(".wprw-display-results-button").hide();
        jQuery(".wprw-start-advisor-button").hide();
        jQuery(".wprw-scroll-to-results-button").hide();

        jQuery('body').on('click', '.wprw-button-next', function(e) {
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];
            var sortable_id = parts[7];

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(jQuery('#current_selected_value_id_' + all_question_id).val());
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_next_questions_front_side",
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    all_selected_value_id: all_question_value,
                    sortable_id: sortable_id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wprw_question_list_new_' + wizard_int_id).html(response.next_html);
                    var total_selected_value = []
                    var current_selected_value_arr = [];
                    var total_question_id = response.question_id_array;
                    jQuery.each(total_question_id, function(i, val) {
                        var current_selected_val = jQuery('#current_selected_value_id_' + val).val();
                        if (current_selected_val != "") {
                            current_selected_value_arr.push(jQuery('#current_selected_value_id_' + val).val());
                        }
                    });
                    if (current_selected_value_arr != '') {
                        total_selected_value.push(current_selected_value_arr);
                    }
                    jQuery('#all_selected_value_id').val(total_selected_value);
                    var total_selected_value_with_join = total_selected_value.join(',');
                    var split_val = total_selected_value_with_join.split(',');
                    jQuery.each(split_val, function(i, val) {
                        jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
                    });
                }
            });
        });

        jQuery('body').on('click', '.wprw-button-previous', function(e) {
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];
            var sortable_id = parts[7];

            var all_selected_value_id = jQuery.trim(jQuery('#all_selected_value_id').val());

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(jQuery('#current_selected_value_id_' + all_question_id).val());
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_previous_questions_front_side",
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    all_selected_value_id: all_question_value,
                    sortable_id: sortable_id
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#wprw_question_list_new_' + wizard_int_id).html(response.previous_html);
                    var total_selected_value = []
                    var current_selected_value_arr = [];
                    var total_question_id = response.question_id_array;
                    jQuery.each(total_question_id, function(i, val) {
                        var current_selected_val = jQuery('#current_selected_value_id_' + val).val();
                        if (current_selected_val != "") {
                            current_selected_value_arr.push(jQuery('#current_selected_value_id_' + val).val());
                        }
                    });
                    if (current_selected_value_arr != '') {
                        total_selected_value.push(current_selected_value_arr);
                    }
                    jQuery('#all_selected_value_id').val(total_selected_value);
                    var total_selected_value_with_join = total_selected_value.join(',');
                    var split_val = total_selected_value_with_join.split(',');
                    jQuery.each(split_val, function(i, val) {
                        jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
                    });
                }
            });
        });

        jQuery('body').on('click', 'span.wprw-answer-selector input.wprw-input', function(e) {
            var input_value = jQuery(this).val();
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];

            jQuery('#ajax_loader_wizard').show();

            var input_name = jQuery(this).attr('name');
            var allInputs = jQuery("input.wprw-input:input");
            var allInputs_type = jQuery.trim(allInputs.attr('type'));
            var current_selected_value = [];
            var current_selected_value_with_join;
            if (allInputs_type == 'radio') {
                var radioValue = jQuery("input.wprw-input:radio:checked").val();
                if (radioValue) {
                    current_selected_value = radioValue;
                }
                current_selected_value_with_join = current_selected_value;
            }

            jQuery('#current_selected_value_id_' + question_int_id).val(current_selected_value);

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(current_selected_val);
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            var total_selected_value_pass_database = '\'' + total_selected_value_with_join.split(',').join('\',\'') + '\'';

            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_ajax_woocommerce_product_list",
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    current_option_id: option_int_id,
                    current_selected_value: current_selected_value_with_join,
                    all_selected_value: total_selected_value_pass_database,
                },
                dataType: 'json',
                success: function(response) {
                    jQuery('#ajax_loader_wizard').hide();
                    jQuery('#perfect_product_div_' + wizard_int_id).html(response.product_html);
                    jQuery('#recently_product_div_' + wizard_int_id).html(response.store_product_html);
                    jQuery('#front_pagination_div_' + wizard_int_id).html(response.pagination_html);

                    var k = 0;
                    jQuery.each(split_val, function(i, val) {
                        var j = 0;
                        jQuery('.prd_section .prd-attribute').each(function() {
                            j++;
                            var prd_attribute_class = jQuery.trim(jQuery(this).attr('class'));
                            if (prd_attribute_class == 'prd-attribute') {
                                jQuery(this).addClass('prd-neutral-attr');
                            }
                        });
                        k++;
                    });

                    jQuery('.prd_section').each(function() {
                        var prd_attribute_id = jQuery(this).attr('id');
                        var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf("_") + 1));

                        var negative_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-negative-attr').sort(sortMe);
                        var neutral_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-neutral-attr').sort(sortMe);

                        function sortMe(a, b) {
                            return a.className < b.className;
                        }

                        jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(negative_value);
                        jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(neutral_value);

                    });
                }
            });
        });

        jQuery(".front_pagination a").live('click', function(e) {
            e.preventDefault();
            var pageNumID = this.id;
            var parts = pageNumID.split('_');
            var wizard_id = parts[1];
            var questions_id = parts[3];
            var option_id = parts[5];
            var curr_selected_value = parts[7];
            var numRecords = parts[9];
            var pageNum = parts[11];
            var total_selected_value_pass_database = jQuery('#all_selected_value').val();
            var perfect_product_div_length = jQuery('#perfect_product_div .prd_section').length;
            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function(i) {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf("_") + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val != "") {
                    all_question_value.push(current_selected_val);
                }
            });
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery('#ajax_loader_wizard').show();
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: "get_ajax_woocommerce_product_list",
                    current_wizard_id: wizard_id,
                    current_question_id: questions_id,
                    current_option_id: option_id,
                    current_selected_value: curr_selected_value,
                    all_selected_value: total_selected_value_pass_database,
                    pagenum: pageNum,
                    limit: numRecords,
                    perfect_product_div_length: perfect_product_div_length
                },
                dataType: 'json',
                success: function(response) {
//                    console.log(response.product_html);
//                    console.log(response.store_product_html);
                    jQuery('#ajax_loader_wizard').hide();
                    jQuery('#perfect_product_div_' + wizard_id).html(response.product_html);
                    jQuery('#recently_product_div_' + wizard_id).html(response.store_product_html);
                    jQuery('#front_pagination_div_' + wizard_id).html(response.pagination_html);

                    var k = 0;
                    jQuery.each(split_val, function(i, val) {
                        var j = 0;
                        jQuery('.prd_section .prd-attribute').each(function() {
                            j++;
                            var prd_attribute_class = jQuery.trim(jQuery(this).attr('class'));
                            if (prd_attribute_class == 'prd-attribute') {
                                jQuery(this).addClass('prd-neutral-attr');
                            }
                        });
                        k++;
                    });
                    jQuery('.prd_section').each(function() {
                        var prd_attribute_id = jQuery(this).attr('id');
                        var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf("_") + 1));

                        var negative_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-negative-attr').sort(sortMe);
                        var neutral_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-neutral-attr').sort(sortMe);

                        function sortMe(a, b) {
                            return a.className < b.className;
                        }

                        jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(negative_value);
                        jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(neutral_value);
                    });
                }
            });
        });

        jQuery('body').on('click', '.wprv-list-restart-button', function(e) {
            var confrim = confirm("Are you sure want to restart?");
            if (confrim == true) {
                setTimeout(function() {
                    location.reload(true);
                }, 1000);
            } else {
                return false;
            }
        });
    });


    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

})(jQuery);
