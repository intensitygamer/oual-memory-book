<div class="dashboard-sidebar bg-light">
	
	<div class="dashboard-logo" >
		<a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&dashboard=true';?>">
			<img src="<?php echo OUAL_NAME_APP;?>assets/images/company-logo.png" alt="Once Upon A Legacy Logo" width="150">
		</a>
	</div>

	<a class="menu-project-display" data-bs-toggle="collapse" href="#chooseProject">
		<div class="menu-project-media">
			<img src="<?php echo $project_details[0]->project_photo;?>" width="45">
		</div>
		<p><?php echo $project_details[0]->full_name;?></p>
	</a>
	<div class="collapse mb-3" id="chooseProject">
		<div class="card card-body">
			<p>Select a project</p>
			<?php foreach ( $user_id_session as $value ): ?>
				<?php if ( !empty( $_GET['project_id'] ) ) {
					if ( $value->project_slug == $_GET['project_id'] ) {
						$project_active = ' project-active';
					} else {
						$project_active = '';
					}
				}?>
				<a class="choose-project<?php echo $project_active;?>" href="<?php echo site_url().'/dashboard/?project_id='.$value->project_slug.'&dashboard=true';?>">
					<div class="menu-project-media">
						<img src="<?php echo $value->project_photo;?>" width="45">
					</div>
					<p><?php echo $value->full_name;?></p>
				</a>
			<?php endforeach ?>
			<a href="<?php echo site_url();?>/dashboard/?project_status=new" class="btn btn-primary" role="button">Start Project</a>
		</div>
	</div>

	<div class="project-menu-nav mt-4 mb-4">
		<h4 class="mb-3">Content</h4>
		<ul>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&dashboard=true';?>"<?php if ( isset( $_GET['dashboard'] ) && $_GET['dashboard'] == 'true' ) echo ' class="menu-link-active"'; ?>>View Dashboard</a></li>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&collection_pages=true';?>"<?php if ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'true' ) echo ' class="menu-link-active"'; ?>">Add Content</a></li>
		</ul>
		<h4 class="mb-3">Collection Page</h4>
		<ul>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&collection_pages=true';?>"<?php if ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'true' ) echo ' class="menu-link-active"'; ?>>View Collection Page</a></li>
			<!-- <li><a href="#">Edit Project Options</a></li> -->
		</ul>
		
		<?php if(@$get_user_details->access_level == 1 || @$get_user_details->access_level == 2 ){?>

		<h4 class="mb-3">Contributors</h4>
		<ul>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&contributors=invite';?>"<?php if ( isset( $_GET['contributors'] ) && $_GET['contributors'] == 'invite' ) echo ' class="menu-link-active"'; ?>>Invite Contributors</a></li>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&contributors=message';?>"<?php if ( isset( $_GET['contributors'] ) && $_GET['contributors'] == 'message' ) echo ' class="menu-link-active"'; ?>">Message Contributors</a></li>
		</ul>
		<h4 class="mb-3">Book Layout</h4>
		<ul>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&design_layout=true';?>"<?php if ( isset( $_GET['design_layout'] ) && $_GET['design_layout'] == 'true' ) echo ' class="menu-link-active"'; ?>">Design Layout</a></li>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&arrange_pages=true';?>"<?php if ( isset( $_GET['arrange_pages'] ) && $_GET['arrange_pages'] == 'true' ) echo ' class="menu-link-active"'; ?>">Preview & Arrange Pages</a></li>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&contributors_list=true';?>"<?php if ( isset( $_GET['contributors_list'] ) && $_GET['contributors_list'] == 'true' ) echo ' class="menu-link-active"'; ?>">Edit Contributor List</a></li>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&edit_cover=true';?>"<?php if ( isset( $_GET['edit_cover'] ) && $_GET['edit_cover'] == 'true' ) echo ' class="menu-link-active"'; ?>">Edit Cover</a></li>
		</ul>
		<h4 class="mb-3">Project Wrap Up</h4>
		<ul>
			<li><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&create_pdf=true';?>"<?php if ( isset( $_GET['create_pdf'] ) && $_GET['create_pdf'] == 'true' ) echo ' class="menu-link-active"'; ?>">Download PDF</a></li>
			<!--<li><a href="#">Share PDF</a></li>-->
		</ul>
	<?php }?>
	</div>

	<div class="d-grid gap-2 mb-5">
		<a href="<?php echo site_url();?>/dashboard/?logout=true" class="btn btn-danger" role="button"><i class="fas fa-sign-out-alt"></i> Logout</a>
	</div>

</div>