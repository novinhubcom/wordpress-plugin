<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

use Novinhub\Client;

class NovinhubWPAjax
{

    private $apiClient;

    /**
     * Ajax constructor. instantiate Client
     */
    function __construct()
    {
        $this->apiClient = new Client(esc_attr(get_option('novinhub_token')));
    }

    /**
     * Add hooks for upload_file and upload_post ajax controllers
     */
    public function novinhubWPRegister()
    {
        //Ajax controller for upload_file
        add_action('wp_ajax_uploadFile', [$this, 'novinhubWPUploadFile']);
        add_action('wp_ajax_nopriv_uploadFile',
            [$this, 'novinhubWPUploadFile']);

        //Ajax controller for upload_post_with_image
        add_action('wp_ajax_uploadPostWithImage',
            [$this, 'novinhubWPUploadPostWithImage']);
        add_action('wp_ajax_nopriv_uploadPostWithImage',
            [$this, 'novinhubWPUploadPostWithImage']);

        //Ajax controller for novinhubWPUploadPostWithVideo
        add_action('wp_ajax_uploadPostWithVideo',
            [$this, 'novinhubWPUploadPostWithVideo']);
        add_action('wp_ajax_nopriv_uploadPostWithVideo',
            [$this, 'novinhubWPUploadPostWithVideo']);

        //Ajax controller for novinhubWPUploadPostWithoutFile
        add_action('wp_ajax_uploadPostWithoutFile',
            [$this, 'novinhubWPUploadPostWithoutFile']);
        add_action('wp_ajax_nopriv_uploadPostWithoutFile',
            [$this, 'novinhubWPUploadPostWithoutFile']);
    }

    function novinhubWPGetAttachmentIdFromUrl($attachment_url = '')
    {

        global $wpdb;
        $attachment_id = false;

        // If there is no url, return.
        if ('' == $attachment_url) {
            return;
        }

        // Get the upload directory paths
        $upload_dir_paths = wp_upload_dir();

        // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
        if (false !== strpos($attachment_url,
                $upload_dir_paths['baseurl'])) {

            // If this is the URL of an auto-generated thumbnail, get the URL of the original image
            $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif|mp4)$)/i',
                '', $attachment_url);

            global $wpdb;

            $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$attachment_url'";
            $attachment_id = $wpdb->get_var($query);

