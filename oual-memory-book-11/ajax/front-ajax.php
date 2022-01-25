<?php
//Loads Wordpress Environment And Template
include('../../../../wp-load.php');
include('../emails/invitation.php');
require('../dashboard/pdf/mem_image.php');
include_once '../dashboard/utilities/dashboard-functions.php';

// Load Fpdi library 
use setasign\Fpdi\Fpdi; 
require_once('../dashboard/vendor/autoload.php');
require_once('../dashboard/vendor/setasign/fpdi/src/PdfParser/PdfParser.php');
$img_watermark = '../assets/images/company-logo.png'; 


global $wpdb;
session_start();


$user_table = $wpdb->prefix . 'memory_book_users';   
$user_project_table = $wpdb->prefix . 'memory_book_projects';
$user_contributors_table = $wpdb->prefix . 'memory_book_contributors';
$user_con_meme_page_table = $wpdb->prefix . 'memory_book_contributors_meme_page';
$user_con_essay_page_table = $wpdb->prefix . 'memory_book_contributors_long_essay_page';
$user_con_all_pages_table = $wpdb->prefix . 'memory_book_contributors_all_pages';
$memory_book_page_settings = $wpdb->prefix . 'memory_book_page_settings';
$memory_book_questions = $wpdb->prefix . 'memory_book_questions';
$memory_book_question_answer = $wpdb->prefix . 'memory_book_question_answer';

// Random string generator for unique project parameter
function generate_random_string() {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < 8; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;

}

// Get Data From Registration Form And Login Form
if ( ( isset( $_POST['form_check'] ) && !empty( $_POST['form_check'] ) ) && ( isset( $_POST['user_email'] ) && !empty( $_POST['user_email'] ) ) ) {
	
	$user_email = strip_tags( stripslashes( trim( filter_var( $_POST['user_email'], FILTER_VALIDATE_EMAIL ) ) ) );
	$user_password = strip_tags( stripslashes( $_POST['user_password'] ) );


	if ( $_POST['form_check'] === 'oual_login' ) {
		
		$encrypt_pass = md5( $user_password );

		$check_user_exist = $wpdb->get_results( "SELECT * FROM $user_table WHERE `email_address` = '$user_email' AND `password` = '$encrypt_pass'" );

	    if ( !empty( $check_user_exist ) ) {

			if ( isset( $_POST['remember_user'] ) && !empty( $_POST['remember_user'] ) ) {

				$hour =  time() + (86400 * 30);
                setcookie('user_email', $user_email, $hour, "/");
                setcookie('user_password', $user_password, $hour, "/");

			}

			// Check user project if more the one
			$check_user_projects = $wpdb->get_results( "SELECT * FROM $user_project_table WHERE `user_id` = '".$check_user_exist[0]->id."'" );

			if ( $check_user_projects ) {

				if ( count( $check_user_projects ) > 1 ) {
					$response['slug'] = '/dashboard/?project_status=projects';					
				} else {
					$response['slug'] = '/dashboard/?project_id='.$check_user_projects[0]->project_slug.'&dashboard=true';
				}

			} else {
				$response['slug'] = '/dashboard/?project_status=new';
			}

			$_SESSION['user_id'] = $check_user_exist[0]->id;
			$_SESSION['user_email'] = $user_email;
			$response['type'] = 'login_success';
			$response['message'] = __( "Welcome Back! You'll be redirected shortly.", 'Memory Book' );

	    } else {

	    	$response['type'] = 'login_error';
		    $response['message'] = __( "Invalid Email Address or Password.", 'Memory Book' );

	    }

	}

	if ( $_POST['form_check'] === 'oual_registration' ) {

		$encrypted_pass = md5( $user_password );

		$user_data = array(

			'email_address' => $user_email,
			'password' => $encrypted_pass,
			'user_registered' => date("Y-m-d H:i:s")

		);

		$register_user = $wpdb->insert( $user_table, $user_data, $format = null );

		if ( $register_user ) {

			$check_user_exist = $wpdb->get_results( "SELECT * FROM $user_table WHERE `email_address` = '$user_email' AND `password` = '$encrypted_pass'" );

	    	if ( !empty( $check_user_exist ) ) {

	    		$_SESSION['user_id'] = $check_user_exist[0]->id;
	    		$response['type'] = 'registration_success';
		    	$response['message'] = __( "Congratulations! You've successfully created your account.", 'Memory Book' );

	    	}

		} else {

			$response['type'] = 'registration_error';
		    $response['message'] = __( "Oops! Something went wrong while creating your account.", 'Memory Book' );
		    
		}

	}

	echo json_encode( $response );

}

