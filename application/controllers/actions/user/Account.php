<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Account Controller ( User, Actions )
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
        
        if ( ! $this->zuser->is_logged_in ) r_s_jump( 'login' );
        
        $this->load->library( 'form_validation' );
        $this->load->model( 'User_model' );
    }
    
    /**
     * Request Area
     *
     * Use to track the request area for redirecting.
     *
     * @return string
     */
    private function request_area()
    {
        $area = do_secure( post( 'area' ) );
        
        if ( ! in_array( $area, ['admin', 'user'] ) )
        {
            r_error( 'invalid_req' );
        }
        
        return $area;
    }
    
    /**
     * Mark All Notifications as Read
     *
     * @return void
     */
    public function mark_all_as_read()
    {
        $this->load->model( 'Notification_model' );
        
        if ( $this->Notification_model->mark_as_read() )
        {
            $area = $this->request_area();
            
            r_s_jump( "{$area}/notifications", 'noti_read' );
        }
        
        r_error( 'nounread_notifications' );
    }
    
    /**
     * Delete User Profile Picture
     *
     * @return void
     */
    public function delete_profile_picture()
    {
        $id = $this->zuser->get( 'id' );
        $area = $this->request_area();
        $togo = "{$area}/account/profile_settings";
        
        if ( delete_profile_picture( $id ) )
        {
            r_s_jump( $togo, 'acc_pic_deleted' );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Profile Settings Page Input Handling.
     *
     * @return void
     */
    public function update_profile_settings()
    {
        $area = $this->request_area();
        
        if ( $this->form_validation->run( 'profile_settings' ) )
        {
            $status = update_profile_settings( $this->zuser->get( 'id' ), 'user' );
            
            if ( $status === true )
            {
                r_s_jump( "{$area}/account/profile_settings", 'updated' );
            }
            
            r_error( $status );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Change Password Page Input Handling.
     *
     * @return void
     */
    public function change_password()
    {
        $area = $this->request_area();
        $form_validation_key = 'change_password_whole';
        $old_password = $this->zuser->get( 'password' );
        $togo = ( $area === 'admin' ) ? 'admin/account/change_password' : 'user/account/profile_settings';
        
        if ( empty( $old_password ) )
        {
            $form_validation_key = 'change_password';
        }
        
        if ( $this->form_validation->run( $form_validation_key ) )
        {
            $this->load->model( 'Login_model' );
            
            $user_id = $this->zuser->get( 'id' );
            
            if ( db_config( 'u_temporary_lockout' ) !== 'off' )
            {
                user_locally_locked_check( $user_id, 'change_password' );
            }
            
            if ( ! empty( $old_password ) )
            {
                if ( ! password_verify( post( 'current_password' ), $old_password ) )
                {
                    $this->Login_model->log_invalid_attempt( $user_id, 'change_password' );
                    r_error( 'wrong_password' );
                }
                
                // Don't allow the password to be the same as before ( old password ):
                else if ( password_verify( post( 'password' ), $old_password ) )
                {
                    r_error( 'same_password' );
                }
            }
            
            $status = validate_password( post( 'password' ) );
            
            if ( $status['status'] === false ) r_error( $status['message'] );
            
            if ( $this->User_model->update_password( $user_id, post( 'password' ) ) )
            {
                if ( db_config( 'u_notify_pass_changed' ) )
                {
                    $template = $this->Tool_model->email_template_by_hook_and_lang( 'changed_password', get_language() );
                    
                    if ( empty( $template ) ) r_error( 'missing_template' );
                    
                    $first_name = $this->zuser->get( 'first_name' );
                    $last_name = $this->zuser->get( 'last_name' );
                    $email_address = $this->zuser->get( 'email_address' );
                    $subject = $template->subject;
                    
                    $message = replace_placeholders( $template->template, [
                        '{USER_NAME}' => $first_name . ' ' . $last_name,
                        '{SITE_NAME}' => db_config( 'site_name' )
                    ]);
                    
                    if ( is_email_settings_filled() )
                    {
                        $this->load->library( 'ZMailer' );
                        
                        $this->zmailer->send_email( $email_address, $subject, $message );
                    }
                }
                
                $this->Login_model->delete_invalid_attempt( $user_id, 'change_password' );
                
                r_s_jump( $togo, 'updated' );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Account
     *
     * @return void
     */
    public function delete()
    {
        if ( db_config( 'u_can_remove_them' ) == 0 )
        {
            r_error( 'invalid_req' );
        }
        
        $id = $this->zuser->get( 'id' );
        
        if ( $id == 1 ) r_error( 'cant_delete_du' );
        
        if ( delete_user( $id ) )
        {
            r_s_jump( 'login', 'my_acc_deleted' );
        }
        
        r_error( 'invalid_req' );
    }
}