<?php
	$title = 'Login'; 
	include( '../includes/login_header.php' );
?>
<body class="bg-secondary">
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-6">
			<div class="o-hidden shadow-lg my-10">
				<div class="card">
					<div class="card-header text-center">
						<img src="<?= BASE_URL ?>/assets/images/Logo-removebg-preview.png" alt="Outlendars" class="mb-2"/>
						<h3>Sign In</h3>
					</div>
					<div class="card-body">
						<div class="formWrapper">
							<form class="needs-validation" novalidate method="post">
								<div class="input-group form-group">
									<input type="email" id="emailaddress" name="emailaddress" class="form-control custom-input" placeholder="Email">						
								</div>
								<div class="input-group form-group">
									<input type="password" id="password" minlength="4" name="password" class="form-control custom-input" placeholder="Password">
								</div>
								<div class="form-group">
									<button type="button" id="submit" name="submit" value="Login" onclick="login();" class="btn btn-outlendars float-right shadow-sm">LOGIN</button>
								</div>
								<a href="/forget_password" class="text-outlendars pl-1">Forget Password</a>
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
<script src="<?= BASE_URL ?>/assets/js/app/login.js"></script>
</body>
</html>