(function ($) {
    jQuery(document).ready(function () {
        /**
         * --------------------------------------------------
         * Attachment
         * --------------------------------------------------
         */
        $('.customizer-framework--attachment-btn-open').on('click', function (e) {
            e.preventDefault();
            let media_uploader;
            let id = $(this).data('id');
            let type = $(this).data('type');
            let extensions = $(this).data('extensions');
            let frame = $('#customizer-framework--attachment-frame-' + id);
            let thumbnail = $('#customizer-framework--attachment-thumbnail-' + id);
            let open_button = $('#customizer-framework--attachment-btn-open-' + id);
            let main_input = $('#customizer-framework--attachment-main-input-' + id);
            let error_message = $('#customizer-framework--attachment-error-' + id);
            let not_found_btn = $('#customizer-framework--attachment-btn-not-found-' + id);
            let current_value = main_input.val();

            // return the title with type
            let get_title = type => {
                return 'Select ' + type.charAt(0).toUpperCase() + type.slice(1);
            }

            // return all mimes depending on extensions
            let get_mimes = (extensions, type) => {
                let mime;
                if (extensions.length > 0) {
                    mime = extensions;
                } else {
                    switch (type) {
                        case 'image':
                            mime = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];
                            break;
                        case 'video':
                            mime = ['video/mp4', 'video/x-m4v', 'video/quicktime', 'video/x-ms-wmv', 'video/avi',
                                'video/mpeg', 'video/ogg', 'video/3gpp', 'video/3gpp2', 'video/mpeg', 'video/webm', 'video/x-matroska'];
                            break;
                        case 'audio':
                            mime = ['audio/mpeg3', 'audio/m4a', 'audio/ogg', 'audio/wav', 'audio/mpeg'];
                            break;
                        case 'application':
                            mime = ['application/pdf', 'application/msword', 'application/mspowerpoint', 'application/powerpoint',
                                'application/vnd.ms-powerpoint', 'application/x-mspowerpoint', 'application/octet-stream',
                                'application/excel', 'application/vnd.ms-excel', 'application/x-excel', 'application/x-msexcel',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.oasis.opendocument.text',
                                'application/mspowerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                            break;
                    }
                }

                return mime;
            }

            let mimes = get_mimes(extensions, type);

            // check media_uploader if initialize then open
            if (media_uploader) {
                media_uploader.open();

                return;
            }

            // initialize media uploader
            media_uploader = wp.media.frames.file_frame = wp.media({
                title: get_title(type),
                button: {
                    text: 'Select'
                },
                library: {
                    type: mimes,
                },
                multiple: false
            }).on('open', function () {
                // setting media uploader default selected
                if (current_value !== '') {
                    let selection = media_uploader.state().get('selection');
                    let attachment = wp.media.attachment(current_value);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                }
            }).on('select', function () {
                // get selected attachment
                let attachment = media_uploader.state().get('selection').first().toJSON();
                if (!customizer_framework_is_empty(attachment) && attachment.id !== current_value) {
                    if (attachment.type == type) {
                        if (mimes.indexOf(attachment.mime) !== -1) {
                            if (type == 'image') {
                                thumbnail.find('img').attr('src', attachment.url);
                            } else {
                                thumbnail.find('img').attr('src', attachment.icon);
                                thumbnail.find('p').text(attachment.filename).attr('title', attachment.filename);
                            }

                            frame.show();
                            open_button.hide();
                            thumbnail.show();
                            not_found_btn.hide();
                            main_input.val(attachment.id).trigger('change');
                        } else {
                            customizer_framework_alert_error({
                                element: error_message,
                                message: `${attachment.mime} extension is not allowed.`
                            });
                        }
                    } else {
                        customizer_framework_alert_error({
                            element: error_message,
                            message: `Format ${attachment.type} is not allowed. Please select ${type} format only`
                        });
                    }
                }
            });

            // re-open the media uploader
            media_uploader.open();
        });

        // removing all attachment
        $('.customizer-framework--attachment-btn-remove').on('click', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            let frame = $('#customizer-framework--attachment-frame-' + id);
            let open_button = $('#customizer-framework--attachment-btn-open-' + id);
            let main_input = $('#customizer-framework--attachment-main-input-' + id);

            frame.hide();
            open_button.show();
            main_input.val('').trigger('change');
        });

        /**
         * --------------------------------------------------
         * Checkbox Multiple
         * --------------------------------------------------
         */
        $('.customizer-framework--checkbox-multiple').on('change', function () {
            customizer_framework_get_checkbox_multiple_value($(this).parent().parent());
        });

        function customizer_framework_get_checkbox_multiple_value(element) {
            var array_value = element.find('.customizer-framework--checkbox-multiple').map(function () {
                if ($(this).is(':checked')) {
                    return $(this).val();
                }
            }).toArray();
            element.find('.customizer-framework--checkbox-multiple-input').val(JSON.stringify(array_value)).trigger('change');
        }

        /**
         * --------------------------------------------------
         * Checkbox Pill
         * --------------------------------------------------
         */
        $('.customizer-framework--checbox-pill-list').each(function (index) {
            $('.customizer-framework--checkbox-pill').on('change', function () {
                let control = $(this).parent().parent().parent();
                let selected = control.find('.customizer-framework--checkbox-pill').map(function () {
                    if ($(this).is(':checked')) {
                        return $(this).val();
                    }
                }).toArray();
                control.find('.customizer-framework--checkbox-pill-input').val(JSON.stringify(selected)).trigger('change');
            });
        });

        /**
         * --------------------------------------------------
         * Code Editor
         * --------------------------------------------------
         */
        $('.customizer-framework--code-editor-textarea').each(function () {
            let id = $(this).data('id'),
                language = $(this).data('language'),
                textarea = document.getElementById('customizer-framework--code-editor-textarea-' + id),
                main_input = $('#customizer-framework--code-editor-input-' + id);

            // validate language and set default
            let get_mode = (language) => {
                if (customizer_framework_is_empty(language)) {
                    return 'htmlmixed';
                }

                if (language == 'html') {
                    return 'htmlmixed';
                }

                return language;
            };

            // initialize CodeMirror
            let editor = CodeMirror.fromTextArea(textarea, {
                lineNumbers: true,
                matchBrackets: true,
                lineWrapping: true,
                styleActiveLine: true,
                styleActiveSelected: true,
                mode: get_mode(language),
            });

            // setting value of code editor
            editor.setValue(main_input.val());

            // pass code editor value into main input and trigger change
            editor.on('blur', function () {
                main_input.val(editor.getValue()).trigger('change');
            });
        });

        /**
         * --------------------------------------------------
         * Color Picker
         * --------------------------------------------------
         */
        //Initialize color picker target by class
        $('.customizer-framework--color-picker').each(function (index) {
            let me = $(this),
                element = '#' + me.attr('id'),
                id = me.data('id'),
                opacity = me.data('opacity'),
                default_value = me.data('default'),
                parent = '#customizer-framework--color-picker-parent-' + id
            app_class = 'customizer-framework--color-picker-prc-app customizer-framework--color-picker-prc-app-' + id;


            let color_picker = Pickr.create({
                el: element,
                theme: 'classic',
                default: default_value,
                container: parent,
                appClass: app_class,
                inline: true,
                autoReposition: false,
                useAsButton: true,
                swatches: [
                    '#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#03a9f4',
                    '#00bcd4', '#009688', '#4caf50', '#8bc34a', '#cddc39', '#ffeb3b', '#ffc107',
                    '#ff9800', '#ff5722', '#795548', '#9e9e9e', '#607d8b', '#000000'
                ],
                components: {

                    // Main components
                    preview: true,
                    opacity: customizer_framework_boolean(opacity),
                    hue: true,

                    // Interactions Components
                    interaction: {
                        hex: false,
                        rgba: false,
                        hsla: false,
                        hsva: false,
                        cmyk: false,
                        save: true,
                        cancel: true
                    }
                }
            }).on('save', (color, instance) => {

                let color_result;
                if (customizer_framework_in_array($(this).data('format'), ['hex', 'HEX'])) {
                    color_result = color.toHEXA().toString(3);
                } else if (customizer_framework_in_array($(this).data('format'), ['rgba', 'RGBA'])) {
                    color_result = color.toRGBA().toString(3);
                }

                $('#customizer-framework--color-picker-selector-color-' + $(this).data('id')).css('background', color_result);
                $('#customizer-framework--color-picker-input-' + $(this).data('id')).val(color_result).trigger('change');
            });
        });

        // Open color picker
        $('.customizer-framework--color-picker-selector').click(function (e) {
            e.preventDefault();
            let id = $(this).data('id'),
                color_picker = '.customizer-framework--color-picker-prc-app-' + id;

            $(color_picker).toggleClass('visible');
            $(color_picker).toggleClass('show');
        });


        /**
         * --------------------------------------------------
         * Content Editor
         * --------------------------------------------------
         */
        $('.customizer-framework--content-editor-textarea').each(function () {
            // setting and validating toolbars
            let get_toolbars = () => {
                const toolbars = $(this).data('toolbars');
                if (customizer_framework_is_empty(toolbars)) {
                    return 'bold italic bullist numlist alignleft aligncenter alignright link unlink wp_more spellchecker underline alignjustify forecolor formatselect';
                }

                return toolbars;
            };

            // validating and sanitizing uploader boolean
            let get_upload = () => {
                const upload = $(this).data('uploader');
                return (!customizer_framework_is_empty(upload) && upload);
            };

            // initialize editor
            wp.editor.initialize($(this).attr('id'), {
                tinymce: {
                    wpautop: true,
                    toolbar1: get_toolbars(),
                    toolbar2: ''
                },
                quicktags: true,
                mediaButtons: get_upload(),
            });
        });

        // trigger change on load
        $(document).on('tinymce-editor-init', function (_, editor) {
            editor.on('change', function (e) {
                tinyMCE.triggerSave();
                $('#' + editor.id).trigger('change');
            });
        });

        /**
         * --------------------------------------------------
         * Date Picker
         * --------------------------------------------------
         */
        $('.customizer-framework--date-picker-input').each(function (index) {
            let attr_id = $(this).attr('id'),
                mode = $(this).data('mode'),
                id = $(this).data('id'),
                selected_dates = $(this).data('value'),
                enable_time = customizer_framework_boolean($(this).data('enable_time'));

            let config = customizer_framework_date_picker_configurations({
                enableTime: enable_time,
                defaultDate: selected_dates
            });

            $('#' + attr_id).flatpickr({
                inline: true,
                mode: mode,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                enableTime: enable_time,
                time_24hr: true,
                defaultDate: config.set_default_date(),
                onChange: function (selectedDates, dateStr, instance) {
                    if (mode == 'range') {
                        if (selectedDates[0] != undefined && selectedDates[1] != undefined) {
                            $('#customizer-framework--date-picker-input-main-' + id).val(selectedDates).trigger('change');
                        }
                    } else {
                        $('#customizer-framework--date-picker-input-main-' + id).val(selectedDates).trigger('change');
                    }
                },
            });
        });

        // Click event when clicking input
        $('.customizer-framework--date-picker-input').click(function (e) {

            e.stopPropagation();
            let parent = $(this).parent().parent();
            customizer_framework_date_picker_display_state(parent);
        });

        // Click event when clicking open button
        $('.customizer-framework--date-picker-btn-open').click(function (e) {

            e.stopPropagation();
            e.preventDefault();
            let id = $(this).data('id'),
                parent = $(this).parent().parent();
            customizer_framework_date_picker_display_state(parent);
        });

        $('.customizer-framework--date-picker-btn-clear').click(function (e) {

            e.preventDefault();
            let id = $(this).data('id'),
                input = $(this).prev().prev().prev(),
                input_main = $('#customizer-framework--date-picker-input-main-' + id);

            input.val('');
            input_main.val('').trigger('change');
        });

        // For adding class and removing class in main parent
        function customizer_framework_date_picker_display_state(parent_obj) {
            if (parent_obj.hasClass('show') === true) {
                parent_obj.removeClass('show');
            } else {
                parent_obj.addClass('show');
            }
        }

        /**
         * Return the configuration for datepicker
         * @param  {[ object ]} config [the set of options]
         * @return {[ object ]}
         */
        function customizer_framework_date_picker_configurations(config) {

            let configurations = {

                /**
                 * Return the correct format with time or no time
                 * @require boolean  enableTime
                 * @return string 	the final format for alt
                 */
                set_alt_format: function () {

                    let format;
                    if (config.enableTime == true) {
                        format = 'F j, Y H:i';
                    } else {
                        format = 'F j, Y';
                    }
                    return format;
                },
                /**
                 * Return the default dates with single and range mode
                 * @required  string    default dates
                 * @return array    serries of default dates
                 */
                set_default_date: function () {
                    if (!customizer_framework_is_empty(config.defaultDate)) {
                        let final_date = [];
                        let dates = config.defaultDate.split(',');
                        dates.forEach(function (date) {
                            let new_date = new Date(date);
                            let full_date = [new_date.getFullYear(), new_date.getMonth() + 1, new_date.getDate()];
                            final_date.push(full_date.join('-'));
                        });
                        return final_date;
                    } else {
                        return 'today';
                    }
                }
            }

            return configurations;
        }

        /**
         * --------------------------------------------------
         * Time Picker
         * --------------------------------------------------
         */
        $('.customizer-framework--time-picker-input').each(function (index) {
            let attr_id = $(this).attr('id'),
                id = $(this).data('id'),
                value = $(this).data('value'),
                military_format = $(this).data('military_format');

            if (customizer_framework_is_empty(military_format)) {
                military_format = false;
            } else {
                military_format = true;
            }

            $('#' + attr_id).flatpickr({
                inline: true,
                dateFormat: 'H:i',
                noCalendar: true,
                enableTime: true,
                time_24hr: military_format,
                defaultDate: value,
                onChange: function (timeSelected, timeStr, instance) {
                    if (!customizer_framework_is_empty(timeSelected)) {
                        let time = new Date(timeSelected);
                        let full_time = ('0' + time.getHours()).slice(-2) + ':' + ('0' + time.getMinutes()).slice(-2);
                        $('#customizer-framework--time-picker-input-main-' + id).val(full_time).trigger('change');
                    }
                }
            });
        });

        // Click event when clicking input
        $('.customizer-framework--time-picker-input').click(function (e) {

            e.stopPropagation();
            let parent = $(this).parent().parent();
            customizer_framework_time_picker_display_state(parent);
        });

        // Click event when clicking open button
        $('.customizer-framework--time-picker-btn-open').click(function (e) {

            e.stopPropagation();
            e.preventDefault();
            let id = $(this).data('id'),
                parent = $(this).parent().parent();
            customizer_framework_time_picker_display_state(parent);
        });

        $('.customizer-framework--time-picker-btn-clear').click(function (e) {

            e.preventDefault();
            let id = $(this).data('id'),
                input = $(this).prev().prev().prev(),
                input_main = $('#customizer-framework--time-picker-input-main-' + id);

            input.val('');
            input_main.val('').trigger('change');
        });


        // For adding class and removing class in main parent
        function customizer_framework_time_picker_display_state(parent_obj) {
            if (parent_obj.hasClass('show') === true) {
                parent_obj.removeClass('show');
            } else {
                parent_obj.addClass('show');
            }
        }

        /**
         * --------------------------------------------------
         * Numeric Control
         * --------------------------------------------------
         */
        $('.customizer-framework--numeric').keyup(function (e) {
            let me = $(this),
                id = me.attr('id'),
                min = parseFloat(me.data('min')),
                max = parseFloat(me.data('max')),
                input_real = $('#' + id.replace("-mirror", '', ""));

            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
                customizer_framework_numeric_validation(me, min, max, this.value);
                input_real.val(this.value);
                input_real.trigger('change');
            } else {
                if (this.value !== '') {
                    customizer_framework_numeric_validation(me, min, max, this.value);
                    input_real.val(this.value);
                    input_real.trigger('change');
                }
            }
        });

        $('.customizer-framework--numeric').focusout(function () {
            let me = $(this),
                id = me.attr('id')
            min = me.data('min'),
                input_real = $('#' + id.replace("-mirror", '', ""));

            if (me.val() == '') {
                me.val(min);
                input_real.val(min);
                input_real.trigger('change');
            }
        });

        $('.customizer-framework--numeric-btn').click(function () {
            let me = $(this),
                input = $('#' + me.data('target_id') + '-mirror'),
                input_real = $('#' + me.data('target_id')),
                min = parseFloat(input.data('min')),
                max = parseFloat(input.data('max')),
                step = parseFloat(input.data('step')),
                value = parseFloat(input.val()),
                role = me.data('role'),
                result;

            if (input.val() === '') {
                value = 0;
            }

            if (role === 'minus') {
                if (value > min) {
                    result = value - step;
                    input.val(result);
                    input_real.val(result);
                    input_real.trigger('change');
                }
            } else if (role === 'plus') {
                if (value < max) {
                    result = value + step;
                    input.val(result);
                    input_real.val(result);
                    input_real.trigger('change');
                }
            }
        });

        /**
         * --------------------------------------------------
         * Range Slider Stepper
         * --------------------------------------------------
         */
        $(".customizer-framework--range").each(function () {
            let id = $(this).attr('id');
            rangejs(document.getElementById(id), {
                css: true,
                change: function (event, ui, data) {
                    $('#' + id).trigger('change');
                }
            });
        });

        /**
         * --------------------------------------------------
         * Size Control
         * --------------------------------------------------
         */
        $('.customizer_framework__size_field').on('keyup', function (e) {
            e.preventDefault();

            let $this = $(this);
            let id = $this.attr('id');
            let $unit_select = $this.siblings('select[name=' + id + '_unit]').first();
            let $input = $('#' + id +  '_hidden');

            $input.val($this.val() + $unit_select.val());
            $input.trigger('change');
        });

        $('.customizer_framework__size_unit_select').on('change', function (e) {
            e.preventDefault();

            let $this = $(this);
            let $size = $this.siblings('.customizer_framework__size_field').first();
            let id = $size.attr('id');
            let $input = $('#' + id +  '_hidden');

            $input.val($size.val() + $this.val());
            $input.trigger('change');
        });

        /**
         * Tagging Control
         *
         * @since 1.0.0
         */
        $(".customizer-framework--tagging-control").each(function () {

            let args = {
                maxItems: $(this).data('maxitem'),
            }

            $(this).selectize({
                plugins: ['remove_button', 'drag_drop'],
                maxItems: args.maxItems,
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                },
                onChange: function () {
                    $(this).trigger('change');
                }
            });
        });


        /**
         * Tagging Select Control.
         *
         * @since 1.0.0
         */
        $(".customizer-framework--tagging-select-control").each(function () {

            let args = {
                maxItems: $(this).data('maxitem'),
            }

            $(this).selectize({
                plugins: ['remove_button', 'drag_drop'],
                maxItems: args.maxItems,
                delimiter: ',',
                persist: false,
                create: function (input) {
                    return {
                        value: input,
                        text: input
                    }
                },
                onChange: function () {
                    $(this).trigger('change');
                }
            });
        });

        /**
         * Accordion.
         *
         * @since 1.0.0
         */
        $('.customizer-framework--accordion-head').click(function () {
            let me = $(this),
                state = me.attr('data-state'),
                body = me.next('.customizer-framework--accordion-body');

            if (state == 'close') {
                body.slideDown();
                me.removeClass('close');
                me.addClass('open');
                me.attr('data-state', 'open');
            } else {
                body.slideUp();
                me.removeClass('open');
                me.addClass('close');
                me.attr('data-state', 'close');
            }

        });


        /**
         * Color Palette Material.
         *
         * @since 1.0.0
         */
        $('.customizer-framework--color-set-colors-container').click(function () {
            let me = $(this),
                color = me.data('color'),
                target_class = me.data('target_id') + '-container',
                target_id = $('#' + me.data('target_id')),
                current_color = target_id.val(),
                color_preview = $('#' + me.data('target_id') + '-color-preview'),
                color_label = $('#' + me.data('target_id') + '-color-label');

            if (current_color != color) {
                $('.' + target_class).removeClass('selected');
                me.addClass('selected');
                color_label.text(color);
                color_preview.css('background-color', color);
                target_id.val(color);
                target_id.trigger('change');
            }

        });

        $('.customizer-framework--color-set-btn-default').click(function (e) {

            e.preventDefault();

            let me = $(this),
                id = me.data('target_id'),
                default_value = me.data('default_value'),
                input = $('#' + id),
                color_preview = $('#' + id + '-color-preview'),
                color_label = $('#' + id + '-color-label'),
                target_class = id + '-container';

            if (input.val() != default_value) {
                $('.' + target_class).removeClass('selected');
                color_preview.css('background-color', default_value);
                color_label.text(default_value);
                input.val(default_value);
                input.trigger('change');
            }

        });

        /**
         * ------------------------
         * 		FUNCTIONS
         * ------------------------
         */
        // Numeric validation
        function customizer_framework_numeric_validation(input, min, max, value) {
            if (value < min) {
                input.val(min);
            } else if (value > max) {
                input.val(max);
            }
        }

        // Checks if the string has a number
        function customizer_framework_has_number(value) {
            return /\d/.test(value);
        }

        // Checks if value exists in array
        function customizer_framework_in_array($needle, $hystack) {
            if ($hystack.indexOf($needle) == -1) {
                return false;
            }
            return true;
        }

        // Convert number to boolean 1 | 0
        function customizer_framework_boolean($number) {

            let output;

            if ($number == 1) {
                output = true;
            } else {
                output = false;
            }
            return output;
        }

        // checks if the variable is empty
        function customizer_framework_is_empty(data) {
            return (!data || data.length === 0);
        }

        // displaying error message
        function customizer_framework_alert_error(obj) {
            obj.element.find('p').text(obj.message);
            obj.element.show().delay(5000).fadeOut();
        }
    });
}(jQuery));
