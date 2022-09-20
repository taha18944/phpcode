<?php
    session_start();
	include('index.php');
    include("../classes/outlendars.php");
    $outlendars= new Outlendars();
	$requestType = $_POST['requestType'];
  	switch ($requestType) {
  		case 'login':
      		$email            = $_POST['email'];
      		$password         = $_POST['password'];
            $query = "SELECT u.*,DATEDIFF(now(),created_at) AS trial_time,(trial_period-DATEDIFF(now(),created_at)) as trial_period_left FROM users as u WHERE u.email='".$email."'";
            $dbobjx->query($query);
            $result = $dbobjx->single();
            if($dbobjx->rowCount() > 0 ){
                $user_id = $result->id;
                $fullname = $result->username;
                $email = $result->email;
                $salt = $result->salt;
                $hashpassword = $result->password;
                $active = $result->active;
                $otp_verify= $result->otp_verification;
                $approved = $result->approved;
                $trial_period = $result->trial_period;
                $trial_time = $result->trial_time;
                $trial_period_left = $result->trial_period_left;
                $package = $result->package;
                $role_id = $result->role_id;
                if($otp_verify == "N"){
                    echo response("0","OTP not verified",[]);
                    exit;
                }
                if ($trial_time>=$trial_period) {
                    echo response("0","Your Trial Period has been exceeded. Please contact admin to Activate Your account",[]);
                    exit;
                }
                if(encryptString($salt,$password) == $hashpassword){
                    if ($active=='Y') {
                        $_SESSION['userid']     =   $user_id;
                        $_SESSION['fullname']   =   $fullname;
                        $_SESSION['email']      =   $email;
                        $_SESSION['package']    =   $package;
                        $_SESSION['role_id']    =   $role_id;
                        $data[] = array(
                            "user_id" => $user_id,
                            "fullname" => $fullname,
                            "email" => $email,
                        );
                        $sql="SELECT * FROM `permissions` as p RIGHT JOIN menu as m ON p.menu_id = m.id where p.role_id='$role_id'";      
                        $dbobjx->query($sql);
                        $resultM = $dbobjx->resultset();
                        $_SESSION['menus']=$resultM;

                        $sql2="SELECT * FROM `internal_functions` where role_id='$role_id'";      
                        $dbobjx->query($sql2);
                        $resultM2 = $dbobjx->resultset();
                        $_SESSION['internal_functions']=$resultM2;
                        echo response("1","Success",$data);
                    }else{
                        echo response("0","Account Deactive",[]);
                    }
                }else{
                    echo response("0","Wrong Password",[]);
                }
            }else{
                echo response("0","Invalid email",[]);
            }
      	break;

        case 'register':
            $username = $_POST['fullName'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $package = "TRAIL";
            $password = $_POST['password'];
            $role_id = $_POST['role_id'];
            $type = $_POST['type'];
            $charge_amount = ($_POST['type'] == 'Monthly') ? 300 : 3000; 
            $query = "SELECT email FROM users WHERE email = '$email'";
            $dbobjx->query($query);
            $dbobjx->single();
            $result = $dbobjx->rowCount();
            if ($result > 0){
                echo response("0", "Dulplicate Email", []);
                return false;
            }
            $generate_otp = rand(1000,9999);
            $query = "SELECT otp FROM users WHERE otp = '$generate_otp' AND otp_verification !='N'";
            $dbobjx->query($query);
            $dbobjx->single();
            $result = $dbobjx->rowCount();
            if ($result > 0){
                $generate_otp = rand(1000,9999);
                $query        = "SELECT otp FROM users WHERE otp = '$generate_otp' AND otp_verification !='N'";
                $dbobjx->query($query);
                $dbobjx->single();
                $result = $dbobjx->rowCount();
                if ($result > 0){
                    $generate_otp = rand(1000,9999);
                }    
            }
            $salt = generatingSalt();
            $hashpassword = encryptString($salt, $password);
            $query = "INSERT INTO users (`username`,`role_id`,`type`,`phone`,`email` , `password` , `salt`,`charge_amount`,`package`,`otp`,`otp_verification`,`is_deleted`,`api_key`,`active`,`trial_period`,`approved`,`created_at`) VALUES ('$username','$role_id','$type','$phone','$email','$hashpassword','$salt','$charge_amount','$package','$generate_otp','N','N',LEFT(MD5(RAND()), 32), 'Y','30','N',NOW())";
            $dbobjx->query($query);
            if($dbobjx->execute($query)){
                $user_id = $dbobjx->lastInsertId();
                
                $data[] = array(
                    "user_id" => $user_id,
                    "email" => $email,
                    "phone" => $phone,
                    "package" => $package,
                    "otp" => 'N'
                );
                echo response("1","Success",$data);
            }else{
                $data[] = array(
                    "status"=> "0",
                    "message"=>"Something went wrong!!",
                );
            }
        break;

        case 'CountTrialPeriod':
            $user_id = $_POST['user_id'];
            $getCurrentUser = $outlendars->getCurrentUser();
            if ($getCurrentUser->status==1) {
                $getCurrentUser->payload->package;
                if ($getCurrentUser->payload->package=='TRAIL') {
                    $query = "SELECT created_at,trial_period, DATEDIFF(now(),created_at) AS trial_time, (trial_period-DATEDIFF(now(),created_at)) as trial_period_left FROM users WHERE id='$user_id'";
                    $dbobjx->query($query);
                    $result = $dbobjx->single();
                    $trial_period = $result->trial_period;
                    $trial_time = $result->trial_time;
                    $trial_period_left = $result->trial_period_left;
                    $data = array(
                        "trial_time" => $trial_time,
                        "trial_period" => $trial_period,
                        "trial_period_left" => $trial_period_left,
                        'created_at'=> $result->created_at,
                        'expire_at'=> date('Y-m-d h:i:s',strtotime($result->created_at.' +'.$trial_period_left.' days')),
                    );
                    if ($trial_time>=$trial_period) {
                        echo response("0","Your Trial Period has been exceeded. Please contact admin to Activate Your account",$data);
                    }else{ 
                        echo response("2","Success",$data);
                    }
                }else{
                    echo response("1","Success",[]);
                }
            }
        break;

        case 'otp':
            $otp = $_POST['otp'];
            $email = $_POST['email'];
            $query = "SELECT otp, TIMESTAMPDIFF(MINUTE,updated_at,now()) AS otp_time FROM users WHERE otp = '$otp' AND email ='$email'";
            $dbobjx->query($query);
            $result_data = $dbobjx->single();
            $otp_time=$result_data->otp_time;
            $result = $dbobjx->rowCount();
            if ($result > 0){
                if($otp_time > 15){
                    $generate_otp = rand(1000,9999);
                    $query = "SELECT otp FROM users WHERE otp = '$generate_otp' AND otp_verification !='N'";
                    $dbobjx->query($query);
                    $dbobjx->single();
                    $result = $dbobjx->rowCount();
                    if ($result > 0){
                        $generate_otp = rand(1000,9999);
                        $query = "SELECT otp FROM users WHERE otp = '$generate_otp' AND otp_verification !='N'";
                        $dbobjx->query($query);
                        $dbobjx->single();
                        $result = $dbobjx->rowCount();
                        if ($result > 0){
                            $generate_otp = rand(1000,9999);
                        }else{
                            $query = "UPDATE users SET otp_verification = '$generate_otp',updated_at=NOW() WHERE email ='$email'";
                            $dbobjx->query($query);
                            if($dbobjx->execute($query)){
                                echo response("3","OTP Expired, New OTP Generated",[]);
                            }else{
                                echo response("0","Something Went Wrong",[]);
                            }
                        }   
                    }else{
                        $query = "UPDATE users SET otp = '$generate_otp',updated_at=NOW() WHERE email ='$email'";
                        $dbobjx->query($query);
                        if($dbobjx->execute($query)){
                            $data[] = array(
                                "email" => $email,
                            );
                            echo response("3","OTP Expired, New OTP Generated",$data);
                        }else{
                            echo response("0","Something Went Wrong",[]);
                        }
                    }
                }else{
                    $query = "UPDATE users SET otp_verification = 'Y', approved = 'Y'  WHERE otp = '$otp' AND email ='$email'";
                    $dbobjx->query($query);
                    if($dbobjx->execute($query)){
                        $data[] = array(
                            "email" => $email,
                        );
                        echo response("1","Success",$data);
                    }else{
                        echo response("0","Something Went Wrong",[]);
                    }
                }
            }else{
                echo response("0","Invalid OTP Code",[]);
            }
        break;

        case 'checkUrlPermission':
            $outlendars->checkUrlPermissions();
            $role_id        =   $_SESSION['role_id'];
            $request_uri    =   $_POST['request_uri'];
            $permission     =   "Permission Denied";
            $status         =   0;
            $sql            =   "SELECT * FROM `internal_functions` WHERE role_id = '$role_id' AND route ='$request_uri'";      
            $dbobjx->query($sql);
            $result = $dbobjx->single();
            if($dbobjx->rowCount() > 0 ){
                $status         =   1;
                $permission     =   "Permission Allow";
            }
            echo response($status,$permission,[]);
        break;
        case 'checkUserDB':
            $result = $outlendars->checkUserDB();
            echo response($result->status,$result->message,[]);
        break;

        case 'forget_password':
            $email = $_POST['email'];
            $query = "SELECT email FROM users WHERE email = '$email'";
            $dbobjx->query($query);
            $dbobjx->single();
            $result = $dbobjx->rowCount();
            if ($result == 0){
                echo response("0", "Invalid Email", []);
                exit;
            }
            else{
                $encrypted_email=encryption($email);
                $encrypted_email_actual=str_replace('+', 'PILUS', $encrypted_email);
                $time_token=encryption(time());
                $time_token_actual=str_replace('+', 'PILUS', $time_token);
                $created_url=BASE_URL.'/set_password?token='.$encrypted_email_actual.'&time='.$time_token_actual;
                echo response("1",$created_url,[]);
            }
        break;
        
        case 'change_password':
            $encrypted_email=str_replace('PILUS', '+', $_POST['email_token']);
            $email=decryption($encrypted_email);
            //$time=decryption($_POST['email_token']);
            $new_password = $_POST['new_password'];
            $salt = generatingSalt();
            $hashpassword = encryptString($salt, $new_password);
            $query = "SELECT email FROM users WHERE email = '$email'";
            $dbobjx->query($query);
            $dbobjx->single();
            $result = $dbobjx->rowCount();
            if ($result == 0){
                echo response("0", "Invalid Token", []);
                exit;
            }
            else{
                $query = "UPDATE users SET salt = '$salt', password = '$hashpassword' WHERE email ='$email'";
                $dbobjx->query($query);
                if($dbobjx->execute($query)){
                    echo response("1","Password Updated",[]);
                }else{
                    echo response("0","Something Went Wrong",[]);
                }
            }
        break;

        default:
        # code...
        break;
	}
?>