<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: Jewmer T. Villagantol
**/

$page_title = 'Questionnaire Page - Collection Page';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details    = get_project_details( $_GET['project_id'] );
    $user_id_session    = get_user_projects( $_SESSION['user_id'] );
    $contributors_list  = get_project_contributors( $_GET['project_id'] );
    $get_questions_list      = get_questions();
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

                          $question_page_title = 'Add Questionnaire';
                          
                          $current_url = home_url($_SERVER['REQUEST_URI']);

                        ?>
                        <!--<div class="col-md-12" align="right">
                          <h2 > 
                            <span class="justify-content-end project_timer" data-reg="<?php echo $countdown_timer;?>">
                            </span>
                          </h2>
                        </div>-->
                        
                        <div class="row justify-content-center">
                           
                            <div class="col-md-3" align="center">

                              <label class="form-label" style="font-size:26px; text-transform:uppercase;" >
                                <h1><?php echo $question_page_title;?></h1>
                              </label><br>
                             
                            </div>
                            <hr>
                            <div id="msg_alert"></div>
                            <div class="col-md-12" >

                              <form id="oual-question-page-form" class="form">

                                  <input type="hidden" name="question_form_check" value="oual_question_page_form">

                                  <input type="hidden" name="edit_question_form_check" value="oual_edit_question_page_form">

                                  <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                                   <input type="hidden" name="question_id" id="question_id">

                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Question</label>
                                    <input type="text" class="form-control"  name="question" id="question" placeholder="Write a question">
                                  </div>

                                  <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="button" id="add_question">Add</button>

                                    <button class="btn btn-success" type="button" id="btn_edit_question" style="display:none;">Save</button>
                                  </div>

                                  <hr>

                                  <table class="table table-striped table-hover">
                                    <thead>
                                      <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Question</th>
                                        <th scope="col">Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php 
                                           $i = 1;
                                      if (!empty($get_questions_list)) :

                                          foreach ($get_questions_list as $question) {
                                       ?>
                                      <tr>
                                        <th scope="row"><?php echo $i++; ?></th>
                                        <td><?php echo $question->question;?></td>
                                        <td>

                                          <span class="badge bg-primary">
                                            <a href="" style="color:#fff;" id="edit_question" data-id="<?php echo $question->id;?>" data-name="<?php echo $question->question;?>">Edit</a>
                                          </span>
                                        
                                          <span class="badge bg-danger">
                                            <a href="" style="color:#fff;" id="delete_question" data-id="<?php echo $question->id;?>" data-name="<?php echo $question->question;?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete</a>
                                          </span>

                                        </td>
                                        
                                      </tr>
                                    <?php }
                                      endif;
                                    ?>
                                    </tbody>
                                  </table>
                                 

                                </form>

                              </div>

                            </div>
                          
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog md-lg">
    <div class="modal-content">
    <form id="oual-del-question-page-form" class="form">
      <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">
      <input type="hidden" name="del_question_form_check" value="oual_del_question_page_form">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
        <input type="hidden" name="del_question_id" id="del_question_id">
      </div>
      
      <div class="modal-body" align="center">
        Are you sure you want to delete this?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="btn-del-question">Delete</button>
      </div>
    </form>
    </div>
  </div>
</div>



<?php include_once 'footer.php'; ?>

<script src="//static.filestackapi.com/filestack-js/3.x.x/filestack.min.js" crossorigin="anonymous"></script>

