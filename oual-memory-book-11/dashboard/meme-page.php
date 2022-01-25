<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: Jewmer T. Villagantol
**/

$page_title = 'Meme Page - Collection Page';
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
<link rel="stylesheet" href="https://static.filestackapi.com/transforms-ui/2.x.x/transforms.css" />

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

                            <form id="oual-meme-page-form" class="form">

                                  <input type="hidden" name="meme_form_check" value="oual_con_meme_page_form">

                                  <input type="hidden" id="current_url" value="<?php echo $current_url;?>">

                                  <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                                  <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                                  <input type="hidden" name="organizer" value="1">


                                <div id="smartwizard">
                                  <ul class="nav">
                                     <li>
                                         <a class="nav-link" href="#step-1">
                                           1. Enter your Meme.
                                         </a>
                                     </li>
                                     <li>
                                         <a class="nav-link" href="#step-2">
                                           2. Sign your Meme.
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

                                          <input type="hidden" name="meme_project_photo" id="meme_project_photo">
                                          
                                          <div class="meme-container">
	                                          <div class="project-upload-dropzone filestack-filepicker-meme-page"> 
	                                            <img src="<?=OUAL_NAME_APP;?>assets/images/edit-image.png" alt="Upload Project Photo" width="300" id="uploadImage">
	                                            <div class="top_text"></div>
	                                            <div class="bottom_text"></div>
	                                            <p>Click to Add a picture for your Meme.</p>
	                                          </div>

	                                          <!--<input type="file" id="demoFile"/>-->

											<div style="text-align:center;">
											  	<img id="result" style="width:600px" />
											</div>

                                     	 </div>

                                      </div>

                                        <!--<label align="left">Top line for meme (required)</label>
                                        <input type="text" class="form-control" id="top_line_meme" placeholder="Top line for meme" name="top_line_meme" required="">
                                        <br>
                                        <label align="left">Bottom line for meme (required)</label>
                                        <input type="text" class="form-control" id="bottom_line_meme" placeholder="Bottom line for meme" name="bottom_line_meme">
                                        <br>-->
                                        <div class="d-grid gap-2">
                                        	<button class="btn btn-outline-primary" id="save_text">Add Text</button>
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
                                          <button type="button" class="btn btn-success" id="submit_meme">Submit</button>
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

<script src="//static.filestackapi.com/filestack-js/3.x.x/filestack.min.js" crossorigin="anonymous"></script>

<script src="https://static.filestackapi.com/transforms-ui/2.x.x/transforms.umd.min.js"></script>

<script src="<?php echo OUAL_NAME_APP;?>assets/js/jquery.smartWizard.min.js" type="text/javascript"></script>

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

    


    $('.sw-btn-next').attr("disabled", true);
    $('#save_text').attr("disabled", true);

    var url = window.location.href;
    var current_url = $('#current_url').val();
    var new_url = current_url+'#step-2';

    //alert(url);
    
    
    //enable next button if the topline and bottom line and picture is not empty
    $( document ).on( 'keyup', '#top_line_meme', function(e) {
      e.preventDefault();

        var top_line = $('#top_line_meme').val();
        var bottom_line_meme = $('#bottom_line_meme').val();
        var meme_project_photo = $('#meme_project_photo').val();
        $('.top_text').html(top_line);

        if(top_line != '' && meme_project_photo != '' && bottom_line_meme != ''){
          $('.sw-btn-next').attr("disabled", false);
        }
       
     });

    //enable next button if the topline and bottom line and picture is not empty
    $( document ).on( 'keyup', '#bottom_line_meme', function(e) {
      e.preventDefault();

        var top_line = $('#top_line_meme').val();
        var bottom_line_meme = $('#bottom_line_meme').val();
        var meme_project_photo = $('#meme_project_photo').val();
        $('.bottom_text').html(bottom_line_meme);

        if(top_line != '' && meme_project_photo != '' && bottom_line_meme != ''){
          $('.sw-btn-next').attr("disabled", false);
        }
       
     });

    // disabled next button on next page
    $( document ).on( 'click', '.sw-btn-next', function(e) {
      e.preventDefault();

        //if(url == current_url){
          $('.sw-btn-next').attr("disabled", true);
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
       
        if(validateEmail(email)) {

          $('.sw-btn-next').attr("disabled", false);
        }
        else{
          $('.sw-btn-next').attr("disabled", true);
        }
       
     });


     $( document ).on( 'click', '#save_text', function(e) {
      e.preventDefault();


      				var FILE_URL = $('#meme_project_photo').val();

       				/*const tr = new FilestackTransform('A6ulpjJhQ6KW7q5IWnfMPz');
					// apply listener with Transformations UI on input file change
					document.querySelector('#meme_project_photo').addEventListener('change', (res) => {
					  tr.open(res.target.files[0]).then(res => {
					    document.getElementById('result').src = res
					  });
					});

					$('#top_line_meme').prop('readonly', true);
					$('#bottom_line_meme').prop('readonly', true);*/
					

				/*const tr = new FilestackTransform('A6ulpjJhQ6KW7q5IWnfMPz');
				tr.open(FILE_URL).then(res => { // replace FILE_URL with the link to the image
				  document.getElementById('result').src = res // display result of the transformations
				});*/
				
				const client = filestack.init('A6ulpjJhQ6KW7q5IWnfMPz'); // initialize Filestack Client with your API key
				const tr = new FilestackTransform('A6ulpjJhQ6KW7q5IWnfMPz'); // initialize Transformations UI
				$('#save_text').html('<button class="btn btn-outline-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Saving...</span></button>');

				tr.setConfigKey('output.blob', true); // set Transformations UI to return blob
				tr.open(FILE_URL).then(res => {
				  client.upload(res).then((uploadRes) => { // upload result of the transformation
				    //document.getElementById('result').innerHTML = JSON.stringify(uploadRes, null, 2);
				    //alert(uploadRes.url);
				    $('#meme_project_photo').val(uploadRes.url);
				    $( '.filestack-filepicker-meme-page' ).find( 'img' ).attr( 'src', uploadRes.url );
				    $('#save_text').html('Add Text');
				    $('#save_text').attr("disabled", true);
				    $('.sw-btn-next').attr("disabled", false);
				    //document.getElementById('result').src = res
				  })
				});


				
				
				




     });


  });
</script>