// Get Data From Project Creation
if ( ( isset( $_POST['_user_id'] ) && !empty( $_POST['_user_id'] ) ) && ( isset( $_POST['_project_heading'] ) && !empty( $_POST['_project_heading'] ) ) && ( isset( $_POST['_project_fullname'] ) && !empty( $_POST['_project_fullname'] ) ) && ( isset( $_POST['_project_dob'] ) && !empty( $_POST['_project_dob'] ) ) && ( isset( $_POST['_project_dod'] ) && !empty( $_POST['_project_dod'] ) ) && ( isset( $_POST['_project_photo'] ) && !empty( $_POST['_project_photo'] ) ) ) {

	$slug = generate_random_string();

	$user_data = array(

		'user_id' => $_POST['_user_id'],
		'project_type' => $_POST['_project_heading'],
		'full_name' => $_POST['_project_fullname'],
		'date_of_birth' => $_POST['_project_dob'],
		'date_of_death' => $_POST['_project_dod'],
		'project_photo' => $_POST['_project_photo'],
		'project_slug' => $slug,
		'project_registered' => date("Y-m-d H:i:s"),
		'project_status' => 1

	);

	$register_project = $wpdb->insert( $user_project_table, $user_data, $format = null );

	if ( $register_project ) {

		$response['slug'] = '/dashboard/?project_id='.$slug.'&dashboard=true';
		$response['type'] = 'add_project_success';
		$response['message'] = __( "Congratulations! You've successfully created your project.", 'Memory Book' );

	} else {

		$response['type'] = 'add_project_error';
		$response['message'] = __( "Oops! Something went wrong while creating your project.", 'Memory Book' );

	}

	echo json_encode( $response );

}


// Get Data For Email Contributors
if ( ( isset( $_POST['_email_recepients'] ) && !empty( $_POST['_email_recepients'] ) ) && ( isset( $_POST['_email_project_slug'] ) && !empty( $_POST['_email_project_slug'] ) ) ) {

	$identify_comma = explode ( ',', $_POST['_email_recepients'] );
	$identify_whitespaces = preg_replace( '/\s+/', '', $identify_comma );
	$identiy_project_id = $_POST['_email_project_slug'];

	// Send Email Invitation to Contributors
	$email_return = __invite_contributors( $identify_whitespaces, $identiy_project_id );

	// If success save into database
	if ( $email_return == 'success') {

		foreach ($identify_whitespaces as $value) {
			$user_data[] = array(

				'project_id' => $identiy_project_id,
				'email_address' => $value,
				'status' => 1,
				'date_added' => date("Y-m-d H:i:s")

			);
		}

		$sql_val = $place_holders = array();

		if ( count($user_data) > 0 ) {
			
			foreach ( $user_data as $value ) {
				
				array_push( $sql_val, $value['project_id'], $value['email_address'], $value['status'], $value['date_added'] );
	        	$place_holders[] = "( %s, %s, %d, %s)";

			}

			$insert_query = "INSERT INTO $user_contributors_table (`project_id`, `email_address`, `status`, `date_added`) VALUES ";
			$insert_query .= implode( ', ', $place_holders );
			$result_query = $wpdb->prepare( "$insert_query ", $sql_val );

			if ( $wpdb->query( $result_query ) ) {
				
				$response['type'] = 'email_invitation_success';
				$response['message'] = __( "Congratulations! You've successfully send an invitation to the email(s) you've provided.", 'Memory Book' );

		    } else {
		    	
		    	$response['type'] = 'email_saving_contributor';
				$response['message'] = __( 'Something went wrong while saving emails into database.', 'Memory Book' );

		    }

		}

	} else {

		$response['type'] = 'email_invitation_error';
		$response['message'] = __( 'Something went wrong while sending invitation.', 'Memory Book' );

	}

	echo json_encode( $response );

}

