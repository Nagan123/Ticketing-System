<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Account Controller ( User )
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
        
        $this->sub_area = 'account';
        $this->area = 'user';
    }
    
    /**
     * Login Page
     *
     * @param  string $page
     * @return void
     */
    public function login( $page = '' )
    {
        if ( $this->zuser->is_logged_in ) env_redirect( get_related_dashboard() );
        
        if ( empty( $page ) )
        {
            $this->parent_ref = lang( 'account' );
            $data['data']['gr_field'] = true;
            $data['title'] = lang( 'login' );
            $data['view'] = 'login';
        }
        else
        {
            if ( $page == 'banned' && get_flashdata( 'banned' ) )
            {
                $data['title'] = lang( 'account_banned' );
                $data['view'] = 'banned';
            }
            else
            {
                env_redirect( 'login' );
            }
        }
        
        $this->load_public_template( $data );
    }
    
    /**
     * Continue with Facebook ( Action ).
     *
     * @return void
     */
    public function login_facebook()
    {
        if ( ! is_fb_togo() ) error_redirect( 'temp_disabled', 'login' );
        
        if ( $this->zuser->is_logged_in ) env_redirect( get_related_dashboard() );
        
        $this->load->model( 'Login_model' );
        
        $this->load->library( 'ZFacebook',
        [
            'public_id' => db_config( 'fb_app_id' ),
            'secret_id' => db_config( 'fb_app_secret' )
        ]);
        
        $user = $this->zfacebook->authenticate();
        
        $this->oauth_handler( $user, 2 );
    }
    
    /**
     * Continue with Twitter ( Action ).
     *
     * @return void
     */
    public function login_twitter()
    {
        if ( ! is_tw_togo() ) error_redirect( 'temp_disabled', 'login' );
        
        if ( $this->zuser->is_logged_in ) env_redirect( get_related_dashboard() );
        
        $this->load->model( 'Login_model' );
        
        $this->load->library( 'ZTwitter',
        [
            'public_id' => db_config( 'tw_consumer_key' ),
            'secret_id' => db_config( 'tw_consumer_secret' )
        ]);
        
        $user = $this->ztwitter->authenticate();
        
        $this->oauth_handler( $user, 3 );
    }
    
    /**
     * Continue with Google ( Action ).
     *
     * @return void
     */
    public function login_google()
    {
        if ( ! is_gl_togo() ) error_redirect( 'temp_disabled', 'login' );
        
        if ( $this->zuser->is_logged_in ) env_redirect( get_related_dashboard() );
        
        $this->load->model( 'Login_model' );
        
        $this->load->library( 'ZGoogle',
        [
            'public_id' => db_config( 'gl_client_key' ),
            'secret_id' => db_config( 'gl_secret_key' )
        ]);
        
        $user = $this->zgoogle->authenticate();
        
        $this->oauth_handler( $user, 4 );
    }
    
    /**
     * OAuth Handler
     *
     * @param  object  $user
     * @param  integer $provider
     * @return void
     */
    private function oauth_handler( $user, $provider )
    {
        if ( empty( $user ) ) error_redirect( 'went_wrong', 'login' );
        
        $data = $this->Login_model->social_user_data( $user, $provider );
        $token = get_long_random_string();
        
        if ( empty( $data ) )
        {
            error_redirect( 'went_wrong', 'login' );
        }
        
        if ( is_string( $data ) )
        {
            error_redirect( $data, 'login' );
        }
        else if ( is_integer( $data ) )
        {
            $id = $data;
        }
        else
        {
            $id = $data->id;
        }
        
        if ( get_flashdata( 'is_registered' ) )
        {
            if ( is_email_settings_filled() )
            {
                send_welcome_email( $id );
                everification_setup( $id );
            }
        }
        
        if ( set_login( $token, $id, true ) )
        {
            env_redirect( get_after_login_location() );
        }
        
        error_redirect( 'went_wrong', 'login' );
    }
    
    /**
     * Email Verification ( Action ).
     *
     * @param  integer $user_id
     * @param  string  $token
     * @return void
     */
    public function everify( $user_id = 0, $token = '' )
    {
        if ( $this->zuser->is_logged_in ) $togo = get_related_dashboard();
        else $togo = 'login';
        
        $this->load->model( 'Email_token_model' );
        
        if ( $this->Email_token_model->email_token( $token, 'email_verification', $user_id ) )
        {
            $this->load->model( 'User_model' );
            
            if ( $this->User_model->mark_as_everified( $user_id ) )
            {
                $this->Email_token_model->delete_email_token( $user_id, 'email_verification' );
                
                success_redirect( 'email_verified', $togo );
            }
            
            error_redirect( 'went_wrong', $togo );
        }
        
        error_redirect( 'invalid_token', $togo );
    }
    
    /**
     * Delete Change Email Token
     *
     * @param  integer $user_id
     * @return void
     */
    private function delete_change_email_token( $user_id )
    {
        $this->Email_token_model->delete_email_token( $user_id, 'change_email' );
    }
    
    /**
     * Change Email ( Action ).
     *
     * @param  string $token
     * @return void
     */
    public function change_email( $token = '' )
    {
        if ( $this->zuser->is_logged_in ) $togo = 'user/account/profile_settings';
        else $togo = 'login';
        
        $this->load->model( 'Email_token_model' );
        
        $row = $this->Email_token_model->email_token( $token, 'change_email' );
        
        if ( ! empty( $row ) )
        {
            $this->load->model( 'User_model' );
            
            $user_id = $row->user_id;
            
            $user = $this->User_model->get_by_id( $user_id );
            
            if ( $user->status == 1 )
            {
                $pending = $user->pending_email_address;
                
                if ( empty( $this->User_model->get_by_email( $pending ) ) )
                {
                    $to_update = ['email_address' => $pending, 'pending_email_address' => ''];
                    
                    if ( $this->User_model->update_user( $to_update, $user_id ) )
                    {
                        $this->delete_change_email_token( $user_id );
                        
                        success_redirect( 'email_activated', $togo );
                    }
                    
                    error_redirect( 'went_wrong', $togo );
                }
                else
                {
                    $this->delete_change_email_token( $user_id );
                }
            }
            
            error_redirect( 'email_not_changed', $togo );
        }
        
        error_redirect( 'invalid_token', $togo );
    }
    
    /**
     * Forgot Password Page
     *
     * @return void
     */
    public function forgot_password()
    {
        if ( db_config( 'u_reset_password' ) == 0 )
        {
            error_redirect( 'temp_disabled', 'login' );
        }
        
        if ( $this->zuser->is_logged_in )
        {
            env_redirect( get_related_dashboard() );
        }
        
        $this->parent_ref = lang( 'account' );
        $data['data']['gr_field'] = true;
        $data['title'] = lang( 'forgot_password' );
        $data['view'] = 'forgot_password';
        
        $this->load_public_template( $data );
    }
    
    /**
     * Change Password Page
     *
     * @param  string $token
     * @return void
     */
    public function change_password( $token = '' )
    {
        if ( empty( $token ) ) redirect();
        
        $this->parent_ref = lang( 'account' );
        $data['title'] = lang( 'change_password' );
        $data['view'] = 'change_password';
        $data['data'] = ['token' => $token];
        $data['data']['gr_field'] = true;
        
        $this->load_public_template( $data );
    }
    
    /**
     * Register Page
     *
     * @param  string $code
     * @return void
     */
    public function register( $code = '' )
    {
        if ( db_config( 'u_enable_registration' ) == 0 && empty( $code ) )
        {
            error_redirect( 'registration_disabled', 'login' );
        }
        
        if ( $this->zuser->is_logged_in ) env_redirect( get_related_dashboard() );
        
        $this->parent_ref = lang( 'account' );
        $data['data']['gr_field'] = true;
        $data['title'] = lang( 'register' );
        $data['view'] = 'register';
        
        if ( ! empty( $code ) )
        {
            $this->load->model( 'User_model' );
            
            $invitation = $this->User_model->invitation_by_code( $code );
            $data['data']['code'] = $code;
            
            if ( ! empty( $invitation ) )
            {
                $data['data']['email_address'] = $invitation->email_address;
            }
            else
            {
                error_redirect( 'ic_invalid', 'register' );
            }
        }
        
        $this->load_public_template( $data );
    }
    
    /**
     * Logout ( Action )
     *
     * @return void
     */
    public function logout()
    {
        $this->zuser->logout();
    }
}
