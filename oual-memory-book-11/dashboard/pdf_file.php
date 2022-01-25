<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
    integrity="sha256-c9vxcXyAG4paArQG3xk6DjyW/9aHxai2ef9RpMWO44A=" crossorigin="anonymous"></script>

<?php
require "utilities/pdfcrowd.php";


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

if ( isset( $_GET['project_id'] ) && !empty( $_GET['project_id'] ) ) {

    $project_details  = get_project_details( $_GET['project_id'] );
    $user_id_session  = get_user_projects( $_SESSION['user_id'] );
    $all_pages       = get_contributors_all_pages( $_SESSION['user_id'], $_GET['project_id'] );
    $essay_pages      = get_contributors_essay_pages( $_SESSION['user_id'] );
    $get_project_contributors      = get_project_contributors( $_GET['project_id']);
    $get_page_stteings_edit_con_page      = get_page_stteings_edit_con_page(  $_SESSION['user_id'],$_GET['project_id']);

    $project_id = $_GET['project_id'];

}


try
{
    // create the API client instance
    $client = new \Pdfcrowd\HtmlToPdfClient("jewvill27", "d20128979f4a739c25c8d4a27a120d49");

    // run the conversion and store the result into the "pdf" variable
   // $pdf = $client->convertFile("/home/timprint/onceuponalegacy.net/bepi/wp-content/plugins/oual-memory-book/dashboard/design_1_1.php");

    // run the conversion and store the result into the "pdf" variable
    $pdf = $client->convertString('<div id="bloom1-meme" style="width:1388px; height:1000px; background:url('.OUAL_NAME_APP.'dashboard/design/Bloom.png); position:relative;"></div>');

    //echo $pdf;
    // at this point the "pdf" variable contains PDF raw data and
    // can be sent in an HTTP response, saved to a file, etc.
}
catch(\Pdfcrowd\Error $why)
{
    // report the error
    error_log("Pdfcrowd Error: {$why}\n");

    // rethrow or handle the exception
    throw $why;
}

?>