// Send Single Email to Contributors Form
if ( 
	( isset( $_POST['form_check'] ) && !empty( $_POST['form_check'] ) ) && 
	( isset( $_POST['email'] ) && !empty( $_POST['email'] ) ) && 
	( isset( $_POST['message'] ) && !empty( $_POST['message'] ) )&& 
	( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) && 
	( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) )
) {

	if ( $_POST['form_check'] === 'oual_msg_contributors' ) {

		$email          =  $_POST['email'];
		$message        =  $_POST['message'];  
		$user_id        =  $_POST['user_id'];  
		$project_id     =  $_POST['project_id'];  

		
		$data = array(
			'project_id' 	=> $project_id,
			'email_address'	=> $email,
			'status'		=> 1,
			'date_added'	=> date("Y-m-d H:i:s")
		);

		//save data to database before sending email...
		$wpdb->insert( $user_contributors_table, $data);
		

		// Send Email Message to Contributors
		mail_submission_for_msg_contributors($email, $message, $user_id, $project_id);

		//get users contributors per project id
		$contributors_list = $wpdb->get_results( "SELECT * FROM $user_contributors_table WHERE `project_id` = '$project_id'" );


		foreach ($contributors_list as $value){
           echo' 
           		<tr>                                    
                <td>'.$value->email_address.'</td>
                <td>No</td>
                <td><div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefaults" name="mass_email[]">
                </div></td>
                </tr>';
		}
	}

	// Send Multiple Email to Contributors Form
	if ( $_POST['form_check'] === 'oual_mass_msg_contributors' ) {

		$email          =  $_POST['email'];
		$message        =  $_POST['message'];  
		$user_id        =  $_POST['user_id'];  
		$project_id     =  $_POST['project_id'];  

		
		foreach ($email as $new_val) {
			echo $message;
			// Send Email Message to Contributors
			mail_submission_for_msg_contributors($new_val, $message, $user_id, $project_id);

		}

	}
}



