(function($) {
    'use strict';
    $(window).load(function() {
        jQuery('table#wizard-listing tbody').sortable();
        /*Table Sorter*/
        jQuery(".tablesorter").tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                4: {
                    sorter: false
                }
            }
        });

        /*Accordian section for option section*/
        jQuery("#accordion").accordion({
            header: "> div > h3",
            collapsible: true,
            active: false,
            autoHeight: false,
            autoFill: true,
            autoActivate: true,
            beforeActivate: function(event, ui) {
                // The accordion believes a panel is being opened
                if (ui.newHeader[0]) {
                    var currHeader = ui.newHeader;
                    var currContent = currHeader.next('.ui-accordion-content');
                    // The accordion believes a panel is being closed
                } else {
                    var currHeader = ui.oldHeader;
                    var currContent = currHeader.next('.ui-accordion-content');
                }
                // Since we've changed the default behavior, this detects the actual status
                var isPanelSelected = currHeader.attr('aria-selected') == 'true';
                // Toggle the panel's header
                currHeader.toggleClass('ui-corner-all', isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top', !isPanelSelected).attr('aria-selected', ((!isPanelSelected).toString()));
                // Toggle the panel's icon
                currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e', isPanelSelected).toggleClass('ui-icon-triangle-1-s', !isPanelSelected);
                // Toggle the panel's content
                currContent.toggleClass('accordion-content-active', !isPanelSelected)
                if (isPanelSelected) {
                    currContent.slideUp();
                } else {
                    currContent.slideDown();
                }

                return false; // Cancels the default action
            }
        });

        jQuery(function() {
            jQuery("#accordion")
                    .accordion({
                        header: "> div > h3"
                    })
                    .sortable({
                        axis: "y",
                        handle: "h3",
                        stop: function(event, ui) {
                            var sortable_option_data = jQuery(this).sortable('serialize', {key: 'string'});
                            sortable_option_data = sortable_option_data.substr(0, sortable_option_data.lastIndexOf("&"));
                            var option_sortable_data_arr = sortable_option_data.split('&');
                            var i = 0;
                            var str = '';
                            for (i; i < option_sortable_data_arr.length; i++) {
                                if (str != "") {
                                    str += ',';
                                }
                                str += option_sortable_data_arr[i].slice(7);
                            }
                            var url_parameters = getUrlVars();
                            var current_wizard_id = url_parameters['wrd_id'];
                            var current_question_id = url_parameters['que_id'];
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: "sortable_option_list_based_on_id",
                                    wizard_id: current_wizard_id,
                                    question_id: current_question_id,
                                    option_sortable_data: str
                                },
                                success: function(response) {
                                    //alert(response);
                                }
                            });
                        }
                    }).on('stop', function() {
                jQuery(this).children().each(function(i) {
                    jQuery(this).data('index', i)
                });
            }).trigger('stop');
        });

        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        jQuery(document).ready(function(e) {
            var url_parameters = getUrlVars();
            var current_wizard_id = url_parameters['wrd_id'];
            displayRecords(current_wizard_id, 5, 1);
        });

        /*Check all checkbox wizard*/
        jQuery('body').on('click', '#chk_all_wizard', function(e) {
            jQuery('input.chk_single_wizard:checkbox').not(this).prop('checked', this.checked);

            var numberOfChecked = jQuery("input[name='chk_single_wizard_chk']:checked").length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_wizard').removeAttr("disabled")
            } else {
                jQuery('#detete_all_selected_wizard').attr("disabled", "disabled");
            }
        });

        jQuery('body').on('click', '.chk_single_wizard', function(e) {
            var numberOfChecked = jQuery("input[name='chk_single_wizard_chk']:checked").length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_wizard').removeAttr("disabled")
            } else {
                jQuery('#detete_all_selected_wizard').attr("disabled", "disabled");
            }
        });

        /*Get all checkbox checked value*/
        jQuery('body').on('click', '#detete_all_selected_wizard', function(e) {
            var numberOfChecked = jQuery("input[name='chk_single_wizard_chk']:checked").length;
            if (numberOfChecked >= 1) {
                var confrim = confirm("Remove all selected wizard?");
                if (confrim == true) {
                    var selected_wizard_arr = [];
                    jQuery.each(jQuery("input[name='chk_single_wizard_chk']:checked"), function() {
                        selected_wizard_arr.push(jQuery(this).val());
                    });
                    var selected_wizard = selected_wizard_arr;//.join(", ")
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: "delete_selected_wizard_using_checkbox",
                            selected_wizard_id: selected_wizard
                        },
                        success: function(response) {
                            if (response == 'true') {
                                jQuery.each(selected_wizard, function(index, value) {
                                    jQuery('#wizard_row_' + value).remove();
                                });
                            } else {

                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });

        /*Delete single wizard using delete button*/
        jQuery('body').on('click', '.delete_single_selected_wizard', function(e) {
            var single_selected_wizard = jQuery(this).attr('id');
            var single_selected_wizard_int_id = single_selected_wizard.substr(single_selected_wizard.lastIndexOf("_") + 1);
            var wizard_name = jQuery(this).data('attr_name');
            var confrim = confirm("Remove " + wizard_name + "?");
            if (confrim == true) {
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "delete_single_wizard_using_button",
                        single_selected_wizard_id: single_selected_wizard_int_id
                    },
                    success: function(response) {
                        if (response == 'true') {
                            jQuery('#wizard_row_' + single_selected_wizard_int_id).remove();
                        } else {

                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Check all checkbox wizard*/
        jQuery('body').on('click', '#chk_all_question', function(e) {
            jQuery('input.chk_single_question:checkbox').not(this).prop('checked', this.checked);

            var numberOfChecked = jQuery("input[name='chk_single_question_name']:checked").length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_question').removeAttr("disabled")
            } else {
                jQuery('#detete_all_selected_question').attr("disabled", "disabled");
            }
        });

        jQuery('body').on('click', '.chk_single_question', function(e) {
            var numberOfChecked = jQuery("input[name='chk_single_question_name']:checked").length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_question').removeAttr("disabled")
            } else {
                jQuery('#detete_all_selected_question').attr("disabled", "disabled");
            }
        });

        /*Get all checkbox checked value*/
        jQuery('body').on('click', '#detete_all_selected_question', function(e) {
            var numberOfChecked = jQuery("input[name='chk_single_question_name']:checked").length;
            if (numberOfChecked >= 1) {
                var confrim = confirm("Remove all selected questions?");
                if (confrim == true) {
                    var selected_question_arr = [];
                    jQuery.each(jQuery("input[name='chk_single_question_name']:checked"), function() {
                        selected_question_arr.push(jQuery(this).val());
                    });
                    var selected_question = selected_question_arr;//.join(", ")
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: "delete_selected_question_using_checkbox",
                            selected_question_id: selected_question
                        },
                        success: function(response) {
                            if (response == 'true') {
                                jQuery.each(selected_question, function(index, value) {
                                    jQuery('#after_updated_question_' + value).remove();
                                });
                            } else {

                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });

        /*Delete single questions using delete button*/
        jQuery('body').on('click', '.delete_single_question_using_button', function(e) {
            var confrim = confirm("Remove single selected question?");
            if (confrim == true) {
                var single_selected_question = jQuery(this).attr('id');
                var single_selected_question_int_id = single_selected_question.substr(single_selected_question.lastIndexOf("_") + 1);
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "delete_single_question_using_button",
                        single_selected_question_id: single_selected_question_int_id
                    },
                    success: function(response) {
                        if (response == 'true') {
                            jQuery('#after_updated_question_' + single_selected_question_int_id).remove();
                        } else {

                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Add new options*/
        jQuery('body').on('click', '#add_new_options', function() {
            var fetchOptionLabel = JSON.parse(optionLabelDetails.option_label);
            var fetchOptionLabelDescription = JSON.parse(optionLabelDetails.option_lable_description);
            var fetchOptionLabelPlaceholder = JSON.parse(optionLabelDetails.option_lable_placeholder);
            var fetchOptionImageLabel = JSON.parse(optionLabelDetails.option_image_lable);
            var fetchOptionErrorName = JSON.parse(optionLabelDetails.option_name_error);
            var fetchOptionImagePro = JSON.parse(optionLabelDetails.option_image_pro);
            var fetchOptionProVersionText = JSON.parse(optionLabelDetails.option_pro_version_text);
            var fetchOptionImageUploadImage = JSON.parse(optionLabelDetails.option_image_upload_image);
            var fetchOptionImageRemoveImage = JSON.parse(optionLabelDetails.option_image_remove_image);
            var fetchOptionErrorName = JSON.parse(optionLabelDetails.option_name_error);
            var fetchOptionAttributeError = JSON.parse(optionLabelDetails.option_attribute_error);
            var fetchOptionAttributeLabel = JSON.parse(optionLabelDetails.option_attribute_lable);
            var fetchOptionAttributeDescription = JSON.parse(optionLabelDetails.option_attribute_description);
            var fetchOptionAttributePlaceholder = JSON.parse(optionLabelDetails.option_attribute_placeholder);
            var fetchOptionValueLabel = JSON.parse(optionLabelDetails.option_value_lable);
            var fetchOptionValueDescription = JSON.parse(optionLabelDetails.option_value_description);
            var fetchOptionValuePlaceholder = JSON.parse(optionLabelDetails.option_value_placeholder);
            var fetchOptionValueError = JSON.parse(optionLabelDetails.option_value_error);
            var fetchTotalCountOptionId = jQuery.trim(JSON.parse(optionLabelDetails.total_count_option_id));
            if (fetchTotalCountOptionId === '0' || fetchTotalCountOptionId === '') {
                fetchTotalCountOptionId = '1';
            }

            var total_count_options = jQuery('.options_rank_class').length;

            var fetchAllAttributeName = JSON.parse(all_attribute_name.attributeArray);
            //var sum_off_total_x = +fetchTotalCountOptionId + +total_count_options;
            var x = +total_count_options + +1;
            if (x == '0') {
                x = '1';
            } else {
                x = +total_count_options + +1;
            }
            var option_title = 'Options';
            var append_new_row = ''
            append_new_row += '<div class="options_rank_class" id="options_rank_' + x + '">';
            append_new_row += '<input type="hidden" name="options_id[][' + x + ']" value="' + x + '">';
            append_new_row += '<h3>' + option_title;
            append_new_row += '<a href="javascript:void(0);" class="ajax_remove_field delete" id="remove_option_' + x + '">Remove</a>';
            append_new_row += '</h3>';
            append_new_row += '<div>';
            append_new_row += '<table class="form-table table-outer product-fee-table" id="option_section">';
            append_new_row += '<tbody>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="options_name">' + fetchOptionLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<input type="text" name="options_name[][' + x + ']" class="text-class half_width" id="options_name_id_' + x + '" value="" required="1" placeholder="' + fetchOptionLabelPlaceholder + '">';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionLabelDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_option_name_' + x + '" style="display:none;">' + fetchOptionErrorName + '</span>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="options_image">' + fetchOptionImageLabel + '</label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip option_image_section">';
            append_new_row += '<img src="' + fetchOptionImagePro + '" onclick="alert(' + "'" + fetchOptionProVersionText + "'" + ');"/>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attribute_name">' + fetchOptionAttributeLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_name_' + x + '" data-placeholder="' + fetchOptionAttributePlaceholder + '" name="attribute_name[][' + x + ']" class="chosen-select-attribute-value category-select chosen-rtl">';
            append_new_row += '<option value=""></option>';
            jQuery.each(fetchAllAttributeName, function(index, value) {
                append_new_row += '<option value="' + jQuery.trim(value) + '">' + jQuery.trim(value) + '</option>';
            });
            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionAttributeDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_attribute_name_' + x + '" style="display:none;">' + fetchOptionAttributeError + '</span>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attributr_value">' + fetchOptionValueLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_value_' + x + '" data-placeholder="' + fetchOptionValuePlaceholder + '" name="attribute_value[][' + x + ']" multiple="true" class="chosen-select-attribute-value category-select chosen-rtl">';
            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wprw_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionValueDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_attribute_value_' + x + '" style="display:none;">' + fetchOptionValueError + '</span>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '</tbody>';
            append_new_row += '</table>';
            append_new_row += '</div>';
            append_new_row += '</div>';
            jQuery('#extra_div').before(append_new_row);//submit_options
            jQuery('#accordion').accordion("refresh");
            jQuery('.accordian_custom_class:last select').chosen();

            jQuery('body').on('change', '#attribute_name_' + x, function(e) {
                var attribute_name = jQuery(this).val();
                var url_parameters = getUrlVars();
                var current_wizard_id = url_parameters['wrd_id'];
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "get_attributes_value_based_on_attribute_name",
                        current_wizard_id: current_wizard_id,
                        attribute_name: attribute_name
                    },
                    success: function(response) {
                        jQuery("#attribute_value_" + x).html(response);
                        jQuery("#attribute_value_" + x).trigger('chosen:updated');
                    }
                });
            });
        });

        /* Validation */
        jQuery('body').on('click', '#submitWizardQuestion', function() {
            var flag = '0';
            jQuery('.options_rank_class').each(function() {
                var options_rank_id = jQuery(this).attr('id');
                var options_rank_int_id = options_rank_id.substr(options_rank_id.lastIndexOf("_") + 1);
                var i = 0;
                jQuery('#options_rank_' + options_rank_int_id).each(function() {
                    var option_title = jQuery.trim(jQuery('#options_name_id_' + options_rank_int_id).val());
                    if (option_title == '') {
                        flag = '1';
                        jQuery('#error_option_name_' + options_rank_int_id).show();
                    } else {
                        jQuery('#error_option_name_' + options_rank_int_id).hide();
                    }
                    if (jQuery('#attribute_name_' + options_rank_int_id + '_chosen').find('a').hasClass('chosen-default')) {
                        flag = '1';
                        jQuery('#error_attribute_name_' + options_rank_int_id).show();
                    } else {
                        jQuery('#error_attribute_name_' + options_rank_int_id).hide();
                    }
                    var attribute_value = jQuery('#attribute_value_' + options_rank_int_id + '_chosen').find('ul').find('li').length;
                    if (attribute_value <= 1) {
                        flag = '1';
                        jQuery('#error_attribute_value_' + options_rank_int_id).show();
                    } else {
                        jQuery('#error_attribute_value_' + options_rank_int_id).hide();
                    }
                    if (option_title == '' || jQuery('#attribute_name_' + options_rank_int_id + '_chosen').find('a').hasClass('chosen-default') || attribute_value <= 1) {
                        flag = '1';
                        jQuery('#options_rank_' + options_rank_int_id).find('h3').attr('style', 'border-color: red !important');
                    } else {
                        jQuery('#options_rank_' + options_rank_int_id).find('h3').attr('style', 'border-color: none');
                    }
                    i++;
                });
            });
            if (flag == '0') {
                return true;
            } else {
                return false;
            }
        });

        /* description toggle */
        jQuery('body').on('click', 'span.woocommerce_wprw_tab_descirtion', function() {
            var data = jQuery(this);
            jQuery(this).next('p.description').toggle();
        });

        jQuery("#custom_pagination a").live('click', function(e) {
            e.preventDefault();
            var pageNum = this.id;
            var parts = pageNum.split('_');
            var wizard_id = parts[1];
            var numRecords = parts[3];
            var pageNum = parts[5];
            //alert(wizard_id + " " + pageNum + " " + numRecords);
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: "get_admin_question_list_with_pagination",
                    wizard_id: wizard_id,
                    pagenum: pageNum,
                    limit: numRecords
                },
                success: function(response) {
                    //alert(response);
                    jQuery("#using_ajax").html(response);
                },
                complete: function tableupdate() {
                    jQuery('table#question_list_table tbody').sortable({
                        axis: 'y',
                        stop: function(event, ui) {
                            var question_sortable_data = jQuery(this).sortable('serialize', {key: 'string'});
                            var question_sortable_data_arr = question_sortable_data.split('&');
                            var i = 0;
                            var str = '';
                            for (i; i < question_sortable_data_arr.length; i++) {
                                if (str != "") {
                                    str += ',';
                                }
                                str += question_sortable_data_arr[i].slice(7);
                            }
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: "sortable_question_list_based_on_id",
                                    wizard_id: wizard_id,
                                    pagenum: pageNum,
                                    limit: numRecords,
                                    question_sortable_data: str
                                },
                                success: function(response) {

                                }
                            });
                        }
                    });
                    jQuery("table#question_list_table tbody").trigger("update");
                },
            });
        });

        function displayRecords(wizard_id, numRecords, pageNum) {
            //alert(wizard_id + " " + numRecords + " " + pageNum);
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: "get_admin_question_list_with_pagination",
                    wizard_id: wizard_id,
                    pagenum: pageNum,
                    limit: numRecords
                },
                success: function(response) {
                    jQuery("#using_ajax").html(response);
                },
                complete: function tableupdate() {
                    //jQuery('table#question_list_table tbody').sortable();
                    jQuery('table#question_list_table tbody').sortable({
                        axis: 'y',
                        stop: function(event, ui) {
                            var question_sortable_data = jQuery(this).sortable('serialize', {key: 'string'});
                            var question_sortable_data_arr = question_sortable_data.split('&');
                            var i = 0;
                            var str = '';
                            for (i; i < question_sortable_data_arr.length; i++) {
                                if (str != "") {
                                    str += ',';
                                }
                                str += question_sortable_data_arr[i].slice(7);
                            }
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: "sortable_question_list_based_on_id",
                                    wizard_id: wizard_id,
                                    pagenum: pageNum,
                                    limit: numRecords,
                                    question_sortable_data: str
                                },
                                success: function(response) {
                                }
                            });
                        }
                    });
                    jQuery(".tablesorter").trigger("update");
                },
            });
        }


        /*Attribute value*/
        var configattributevalue = {
            '.chosen-select-attribute-value': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        }
        for (var selectorattributevalue in configattributevalue) {
            $(selectorattributevalue).chosen(configattributevalue[selectorattributevalue]);
        }

        var fetchAllAttributeValuID = JSON.parse(option_value_id.OptionValueIDArray);
        jQuery.each(fetchAllAttributeValuID, function(index, value) {
            var option_id = value.substr(value.lastIndexOf("_") + 1);
            /*Attribute Option Section*/
            var settingObj = window["allAttributeValue" + option_id];
            var selectedAttributeOptionsArray1 = settingObj.attributeOptionArray;
            var selectedttributeOptionsglobalarr1 = [];
            for (var j in selectedAttributeOptionsArray1) {
                selectedttributeOptionsglobalarr1.push(selectedAttributeOptionsArray1[j]);
            }
            var attributeString1 = '';
            attributeString1 = selectedttributeOptionsglobalarr1.join(",");
            //alert(attributeString1);
            if (attributeString1 != '') {
                jQuery.each(attributeString1.split(","), function(i, e) {
                    jQuery("#attribute_value_" + option_id + " option[value='" + jQuery.trim(e) + "']").prop("selected", true);
                    jQuery("#attribute_value_" + option_id).trigger('chosen:updated');
                });
            }

            /*Attribute Name Section*/
            var settingObj = window["allAttributename" + option_id];
            var selectedAttributeNameArray1 = settingObj.attributeAttributeArray;
            if (selectedAttributeNameArray1 != '') {
                jQuery("#attribute_name_" + option_id + " option[value='" + jQuery.trim(selectedAttributeNameArray1) + "']").prop("selected", true);
                jQuery("#attribute_name_" + option_id).trigger('chosen:updated');
            }

            /*Attribute Name Chosen Section (Using Ajax)*/
            jQuery('body').on('change', '#attribute_name_' + option_id, function(e) {
                var attribute_name = jQuery(this).val();
                var chosen_id = jQuery(this).attr('id');
                var chosen_int_id = chosen_id.substr(chosen_id.lastIndexOf("_") + 1);
                var url_parameters = getUrlVars();
                var current_wizard_id = url_parameters['wrd_id'];
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "get_attributes_value_based_on_attribute_name",
                        current_wizard_id: current_wizard_id,
                        attribute_name: attribute_name
                    },
                    success: function(response) {
                        //alert(response);
                        jQuery("#attribute_value_" + chosen_int_id).html(response);
                        jQuery("#attribute_value_" + chosen_int_id).trigger('chosen:updated');
                    }
                });
            });
        });

        /*Add css for chosen select*/
        jQuery('body').on('click', '.chosen-container-multi', function(e) {
            if (jQuery('.chosen-container-multi').hasClass("chosen-container-active")) {
                jQuery('.chosen-container-multi .chosen-drop').css("position", "relative");
            }
            e.stopPropagation();
        });
        jQuery(document).click(function() {
            jQuery('.chosen-container .chosen-drop').css("position", "absolute");
        });

        /*Upload image in option*/
        jQuery('.option_single_upload_file').live('click', function(event) {
            var id = jQuery(this).attr('id');
            var int_id = id.substr(id.lastIndexOf("_") + 1);
            event.preventDefault();
            var file_frame;
            /*If the media frame already exists, reopen it.*/
            if (file_frame) {
                file_frame.open();
                return;
            }

            /*Create the media frame.*/
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery(this).data('uploader_title'),
                button: {
                    text: jQuery(this).data('uploader_button_text'),
                },
                multiple: false
            });
            file_frame.on('select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();
                jQuery('#option_single_image_src_id_' + int_id).attr('src', attachment.url);
                jQuery('#hf_option_single_image_src_' + int_id).val(attachment.url);
                jQuery('#option_single_image_src_id_' + int_id).css('display', 'block');
            });
            file_frame.open();
        });

        /*Remove image from option*/
        jQuery('.option_single_remove_file').live('click', function(e) {
            var id = jQuery(this).attr('id');
            var int_id = id.substr(id.lastIndexOf("_") + 1);
            jQuery('#option_single_image_src_id_' + int_id).attr('src', '');
            jQuery('#option_single_image_src_id_' + int_id).css('display', 'none');
            jQuery('#hf_option_single_image_src_' + int_id).val('');

        });

        jQuery('body').on("click", ".ajax_remove_field", function(e) { //user click on remove text
            var confrim = confirm("Remove this option?");
            if (confrim == true) {
                e.preventDefault();
                var remove_option_id = jQuery(this).attr('id');
                var remove_option_int_id = remove_option_id.substr(remove_option_id.lastIndexOf("_") + 1);
                jQuery('#options_rank_' + remove_option_int_id).remove();
            } else {
                return false;
            }
        })
        /*Remove option data from ajax*/
        jQuery('body').on('click', '.remove_option_row', function(e) {
            var confrim = confirm("Remove this option?");
            if (confrim == true) {
                var remove_option_id = jQuery(this).attr('id');
                var remove_option_int_id = remove_option_id.substr(remove_option_id.lastIndexOf("_") + 1);
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: "remove_option_data_from_option_page",
                        option_id: remove_option_int_id
                    },
                    success: function(response) {
                        if (response == '1') {
                            jQuery('#options_rank_' + remove_option_int_id).remove();
                        } else {
                            alert('Something error');
                        }
                    }
                });
            } else {
                return false;
            }
        });
    });


})(jQuery);
