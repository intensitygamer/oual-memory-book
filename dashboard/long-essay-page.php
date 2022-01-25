<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: Jewmer T. Villagantol
**/

$page_title = 'Long Essay Page - Collection Page';
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

<!-- Font Aweomse 4 CSS -->
<link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.min.css'>
      
<!-- Rich Text Editor CSS -->
<link rel="stylesheet" href="<?php echo OUAL_NAME_APP;?>assets/css/rich-text-editor.css">

<link href="<?php echo OUAL_NAME_APP;?>assets/css/editor.css" type="text/css" rel="stylesheet"/>
    
<!-- Demo CSS -->
<link rel="stylesheet" href="<?php echo OUAL_NAME_APP;?>assets/css/demo.css">

<div class="container-fluid">

    <div class="row">

        <?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">
            
            <div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">
                        
                        <?php $countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

                          $collection_page_title = 'Collection Pages';
                          $collection_sub_pages = $_GET['collection_pages'];

                        if ( $project_details[0]->project_type == 1 ) {
                          $collection_page_title = $project_details[0]->full_name;
                        }

                        if ( $project_details[0]->project_type == 2 ) {
                          $collection_page_title = $project_details[0]->full_name;
                        }

                        if($collection_sub_pages == 'meme'){
                          $sub_page = 'Create Meme';
                        }

                        if($collection_sub_pages == 'long-essay'){
                          $sub_page = 'Write an Essay';
                        }

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

                              <img class="img-fluid mt-4" src="<?php echo $project_details[0]->project_photo;?>">
                              <label class="form-label" style="font-size:26px; text-transform:uppercase;" ><?php echo $collection_page_title;?></label><br>
                              <label class="form-label" style="font-size:26px; opacity:0.40;" ><?php echo $sub_page;?></label>
                            </div>
                            <br>
                            <div id="msg_alert"></div>
                            <div class="col-md-12" >

                            <form id="oual-essay-page-form" class="form">

                                  <input type="hidden" name="essay_form_check" value="oual_con_essay_page_form">

                                  <input type="hidden" id="current_url" value="<?php echo $current_url;?>">

                                  <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                                  <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                                  <input type="hidden" name="organizer" value="1">


                                <div id="smartwizard">
                                  <ul class="nav">
                                     <li>
                                         <a class="nav-link" href="#step-1">
                                           1. Write your essay.
                                         </a>
                                     </li>
                                     <li>
                                         <a class="nav-link" href="#step-2">
                                           2. Sign your entry.
                                         </a>
                                     </li>
                                     <li>
                                         <a class="nav-link" href="#step-3">
                                           3. Review and Submit.
                                         </a>
                                     </li>
                                    
                                  </ul>

                               

                                  <div class="tab-content">

                                     <div id="step-1" class="tab-pane" role="tabpanel">
                                      <div class="mb-3" align="left">
                                        
                                       <div class="container-fluid">
                                        <div class="row">
                                          
                                          <div class="container">
                                            <div class="row">
                                              <div class="col-lg-12 nopadding">
                                                <textarea id="txtEditor" class="essay_editor" name="essay_editor"></textarea>


                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                   

                                      </div>
                                     </div>

                                     <div id="step-2" class="tab-pane" role="tabpanel">
                                        <br>
                                        <div class="mb-3" align="left">
                                          <label for="exampleFormControlInput1" class="form-label">Name (optional)</label>
                                          <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Add your full or nickname to appearon your entry" name="nickname">
                                        </div>

                                        <div class="mb-3" align="left">
                                          <label for="exampleFormControlInput1" class="form-label">Email (required)</label>
                                          <input type="email" class="form-control" id="email" placeholder="for us to send your confirmation" name="email">
                                        </div>

                                        <div class="form-check" align="left">
                                          <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked="">
                                          <label class="form-check-label" for="flexCheckDefault" >
                                            Join our newsletter for sneak peeks on product launches, memory book tips, and exclusive discounts.
                                          </label>
                                        </div>

                                     </div>
                                     <div id="step-3" class="tab-pane" role="tabpanel" align="left">
                                      <br>
                                        <!--<div class="progress">
                                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                        </div>-->
                                        <br>
                                        <label class="form-check-label" for="flexCheckDefault">
                                           Would you like to share your contribution with others?
                                        </label>
                                        <br><br>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" id="flexRadioDefault1" name="contribute_with_others" value="1">
                                          <label class="form-check-label" for="flexRadioDefault1">
                                            Yes, allow others invited to this project to see my contribution
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" id="flexRadioDefault2" checked name="contribute_with_others" value="2">
                                          <label class="form-check-label" for="flexRadioDefault2">
                                           No, do not allow others invited to this project to see my contribution
                                          </label>
                                        </div>
                                        <hr>
                                        <div align="left">
                                          <button type="button" class="btn btn-success" id="submit_long_essay">Submit</button>
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

    </div>

