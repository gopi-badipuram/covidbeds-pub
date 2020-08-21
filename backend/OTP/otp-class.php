<?php


class OTP
{
	var $con;

	function __construct($con)
	{
		$this->con=$con;
	}

	function send_otp($sender,$mode,$cause="account_register"){
		$otp_value=rand(100000,999999);

		if($mode=="mail"){
			$this->send_mail($sender,$otp_value);
		}
		elseif($mode=="phone") {
			$this->send_sms($sender,$otp_value);
		}

		$date=date("Y-m-d H:i:s");

		if($cause=="forgot_password"){
			$_SESSION['forgot_password_time']=$date;
		}

		$this->disable_prev_otp($sender,$mode,$cause);
		$this->insert_otp_db($sender,$otp_value,$mode,$date,$cause);
	}

	function verify_otp($sender,$otp,$mode,$cause="account_register"){
		$date=date("Y-m-d H:i:s");

		$query="select * from otp_verification where otp_sender=? and otp_value=? and otp_mode=? and otp_verified=false and otp_verification_time='0000-00-00 00:00:00' and cause=?;";

		if($stmt=$this->con->prepare($query)){
			$stmt->bind_param("ssss",$sender,$otp,$mode,$cause);
			if($stmt->execute()){
				$result=$stmt->get_result();
				if(mysqli_num_rows($result)==1){
					$row=$result->fetch_assoc();
					$diff=strtotime($date)-strtotime($row['otp_generation_time']);
					
					if($diff>300){
						die(json_encode(array("response" => "wrong otp")));
					}
					else{
						$this->otp_verified($row['otp_id']);
						if($cause=="profile update"){
							return $row['otp_id'];
						}
						else{
							$_SESSION['forgot_password_verified']=$row['otp_id'];
							echo json_encode(array("response" => "success"));
						}
					}
				}
				else{
					die(json_encode(array("response" => "wrong otp")));
				}
			}
		}
	}

	function send_mail($sender,$otp){

		require_once('Email/vendor/autoload.php');

		$mj = new \Mailjet\Client('f9b86bdba7fcf1d10339bda76cee856a', 'd4cb01793e441d8581377d4fcbaca8fb', true,['version' => 'v3.1']);
        $body = [
                'Messages' => [
                    [                        
                        'From' => [
                            'Email' => "donot-reply@philipsfunds.com",
                            'Name' => "Donot reply"
                            ],
                        'To' => [
                            [
                                'Email' => $sender,
                                'Name' => ''
                            ]
                        ],
                        'Subject' => "Philipsfunds Email Verification",
                        'TextPart' => "",
                        'HTMLPart' => "<p>Your <strong>OTP</strong> for Verification of email address is:</p><h2>".$otp."</h2>"
                    ]
                ]
        ];

        $response = $mj->post(\Mailjet\Resources::$Email, ['body' => $body]);

        if(!$response->success()){
        	die(json_encode(array("response" => "error while sending email")));
        }
            
	}

	function send_sms($number,$message){
		require_once('aws/app/start.php');

		$client = Aws\Sns\SnsClient::factory(array(
	    'region' => 'us-east-1',
	    'version' => 'latest',
	    'credentials' => array(
	        'key' => 'AKIAJZCDCYEPKZGTX3DA',
	        'secret' => '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')
	    ));

		$msg="The OTP for Philipsfunds is ".$message;
		$ph=$number;
		$sent = $client->publish(
		    [
		        'Message' => $msg,
		        'PhoneNumber' => $ph,
		        'MessageAttributes' => [
		            'AWS.SNS.SMS.SenderID' => [
		                'DataType' => 'String',
		                'StringValue' =>  'PHOTP'
		            ],
		            'AWS.SNS.SMS.SMSType'  => [
		                'DataType'    => 'String',
		                'StringValue' => 'Transactional',
		            ]
		        ]
		    ]
		);
	}

	function disable_prev_otp($sender,$mode,$cause){
		$query="update otp_verification set otp_verification_time=? where otp_sender=? and otp_mode=? and otp_verified=0 and cause=?;";

		if($stmt=$this->con->prepare($query)){
			$date=date("Y-m-d H:i:s");

			$stmt->bind_param("ssss",$date,$sender,$mode,$cause);
			if(!$stmt->execute()){
				die(json_encode(array("response" => "error while disabling previous otp", "cause" => $stmt->error)));
			}
		}
		else{
			die(json_encode(array("response" => "error while disabling previous otp", "cause" => $this->con->error)));
		}
	}

	function insert_otp_db($sender,$otp,$mode,$date,$cause){

		$query="insert into otp_verification(otp_sender,otp_value,otp_mode,otp_generation_time,cause) values(?,?,?,?,?);";

		if($stmt=$this->con->prepare($query)){
			$stmt->bind_param("sssss",$sender,$otp,$mode,$date,$cause);
			if($stmt->execute()){
				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "error while entering otp into db", "cause" => $stmt->error)));
			}
		}
		else{
			die(json_encode(array("response" => "error while entering otp into db", "cause" => $this->con->error)));
		}
	}

	function otp_verified($otp_id){
		$date=date("Y-m-d H:i:s");
		
		$query="update otp_verification set otp_verified=true, otp_verification_time=? where otp_id=?;";

		if($stmt=$this->con->prepare($query)){
			$stmt->bind_param("ss",$date,$otp_id);
			if(!$stmt->execute()){
				die(json_encode(array("response" => "error while updating otp verified", "cause" => $stmt->error)));
			}
		}
		else{
			die(json_encode(array("response" => "error while updating otp verified", "cause" => $this->con->error)));

		}
	}

	function check_user_exists($id,$type){
		$query="";
		if($type=="investor"){
			$query="select * from investor_details where investor_email=? or investor_phone=?;";
		}
		else if($type=="investee"){
			$query="select * from investee_details where investee_email=? or investee_phone=?;";
		}

		if($stmt=$this->con->prepare($query)){
			$stmt->bind_param("ss",$id,$id);
			if($stmt->execute()){
				$result=$stmt->get_result();
				if(mysqli_num_rows($result)>0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => $this->con->error)));
		}
	}

	function check_details_verified($mail,$phone){

		$arr=array(array("mode" => "mail", "sender" => $mail), array("mode" => "phone", "sender" => $phone));
		$arr1=array();

		for($i=0;$i<sizeof($arr);$i++){
			$query="select max(otp_id) as otp_id from otp_verification where otp_sender=? and otp_mode=? and otp_verified=1 and otp_verification_time!='0000-00-00 00:00:00';";

			if($stmt=$this->con->prepare($query)){
				$stmt->bind_param("ss",$arr[$i]['sender'],$arr[$i]['mode']);
				if($stmt->execute()){
					$result=$stmt->get_result();
					if(mysqli_num_rows($result)>0){
						$row=$result->fetch_assoc();
						array_push($arr1, $row['otp_id']);
					}
					else{
						die(json_encode(array("response" => "failed", "cause" => "User Not verified")));
					}
				}
				else{
					die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
				}
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => $this->con->error)));

			}
		}
		return $arr1;
	}



}

?>