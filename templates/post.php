<?php

if (!defined('ABSPATH')) {
    echo esc_html(__("Hey, you don't have permission to access this file", 'novinhub'));
    exit;
}

use Novinhub\Client;


//function add_header_CDN() {
//	echo '<link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.1.5/dist/css/persian-datepicker.min.css"/>';
//}
//
//add_action( 'admin_head', 'add_header_CDN' );

//Card ( Start )
echo '<div class="novinhub-card col-12 col-sm-12">';
//Card header ( Start )

// Card Header ( End )


$accounts = get_transient('novinhub_accounts');
if ($accounts === false) {
    try {
        $api = new Client(esc_attr(get_option('novinhub_token')));
        $accounts = $api->get('account');
    } catch (\Exception $e) {
        $message = $e->getMessage();
        if ($message === 'توکن نامعتبر است') {
            delete_option('novinhub_token');
            echo '<div class="novinhub-alert novinhub-alert-danger" style="text-align: center">';
            echo '<strong>' . esc_html(__('Error',
                    'novinhub')) . '</strong> ' . esc_html(__('Please go to Novinhub Settings page and reset token.',
                    'novinhub'));
        } else {
            echo '<div class="novinhub-alert novinhub-alert-danger" style="text-align: center;">';
            echo '<strong>' . esc_html(__('Error',
                    'novinhub')) . '</strong> ' . $message;
        }
    }
}

