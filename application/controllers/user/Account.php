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
        
        if ( ! $this->zuser->is_logged_in )
        {
            env_redirect( 'login' );
        }
        
        $this->sub_area = 'account';
        $this->area = 'user';
    }
    
    /**
     * Notifications Page
     *
     * @param  string $type
     * @return void
     */
    public function notifications( $type = '' )
    {
        if ( ! in_array( $type, ['user', 'admin'] ) ||
        ( $type === 'admin' && ! $this->zuser->is_team_member() ) )
        {
            env_redirect( get_related_dashboard() );
        }
        
        $this->load->library( 'pagination' );
        
        $to_fetch = [];
        $to_count = ['count' => true];
        
        if ( $type === 'user' && ! $this->zuser->is_team_member() )
        {
            $to_count['for_team_member'] = 0;
            $to_fetch['for_team_member'] = 0;
        }
        
        $config['total_rows'] = $this->Notification_model->notifications( $to_count );
        $method = 'load_public_template';
        $sub = true;
        
        if ( $type === 'user' )
        {
            $this->set_user_reference( 'notifications' );
            $config['base_url'] = env_url( 'user/notifications' );
            $config['per_page'] = PER_PAGE_RESULTS;
        }
        else if ( $type === 'admin' )
        {
            $this->set_admin_reference( 'notifications' );
            $this->area = 'admin';
            $config['base_url'] = env_url( 'admin/notifications' );
            $config['per_page'] = PER_PAGE_RESULTS_PANEL;
            $method = 'load_panel_template';
            $sub = false;
        }
        
        $offset = get_offset( $config['per_page'], 3 );
        $to_fetch['offset'] = $offset;
        $to_fetch['limit'] = $config['per_page'];
        
        $notifications = $this->Notification_model->notifications( $to_fetch );
        $unread_notifications = $this->Notification_model->check_for_new_notifications();
        
        $this->pagination->initialize( $config );
        
        $data['data']['pagination'] = $this->pagination->create_links();
        $data['data']['notifications'] = $notifications;
        $data['data']['unread_notifications'] = $unread_notifications;
        $data['view'] = 'notifications';
        
        $this->{$method}( $data, $sub );
    }
    
    /**
     * Read Notification ( Action ).
     *
     * @param  string  $type
     * @param  integer $id
     * @return void
     */
    public function read_notification( $type = '', $id = 0 )
    {
        if ( empty( $id ) || empty( $type ) ) env_redirect( get_related_dashboard() );

        $referral = "{$type}/notifications";
        
        if ( $this->Notification_model->mark_as_read( $id ) )
        {
            $data = $this->Notification_model->notification( $id );
            
            env_redirect( $data->location );
        }
        
        error_redirect( 'invalid_req', $referral );
    }
    
    /**
     * Profile Settings Page
     *
     * @param  string $type
     * @return void
     */
    public function profile_settings( $type = 'user' )
    {
        if ( ! in_array( $type, ['admin', 'user'] ) )
        {
            env_redirect( get_related_dashboard() );
        }
        
        $this->set_user_reference( 'account' );
        $this->load->model( 'User_model' );
        $method = 'load_public_template';
        
        $user = new stdClass;
        $user->send_email_notifications = $this->zuser->get( 'send_email_notifications' );
        $user->first_name = $this->zuser->get( 'first_name' );
        $user->last_name = $this->zuser->get( 'last_name' );
        $user->email_address = $this->zuser->get( 'email_address' );
        $user->picture = $this->zuser->get( 'picture' );
        $user->username = $this->zuser->get( 'username' );
        $user->time_format = $this->zuser->get( 'time_format' );
        $user->date_format = $this->zuser->get( 'date_format' );
        $user->timezone = $this->zuser->get( 'timezone' );
        $user->language = $this->zuser->get( 'language' );
        $user->id = $this->zuser->get( 'id' );
        
        $data['title'] = lang( 'profile_settings' );
        $data['view'] = 'settings/profile_settings';
        $data['data']['user'] = $user;
        
        if ( $type === 'admin' )
        {
            if ( ! $this->zuser->is_team_member() )
            {
                env_redirect( get_related_dashboard() );
            }
            
            $method = 'load_panel_template';
            $this->area = 'admin';
        }
        
        $this->{$method}( $data );
    }
}
