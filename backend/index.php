<?php

require_once('dbconfig.php');

date_default_timezone_set('Asia/Kolkata');

session_start();

if(isset($_POST['admin_login'])){
	$login_id=(isset($_POST['login_id'])?$_POST['login_id']:false);
	$login_pass=(isset($_POST['login_pass'])?$_POST['login_pass']:false);

	if($login_id && $login_pass){
		$query = "select * from admin_login where admin_login_id=?";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("s",$login_id);

			if($stmt->execute()){
				$result = $stmt->get_result();

				if(mysqli_num_rows($result) == 1){
					$row = $result->fetch_assoc();

					$pass=$row['admin_login_salt'].$login_pass;
					$pass=hash('sha512',$pass);
					
					if($row['admin_login_pass'] == $pass){
						$_SESSION['covid_app_user'] = 'admin';
						$_SESSION['covid_app_user_id'] = $row['admin_id'];

						echo json_encode(array("response" => "success"));
					}
					else{
						die(json_encode(array("response" => "failed", "cause" => "wrong password")));
					}
				}
				else{
					die(json_encode(array("response" => "failed", "cause" => "wrong password")));
				}
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "params empty")));
	}
}

if(isset($_POST['add_hospital'])){
	if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
		die(json_encode(array("response" => "failed", "cause" => "user error")));
	}

	$name = $_POST['name'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $beds = $_POST['beds'];
    $vacant = $_POST['vacant'];
    $attr = $_POST['attr'];
    $last_updated = $_POST['last_updated'];

    $date = date_format(date_create($last_updated), "Y-m-d H:i:s");

    //$date = Date("Y-m-d H:i:s");

    $query = "insert into hospital_details(hospital_name,hospital_phone,hospital_address,hospital_alloted_beds,hospital_attr,hospital_vacant_beds,last_update) values(?,?,?,?,?,?,?);";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("sssssss",$name,$phone,$addr,$beds,$attr,$vacant,$date);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['update_hospital'])){
	if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
		die(json_encode(array("response" => "failed", "cause" => "user error")));
	}

	$id = $_POST['hosp_id'];
	$name = $_POST['name'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $beds = $_POST['beds'];
    $vacant = $_POST['vacant'];
    $attr = $_POST['attr'];
    $last_updated = $_POST['last_updated'];

    $date = date_format(date_create($last_updated), "Y-m-d H:i:s");

    //$date = Date("Y-m-d H:i:s");

    $query = "update hospital_details set hospital_name=?, hospital_phone=?, hospital_address=?, hospital_alloted_beds=?, hospital_attr=?, hospital_vacant_beds=?, last_update=? where hospital_id=?;";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("ssssssss",$name,$phone,$addr,$beds,$attr,$vacant,$date,$id);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => $con->error)));
	}
}

if(isset($_POST['delete_hospital'])){
	$hosp_id=(isset($_POST['hosp_id'])?$_POST['hosp_id']:false);

	if($hosp_id){
		$query = "delete from hospital_details where hospital_id=?;";

		if($stmt = $con->prepare($query)){

			$stmt->bind_param("s",$hosp_id);

			if($stmt->execute()){
				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['add_ambulance'])){
	if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
		die(json_encode(array("response" => "failed", "cause" => "user error")));
	}

	$name = $_POST['name'];
    $phone = $_POST['phone'];
    $num = $_POST['num'];
    $cost = $_POST['cost'];
    $types = $_POST['types'];
    $attr = $_POST['attr'];

    //$date = date_format(date_create($last_updated), "Y-m-d H:i:s");

    $date = Date("Y-m-d H:i:s");

    $query = "insert into ambulance_details(ambulance_provider,ambulance_phone,ambulance_qty,ambulance_cost,ambulance_types,ambulance_attr,last_update) values(?,?,?,?,?,?,?);";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("sssssss",$name,$phone,$num,$cost,$types,$attr,$date);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['update_ambulance'])){
	if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
		die(json_encode(array("response" => "failed", "cause" => "user error")));
	}

	$id = $_POST['amb_id'];
	$name = $_POST['name'];
    $phone = $_POST['phone'];
    $num = $_POST['num'];
    $cost = $_POST['cost'];
    $types = $_POST['types'];
    $attr = $_POST['attr'];

    //$date = date_format(date_create($last_updated), "Y-m-d H:i:s");

    $date = Date("Y-m-d H:i:s");

    $query = "update ambulance_details set ambulance_provider=?, ambulance_phone=?, ambulance_qty=?, ambulance_cost=?, ambulance_types=?, ambulance_attr=?, last_update=? where ambulance_id=?;";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("ssssssss",$name,$phone,$num,$cost,$types,$attr,$date,$id);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => $con->error)));
	}
}

