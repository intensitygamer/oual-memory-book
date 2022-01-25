<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Design-Layouts - Dashboard';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details  = get_project_details( $_GET['project_id'] );
    $user_id_session  = get_user_projects( $_SESSION['user_id'] );
    $all_pages       = get_contributors_all_pages( $_SESSION['user_id'], $_GET['project_id'] );
    $essay_pages      = get_contributors_essay_pages( $_SESSION['user_id'] );
    $get_project_contributors      = get_project_contributors( $_GET['project_id']);
    $get_page_stteings_edit_con_page      = get_page_stteings_edit_con_page(  $_SESSION['user_id'],$_GET['project_id']);

}

?>

<style>


.figure-caption:hover {
 
  background-color: rgba(0, 0, 0, 0.5); /* Black see-through */
  color: #f1f1f1;
  text-align: center;
  padding:20px;
}



</style>

<div class="container-fluid">

    <div class="row">

    	<?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">

        	<div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">

                    	<?php 
                    	$countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

                    	$design_layouts_title = 'Design Layouts';

                    	?>

                        <h2 class="pt-4 pb-2 border-bottom"><?php echo $design_layouts_title;?> 
                          <?php require_once('countdown-timer.php');?>
                        </h2>

                        <div class="row">
                        	
                        	<div id="msg_alert"></div>

  		                    <div class="col-md-12">

  		                    	<?php $collection_project_deadline = date( 'l, F d, Y',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>

  		                    	<div class="row">
                                    
                                    <form method="POST" id="page_arrange_form" >

                                        <!--<button type="button" class="btn btn-success" id="submit_page_arrange">Save & Reload</button>-->
                                        <hr>

                                        <input type="hidden" name="arrange_page_form_check" value="oual_con_arrange_page_form">

                                        <div id="msg_alert"></div>

                                    <div class="row row-cols-1 row-cols-md-3">

                                    	<a href="<?php echo site_url().'/dashboard/?project_id='.$value->project_slug.'&design1_1=true';?>" class="design1">
	                                    	<figure class="figure">
											  <img src="<?=OUAL_NAME_APP;?>dashboard/design/Bloom.jpg" class="figure-img img-fluid rounded image" alt="...">
											  <figcaption class="figure-caption">Bloom 1 - 1st Design</figcaption>
											</figure>
                                        </a>

                                        <a href="<?php echo site_url().'/dashboard/?project_id='.$value->project_slug.'&design1_2=true';?>" class="design2">
	                                    	<figure class="figure">
											  <img src="<?=OUAL_NAME_APP;?>dashboard/design/Bloom1-Pic-Choice2.png" class="figure-img img-fluid rounded" alt="...">
											  <figcaption class="figure-caption">Bloom 1 - 2nd Design</figcaption>
											</figure>
                                        </a>
                                   	
                                   	</div>
		                        	

                            </form>

		                    </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<?php include_once 'footer.php'; ?>

 