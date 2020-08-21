<?php
header("Access-Control-Allow-Origin: *");

require_once("../DB/dbconfig.php");
require_once("otp-class.php");

session_start();

date_default_timezone_set('Asia/Kolkata');

$otp=new OTP($con);

if(isset($_POST['send_otp'])){
	$sender=(isset($_POST['otp_sender'])?$_POST['otp_sender']:false);
	$mode=(isset($_POST['otp_mode'])?$_POST['otp_mode']:false);
	$type=((isset($_POST['type'])&&!empty($_POST['type']))?$_POST['type']:false);

	if($sender&&$mode&&$type){

		if($otp->check_user_exists($sender,$type)){
			die(json_encode(array("response" => "failed", "cause" => "user exists")));
		}

		$otp->send_otp($sender,$mode);
	}
	else{
		die(json_encode(array("response" => "failed to send OTP", "cause" => "details are empty")));
	}
}

if(isset($_POST['verify_otp'])){
	$sender=(isset($_POST['otp_sender'])?$_POST['otp_sender']:false);
	$mode=(isset($_POST['otp_mode'])?$_POST['otp_mode']:false);
	$otp1=(isset($_POST['otp_value'])?$_POST['otp_value']:false);
	
	if($sender&&$mode&&$otp1){
		$otp->verify_otp($sender,$otp1,$mode);
	}
	else{
		die(json_encode(array("response" => "failed to verify OTP", "cause" => "details are empty")));
	}
}

//$otp=new OTP($con);
//$otp->send_otp("sulaimanbakash@gmail.com","mail");
//$otp->verify_otp("sulaimanbakash@gmail.com","989082","mail");
//echo $otp->check_details_verified("dfs@fsd.com","1234567890");
?>