// Create Contributors Meme Page
if ( 
	 ( isset( $_POST['meme_form_check'] ) && !empty( $_POST['meme_form_check'] ) ) &&
	 ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) && 
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) ) && 
	 ( isset( $_POST['meme_project_photo'] ) && !empty( $_POST['meme_project_photo'] ) ) &&
	 ( isset( $_POST['organizer'] ) && !empty( $_POST['organizer'] ) ) && 
	// ( isset( $_POST['top_line_for_meme'] ) && !empty( $_POST['top_line_for_meme'] ) ) && 
	// ( isset( $_POST['bottom_line_for_meme'] ) && !empty( $_POST['bottom_line_for_meme'] ) ) && 
	 ( isset( $_POST['nickname'] ) && !empty( $_POST['nickname'] ) ) && 
	 ( isset( $_POST['email_address'] ) && !empty( $_POST['email_address'] ) ) && 
	 ( isset( $_POST['contribute_with_others'] ) && !empty( $_POST['contribute_with_others'] ) ) 
  ) 
{

	//echo $_POST['meme_project_photo'];
	
	if ( $_POST['meme_form_check'] === 'oual_con_meme_page_form' ) {
		
		$post_data = array(

			'user_id' => $_POST['user_id'],
			'project_id' => $_POST['project_id'],
			'meme_project_photo' => $_POST['meme_project_photo'],
			'organizer' => $_POST['organizer'],
			//'top_line_for_meme' => $_POST['top_line_for_meme'],
			//'bottom_line_for_meme' => $_POST['bottom_line_for_meme'],
			'nickname' => $_POST['nickname'],
			'email_address' => $_POST['email_address'],
			'contribute_with_others' => $_POST['contribute_with_others'],
			'date_added' => date("Y-m-d H:i:s")

		);

		//update contributors table field name 
		$data = array('name' => $_POST['nickname']);
		$where = array('email_address' => $_POST['email_address'], 'project_id' => $_POST['project_id']);
		$wpdb->update( $user_contributors_table, $data, $where);


		$wpdb->insert( $user_con_meme_page_table, $post_data);
		$lastid = $wpdb->insert_id;



		$user_id = $_POST['user_id'];
		$project_id = $_POST['project_id'];

		$wpdb->get_results("SELECT * FROM $user_con_all_pages_table WHERE 
                        `user_id` = '$user_id' AND 
                        `project_id` = '$project_id' "); 

		$pageNum = $wpdb->num_rows + 1;

		
		$insert_data = array(

			'user_id' 		=> $_POST['user_id'],
			'project_id' 	=> $_POST['project_id'],
			'page_id' 		=> $lastid,
			'page_num' 		=> $pageNum,
			'pages_type' 	=> 1,
			'date_added' 	=> date("Y-m-d H:i:s")

		);
		
		$wpdb->insert($user_con_all_pages_table, $insert_data);


		//API Details
		$apiKey = '5bb95be92d77c3c255e436f4931c2d17-us17';
		$listId = '88ed69ee2f';

		//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $firstname = $_POST['nickname'];
		    $lastname = 'Meme';
		    $email = $_POST['email_address'];

		    if($email) {
		        //Create mailchimp API url
		        $memberId = md5(strtolower($email));
		        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
		        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

		        //Member info
		        $data = array(
		            'email_address'=>$email,
		            'status' => 'subscribed',
		            'merge_fields'  => [
		                'FNAME'     => $firstname,
		                'LNAME'     => $lastname
		            ]
		            );
		        $jsonString = json_encode($data);

		        // send a HTTP POST request with curl
		        $ch = curl_init($url);
		        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
		        $result = curl_exec($ch);
		        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		        curl_close($ch);

		        //Collecting the status
		        switch ($httpCode) {
		            case 200:
		                $msg = 'Success, newsletter subcribed using mailchimp API';
		                break;
		            case 214:
		                $msg = 'Already Subscribed';
		                break;
		            default:
		                $msg = 'Oops, please try again.[msg_code='.$httpCode.']';
		                break;
		        }
		    }
		/*if ( $add_meme_page ) {

			$response['type'] = 'success';
			

		} else {

			$response['type'] = 'error';
			

		}

		echo json_encode( $response );*/
	}

}



// Create Contributors Essay Page
if ( 
	 ( isset( $_POST['essay_form_check'] ) && !empty( $_POST['essay_form_check'] ) ) &&
	 ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) && 
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) ) && 
	 ( isset( $_POST['essay'] ) && !empty( $_POST['essay'] ) ) &&
	 ( isset( $_POST['organizer'] ) && !empty( $_POST['organizer'] ) ) &&
	 ( isset( $_POST['nickname'] ) && !empty( $_POST['nickname'] ) ) && 
	 ( isset( $_POST['email_address'] ) && !empty( $_POST['email_address'] ) ) && 
	 ( isset( $_POST['contribute_with_others'] ) && !empty( $_POST['contribute_with_others'] ) ) 
  ) 
{

	
	if ( $_POST['essay_form_check'] === 'oual_con_essay_page_form' ) {
		
		$post_data = array(

			'user_id' 					=> $_POST['user_id'],
			'project_id' 				=> $_POST['project_id'],
			'essay' 					=> $_POST['essay'],
			'organizer' 				=> $_POST['organizer'],
			'nickname' 					=> $_POST['nickname'],
			'email_address' 			=> $_POST['email_address'],
			'contribute_with_others' 	=> $_POST['contribute_with_others'],
			'date_added' 				=> date("Y-m-d H:i:s")

		);

		//update contributors table field name 
		$data = array('name' => $_POST['nickname']);
		$where = array('email_address' => $_POST['email_address'], 'project_id' => $_POST['project_id']);
		$wpdb->update( $user_contributors_table, $data, $where);

		$wpdb->insert( $user_con_essay_page_table, $post_data);
		$lastid = $wpdb->insert_id;

		$user_id = $_POST['user_id'];
		$project_id = $_POST['project_id'];

		$wpdb->get_results("SELECT * FROM $user_con_all_pages_table WHERE 
                        `user_id` = '$user_id' AND 
                        `project_id` = '$project_id' "); 

		$pageNum = $wpdb->num_rows + 1;

		

		$insert_data = array(

			'user_id' => $_POST['user_id'],
			'project_id' => $_POST['project_id'],
			'page_id' => $lastid,
			'page_num' => $pageNum,
			'pages_type' => 2,
			'date_added' => date("Y-m-d H:i:s")

		);
		
		$wpdb->insert($user_con_all_pages_table, $insert_data);


		//API Details
		$apiKey = '5bb95be92d77c3c255e436f4931c2d17-us17';
		$listId = '88ed69ee2f';

		//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $firstname = $_POST['nickname'];
		    $lastname = 'Long Essay';
		    $email = $_POST['email_address'];

		    if($email) {
		        //Create mailchimp API url
		        $memberId = md5(strtolower($email));
		        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
		        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

		        //Member info
		        $data = array(
		            'email_address'=>$email,
		            'status' => 'subscribed',
		            'merge_fields'  => [
		                'FNAME'     => $firstname,
		                'LNAME'     => $lastname
		            ]
		            );
		        $jsonString = json_encode($data);

		        // send a HTTP POST request with curl
		        $ch = curl_init($url);
		        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
		        $result = curl_exec($ch);
		        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		        curl_close($ch);

		        //Collecting the status
		        switch ($httpCode) {
		            case 200:
		                $msg = 'Success, newsletter subcribed using mailchimp API';
		                break;
		            case 214:
		                $msg = 'Already Subscribed';
		                break;
		            default:
		                $msg = 'Oops, please try again.[msg_code='.$httpCode.']';
		                break;
		        }
		    }
		
		
	}

}



// Save Arrange Pages
if ( 
	 ( isset( $_POST['arrange_page_form_check'] ) && !empty( $_POST['arrange_page_form_check'] ) ) &&
	 ( isset( $_POST['page_id'] ) && !empty( $_POST['page_id'] ) ) && 
	 ( isset( $_POST['arrange_num'] ) && !empty( $_POST['arrange_num'] ) ) 
  ) 
{

	
	if ( $_POST['arrange_page_form_check'] === 'oual_con_arrange_page_form' ) {
		
		foreach ($_POST['page_id'] as $key => $PageID) {
			
			$data = array('page_num' => $_POST['arrange_num'][$key]);
			$where = array('id' => $PageID);

			//echo $PageID .'Page ID ='. $_POST['arrange_num'][$key].'<br>';
			$wpdb->update( $user_con_all_pages_table, $data, $where);
		
		}
		
	}

}


// get contributors list

if ( @$_GET['auto_gen'] == 1 ) {
		
		$project_id = $_GET['project_id'];
		$user_id = $_GET['user_id'];
		
		$get_data = $wpdb->get_results( "SELECT * FROM $user_contributors_table 
			WHERE project_id = '$project_id'
		");

		echo '<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">';
		foreach ($get_data as $value){

			echo $value->name.'<hr>';

		}
		echo '</div>';
}


if ( @$_GET['auto_gen'] == 2 ) {
		
		$project_id = $_GET['project_id'];
		$user_id = $_GET['user_id'];
		
		$get_data = $wpdb->get_results( "SELECT * FROM $user_contributors_table 
			WHERE project_id = '$project_id'
		");
		
		echo '<div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example" tabindex="0">';

		foreach ($get_data as $value){

			echo '<div class="mb-3">
				<input type="hidden" name="con_id" value="'.$value->id.'">
			  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value="'.$value->name.'" name="user_contributors">
			</div>';
		}
		echo '</div>';
	
}


// Save edit contributors list
if ( 
	 ( isset( $_POST['edit_con_form_check'] ) && !empty( $_POST['edit_con_form_check'] ) )  && 
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) )  &&
	 ( isset( $_POST['edit_con_status'] ) && !empty( $_POST['edit_con_status'] ) ) ||
	 ( isset( $_POST['user_con_data'] ) && !empty( $_POST['user_con_data'] ) ) &&
	 ( isset( $_POST['con_id'] ) && !empty( $_POST['con_id'] ) )
  ) 
{

	$project_id = $_POST['project_id'];

	if ( $_POST['edit_con_form_check'] === 'oual_editcon_list_form' ) {
		
			if($_POST['edit_con_status'] == 2){
				foreach ($_POST['con_id'] as $key => $ConID) {
					//echo $_POST['user_con_data'][$key];
					$data = array('name' => $_POST['user_con_data'][$key]);
					$where = array('id' => $ConID);

					$wpdb->update( $user_contributors_table, $data, $where);

				}
			}

			//$_POST['edit_con_status'];

			$data1 = array(
				'page_status'	=> $_POST['edit_con_status']
			);

			$where = array(
				'project_id' 	=> $project_id, 
				'page_name' 	=> 'edit_contributors_list');
			
			$wpdb->update( $memory_book_page_settings, $data1, $where);
		
	}

}



// Save page settings
if ( 
	 ( isset( $_POST['edit_con_form_check'] ) && !empty( $_POST['edit_con_form_check'] ) ) &&
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) ) &&
	 ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) 
  ) 
{

	
	if ( $_POST['edit_con_form_check'] === 'oual_editpage_settings_form' ) {
		
			$user_id 	= $_POST['user_id'];
			$project_id = $_POST['project_id'];

			$data = array(
				'user_id' 		=> $user_id,
				'project_id'	=> $project_id,
				'page_name'		=> 'edit_contributors_list',
				'page_status'	=> 3,
				'date_added'	=> date("Y-m-d H:i:s")
			);

			$data1 = array(
				'page_status'	=> 3
			);

			$where = array(
				'user_id' 		=> $user_id ,
				'project_id' 	=> $project_id, 
				'page_name' 	=> 'edit_contributors_list'
			);

			//check if the page name is existed
			$res = $wpdb->get_row( "SELECT count(*) as count 
				FROM $memory_book_page_settings
				WHERE user_id = '$user_id' 
				AND project_id = '$project_id'
				AND page_name = 'edit_contributors_list'
			");

			$num = $res->count;

			//check of the page status is on
			$res1 = $wpdb->get_row( "SELECT count(*) as count 
				FROM $memory_book_page_settings WHERE user_id = '$user_id' 
				AND project_id = '$project_id' AND page_name = 'edit_contributors_list'
				AND page_status != 3
			");

			
			$num1 = $res1->count;

			if($num == 0){

				$wpdb->insert( $memory_book_page_settings, $data);
				echo 'success';
				//$wpdb->update( $memory_book_page_settings, $data, $where);
			}
			else{

				if($num1 == 1)
				{
					$wpdb->update( $memory_book_page_settings, $data1, $where);
					echo 'success';
				}
				else{
					echo 'error';
				}
			}

			//$wpdb->insert( $memory_book_page_settings, $data);
	
		
	}

}


// Submit Edit Cover Page
if ( 
	 ( isset( $_POST['edit_cover_form_check'] ) && !empty( $_POST['edit_cover_form_check'] ) ) &&
	 ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) && 
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) ) && 
	 ( isset( $_POST['edit_front_cover_project_photo'] ) && !empty( $_POST['edit_front_cover_project_photo'] ) ) &&
	 ( isset( $_POST['edit_back_cover_project_photo'] ) && !empty( $_POST['edit_back_cover_project_photo'] ) ) && 
	 ( isset( $_POST['project_title'] ) && !empty( $_POST['project_title'] ) ) &&
	 ( isset( $_POST['project_back_title'] ) && !empty( $_POST['project_back_title'] ) )
  ) 
{

	
	if ( $_POST['edit_cover_form_check'] === 'oual_edit_cover_page_form' ) {
		
		

		$post_data = array(

			'project_photo' => $_POST['edit_front_cover_project_photo'],
			'project_back_photo' => $_POST['edit_back_cover_project_photo'],
			'full_name' => $_POST['project_title'],
			'project_back_title' => $_POST['project_back_title'],
			'project_updates' => date("Y-m-d H:i:s")

		);


		
		//update project details table field name 
		$where = array('project_slug' => $_POST['project_id'], 'user_id' => $_POST['user_id']);
		$update_data = $wpdb->update( $user_project_table, $post_data, $where);
			
		if($update_data == 1){
			echo 'success';
		}
		else{
			echo 'error';
		}
		
	}

}



