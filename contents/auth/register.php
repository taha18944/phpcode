<?php
    include( '../includes/login_header.php' );
    if (isset($_GET['role_id']) && !empty($_GET['role_id'])) {
        $role_id = $_GET['role_id'];
    }else{
        $role_id = '1';
    }
    if (isset($_GET['type']) && !empty($_GET['type'])) {
        $type = $_GET['type'];
    }else{
        $type = 'Monthly';
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
                            <h2 class="text-center">Registration</h2>
                        </div>
                        <div class="card-body">
                            <div class="formWrapper">
                                <form class="needs-validation" method="post">
                                    <input type="hidden" class="form-control custom-input" name="role_id" id="role_id" value="<?php echo $role_id ?>">
                                    <input type="hidden" class="form-control custom-input" name="type" id="type" value="<?php echo $type ?>">
                                    <div class="input-group form-group">
                                        <input type="text" class="form-control custom-input" name="fname" id="fname" placeholder="Enter your full name" required>
                                    </div>
                                    <div class="input-group form-group">
                                        <input type="text" name="phone" class="form-control digits custom-input" id="phone" placeholder="Enter Your Contact Number" required>
                                    </div>
                                    <div class="input-group form-group">
                                        <input type="email" class="form-control custom-input" name="email" id="email" placeholder="Enter your email" required>
                                    </div>
                                    <div class="input-group form-group">
                                        <input type="Password" name="password" minlength="6" class="form-control custom-input" id="password" placeholder="Enter your password" required>
                                    </div>
                                    <div class="col-sm-12 form-group mb-0 register-button">
                                        <button type="button" id="submit" name="submit" onclick="register();" class="btn btn-outlendars float-right shadow-sm">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-center links">
                                Already have an account?<a href="/login" class="text-outlendars pl-1">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include( '../includes/login_footer.php' );?>
<script src="<?= BASE_URL ?>/assets/js/app/register.js"></script>
</body>
</html>