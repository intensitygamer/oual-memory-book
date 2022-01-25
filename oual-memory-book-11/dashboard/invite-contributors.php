<?php

if (!defined('ABSPATH')) exit;

/**
* @author Once Upon A Legacy https://onceuponalife-time.com/
* @version 1.0
* Developer: John Patrick Tabanas
**/

$page_title = 'Invite Contributors - Dashboard';
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
                        
                        <?php $countdown_timer = date( 'M j, Y H:i:s',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>

                        <h2 class="mt-4 mb-4">Manage Contributors 
                            <?php require_once('countdown-timer.php');?>
                        </h2>

                        <ul class="nav nav-tabs" id="manageContributor" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="invite-contributor" data-bs-toggle="tab" data-bs-target="#invite" type="button" role="tab" aria-controls="invite" aria-selected="true">Invitation with submission reminders <i class="fas fa-question-circle deadline-info" data-bs-toggle="modal" data-bs-target="#invitationContributor"  title="About Invitation"></i></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="message-contributor" data-bs-toggle="tab" data-bs-target="#message" type="button" role="tab" aria-controls="message-contributor" aria-selected="false">Share collection page URL</button>
                            </li>
                        </ul>

                        <div class="tab-content pb-5" id="manageContributorContent">
                            <div class="tab-pane fade show active" id="invite" role="tabpanel" aria-labelledby="invite-contributor">
                                <div class="container pt-4">
                                    <p class="mb-4 email_invitation_text">Add emails for people you want to contribute to your memory book. Our system will automatically send out invitations and reminders. Add your email to see how it looks! <i>Please note you can add multiple emails at once just seperate it with commas.</i></p>

                                    <input class="form-control" type="text" placeholder="Add contributors email(s) here" aria-label="default input" name="email_contributors">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewInvitation">Review Invitation</button>
                                    </div>

                                    <?php if ( $contributors_list ): ?>
                                    <div class="table-responsive mt-4">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <td>#</td>
                                                    <td>Email Address</td>
                                                    <td>Contributed</td>
                                                    <td>Status</td>
                                                    <td>Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($contributors_list as $value): ?>
                                                <tr>
                                                    <th scope="row"><?php echo $value->id;?></td>
                                                    <td><?php echo $value->email_address;?></td>
                                                    <td>No</td>
                                                    <?php
                                                    switch ( $value->status ) {
                                                        case '2':
                                                            $contributor_status = '<span class="text-success">No Issues</span>';
                                                            break;
                                                        case '3':
                                                            $contributor_status = '<span class="text-success">Active</span>';
                                                            break;
                                                        case '4':
                                                            $contributor_status = '<span class="text-danger">Inactive</span>';
                                                            break;
                                                        default:
                                                            $contributor_status = '<span class="text-muted"> - </span>';
                                                            break;
                                                    }
                                                    ?>
                                                    <td><?php echo $contributor_status;?></td>
                                                    <td>
                                                        <a class="text-decoration-none del_contributor" href="javascript:void(0);" data-emailid="<?php echo $value->id;?>" data-contributor="<?php echo $value->project_id;?>">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>  
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="message" role="tabpanel" aria-labelledby="message-contributor">
                                <div class="container pt-4">
                                    <p class="mb-3">Copy the website URL below and email everyone with this link. Remember to send reminders as people often forget and procrastinate! </p>

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="<?php echo site_url().'/dashboard/?project='.$project_details[0]->project_slug;?>" aria-describedby="project-link-clipboard" readonly>
                                        <span class="input-group-text btn-primary" id="project-link-clipboard"><i class="fas fa-paste"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Modal For Deadline Information -->
<div class="modal fade" id="invitationContributor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="invitationContributorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invitationContributorLabel">Contributors Invitation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Our automated system sends invitations and reminders so you can "set it and forget it"! When you add contributor emails, we send out an invitation such as the example below. It uses the message you crafted to contributors from your collection page. </p>

                <p>The deadline by default for every project is setup for <strong>30 days</strong> from date of registration.</p>

                <p>We’ll send messages on your behalf reminding contributors to submit their memories leading up to the date.</p>

                <p>We also send reminders as the deadline approaches. Reminders are sent <strong>3 weeks</strong>, <strong>2 weeks</strong>, <strong>1 weeks</strong>, <strong>3 days</strong>, <strong>1 days</strong> from the deadline.</p>

                <p>Please do not be alarmed. We don’t want anyone blocked at this 30 days, we just want to encourage contributors to have their contributions completed within the 30 days.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal For Invitation -->
<div class="modal fade" id="reviewInvitation" tabindex="-1" aria-labelledby="reviewInvitationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewInvitationLabel">Please review the invite below:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8f8f8;">
                    <tbody>
                        <tr>
                            <td align="center" style="padding: 10px 0;"><img src="http://localhost/legacy/wp-content/plugins/oual-memory-book/assets/images/company-logo.png" alt="Company Logo" width="80"></td>
                        </tr>
                        <tr><td style="padding-bottom: 70px;">
                        <table width="70%" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;background-color: #fff;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" align="center">You're Invited!</td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 20px 0px 20px;" align="center">
                                    <img class="img-circle img-thumbnail img-max" style="display: block; padding: 0; color: #666666; text-decoration: none;" src="<?php echo $project_details[0]->project_photo;?>" width="200">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">
                                    <?php if ( $project_details[0]->project_type == 1 ): ?>
                                    <?php echo "In Loving Memory of ".$project_details[0]->full_name;?>
                                    <?php else: ?>
                                    <?php echo "Celebration of Life ".$project_details[0]->full_name;?>
                                    <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 20px 0 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">

                                        <?php $email_project_deadline = date( 'D, M j',strtotime('+30 days', strtotime( $project_details[0]->project_registered ) ) ) . PHP_EOL;?>

                                        We're organizing a book filled with contributions from the group. You've been invited to be a part of it! We are asking that you contribute by the deadline <?php echo $email_project_deadline;?>.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;padding-top: 25px;">
                                        <a href="<?php echo site_url().'/dashboard/?project='.$project_details[0]->project_slug;?>" style="background-color: #256F9C;color: #fff;font-size: 16px;font-family: Helvetica, Arial, sans-serif;text-decoration: none;border-radius: 3px;padding: 15px 25px;display: inline-block;">Check it Out</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 20px 40px 20px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" align="center">
                                        Let us know if you have any questions,<br> Team Once Upon A Legacy
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td></tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary contributors_invitation" data-project-slug="<?php echo $project_details[0]->project_slug;?>">Send Invitation</button>
            </div>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>