// Add Questions
if ( 
	 ( isset( $_POST['question_form_check'] ) && !empty( $_POST['question_form_check'] ) ) &&
	 ( isset( $_POST['question'] ) && !empty( $_POST['question'] ) ) 
  ) 
{

	
	if ( $_POST['question_form_check'] === 'oual_question_page_form' ) {
		
		$post_data = array(

			'question' => $_POST['question'],
			'date_added' => date("Y-m-d H:i:s")

		);
		
		$add_data = $wpdb->insert($memory_book_questions, $post_data);
			
		if($add_data == 1){
			echo 'success';
		}
		else{
			echo 'error';
		}
		
	}

}


// Edit Questions
if ( 
	 ( isset( $_POST['edit_question_form_check'] ) && !empty( $_POST['edit_question_form_check'] ) ) &&
	 ( isset( $_POST['question'] ) && !empty( $_POST['question'] ) ) &&
	 ( isset( $_POST['question_id'] ) && !empty( $_POST['question_id'] ) ) 
  ) 
{

	
	if ( $_POST['edit_question_form_check'] === 'oual_edit_question_page_form' ) {
		
		$post_data = array(

			'question' => $_POST['question'],
			'updates' => date("Y-m-d H:i:s")

		);

		$where = array('id' => $_POST['question_id']);

		$edit_data = $wpdb->update($memory_book_questions, $post_data, $where);
			
		if($edit_data == 1){
			echo 'success';
		}
		else{
			echo 'error';
		}
		
	}

}


