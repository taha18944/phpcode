<?php
	include('index.php');
	session_start();
	$id = $_SESSION['userid'];
	$requestType = $_POST['requestType'];
	switch ($requestType) {
		case 'changePassword':
			$current_password = $_POST['currentPassword'];
			$new_password = $_POST['newPassword'];
			$confirm_password = $_POST['confirmPassword'];
			$salt = generatingSalt();
        	$hashpassword = encryptString($salt, $confirm_password);      		
			$query = "UPDATE users SET salt = '$salt', password = '$hashpassword' WHERE id = '$id'";
			$dbobjx->query($query);
			$result = $dbobjx->execute();
		break;

		case 'checkCurrentPassword':
			$current_password = $_POST['current_password'];
			$query = "SELECT * FROM users WHERE id = '$id'";
			$dbobjx->query($query);
			$result = $dbobjx->single();
			$hashpassword = $result->password;
			$salt = $result->salt;
			if(encryptString($salt,$current_password) == $hashpassword){
                echo response("1","Current Password is correct",[]);
            }else{
                echo response("0","Current Password is incorrect",[]);
            }
		break;

		case 'updateProfile':
			$username = $_POST['username'];
			$phone = $_POST['phone'];
			$email = $_POST['email'];
			$query = "UPDATE users SET username = '$username', phone = '$phone' WHERE id = '$id'";
			$dbobjx->query($query);
			$result = $dbobjx->execute();
			if ($result == 1) {
				$query = "SELECT * FROM users WHERE id = '$id'";
				$dbobjx->query($query);
    			$result = $dbobjx->single();
				$_SESSION['fullname']	=	$result->username;
                echo response("1","Updated",[]);
			}
		break;
		
		default:
			# code...
			break;
	}
?>