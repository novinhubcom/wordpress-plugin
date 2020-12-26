<?php
/**
 * @package Novinhub
 */

namespace Novinhub\Inc\Base;

use Novinhub\Client;

class Ajax
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
    public function register()
    {
        //Ajax controller for upload_file
        add_action('wp_ajax_uploadFile', [$this, 'upload_file']);
        add_action('wp_ajax_nopriv_uploadFile',
            [$this, 'upload_file']);

        //Ajax controller for upload_post_with_image
        add_action('wp_ajax_uploadPostWithImage',
            [$this, 'upload_post_with_image']);
        add_action('wp_ajax_nopriv_uploadPostWithImage',
            [$this, 'upload_post_with_image']);

        //Ajax controller for upload_post_with_video
        add_action('wp_ajax_uploadPostWithVideo',
            [$this, 'upload_post_with_video']);
        add_action('wp_ajax_nopriv_uploadPostWithVideo',
            [$this, 'upload_post_with_video']);

        //Ajax controller for upload_post_without_file
        add_action('wp_ajax_uploadPostWithoutFile',
            [$this, 'upload_post_without_file']);
        add_action('wp_ajax_nopriv_uploadPostWithoutFile',
            [$this, 'upload_post_without_file']);
    }

    function get_attachment_id_from_url($attachment_url = '')
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
    public function upload_file()
    {
        $file_url = $_POST['file_url'];
        $file_path = $this->get_attachment_id_from_url($file_url);

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
    public function upload_post_with_image()
    {
        $account_ids = $_POST['account_ids'];
        $caption = $_POST['caption'];
        $is_scheduled = $_POST['is_scheduled'];
        $schedule_date = $_POST['schedule_date'];
        $media_ids = $_POST['media_ids'];
        $hashtags = $_POST['hashtag'];
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
     * Receive upload_post_with_video ajax request from post template and
     * upload that post into Novinhub Servers
     */
    public function upload_post_with_video()
    {
        $account_ids = $_POST['account_ids'];
        $caption = $_POST['caption'];
        $is_scheduled = $_POST['is_scheduled'];
        $schedule_date = $_POST['schedule_date'];
        $media_ids = $_POST['media_ids'];
        $hashtags = $_POST['hashtag'];

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
    public function upload_post_without_file()
    {
        $account_ids = $_POST['account_ids'];
        $caption = $_POST['caption'];
        $is_scheduled = $_POST['is_scheduled'];
        $schedule_date = $_POST['schedule_date'];
        $hashtags = $_POST['hashtag'];

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