// delete Questions
if ( 
	 ( isset( $_POST['del_question_form_check'] ) && !empty( $_POST['del_question_form_check'] ) ) &&
	 ( isset( $_POST['question_id'] ) && !empty( $_POST['question_id'] ) ) 
  ) 
{

	
	if ( $_POST['del_question_form_check'] === 'oual_del_question_page_form' ) {
		
		$where = array('id' => $_POST['question_id']);

		$del_data = $wpdb->delete($memory_book_questions, $where);
			
		if($del_data == 1){
			echo 'success';
		}
		else{
			echo 'error';
		}
		
	}

}


if ( @$_GET['user_email']) {

	$user_email = $_GET['user_email'];

	$memory_book_contributors = $wpdb->prefix . 'memory_book_contributors';
	$data_con = $wpdb->get_results( "SELECT * FROM $memory_book_contributors WHERE `email_address` = '$user_email'" );
	$Num = count($data_con);


	if($Num > 0)
	{
		echo 'success';
	}
	else{ 
		echo 'error';	
	}

}


if ( @$_GET['get_ques'] == 1) {



	$memory_book_questions = $wpdb->prefix . 'memory_book_questions';
	$get_data = $wpdb->get_results( "SELECT * FROM $memory_book_questions" );

		$i = 1;
		foreach ($get_data as $value) {
			
			echo '
			<div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label" style="float:left;">
                	'.$i++.'.) '.$value->question.'
                </label>
                <input type="hidden" name="question_id" value="'.$value->id.'">
                <input type="text" class="form-control"  name="answer" id="answer" placeholder="Write your answer">
            </div>';
		}
	

}


