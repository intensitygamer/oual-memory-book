<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

// Include PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

/*function mail_credentials(){

	 	$mail->SMTPDebug = 0;
        $mail->isSMTP();
       // $mail->Host = 'onceuponalifetime.greenbeansph.com';
        $mail->Host = 'mocha3036.mochahost.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test@onceuponalegacy.net';
        $mail->Password = 'legacytest2021*!';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

}
*/

function __invite_contributors( $emails, $project_id ) {

	global $wpdb;

    $mail_msg = '';
    $mail = new PHPMailer(true);

    try {

    	$mail->SMTPDebug = 0;
        $mail->isSMTP();
       // $mail->Host = 'onceuponalifetime.greenbeansph.com';
        $mail->Host = 'mocha3036.mochahost.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test@onceuponalegacy.net';
        $mail->Password = 'legacytest2021*!';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
       
        if ( !empty( $project_id ) ) {

        	$project_table = $wpdb->prefix . 'memory_book_projects';
			$get_data = $wpdb->get_results( "SELECT * FROM $project_table WHERE `project_slug` = '$project_id'" );

			if ( $get_data ) {
				
				// From 
				$mail->setFrom( 'team@onceuponalifetime.com', $get_data[0]->full_name );

				// Subject
				if ( $get_data[0]->project_type == 1 ) {
					$mail->Subject = 'In Loving Memory Of '.$get_data[0]->full_name;
					$mail_content_header = 'In Loving Memory of '.$get_data[0]->full_name;
				} else {
					$mail->Subject = 'Celebration Of Life Of '.$get_data[0]->full_name;
					$mail_content_header = 'Celebration of Life '.$get_data[0]->full_name;
				}

				// Set Deadline
				$email_project_deadline = date( 'D, M j',strtotime('+30 days', strtotime( $get_data[0]->project_registered ) ) ) . PHP_EOL;

				// For non HTML
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				//Content
		        $mail->isHTML(true);

		        $mail->Body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8f8f8;">';
		        $mail->Body .= '<tbody>';
		        $mail->Body .= '<tr><td align="center" style="padding: 10px 0;"><img src="https://onceuponalifetime.greenbeansph.com/wp-content/uploads/2021/06/Legacy_logo_PNG-01-300x185.png" alt="Once Upon A Lifetime Logo" width="80"></td></tr>';
		        $mail->Body .= '<tr><td style="padding-bottom: 70px;">';
		        $mail->Body .= '<table width="50%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;background-color: #fff;">';
		        $mail->Body .= '<tbody>';
		        $mail->Body .= '<tr><td style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" align="center">You\'re Invited!</td></tr>';
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0px 20px;" align="center"><img class="img-circle img-thumbnail img-max" style="display: block; padding: 0; color: #666666; text-decoration: none;" src="'.$get_data[0]->project_photo.'" width="200"></td></tr>';
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">'.$mail_content_header.'</td></tr>';
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">We\'re organizing a book filled with contributions from the group. You\'ve been invited to be a part of it! We are asking that you contribute by the deadline '.$email_project_deadline.'.</td></tr>';
		        foreach ($emails as $value) {
		        $mail->Body .= '<tr><td style="text-align: center;padding-top: 25px;"><a href="'.site_url().'/dashboard/?project='.$get_data[0]->project_slug.'&dashboard=true&contributor=true&email='.$value.'" style="background-color: #256F9C;color: #fff;font-size: 16px;font-family: Helvetica, Arial, sans-serif;text-decoration: none;border-radius: 3px;padding: 15px 25px;display: inline-block;">Check it Out</a></td></tr>';
		    	}
		        $mail->Body .= '<tr><td style="padding: 20px 20px 40px 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">Let us know if you have any questions,<br> Team Once Upon A Legacy</td></tr>';
		        $mail->Body .= '</tbody></table>';
		        $mail->Body .= '</td></tr></tbody></table>';

		        //Recipients
		        foreach ($emails as $value) {
		        	
		        	$mail->addAddress( $value, 'Recipient');
		        	$return_msg = $mail->send();

			        if ( $return_msg ) {

			            $mail_msg = 'success';

			        }

			        $mail->ClearAddresses();

		        }

			}

        }

    } catch (Exception $e) {

        $mail_msg = "Mailer Error: ".$mail->ErrorInfo;

    }

    return $mail_msg;

}


