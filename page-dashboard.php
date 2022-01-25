<?php

if (!defined('ABSPATH')) exit;
/**
* Template Name: Memory Book Dashboard Page Template
*
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
*/

global $wpdb;
session_start();

if ( isset( $_GET['contributor'] ) && $_GET['contributor'] == 'true' ) {
	
	@$email = $_GET['email'];
	@$project = $_GET['project'];

	//if(!empty($contributors )){
	$user_contributors_table = $wpdb->prefix . 'memory_book_contributors';
	$check_user_contributors = $wpdb->get_results( "SELECT * FROM $user_contributors_table WHERE `project_id` = '$project'" );

	$db_project_id = $check_user_contributors[0]->project_id;

	$user_con_proj_table = $wpdb->prefix . 'memory_book_projects';
	$check_user_con_proj = $wpdb->get_results( "SELECT * FROM $user_con_proj_table WHERE `project_slug` = '$db_project_id'" );


	$_SESSION['user_id'] = $check_user_con_proj[0]->user_id;

	$_SESSION['con_email'] = $email;

	$_SESSION['db_project_id'] = $db_project_id;

	//header( 'Location: dashboard/?project_id='.$check_user_contributors[0]->project_id.'&dashboard=true' );

	//}

} 



if ( empty( $_SESSION['user_id'] ) ) {
	
	header( 'Location: login' );
	die();

} else {

	if ( isset( $_GET['project_status'] ) && !empty( $_GET['project_status'] ) ) {
	
		if ( $_GET['project_status'] == 'new' ) {
			
			include 'dashboard/new-project.php';
		}

		if ( $_GET['project_status'] == 'projects' ) {
			include 'dashboard/project-display.php';
		}

	} elseif ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {
		
		if ( isset( $_GET['contributors'] ) && $_GET['contributors'] == 'invite' ) {
			include 'dashboard/invite-contributors.php';
		} 

		elseif ( isset( $_GET['contributors'] ) && $_GET['contributors'] == 'message' ) {
			include 'dashboard/message-contributors.php';
		}

		elseif ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'true' ) 
		{
			include 'dashboard/collection-pages.php';
		} 
		elseif ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'meme' ) 
		{
			include 'dashboard/meme-page.php';
		} 
		elseif ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'long-essay' ) 
		{
			include 'dashboard/long-essay-page.php';
		} 
		elseif ( isset( $_GET['arrange_pages'] ) && $_GET['arrange_pages'] == 'true' ) 
		{
			include 'dashboard/arrange-pages.php';
		} 
		elseif ( isset( $_GET['create_pdf'] ) && $_GET['create_pdf'] == 'true' ) 
		{
			include 'dashboard/create-pdf.php';
		} 
		
		elseif ( isset( $_GET['contributors_list'] ) && $_GET['contributors_list'] == 'true' ) 
		{include 'dashboard/contributors-list.php';
		}
		elseif ( isset( $_GET['edit_cover'] ) && $_GET['edit_cover'] == 'true' ) 
		{
			include 'dashboard/edit-cover.php';
		}
		elseif ( isset( $_GET['collection_pages'] ) && $_GET['collection_pages'] == 'questionnaire' ) 
		{
			include 'dashboard/questionnaire-page.php';
		} 
		elseif ( isset( $_GET['questionnaire'] ) && $_GET['questionnaire'] == 'list' ) 
		{
			include 'dashboard/questionnaire-list.php';
		} 
		elseif ( isset( $_GET['design_layout'] ) && $_GET['design_layout'] == 'true' ) 
		{
			include 'dashboard/design_layout.php';
		} 
		elseif ( isset( $_GET['design1_1'] ) && $_GET['design1_1'] == 'true' ) 
		{
			include 'dashboard/design_1_1.php';
		} 
		elseif ( isset( $_GET['design1_2'] ) && $_GET['design1_2'] == 'true' ) 
		{
			include 'dashboard/design_1_2.php';
		} 
		elseif ( isset( $_GET['pdf_file'] ) && $_GET['pdf_file'] == 'true' ) 
		{
			include 'dashboard/pdf_file.php';
		} 
		else {
			include 'dashboard/dashboard.php';
		}
		

	} elseif ( ( isset( $_GET['email_id'] ) && !empty( $_GET['email_id'] ) ) && ( isset( $_GET['delete_contributors'] ) && !empty( $_GET['delete_contributors'] ) ) ) {
		
		$del_contributor_data = $wpdb->prefix . 'memory_book_contributors';
		$del_contributor_res = $wpdb->delete( $del_contributor_data, array( 'id' => $_GET['email_id'], 'project_id' => $_GET['delete_contributors'] ) );

		if ( $del_contributor_res ) {
			header( 'Location: ?project_id='.$_GET['delete_contributors'].'&contributors=invite' );
			die();
		}

	} elseif ( isset( $_GET['logout'] ) && $_GET['logout'] == 'true' ) {
		
		unset($_SESSION);
		session_destroy();

		header( 'Location: login' );
		die();

	} else {

		header( 'Location: login' );
		die();

	}

}


?>