// Save Questions Answer 
if ( 
	 ( isset( $_POST['save_question_form_check'] ) && !empty( $_POST['save_question_form_check'] ) ) &&
	 ( isset( $_POST['contributor_id'] ) && !empty( $_POST['contributor_id'] ) ) &&
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) ) &&
	 ( isset( $_POST['question_id'] ) && !empty( $_POST['question_id'] ) ) &&
	 ( isset( $_POST['answer'] ) && !empty( $_POST['answer'] ) ) &&
	 ( isset( $_POST['love_one'] ) && !empty( $_POST['love_one'] ) )
  ) 
{

	
	if ( $_POST['save_question_form_check'] === 'oual_save_question_page_form' ) {
		

		foreach ($_POST['question_id'] as $key => $question) {

		

			$post_data = array(

				'contributor_id' 	=> $_POST['contributor_id'],
				'project_id' 		=> $_POST['project_id'],
				'question_id'		=> $question,
				'answer' 			=> $_POST['answer'][$key],
				'love_one' 			=> $_POST['love_one'],
				'date_added' 		=> date("Y-m-d H:i:s")

			);
			
			$add_data = $wpdb->insert($memory_book_question_answer, $post_data);

		}
			
		if($add_data == 1){
			echo 'success';
		}
		else{
			echo 'error';
		}
		
	}

}



