<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Preview & Design Layouts - Dashboard';
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

#download-button{
  position: fixed;
  right: 5%;
  bottom: 2%;
  z-index: 1000;
  transform: rotate(360deg);
  -webkit-transform: rotate(360deg);
  -moz-transform: rotate(360deg);
  -o-transform: rotate(360deg);
 filter: progid: dximagetransform.microsoft.basicimage(rotation=3);
  text-align: center;
  text-decoration: none;
}

</style>

<div class="container-fluid">

    <div class="row">

    	<?php //include_once 'sidebar.php'; ?>
        <div class="dashboard-content">

        	<div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">

                    

                        <div class="row">
                        	
                          <form method="POST" id="page_arrange_form" >

                        	<div id="msg_alert"></div>

  		                   
                          <div id="download-button">

                            <button type="button" class="btn btn-success" id="submit_page_arrange" style="">Download PDF</button>
                            
                            <input type="hidden" name="arrange_page_form_check" value="oual_con_arrange_page_form">

                          </div>

                            <div id="msg_alert"></div>

  		                    	
                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom1-Pic-Choice2.png'); ">
                                
                            </div>
                            
                            <hr>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom 2- Pic-Choice 2.png'); ">
                                
                            </div>

                            <hr>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom-3-Pic-Choice-2.png'); ">
                                
                            </div>

                            <hr>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom-4-Pic-Choice-2.png'); ">
                                
                            </div>

                            <hr>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Long-Essay-Choice-2.png'); ">
                                
                            </div>


                            <hr>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Meme.png'); ">
                                
                            </div>

                            <hr>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Questionaire-With-Photo.png'); ">
                                
                            </div>

                      </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<?php include_once 'footer.php'; ?>

 