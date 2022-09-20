<?php
	$title = 'Forget Password'; 
	include( '../includes/login_header.php');
    //include( '../../datafiles/index.php' );
    $encrypted_time=str_replace('PILUS', '+', $_GET['time']);
    $time=decryption($encrypted_time);
    $mins =(time() - $time)/60;
    if($mins >= 10){
        die("Link Expired");

    }

    function decryption($string){
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "GeeksforGeeks";
        $decryption = openssl_decrypt($string, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }

?>
<body class="bg-secondary">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="o-hidden shadow-lg my-10">
				<div class="card">
					<div class="card-header text-center">
						<img src="<?= BASE_URL ?>/assets/images/Logo-removebg-preview.png" alt="Outlendars" class="mb-2"/>
						<h3>Change Password</h3>
					</div>
					<div class="card-body">
						<div class="formWrapper">
							<form class="needs-validation" novalidate method="post">
                                <div class="input-group form-group">
									<input type="password" id="new_password" minlength="4" name="new_password" class="form-control custom-input" placeholder="New Password" required>
                                    <input type="text" id="email" minlength="4" name="email" class="form-control custom-input"  value="<?= $_GET['token'] ?>" hidden>
								</div>
                                <div class="input-group form-group">
									<input type="password" id="confirm_password" minlength="4" name="confirm_password" class="form-control custom-input" placeholder="Confirm Password" required>
								</div>
							
								<div class="form-group">
									<button type="button" id="submit" name="submit" value="Login" onclick="changePassword();" class="btn btn-outlendars float-right shadow-sm">Change Password</button>
								</div>
							</form>
						</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center links">
							Don't have an account?  <a href="/register" class="text-outlendars pl-1">Sign Up</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include( '../includes/login_footer.php' );?>
<script src="<?= BASE_URL ?>/assets/js/app/forget_password.js"></script>
<script>
  let changePassword = () => {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
        if(form.checkValidity() === false) {
            ($("#new_password").val()=='') ? $("#new_password").addClass('is-invalid') : $("#new_password").removeClass('is-invalid');
            ($("#confirm_password").val()=='') ? $("#confirm_password").addClass('is-invalid') : $("#confirm_password").removeClass('is-invalid');
            

        } 
        if($("#new_password").val() != $("#confirm_password").val()){
                $("#confirm_password").addClass('is-invalid');
                $("#new_password").addClass('is-invalid');
        }
        else {
            $('.needs-validation input').removeClass('is-invalid');
            let data = {
                new_password: $("#new_password").val(),
                email_token: $("#email").val(),
                requestType: 'change_password'
            };
            $.post('datafiles/user.php', data, function(response) {
                let getValues = JSON.parse(response);
                if(getValues.status == 1) {
                    alert("Password Changed");
                    window.location.href = '/login';
                } else {
                    $("#invalidError").show();
                    if(getValues.message == 'Invalid Token') {
                        $("#invalidError").html(getValues.message);
                    }
                    else{
                        $("#invalidError").html(getValues.message);
                    }
                    $(".valid-feedback").hide();
                    event.preventDefault();
                    event.stopPropagation();
                }
            });
        }
    });
};
// $(document).ready(function() {

//     let data = {
//         time_token:user_id,
//         requestType: 'CountTrialPeriod'
//     }
//     $.post('datafiles/user.php', data, function(result) {
//       let row = JSON.parse(result);
//       if (row.status==0) {
//         window.location.href = '/logout';
//       }else{
//         let finalTimeLeft;
//         let countDownDate = new Date(row.payload.expire_at).getTime();
//         let x = setInterval(function() {
//           let now = new Date().getTime();
//           let distance = countDownDate - now; 
//           let days = Math.floor(distance / (1000 * 60 * 60 * 24));
//           let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//           let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
//           let seconds = Math.floor((distance % (1000 * 60)) / 1000); 
//           finalTimeLeft = `${days} Days ${hours} Hours left for your Trial Period`;
//           if (distance < 0) {
//             clearInterval(x);
//             finalTimeLeft = 'EXPIRED';
//           }
//           $("#trialTimer").html(finalTimeLeft);
//         }, 1000);
//       }    
//     });
  
// });

</script>
</body>
</html>