<script src="<?php echo OUAL_NAME_APP;?>assets/js/jquery.smartWizard.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function(){

  //add question 
   $( document ).on( 'click', '#add_question', function(e) {
    e.preventDefault();

      
      var question_form_check = $( '#oual-question-page-form input[name=question_form_check]' ).val();
      var question = $( '#oual-question-page-form input[name=question]' ).val();
      var project_id = $( '#oual-question-page-form input[name=project_id]' ).val();
      $('#add_question').html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span>Loading...</span></button>');

              var post_data = { 

                'question': question,
                'question_form_check': question_form_check

              };

              var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
              var to =    window.location.origin+'/bepi/dashboard/?project_id='+project_id+'&collection_pages=questionnaire';

                  $.ajax({ 
                      method: 'POST',
                      url: ajax_url,
                      data: post_data,
                     success: function(data) { 

                        

                        if(data == 'success'){

                            $('#oual-question-page-form').trigger("reset");
                            $('#add_question').html('Add');
                            $('#msg_alert').html('<div class="alert alert-success" role="alert">New data was added successfully..</div>');
                            $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                              $("#msg_alert").slideUp(500);
                            });

                            setTimeout(function() {
                                 window.location.replace(to);
                            }, 1000);
                    
                        }
                        else{

                            $('#msg_alert').html('<div class="alert alert-danger" role="alert">Sorry!!! Error found..</div>');
                                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                                          $("#msg_alert").slideUp(500);
                                        });
                                       
                        }

                      }
                  });

                  
    });



   //edit question 
   $( document ).on( 'click', '#btn_edit_question', function(e) {
    e.preventDefault();

      
      var edit_question_form_check = $( '#oual-question-page-form input[name=edit_question_form_check]' ).val();
      var question = $( '#oual-question-page-form input[name=question]' ).val();
      var project_id = $( '#oual-question-page-form input[name=project_id]' ).val();
      var question_id = $( '#oual-question-page-form input[name=question_id]' ).val();

      $('#btn_edit_question').html('<button class="btn btn-success" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span>Loading...</span></button>');

              var post_data = { 

                'question': question,
                'question_id': question_id,
                'edit_question_form_check': edit_question_form_check

              };

              var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
              var to =    window.location.origin+'/bepi/dashboard/?project_id='+project_id+'&collection_pages=questionnaire';

                  $.ajax({ 
                      method: 'POST',
                      url: ajax_url,
                      data: post_data,
                     success: function(data) { 

                        if(data == 'success'){

                            $('#oual-question-page-form').trigger("reset");
                            $('#btn_edit_question').html('Add');
                            $('#msg_alert').html('<div class="alert alert-success" role="alert">Data was updated successfully..</div>');
                            $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                              $("#msg_alert").slideUp(500);
                            });

                            setTimeout(function() {
                                 window.location.replace(to);
                            }, 1000);
                    
                        }
                        else{

                            $('#msg_alert').html('<div class="alert alert-danger" role="alert">Sorry!!! Error found..</div>');
                                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                                          $("#msg_alert").slideUp(500);
                                        });
                                       
                        }

                      }
                  });

                  
    });


    $( document ).on( 'click', '#edit_question', function(e) {
    e.preventDefault();
       //s alert('ok');
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        $('#question').val(name);
        $('#question_id').val(id);
        $('#add_question').hide();
        $('#btn_edit_question').show();
    });

    //delete question
     $( document ).on( 'click', '#delete_question', function(e) {
    e.preventDefault();
       //s alert('ok');
        var id = $(this).attr("data-id");
        var name = $(this).attr("data-name");
        $('#del_question_id').val(id);
        $('#staticBackdropLabel').html(name);

    });


     //delete question form
   $( document ).on( 'click', '#btn-del-question', function(e) {
    e.preventDefault();

      
      var del_question_form_check = $( '#oual-del-question-page-form input[name=del_question_form_check]' ).val();
      var project_id = $( '#oual-del-question-page-form input[name=project_id]' ).val();
      var question_id = $( '#oual-del-question-page-form input[name=del_question_id]' ).val();

      $('#btn-del-question').html('<button class="btn btn-danger" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span>Loading...</span></button>');

              var post_data = { 
                'question_id': question_id,
                'del_question_form_check': del_question_form_check

              };

              var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
              var to =    window.location.origin+'/bepi/dashboard/?project_id='+project_id+'&collection_pages=questionnaire';

                  $.ajax({ 
                      method: 'POST',
                      url: ajax_url,
                      data: post_data,
                     success: function(data) { 

                        if(data == 'success'){

                            $('#oual-del-question-page-form').trigger("reset");
                            $('#btn_edit_question').html('Add');
                            $('#msg_alert').html('<div class="alert alert-success" role="alert">Data was deleted successfully..</div>');
                            $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                              $("#msg_alert").slideUp(500);
                            });

                            $("#staticBackdrop").modal('hide');

                            setTimeout(function() {
                                 window.location.replace(to);
                            }, 1000);
                    
                        }
                        else{

                            $('#msg_alert').html('<div class="alert alert-danger" role="alert">Sorry!!! Error found..</div>');
                                        $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                                          $("#msg_alert").slideUp(500);
                                        });
                                       
                        }

                      }
                  });

                  
    });

  });
</script>


