<?php
require 'vendor/autoload.php';
use \Mailjet\Resources;

function attachment($path)
{
  $data = file_get_contents($path);
  $base64 = base64_encode($data);
  return $base64;
}

//var_dump(attachment('test.txt', 'test.txt'));

$mj = new \Mailjet\Client('3d389264375d300e2d3fe155f0425b96', '159200bb498cb1a12ccd2f96ecc7cfe8', true,['version' => 'v3.1']);
$body = [
             'Messages' => [
                             [                        
                                'From' => [
                                    'Email' => "admin@adzpert.com",
                                    'Name' => "adzpert.com"
                                              ],
                                    'To' => [
                                        [
                                            'Email' => "sulaimanbakash@gmail.com"
                                        ]
                                 ],
                                'Subject' => "Mailjet Attachment test",
                                'TextPart' => "",
                                'HTMLPart' => "This is a test"
                                /*'Attachments' => [
									                [
									                    'ContentType' => "application/pdf",
									                    'Filename' => "test.pdf",
									                    'Base64Content' => attachment("example1.pdf")
									                ]
									            ]*/
                                 ]
                             ]
                           ];

$response = $mj->post(Resources::$Email, ['body' => $body]);
var_dump($response->getData());
/*if($response->success()){
		echo "success";
	}else{
	die("failed");
}*/


?>