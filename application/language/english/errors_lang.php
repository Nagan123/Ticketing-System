<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

// General:
$lang['err_token_expired']          = 'The token is expired, you have to request for the change of password again.';
$lang['err_invalid_token']          = 'The authentication token is invalid or used.';
$lang['err_not_updated']            = 'Seems you\'ve not changed the data.';
$lang['err_invalid_req']            = 'The received request is invalid.';
$lang['err_went_wrong']             = 'Something went wrong, please try again later.';
$lang['err_invalid_input']          = 'Invalid input, please review your fields.';
$lang['err_temp_disabled']          = 'Sorry, the requested action is temporarily disabled.';
$lang['err_missing_keys']           = 'Missing related API key(s), please review the settings.';
$lang['err_missing_input']          = 'Missing input, please review the required (*) fields.';
$lang['err_failed_email']           = 'Email sent failed, there can be some issue in the configuration.';
$lang['err_failed_email_status']    = 'The mailing engine returned an unsuccessful status, please kindly review in the receiver\'s inbox before trying again.';
$lang['err_slug_exists']            = 'This slug must be unique for each post.';
$lang['err_missing_email_config_a'] = 'Sorry, cannot proceed, the mailing part is not configured yet.';
$lang['err_missing_parent_cat']     = 'Invalid request, missing parent category.';
$lang['err_delete_subcategories']   = 'Please delete the belonging subcategories to delete it.';
$lang['err_missing_message']        = 'The message is required if the <q>Show this Message</q> is checked as <q>Yes</q>.';
$lang['err_recaptcha']              = 'Please make sure that you have successfully solved the Google reCaptcha.';
$lang['err_401']                    = '401 - Sorry, you request cannot be processed because of unauthorization.';
$lang['err_403']                    = '403 - Sorry, the server is refused to accept your request.';
$lang['err_404']                    = '404 - Sorry, the requested file is not found on the server.';
$lang['err_500']                    = '500 - Sorry, your request cannot be processed because of technical issues.';
$lang['err_502']                    = '502 - Sorry, the server is not able to handle this request.';
$lang['err_503']                    = '503 - Sorry, currently the server is not able to handle this request.';
$lang['err_nounread_notifications'] = 'Sorry, there are no unread notifications found.';

// Users:
$lang['err_not_logged_in']          = 'Account login is required to perform this action.';
$lang['err_req_logged_in']          = 'You are not logged in, please login to continue.';
$lang['err_already_registered']     = 'The user with this email address is already registered.';
$lang['err_already_logged_in']      = 'You are already logged in.';
$lang['err_invalid_credentials']    = 'Invalid credentials, please try again.';
$lang['err_email_not_changed']      = 'Failed to change the email address.';
$lang['err_missing_passwords']      = 'Please review the password fields.';
$lang['err_passwords_unmatched']    = 'The passwords are not matched, please review the fields.';
$lang['err_passwords_match']        = 'Password and Retype Password fields must be same.';
$lang['err_wrong_password']         = 'Invalid current password.';
$lang['err_invalid_email']          = 'Invalid email address.';
$lang['err_user_banned']            = 'Your account has been banned from this site.';
$lang['err_pass_reset_token_req']   = 'In the last 15 minutes, you have already requested a password reset.';
$lang['err_too_many_attempts']      = 'Too many invalid attempts, please kindly wait for %s before trying again.';
$lang['err_registration_disabled']  = 'Sorry, the user registration is temporarily disabled.';
$lang['err_reg_add_sess']           = 'The user is successfully registerd but, failed to login. Please try to login directly.';
$lang['err_send_pass_fe']           = 'The user is successfully registerd but, password sending is failed.';
$lang['err_ev_token_update_failed'] = 'Failed to set the email verification token.';
$lang['err_ic_expired']             = 'Invalid invitation code, the code is used or expired.';
$lang['err_ic_invalid']             = 'Invalid invitation code.';
$lang['err_invalid_invitation']     = 'Invalid request, no invitation is found for this code.';
$lang['err_other_provider']         = 'The user with this account\'s email address is already registered with another source.';
$lang['err_cant_impersonate']       = 'You cannot start impersonation with this as you already in.';
$lang['err_user_cant_delete']       = 'You cannot delete yourself.';
$lang['err_already_verified']       = 'This user is already verified.';
$lang['err_cant_delete_du']         = 'The default user cannot be deleted.';
$lang['err_email_taken']            = 'The email address is already taken.';
$lang['err_username_taken']         = 'The username is already taken.';
$lang['err_already_email_pending']  = 'The inputted email address is already pending.';
$lang['err_pwd_strong']             = 'The Password field must contain, number, letter, and special character with a minimum of 12 characters.';
$lang['err_pwd_medium']             = 'The Password field must contain, number, and lower and uppercase letter with a minimum of 8 characters.';
$lang['err_pwd_normal']             = 'The Password field must contain, number, and letter with a minimum of 6 characters.';
$lang['err_pwd_low']                = 'The Password field length must be at least 6 characters.';
$lang['err_same_password']          = 'Seems your password is the same as before, this must be different.';
$lang['err_u_change_not_allowed']   = 'Password, Role, and Status are not allowed to change for the default user.';
$lang['err_invalid_language']       = 'Invalid language input, please refresh your page and try again.';
$lang['err_login_to_chat']          = 'Please login to your account and reload your page to continue the chatting.';