</div>


<?php include_once 'footer.php'; ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>



<script src="//static.filestackapi.com/filestack-js/3.x.x/filestack.min.js" crossorigin="anonymous"></script>

<script src="<?php echo OUAL_NAME_APP;?>assets/js/jquery.smartWizard.min.js" type="text/javascript"></script>

<script src="<?php echo OUAL_NAME_APP;?>assets/js/editor.js"></script>

<script>
  $(document).ready(function() {
      $("#txtEditor").Editor();
  });
</script>

<script type="text/javascript">

 
  $(document).ready(function(){

    $('#smartwizard').smartWizard({
        selected: 0, // Initial selected step, 0 = first step
        theme: 'default', // theme for the wizard, related css need to include for other than default theme
        justified: true, // Nav menu justification. true/false
        darkMode:false, // Enable/disable Dark Mode if the theme supports. true/false
        autoAdjustHeight: true, // Automatically adjust content height
        cycleSteps: false, // Allows to cycle the navigation of steps
        backButtonSupport: true, // Enable the back button support
        enableURLhash: true, // Enable selection of the step based on url hash
        transition: {
            animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            speed: '400', // Transion animation speed
            easing:'' // Transition animation easing. Not supported without a jQuery easing plugin
        },
        toolbarSettings: {
            toolbarPosition: 'bottom', // none, top, bottom, both
            toolbarButtonPosition: 'right', // left, right, center
            showNextButton: true, // show/hide a Next button
            showPreviousButton: true, // show/hide a Previous button
            toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
        },
        anchorSettings: {
            anchorClickable: true, // Enable/Disable anchor navigation
            enableAllAnchors: false, // Activates all anchors clickable all times
            markDoneStep: true, // Add done state on navigation
            markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
            removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
        },
        keyboardSettings: {
            keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            keyLeft: [37], // Left key code
            keyRight: [39] // Right key code
        },
        lang: { // Language variables for button
            next: 'Next',
            previous: 'Previous'
        },
        disabledSteps: [], // Array Steps disabled
        errorSteps: [], // Highlight step with errors
        hiddenSteps: [] // Hidden steps
    });

    

   // $('.sw-btn-next').attr("disabled", true);
    
    var url = window.location.href;
    var current_url = $('#current_url').val();
    var new_url = current_url+'#step-2';

    $('.sw-btn-next').attr("disabled", true);
   // alert(new_url);
    
    //enable next button if the essay empty
    $( document ).on( 'keyup', '.Editor-editor', function(e) {
      e.preventDefault();
        
        var essay = $('.Editor-editor').html();
        //var essay = $('.essay_editor').val();
        
        if(essay != ''){
          $('.sw-btn-next').attr("disabled", false);
        }
       
     });

    
    // disabled next button on next page
    $( document ).on( 'click', '.sw-btn-next', function(e) {
      e.preventDefault();
        var email = $('#email').val();

        if(new_url == new_url){
          $('.sw-btn-next').attr("disabled", true);
        }
        else{
          //$('.sw-btn-next').attr("disabled", false);
        }

    });

    // disabled next button on next page
    $( document ).on( 'click', '.sw-btn-prev', function(e) {
      e.preventDefault();
        //alert(url);
        //if(new_url == new_url){
          $('.sw-btn-next').attr("disabled", false);
        //}

    });

    function validateEmail(email) {
      var EmailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return EmailRegex.test(email);
    }

    //enable next button after email enter
     $( document ).on( 'keyup', '#email', function(e) {
      e.preventDefault();

        var email = $('#email').val();
       
        if(validateEmail(email) && email != '') {

          $('.sw-btn-next').attr("disabled", false);
        }
        else{
          $('.sw-btn-next').attr("disabled", true);
        }
       
     });

  });
</script>


