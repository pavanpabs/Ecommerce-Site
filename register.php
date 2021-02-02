<?php include 'db/db.php' ?>

<?php include 'includes/refs.php' ?>
<?php include 'includes/header.php' ?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
	<div class="container h-100">
		<div class="blog-banner">
			<div class="text-center">
				<h1>Register</h1>
				<nav aria-label="breadcrumb" class="banner-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Register</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</section>
<!-- ================ end banner area ================= -->

<!--================Login Box Area =================-->
<section class="login_box_area section-margin">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="login_box_img">
					<div class="hover">
						<h4>Already have an account?</h4>
						<p></p>
						<a class="button button-account" href="login.php">Login Now</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner register_form_inner">
					<h3>Create an account</h3>
					<form class="row login_form" action="" id="register_form" method="POST">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="name" name="name" placeholder="Calling Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
						</div>
						<div class="col-md-12 form-group">
							<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'">
						</div>
						<div class="col-md-12 form-group">
							<div class="creat_account">
								<input type="checkbox" id="f-option2" name="selector">
								<label for="f-option2">Keep me logged in</label>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<button type="submit" name="submit" id="submit" class="button button-register w-100">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================End Login Box Area =================-->



<!--================ Start footer Area  =================-->
<?php include 'includes/footer.php' ?>
<script>
	$(document).ready(function() {

		$('#submit').click(function(e) {
			e.preventDefault();

			if ($('#password').val() == $('#confirmPassword').val()) {
				$.ajax({

					method: "POST",
					url: "ajax/addUser.php",
					data: $('#register_form').serialize(),
					success: function(data) {
						if (data == 1) {
							toastr.success(
								'', 'You have registered successfully!', {
									timeOut: 2500,
									onHidden: function() {
										window.location.replace('login.php');
									}
								}
							);
						} else if (data = 2) {
							toastr.info("You have already registered!");
						}

					}
				});
			} else {
				$('#password').val(null);
				$('#confirmPassword').val(null);
				toastr.error("Please confirm your password!");

			}


		});

	});
</script>