if(isset($_POST['delete_ambulance'])){
	$amb_id=(isset($_POST['amb_id'])?$_POST['amb_id']:false);

	if($amb_id){
		$query = "delete from ambulance_details where ambulance_id=?;";

		if($stmt = $con->prepare($query)){

			$stmt->bind_param("s",$amb_id);

			if($stmt->execute()){
				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => $con->error)));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['add_tc'])){
	if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
		die(json_encode(array("response" => "failed", "cause" => "user error")));
	}

	$name = $_POST['name'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $cost = $_POST['cost'];
    $types = $_POST['types'];
    $wait_time = $_POST['wait_time'];
    $attr = $_POST['attr'];

    //$date = date_format(date_create($last_updated), "Y-m-d H:i:s");

    $date = Date("Y-m-d H:i:s");

    $query = "insert into testing_centers(tc_name,tc_phone,tc_addr,tc_cost,tc_types,tc_attr,last_update,tc_wait_time) values(?,?,?,?,?,?,?,?);";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("ssssssss",$name,$phone,$addr,$cost,$types,$attr,$date,$wait_time);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['update_tc'])){
	if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
		die(json_encode(array("response" => "failed", "cause" => "user error")));
	}

	$id = $_POST['tc_id'];
	$name = $_POST['name'];
    $phone = $_POST['phone'];
    $addr = $_POST['addr'];
    $cost = $_POST['cost'];
    $types = $_POST['types'];
    $wait_time = $_POST['wait_time'];
    $attr = $_POST['attr'];

    //$date = date_format(date_create($last_updated), "Y-m-d H:i:s");

    $date = Date("Y-m-d H:i:s");

    $query = "update testing_centers set tc_name=?, tc_phone=?, tc_addr=?, tc_cost=?, tc_types=?, tc_attr=?, last_update=?, tc_wait_time=? where tc_id=?;";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("sssssssss",$name,$phone,$addr,$cost,$types,$attr,$date,$wait_time,$id);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => $con->error)));
	}
}

