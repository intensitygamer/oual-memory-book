<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Message Contributors - Dashboard';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details = get_project_details( $_GET['project_id'] );
    $user_id_session = get_user_projects( $_SESSION['user_id'] );
    $contributors_list = get_project_contributors( $_GET['project_id'] );

}

?>

<div class="container-fluid">

    <div class="row">

        <?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">
            
            <div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">
                        
                        <?php $countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>

                        <h2 class="mt-4 mb-4">Send a message 
                          <?php require_once('countdown-timer.php');?>
                        </h2>

                        
                        <div class="row justify-content-left">
                          <div class="col-md-12 col-lg-12">

                            <form class="form" id="message-con-form">

                              <input type="hidden" name="form_check" value="oual_msg_contributors">

                              <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                              <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                              <div id="msg_alert"></div>
                              <div class="mb-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Write Your Message</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="E.g Don't forget to submit something!"></textarea>
                              </div>
                              <br>

                              <!--<div class="mb-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Write Your Would you like to include a link to the collection page?</label><br>
                                
                                <input type="radio" class="btn-check" name="col_page" id="link_col_page_yes" autocomplete="off" value="1">
                                <label class="btn btn-outline-success" for="link_col_page_yes">Yes</label>

                                <input type="radio" class="btn-check" name="col_page" id="link_col_page_no" autocomplete="off" value="0">
                                <label class="btn btn-outline-success" for="link_col_page_no">No</label>
                              </div>

                              
                              <div class="mb-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Would you like to include a link to the latest memory book pdf?</label><br>
                                
                                <input type="radio" class="btn-check" name="pdf_book" id="link_pdf_yes" autocomplete="off" value="1">
                                <label class="btn btn-outline-success" for="link_pdf_yes">Yes</label>

                                <input type="radio" class="btn-check" name="pdf_book" id="link_pdf_no" autocomplete="off" value="0">
                                <label class="btn btn-outline-success" for="link_pdf_no">No</label>

                              </div>-->

                             
                              <div class="mb-12">
                                <label for="exampleFormControlTextarea1" class="form-label">Want to see a preview of your message?</label><br>
                                
                               
                                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Enter your email address" ><br>
                                <button type="button" class="btn btn-light" id="message_preview">Send Preview</button>
                              </div>
                            </form>

                             <form class="form" id="mass-message-con-form">

                               <input type="hidden" name="form_check" value="oual_mass_msg_contributors">

                              <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                              <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">
                              <br>
                              <?php if ( $contributors_list ): ?>
                              <div class="mb-12">
                                 <label for="exampleFormControlTextarea1" class="form-label">Select Who Should Receive Your Message</label><br>
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">Email</th>
                                        <th scope="col">Contributed?</th>
                                        <th scope="col">
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                          </div>
                                        </th>
                                      </tr>
                                    </thead>
                                    <tbody id="user-contributors">
                                    <?php foreach ($contributors_list as $value): ?>
                                                <tr>
                                                    
                                                    <td><?php echo $value->email_address;?></td>
                                                    <td>No</td>
                                                    <?php
                                                    switch ( $value->status ) {
                                                        case '2':
                                                            $contributor_status = '<span class="text-success">No Issues</span>';
                                                            break;
                                                        case '3':
                                                            $contributor_status = '<span class="text-success">Active</span>';
                                                            break;
                                                        case '4':
                                                            $contributor_status = '<span class="text-danger">Inactive</span>';
                                                            break;
                                                        default:
                                                            $contributor_status = '<span class="text-muted"> - </span>';
                                                            break;
                                                    }
                                                    ?>
                                                    
                                                  <td><div class="form-check">
                                                   
                                                  <input class="form-check-input" type="checkbox" value="<?php echo $value->email_address;?>" id="flexCheckDefaults" name="mass_email">
                                                </div></td>
                                                </tr>
                                                <?php endforeach ?>
                                      
                                     
                                    </tbody>
                                  </table>
                              </div>
                              <?php endif ?>
                              <div class="col-12 justify-content-right" align="right">
                                <button type="button" class="btn btn-primary" id="mass_message_con">Send Message</button>
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

<script type="text/javascript">
  
        /*function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
        }
    
        $("#message_preview").click(function() { 

              var email = $("#exampleFormControlInput1").val();

              if($("#exampleFormControlInput1").val()==''){

                $('#msg_alert').html('<div class="alert alert-danger" role="alert">Please enter email address..</div>');
                $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                  $("#msg_alert").slideUp(500);
                });
              }

              else{
                  
                  if(validateEmail($("#exampleFormControlInput1").val())){
                
                      var message = $("#exampleFormControlTextarea1").val();
                     // var pdf_link = $("input[name=pdf_book]:checked").val();
                     // var col_page_link = $("input[name=col_page]:checked").val();

                      //alert(col_page_link);
                      var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php',
                      //var ajax_url = '<?php echo admin_url( "admin-ajax.php" ); ?>';
                      
                      $.ajax({ 
                          method: 'POST',
                          url: ajax_url,
                          data: {action: 'message_con_form', email:email, message:message},
                          success: function(data) {

                              //alert(data);
                              //console.log(data);
                              //$('#query_results').html(data);

                              $('#message-con-form').trigger("reset");
                              $('#msg_alert').html('<div class="alert alert-success" role="alert">Email sent successfully..</div>');
                              $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                                $("#msg_alert").slideUp(500);
                              });
                          }
                      });
                  
                  }
                  else{
                      $('#msg_alert').html('<div class="alert alert-danger" role="alert">Please enter a valid email...</div>');
                       $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
                        $("#msg_alert").slideUp(500);
                      });
                    }
              }

         });
         */


</script>