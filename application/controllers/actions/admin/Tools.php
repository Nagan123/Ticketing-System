<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Tools Controller ( Admin, Actions )
 *
 * @author Shahzaib
 */
class Tools extends MY_Controller {
    
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
        $this->load->helper( 'z_backup' );
    }
    
    /**
     * Add Announcement Input Handling.
     *
     * @return void
     */
    public function add_announcement()
    {
        check_action_authorization( 'announcements' );
        
        if ( $this->form_validation->run( 'announcement' ) )
        {
            $data = [
                'subject' => do_secure( post( 'subject' ) ),
                'announcement' => do_secure( post( 'announcement' ), true ),
                'created_at' => time()
            ];
            
            $id = $this->Tool_model->add_announcement( $data );
            
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                
                $html = read_view( 'admin/responses/add_announcement', $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Announcement ( Read More ) Response.
     *
     * @return void
     */
    public function announcement()
    {
        check_action_authorization( 'announcements' );
        
        $id = intval( post( 'id' ) );
        $data = $this->Tool_model->announcement( $id );
        
        if ( ! empty( $data ) )
        {
            $data = [
                'detail' => $data->announcement,
                'type' => lang( 'announcement' ),
                'id' => $id
            ];
            
            display_view( 'admin/responses/read_more', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Edit Announcement ( Response ).
     *
     * @return void
     */
    public function edit_announcement()
    {
        check_action_authorization( 'announcements' );
        
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Tool_model->announcement( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_announcement', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Announcement Input Handling.
     *
     * @return void
     */
    public function update_announcement()
    {
        check_action_authorization( 'announcements' );
        
        if ( $this->form_validation->run( 'announcement' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'subject' => do_secure( post( 'subject' ) ),
                'announcement' => do_secure( post( 'announcement' ), true )
            ];
            
            if ( $this->Tool_model->update_announcement( $data, $id ) )
            {
                $data = $this->Tool_model->announcement( $id );
                $html = read_view( 'admin/responses/update_announcement', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Announcement
     *
     * @return void
     */
    public function delete_announcement()
    {
        check_action_authorization( 'announcements' );
        
        $id = intval( post( 'id' ) );
        
        if ( $this->Tool_model->delete_announcement( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Add Email Template Input Handling.
     *
     * @return void
     */
    public function add_email_template()
    {
        check_action_authorization( 'email_templates' );
        
        if ( $this->form_validation->run( 'email_template' ) )
        {
            $lang_key = do_secure( post( 'language' ) );
            $hook = do_secure( post( 'hook' ) );
            
            if ( ! $this->Tool_model->email_template_by_hook_and_lang( $hook, $lang_key ) )
            {
                $data = [
                    'title' => do_secure( post( 'title' ) ),
                    'subject' => do_secure( post( 'subject' ) ),
                    'language' => $lang_key,
                    'hook' => $hook,
                    'template' => do_secure( post( 'template' ), true ),
                    'created_at' => time()
                ];
                
                $id = $this->Tool_model->add_email_template( $data );
                
                if ( ! empty( $id ) )
                {
                    r_s_jump( 'admin/tools/email_templates', 'added' );
                }
                
                r_error( 'went_wrong' );
            }
            
            r_error( 'et_exists' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Update Email Template Input Handling.
     *
     * @return void
     */
    public function update_email_template()
    {
        check_action_authorization( 'email_templates' );
        
        if ( $this->form_validation->run( 'email_template' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'title' => do_secure( post( 'title' ) ),
                'subject' => do_secure( post( 'subject' ) ),
                'template' => do_secure( post( 'template' ), true )
            ];
            
            if ( $this->Tool_model->update_email_template( $data, $id ) )
            {
                r_s_jump( 'admin/tools/email_templates', 'updated' );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Email Template
     *
     * @return void
     */
    public function delete_email_template()
    {
        check_action_authorization( 'email_templates' );
        
        $id = intval( post( 'id' ) );
        
        $data = $this->Tool_model->email_template( $id );
        
        if ( ! empty( $data ) )
        {
            if ( $data->is_built_in == 1 ) r_error( 'invalid_req' );
            
            if ( $this->Tool_model->delete_email_template( $id ) )
            {
                r_s_jump( 'admin/tools/email_templates', 'deleted' );
            }
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * IP Address Geolocation Response.
     *
     * @return void
     */
    public function ip_geolocation()
    {
        $token = db_config( 'ipinfo_token' );
        
        if ( empty( $token ) ) r_error( 'invalid_req' );
        
        $ip = do_secure( post( 'id' ) );
        $url = "http://ipinfo.io/{$ip}?token={$token}";
        $ch = curl_init();
        
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_URL, $url );
        
        $result = curl_exec( $ch );
        
        curl_close( $ch );
        
        $response = json_decode( $result, true );
        
        if ( ! empty( $response ) )
        {
            if ( empty( $response['error'] ) )
            {
                display_view( 'admin/responses/ip_geolocation', $response );
            }
            
            $error = $response['error']['message'];
            
            d_r_error( $error );
        }
        
        r_error( 'went_wrong' );
    }
    
    /**
     * Backup Page Input Handling.
     *
     * @return void
     */
    public function take_backup()
    {
        check_page_authorization( 'backup' );
        
        $option = intval( post( 'option' ) );
        $action = intval( post( 'action' ) );
        $req = 'admin/tools/backup';
        
        if ( $option === 1 || $option === 2 || $option === 4 ) $to_call = 'backup_files';
        else if ( $option === 3 || $option === 5 ) $to_call = 'backup_database';
        
        if ( ! empty( $to_call ) )
        {
            if ( $option === 1 )
            {
                $backup_file = $to_call( $action, 'application/language', 1 );
            }
            else if ( $option === 4 )
            {
                $backup_file = $to_call( $action, 'uploads', 4 );
            }
            else if ( $option === 5 )
            {
                $backup_file = $to_call( $action, false );
            }
            else
            {
                $backup_file = $to_call( $action );
            }
        }
        
        if ( $action === 2 )
        {
            success_redirect( 'backup_saved', $req );
        }
    }
    
    /**
     * Delete Backup Log
     *
     * @return void
     */
    public function delete_a_backup_log()
    {
        check_action_authorization( 'backup' );
        
        $id = intval( post( 'id' ) );
        
        if ( $this->Tool_model->delete_a_backup_log( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Delete User Session
     *
     * @return void
     */
    public function delete_user_session()
    {
        check_action_authorization( 'users' );
        
        $id = intval( post( 'id' ) );;
        $session = $this->Tool_model->user_session( $id );
        $current = false;
        
        if ( empty( $session ) ) r_error( 'invalid_req' );
        
        if ( $this->Tool_model->delete_user_session( $id ) )
        {
            if ( $session->token == get_session( USER_TOKEN ) )
            {
                $current = true;
            }
            
            if ( $current )
            {
                r_s_jump( 'login', 'u_sess_deleted' );
            }
            
            r_success_remove( $id, 'u_sess_deleted' );
        }
        
        r_error( 'went_wrong' );
    }
    
    /**
     * Logout All
     *
     * @return void
     */
    public function logout_all()
    {
        check_action_authorization( 'users' );
        
        $username = do_secure_l( post( 'username' ) );
        $togo = 'admin/users/sessions/';
        
        if ( empty( $username ) ) r_error( 'invalid_req' );
        
        $this->load->model( 'User_model' );
        
        $user = $this->User_model->get_by_username( $username );
        
        if ( ! empty( $user ) )
        {
            if ( $this->Tool_model->delete_user_sessions( $user->id ) )
            {
                if ( $this->zuser->get( 'id' ) != $user->id )
                {
                    r_s_jump( $togo . $username, 'logout_all' );
                }
                
                r_s_jump( 'login', 'logout_all_self' );
            }
        }
        
        r_error( 'went_wrong' );
    }
}