// Support:
$lang['err_ticket_closed']          = 'The reply cannot be added to the closed ticket.';
$lang['err_invalid_priority']       = 'Invalid priority value, please refresh your page and try again.';
$lang['err_invalid_department']     = 'Invalid department, please refresh your page and try again.';
$lang['err_ticket_fe']              = 'The reply is successfully added but, email notification sending is failed.';
$lang['err_missing_team_users']     = 'Please select at least one user for this department.';
$lang['err_not_updated_user']       = 'Seems the record is already assigned to the selected user.';
$lang['err_cant_self_assign']       = 'The user that is going to be assigned to this ticket, must not be its requester.';
$lang['err_cant_self_assign_chat']  = 'The user that is going to be assigned to this chat, must not be its requester.';
$lang['err_delete_faqs']            = 'Please delete the belonging FAQs to delete it.';
$lang['err_delete_articles']        = 'Please delete the belonging articles to delete it.';
$lang['err_assigned_no_template']   = 'Successfully assigned but, email template for the related hook or language is not found.';
$lang['err_already_voted']          = 'Sorry, you\'ve already voted for this article.';
$lang['err_delete_dep_tickets']     = 'Please delete the belonging tickets to delete it.';
$lang['err_already_chatting']       = 'Sorry, you already have an active chat, please end that chat first.';
$lang['err_cant_assign_closed']     = 'Sorry, the closed ticket cannot be assigned until it is reopened.';
$lang['err_cant_assign_ended']      = 'Sorry, the ended chat cannot be assigned until it is reactivated.';
$lang['err_chat_ended']             = 'The reply cannot be added to the ended chat.';
$lang['err_no_chat_available']      = 'Sorry, no agents are online at that moment, please try again later or create a new ticket.';
$lang['err_already_verified']       = 'Sorry, cannot proceed, the record is already verified.';
$lang['err_reached_limited']        = 'Sorry, cannot proceed, you have reached the maximum limit.';
$lang['err_resend_wait_one_minute'] = 'After you resent it, you will have to wait for one minute before making another attempt.';

// Settings:
$lang['err_missing_mm_message']     = 'Please leave a maintenance mode message for the visitors.';
$lang['err_invalid_avatar_size']    = 'Invalid input passed for the maximum avatar size.';
$lang['err_invalid_ak']             = 'Invalid format passed for the access key field.';
$lang['err_role_exists']            = 'This role is already exists.';
$lang['err_review_ip']              = 'Invalid IP(s) found, please review the IP addresses field.';

// Tools:
$lang['err_missing_template']       = 'Email template for this hook or language is not found.';
$lang['err_et_exists']              = 'Email template for this hook and language is already exists.';

// Custom Fields:
$lang['err_options_req']            = 'The Options field is required for the selected field type.';
