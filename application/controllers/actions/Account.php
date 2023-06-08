<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Account Controller ( Actions )
 *
 * @author Shahzaib
 */
class Account extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->library( 'form_validation' );
        $this->load->model( 'User_model' );
        $this->load->model( 'Login_model' );
    }
    
    /**
     * Set Main Login
     *
     * @param  string  $token
     * @parma  integer $user_id
     * @return void
     */
    private function set_main_login( $token, $user_id )
    {
        if ( set_login( $token, $user_id ) )
        {
            r_s_jump( get_after_login_location() );
        }
        
        r_error_gr( 'went_wrong' );
    }
    
    /**
     * Login Page Input Handling.
     *
     * @return void
     */
    public function login()
    {
        if ( $this->zuser->is_logged_in ) r_error_gr( 'already_logged_in' );
        
        $user_token = get_long_random_string();
        
        if ( $this->form_validation->run( 'login' ) )
        {
            if ( ! submit_gr() ) r_error( 'recaptcha' );
            
            $username = do_secure_l( post( 'username' ) );
            
            // Check the account status throught the user login attempts:
            if ( db_config( 'u_temporary_lockout' ) !== 'off' )
            {
                user_locally_locked_check( $username );
            }
            
            if ( filter_var( $username, FILTER_VALIDATE_EMAIL ) )
            {
                $user = $this->User_model->get_by_email( $username );
            }
            else
            {
                $user = $this->User_model->get_by_username( $username );
            }
            
            if ( ! empty( $user ) )
            {   
                if ( ! password_verify( post( 'password' ), $user->password ) )
                {
                    $this->Login_model->log_invalid_attempt( $username );
                    r_error_gr( 'invalid_credentials' );
                }
                
                $this->Login_model->delete_invalid_attempt( $username );
                
                if ( $user->status == 0 )
                {
                    r_error_gr( 'user_banned' );
                }
                
                $this->set_main_login( $user_token, $user->id );
            }
            else
            {
                $this->Login_model->log_invalid_attempt( $username );
                r_error_gr( 'invalid_credentials' );
            }
        }
        
        d_r_error_gr( validation_errors() );
    }
    
    /**
     * Forgot Password Page Input Handling.
     *
     * @return void
     */
    public function request_password()
    {
        if ( db_config( 'u_reset_password' ) == 0 ) r_error_gr( 'temp_disabled' );
        else if ( $this->zuser->is_logged_in ) r_error_gr( 'already_logged_in' );
        else if ( ! is_email_settings_filled() ) r_error_gr( 'missing_email_config_a' );
        
        $recent_log = $this->Login_model->password_reset_log();
        
        if ( ! empty( $recent_log ) )
        {
            if ( $recent_log->requested_at > subtract_time( '15 minutes' ) )
            {
                r_error_gr( 'pass_reset_token_req' );
            }
        }
        
        if ( $this->form_validation->run( 'just_email_address' ) )
        {
            if ( ! submit_gr() ) r_error( 'recaptcha' );
            
            $email_address = do_secure_l( post( 'email_address' ) );
            $user = $this->User_model->get_by_email( $email_address );
            
            if ( ! empty( $user ) )
            {
                if ( $user->status == 0 ) r_error_gr( 'invalid_email' );
                
                $template = $this->Tool_model->email_template_by_hook_and_lang( 'forgot_password', get_language() );
                $token = get_short_random_string();
                
                if ( empty( $template ) ) r_error( 'missing_template' );
                
                $message = replace_placeholders( $template->template, [
                    '{USER_NAME}' => $user->first_name . ' ' . $user->last_name,
                    '{EMAIL_LINK}' => env_url( "change_password/{$token}" ),
                    '{SITE_NAME}' => db_config( 'site_name' )
                ]);
                
                $this->load->library( 'ZMailer' );
                
                if ( $this->zmailer->send_email( $email_address, $template->subject, $message ) )
                {
                    $this->load->model( 'Email_token_model' );
                    
                    if ( $this->Email_token_model->add_email_token( $token, $user->id, 'password_reset' ) )
                    {
                        r_success_gr( 'change_pass_req' );
                    }
                    
                    r_error_gr( 'went_wrong' );
                }
                
                r_error_gr( 'failed_email' );
            }
            else
            {
                r_error_gr( 'invalid_email' );
            }
        }
        
        d_r_error_gr( form_error( 'email_address' ) );
    }
    
    /**
     * Change Password Page Input Handling.
     *
     * @return void
     */
    public function change_password()
    {
        if ( $this->zuser->is_logged_in ) r_error_gr( 'already_logged_in' );
        
        if ( $this->form_validation->run( 'change_password' ) )
        {
            if ( ! submit_gr() ) r_error( 'recaptcha' );
            
            $this->load->model( 'Email_token_model' );
            
            $token = do_secure( post( 'token' ) );
            $token = $this->Email_token_model->email_token( $token, 'password_reset' );
            $user_token = get_long_random_string();
            $password = post( 'password' );
            
            if ( ! empty( $token ) )
            {
                $id = $token->user_id;
                
                $user = $this->User_model->get_by_id( $id );
                
                if ( $token->requested_at < subtract_time( '24 hours' ) )
                {
                    r_error_gr( 'token_expired' );
                }
                
                $status = validate_password( $password );
            
                if ( $status['status'] === false ) r_error_gr( $status['message'] );
                
                if ( $this->User_model->update_password( $id, $password ) )
                {
                    $this->Email_token_model->delete_email_token( $id, 'password_reset' );
                    
                    if ( set_login( $user_token, $id ) )
                    {
                        r_s_jump( get_after_login_location(), 'pass_changed' );
                    }
                }
                
                r_error_gr( 'went_wrong' );
            }
            
            r_error_gr( 'invalid_token' );
        }
        
        d_r_error_gr( validation_errors() );
    }
    
    /**
     * Register Page Input Handling.
     *
     * @return void
     */
    public function register()
    {
        if ( $this->zuser->is_logged_in ) r_error_gr( 'already_logged_in' );
        
        if ( $this->form_validation->run( 'register' ) )
        {
            if ( ! submit_gr() ) r_error( 'recaptcha' );
            
            $code = do_secure( post( 'invitation_code' ) );
            
            if ( ! empty( $code ) )
            {
                $invitation = $this->User_model->invitation_by_code( $code );
                
                if ( empty( $invitation ) ) r_error_gr( 'invalid_invitation' );
                
                if ( db_config( 'u_enable_registration' ) == 0 && $invitation->bypass_registration == 0 )
                {
                    r_error_gr( 'registration_disabled' );
                }
                else if ( get_invitation_status( $invitation ) !== 'unused' )
                {
                    r_error_gr( 'ic_expired' );
                }
            }
            else if ( db_config( 'u_enable_registration' ) == 0 )
            {
                r_error_gr( 'registration_disabled' );
            }
            
            $status = validate_password( post( 'password' ) );
            
            if ( $status['status'] === false ) r_error_gr( $status['message'] );
            
            $user_token = get_long_random_string();
            $user = $this->User_model->get_by_email( do_secure_l( post( 'email_address' ) ) );
            
            if ( ! empty( $user ) ) r_error_gr( 'already_registered' );
            
            $data = [
                'first_name' => do_secure_u( post( 'first_name' ) ),
                'last_name' => do_secure_u( post( 'last_name' ) ),
                'password' => password_hash( post( 'password' ), PASSWORD_DEFAULT ),
                'role' => DEFAULT_USER_ROLE_ID,
                'registered_month_year' => get_site_date( 'n-Y' ),
                'registered_at' => time()
            ];
            
            if ( ! empty( $code ) )
            {
                $data['email_address'] = do_secure_l( $invitation->email_address );
                $data['is_verified'] = 1;
            }
            else
            {
                $data['email_address'] = do_secure_l( post( 'email_address' ) );
            }
            
            $source = "{$data['first_name']}{$data['last_name']}";
            
            if ( ! is_alpha_numeric( $source ) || strlen( $source ) < 5 )
            {
                $source = cleaned_email_username( $data['email_address'] );
            }
            
            $data['username'] = $this->User_model->get_unique_username( $source );
            
            $id = $this->User_model->add( $data );
            
            if ( ! empty( $id ) )
            {
                if ( ! empty( $code ) )
                {
                    $this->User_model->invitation_mark_as_used( $code, $id );
                }
                else if ( is_email_settings_filled() )
                {
                    send_welcome_email( $id );
                    everification_setup( $id );
                }

                if ( ! set_login( $user_token, $id ) )
                {
                    r_error_gr( 'reg_add_sess' );
                }
                
                if ( ! empty( $code ) ) $smessage = 'registered_ev';
                else $smessage = 'registered';
                
                r_s_jump( get_after_login_location(), $smessage );
            }
            
            r_error_gr( 'went_wrong' );
        }
        
        d_r_error_gr( validation_errors() );
    }
}
