<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Start new project';
$body_class = ' new-project';

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

        <title><?php echo $page_title;?> | Once Upon A Legacy</title>
    </head>
    <body class="memory_book_body<?=$body_class;?>">

		<nav class="navbar">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="<?=OUAL_NAME_APP;?>assets/images/company-logo.png" alt="Once Upon A Legacy Logo" width="175">
				</a>
			</div>
		</nav>


		<div class="oual-form-container">
			<div class="container oual-main-content mt-5">
				<div class="row">
					<div class="col-6">
						<h1>Start your project</h1>
						<p>We need some basic details to get your project started that help people know how to contribute.</p>
					</div>
				</div>
			</div>


			<div class="container mt-5">
				<div class="row">

					<div class="col-6">

						<form class="oual_new_project_form" method="post">

							<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']?>">

							<div class="mb-3">
								<label for="user_project_heading" class="col-form-label-lg">Choose Heading</label>
								<select class="form-select form-select-lg mb-3" id="user_project_heading" name="user_project_heading">
									<option value="1" selected>In loving memory of</option>
									<option value="2">Celebration of Life</option>
								</select>
							</div>

							<div class="mb-3">
								<label for="user_project_fullname" class="col-form-label-lg">Full Name</label>
								<input type="text" class="form-control form-control-lg" id="user_project_fullname" name="user_project_fullname" placeholder="Please provide fullname here" required>
							</div>

							<div class="mb-3">
								<label for="user_project_dob" class="col-form-label-lg">Date Of Birth</label>
								<input type="date" class="form-control form-control-lg" id="user_project_dob" name="user_project_dob" required>
							</div>

							<div class="mb-3">
								<label for="user_project_dod" class="col-form-label-lg">Date Of Death</label>
								<input type="date" class="form-control form-control-lg" id="user_project_dod" name="user_project_dod" required>
							</div>

							<div class="mb-4">
								<input type="hidden" name="user_project_photo">
								<label for="user_project_photo" class="col-form-label-lg">Project Photo</label>
								<div id="user_project_photo" class="form-text">Choose a photo to represent your project. We’ll show it when we invite others to participate! </div>

								<div class="project-upload-dropzone filestack-filepicker">
									<img src="<?=OUAL_NAME_APP;?>assets/images/edit-image.png" alt="Upload Project Photo" width="65">
									<p>Click to upload a photo</p>
								</div>
							</div>

							<div class="row">
								<div class="col-4">
									<div class="d-grid">
										<button class="btn btn-primary btn-lg submit_project" type="submit">Start Project</button>
									</div>
								</div>
							</div>

						</form>

					</div>

				</div>

			</div>
		</div>

		<footer class="bg-light text-muted mt-5">
			<div class="oual-plg-footer text-center p-4">
				&copy; <?=date('Y');?> Copyright: <a href="https://onceuponalife-time.com/">Once Upon A Legacy</a>. All rights reserved.
			</div>
		</footer>

		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

		<script src="//static.filestackapi.com/filestack-js/3.x.x/filestack.min.js" crossorigin="anonymous"></script>

		<script type="text/javascript" src="<?=OUAL_NAME_APP;?>assets/js/front.js"></script>
		
	</body>

</html>
		