/*
Scripts for post template...
Author: Novinhub
 */
jQuery(document).ready(function ($) {
    var max_count = 0;
    var hashtag = [];
    var mandatory_caption = false;
    var has_video = false;
    var video_url;
    var has_image = false;
    var image_url;

    //Show Warnings based on page type
    //Show warnings for Woocommerce product page
    if ($('.woocommerce-page').length > 0) {
        $("#forRegularPostPage").css('display', 'none');
        $("#forWoocommerceProductPage").css('display', 'block');
    } else {
        //Show warnings for regular post page
        $("#forWoocommerceProductPage").css('display', 'none');
        $("#forRegularPostPage").css('display', 'block');
    }
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

    function setCharLimit(content) {
        var content_length = content.length;
        if (content_length === max_count) {
            $("#numberOfChars").html(max_count);
        } else {
            $("#numberOfChars").html(content_length);
        }

        if (max_count === 0) {
            $("#charLimit").html('/ ∞');
        } else {
            $("#charLimit").html('/ ' + max_count);
        }
    }

    function copyText() {
        //Check if Gutenberg ( default ) editor being used
        if ($(".block-editor-block-list__block").length > 0) {
            var title = $('textarea.editor-post-title__input').val();
            var contents = $(".block-editor-rich-text__editable");
            var content = '';
            if (title !== '') {
                content += title + '<br data-rich-text-line-break="true">';
            }
            if (contents.length > 0) {
                contents.each(function (index, key) {
                    if ($(key).attr('contenteditable') === 'true') {
                        if (!$(key).html().includes('contenteditable="false"')) {
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
        } else {
            //If Classic editor may being used
            var title = $('#title').val();
            var contents = tinymce.activeEditor.getContent({format: 'text'});

            var content = '';
            if (title != '') {
                content += title + '\n';
            }
            content += contents;
            if (max_count !== 0) {
                content = content.substring(0, max_count);
            }

            $("#novinhubTxt").val(content);
            setCharLimit($("#novinhubTxt").val());
        }


        //IF USER IS IN WOOCOMMERCE PRODUCT PAGE
        if ($('.woocommerce-page').length > 0) {
            var product_title = $('#title').val();
            var product_des = tinyMCE.get('excerpt').getContent({format: 'text'});
            var product_price = $('#_sale_price').val();
            var content = '';
            if (product_title != '') {
                content += product_title + '\n';
            }
            content += product_des;
            if (product_price != '') {
                if ($('html').attr('lang') === 'fa-IR') {
                    content += '\n' + 'قیمت: ' + product_price + ' ریال';
                } else
                    content += '\n' + 'Price: ' + product_price + ' $';
            }

            if (max_count !== 0) {
                content = content.substring(0, max_count);
            }

            $("#novinhubTxt").val(content);
            setCharLimit($("#novinhubTxt").val());
        }
    }

    $('#novinhubTxt').keypress(function (e) {
        var caption_content = $(this).val();
        if (max_count > 0) {
            if (caption_content.length === max_count) {
                e.preventDefault();
            }
        }
    })

    $('#novinhubTxt').on('keyup', function () {
        var caption_content = $(this).val();
        if (max_count === 0) {
            setCharLimit(caption_content);
        } else {
            if (caption_content.length <= max_count) {
                setCharLimit(caption_content);
            }
        }
    })

    $('#copyTextAndTags').on('click', function () {
        copyText();

        //Show Media for user control
        //Get thumbnail from wooCommerce product page
        if ($('.woocommerce-page').length > 0) {
            if ($('#set-post-thumbnail img').length > 0) {
                image_url = $('#set-post-thumbnail img').attr('src');
                has_image = true;
                $('#thereIsNoImageWarning').css('display', 'none');
                $('#availableImage').css('display', 'block');
                $('#availableImage a').attr('href', image_url);
            } else {
                has_image = true;
                $('#availableImage').css('display', 'none');
                $('#thereIsNoImageWarning').css('display', 'block');
            }
        } else {
            //Check if featured image has been added in post page
            if ($('.editor-post-featured-image__container img').length > 0) {
                image_url = $('.editor-post-featured-image__container img').attr('src');
                has_image = true;
                $('#thereIsNoMediaWarning').css('display', 'none');
                $('#availableVideo').css('display', 'none');
                $('#availableImage').css('display', 'block');
                $('#availableImage a').attr('href', image_url);
            } else {
                has_image = false;
                //Check if the box has image to upload
                var image = $(".block-editor-block-list__layout [aria-label='Block: Image'] img");
                var image_fa = $(".block-editor-block-list__layout [aria-label='بلوک: تصویر'] img");
                if (image.length > 0 || image_fa.length > 0) {
                    has_image = true;
                    if (image_fa.length > 0) {
                        image_url = image_fa.attr('src');
                    } else if (image.length > 0) {
                        image_url = image.attr('src');
                    }
                    $('#thereIsNoMediaWarning').css('display', 'none');
                    $('#availableVideo').css('display', 'none');
                    $('#availableImage').css('display', 'block');
                    $('#availableImage a').attr('href', image_url);
                } else {
                    $('#availableImage').css('display', 'none');
                    $('#thereIsNoMediaWarning').css('display', 'block');

                    //Check if featured image has been added in classic editor
                    if ($(".attachment-post-thumbnail").length > 0) {
                        image_url = $('.attachment-post-thumbnail').attr('src');
                        has_image = true;
                        $('#thereIsNoMediaWarning').css('display', 'none');
                        $('#availableVideo').css('display', 'none');
                        $('#availableImage').css('display', 'block');
                        $('#availableImage a').attr('href', image_url);
                    }else{
                        has_image = false;
                        $('#availableImage').css('display', 'none');
                        $('#thereIsNoMediaWarning').css('display', 'block');
                    }
                }
            }
            //Check if the box has video to upload in post page
            if (!has_image) {
                var video = $(".block-editor-block-list__layout [aria-label='Block: Video'] video");
                var video_fa = $(".block-editor-block-list__layout [aria-label='بلوک: ویدئو'] video");
                if (video.length > 0 || video_fa.length > 0) {
                    has_video = true;
                    if (video_fa.length > 0) {
                        video_url = video_fa.attr('src');
                    } else if (video.length > 0) {
                        video_url = video.attr('src');
                    }
                    $('#thereIsNoMediaWarning').css('display', 'none');
                    $('#availableVideo').css('display', 'block');
                    $('#availableVideo a').attr('href', video_url);
                } else {
                    has_video = false;
                    $('#availableVideo').css('display', 'none');
                    $('#thereIsNoMediaWarning').css('display', 'block');
                }
            }
        }

        //Check if maybe Classic editor being used
        if (!has_image && !has_video){
            if (tinymce.activeEditor != null){
                //Check for image
                if (tinymce.activeEditor.$("img").length > 0){
                    has_image = true;
                    image_url = tinymce.activeEditor.$("img").attr('src');
                    $('#thereIsNoMediaWarning').css('display', 'none');
                    $('#availableVideo').css('display', 'none');
                    $('#availableImage').css('display', 'block');
                    $('#availableImage a').attr('href', image_url);
                }else{
                    has_image = false;
                    $('#availableImage').css('display', 'none');
                    $('#thereIsNoMediaWarning').css('display', 'block');
                }
                //Check for video
                if (!has_image){
                    var video_url_container = tinymce.activeEditor.getContent();
                    video_url_container = video_url_container.match(/\bmp4="(.+)\b/);
                    if (video_url_container != null){
                        var video_url = video_url_container[1].substring(0, video_url_container[1].length-13);
                        has_video = true;
                        $('#thereIsNoMediaWarning').css('display', 'none');
                        $('#availableVideo').css('display', 'block');
                        $('#availableVideo a').attr('href', video_url);
                    }else{
                        has_video = false;
                        $('#availableVideo').css('display', 'none');
                        $('#thereIsNoMediaWarning').css('display', 'block');
                    }
                }
            }
        }

        //Show hashtags for user control
        var hashtags = $('.components-form-token-field__token');
        if (hashtags.length > 0) {
            $('#thereIsNoTagsWarning').css('display', 'none');
            $('#availableTags').css('display', 'block');

            var tags = '';
            hashtag = [];
            hashtags.each(function () {
                hashtag.push($(this).find('span [aria-hidden = true]').text().replace(' ', '_'));
                tags += '#' + $(this).find('span [aria-hidden = true]').text().replace(' ', '_');
            })
            $('#thereIsNoTagsWarning').css('display', 'none');
            $('#availableTags').css('display', 'block');
            $('#availableTags span').html(tags);
        } else {
            $('#availableTags').css('display', 'none');
            $('#thereIsNoTagsWarning').css('display', 'block');

            //FOR WOOCOMMERCE PRODUCT PAGE AND FOR CLASSIC EDITOR...
            if ($('.tagchecklist li').length > 0) {
                var tags = '';
                hashtag = [];
                $('.tagchecklist li').each(function () {
                    hashtag.push($(this)[0].lastChild.textContent.replace(' ', '_'));
                    tags += '#' + $(this)[0].lastChild.textContent.replace(' ', '_');
                })
                if (tags != '') {
                    $('#thereIsNoTagsWarning').css('display', 'none');
                    $('#availableTags').css('display', 'block');
                    $('#availableTags span').html(tags);
                } else {
                    $('#availableTags').css('display', 'none');
                    $('#thereIsNoTagsWarning').css('display', 'block');
                }
            } else {
                $('#availableTags').css('display', 'none');
                $('#thereIsNoTagsWarning').css('display', 'block');
            }
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
        } else if (linkedin !== 0) {
            max_count = 1300;
        } else if (facebook !== 0) {
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


        var ajax_url = $(this).data('ajax_url');
        var caption = $("#novinhubTxt").val();
        var publishLater = $("#novinhubPublishChk").prop("checked");
        var timestamp = $("#altfieldunix").val();
        var accounts = "";
        var number_of_accounts = $('.novinhub_li input[type=checkbox]:checked').length;
        if (number_of_accounts === 0) {
            $(".after-send-alert").css('display', 'none');
            $("#chooseNovinhubAccountError").css('display', 'block');
            return true;
        }
        $("#chooseNovinhubAccountError").css('display', 'none');
        if (max_count === 2200) {

            if (has_image || has_video) {
                $(".after-send-alert").css('display', 'none');
                $("#addNovinhubMediaError").css('display', 'none');
            } else {
                $("#addNovinhubMediaError").css('display', 'block');
                return true;
            }
        }

        if (mandatory_caption) {
            if (caption.length <= 1) {
                $(".after-send-alert").css('display', 'none');
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
            $(".after-send-alert").css('display', 'none');
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
                        $(".after-send-alert").css('display', 'none');
                        $("#finishingNovinhubWaiting").css('display', 'block');
                        $.ajax({
                            url: ajax_url,
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    $(".after-send-alert").css('display', 'none');
                                    $("#novinhubFinished").css('display', 'block');
                                    $("#novinhubFinishedThankYou").css('display', 'block');
                                } else {
                                    $(".after-send-alert").css('display', 'none');
                                    $("#finishingNovinhubWaitingError").css('display', 'block');
                                    $("#finishingNovinhubWaitingError span").html(response.data.message);
                                }

                            },
                            error: function (error) {
                                $(".after-send-alert").css('display', 'none');
                                $("#finishingNovinhubWaitingError").css('display', 'block');
                                $("#finishingNovinhubWaitingError span").html(error.responseText);
                            }
                        })
                    } else {
                        $(".after-send-alert").css('display', 'none');
                        $("#uploadNovinhubImageWaitingError").css('display', 'block');
                        $("#uploadNovinhubImageWaitingError span").html(response.data.message);
                    }
                },
                error: function (error) {
                    $(".after-send-alert").css('display', 'none');
                    $("#uploadNovinhubImageWaitingError").css('display', 'block');
                    $("#uploadNovinhubImageWaitingError span").html(error.responseText);
                }
            });
        }
        //Send to ajax controller for video upload
        else if (has_video) {
            $(".after-send-alert").css('display', 'none');
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
                        $(".after-send-alert").css('display', 'none');
                        $("#finishingNovinhubWaiting").css('display', 'block');
                        $.ajax({
                            url: ajax_url,
                            type: 'post',
                            data: data,
                            dataType: 'json',
                            success: function (response) {
                                if (response.success) {
                                    $(".after-send-alert").css('display', 'none');
                                    $("#novinhubFinished").css('display', 'block');
                                    $("#novinhubFinishedThankYou").css('display', 'block');
                                } else {
                                    $(".after-send-alert").css('display', 'none');
                                    $("#finishingNovinhubWaitingError").css('display', 'block');
                                    $("#finishingNovinhubWaitingError span").html(response.data.message);
                                }

                            },
                            error: function (error) {
                                $(".after-send-alert").css('display', 'none');
                                $("#finishingNovinhubWaitingError").css('display', 'block');
                                $("#finishingNovinhubWaitingError span").html(error.responseText);
                            }
                        })
                    } else {
                        $(".after-send-alert").css('display', 'none');
                        $("#uploadNovinhubVideoWaitingError").css('display', 'block');
                        $("#uploadNovinhubVideoWaitingError span").html(response.data.message);
                    }
                },
                error: function (error) {
                    $(".after-send-alert").css('display', 'none');
                    $("#uploadNovinhubVideoWaitingError").css('display', 'block');
                    $("#uploadNovinhubVideoWaitingError span").html(error.responseText);
                }
            });
        }

        //Send to ajax controller for upload caption only
        if (!has_video && !has_image) {
            $(".after-send-alert").css('display', 'none');
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
                        $(".after-send-alert").css('display', 'none');
                        $("#novinhubFinished").css('display', 'block');
                        $("#novinhubFinishedThankYou").css('display', 'block');
                    } else {
                        $(".after-send-alert").css('display', 'none');
                        $("#finishingNovinhubWaitingError").css('display', 'block');
                        $("#finishingNovinhubWaitingError span").html(response.data.message);
                    }
                },
                error: function (error) {
                    $(".after-send-alert").css('display', 'none');
                    $("#finishingNovinhubWaitingError").css('display', 'block');
                    $("#finishingNovinhubWaitingError span").html(error.responseText);
                }
            })
        }
    });
});