//			$file_path = $upload_dir_paths['basedir'] . '/' . wp_get_attachment_metadata( $attachment_id )['file'];
            $file_path = get_attached_file($attachment_id);
        }

        return $file_path;
    }

    /**
     * Receive upload_file ajax requests from post template and
     *upload that file into Novinhub Servers
     */
    public function novinhubWPUploadFile()
    {
        $file_url = $_POST['file_url'];
        $file_url = esc_url_raw($file_url);
        $file_path = $this->novinhubWPGetAttachmentIdFromUrl($file_url);
        try {
            $response = $this->apiClient->post('file',
                ['file' => $this->apiClient->getFile($file_path)]);

            wp_send_json_success(['id' => $response['id']]);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }

    }

    /**
     * Receive upload_post_with_image ajax request from post template and
     * upload that post into Novinhub Servers
     */
    public function novinhubWPUploadPostWithImage()
    {
        if ( isset( $_POST['account_ids'] ) ){
            $account_ids = $_POST['account_ids'];
        }else{
            $account_ids = '';
        }
        if ( isset( $_POST['caption'] ) ){
            $caption = sanitize_textarea_field($_POST['caption']);
        }else{
            $caption = '';
        }
        if ( isset( $_POST['is_scheduled'] ) ){
            $is_scheduled = $_POST['is_scheduled'];
        }else{
            $is_scheduled = '';
        }
        if ( isset( $_POST['schedule_date'] ) ){
            $schedule_date = $_POST['schedule_date'];
        }else{
            $schedule_date = '';
        }
        if ( isset( $_POST['media_ids'] ) ){
            $media_ids = $_POST['media_ids'];
        }else{
            $media_ids = '';
        }
        if ( isset( $_POST['hashtag'] ) ){
            $hashtags_before = $_POST['hashtag'];
            $hashtags = array();
            foreach ( $hashtags_before as $hashtag ){
                array_push( $hashtags, sanitize_text_field($hashtag) );
            }
        }else{
            $hashtags = '';
        }

        try {
            $response = $this->apiClient->post('post', [
                'type' => 'image',
                'account_ids' => $account_ids,
                'caption' => $caption,
                'is_scheduled' => $is_scheduled,
                'schedule_date' => $schedule_date,
                'media_ids' => $media_ids,
                'hashtag' => $hashtags
            ]);

            wp_send_json_success(['response' => $response]);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }

        die;
    }

    /**
     * Receive novinhubWPUploadPostWithVideo ajax request from post template and
     * upload that post into Novinhub Servers
     */
    public function novinhubWPUploadPostWithVideo()
    {
        if ( isset( $_POST['account_ids'] ) ){
            $account_ids = $_POST['account_ids'];
        }else{
            $account_ids = '';
        }
        if ( isset( $_POST['caption'] ) ){
            $caption = sanitize_textarea_field($_POST['caption']);
        }else{
            $caption = '';
        }
        if ( isset( $_POST['is_scheduled'] ) ){
            $is_scheduled = $_POST['is_scheduled'];
        }else{
            $is_scheduled = '';
        }
        if ( isset( $_POST['schedule_date'] ) ){
            $schedule_date = $_POST['schedule_date'];
        }else{
            $schedule_date = '';
        }
        if ( isset( $_POST['media_ids'] ) ){
            $media_ids = $_POST['media_ids'];
        }else{
            $media_ids = '';
        }
        if ( isset( $_POST['hashtag'] ) ){
            $hashtags_before = $_POST['hashtag'];
            $hashtags = array();
            foreach ( $hashtags_before as $hashtag ){
                array_push( $hashtags, sanitize_text_field($hashtag) );
            }
        }else{
            $hashtags = '';
        }

        try {
            $response = $this->apiClient->post('post', [
                'type' => 'video',
                'account_ids' => $account_ids,
                'caption' => $caption,
                'is_scheduled' => $is_scheduled,
                'schedule_date' => $schedule_date,
                'media_ids' => $media_ids,
                'hashtag' => $hashtags
            ]);

            wp_send_json_success(['response' => $response]);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }

        die;
    }

    /**
     * Receive upload_post_without_media ajax request from post template and
     * upload that post into Novinhub Servers
     */
    public function novinhubWPUploadPostWithoutFile()
    {
        if ( isset( $_POST['account_ids'] ) ){
            $account_ids = $_POST['account_ids'];
        }else{
            $account_ids = '';
        }
        if ( isset( $_POST['caption'] ) ){
            $caption = sanitize_textarea_field($_POST['caption']);
        }else{
            $caption = '';
        }
        if ( isset( $_POST['is_scheduled'] ) ){
            $is_scheduled = $_POST['is_scheduled'];
        }else{
            $is_scheduled = '';
        }
        if ( isset( $_POST['schedule_date'] ) ){
            $schedule_date = $_POST['schedule_date'];
        }else{
            $schedule_date = '';
        }
        if ( isset( $_POST['hashtag'] ) ){
            $hashtags_before = $_POST['hashtag'];
            $hashtags = array();
            foreach ( $hashtags_before as $hashtag ){
                array_push( $hashtags, sanitize_text_field($hashtag) );
            }
        }else{
            $hashtags = '';
        }

        try {
            $response = $this->apiClient->post('post', [
                'type' => 'text',
                'account_ids' => $account_ids,
                'caption' => $caption,
                'is_scheduled' => $is_scheduled,
                'schedule_date' => $schedule_date,
                'hashtag' => $hashtags
            ]);

            wp_send_json_success(['response' => $response]);
        } catch (\Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }

        die;
    }


}