function mail_submission_for_msg_contributors($email, $message, $user_id, $project_id) {

	global $wpdb;
	
	$user_table = $wpdb->prefix . 'memory_book_users';  
	$project_table = $wpdb->prefix . 'memory_book_projects';

	$check_user_exist = $wpdb->get_results( "SELECT * FROM $user_table WHERE `id` = '$user_id'" );

	$msg_from = $check_user_exist[0]->email_address;

	$get_data = $wpdb->get_results( "SELECT * FROM $project_table WHERE `project_slug` = '$project_id'" );

	
    $mail_msg = '';
    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
       // $mail->Host = 'onceuponalifetime.greenbeansph.com';
        $mail->Host = 'mocha3036.mochahost.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test@onceuponalegacy.net';
        $mail->Password = 'legacytest2021*!';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        //Recipients
        $mail->setFrom('noreply@onceuponalifetime.com', ''.$msg_from.'');
        $mail->addAddress($email, 'Contributors');

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Message regarding Once Upon A Legacy';

        $mail->Body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8f8f8;">';

		        $mail->Body .= '<tbody>';

		       // $mail->Body .= '<tr><td align="center" style="padding: 10px 0;"><img src="'.$get_data[0]->project_photo.'" alt="Once Upon A Legacy Logo" width="80"></td></tr>';

		        $mail->Body .= '<tr><td style="padding-bottom: 70px;">';

		        $mail->Body .= '<table width="50%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;background-color: #fff;">';
		        $mail->Body .= '<tbody>';

		        $mail->Body .= '<tr><td style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" align="center">Message from '.$msg_from.'</td></tr>';
		        
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0px 20px;" align="center"><img class="img-circle img-thumbnail img-max" style="display: block; padding: 0; color: #666666; text-decoration: none;" src="'.$get_data[0]->project_photo.'" width="200" alt="Once Upon A Legacy Logo"></td></tr>';

		        $mail->Body .= '<tr><td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">'.$message.'</td></tr>';
		    
		        $mail->Body .= '</tbody></table>';
		        $mail->Body .= '</td></tr></tbody></table>';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $return_msg = $mail->send();

        if ($return_msg) {

            $mail_msg = 'Success';

        }

    } catch (Exception $e) {

        $mail_msg = "Mailer Error: ".$mail->ErrorInfo;

    }

    return $mail_msg;

}



function __download_pdf_book( $emails, $project_id, $attachment ) {

	global $wpdb;

    $mail_msg = '';
    $mail = new PHPMailer(true);

    try {

        $mail->SMTPDebug = 0;
        $mail->isSMTP();
       // $mail->Host = 'onceuponalifetime.greenbeansph.com';
        $mail->Host = 'mocha3036.mochahost.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'test@onceuponalegacy.net';
        $mail->Password = 'legacytest2021*!';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        if ( !empty( $project_id ) ) {

        	$project_table = $wpdb->prefix . 'memory_book_projects';
			$get_data = $wpdb->get_results( "SELECT * FROM $project_table WHERE `project_slug` = '$project_id'" );

			if ( $get_data ) {
				
				// From 
				$mail->setFrom( 'team@onceuponalifetime.com', $get_data[0]->full_name );

				// Subject
				if ( $get_data[0]->project_type == 1 ) {
					$mail->Subject = 'In Loving Memory Of '.$get_data[0]->full_name;
					$mail_content_header = 'In Loving Memory of '.$get_data[0]->full_name;
				} else {
					$mail->Subject = 'Celebration Of Life Of '.$get_data[0]->full_name;
					$mail_content_header = 'Celebration of Life '.$get_data[0]->full_name;
				}

				// Set Deadline
				$email_project_deadline = date( 'D, M j',strtotime('+30 days', strtotime( $get_data[0]->project_registered ) ) ) . PHP_EOL;

				// For non HTML
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				//Content
		        $mail->isHTML(true);

		        $mail->Body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8f8f8;">';
		        $mail->Body .= '<tbody>';
		        $mail->Body .= '<tr><td align="center" style="padding: 10px 0;"><img src="https://onceuponalifetime.greenbeansph.com/wp-content/uploads/2021/06/Legacy_logo_PNG-01-300x185.png" alt="Once Upon A Lifetime Logo" width="80"></td></tr>';
		        $mail->Body .= '<tr><td style="padding-bottom: 70px;">';
		        $mail->Body .= '<table width="50%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;background-color: #fff;">';
		        $mail->Body .= '<tbody>';
		        $mail->Body .= '<tr><td style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" align="center">Congratulations!!!</td></tr>';
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0px 20px;" align="center"><img class="img-circle img-thumbnail img-max" style="display: block; padding: 0; color: #666666; text-decoration: none;" src="'.$get_data[0]->project_photo.'" width="200"></td></tr>';
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">'.$mail_content_header.'</td></tr>';
		        $mail->Body .= '<tr><td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">Please see the attachment pdf file of your project compilation....</td></tr>';
		        
		        $mail->Body .= '<tr><td style="text-align: center;padding-top: 25px;"><a style="background-color: #256F9C;color: #fff;font-size: 16px;font-family: Helvetica, Arial, sans-serif;text-decoration: none;border-radius: 3px;padding: 15px 25px;display: inline-block;">Thank You!!!</a></td></tr>';
		    	
		        $mail->Body .= '<tr><td style="padding: 20px 20px 40px 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">Let us know if you have any questions,<br> Team Once Upon A Legacy</td></tr>';
		        $mail->Body .= '</tbody></table>';
		        $mail->Body .= '</td></tr></tbody></table>';

		        //Recipients
		        //foreach ($emails as $value) {
		        	
		        	$mail->addAttachment($attachment);
		        	$mail->addAddress( $emails, 'Recipient');
		        	$return_msg = $mail->send();

			        if ( $return_msg ) {

			            $mail_msg = 'success';

			        }

			        $mail->ClearAddresses();

		       // }

			}

        }

    } catch (Exception $e) {

        $mail_msg = "Mailer Error: ".$mail->ErrorInfo;

    }

    return $mail_msg;

}

?>