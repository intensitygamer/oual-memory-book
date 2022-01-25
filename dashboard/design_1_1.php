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
require('pdf/mem_image.php');

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details  = get_project_details( $_GET['project_id'] );
    $user_id_session  = get_user_projects( $_SESSION['user_id'] );
    $all_pages       = get_contributors_all_pages( $_SESSION['user_id'], $_GET['project_id'] );
    $essay_pages      = get_contributors_essay_pages( $_SESSION['user_id'] );
    $get_project_contributors      = get_project_contributors( $_GET['project_id']);
    $get_page_stteings_edit_con_page      = get_page_stteings_edit_con_page(  $_SESSION['user_id'],$_GET['project_id']);

    $project_id = $_GET['project_id'];

}


if(isset($_POST['crete_pdf'])){

  foreach ($all_pages as $new_pages) {

    if($new_pages->pages_type == 1){

          $pdf->AddPage();

          $img = file_get_contents($new_pages->meme_project_photo);
                    
          $pdf->MemImage($img, 50, 30, 120);

          $plugins_url = plugins_url();
          $base_url = get_option( 'siteurl' );
          $plugins_dir = str_replace( $base_url, ABSPATH, $plugins_url );

          $file = $plugins_dir.'/oual-memory-book/dashboard/uploaded_pdf/'.$email.'- '.'Bloom-Design'.'.pdf';
          
          $file_download = $pdf->Output('F', $file);
          
    }

  }

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
    integrity="sha256-c9vxcXyAG4paArQG3xk6DjyW/9aHxai2ef9RpMWO44A=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.0/jspdf.debug.js"></script>

<div class="container-fluid">

    <div class="row">

      <?php //include_once 'sidebar.php'; ?>
        <div class="dashboard-content">

          <div class="container">

                <div class="row">

                    <div class="col-md-12 mt-5">

                    

                        <div class="row">
                          
                          <form method="POST" >

                          <div id="msg_alert"></div>

                         
                          <div id="download-button">

                            <button type="submit" class="btn btn-success"  style="" id="downloadPDFs" name="crete_pdf">Download PDF</button>
                            

                            <input type="hidden" name="arrange_page_form_check" value="oual_con_arrange_page_form">

                          </div>

                            <div id="msg_alert"></div>

                          <div id="content">

                             <?php 

                                  //meme & long essay template
                                  if (!empty($all_pages)) :
                                  $m = 0;
                                  foreach ($all_pages as $new_pages) {

                                      if($new_pages->pages_type == 1){ 

                                        $m++;
                                        if($m == 1){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="1355" height="970" style="margin-top:15px; margin-left:15px; position:absolute;">';

                                      ?>

                                      <div id="bloom1-meme" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom.png'); position:relative;"></div>

                                      <?php 
                                        
                                        echo '</div>';

                                       }
                                  }
                                  break;
                                }

                                endif;

                              ?>
                           
                            <br>

                            <div class="html2pdf_page-break"></div>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom2-Pic.png'); ">

                              <?php 

                                  //meme & long essay template
                                  if (!empty($all_pages)) :
                                  $m = 0;
                                  foreach ($all_pages as $new_pages) {

                                      if($new_pages->pages_type == 1){ 

                                        $m++;

                                        if($m == 1){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="390" height="390" style="margin-top:498px; margin-left:105px; position:absolute; transform: rotate(-13deg);">';                                        
                                        //echo '</div>';

                                       }

                                       if($m == 2){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="390" height="390" style="margin-top:498px; margin-left:895px; position:absolute; transform: rotate(12deg);">';                                        
                                        //echo '</div>';

                                       }

                                      // break;
                                  }
                                 
                                }

                                endif;

                              ?>
                                
                            </div>

                           <br>

                            <div class="html2pdf_page-break"></div>

                            
                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom 3- Pic.png'); ">
                                  
                                  <?php 

                                  //meme & long essay template
                                  if (!empty($all_pages)) :
                                  $m = 0;
                                  foreach ($all_pages as $new_pages) {

                                      if($new_pages->pages_type == 1){ 

                                        $m++;

                                        if($m == 3){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="310" height="310" style="margin-top:225px; margin-left:162px; position:absolute; transform: rotate(12deg);">';                                        
                                        //echo '</div>';

                                       }

                                       if($m == 4){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="310" height="310" style="margin-top:582px; margin-left:130px; position:absolute; transform: rotate(-10deg);">';                                        
                                        //echo '</div>';

                                       }

                                       if($m == 2){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="882" height="764" style="margin-top:40px; margin-left:476px; position:absolute;">';                                        
                                        //echo '</div>';

                                       }

                                      // break;
                                  }
                                 
                                }

                                endif;

                              ?>

                            </div>

                            
                             <br>

                             <div class="html2pdf_page-break"></div>

                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Bloom 4- Pic.png'); ">

                                <?php 

                                  //meme & long essay template
                                  if (!empty($all_pages)) :
                                  $m = 0;
                                  foreach ($all_pages as $new_pages) {

                                      if($new_pages->pages_type == 1){ 

                                        $m++;

                                        if($m == 1){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="358" height="290" style="margin-top:662px; margin-left:626px; position:absolute;">';                                        
                                        //echo '</div>';

                                       }

                                        if($m == 3){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="380" height="290" style="margin-top:662px; margin-left:1008px; position:absolute;">';                                        
                                        //echo '</div>';

                                       }

                                       if($m == 4){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="572" height="290" style="margin-top:662px; margin-left:0px; position:absolute;">';                                        
                                        //echo '</div>';

                                       }

                                       if($m == 2){

                                        echo  '<img src="'.$new_pages->meme_project_photo.'" width="858" height="564" style="margin-top:50px; margin-left:526px; position:absolute;">';                                        
                                        //echo '</div>';

                                       }

                                      // break;
                                  }
                                 
                                }

                                endif;

                              ?>
                             
                                
                            </div>

                            <br>

                          <div class="html2pdf_page-break"></div>
                              
                            <?php 

                                  //meme & long essay template
                                  if (!empty($all_pages)) :

                                  foreach ($all_pages as $new_pages) {

                                      if($new_pages->pages_type == 2){ 
                                ?>

                                      

                                    <br>

                                      <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Long Essay- Choice 1.png'); text-align:center;">
                                    
                                 <?php  
                                          echo '<br><br><br><br><br><br><br><br><br><br>';
                                          echo '<div>'.$new_pages->essay.'</div>';
                                        echo '</div>';
                                       }
                                  }

                                endif;

                              ?>
                              
                             

                              <?php 

                                  //meme & long essay template
                                  if (!empty($all_pages)) :
                                  $m = 0;
                                  foreach ($all_pages as $new_pages) {

                                      if($new_pages->pages_type == 1){ 

                                ?>
                                      <br>

                                      

                                      <div id="bloom1-meme" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Meme.png'); ">

                                        
                                <?php 
                                      echo '<br><br><br><br><br><br><br><br>';
                                        echo '<div style="width:545px; height:565px; background:url('.$new_pages->meme_project_photo.'); background-repeat:no-repeat; background-position: center; 
                                          background-origin: content-box;
                                          
                                          margin-left:138px;"></div>';
                                        //echo  '<img src="'.$new_pages->meme_project_photo.'" width="530" height="450" style="margin-top:250px; margin-left:135px;">';

                                        echo '</div>';
                                       }
                                  }

                                endif;

                              ?>
                                
                            <br>

                            <div class="html2pdf_page-break"></div>
                             
                            <div id="bloom1" style="width:1388px; height:1000px; background:url('<?=OUAL_NAME_APP;?>dashboard/design/Questionaire-No-Photo.png'); margin-top:50px;">
                                
                                <?php
                                  //questionnaire
                                  if (!empty($get_project_contributors)) :

                                      foreach ($get_project_contributors as $gpc) {
                                        
                                        $get_project_con_question = get_con_question_and_answer($gpc->id, $project_id);
                                          $j = 1;
                                           if (!empty($get_project_con_question)) :

                                              foreach ($get_project_con_question as $value) {
                                                echo $j++.'.) '.$value->question.'<br>';
                                              }

                                          endif;
                                      }

                                  endif;
                                 ?>
                            </div>

                          </div>

                      </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<?php include_once 'footer.php'; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.0/html2pdf.bundle.min.js"></script>

 <script type="text/javascript">

 	/*function addScript(url) {
	     var script = document.createElement('script');
	     script.type = 'application/javascript';
	     script.src = url;
	     document.head.appendChild(script);
	 }
	 addScript('https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js');

	 html2pdf(document.body);*/

   var content = document.querySelector("#content");
 
   $('#downloadPDF').click(function () {
      $('#downloadPDF').html('<button class="btn btn-success" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span> Downloading...</span></button>');


      

      
     var content = document.getElementById("content");
     
     //imgData = canvas.toDataURL('image/png');

      /*html2pdf(content, {

        margin:       5,
        enableLinks:  true,
        filename:     'Bloom-Design-1.pdf',
        image:        { type: 'jpeg', quality: 0.98},
        html2canvas:  { scale: 2, logging: true, dpi: 192, letterRendering: true},      
        jsPDF:        { unit: 'px', format: [1388, 1050], orientation: 'landscape'}

      });*/

      

     
      
      var imgData;

      html2canvas($("#content"), {
      
          useCORS: true,
          onrendered: function(canvas){

            imgData = canvas.toDataURL('image/png');

            //make the pdf document jspdf

            var doc = new jsPDF('l', 'in', [13.8, 10]);

            doc.addImage(imgData,'PNG', 10, 10);

            doc.addPage();
            //save the pdf document
            
            doc.save('Bloom-Design1.pdf');

          //  window.open(imgData);
         

            /*var imgData = canvas.toDataURL('image/png');
            var imgWidth = 295; 
            var pageHeight = 180;  
            var imgHeight = canvas.height * imgWidth / canvas.width;
            alert(imgHeight);
            var heightLeft = imgHeight;
            var doc = new jsPDF('landscape', 'px');
            var position = 0;

            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
              position = heightLeft - imgHeight;
              doc.addPage();
              doc.addImage(imgData, 'PNG', 5, 20, 200, 150);
              heightLeft -= pageHeight;
            }
			*/
            


          }
      });

      //$('#downloadPDF').html('Download');

   /*var options = {
      'width': 1388,
      'height': 1000
    };
    var pdf = new jsPDF('p', 'pt', 'a4');
    pdf.addHTML($("#content"), -1, 220, options, function() {
      pdf.save('admit_card.pdf');
    });*/
  });
 </script>