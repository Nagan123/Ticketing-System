<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Users Controller ( Admin, Actions )
 *
 * @author Shahzaib
 */
class Users extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        if ( ! $this->zuser->is_logged_in ) r_s_jump( 'login' );
        
        if ( ! $this->zuser->has_permission( 'users' ) )
        {
            if ( $this->uri->segment( 4 ) !== 'deimpersonate' )
            {
                r_error_no_permission();
            }
        }
        
        $this->load->library( 'form_validation' );
        $this->load->model( 'User_model' );
    }
    
    /**
     * Delete User Profile Picture
     *
     * @return void
     */
    public function delete_profile_picture()
    {
        $id = intval( post( 'id' ) );
        $togo = "admin/users/edit_user/{$id}";
        
        if ( delete_profile_picture( $id ) )
        {
            r_s_jump( $togo, 'acc_pic_deleted' );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * New User Page Input Handling.
     *
     * @return void
     */
    public function new_user()
    {
        if ( $this->form_validation->run( 'new_user' ) )
        {
            $status = validate_password( post( 'password' ) );
            
            if ( $status['status'] === false ) r_error( $status['message'] );
            
            $email_address = do_secure_l( post( 'email_address' ) );
            
            $user = $this->User_model->get_by_email( $email_address );
            
            if ( ! empty( $user ) ) r_error( 'already_registered' );
            
            $data = [
                'first_name' => do_secure_u( post( 'first_name' ) ),
                'last_name' => do_secure_u( post( 'last_name' ) ),
                'email_address' => $email_address,
                'password' => password_hash( post( 'password' ), PASSWORD_DEFAULT ),
                'role' => intval( post( 'role' ) ),
                'is_verified' => 1,
                'registered_month_year' => get_site_date( 'n-Y' ),
                'registered_at' => time()
            ];
            
            $source = "{$data['first_name']}{$data['last_name']}";
            
            if ( ! is_alpha_numeric( $source ) || strlen( $source ) < 5 )
            {
                $source = cleaned_email_username( $data['email_address'] );
            }
            
            $data['username'] = $this->User_model->get_unique_username( $source );
            
            if ( ! empty( $_FILES['picture']['tmp_name'] ) )
            {
                $this->load->library( 'ZFiles' );
                $data['picture'] = $this->zfiles->upload_user_avatar();
            }
            
            $id = $this->User_model->add( $data );
            
            if ( ! empty( $id ) )
            {
                if ( post( 'send_password' ) == 1 )
                {
                    $sent_email = false;
                    
                    $this->lang->load( 'email', 'english' );
                    
                    $subject = lang( 'e_send_password_subject' );
                    
                    $message = sprintf(
                        lang( 'e_send_password_message' ),
                        $data['first_name'] . ' ' . $data['last_name'],
                        str_replace( ' ', '&nbsp;', html_escape( do_secure( post( 'password' ), true ) ) ),
                        db_config( 'site_name' )
                    );
                    
                    if ( is_email_settings_filled() )
                    {
                        $this->load->library( 'ZMailer' );

                        if ( $this->zmailer->send_email( $email_address, $subject, $message ) )
                        {
                            $sent_email = true;
                        }
                    }
                    
                    if ( $sent_email === false )
                    {
                        r_e_jump( 'admin/users/manage', 'send_pass_fe' );
                    }
                }
                
                r_s_jump( 'admin/users/manage', 'added' );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Update User Input Handling.
     *
     * @return void
     */
    public function update_user()
    {
        if ( $this->form_validation->run( 'profile_settings' ) )
        {
            $id = intval( post( 'id' ) );
            $status = update_profile_settings( $id, 'admin' );
            
            if ( $status === true )
            {
                r_s_jump( "admin/users/edit_user/{$id}", 'updated' );
            }
            
            r_error( $status );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete User
     *
     * @return void
     */
    public function delete_user()
    {
        $id = intval( post( 'id' ) );
        
        if ( $id == 1 ) r_error( 'cant_delete_du' );
        
        if ( delete_user( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Send Email to User
     *
     * @return void
     */
    public function send_email_user()
    {
        if ( $this->form_validation->run( 'send_email_user' ) )
        {
            $id = intval( post( 'id' ) );
            $user = $this->User_model->get_by_id( $id );
            
            if ( empty( $user ) ) r_error( 'invalid_req' );
            else if ( ! is_email_settings_filled() ) r_error( 'missing_email_config_a' );
            
            $this->load->library( 'ZMailer' );
            $this->lang->load( 'email', 'english' );
            
            $email_address = $user->email_address;
            $subject = do_secure( post( 'subject' ) );
            $sender_comment = do_secure( post( 'message' ), true );
            
            $message = sprintf(
                lang( 'e_email_user_message' ),
                $user->first_name . ' ' . $user->last_name,
                $sender_comment,
                db_config( 'site_name' )
            );
            
            if ( $this->zmailer->send_email( $email_address, $subject, $message ) )
            {
                $data = [
                    'subject' => $subject,
                    'message' => $sender_comment,
                    'sent_to' => $user->id,
                    'sent_by' => $this->zuser->get( 'id' ),
                    'sent_at' => time()
                ];
                
                $this->User_model->add_sent_email( $data );
                r_s_refresh( 'email_sent' );
            }
            
            r_error( 'failed_email' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Sent Email Record ( Read More ) Response.
     *
     * @return void
     */
    public function sent_email()
    {
        $id = intval( post( 'id' ) );
        $data = $this->User_model->sent_email( $id );
        
        if ( ! empty( $data ) )
        {
            $data = [
                'detail' => $data->message,
                'type' => lang( 'message' ),
                'id' => $id
            ];
            
            display_view( 'admin/responses/read_more_html', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Delete Sent Email Record
     *
     * @return void
     */
    public function delete_sent_email()
    {
        $id = intval( post( 'id' ) );
        
        if ( $this->User_model->delete_sent_email( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Impersonate User
     *
     * @return void
     */
    public function impersonate()
    {
        $id = intval( post( 'id' ) );
        
        if ( $this->zuser->has_permission( 'impersonate' ) )
        {
            if ( $this->zuser->get( 'id' ) != $id )
            {
                $user = $this->User_model->get_by_id( $id );
                
                if ( ! empty( $user ) )
                {
                    $this->zuser->impersonate( $id );
                    
                    if ( $user->role == 3 )
                    {
                        r_s_jump( 'dashboard' );
                    }
                    
                    r_s_jump( 'admin/dashboard' );
                }
                
                r_error( 'invalid_req' );
            }
            
            r_error( 'cant_impersonate' );
        }
        
        r_error_no_permission();
    }
    
    /**
     * Deimpersonate User
     *
     * @return void
     */
    public function deimpersonate()
    {
        if ( get_session( 'impersonating' ) )
        {
            $admin_id = $this->Tool_model->user_id_by_sess_token();
            $tmp_uid = $this->zuser->get( 'id' );
            
            $this->zuser->deimpersonate();
        }
        
        env_redirect( 'admin/users/manage' );
    }
    
    /**
     * Send Verification Link
     *
     * @return void
     */
    public function send_vlink()
    {
        $id = intval( post( 'id' ) );

        $status = everification_setup( $id );
        
        if ( $status === true )
        {
            r_success_cm( 'sent_vlink' );
        }
        
        return r_error( $status );
    }
    
    /**
     * Invite User Input Handling.
     *
     * @return void
     */
    public function invite_user()
    {
        if ( $this->form_validation->run( 'user_invite' ) )
        {
            $et_language = do_secure_l( post( 'et_language' ) );
            
            $data = [
                'email_address' => do_secure( post( 'email_address' ) ),
                'invitation_code' => get_short_random_string(),
                'bypass_registration' => only_binary( post( 'bypass_registration' ) ),
                'expires_in' => intval( post( 'expires_in' ) ),
                'invited_at' => time()
            ];
            
            if ( ! empty( $this->User_model->get_by_email( $data['email_address'] ) ) )
            {
                r_error( 'already_registered' );
            }
            
            $template = $this->Tool_model->email_template_by_hook_and_lang( 'member_invite', $et_language );
            
            if ( empty( $template ) ) r_error( 'missing_template' );
            else if ( ! is_email_settings_filled() ) r_error( 'missing_email_config_a' );
            
            $message = replace_placeholders( $template->template, [
                '{EMAIL_LINK}' => env_url( "register/invitation/{$data['invitation_code']}" ),
                '{SITE_NAME}' => db_config( 'site_name' )
            ]);
            
            $this->load->library( 'ZMailer' );
            
            if ( $this->zmailer->send_email( $data['email_address'], $template->subject, $message ) )
            {
                $id = $this->User_model->add_invitation( $data );
                
                if ( ! empty( $id ) )
                {
                    $data['id'] = $id;
                    
                    $html = read_view( 'admin/responses/add_user_invitation', $data );
                    
                    r_success_add( $html, 'invited' );
                }
                
                r_error( 'went_wrong' );
            }
            
            r_error( 'failed_email' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Edit User Invitation ( Response ).
     *
     * @return void
     */
    public function edit_user_invitation()
    {
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->User_model->invites( ['id' => intval( post( 'id' ) )] );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_user_invitation', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Invitation Input Handling.
     *
     * @return void
     */
    public function update_invitation()
    {
        if ( $this->form_validation->run( 'user_invite' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'bypass_registration' => only_binary( post( 'bypass_registration' ) ),
                'expires_in' => intval( post( 'expires_in' ) )
            ];
            
            if ( $this->User_model->update_invitation( $data, $id ) )
            {
                $data = $this->User_model->invites( ['id' => $id] );
                $html = read_view( 'admin/responses/update_user_invitation', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Invitation
     *
     * @return void
     */
    public function delete_invitation()
    {
        $id = intval( post( 'id' ) );
        
        if ( $this->User_model->delete_invitation( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
}
