<?php
//require('pdf/fpdf.php');
/*require('pdf/mem_image.php');
include_once 'utilities/dashboard-functions.php';

$pdf = new PDF_MemImage();
$pdf->AddPage();

// Load an image into a variable
$project_details  				= get_project_details( $_GET['project_id'] );
$all_pages       				= get_contributors_all_pages( $_SESSION['user_id'], $_GET['project_id'] );
$get_page_stteings_edit_con_page= get_page_stteings_edit_con_page(  $_SESSION['user_id'],$_GET['project_id']);
$get_project_contributors      	= get_project_contributors( $_GET['project_id']);

$get_project_user      			= get_user_details( $project_details[0]->user_id);

$email = $get_project_user->email_address;
$project_id = $_GET['project_id'];

//cover
$logo = file_get_contents($project_details[0]->project_photo);
// Output it
$pdf->MemImage($logo, 50, 30, 120);


$pdf->SetFont('Arial','B',15);
// Move to the right
$pdf->Cell(80, 30);
// Title
$pdf->Cell(30,10,$project_details[0]->full_name,0,0,'C');



//displaycontrbutors list
if($get_page_stteings_edit_con_page[0]->page_status != 3){

    $pdf->AddPage();

    $pdf->SetFont('Arial','B',15);
            // Move to the right
    $pdf->Cell(80, 30);
            // Title
    $pdf->Cell(30,10,'Contributors List',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();

    $i = 1;
    foreach ($get_project_contributors as $pc) {
        
        $html = $i++.'.) '.$pc->name;
       
        $pdf->SetFont('Arial','I',12);
        $pdf->SetTextColor(128);
        //$pdf->SetXY(100, $newline);

        $pdf->Cell(80, 50);
        $pdf->Cell(30,10,$html,0,0,'L');
        $pdf->Ln();
    }

}


//meme & long essay template
if (!empty($all_pages)) :

foreach ($all_pages as $new_pages) {

    if($new_pages->pages_type == 1){

        $pdf->AddPage();

        $img = file_get_contents($new_pages->meme_project_photo);
        
        $pdf->MemImage($img, 50, 30, 120);

        $pdf->SetFont('Arial','B',15);
        // Move to the right
        $pdf->Cell(80, 30);
        // Title
        $pdf->Cell(30,10,'Meme',0,0,'C');

    }

    if($new_pages->pages_type == 2){


        $pdf->AddPage();

        $pdf->SetFont('Arial','B',15);
        // Move to the right
        $pdf->Cell(80, 30);
        // Title
        $pdf->Cell(30,10,'Long Essay',0,0,'C');

       // $html = $new_pages->essay;

        //$html = '<i>'.$new_pages->essay.'</i>';
        $html = $new_pages->essay;
        
        $pdf->SetFont('Arial','I',12);
        $pdf->SetTextColor(128);
        $pdf->SetXY(80, 42);
        $pdf->Write(0, $html);
       // $pdf->Cell(0,40,''.$html.'',0,0,'C');
       
    }

   //  $pdf->SetY(-15);
     //$pdf->SetFont('Arial','I',8);
      //  $pdf->SetXY(80, 42);
     //$pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
}   

endif;


//questionnaire
if (!empty($get_project_contributors)) :

$i = 1;
foreach ($get_project_contributors as $gpc) {

   		$get_project_con_question = get_con_question_and_answer($gpc->id, $_GET['project_id']);
   		$get_project_con_question_lo = get_con_question_and_answer_love_one($gpc->id, $_GET['project_id']);

        $pdf->AddPage();

	    $pdf->SetFont('Arial','B',15);
	            // Move to the right
	    $pdf->Cell(80, 30);
	            // Title
	    $pdf->Cell(30,10,'Questionnaire',0,0,'C');
	   // $pdf->setLineStyle(1);
	    $pdf->Ln();


        $html = $i++.'.)'.$gpc->name;
       
        $pdf->SetFont('Arial','B',14);
        $pdf->SetTextColor(128);
        //$pdf->SetXY(100, $newline);

        $pdf->Cell(20, 180);
        $pdf->Cell(30,10,$html,0,0,'L');
        $pdf->Ln();

        $pdf->SetFont('Arial','I',12);
		$pdf->Cell(20, 180);
		$pdf->Cell(30,10,'Love One'.' ( '.$get_project_con_question_lo->love_one.' )',0,0,'L');
		$pdf->Ln();

        if (!empty($get_project_con_question)) :
        	$j = 1;
	        foreach ($get_project_con_question as $value) {
	        	
	        	$pdf->SetFont('Arial','I',12);
		        $pdf->Cell(20, 180);
		        $pdf->Cell(30,10,$j++.'.) '.$value->question,0,0,'L');
		        $pdf->Ln();

		        $pdf->SetFont('Arial','I',11);
		        $pdf->Cell(20, 180);
		        $pdf->Cell(30,10,$value->answer,0,0,'L');
		        $pdf->Ln();

		    }

   		endif;
}   

endif;


if (!empty($project_details[0]->project_back_photo)) :


$logo1 = file_get_contents($project_details[0]->project_back_photo);

$pdf->AddPage();

// Output it
$pdf->MemImage($logo1, 50, 30, 120);


$pdf->SetFont('Arial','B',15);
// Move to the right
$pdf->Cell(80, 30);
// Title
$pdf->Cell(30,10,$project_details[0]->project_back_title,0,0,'C');

endif;

$plugins_url = plugins_url();
$base_url = get_option( 'siteurl' );
$plugins_dir = str_replace( $base_url, ABSPATH, $plugins_url );

$file = $plugins_dir.'/oual-memory-book/dashboard/uploaded_pdf/'.$project_details[0]->full_name.'.pdf';
$file_download = $pdf->Output('F', $file); 

$send_email = __download_pdf_book($email, $project_id, $file_download);
echo $send_email;*/


if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: Jewmer T. Villagantol
**/

$page_title = 'Download PDF Page - Project Wrap Up Page';
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
                        
                        <?php $countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

                          $download_pdf_page_title = 'Download PDF Book Compilation';
                          

                        ?>
                        <!--<div class="col-md-12" align="right">
                          <h2 > 
                            <span class="justify-content-end project_timer" data-reg="<?php echo $countdown_timer;?>">
                            </span>
                          </h2>
                        </div>-->
                        
                        <div class="row justify-content-center">
                           
                            <div class="col-md-12" align="left">

                              <label class="form-label" style="font-size:26px; text-transform:uppercase;" ><?php echo $download_pdf_page_title;?></label><br>
                              
                            </div>
                            <br>
                            <div id="msg_alert" align="center"></div>
                            <div class="col-md-12" >
                            <hr>
                            <form id="oual-send-pdf-page-form" class="form">

                                  <input type="hidden" name="send_pdf_to_org_form_check" value="oual_send_pdf_to_org_form">

                                  <input type="hidden" name="user_id" value="<?php echo  $_SESSION['user_id'];?>">

                                  <input type="hidden" name="project_id" value="<?php echo $_GET['project_id'];?>">

                                  <input type="hidden" name="organizer" value="1">

                                    <br><br>
                                    <div align="center">
                                          <button type="button" class="btn btn-success" id="btn_download_pdf">Click here to download</button>
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
