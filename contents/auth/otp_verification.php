<?php
    $title = 'OTP';
    include( '../includes/login_header.php');
    if (isset($_POST['email'])) {
        $user_email = $_POST['email'];
    }else{
        header("Location: /login");
    }
?>
<body class="bg-secondary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="o-hidden shadow-lg my-10">
                    <div class="card">
                        <div class="card-header">
                            <img src="<?= BASE_URL ?>/assets/images/Logo-removebg-preview.png" alt="Outlendars" class="mb-2"/>
                            <h3 class="text-center">OTP Verification</h3>
                        </div>
                        <div class="card-body">
                            <div class="formWrapper">
                                <form class="needs-validation" method="post">
                                    <div class="row">
                                        <div class="input-group form-group">
                                            <input type="text" name="userEmail" class="form-control custom-input" id="userEmail" value ="<?php echo $user_email ;?>" hidden>
                                            <input type="text" name="otp" class="form-control custom-input" id="otp" required placeholder="OTP">
                                        </div>
                                        <div class="col-sm-12 form-group mb-0 register-button">
                                           <button type="button" id="submit" name="submit" onclick="otpverify();" class="btn btn-outlendars float-right login_btn">Verify</button>
                                        </div>                
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center links">
                                Already have an account? <a href="/login" class="text-outlendars pl-1"> Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include( '../includes/login_footer.php' );?>
<script src="<?= BASE_URL ?>/assets/js/app/otp.js"></script>
</body>
</html>