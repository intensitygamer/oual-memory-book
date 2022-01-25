<?php
if (!defined('ABSPATH')) exit;
/**
* Template Name: Memory Book Login Page Template
*
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
*/

global $post;

$post = get_post( $post->ID ); 
$content = apply_filters('the_content', $post->post_content);

$cookie_user_email = '';
$cookie_user_pass = '';



if ( isset( $_COOKIE['user_email'] ) && isset( $_COOKIE['user_password'] )  ) {
	$cookie_user_email = ( !empty( $_COOKIE['user_email'] ) ) ? ' value="'.$_COOKIE['user_email'].'"' : '';
	$cookie_user_pass = ( !empty( $_COOKIE['user_password'] ) ) ? ' value="'.$_COOKIE['user_password'].'"' : '';
}



session_start();
if ( !empty( $_SESSION['user_id'] ) ) {

	$current_user = $_SESSION['user_id'];
	@$con_email = $_SESSION['con_email'];
	$db_project_id = $_SESSION['db_project_id'];

	$user_project_table = $wpdb->prefix . 'memory_book_projects';
	$check_user_projects = $wpdb->get_results( "SELECT * FROM $user_project_table WHERE `user_id` = '$current_user'" );

	if ( $check_user_projects ) {

		if ( count( $check_user_projects ) > 1 ) {
			if(!empty($con_email)){
				header( 'Location: dashboard/?project_id='.$db_project_id.'&dashboard=true' );
			}
			else{
				header( 'Location: dashboard/?project_status=projects' );
			}
			
		} else {
			header( 'Location: dashboard/?project_id='.$check_user_projects[0]->project_slug.'&dashboard=true' );
		}

	} else {
		header( 'Location: dashboard/?project_status=new');
	}

}

?>

<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
		<link rel="stylesheet" type="text/css" href="<?=OUAL_NAME_APP;?>assets/css/plugin.css">

		<title>Log in | Once Upon A Legacy</title>
	</head>
	<body class="memory_book_body login">

		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="<?=OUAL_NAME_APP;?>assets/images/company-logo.png" alt="Once Upon A Legacy Logo" width="125">
				</a>

				<ul class="nav d-flex align-items-center">
					<?php if ( is_user_logged_in() ) edit_post_link('Edit Page', '<li class="nav-item">', '</li>'); ?>
					<li class="nav-item">
						<a class="nav-link" href="../login">Log in</a>
					</li>
					<li class="nav-item">
						<a class="btn btn-secondary oual-plg-btn-lg" href="../sign-up" role="button">Get Started</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="oual-form-container">
			<div class="container oual-main-content mt-5">
				<div class="row">
					<h1><?=$post->post_title?></h1>

					<?=$content;?>
				</div>
			</div>


			<div class="container mt-5">
				<div class="row">

					<div class="col-6">

						<form class="oual_form_front" method="post">
							<input type="hidden" name="form_check" value="oual_login">

							<div class="mb-3">
								<label for="user_email" class="col-form-label-lg">Email Address</label>
								<input type="email" class="form-control form-control-lg" id="user_email" name="user_email" placeholder="johndoe@onceuponalegacy.com"<?=$cookie_user_email;?> required>
							</div>
							<div class="mb-3">
								<label for="user_password" class="col-form-label-lg">Password</label>
								<input type="password" id="user_password" name="user_password" autocomplete="user_password" class="form-control form-control-lg mb-2" spellcheck="false" autocorrect="off" autocapitalize="none"<?=$cookie_user_pass;?> required="" placeholder="••••••••">
								
								<div class="row">
									<div class="col-12 d-flex justify-content-end">
										<a href="javascript:void(0);" class="show_pass"> 
											<i class="far fa-eye"></i>
											<span>Show</span>
										</a>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-4">
									<div class="d-grid">
										<button class="btn btn-primary btn-lg submit_login" type="submit">Log in</button>
									</div>
								</div>
								<div class="col-8 d-flex align-items-center">
									<div class="form-check">
										<input type="checkbox" class="form-check-input" id="remember_user" name="remember_user" value="1">
										<label class="form-check-label" for="remember_user">Remember Me</label>
									</div>
								</div>
							</div>

						</form>

					</div>

				</div>

			</div>
		</div>
		
		<footer class="bg-light text-muted mt-5">

			<section>
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-lg-5 col-xl-4 mt-4 mb-4">
							<a class="ouap-footer-brand mb-2" href="#">
								<img src="https://onceuponalife-time.com/wp-content/uploads/2021/06/Legacy_logo_PNG-01-300x185.png" alt="Once Upon A Legacy Logo" width="125">
							</a>
							<p>Collect, collaborate with family, friends and colleages into building the greatest Legacy Book that will last throughout generations.</p>
						</div>
						<div class="col-md-3 col-lg-4 col-xl-3 mt-4 mb-4 oual-footer-nav">
							<h5>Explore</h5>

							<p><a href="#!">Home</a></p>
							<p><a href="#!">About Us</a></p>
							<p><a href="#!">Documentations</a></p>
							<p><a href="#!">Tutorials</a></p>
							<p><a href="#!">Contact Us</a></p>
						</div>
						<div class="col-md-5 col-lg-6 col-xl-5 mt-4 mb-4">
							<h5>Subscribe to our newsletter </h5>
							<form class="form_subscription">

								<div class="mt-3 mb-2">
									<input type="email" class="form-control" placeholder="Enter your email here">
								</div>

								<div class="row d-flex justify-content-end">
									<div class="col-4">
										<div class="d-grid">
											<button type="button" class="btn btn-secondary">Subscribe</button>
										</div>
									</div>
								</div>

							</form>

							<section class="mt-3 d-flex justify-content-end">
								<a class="btn btn-outline-secondary btn-floating m-1" href="#!" role="button">
									<i class="fab fa-facebook-f"></i>
								</a>
								<a class="btn btn-outline-secondary btn-floating m-1" href="#!" role="button">
									<i class="fab fa-twitter"></i>
								</a>
								<a class="btn btn-outline-secondary btn-floating m-1" href="#!" role="button">
									<i class="fab fa-instagram"></i>
								</a>
							</section>
						</div>
					</div>
				</div>
			</section>

			<div class="oual-plg-footer text-center p-4">
				&copy; <?=date('Y');?> Copyright: <a href="https://onceuponalife-time.com/">Once Upon A Legacy</a>. All rights reserved.
			</div>
		</footer>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		
		<script type="text/javascript" src="<?=OUAL_NAME_APP;?>assets/js/front.js"></script>

	</body>
</html>