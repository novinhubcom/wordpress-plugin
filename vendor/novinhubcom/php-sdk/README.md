# Novinhub
Novinhub php sdk

## Requirements

PHP 5.6 and later

## Installation and Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), run following command:

```
composer require novinhubcom/php-sdk
```

Then run `composer install`

## Getting Started

After Installation The API can be used as easy as the following

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

//Initialize Novinhub Client Instance...
$api = new Novinhub\Client('your_token_here');

/*
 * Instance Usage:
 * $api->Method('Path', Parameters(IF EXISTS));
 */
//Example1: Get all accounts assigned to your token
$accounts = $api->get('account');

/*
 * Example2: Create Caption...
 * 
 * If Successful, The $response will contain an Array including 
 * the new caption Id, Title, Caption and Date of creation.
 * If not, there is an error message in $response.
 */
$response = $api->post('caption', ['title'=> 'Caption Title', 'caption'=> 'Caption Text']);

//Example 3: Update an existing Caption you created...
$response = $api->put('caption/your_caption_id', ['title'=> 'Caption New Title', 'caption'=> 'caption New Text']);

/*
 * Example 4: Create file...
 * In order to create a file you can use 
 * Method getFile('FileAddress') of $api...
 * hint: You can use 'Absolute' or 'Relative' addressing for FileAddress
 * 
 * If Successful, The $response will contain an Array including
 * the new file Id, Title, File size, Date of creation and 
 * the URL that contains The file.
 * If not, there is an error message in $response.
 */
$response = $api->post('file', ['file'=> $api->getFile('fileAddress')]);
?>
```

## Documentation for API Endpoints

All URIs are relative to *https://panel.novinhub.com/api/v1*

Function | Method | Path | Parameters | Description
------------ | ------------- | ------------- | ------------- | -------------
*Account-list* | [**get**](#) | **account** | - | Get all accounts assigned to your token
*Account-one* | [**get**](#) | **account/{accountId}** | - | Get one account with specific ID
*Account-delete* | [**delete**](#) | **account/{accountId}** | - | Delete one account with specific ID
*Caption-list* | [**get**](#) | **caption** | - | Get all captions assigned to your token
*Caption-one* | [**get**](#) | **caption/{captionId}** | - | Get on caption with specific ID
*Caption-create* | [**post**](#) | **caption** | ['title'=> 'Caption Title', 'caption'=> Caption text'] | Create caption with Title and Text
*Caption-update* | [**put**](#) | **caption/{captionId}** | ['title'=> 'New Caption Title', 'caption'=> 'New Caption Text'] | Update caption title and text with a specific ID
*Caption-delete* | [**delete**](#) | **caption/{captionId}** | - | Delete one caption with specific ID
*File-all* | [**get**](#) | **file** | - | Get all file assigned to your token
*File-one* | [**get**](#) | **file/{fileId}** | - | Get one file with specific ID
*File-create* | [**post**](#) | **file** | ['file'=> $api->getFile('fileAddress')] | Create file
*File-delete* | [**delete**](#) | **file/{fileId}** | - | Delete on file with specific ID
*Gateway-all* | [**get**](#) | **gateway** | - | Get all gateways assigned to your token
*Me-index* | [**get**](#) | **me** | - | Get your account information
*Me-files* | [**get**](#) | **me/files** | - | Get your Files and Storage Meta Date
*Order-list* | [**get**](#) | **order** | - | Get all your orders information
*Order-one* | [**get**](#) | **order/{orderId}** | - | Get one order information with specific ID
*Package-all* | [**get**](#) | **package** | - | Get all packages information
*Package-one* | [**get**](#) | **package/{packageId}** | - | Get one package information with specific ID
*Post-all* | [**get**](#) | **post** | - | Get all post information you created
*Post-one* | [**get**](#) | **post/{postId}** | - | Get post information you create with specific ID
*Post-create* | [**post**](#) | **post** | ['type'=> 'post_type', 'account_ids'=> 'id', 'caption'=> 'Caption For Post', 'is_scheduled'=> true or false, 'schedule_date'=> 'timestamp', 'media_ids'=> 'file_id'] | Create a post with an existing file and it can be scheduled
*Post-retry* | [**put**](#) | **post/{postId}/retry** | - | Retry create post if not successful
*Post-cancel* | [**put**](#) | **post/{postId}/cancel** | - | Cancel a scheduled post if is not done
*Ticket-all* | [**get**](#) | **ticket** | - | Get all tickets information assigned to your token
*Ticket-one* | [**get**](#) | **ticket{ticketId}** | - | Get one ticket information with specific ID
*Ticket-get-meta* | [**get**](#) | **ticket/{ticketId}/meta** | - | Get one ticket meta data with specific ID
*Ticket-departments* | [**get**](#) | **ticket/departments** | - | Get ticket departments information
*Ticket-create* | [**post**](#) | **ticket** | ['title'=> 'Ticket Title', 'content'=> 'Ticket Content', 'department_id'=> 'id'] | Create a ticket for a specific department
*Ticket-add-meta* | [**put**](#) | **ticket/{ticketId}/meta** | ['content'=> 'Meta Content'] | Add meta data to an existing ticket with specific ID
*Ticket-close* | [**put**](#) | **ticket/{ticketId}/close** | - | Close an existing ticket with specific ID


## Author

support@novinhub.com


