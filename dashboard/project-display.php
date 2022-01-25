<?php
if (!defined('ABSPATH')) exit;
/**
* Template Name: Memory Book Login Page Template
*
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
*/

if ( !empty( $_SESSION['user_id'] ) ) {

	$current_user = $_SESSION['user_id'];

	$user_project_table = $wpdb->prefix . 'memory_book_projects';
	$check_user_projects = $wpdb->get_results( "SELECT * FROM $user_project_table WHERE `user_id` = '$current_user'" );


	if ( $check_user_projects ) {

		if ( count( $check_user_projects ) == 1 ) {
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

		<title>Project Display | Once Upon A Legacy</title>
	</head>
	<body class="memory_book_body">

		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="<?=OUAL_NAME_APP;?>assets/images/company-logo.png" alt="Once Upon A Legacy Logo" width="125">
				</a>

				<ul class="nav d-flex align-items-center">
					<li class="nav-item">
						<a class="btn btn-danger" href="<?php echo site_url();?>/dashboard/?logout=true" role="button"><i class="fas fa-sign-out-alt"></i> Logout</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="container mt-5">

			<div class="row">

				<h1 class="mb-4 list-display-heading">List of Projects</h1>
				
				<?php if ( $check_user_projects ) {

					foreach ($check_user_projects as $value) { ?>
				
					<div class="display-project-card">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title mb-4"><?php echo $value->full_name;?></h5>
								<p class="card-text">
									<span class="cart-text-head">Project Status: </span>
									<span class="badge bg-success">Collecting</span>
								</p>
								<p class="card-text">
									<span class="cart-text-head">Project Deadline: </span><?php echo date('F j, Y',strtotime('+30 days',strtotime( $value->project_registered ))) . PHP_EOL;?>
								</p>
								<a href="<?php echo site_url().'/dashboard/?project_id='.$value->project_slug.'&dashboard=true';?>" class="btn btn-primary mt-3">View Project</a>
							</div>
						</div>
					</div>

				<?php
					}

				} ?>
				
			</div>
			
		</div>

		<footer class="bg-light text-muted display-card-footer">
			<div class="oual-plg-footer text-center p-4">
				&copy; <?=date('Y');?> Copyright: <a href="https://onceuponalife-time.com/">Once Upon A Legacy</a>. All rights reserved.
			</div>
		</footer>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

		<script src="//static.filestackapi.com/filestack-js/3.x.x/filestack.min.js" crossorigin="anonymous"></script>

		<script type="text/javascript" src="<?=OUAL_NAME_APP;?>assets/js/front.js"></script>

	</body>
</html>