<?php
// Install Script

global $wpdb;

// 1. Create memory_book_users table (If table not in database. Create new table)
$memory_book_users = $wpdb->prefix.'memory_book_users';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_users'" ) != $memory_book_users ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`email_address` varchar(100) NOT NULL,
	`password` varchar(255) NOT NULL,
	`access_level` int(11) NOT NULL DEFAULT 1,
	`user_registered` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}

// 2. Create memory_book_projects table (If table not in database. Create new table)
$memory_book_projects = $wpdb->prefix.'memory_book_projects';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_projects'" ) != $memory_book_projects ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_projects` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(12) NOT NULL,
	`project_type` tinyint(4) NOT NULL COMMENT '1 = In Loving Memory, 2 = Celebration of Like',
	`full_name` varchar(100) NOT NULL,
	`date_of_birth` date NOT NULL,
	`date_of_death` date NOT NULL,
	`project_photo` varchar(255) NOT NULL,
	`project_back_photo` varchar(255) NULL,
	`project_back_title` varchar(100) NULL,
	`project_slug` varchar(10) NOT NULL,
	`project_registered` datetime NOT NULL,
	`project_status` tinyint(4) NOT NULL COMMENT '1 = active, 2 = expired',
	`project_updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}

// 3. Create memory_book_contributors table (If table not in database. Create new table)
$memory_book_contributors = $wpdb->prefix.'memory_book_contributors';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_contributors'" ) != $memory_book_contributors ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_contributors` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`project_id` varchar(15) NOT NULL,
	`email_address` varchar(150) NOT NULL,
	`name` varchar(150) NOT NULL,
	`status` tinyint(4) NOT NULL COMMENT '1 = Default, 2 = Have no issues, 3 = Active, 4 = Inactive',
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}


// 4. Create memory_book_contributors_meme_page table (If table not in database. Create new table)
$memory_book_contributors_meme_page = $wpdb->prefix.'memory_book_contributors_meme_page';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_contributors_meme_page'" ) != $memory_book_contributors_meme_page ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_contributors_meme_page` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(12) NOT NULL,
	`project_id` varchar(15) NOT NULL,
	`meme_project_photo` varchar(255) NOT NULL,
	`top_line_for_meme` varchar(100)  NULL,
	`bottom_line_for_meme` varchar(100) NULL,
	`nickname` varchar(100) NOT NULL,
	`email_address` varchar(100) NOT NULL,
	`contribute_with_others` int(1) NOT NULL COMMENT '1 = yes, 2 = no',
	`organizer` int(1) NOT NULL COMMENT '1 = yes, 2 = no',
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}


// 5. Create memory_book_contributors_long_essay_page table (If table not in database. Create new table)
$memory_book_contributors_long_essay_page = $wpdb->prefix.'memory_book_contributors_long_essay_page';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_contributors_long_essay_page'" ) != $memory_book_contributors_long_essay_page ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_contributors_long_essay_page` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(12) NOT NULL,
	`project_id` varchar(15) NOT NULL,
	`essay` text NOT NULL,
	`nickname` varchar(100) NOT NULL,
	`email_address` varchar(100) NOT NULL,
	`contribute_with_others` int(1) NOT NULL COMMENT '1 = yes, 2 = no',
	`organizer` int(1) NOT NULL COMMENT '1 = yes, 2 = no',
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}


// 6. Create memory_book_contributors_all_pages table (If table not in database. Create new table)
$memory_book_contributors_all_pages = $wpdb->prefix.'memory_book_contributors_all_pages';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_contributors_all_pages'" ) != $memory_book_contributors_all_pages ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_contributors_all_pages` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(12) NOT NULL,
	`project_id` varchar(15) NOT NULL,
	`page_id` int(12) NOT NULL,
	`page_num` varchar(50) NOT NULL,
	`pages_type` int(1) NOT NULL COMMENT '1 = meme, 2 = essay, 3 = questionnaire, 4 = design',
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}


// 7. Create memory_book_page_settings table (If table not in database. Create new table)
$memory_book_page_settings = $wpdb->prefix.'memory_book_page_settings';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_page_settings'" ) != $memory_book_page_settings ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_page_settings` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(12) NOT NULL,
	`project_id` varchar(15) NOT NULL,
	`page_name` varchar(200) NOT NULL,
	`page_status` int(11) NOT NULL,
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}


// 8. Create memory_book_questionnaire_page table (If table not in database. Create new table)
$memory_book_questions = $wpdb->prefix.'memory_book_questions';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_questions'" ) != $memory_book_questions ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_questions` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`question` varchar(255) NOT NULL,
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}

// 9. Create memory_book_question_answer table (If table not in database. Create new table)
$memory_book_question_answer = $wpdb->prefix.'memory_book_question_answer';

if ( $wpdb->get_var( "SHOW TABLES LIKE '$memory_book_question_answer'" ) != $memory_book_question_answer ) {

	$memory_book_sql = "CREATE TABLE IF NOT EXISTS `$memory_book_question_answer` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`contributor_id` int(11) NOT NULL,
	`project_id` varchar(255) NOT NULL,
	`question_id` int(11) NOT NULL,
	`love_one` varchar(255) NOT NULL,
	`answer` varchar(255) NOT NULL,
	`date_added` datetime NOT NULL,
	`updates` timestamp NOT NULL DEFAULT current_timestamp(),
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

	$wpdb->query( $memory_book_sql );
	
}

?>