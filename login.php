<?php
// Start the session
session_start();
?>
<?php include 'db/db.php' ?>
<?php include 'includes/refs.php' ?>
<?php 
    if(isset($_POST['loginSub'])){
        $userName=$_POST['name'];
        $pass=$_POST['password'];
    
    $sql="SELECT * FROM user u,userlogin l WHERE l.uId=u.uID AND l.password='$pass' AND l.email='$userName'";
    $run=mysqli_query($con,$sql);
    $count=mysqli_num_rows($run);
    while($row=mysqli_fetch_assoc($run)){
        $userId=$row['ID'];
		$userName=$row['username'];
		$role=$row['role'];
    }
    if($count==1){
        $_SESSION['username']=$userName;
		$_SESSION['userID']=$userId;
		$_SESSION['role']=$role;
		
	if(isset($_GET['redirect'])){
		if(isset($_GET['prd'])){
			header('Location:./'.$_GET['redirect'].'?prd='.$_GET['prd']);
		}else{
			header('Location:./'.$_GET['redirect']);
		}
    }else{
		header('Location:./index.php');
	}
    }
	}
?>
<?php include 'includes/header.php' ?>
  <!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Login / Register</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Login/Register</li>
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
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="button button-account" href="register.php">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" method="post" action="" id="contactForm" >
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit"  name="loginSub" class="button button-login w-100">Log In</button>
								<a href="#">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->


	<?php include 'includes/footer.php' ?>