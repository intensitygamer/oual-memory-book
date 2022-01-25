<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: Jewmer T. Villagantol
**/

$page_title = 'Edit Cover - Book Layout';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details = get_project_details( $_GET['project_id'] );
    $user_id_session = get_user_projects( $_SESSION['user_id'] );
    $contributors_list = get_project_contributors( $_GET['project_id'] );

}

?>
<link href="<?php echo OUAL_NAME_APP;?>assets/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

<div class="container-fluid">

    <div class="row">

        <?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">
            
            <div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">
                        
                        <?php $countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

                        if ( $project_details[0]->project_type == 1 ) {
                          $front_page_title = $project_details[0]->full_name;
                          $project_back_title = $project_details[0]->project_back_title;
                        }

                        if ( $project_details[0]->project_type == 2 ) {
                          $front_page_title = $project_details[0]->full_name;
                          $project_back_title = $project_details[0]->project_back_title;
                        }

                      

                        $current_url = home_url($_SERVER['REQUEST_URI']);

                        $pro_back_photo = $project_details[0]->project_back_photo;

                        ?>
                        <!--<div class="col-md-12" align="right">
                          <h2 > 
                            <span class="justify-content-end project_timer" data-reg="<?php echo $countdown_timer;?>">
                            </span>
                          </h2>
                        </div>-->
                        
                        <div class="row justify-content-center">
                            
                            <div class="row" align="center">
                              <label class="form-label" style="font-size:30px; text-transform:uppercase;" ><?php echo $front_page_title;?></label>
                            </div>
                             <hr>
                           

                            <form id="oual-edit-cover-page-form" class="form">

                                  <input type="hidden" name="edit_cover_form_check" value="oual_edit_cover_page_form">

                                  <input type="hidden" id="current_url" value="<?php echo $current_url;?>">

                                  <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                                  <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                                  <input type="hidden" name="organizer" value="1">

                            <div class="row" style="margin-bottom: 10px;">
                              <div class="col-sm-2">
                              </div>
                              <div class="col-sm-4">
                                <div class="card">
                                  <div class="card-body" align="center">
                                    <label class="form-label" style="font-size:26px; color:#238efa;" >
                                      Back Cover
                                    </label><hr>
                                      <?php if($pro_back_photo == ''){ ?>

                                        <input type="hidden" name="edit_back_cover_project_photo" id="edit_back_cover_project_photo">
                                          <div class="project-upload-dropzone filestack-filepicker-back-cover-page" style="width:18rem; height:22rem;"> 
                                            <img class="img-fluid" src="<?=OUAL_NAME_APP;?>assets/images/back-cover.png" alt="Upload Project Photo">
                                              <p>Click to update photo.</p>
                                          </div>

                                        <?php }else{?>
                                        <input type="hidden" name="edit_back_cover_project_photo" id="edit_back_cover_project_photo" value="<?php echo $project_details[0]->project_back_photo;?>">
                                        <div class="project-upload-dropzone filestack-filepicker-back-cover-page" style="width:18rem; height:22rem;"> 
                                          <img class="img-fluid" src="<?php echo $project_details[0]->project_back_photo;?>">
                                          <p>Click to update photo.</p>
                                        </div>
                                        <?php } ?>

                                      <h5 class="card-title"><?php echo $project_back_title;?></h5>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="col-sm-4">
                                <div class="card">
                                  <div class="card-body" align="center">
                                    <label class="form-label" style="font-size:26px; color:#238efa;" >
                                      Front Cover
                                    </label><hr>
                                    <input type="hidden" name="edit_front_cover_project_photo" id="edit_back_cover_project_photo" value="<?php echo $project_details[0]->project_photo;?>">

                                    <div class="project-upload-dropzone filestack-filepicker-edit-front-cover-front-page" style="width:18rem; height:22rem;"> 
                                    <img class="img-fluid" src="<?php echo $project_details[0]->project_photo;?>" >
                                     <p>Click to update photo.</p>
                                   </div>

                                   <h5 class="card-title"><?php echo $front_page_title;?></h5>
                                  </div>
                                  
                                </div>
                              </div>

                              <div class="col-sm-2">
                              </div>
                            </div>
                           <div id="msg_alert"></div>
                            <hr>
                            <!--<label class="form-label" style="font-size:26px;" >Front Cover</label>-->
                            
                            <br>
                            <div id="msg_alert"></div>
                            <div class="col-md-12" >

                                  <div class="row">

                                    <div class="col-md-12" >
                                     
                                        <input type="text" name="project_title" class="form-control" value="<?php echo $front_page_title;?>" placeholder="Front Cover Name">
                                    </div>
                                    </br></br>
                                    <div class="col-md-12" >
                                     
                                        <input type="text" name="project_back_title" class="form-control" value="<?php echo $project_back_title;?>" placeholder="Back Cover Name">
                                    </div>

                                  </div>

                                  <br>

                                   <div class="row">  
                                    <div class="col-md-12" align="right">
                                       
                                      <button type="button" class="btn btn-success" id="submit_edit_cover">Submit</button>
                                        
                                    </div>
                                    
                                  </div>

                                

                              </div>

                            </div>
                          </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<?php include_once 'footer.php'; ?>

<script src="//static.filestackapi.com/filestack-js/3.x.x/filestack.min.js" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function(){



  });
</script>


