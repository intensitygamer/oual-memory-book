<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: Jewmer T. Villagantol
**/

$page_title = 'Contributors List - Book Layout';
$body_class = ' admin-dashboard';

include_once 'utilities/dashboard-functions.php';
include_once 'header.php';

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details = get_project_details( $_GET['project_id'] );
    $user_id_session = get_user_projects( $_SESSION['user_id'] );
    $contributors_list = get_project_contributors( $_GET['project_id'] );
    $get_page_stteings_edit_con_page = get_page_stteings_edit_con_page( $_SESSION['user_id'], $_GET['project_id'] );

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

                          $book_layout_title = 'Edit your Contributors List';
                          $book_layout_sub_pages = 'How do you want to display your list of contributors in the memory book?';

                      

                        $current_url = home_url($_SERVER['REQUEST_URI']);

                        ?>
                       
                        <div class="row justify-content-center">
                           
                            <div class="col-md-12" align="center">

                              <label class="form-label" style="font-size:26px; text-transform:uppercase;" ><?php echo $book_layout_title;?></label><br>
                              <label class="form-label" style="font-size:26px; opacity:0.40;" ><?php echo $book_layout_sub_pages;?></label>
                            </div>
                            <hr>
                            <div id="msg_alert"></div>
                            <div class="col-md-12" >

                            <form id="oual-editcon-form" class="form">

                                  <input type="hidden" name="edit_con_form_check" value="oual_editpage_settings_form">

                                  <input type="hidden" id="current_url" value="<?php echo $current_url;?>">

                                  <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                                  <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                                  <input type="hidden" name="organizer" value="1">

                                  <?php 
                                  $page_status = $get_page_stteings_edit_con_page[0]->page_status;?>

                                  <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" name="flexRadioDefault" id="select_display_con_list">

                                  	<?php 
                                  		if($page_status == 1){
                                  			echo '
                                  			<option value="1">Auto-generate a list of contributors (default)</option>
									  		<option value="2"> Customize a list of contributor names</option>
									  		<option value="3"> I do not want a page for contributor names</option>';
                                  		}
                                  		elseif($page_status == 2){
                                  			echo '
									  		<option value="2"> Customize a list of contributor names</option>
									  		<option value="1">Auto-generate a list of contributors (default)</option>
									  		<option value="3"> I do not want a page for contributor names</option>';
                                  		}
                                  		else{
                                  			echo '
                                  			<option value="3"> I do not want a page for contributor names</option>
                                  			<option value="1">Auto-generate a list of contributors (default)</option>
									  		<option value="2"> Customize a list of contributor names</option>
									  ';
                                  		}
                                  	?>
									  <!--<option selected>Open this select Display</option>-->
									  
									</select>

                                  <!--<div class="form-check" >
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="exampleRadios1" value="1">
                                    <label class="form-check-label" for="exampleRadios1">
                                      Auto-generate a list of contributors (default)
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="exampleRadios2" value="2">
                                    <label class="form-check-label" for="exampleRadios2">
                                      Customize a list of contributor names
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="exampleRadios3" value="3">
                                    <label class="form-check-label" for="exampleRadios3">
                                      I do not want a page for contributor names
                                    </label>
                                  </div>-->


                                  

                                  <hr>
                                  <div class="row" align="right">
	                                  <button type="button" class="btn btn-primary" id="btn-next">Next</button>

	                                  <button type="button" class="btn btn-primary" id="btn-saved" style="display:none;">
	                                  	<div id="loading"></div>Save
	                                  </button>
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


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
   	<form id="oual-save-edit-con-form" class="form">
   	<input type="hidden" name="edit_con_form_check" id="edit_con_form_check" value="oual_editcon_list_form">
   	<input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">
    <input type="hidden" name="project_id" id="project_id" value="<?php echo $_GET['project_id'];?>">
    <input type="hidden" id="edit_con_status" name="edit_con_status">

      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
      </div>
      <div class="modal-body">
        <div id="load"></div>
        <div id='content'></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-close">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save-edit-con">Save</button>
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

    $( document ).on( 'click', '#btn-next', function(e) {
      e.preventDefault();

        var load = '<div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border ms-auto" role="status" aria-hidden="true"></div></div>';


        var user_id = $( '#oual-editcon-form input[name=user_id]' ).val();
        var project_id = $( '#oual-editcon-form input[name=project_id]' ).val();

        var chck = $('#select_display_con_list').val();
        $('#edit_con_status').val(chck);

        if(chck == 1){
            $('#staticBackdrop').modal('show'); 
            $('#load').html(load);
            $('.modal-title').html('Here is your preview');
            $('#content').html('');
            //$('#btn-save-edit-con').hide();
            
            var post_data = { 

                'auto_gen': chck, 
                'user_id': user_id, 
                'project_id': project_id
                
              };

            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
              
                  $.ajax({ 
                      type: 'GET',
                      url: ajax_url,
                      data: post_data,
                     success: function(data) { 


                        $('#load').html('');
                        $('#content').html(data);
                         
                      }
                  });
        }


        if(chck == 2){
          
          $('#staticBackdrop').modal('show'); 
          $('#load').html(load);
          $('.modal-title').html('Names from contributions');
          $('#content').html('');
          $('#btn-save-edit-con').show();

            var post_data = { 

                'auto_gen': chck, 
                'user_id': user_id, 
                'project_id': project_id
                
              };

            var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
              
                  $.ajax({ 
                      type: 'GET',
                      url: ajax_url,
                      data: post_data,
                     success: function(data) { 

                        $('#load').html('');
                        $('#content').html(data);
                         
                      }
                  });

        }


    });

    $( document ).on( 'change', '#select_display_con_list', function(e) {
      e.preventDefault();

         if($(this).val() == 1){
            //$('#exampleRadios3').attr('checked', 'checked');
            $('#btn-saved').css('display', 'none');
            $('#btn-next').show();
           
         }

         if($(this).val() == 2){
            //$('#exampleRadios3').attr('checked', 'checked');
            $('#btn-saved').css('display', 'none');
            $('#btn-next').show();
           
         }

         if($(this).val() == 3){
            //$('#exampleRadios3').attr('checked', 'checked');
            $('#btn-saved').css('display', 'block');
            $('#btn-next').hide();
           
         }

     });

    $('.sw-btn-next').attr("disabled", true);
    
    var url = window.location.href;
    var current_url = $('#current_url').val();
    var new_url = current_url+'#step-2';

    
	 //save edit contributors list
	 $( document ).on( 'click', '#btn-save-edit-con', function(e) {
		e.preventDefault();

			var edit_con_form_check = $( '#edit_con_form_check' ).val();
			var project_id 			= $( '#project_id' ).val();
			var edit_con_status 	= $( '#edit_con_status' ).val();
			$('#btn-save-edit-con').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
			
			
			var con_id = [];
			$("input[name=con_id]").each(function () {
			    con_id.push($(this).val());
			});


			var user_con_data = [];
			$("input[name=user_contributors]").each(function () {
			    user_con_data.push($(this).val());
			});

			//alert(edit_con_status);

	            var post_data = { 

	            	'edit_con_form_check': edit_con_form_check, 
	            	'con_id': con_id, 
	            	'user_con_data': user_con_data,
	            	'project_id': project_id,
	            	'edit_con_status': edit_con_status
	            	
	            };


	        var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	                     
	            $.ajax({ 
	                method: 'POST',
	                url: ajax_url,
	                data: post_data,
	                success: function(data) { 

	                   //	alert(data);

	                   	$('#oual-save-edit-con-form').trigger("reset");

	                   	$('#btn-save-edit-con').html('Save');

	           			$('#staticBackdrop').modal('hide');

	                    $('#msg_alert').html('<div class="alert alert-success" role="alert">Your settings have been saved successfully.</div>');
	                    $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
	                    $("#msg_alert").slideUp(500);


	                });
	            }
	        });

	       
                  
    });


	//save page settings
	 $( document ).on( 'click', '#btn-saved', function(e) {
		e.preventDefault();

			var edit_con_form_check = $( '#oual-editcon-form input[name=edit_con_form_check]' ).val();
			var user_id = $( '#oual-editcon-form input[name=user_id]' ).val();
			var project_id = $( '#oual-editcon-form input[name=project_id]' ).val();
			$('#btn-saved').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>');
			//alert(project_id);
			
	            var post_data = { 

	            	'edit_con_form_check': edit_con_form_check, 
	            	'user_id': user_id, 
	            	'project_id': project_id
	            	
	            };


	        var ajax_url = window.location.origin+'/bepi/wp-content/plugins/oual-memory-book/ajax/front-ajax.php';
	                     
	            $.ajax({ 
	                method: 'POST',
	                url: ajax_url,
	                data: post_data,
	                success: function(data) { 

	                //	alert(data);

	                  	if(data == 'success')
	                  	{

		                   	$('#oual-meme-page-form').trigger("reset");
		                   	$('#btn-saved').html('Save');
		                    $('#msg_alert').html('<div class="alert alert-success" role="alert">Your settings have been saved successfully.</div>');
		                    $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                    $("#msg_alert").slideUp(500);
		                	});

	                   }
	                   else{
	                   		$('#btn-saved').html('Save');
	                   		$('#msg_alert').html('<div class="alert alert-danger" role="alert">Page Settings was already saved..</div>');
		                    $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
		                    $("#msg_alert").slideUp(500);
		                	});
	                   }
	                  //  setTimeout(function() {
						    
						//}, 1000);

	                
	            }
	        });

	       
                  
    });
    
    

  });
</script>


