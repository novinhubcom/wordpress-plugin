<?php

if ( ! defined( 'ABSPATH' ) ) {
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
echo '<div class="card col-12">';
//Card header ( Start )
echo '<div class="card-header">';
echo '<h5 class="text-center">' . __( 'Send To Your Social Accounts',
		'novinhub' ) . '</h5>';
echo '</div>';
// Card Header ( End )


$accounts = get_transient( 'novinhub_accounts' );
if ( $accounts === false ) {
	try {
		$api      = new Client( esc_attr( get_option( 'novinhub_token' ) ) );
		$accounts = $api->get( 'account' );
	} catch ( \Exception $e ) {
	
	}
}
//Create accounts checkboxes
if ( ! $accounts ) {
	echo '<div id="getNovinhubAccountsError" class="alert alert-danger">';
	echo '<strong>' . __( 'Error',
			'novinhub' ) . '</strong> ' . __( 'Something went wrong, please refresh the page to get accounts again',
			'novinhub' );
	echo '</div>';
} else {
	//Card body ( Start )
	echo '<div class="card-body">';
	//Create Text area to show draft
	echo '<p class="bg-danger text-white p-2 text-center">' . __( 'Caption Draft',
			'novinhub' ) . '</p>';
	echo '<section id="novinhubTextSection">
					<textarea id="novinhubTxt"></textarea>
				</section>';
	echo '<p class="bg-danger text-white p-2 text-center">' . __( 'Choose accounts to send to',
			'novinhub' ) . '</p>';
	//List of accounts ( Start )
	echo '<div class="novinhub_li text-center" style="height: 20vh; overflow-y: scroll;">';
	foreach ( $accounts as $account ) {
		if ( $account['type'] != 'InstagramOfficial' ) {
			echo '<label class="checkbox-inline col-lg-3 col-md-4 col-sm-6 col-12 text-left m-0 p-0 pb-2"><input type="checkbox" value="' . $account['id'] .
			     '" data-type="' . $account['type'] . '">
	                            						     <img src="' . plugins_url( '../assets/images/' . strtolower( $account['type'] ) . '.png',
					__FILE__ ) . '"> ' . $account['name'] . '</label>';
		}
	}
	echo '</div>';
	//List of accounts ( End )
	
	//Date picker section ( Start )
	echo '<div class="container mt-4 border-top border-danger pt-2">';
	echo '<div class="row text-center">';
	echo '<div class="col-sm-12 publish_later">';
	echo '<input type="checkbox" id="novinhubPublishChk"/>';
	echo '<label for="novinhubPublishChk">' . __( "Publish later",
			"novinhub" ) . '</label>';
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
	$ajax_url     = admin_url( "admin-ajax.php" );
	$thumbnail_id = get_post_thumbnail_id();
	//Card footer ( Start )
	echo '<div class="card-footer">';
	//Warnings
	if ( get_locale() === 'fa_IR' ){
		echo '<div class="alert alert-warning text-right">';
	}else{
		echo '<div class="alert alert-warning">';
	}
	echo '<strong>' . __( 'Warning', 'novinhub' ) . '</strong>';
	echo '<li class="mt-2">' . __( 'If more than one image is selected, the first one will be uploaded...',
			'novinhub' ) . '</li>';
	echo '<li>' . __( 'If more than one video is selected, the first one will be uploaded...',
			'novinhub' ) . '</li>';
	echo '<li>' . __( 'If image and video are selected simultaneously, only the image will be uploaded...',
			'novinhub' ) . '</li>';
	echo '</div>';
	echo '<div class="text-center"><a class="btn btn-success text-white sendToAPI"
	 data-ajax_url="' . $ajax_url . '" data-thumbnail_id="' . $thumbnail_id . '" style="cursor: pointer;">'
	     . __( 'Send', 'novinhub' ) . '</a></div>';
	
	
	//Before Send Errors
	echo '<div id="chooseNovinhubAccountError" class="alert alert-danger text-center mt-2" style="display: none;">';
	echo '<strong>' . __( 'Error',
			'novinhub' ) . '</strong> ' . __( 'Choose at least one account to send to',
			'novinhub' );
	echo '</div>';
	echo '<div id="addNovinhubMediaError" class="alert alert-danger text-center mt-2" style="display: none;">';
	echo '<strong>' . __( 'Error',
			'novinhub' ) . '</strong> ' . __( 'Choose at least a media to upload',
			'novinhub' );
	echo '</div>';
	echo '<div id="addNovinhubCaptionError" class="alert alert-danger text-center mt-2" style="display: none;">';
	echo '<strong>' . __( 'Error',
			'novinhub' ) . '</strong> ' . __( 'Write caption',
			'novinhub' );
	echo '</div>';
	
	//Upload post in page alerts
	//with image
	echo '<div id="uploadNovinhubImageWaitingMessage" class="alert alert-success text-center" style="display: none;">';
	echo '<strong>' . __( 'Wait!',
			'novinhub' ) . '</strong> ' . __( 'Uploading Image...',
			'novinhub' );
	echo '</div>';
	echo '<div id="uploadNovinhubImageWaitingError" class="alert alert-danger text-center" style="display: none;">';
	echo '<strong>' . __( 'Error!',
			'novinhub' ) . '</strong> ' . __( 'Image upload has error:',
			'novinhub' ) . ' <span></span>';
	echo '</div>';
	
	//with video
	echo '<div id="uploadNovinhubVideoWaitingMessage" class="alert alert-success text-center" style="display: none;">';
	echo '<strong>' . __( 'Wait!',
			'novinhub' ) . '</strong> ' . __( 'Uploading Video, It may takes some seconds...',
			'novinhub' );
	echo '</div>';
	echo '<div id="uploadNovinhubVideoWaitingError" class="alert alert-danger text-center" style="display: none;">';
	echo '<strong>' . __( 'Error!',
			'novinhub' ) . '</strong> ' . __( 'Video upload has error:',
			'novinhub' ) . ' <span></span>';
	echo '</div>';
	
	//After upload file
	echo '<div id="finishingNovinhubWaiting" class="alert alert-success text-center" style="display: none;">';
	echo '<strong>' . __( 'Successful!',
			'novinhub' ) . '</strong> ' . __( 'Wait, Finishing...',
			'novinhub' );
	echo '</div>';
	echo '<div id="finishingNovinhubWaitingError" class="alert alert-danger text-center" style="display: none;">';
	echo '<strong>' . __( 'Error!',
			'novinhub' ) . '</strong> ' . __( 'Post upload has error:',
			'novinhub' ) . ' <span></span>';
	echo '</div>';
	echo '<div id="novinhubFinished" class="alert alert-success text-center" style="display: none;">';
	echo '<strong>' . __( 'Done!',
			'novinhub' ) . '</strong> ' . __( 'Your post sent to novinhub successfully.',
			'novinhub' );
	echo '</div>';
	
	//without media
	echo '<div id="sendNovinhubWithoutFile" class="alert alert-success text-center" style="display: none;">';
	echo '<strong>' . __( 'Wait!',
			'novinhub' ) . '</strong> ' . __( 'Sending post without media...',
			'novinhub' );
	echo '</div>';
	
	echo '</div>';
	//Card footer ( End )
}

echo '</div>';
//Card ( End )