// Send pdf to organizer
if ( 
	 ( isset( $_POST['send_pdf_to_org_form_check'] ) && !empty( $_POST['send_pdf_to_org_form_check'] ) ) &&
	 ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) &&
	 ( isset( $_POST['project_id'] ) && !empty( $_POST['project_id'] ) ) 
  ) 
{

	

	if ( $_POST['send_pdf_to_org_form_check'] === 'oual_send_pdf_to_org_form' ) {
		
			
			

			$pdf = new PDF_MemImage();
			$pdf->AddPage();

			// Load an image into a variable
			$project_details  				= get_project_details( $_POST['project_id'] );
			$all_pages       				= get_contributors_all_pages( $_SESSION['user_id'], $_POST['project_id'] );
			$get_page_stteings_edit_con_page= get_page_stteings_edit_con_page(  $_SESSION['user_id'], $_POST['project_id']);
			$get_project_contributors      	= get_project_contributors( $_POST['project_id']);

			$get_project_user      			= get_user_details( $project_details[0]->user_id);

			$email = $get_project_user->email_address;
			$project_id = $_POST['project_id'];

			
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

			   		$get_project_con_question = get_con_question_and_answer($gpc->id, $project_id);
			   		$get_project_con_question_lo = get_con_question_and_answer_love_one($gpc->id, $project_id);

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
					$pdf->Cell(30,10,'Love One'.' ( '.@$get_project_con_question_lo->love_one.' )',0,0,'L');
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

		$file = $plugins_dir.'/oual-memory-book/dashboard/uploaded_pdf/'.$email.'-'.$project_details[0]->full_name.'.pdf';
		
		$file_download = $pdf->Output('F', $file);

		
		// Source file and watermark config 
		$doc_file = '../dashboard/uploaded_pdf/'.$email.'-'.$project_details[0]->full_name.'.pdf'; 
		$text_image = $img_watermark; 

		// Set source PDF file 
		$pdf = new Fpdi(); 
		if(file_exists("./".$doc_file)){ 
		    $pagecount = $pdf->setSourceFile($doc_file); 
		}else{ 
		    die('Source PDF not found!'); 
		} 
		 
		// Add watermark image to PDF pages 
		for($i=1;$i<=$pagecount;$i++){ 
		    $tpl = $pdf->importPage($i); 
		    $size = $pdf->getTemplateSize($tpl); 
		    $pdf->addPage(); 
		    $pdf->useTemplate($tpl, 1, 1, $size['width'], $size['height'], TRUE); 
		     
		    //Put the watermark 
		    $xxx_final = ($size['width']-150); 
		    $yyy_final = ($size['height']-175); 
		    $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
		} 
		
		$pdf->Output('F', $file);
	
		 
		//send email and attach the pdf compilation to organizer email
		$send_email = __download_pdf_book($email, $project_id, $file);

		if($send_email){
			echo 'success';
		}
		else{
			echo 'error';
		}
		
	}

}
?>