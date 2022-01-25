<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Collection Pages - Dashboard';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details = get_project_details( $_GET['project_id'] );
    $user_id_session = get_user_projects( $_SESSION['user_id'] );
    $get_user_detail = get_user_details( $_SESSION['user_id'] );

}

?>

<div class="container-fluid">

    <div class="row">

    	<?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">

        	<div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">

                    	<?php 
                    	$countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

                    	$collection_page_title = 'Collection Pages';

                    	if ( $project_details[0]->project_type == 1 ) {
                    		$collection_page_title = "In Loving Memory of ".$project_details[0]->full_name;
                    	}

                    	if ( $project_details[0]->project_type == 2 ) {
                    		$collection_page_title = "Celebration of Life ".$project_details[0]->full_name;
                    	}

                    	?>

                        <h2 class="pt-4 pb-2 border-bottom"><?php echo $collection_page_title;?>
                          <?php require_once('countdown-timer.php');?>
                        </h2>
                       
                        <div class="row">
                        	
                        	<div class="col-md-4">

		                    	<img class="img-fluid mt-4" src="<?php echo $project_details[0]->project_photo;?>">

		                    </div>
		                    <div class="col-md-8">

		                    	<?php $collection_project_deadline = date( 'l, F d, Y',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>

		                    	<h3 class="text-center mt-4 fw-normal">Add contributions by picking from template options below. They will be included in a memory book created by the group. The deadline for contributions is <?php echo $collection_project_deadline;?>
                                    
                                </h3>
                                <br>
		                    	<div class="row">
                                    
                                   
                            	       <div class="card" style="width: 20rem; height:24rem;  margin-right:10px; margin-bottom:10px;">
                                          <img src="<?php echo OUAL_NAME_APP;?>assets/images/layouts/create_meme.jpg" class="card-img-top" alt="..." style="height:260px;">
                                          <div class="card-body">
                                            <h5 class="card-title"><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&collection_pages=meme';?>"<?php if ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'meme' ) echo ' class="menu-link-active"'; ?> class="btn btn-primary">Meme</a></h5>
                                            <p class="card-text">Generate text over fun pictures</p>
                                            
                                          </div>
                                        </div>

                                         <div class="card" style="width: 20rem; height:24rem; margin-right:10px; margin-bottom:10px;">
                                          <img src="<?php echo OUAL_NAME_APP;?>assets/images/layouts/long-essay.jpg" class="card-img-top" alt="..." style="height:260px;">
                                          <div class="card-body">
                                            <h5 class="card-title"><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&collection_pages=long-essay';?>"<?php if ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'long-essay' ) echo ' class="menu-link-active"'; ?> class="btn btn-primary">Long Essay</a></h5>
                                            <p class="card-text">For longer messages and life stories</p>
                                            
                                          </div>
                                        </div>
                                        
                                        <div class="card" style="width: 20rem; height:24rem; margin-right:10px; margin-bottom:10px;">
                                          <img src="<?php echo OUAL_NAME_APP;?>assets/images/layouts/design-layouts.jpg" class="card-img-top" alt="..." style="height:300px;">
                                          <div class="card-body">
                                            <h5 class="card-title"><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&design_layout=true';?>"<?php if ( isset( $_GET['design_layout'] ) && $_GET['design_layout'] == 'true' ) echo ' class="menu-link-active"'; ?> class="btn btn-primary">Design Layouts</a></h5>
                                            <p class="card-text">Select pre-formatted page layouts</p>
                                            
                                          </div>
                                        </div>
                                        <?php if($get_user_detail->access_level == 2){?>
                                         <div class="card" style="width: 20rem; height:24rem; margin-right:10px; margin-bottom:10px;">
                                          <img src="<?php echo OUAL_NAME_APP;?>assets/images/layouts/questionnaire.jpg" class="card-img-top" alt="..." style="height:260px;">
                                          <div class="card-body">
                                            <h5 class="card-title"><a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&collection_pages=questionnaire';?>"<?php if ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'questionnaire' ) echo ' class="menu-link-active"'; ?> class="btn btn-primary">Questionnaire</a></h5>
                                            <p class="card-text">Write your own question here..</p>
                                            
                                          </div>
                                        </div>
                                      <?php }?>
				                   

				                  
				                   
				                  

		                        </div>

		                    </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include_once 'footer.php'; ?>