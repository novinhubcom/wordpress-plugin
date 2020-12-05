/*
Scripts for post template...
Author: Novinhub
 */
jQuery(document).ready(function ($) {
    var wp_thumbnail_id;
    var max_count = 0;
    wp_thumbnail_id = $('.sendToAPI').data('thumbnail_id');
    var new_wp_thumbnail_id = 0;
    console.log(wp_thumbnail_id);
    $(document).on("click", ".attachment", function () {
        // console.log($(this).data("id"));
        new_wp_thumbnail_id = $(this).data("id");
        console.log(new_wp_thumbnail_id);
    });

    $(document).on("click", ".is-destructive", function () {
        wp_thumbnail_id = 0;
        console.log(wp_thumbnail_id);
    });

    $("#novinhubDatepicker").persianDatepicker({
        "inline": false,
        "format": "dddd YYYY/MM/D HH:mm",
        "viewMode": "day",
        "initialValue": true,
        "minDate": new persianDate().unix(),
        "maxDate": null,
        "autoClose": true,
        "position": "auto",
        "altFormat": "X",
        "altField": "#altfieldunix",
        "onlyTimePicker": false,
        "onlySelectOnDate": true,
        "calendarType": "persian",
        "inputDelay": 800,
        "observer": false,
        "calendar": {
            "persian": {
                "locale": "fa",
                "showHint": true,
                "leapYearMode": "algorithmic"
            },
            "gregorian": {
                "locale": "en",
                "showHint": true
            }
        },
        "navigator": {
            "enabled": true,
            "scroll": {
                "enabled": true
            },
            "text": {
                "btnNextText": "<",
                "btnPrevText": ">"
            }
        },
        "toolbox": {
            "enabled": true,
            "calendarSwitch": {
                "enabled": true,
                "format": "MMMM"
            },
            "todayButton": {
                "enabled": true,
                "text": {
                    "fa": "امروز",
                    "en": "Today"
                }
            },
            "submitButton": {
                "enabled": true,
                "text": {
                    "fa": "تایید",
                    "en": "Submit"
                }
            },
            "text": {
                "btnToday": "امروز"
            }
        },
        "timePicker": {
            "enabled": true,
            "step": 1,
            "hour": {
                "enabled": true,
                "step": null
            },
            "minute": {
                "enabled": true,
                "step": null
            },
            "second": {
                "enabled": false,
                "step": null
            },
            "meridian": {
                "enabled": true
            }
        },
        "dayPicker": {
            "enabled": true,
            "titleFormat": "YYYY MMMM"
        },
        "monthPicker": {
            "enabled": true,
            "titleFormat": "YYYY"
        },
        "yearPicker": {
            "enabled": true,
            "titleFormat": "YYYY"
        },
        "responsive": false
    });

    $("#novinhubPublishChk").change(function () {
        if (this.checked) {
            $("#novinhubPublishSection").css('display', 'block');
            $("#novinhubDatepicker").prop("disabled", false);
        } else {
            $("#novinhubPublishSection").hide();
            $("#novinhubDatepicker").prop("disabled", "disabled");
        }
    });
    tinymce.PluginManager.add('charactercount', function (editor) {
        var _self = this;

        function update(k) {
            if (_self.getCount() >= max_count && max_count !== 0) {
                if (k.keyCode !== 8) {
                    return false;
                }

                if (_self.getCount() > max_count) {
                    var content = editor.getContent({format: 'text'});
                    editor.setContent(content.substring(0, max_count - 1));
                }

            }

            editor.theme.panel.find('#charactercount').text(['Characters: {0}', _self.getCount()]);
        }

        editor.on('init', function () {
            var statusbar = editor.theme.panel && editor.theme.panel.find('#statusbar')[0];

            if (statusbar) {
                window.setTimeout(function () {
                    statusbar.insert({
                        type: 'label',
                        name: 'charactercount',
                        text: ['Characters: {0}', _self.getCount()],
                        classes: 'charactercount',
                        disabled: editor.settings.readonly
                    }, 0);

                    editor.on('setcontent beforeaddundo keydown', update);

                    statusbar.insert({
                        type: 'label',
                        name: 'max-length',
                        text: ['Max Characters: {0}', '∞'],
                        classes: 'charactercount',
                        id: 'max-length',
                        disabled: editor.settings.readonly
                    }, 0);

                }, 0);
            }
        });

        _self.getCount = function () {
            var tx = editor.getContent({format: 'raw'});
            var decoded = decodeHtml(tx);
            var decodedStripped = decoded.replace(/(<([^>]+)>)/ig, '');
            var tc = decodedStripped.length;
            return tc;
        };

        function decodeHtml(html) {
            var txt = document.createElement('textarea');
            txt.innerHTML = html;
            return txt.value;
        }
    });


    tinymce.init({
        selector: '#novinhubTxt',
        menubar: false,
        plugins: 'charactercount',
        elementpath: false,
        branding: false,
        directionality: "rtl",


        setup: function (editor) {
            editor.on('keydown', function (e) {
                var body = editor.getBody();
                var text = tinymce.trim(body.innerText || body.textContent);
            });
        }
    });

    var registerEvent = false;

    function copyText() {
        if ($(".block-editor-block-list__block").length > 0) {
            var content = $(".block-editor-rich-text__editable").text().toString();
            if (max_count !== 0) {
                content = content.substring(0, max_count);
            }
            content = content.replace(/(?:\r\n|\r|\n)/g, '<br>');
            content = content.replace(/<br>\s*<br>/g, '<br>');
            tinyMCE.get('novinhubTxt').setContent(max_count !== 0 ? content.substring(0, max_count) : content);
        }

    }

    copyText();
    $(".block-editor-block-list__layout").on('change', copyText);
    $(".block-editor-block-list__layout").on('keyup', copyText);

    $('.novinhub_li input[type=checkbox]').change(function () {
        if (!registerEvent) {
            $(".block-editor-block-list__layout").on('change', copyText);
            $(".block-editor-block-list__layout").on('keyup', copyText);
            registerEvent = true;
        }

        var twitter = $('.novinhub_li').find("input[data-type=Twitter]:checked").length;
        var instagram = $('.novinhub_li').find("input[data-type=Instagram]:checked").length;
        var telegram = $('.novinhub_li').find("input[data-type=Telegram]:checked").length;

        if (twitter !== 0) {
            max_count = 280;
        }

        else if (twitter === 0 && instagram !== 0) {
            max_count = 2200;
        }

        else if (twitter === 0 && instagram === 0 && telegram !== 0) {
            max_count = 3900;
        }

        else {
            max_count = 0;
        }


        // // }

        var regex = /\d{1,4}/gm;
        var txt = $("#max-length").html();

        txt = txt.replace("∞", max_count);
        txt = txt.replace(regex, max_count);

        if (max_count === 0)
            txt = txt.replace(regex, "∞");


        $("#max-length").html(txt);

        if ($(this).is(':checked')) {
            copyText();
        }


    });

    $(".sendToAPI").on('click', function () {
        var has_video = false;
        var has_image = false;
        var more_than_one_videos = false;
        var more_than_one_images = false;


        //Check if the box has video to upload
        var video = $(".block-editor-block-list__layout [aria-label='Block: Video'] video");
        var video_fa = $(".block-editor-block-list__layout [aria-label='بلوک: ویدئو'] video");
        if (video.length > 0 || video_fa.length > 0) {
            if (video.length > 1 || video_fa.length > 1) {
                more_than_one_videos = true;
            }
            has_video = true;
            if (video_fa.length > 0) {
                var video_url = video_fa.attr('src');
            } else if (video.length > 0) {
                var video_url = video.attr('src');
            }
            console.log(video_url);
        }

        //Check if the box has image to upload
        var image = $(".block-editor-block-list__layout [aria-label='Block: Image'] img");
        var image_fa = $(".block-editor-block-list__layout [aria-label='بلوک: تصویر'] img");
        if (image.length > 0 || image_fa.length > 0) {
            if (image.length > 1 || image_fa.length > 1) {
                more_than_one_images = true;
            }
            has_image = true;
            if (image_fa.length > 0) {
                var image_url = image_fa.attr('src');
            } else if (image.length > 0) {
                var image_url = image.attr('src');
            }
            console.log(image_url);
        }

        // console.log(tinyMCE.get('novinhubTxt').getContent());
        var ajax_url = $(this).data('ajax_url');
        var caption = tinyMCE.get('novinhubTxt').getContent({format: 'text'});
        var publishLater = $("#novinhubPublishChk").prop("checked");
        var timestamp = $("#altfieldunix").val();
        var accounts = "";
        var forEachLength = $('.novinhub_li input[type=checkbox]:checked').length;
        if (forEachLength === 0) {
            $("#chooseNovinhubAccountError").css('display', 'block');
            return true;
        }
        $("#chooseNovinhubAccountError").css('display', 'none');
        if (max_count === 2200) {

            if (wp_thumbnail_id === 0) {
                $("#addNovinhubMediaError").css('display', 'block');
                return true;
            } else {
                $("#addNovinhubMediaError").css('display', 'none');
            }

        } else if (caption.length <= 1) {
            $("#addNovinhubCaptionError").css('display', 'block');
            return true;
        } else {
            $("#addNovinhubCaptionError").css('display', 'none');
        }

        $(this).css('display', 'none');

        $('.novinhub_li input[type=checkbox]:checked').each(function (index, key) {
            accounts += $(key).val();
            if (index !== (forEachLength - 1))
                accounts += ",";
        });

        //Send to ajax controller for image upload
        if (has_image) {
            $("#uploadNovinhubImageWaitingMessage").css('display', 'block');
            var data = {
                'action': 'uploadFile',
                'file_url': image_url
            };

            $.ajax({
                url: ajax_url,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        console.log(response.data.id);
                        var data = {
                            'action': 'uploadPostWithImage',
                            'media_ids': response.data.id,
                            'account_ids': accounts,
                            'caption': caption,
                            'is_scheduled': publishLater,
                            'schedule_date': timestamp
                        };
                        $("#uploadNovinhubImageWaitingMessage").css('display', 'none');
                        $("#finishingNovinhubWaiting").css('display', 'block');
                        $.ajax({
                            url: ajax_url,
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function (response) {
                                console.log(response);
                                if (response.success) {
                                    $("#finishingNovinhubWaiting").css('display', 'none');
                                    $("#novinhubFinished").css('display', 'block');
                                } else {
                                    $("#finishingNovinhubWaiting").css('display', 'none');
                                    $("#finishingNovinhubWaitingError").css('display', 'block');
                                    $("#finishingNovinhubWaitingError span").html(response.data.message);
                                }

                            },
                            error: function (error) {
                                $("#finishingNovinhubWaiting").css('display', 'none');
                                $("#finishingNovinhubWaitingError").css('display', 'block');
                                $("#finishingNovinhubWaitingError span").html(error.responseText);
                            }
                        })
                    } else {
                        $("#uploadNovinhubImageWaitingMessage").css('display', 'none');
                        $("#uploadNovinhubImageWaitingError").css('display', 'block');
                        $("#uploadNovinhubImageWaitingError span").html(response.data.message);
                    }
                },
                error: function (error) {
                    $("#uploadNovinhubImageWaitingMessage").css('display', 'none');
                    $("#uploadNovinhubImageWaitingError").css('display', 'block');
                    $("#uploadNovinhubImageWaitingError span").html(error.responseText);
                }
            });
        }
        //Send to ajax controller for video upload
        else if (has_video) {
            $("#uploadNovinhubVideoWaitingMessage").css('display', 'block');
            var data = {
                'action': 'uploadFile',
                'file_url': video_url,
            };
            $.ajax({
                url: ajax_url,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        console.log(response.data.id);
                        var data = {
                            'action': 'uploadPostWithVideo',
                            'media_ids': response.data.id,
                            'account_ids': accounts,
                            'caption': caption,
                            'is_scheduled': publishLater,
                            'schedule_date': timestamp
                        };
                        $("#uploadNovinhubVideoWaitingMessage").css('display', 'none');
                        $("#finishingNovinhubWaiting").css('display', 'block');
                        $.ajax({
                            url: ajax_url,
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function (response) {
                                console.log(response);
                                if (response.success) {
                                    $("#finishingNovinhubWaiting").css('display', 'none');
                                    $("#novinhubFinished").css('display', 'block');
                                } else {
                                    $("#finishingNovinhubWaiting").css('display', 'none');
                                    $("#finishingNovinhubWaitingError").css('display', 'block');
                                    $("#finishingNovinhubWaitingError span").html(response.data.message);
                                }

                            },
                            error: function (error) {
                                $("#finishingNovinhubWaiting").css('display', 'none');
                                $("#finishingNovinhubWaitingError").css('display', 'block');
                                $("#finishingNovinhubWaitingError span").html(error.responseText);
                            }
                        })
                    } else {
                        $("#uploadNovinhubVideoWaitingMessage").css('display', 'none');
                        $("#uploadNovinhubVideoWaitingError").css('display', 'block');
                        $("#uploadNovinhubVideoWaitingError span").html(response.data.message);
                    }
                },
                error: function (error) {
                    $("#uploadNovinhubVideoWaitingMessage").css('display', 'none');
                    $("#uploadNovinhubVideoWaitingError").css('display', 'block');
                    $("#uploadNovinhubVideoWaitingError span").html(error.responseText);
                }
            });
        }

        //Send to ajax controller for upload caption only
        if (!has_video && !has_image) {
            $("#sendNovinhubWithoutFile").css('display', 'block');
            var data = {
                'action': 'uploadPostWithoutFile',
                'account_ids': accounts,
                'caption': caption,
                'is_scheduled': publishLater,
                'schedule_date': timestamp
            };

            $.ajax({
                url: ajax_url,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        $("#sendNovinhubWithoutFile").css('display', 'none');
                        $("#novinhubFinished").css('display', 'block');
                    } else {
                        $("#sendNovinhubWithoutFile").css('display', 'none');
                        $("#finishingNovinhubWaitingError").css('display', 'block');
                        $("#finishingNovinhubWaitingError span").html(response.data.message);
                    }
                },
                error: function (error) {
                    $("#sendNovinhubWithoutFile").css('display', 'none');
                    $("#finishingNovinhubWaitingError").css('display', 'block');
                    $("#finishingNovinhubWaitingError span").html(error.responseText);
                }
            })
        }
    });
});