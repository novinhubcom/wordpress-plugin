<?php

if (!defined('ABSPATH')) {
    echo "Hey, you don't have permission to access this file";
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
            echo '<strong>' . __('Error',
                    'novinhub') . '</strong> ' . __('Please go to Novinhub Settings page and reset token.',
                    'novinhub');
        } else {
            echo '<div class="novinhub-alert novinhub-alert-danger" style="text-align: center;">';
            echo '<strong>' . __('Error',
                    'novinhub') . '</strong> ' . $message;
        }
    }
}

//Create accounts checkboxes
if (!$accounts) {
    echo '<div id="getNovinhubAccountsError" class="novinhub-alert novinhub-alert-danger">';
    echo '<strong>' . __('Error',
            'novinhub') . '</strong> ' . __('Something went wrong, please refresh the page to get accounts again',
            'novinhub');
    echo '</div>';
} else {
    //Card body ( Start )
    echo '<div class="novinhub-card-body">';

    echo '<p id="selectAccount">' . __('Choose accounts to send to',
            'novinhub') . '</p>';
    //List of accounts ( Start )
    echo '<div class="novinhub_li">';
    foreach ($accounts as $account) {
        if ($account['type'] != 'InstagramOfficial') {
            echo '<label class="novinhub-checkbox-inline col-lg-3 col-md-4 col-sm-6 col-12"><input type="checkbox" value="' . $account['id'] .
                '" data-type="' . $account['type'] . '">
	                            						     <img src="' . plugins_url('../assets/images/' . strtolower($account['type']) . '.png',
                    __FILE__) . '"> ' . $account['name'] . '</label>';
        }
    }
    echo '</div>';
    //List of accounts ( End )

    //Create Text area to show draft
    echo '<p id="captionDraft" style="margin-top: 30px;">' . __('Novinhub',
            'novinhub') . '</p>';
    echo '<section id="novinhubTextSection">
					<textarea id="novinhubTxt" rows="5" class="col-12 col-sm-12"></textarea>
					<p id="chars" style="margin:0;"><span>' . __('Characters', 'novinhub') . ':</span>
					<span id="numberOfChars">0</span>
					<span id="charLimit">/ ∞</span></p>
				</section>';

    echo '<div style="text-align: center; padding: 10px;"><a id="copyTextAndTags" class="novinhub-btn novinhub-btn-success"
	  style="cursor: pointer;">'
        . __('Create Caption using post text And Copy Tags from sidebar', 'novinhub') . '</a></div>';


    echo '<div id="thereIsNoTagsWarning" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . __('Warning!',
            'novinhub') . '</strong> ' . __('There is no Tags...',
            'novinhub');
    echo '</div>';

    echo '<div id="availableTags" class="novinhub-alert novinhub-alert-info" style="display: none; text-align: center;">';
    echo '<strong>' . __('Tags Are:',
            'novinhub') . '</strong> ' . '<span></span>';
    echo '</div>';

    //Date picker section ( Start )
    echo '<div id="DatePickerSection" class="novinhub-container">';
    echo '<div class="novinhub-row" style="text-align: center;">';
    echo '<div class="col-sm-12 publish_later">';
    echo '<input type="checkbox" id="novinhubPublishChk"/>';
    echo '<label for="novinhubPublishChk">' . __("Publish later",
            "novinhub") . '</label>';
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

    echo '<strong>' . __('Warning', 'novinhub') . '</strong>';
    echo '<li style="margin-top: 10px;">' . __('If more than one image has been attached, the first one will be uploaded... 
            (Featured image will not be uploaded.)',
            'novinhub') . '</li>';
    echo '<li>' . __('If more than one video has been attached, the first one will be uploaded...',
            'novinhub') . '</li>';
    echo '<li>' . __('If image and video have been attached simultaneously, only the image will be uploaded...',
            'novinhub') . '</li>';
    echo '<li>' . __('If you want to Add some Hashtags into your caption, you can insert your hashtags into "Add New Tag" section. (Be sure your hashtags added correctly to wordpress.)',
            'novinhub') . '</li>';
    echo '</div>';
    echo '<div style="text-align: center; padding: 10px;"><a class="novinhub-btn novinhub-btn-send sendToAPI"
	 data-ajax_url="' . $ajax_url . '" style="cursor: pointer;">'
        . __('Send', 'novinhub') . '</a></div>';


    //Before Send Errors
    echo '<div id="chooseNovinhubAccountError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center; margin-top: 10px;">';
    echo '<strong>' . __('Error',
            'novinhub') . '</strong> ' . __('Choose at least one account to send to',
            'novinhub');
    echo '</div>';
    echo '<div id="addNovinhubMediaError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center; margin-top: 10px;">';
    echo '<strong>' . __('Error',
            'novinhub') . '</strong> ' . __('Choose at least a media to upload',
            'novinhub');
    echo '</div>';
    echo '<div id="addNovinhubCaptionError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center; margin-top: 10px;">';
    echo '<strong>' . __('Error',
            'novinhub') . '</strong> ' . __('Write caption',
            'novinhub');
    echo '</div>';

    //Upload post in page alerts
    //with image
    echo '<div id="uploadNovinhubImageWaitingMessage" class="novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . __('Wait!',
            'novinhub') . '</strong> ' . __('Uploading Image...',
            'novinhub');
    echo '</div>';
    echo '<div id="uploadNovinhubImageWaitingError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . __('Error!',
            'novinhub') . '</strong> ' . __('Image upload has error:',
            'novinhub') . ' <span></span>';
    echo '</div>';

    //with video
    echo '<div id="uploadNovinhubVideoWaitingMessage" class="novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . __('Wait!',
            'novinhub') . '</strong> ' . __('Uploading Video, It may takes some seconds...',
            'novinhub');
    echo '</div>';
    echo '<div id="uploadNovinhubVideoWaitingError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . __('Error!',
            'novinhub') . '</strong> ' . __('Video upload has error:',
            'novinhub') . ' <span></span>';
    echo '</div>';

    //After upload file
    echo '<div id="finishingNovinhubWaiting" class="novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . __('Successful!',
            'novinhub') . '</strong> ' . __('Wait, Finishing...',
            'novinhub');
    echo '</div>';
    echo '<div id="finishingNovinhubWaitingError" class="novinhub-alert novinhub-alert-danger" style="display: none; text-align: center;">';
    echo '<strong>' . __('Error!',
            'novinhub') . '</strong> ' . __('Post upload has error:',
            'novinhub') . ' <span></span>';
    echo '</div>';
    echo '<div id="novinhubFinished" class="novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . __('Done!',
            'novinhub') . '</strong> ' . __('Your post sent to novinhub successfully.',
            'novinhub');
    echo '</div>';

    //without media
    echo '<div id="sendNovinhubWithoutFile" class="novinhub-alert novinhub-alert-success" style="display: none; text-align: center;">';
    echo '<strong>' . __('Wait!',
            'novinhub') . '</strong> ' . __('Sending post without media...',
            'novinhub');
    echo '</div>';

    echo '</div>';
    //Card footer ( End )
}
echo '</div>';
//Card ( End )





