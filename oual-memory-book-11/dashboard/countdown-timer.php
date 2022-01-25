
<?php 
include_once 'utilities/dashboard-functions.php';

$project_details = get_project_details( $_GET['project_id'] );

$countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;

$countdown_timer_nw_format = date( 'Y-m-j H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) );

$reg_date = $project_details[0]->project_registered;

//echo '<br>';
//echo $countdown_timer_nw_format.'<br>';
//echo $project_details[0]->project_registered;
$now = date('Y-m-j H:i:s');
//$dateRegister = strtotime("+1 months", strtotime($reg_date));
//$date_reg = date("Y-m-j H:i:s", $dateRegister);
                            
    if($now >= $countdown_timer_nw_format){
        echo '<span class="badge bg-danger" style="float:right;">Project Expired!!!</span>';
    }
    else{

    echo '<span class="justify-content-end project_timer" data-reg="'.$countdown_timer.'"></span>';
    }
?>