<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Project Dashboard';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details = get_project_details( $_GET['project_id'] );
    $user_id_session = get_user_projects( $_SESSION['user_id'] );
    $contributors_per_proj = get_project_contributors( $_GET['project_id'] );
    
    @$get_con_details = get_con_details( $_SESSION['con_email'] );
    

    if ( $contributors_per_proj ) {
        $count_contributors = count( $contributors_per_proj );
    }

}

$path = $_SERVER["DOCUMENT_ROOT"].'/uploads/';
$url = $_SERVER['HTTP_HOST'].'/uploads/';


//echo $get_user_details->access_level;
?>

<div class="container-fluid">

    <div class="row">

        <?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">
            
            <div class="container">

                <div class="row">
                    <div class="col-md-12 mt-5">
                        
                        <?php $countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>

                        <h2 class="mt-4 mb-4">Submission Dashboard
                        <?php require_once('countdown-timer.php');?>
                        </h2>


                        <!-- Project Details -->
                        <div class="project-details-block mb-5">

                            <div class="row">

                                <div class="col-md-3">
                                        
                                    <img src="<?php echo $project_details[0]->project_photo;?>" alt="Project Featured Image">

                                </div>

                                <div class="col-md-9">

                                    <h3 class="mb-3"><?php echo $project_details[0]->full_name;?></h3>

                                    <div class="row">

                                        <div class="col-md-6">

                                            <p>Status: <span class="badge bg-success">Collecting</span>
                                            <a href="#" class="invite-collab-link" title="Change Status"><i class="fas fa-edit"></i></a>
                                            </p>

                                            <p>Deadline: <span class="project-info-list"><?php echo date('F j, Y',strtotime('+30 days',strtotime( $project_details[0]->project_registered ))) . PHP_EOL;?></span>
                                                <i class="fas fa-question-circle deadline-info" data-bs-toggle="modal" data-bs-target="#deadlineInfo"  title="About Deadline"></i></p>

                                            <p>People Invited: <span class="project-info-list">
                                                <?php if ( !empty( $count_contributors ) ): echo $count_contributors; ?>
                                                <?php else: echo "0"; ?>
                                                <?php endif; ?>
                                                </span>
                                            <a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&contributors=invite';?>" class="invite-collab-link" title="Invite People"><i class="fas fa-paper-plane"></i></a>
                                            </p>

                                        </div>

                                        <div class="col-md-6">
                                            <p>Entries Contributed: <span class="project-info-list">0</span></p>
                                            <p>Unique Contributors: <span class="project-info-list">0</span></p>
                                            <p>Total Pages: <span class="project-info-list">0</span></p>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Contributors Panel -->
                        <h3 class="mt-4">Get more contributions</h3>
                        <p class="mb-3">View your checklist to see what you can accomplish to receive more contributions.</p>

                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <a href="#" class="project-checklist">
                                    <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/compose.png" width="100" height="100" alt="Project Summary">
                                    <p>Add a summary for your project</p>
                                </a>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="#" class="project-checklist">
                                    <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/calendar.png" width="100" height="100" alt="Project Deadline">
                                    <p>Add a deadline for submissions</p>
                                </a>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="#" class="project-checklist">
                                    <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/booklet.png" width="100" height="100" alt="Project Templates">
                                    <p>Choose page templates to allow</p>
                                </a>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&contributors=invite';?>" class="project-checklist">
                                    <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/sent.png" width="100" height="100" alt="Project Invitation">
                                    <p>Invite others to submit pages to your book</p>
                                </a>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="#" class="project-checklist">
                                    <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/photo-gallery.png" width="100" height="100" alt="Project Photo Selection">
                                    <p>Add a custom photo for your project</p>
                                </a>
                            </div>
                            <div class="col-md-4 mt-3">
                                <a href="#" class="project-checklist">
                                    <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/document.png" width="100" height="100" alt="Project Compose">
                                    <p>Create your first page now</p>
                                </a>
                            </div>
                        </div>

                        <h3 class="mt-5">Submitted Contributions</h3>
                        <p class="mb-5">See what others are saying! You can view and edit contributions as you go.</p>

                        <div class="mb-5">

                            <div class="no-invites">
                                <img src="<?php echo OUAL_NAME_APP;?>assets/images/checklist/report.png" width="50" height="50" alt="Email Alert">
                                <p class="mt-3">No pages yet. <a href="#">Invite others</a> to create pages or <a href="#">create your first</a> page.</p>
                            </div>
                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

 <input type="hidden" name="access_level" id="access_level" value="<?php echo $get_user_details->access_level;?>">
<!-- Question List -->
<div class="modal fade" id="QuestionList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
    <form id="oual-save-question-page-form" class="form">
      <input type="hidden" name="user_con_email" id="user_con_email" value="<?php echo $_SESSION['con_email'];?>">
      <input type="hidden" name="contributor_id" id="contributor_id" value="<?php echo $get_con_details->id;?>">
      <input type="hidden" name="project_id" id="project_id" value="<?php echo $_GET['project_id'];?>">

      <input type="hidden" name="save_question_form_check" value="oual_save_question_page_form">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Questionnaire</h5>
        <input type="hidden" name="save_question_id" id="save_question_id">
      </div>
      <div id="msg_alert"></div>
      <div class="modal-body" align="center">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label" style="float:left;">Love One's Name</label>
            <input type="text" class="form-control"  name="love_one" id="love_one" placeholder="Write a your love one's name">
        </div>
        <hr>
        <div id="question_content"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_save_question">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal For Deadline Information -->
<div class="modal fade" id="deadlineInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deadlineInfoLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deadlineInfoLabel">Project Deadline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>The deadline by default for every project is setup for <strong>30 days</strong> from date of registration.</p>

                <p>We’ll send messages on your behalf reminding contributors to submit their memories leading up to the date.</p>

                <p>We also send reminders as the deadline approaches. Reminders are sent <strong>3 weeks</strong>, <strong>2 weeks</strong>, <strong>1 weeks</strong>, <strong>3 days</strong>, <strong>1 days</strong> from the deadline.</p>

                <p>Please do not be alarmed. We don’t want anyone blocked at this 30 days, we just want to encourage contributors to have their contributions completed within the 30 days.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>

<script type="text/javascript">
  $(document).ready(function(){

            var user_email = $( '#user_con_email' ).val();
            var access_level = $( '#access_level' ).val();

            if(access_level != 1 || access_level != 2)
            {

                var post_data = { 

                    'user_email': user_email

                };

              var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
             
                  $.ajax({ 
                      method: 'GET',
                      url: ajax_url,
                      data: post_data,
                     success: function(data) { 
                        
                        if(data == 'success'){

                            $('#QuestionList').modal("show");

                            $('#question_content').html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Loading...</span></button>');

                            var get_data = { 'get_ques': 1 };

                            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
             
                              $.ajax({ 
                                  method: 'GET',
                                  url: ajax_url,
                                  data: get_data,
                                 success: function(data) { 
                                    
                                    $('#question_content').html(data);
                                }
                            
                              });
                        }
                        else{

                            $('#question_content').html('<div class="alert alert-danger" role="alert">No data has been found..</div>');
                                $("#question_content").fadeTo(2000, 500).slideUp(500, function() {
                                $("#question_content").slideUp(500);
                            });
                                       
                        }

                      }
                  });

            }

  });
</script>