//Create accounts checkboxes
if (!$accounts) {
    echo '<div id="getNovinhubAccountsError" class="novinhub-alert novinhub-alert-danger">';
    echo '<strong>' . esc_html(__('Error',
            'novinhub')) . '</strong> ' . esc_html(__('Something went wrong, please refresh the page to get accounts again',
            'novinhub'));
    echo '</div>';
} else {
    //Card body ( Start )
    echo '<div class="novinhub-card-body">';

    echo '<p id="selectAccount">' . esc_html(__('Choose accounts to send to',
            'novinhub')) . '</p>';
    //List of accounts ( Start )
    echo '<div class="novinhub_li">';
    foreach ($accounts as $account) {
            echo '<label class="novinhub-checkbox-inline col-lg-3 col-md-4 col-sm-6 col-12"><input type="checkbox" value="' . $account['id'] .
                '" data-type="' . $account['type'] . '">
	                            						     <img src="' . esc_url(plugins_url('../assets/images/' . strtolower($account['type']) . '.png',
                    __FILE__)) . '"> ' . $account['name'] . '</label>';
    }
    echo '</div>';
    //List of accounts ( End )

    //Create Text area to show draft
    echo '<p id="captionDraft" style="margin-top: 30px;">' . esc_html(__('Novinhub',
            'novinhub')) . '</p>';
    echo '<section id="novinhubTextSection">
					<textarea id="novinhubTxt" rows="5" class="col-12 col-sm-12"></textarea>
					<p id="chars" style="margin:0;"><span>' . esc_html(__('Characters', 'novinhub')) . ':</span>
					<span id="numberOfChars">0</span>
					<span id="charLimit">/ ∞</span></p>
				</section>';

    echo '<div style="text-align: center; padding: 10px;"><a id="copyTextAndTags" class="novinhub-btn novinhub-btn-success"
	  style="cursor: pointer;">'
        . esc_html(__('Create Caption using post text, get Media and copy Tags from sidebar', 'novinhub')) . '</a></div>';

    echo '<div id="thereIsNoMediaWarning" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Warning!',
            'novinhub')) . '</strong> ' . esc_html(__('There is no Media...',
            'novinhub'));
    echo '</div>';

    //For wooCommerce product page
    echo '<div id="thereIsNoImageWarning" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Warning!',
            'novinhub')) . '</strong> ' . esc_html(__('There is no Image...',
            'novinhub'));
    echo '</div>';

    echo '<div id="availableImage" class="novinhub-alert novinhub-alert-info" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Image:',
            'novinhub')) . '</strong> ' . '<span><a href="" target="_blank" style="text-decoration: none;">' . esc_html(__('Click to check',
            'novinhub')) . '</a></span>';
    echo '</div>';

    echo '<div id="availableVideo" class="novinhub-alert novinhub-alert-info" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Video:',
            'novinhub')) . '</strong> ' . '<span><a href="" target="_blank" style="text-decoration: none;">' . esc_html(__('Click to check',
            'novinhub')) . '</a></span>';
    echo '</div>';

    echo '<div id="thereIsNoTagsWarning" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Warning!',
            'novinhub')) . '</strong> ' . esc_html(__('There is no Tags...',
            'novinhub'));
    echo '</div>';

    echo '<div id="availableTags" class="novinhub-alert novinhub-alert-info" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Tags Are:',
            'novinhub')) . '</strong> ' . '<span></span>';
    echo '</div>';

    //Date picker section ( Start )
    echo '<div id="DatePickerSection" class="novinhub-container">';
    echo '<div class="novinhub-row" style="text-align: center;">';
    echo '<div class="col-sm-12 publish_later">';
    echo '<input type="checkbox" id="novinhubPublishChk"/>';
    echo '<label for="novinhubPublishChk">' . esc_html(__("Publish later",
            "novinhub")) . '</label>';
    echo '<div id="novinhubPublishSection" style="display:none;">';
    echo '<input type="text" width="100" id="novinhubDatepicker"/>';
    echo '<input type="text" id="altfieldunix" style="display: none;"/>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    //Date picker section ( End )

    echo '</div>';
    //Card body ( End )
    $ajax_url = admin_url("admin-ajax.php");
    $thumbnail_id = get_post_thumbnail_id();
    //Card footer ( Start )
    echo '<div class="novinhub-card-footer">';
    //Warnings
    echo '<div class="novinhub-alert novinhub-alert-warning">';

    echo '<strong>' . esc_html(__('Warning', 'novinhub')) . '</strong>';
    //Warnings For Regular Post Page
    echo '<div id="forRegularPostPage">';
    echo '<li style="margin-top: 10px;">' . esc_html(__('If more than one image has been attached, the first one will be uploaded... 
            (Highest Priority: Featured Image)',
            'novinhub')) . '</li>';
    echo '<li>' . esc_html(__('If more than one video has been attached, the first one will be uploaded...',
            'novinhub')) . '</li>';
    echo '<li>' . esc_html(__('If image and video have been attached simultaneously, only the image will be uploaded...',
            'novinhub')) . '</li>';
    echo '<li>' . esc_html(__('If you want to Add some Hashtags into your caption, you can insert your hashtags into Tags section. (Be sure your hashtags added correctly to wordpress.)',
            'novinhub')) . '</li>';
    echo '</div>';
    //Warnings For Woocommerce Product Page
    echo '<div id="forWoocommerceProductPage">';
    echo '<li style="margin-top: 10px;">' . esc_html(__('If you want to add description about your product, you can use "Product short description" section...',
            'novinhub')) . '</li>';
    echo '<li>' . esc_html(__('If you want to add image for your product, you can use "Product image" section in right menu...',
            'novinhub')) . '</li>';
    echo '<li>' . esc_html(__('If you want to add some hashtags for your product, you can use "Product tags" section in right menu...',
            'novinhub')) . '</li>';
    echo '<li>' . esc_html(__('If you want to add price for your product, you can use "Sale price" section...',
            'novinhub')) . '</li>';
    echo '</div>';
    echo '</div>';
    echo '<div style="text-align: center; padding: 10px;"><a class="novinhub-btn novinhub-btn-send sendToAPI"
	 data-ajax_url="' . $ajax_url . '" style="cursor: pointer;">'
        . esc_html(__('Send', 'novinhub')) . '</a></div>';


    //Before Send Errors
    echo '<div id="chooseNovinhubAccountError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center; margin-top: 10px;">';
    echo '<strong>' . esc_html(__('Error',
            'novinhub')) . '</strong> ' . esc_html(__('Choose at least one account to send to',
            'novinhub'));
    echo '</div>';
    echo '<div id="addNovinhubMediaError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center; margin-top: 10px;">';
    echo '<strong>' . esc_html(__('Error',
            'novinhub')) . '</strong> ' . esc_html(__('Choose at least a media to upload',
            'novinhub'));
    echo '</div>';
    echo '<div id="addNovinhubCaptionError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center; margin-top: 10px;">';
    echo '<strong>' . esc_html(__('Error',
            'novinhub')) . '</strong> ' . esc_html(__('Write caption',
            'novinhub'));
    echo '</div>';

    //Upload post in page alerts
    //with image
    echo '<div id="uploadNovinhubImageWaitingMessage" class="after-send-alert novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Wait!',
            'novinhub')) . '</strong> ' . esc_html(__('Uploading Image...',
            'novinhub'));
    echo '</div>';
    echo '<div id="uploadNovinhubImageWaitingError" class="after-send-alert novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Error!',
            'novinhub')) . '</strong> ' . esc_html(__('Image upload has error:',
            'novinhub')) . ' <span></span>';
    echo '</div>';

    //with video
    echo '<div id="uploadNovinhubVideoWaitingMessage" class="after-send-alert novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Wait!',
            'novinhub')) . '</strong> ' . esc_html(__('Uploading Video, It may takes some seconds...',
            'novinhub'));
    echo '</div>';
    echo '<div id="uploadNovinhubVideoWaitingError" class="after-send-alert novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Error!',
            'novinhub')) . '</strong> ' . esc_html(__('Video upload has error:',
            'novinhub')) . ' <span></span>';
    echo '</div>';

    //After upload file
    echo '<div id="finishingNovinhubWaiting" class="after-send-alert novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Successful!',
            'novinhub')) . '</strong> ' . esc_html(__('Wait, Finishing...',
            'novinhub'));
    echo '</div>';
    echo '<div id="finishingNovinhubWaitingError" class="after-send-alert novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Error!',
            'novinhub')) . '</strong> ' . esc_html(__('Post upload has error:',
            'novinhub')) . ' <span></span>';
    echo '</div>';
    echo '<div id="novinhubFinished" class="after-send-alert novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Done!',
            'novinhub')) . '</strong> ' . esc_html(__('Your post sent to novinhub successfully.',
            'novinhub')) . '<br>' . esc_html(__('"Sometimes publishing your post may be delayed, please be patient."', 'novinhub'))
            . '<br>' . esc_html(__('"In case of problems, please contact Novinhub support."', 'novinhub'));
    echo '</div>';
    echo '<div id="novinhubFinishedThankYou" class="after-send-alert novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo  '<strong> ' . esc_html(__('Thank you for choosing Novinhub',
            'novinhub')) . '</strong>';
    echo '</div>';
    echo '</div>';


    //without media
    echo '<div id="sendNovinhubWithoutFile" class="after-send-alert novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . esc_html(__('Wait!',
            'novinhub')) . '</strong> ' . esc_html(__('Sending post without media...',
            'novinhub'));
    echo '</div>';

    echo '</div>';
    //Card footer ( End )
}
echo '</div>';
//Card ( End )





