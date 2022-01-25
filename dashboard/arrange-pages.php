<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Preview & Arrange Pages - Dashboard';
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

<div class="container-fluid">

    <div class="row">

    	<?php include_once 'sidebar.php'; ?>
        <div class="dashboard-content">

        	<div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">

                    	<?php 
                    	$countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

                    	$arrange_page_title = 'Preview & Arrange Pages';

                    	?>

                        <h2 class="pt-4 pb-2 border-bottom"><?php echo $arrange_page_title;?> 
                          <?php require_once('countdown-timer.php');?>
                        </h2>

                        <div class="row">
                        	
                        	<div id="msg_alert"></div>

  		                    <div class="col-md-12">

  		                    	<?php $collection_project_deadline = date( 'l, F d, Y',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>



  		                    	<div class="row">
                                    
                                    <form method="POST" id="page_arrange_form" >

                                        <button type="button" class="btn btn-success" id="submit_page_arrange">Save & Reload</button>
                                        <hr>

                                        <input type="hidden" name="arrange_page_form_check" value="oual_con_arrange_page_form">

                                        <div id="msg_alert"></div>

                                    <div class="row row-cols-1 row-cols-md-6 g-6">

                                      <div class="col">
                                        <div class="card h-100">
                                          <img src="<?php echo $project_details[0]->project_photo;?>" class="card-img-top" alt="...">
                                          <div class="card-body">
                                            <h5 class="card-title">Cover</h5>
                                            
                                          </div>
                                          <div class="card-footer">
                                            <small class="text-muted">
                                            	<a href="" class="badge bg-primary">Edit Cover</a>
                                            </small>
                                          </div>
                                        </div>
                                      </div>

                                      <?php 
                                      if($get_page_stteings_edit_con_page[0]->page_status != 3){?>
                                      <div class="col">
                                        <div class="card h-100" align="center">
                                         
                                          <div class="card-body">
                                            <h6 class="card-title">Contributors List</h6>
                                            <p class="card-text">
                                             <?php 
                                              foreach ($get_project_contributors as $pc) {
                                                echo $pc->name.'<hr>';
                                              }
                                          ?>
                                          </p>
                                          </div>
                                          <div class="card-footer">
                                            <small class="text-muted">
                                              <a href="<?php echo site_url().'/dashboard/?project_id='.$project_details[0]->project_slug.'&contributors_list=true';?>"<?php if ( isset( $_GET['contributors_list'] ) && $_GET['contributors_list'] == 'true' ) echo ' class="menu-link-active"'; ?>" class="badge bg-primary" >Edit</a>
                                            </small>
                                          </div>
                                        </div>
                                      </div>
                                      <?php }?>
                                      <?php if (!empty($all_pages)) : ?>
                                      <?php 
                                        //get all project pages per user id
                                      	$j = 1;
                                        foreach ($all_pages as $new_pages) {
                                        $m_num = $j++;

                                        if($new_pages->pages_type == 1){
                                      ?>
                                      <div class="col">
                                        <div class="card h-100">
                                          <img src="<?php echo $new_pages->meme_project_photo;?>" class="card-img-top" alt="...">
                                          <div class="card-body">
                                            <h5 class="card-title">Meme</h5>
                                            <p class="card-text"><?php echo $new_pages->top_line_for_meme.','.$new_pages->email_address;?></p>
                                          </div>
                                          <div class="card-footer">
                                            <small class="text-muted">
                                            	<!--<a href="<?php echo $new_pages->id;?>" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#editMeme">Edit</a>		
                                            	<a href="<?php echo $new_pages->id;?>" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#deleteMeme">
                                            		Delete
                                            	</a>-->
                                            	<input type="hidden" name="page_email" id="page_email" value="<?php echo $new_pages->email_address;?>">

                                              <input type="hidden" name="page_id" value="<?php echo $new_pages->order_id;?>">
                                            	
                                            	<input type="hidden" name="arrange_num" id="arrange_num_<?php echo $new_pages->page_num;?>" value="<?php echo $new_pages->page_num;?>">

                                            	<a href="<?php echo $new_pages->id;?>" class="badge bg-dark page_modz" data-bs-toggle="modal" data-bs-target="#arrangePage" data-email="<?php echo $new_pages->email_address;?>" data-pagenums="arrange_num_<?php echo $new_pages->page_num;?>">
                                            		Arrange
                                            	</a>
                                              <span class="badge bg-secondary bg-danger arrange_num_<?php echo $new_pages->page_num;?>" align="right">
                                                  <?php echo $new_pages->page_num;?>
                                                </span>
                                            </small>
                                          </div>
                                        </div>
                                      </div>

                                      <?php 

                                          }
                                       
                                      //	$m = $j-1;
                                      //	$k = 1;
                                        //get all essay pages per user id
                                        //foreach ($essay_pages as $new_essay) {
                                         //$essay_num = $m + $k++;
                                        if($new_pages->pages_type == 2){
                                      ?>
                                      <div class="col">
                                        <div class="card h-100">
                                          
                                          <div class="card-body">
                                            <h5 class="card-title">Long Essay</h5>
                                            <p class="card-text"><?php echo $new_pages->essay.','.$new_pages->email_address;?></p>
                                          </div>
                                          <div class="card-footer">
                                            <small class="text-muted">
                                            	<!--<a href="<?php echo $new_pages->id;?>" class="badge bg-info" data-bs-toggle="modal" data-bs-target="#editEssay">Edit</a>
                                            	<a href="<?php echo $new_pages->id;?>" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#deleteEssay">
                                            		Delete
                                            	</a>-->
                                            	<input type="hidden" name="page_email" id="page_email" value="<?php echo $new_pages->email_address;?>">

                                              <input type="hidden" name="page_id" value="<?php echo $new_pages->order_id;?>">

                                            	<input type="hidden" name="arrange_num" id="arrange_num_<?php echo $new_pages->page_num;?>" value="<?php echo $new_pages->page_num;?>">

                                            	<a href="<?php echo $new_pages->id;?>" class="badge bg-dark page_modz" data-bs-toggle="modal" data-bs-target="#arrangePage" data-email="<?php echo $new_pages->email_address;?>" data-pagenums="arrange_num_<?php echo $new_pages->page_num;?>">
                                            		Arrange
                                            	</a>

                                              <span class="badge bg-secondary bg-danger arrange_num_<?php echo $new_pages->page_num;?>">
                                                  <?php echo $new_pages->page_num;?>
                                              </span>
                                            </small>
                                          </div>
                                        </div>
                                      </div>

                                      <?php
                                          }
                                       }?>
                                    <?php endif; ?>
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


<!-- Modal -->
<div class="modal fade" id="editCover" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Edit Cover</h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editMeme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Edit Meme</h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteMeme" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Delete Meme</h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="editEssay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Edit Essay</h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteEssay" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Delete Essay</h5>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="arrangePage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">Arrange Page </h5>
      <input type="hidden" id="get_page_num">
      </div>
      <div class="modal-body">
      		(<span id="mo_head"></span>)

      <hr>
      <!--<label>From:</label>-->
		  <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="arrange_number">
		 
      <option selected value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5">5</option>
		  <option value="6">6</option>
		  <option value="7">7</option>
		  <option value="8">8</option>
		  <option value="9">9</option>
		  <option value="10">10</option>
		  <option value="11">11</option>
		  <option value="12">12</option>
		  <option value="13">13</option>
		  <option value="14">14</option>
		  <option value="15">15</option>
		  <option value="16">16</option>
		  <option value="17">17</option>
		  <option value="18">18</option>
		  <option value="19">19</option>
		  <option value="20">20</option>
		  <option value="21">21</option>
		  <option value="22">22</option>
		</select>

   <!-- <label>To:</label>
      <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="arrange_number_to">
     
      <option selected value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
      <option value="13">13</option>
      <option value="14">14</option>
      <option value="15">15</option>
      <option value="16">16</option>
      <option value="17">17</option>
      <option value="18">18</option>
      <option value="19">19</option>
      <option value="20">20</option>
      <option value="21">21</option>
      <option value="22">22</option>
    </select>-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-dark arrange_page_save">Save</button>
      </div>
    </div>
  </div>
</div>

<?php include_once 'footer.php'; ?>

 <script type="text/javascript">

 	var msg_sucess = '<div class="alert alert-success" role="alert">Page Order Change Successfully!!!</div>';

        $(".page_modz").click(function () {
            var email = $(this).data('email');
            var page_num = $(this).data('pagenums');
           // alert(page_num);
            $("#mo_head").html(email);
            $('#get_page_num').val(page_num);
        });

        $(".arrange_page_save").click(function () {
            var num = $('#arrange_number').val();
            var num_to = $('#arrange_number_to').val();
            var ds_page_num = $('#get_page_num').val();
            var nw_pn = '#'+ ds_page_num;
            var nw_pn1 = '.'+ ds_page_num;
            
            $(nw_pn).val(num);
            $(nw_pn1).html(num);

            $('#arrangePage').modal('hide');
            $('#msg_alert').html(msg_sucess);
            $("#msg_alert").fadeTo(2000, 500).slideUp(500, function() {
	               $("#msg_alert").slideUp(500);
	           });

        });
</script>