<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

//Loads Wordpress Environment And Template
//include('wp-load.php');

function get_project_details( $slug ) {

	global $wpdb;

	if ( !empty( $slug ) ) {

		$project_table = $wpdb->prefix . 'memory_book_projects';
		$get_data = $wpdb->get_results( "SELECT * FROM $project_table WHERE `project_slug` = '$slug'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}

function get_user_projects( $user_id ) {

	global $wpdb;

	if ( !empty( $user_id ) ) {

		$project_table = $wpdb->prefix . 'memory_book_projects';
		$get_data = $wpdb->get_results( "SELECT * FROM $project_table WHERE `user_id` = '$user_id'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}

function get_project_contributors( $project_id ) {

	global $wpdb;

	if ( !empty( $project_id ) ) {

		$contributors_table = $wpdb->prefix . 'memory_book_contributors';
		$get_data = $wpdb->get_results( "SELECT * FROM $contributors_table WHERE `project_id` = '$project_id'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}


function get_contributors_all_pages( $user_id, $project_id ) {

	global $wpdb;

	if ( !empty( $user_id ) ) {

		$contributors_meme_page_table = $wpdb->prefix . 'memory_book_contributors_meme_page';
		$contributors_essay_page_table = $wpdb->prefix . 'memory_book_contributors_long_essay_page';
		$user_con_all_pages_table = $wpdb->prefix . 'memory_book_contributors_all_pages';

		$get_data = $wpdb->get_results( "SELECT *, a.id as order_id FROM $user_con_all_pages_table AS a, $contributors_meme_page_table AS m, $contributors_essay_page_table AS e
			 WHERE 
			 a.page_id = m.id 
			 AND a.user_id = '$user_id' 
			 AND a.project_id = '$project_id'
			 OR 
			 a.page_id = e.id 
			 AND a.user_id = '$user_id' 
			 AND a.project_id = '$project_id' 
			 GROUP BY a.id
			 ORDER BY a.page_num ASC 
			 " );

		if ( $get_data ) {
			return $get_data;
		}

	}

}


function get_contributors_essay_pages( $user_id ) {

	global $wpdb;

	if ( !empty( $user_id ) ) {

		$contributors_essay_page_table = $wpdb->prefix . 'memory_book_contributors_long_essay_page';
		$get_data = $wpdb->get_results( "SELECT * FROM $contributors_essay_page_table WHERE `user_id` = '$user_id'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}


function get_page_stteings_edit_con_page( $user_id, $project_id) {

	global $wpdb;

	if ( !empty( $user_id ) ) {

		$memory_book_page_settings = $wpdb->prefix . 'memory_book_page_settings';
		$get_data = $wpdb->get_results( "SELECT * FROM $memory_book_page_settings WHERE `user_id` = '$user_id' AND project_id = '$project_id' AND page_name = 'edit_contributors_list'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}



function get_questions() {

	global $wpdb;

	//if ( !empty( $user_id ) ) {

		$memory_book_questions = $wpdb->prefix . 'memory_book_questions';
		$get_data = $wpdb->get_results( "SELECT * FROM $memory_book_questions" );

		if ( $get_data ) {
			return $get_data;
		}

	//}

}


function get_user_details($user_id) {

	global $wpdb;

	if ( !empty( $user_id ) ) {

		$memory_book_user = $wpdb->prefix . 'memory_book_users';
		$get_data = $wpdb->get_row( "SELECT * FROM $memory_book_user WHERE `id` = '$user_id'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}

function get_user_details_by_email($email) {

	global $wpdb;

	if ( !empty( $email ) ) {

		$memory_book_user = $wpdb->prefix . 'memory_book_users';
		$get_data = $wpdb->get_row( "SELECT * FROM $memory_book_user WHERE `email_address` = '$email'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}



function get_con_details($email) {

	global $wpdb;

	if ( !empty( $email ) ) {

		$memory_book_con = $wpdb->prefix . 'memory_book_contributors';
		$get_data = $wpdb->get_row( "SELECT * FROM $memory_book_con WHERE `email_address` = '$email'" );

		if ( $get_data ) {
			return $get_data;
		}

	}

}


function get_con_question_and_answer($con_id, $project_id) {

	global $wpdb;

	//if ( !empty( $email ) ) {

		$memory_book_question_answer = $wpdb->prefix . 'memory_book_question_answer';
		$memory_book_question = $wpdb->prefix . 'memory_book_questions';

		$get_data = $wpdb->get_results( "SELECT * FROM 
			$memory_book_question_answer AS qa, $memory_book_question AS bq
			WHERE qa.question_id = bq.id AND
			qa.contributor_id = '$con_id' AND qa.project_id = '$project_id' 
			GROUP BY qa.question_id
		" );

		if ( $get_data ) {
			return $get_data;
		}

	//}

}


function get_con_question_and_answer_love_one($con_id, $project_id) {

	global $wpdb;

	//if ( !empty( $email ) ) {

		$memory_book_question_answer = $wpdb->prefix . 'memory_book_question_answer';
		$memory_book_question = $wpdb->prefix . 'memory_book_questions';

		$get_data = $wpdb->get_row( "SELECT * FROM 
			$memory_book_question_answer AS qa, $memory_book_question AS bq
			WHERE qa.question_id = bq.id AND
			qa.contributor_id = '$con_id' AND qa.project_id = '$project_id' 
			GROUP BY qa.question_id
		" );

		if ( $get_data ) {
			return $get_data;
		}

	//}

}




?>