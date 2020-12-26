/*
Scripts for post template...
Author: Novinhub
 */
jQuery(document).ready(function ($) {
    var max_count = 0;
    var hashtag = [];
    var mandatory_caption = false;

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

    function setCharLimit(content){
        var content_length = content.length;
        if (content_length === max_count){
            $("#numberOfChars").html(max_count);
        }else{
            $("#numberOfChars").html(content_length);
        }

        if (max_count === 0){
            $("#charLimit").html('/ ∞');
        }else{
            $("#charLimit").html('/ '+max_count);
        }
    }

    function copyText() {
        if ($(".block-editor-block-list__block").length > 0) {
            var title = $('textarea.editor-post-title__input').val();
            var contents = $(".block-editor-rich-text__editable");
            var content = '';
            if (title !== ''){
                content += title + '<br data-rich-text-line-break="true">';
            }
            if (contents.length > 0) {
                contents.each(function (index, key) {
                    if ($(key).attr('contenteditable') === 'true') {
                        if (!$(key).html().includes('contenteditable="false"')){
                            if (index !== 0) {
                                content += '<br data-rich-text-line-break="true">';
                            }
                            content += $(key).html();
                        }
                    }
                })
            }

            content = content.replace(/<br>\s*<br>/g, /(?:\r\n|\r)/g, '<br>');
            content = content.replace(/<br data-rich-text-line-break="true">/g, '\n');

            if (max_count !== 0) {
                content = content.substring(0, max_count);
            }

            $("#novinhubTxt").val(content);
            setCharLimit($("#novinhubTxt").val());
        }
    }

    $('#novinhubTxt').keypress(function(e){
        var caption_content = $(this).val();
        if (max_count > 0){
            if (caption_content.length === max_count) {
                e.preventDefault();
            }
        }
    })

    $('#novinhubTxt').on('keyup', function(){
        var caption_content = $(this).val();
        if (max_count === 0){
            setCharLimit(caption_content);
        }else{
            if (caption_content.length <= max_count) {
                setCharLimit(caption_content);
            }
        }
    })

    $('#copyTextAndTags').on('click', function () {
        copyText();

        hashtags = $('.components-form-token-field__token');
        if (hashtags.length > 0) {
            $('#thereIsNoTagsWarning').css('display', 'none');
            $('#availableTags').css('display', 'block');

            var tags = '';
            hashtag = [];
            hashtags.each(function () {
                hashtag.push($(this).find('span [aria-hidden = true]').text().replace(' ', '_'));
                tags += '#' + $(this).find('span [aria-hidden = true]').text().replace(' ', '_');
            })
            $('#availableTags span').html(tags);
        } else {
            $('#availableTags').css('display', 'none');
            $('#thereIsNoTagsWarning').css('display', 'block');
        }
    })

    $('.novinhub_li input[type=checkbox]').change(function () {
        var twitter = $('.novinhub_li').find("input[data-type=Twitter]:checked").length;
        var instagram = $('.novinhub_li').find("input[data-type=Instagram]:checked").length;
        var telegram = $('.novinhub_li').find("input[data-type=Telegram]:checked").length;
        var aparat = $('.novinhub_li').find("input[data-type=Aparat]:checked").length;
        var bale = $('.novinhub_li').find("input[data-type=Bale]:checked").length;
        var facebook = $('.novinhub_li').find("input[data-type=Facebook]:checked").length;
        var linkedin = $('.novinhub_li').find("input[data-type=Linkedin]:checked").length;

        if (aparat !== 0 || bale !== 0) {
            mandatory_caption = true;
        }

        if (twitter !== 0) {
            max_count = 280;
        }else if (linkedin !== 0) {
            max_count = 1300;
        }else if (facebook !== 0){
            max_count = 2000;
        } else if (twitter === 0 && instagram !== 0) {
            max_count = 2200;
        } else if (twitter === 0 && instagram === 0 && telegram !== 0) {
            max_count = 3900;
        } else {
            max_count = 0;
        }

        // // }
        var caption_content = $("#novinhubTxt").val();
        if (max_count !== 0) {
            caption_content = caption_content.substring(0, max_count);
        }

        $("#novinhubTxt").val(caption_content);
        setCharLimit($("#novinhubTxt").val());



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
        }

        var ajax_url = $(this).data('ajax_url');
        var caption = $("#novinhubTxt").val();
        var publishLater = $("#novinhubPublishChk").prop("checked");
        var timestamp = $("#altfieldunix").val();
        var accounts = "";
        var number_of_accounts = $('.novinhub_li input[type=checkbox]:checked').length;
        if (number_of_accounts === 0) {
            $("#chooseNovinhubAccountError").css('display', 'block');
            return true;
        }
        $("#chooseNovinhubAccountError").css('display', 'none');
        if (max_count === 2200) {

            if (has_image || has_video) {
                $("#addNovinhubMediaError").css('display', 'none');
            } else {
                $("#addNovinhubMediaError").css('display', 'block');
                return true;
            }
        }

        if (mandatory_caption) {
            if (caption.length <= 1) {
                $("#addNovinhubCaptionError").css('display', 'block');
            } else {
                $("#addNovinhubCaptionError").css('display', 'none');
            }
        }

        // $(this).css('display', 'none');

        $('.novinhub_li input[type=checkbox]:checked').each(function (index, key) {
            accounts += $(key).val();
            if (index !== (number_of_accounts - 1))
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
                    if (response.success) {
                        var data = {
                            'action': 'uploadPostWithImage',
                            'media_ids': response.data.id,
                            'account_ids': accounts,
                            'caption': caption,
                            'is_scheduled': publishLater,
                            'schedule_date': timestamp,
                            'hashtag': hashtag
                        };
                        $("#uploadNovinhubImageWaitingMessage").css('display', 'none');
                        $("#finishingNovinhubWaiting").css('display', 'block');
                        $.ajax({
                            url: ajax_url,
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function (response) {
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
                    if (response.success) {
                        var data = {
                            'action': 'uploadPostWithVideo',
                            'media_ids': response.data.id,
                            'account_ids': accounts,
                            'caption': caption,
                            'is_scheduled': publishLater,
                            'schedule_date': timestamp,
                            'hashtag': hashtag
                        };
                        $("#uploadNovinhubVideoWaitingMessage").css('display', 'none');
                        $("#finishingNovinhubWaiting").css('display', 'block');
                        $.ajax({
                            url: ajax_url,
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function (response) {
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
                'schedule_date': timestamp,
                'hashtag': hashtag
            };

            $.ajax({
                url: ajax_url,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function (response) {
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