if(isset($_POST['delete_tc'])){
	$tc_id=(isset($_POST['tc_id'])?$_POST['tc_id']:false);

	if($tc_id){
		$query = "delete from testing_centers where tc_id=?;";

		if($stmt = $con->prepare($query)){

			$stmt->bind_param("s",$tc_id);

			if($stmt->execute()){
				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => $stmt->error)));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => $con->error)));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['get_hospitals'])){
	$query = "select * from hospital_details order by hospital_name";

	if($stmt = $con->prepare($query)){
		if($stmt->execute()){
			$result = $stmt->get_result();

			if(mysqli_num_rows($result) > 0){
				$arr = array();

				while($row = $result->fetch_assoc()){
					$arr[] = $row;
				}

				echo json_encode(array("response" => "success", "payload" => $arr));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "not found")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['get_ambulance_list'])){
	$query = "select * from ambulance_details";

	if($stmt = $con->prepare($query)){
		if($stmt->execute()){
			$result = $stmt->get_result();

			if(mysqli_num_rows($result) > 0){
				$arr = array();

				while($row = $result->fetch_assoc()){
					$arr[] = $row;
				}

				echo json_encode(array("response" => "success", "payload" => $arr));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "not found")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['get_tc'])){
	$query = "select * from testing_centers";

	if($stmt = $con->prepare($query)){
		if($stmt->execute()){
			$result = $stmt->get_result();

			if(mysqli_num_rows($result) > 0){
				$arr = array();

				while($row = $result->fetch_assoc()){
					$arr[] = $row;
				}

				echo json_encode(array("response" => "success", "payload" => $arr));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "not found")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['update_stats'])){
	$type = (isset($_POST['type'])?$_POST['type']:false);
	$today = (isset($_POST['today'])?$_POST['today']:false);
	$active = (isset($_POST['active'])?$_POST['active']:false);
	$discharges_today = (isset($_POST['discharges_today'])?$_POST['discharges_today']:false);
	$discharges_total = (isset($_POST['discharges_total'])?$_POST['discharges_total']:false);
	$deaths_today = (isset($_POST['deaths_today'])?$_POST['deaths_today']:false);
	$deaths_total = (isset($_POST['deaths_total'])?$_POST['deaths_total']:false);
	$total = (isset($_POST['total'])?$_POST['total']:false);

	unset($_POST['update_stats']);
	unset($_POST['type']);


	//if($type && $today && $active && $discharges_today && $discharges_total && $deaths_total && $deaths_today && $total){

	foreach ($_POST as $key => $value) {
		$query = "update covid_stats set stat_value=?, stat_last_update=? where stat_key=?";

		$a = $type."-".str_replace("_", "-", $key);
		$date = Date("Y-m-d H:i:s");

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("sss",$value,$date,$a);

			if(!$stmt->execute()){
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}

	echo json_encode(array("response" => "success"));
	
}

if(isset($_POST['add_mail'])){
	$mail = (isset($_POST['mail'])?$_POST['mail']:false);

	if($mail){
		$date = Date("Y-m-d H:i:s");

		$query = "insert into mailing_list(mail_address,mail_time) values(?,?);";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("ss",$mail,$date);

			if($stmt->execute()){
				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['contact'])){
	$name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $sub = $_POST['sub'];
    $msg = $_POST['msg'];
    $date = Date("Y-m-d H:i:s");

    $query = "insert into feedback(feed_name,feed_email,feed_phone,feed_subject,feed_msg,feed_date) values(?,?,?,?,?,?);";

    if($stmt = $con->prepare($query)){
    	$stmt->bind_param("ssssss",$name,$email,$phone,$sub,$msg,$date);

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['add_blog'])){
	$title = $_POST['title'];
    $slug = $_POST['slug'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $img = $_POST['img'];
    $content = $_POST['content'];

    $date = date_format(date_create($date), "Y-m-d H:i:s");

    $file = fopen("../blog/".$slug.".php", "w");

    require_once('write-blog.php');

    $html = get_blog_html($title, $author, $date, $img, $content);

    fwrite($file, $html);

    fclose($file);

    if(isset($_POST['blog_id'])){
    	$query = "update blog set blog_title=? ,blog_slug=? ,blog_author=? ,blog_date=? ,blog_img=? ,blog_content=? where blog_id=?;";
    }
    else{
    	$query = "insert into blog(blog_title,blog_slug,blog_author,blog_date,blog_img,blog_content) values(?,?,?,?,?,?);";
    }

    if($stmt = $con->prepare($query)){
    	if(isset($_POST['blog_id'])){
    		$stmt->bind_param("sssssss",$title,$slug,$author,$date,$img,$content,$_POST['blog_id']);
    	}
    	else{
    		$stmt->bind_param("ssssss",$title,$slug,$author,$date,$img,$content);
    	}

    	if($stmt->execute()){
    		echo json_encode(array("response" => "success"));
    	}
    	else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
    }
    else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['add_blr_daily_stats'])){
	$ward_num=(isset($_POST['ward_num'])?$_POST['ward_num']:false);
	$ward_name=(isset($_POST['ward_name'])?$_POST['ward_name']:false);
	$cases=(isset($_POST['cases'])?$_POST['cases']:false);
	$date=(isset($_POST['date'])?$_POST['date']:false);

	$date = date_format(date_create($date), "Y-m-d");

		$query = "insert into blr_daily_stats(stat_ward_id,stat_ward_name,stat_cases,stat_date) values(?,?,?,?);";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("ssss",$ward_num,$ward_name,$cases,$date);

			if($stmt->execute()){
				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
}

if(isset($_POST['register_counsellor'])){
	$name = (isset($_POST['name'])?$_POST['name']:false);
	$phone = (isset($_POST['phone'])?$_POST['phone']:false);
	$email = (isset($_POST['email'])?$_POST['email']:false);
	$pass = (isset($_POST['pass'])?$_POST['pass']:false);

	//var_dump($_POST);

	if($name && $phone && $email && $pass){
		$query = "insert into counsellors(counsellor_name,counsellor_email,counsellor_phone,counsellor_salt,counsellor_pass,reg_date) values(?,?,?,?,?,?)";

		if($stmt = $con->prepare($query)){
			$salt = openssl_random_pseudo_bytes(128);
			$pass1 = $salt.$pass;
			$pass1 = hash('sha512',$pass1);
			$date = Date("Y-m-d H:i:s");

			$stmt->bind_param("ssssss",$name,$email,$phone,$salt,$pass1,$date);

			if($stmt->execute()){
				$otp = rand(100000,999999);

				$_SESSION['otp']['val'] = $otp;
				$_SESSION['otp']['time'] = $date;
				$_SESSION['otp']['phone'] = $phone;

				$msg = $otp." is your OTP for covidbeds.org registration.";

				send_sms($phone, $msg);

				echo json_encode(array("response" => "success"));
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['resend_otp'])){
	$phone = (isset($_POST['phone'])?$_POST['phone']:false);

	if($phone){
		$otp = rand(100000,999999);

		$_SESSION['otp']['val'] = $otp;
		$_SESSION['otp']['time'] = Date("Y-m-d H:i:s");
		$_SESSION['otp']['phone'] = $phone;

		$msg = $otp." is your OTP for covidbeds.org registration.";

		send_sms($phone, $msg);

		echo json_encode(array("response" => "success"));
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['verify_otp'])){
	$phone = (isset($_POST['phone'])?$_POST['phone']:false);
	$otp = (isset($_POST['otp'])?$_POST['otp']:false);

	//var_dump($_SESSION);

	if($phone && $otp){
		if(!isset($_SESSION['otp']['val'])){
			die(json_encode(array("response" => "failed", "cause" => "wrong otp")));
		}
		else{
			$date = Date("Y-m-d H:i:s");
			$diff = strtotime($date) - strtotime($_SESSION['otp']['time']);

			if($otp == $_SESSION['otp']['val'] && $_SESSION['otp']['phone'] == $phone  && $diff <= 300){
				$query = "update counsellors set phone_verified=1 where counsellor_phone=?";

				if($stmt = $con->prepare($query)){
					$stmt->bind_param("s",$phone);

					if($stmt->execute()){
						unset($_SESSION['otp']);
						echo json_encode(array("response" => "success"));
					}
					else{
						die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
					}
				}
				else{
					die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
				}
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "wrong otp")));
			}
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['counsellor_login'])){
	$login_id = (isset($_POST['login_id'])?$_POST['login_id']:false);
	$login_pass = (isset($_POST['login_pass'])?$_POST['login_pass']:false);

	if($login_id && $login_pass){
		$query = "select * from counsellors where counsellor_email=? or counsellor_phone=?";

		if($stmt = $con->prepare($query)){
			$stmt->bind_param("ss",$login_id,$login_id);

			if($stmt->execute()){
				$result = $stmt->get_result();

				if(mysqli_num_rows($result) == 1){
					$row = $result->fetch_assoc();

					$pass = $row['counsellor_salt'].$login_pass;
					$pass = hash('sha512',$pass);
					
					if($row['counsellor_pass'] == $pass){
						$_SESSION['covid_app_user'] = 'counsellor';
						$_SESSION['covid_app_user_id'] = $row['counsellor_id'];

						echo json_encode(array("response" => "success"));
					}
					else{
						die(json_encode(array("response" => "failed", "cause" => "wrong password")));
					}
				}
				else{
					die(json_encode(array("response" => "failed", "cause" => "wrong password")));
				}
			}
			else{
				die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['new_counseling_request'])){
	$name = (isset($_POST['name'])?$_POST['name']:exit_error());
	$phone = (isset($_POST['phone'])?$_POST['phone']:exit_error());
	$email = (isset($_POST['email'])?$_POST['email']:exit_error());
	$country = (isset($_POST['country'])?$_POST['country']:exit_error());
	$city = (isset($_POST['city'])?$_POST['city']:exit_error());
	$age = (isset($_POST['age'])?$_POST['age']:exit_error());
	$occupation = (isset($_POST['occupation'])?$_POST['occupation']:false);
	$language = (isset($_POST['language'])?$_POST['language']:exit_error());
	$mode = (isset($_POST['mode'])?$_POST['mode']:exit_error());
	$time = (isset($_POST['time'])?$_POST['time']:exit_error());
	$cfor = (isset($_POST['cfor'])?$_POST['cfor']:exit_error());
	$history = (isset($_POST['history'])?$_POST['history']:exit_error());
	$comments = (isset($_POST['comments'])?$_POST['comments']:false);
	$days = (isset($_POST['days'])?$_POST['days']:exit_error());

	$query = "insert into counselling_requests(req_name,req_email,req_phone,req_country,req_city,req_age,req_occupation,req_language,req_mode,req_days,req_time,req_for,req_history,req_message,req_date) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

	if($stmt = $con->prepare($query)){
		$date = Date("Y-m-d H:i:s");

		$stmt->bind_param("sssssssssssssss",$name,$email,$phone,$country,$city,$age,$occupation,$language,$mode,$days,$time,$cfor,$history,$comments,$date);

		if($stmt->execute()){
			echo json_encode(array("response" => "success"));

			$query1 = "select counsellor_phone from counsellors where phone_verified=1";

			if($stmt1 = $con->prepare($query1)){
				if($stmt1->execute()){
					$result = $stmt1->get_result();

					if(mysqli_num_rows($result) > 0){

						$msg = 'New counseling request from covidbeds.org. Patient name: '.$name.', Phone number: '.$phone.', Language: '.$language.', For: '.$cfor.'. Visit https://covidbeds.org/counselling to accept the request';

						while ($row = $result->fetch_assoc()) {
							send_sms($row['counsellor_phone'], $msg);
						}
					}
				}
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['accept_counseling_request'])){
	$req_id = (isset($_POST['req_id'])?$_POST['req_id']:exit_error());
	$phone = (isset($_POST['phone'])?$_POST['phone']:exit_error());

	$query = "update counselling_requests set req_accepted=1, req_accepted_by=?, req_accept_date=? where req_id=?";

	if($stmt = $con->prepare($query)){
		$date = Date("Y-m-d H:i:s");
		$stmt->bind_param("sss",$_SESSION['covid_app_user_id'],$date,$req_id);

		if($stmt->execute()){
			echo json_encode(array("response" => "success"));

			$query1 = "select * from counsellors where counsellor_id=?";

			if($stmt1 = $con->prepare($query1)){
				$stmt1->bind_param("s",$_SESSION['covid_app_user_id']);

				if($stmt1->execute()){
					$result = $stmt1->get_result();

					if(mysqli_num_rows($result) == 1){
						$row = $result->fetch_assoc();

						$msg = 'Your appointment for free counseling on covidbeds.org is booked. Dr.'.$row['counsellor_name'].' will be handling your session. You will get a call soon. Phone: '.$row['counsellor_phone'];

						send_sms($phone, $msg);
					}
				}
			}
		}
		else{
			die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
		}
	}
	else{
		die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
	}
}

if(isset($_POST['logout'])){
	unset($_SESSION['covid_app_user']);
	unset($_SESSION['covid_app_user_id']);

	echo json_encode(array("response" => "success"));
}

function send_sms($number,$message){
	require_once('aws/app/start.php');

	$client = Aws\Sns\SnsClient::factory(array(
	  'region' => 'us-east-1',
	  'version' => 'latest',
	  'credentials' => array(
	    'key' => 'AKIAIN5WHOMH5DHIJ2LQ',
	    'secret' => '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')
	));

	
	$sent = $client->publish(
		[
		    'Message' => $message,
		    'PhoneNumber' => '+91'.$number,
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

function exit_error(){
	die(json_encode(array("response" => "failed", "cause" => "something went wrong")));
}

//send_sms('8296082465', 'hello hd');

?>