<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Users Controller ( Admin )
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
        
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );

        check_page_authorization( 'users' );
        
        $this->sub_area = 'users';
        $this->area = 'admin';
        
        $this->load->model( 'User_model' );
        $this->load->library( 'pagination' );
    }
    
    /**
     * Tickets or Chats
     *
     * @param   string $plural
     * @param   string $singular
     * @param   string $username
     * @return  void
     * @version 1.6
     */
    private function tickets_or_chats( $plural, $singular, $username )
    {
        if ( ! in_array( $plural, ['tickets', 'chats'] ) )
        {
            env_redirect( 'dashboard' );
        }
        
        if ( ! $this->zuser->has_permission( "all_{$plural}" ) )
        {
            env_redirect( 'admin/users/manage' );
        }
        
        $this->set_admin_reference( 'others' );
        
        $username = do_secure_l( $username );
        $user = $this->User_model->get_by_username( $username );
        
        if ( empty( $user ) ) env_redirect( 'admin/users/manage' );
        
        $this->load->model( 'Support_model' );
        
        $to_count = ['count' => true, 'user_id' => $user->id];
        
        $config['base_url'] = env_url( "admin/users/{$plural}/{$username}" );
        
        $all_rows = $this->Support_model->{$plural}([
            'user_id' => $user->id,
            'count' => true
        ]);
        
        $config['total_rows'] = $all_rows;
        
        if ( $plural == 'tickets' )
        {
            $data['data']['all_tickets'] = $all_rows;
            
            $to_count['status'] = 1;
            $data['data']['opened_tickets'] = $this->Support_model->tickets( $to_count );
            
            $to_count['status'] = 0;
            $data['data']['closed_tickets'] = $this->Support_model->tickets( $to_count );
        }
        else
        {
            $data['data']['all_chats'] = $all_rows;
            
            $to_count['status'] = 1;
            $data['data']['active_chats'] = $this->Support_model->chats( $to_count );
            
            $to_count['status'] = 0;
            $data['data']['ended_chats'] = $this->Support_model->chats( $to_count );
        }
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'], 5 );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $result = $this->Support_model->{$plural}([
            'user_id' => $user->id,
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);

        $data['data'][$plural] = $result;
        $data['data']['user_email_address'] = $user->email_address;
        $data['data']['main_controller'] = 'support';
        $data['delete_method'] = "delete_{$singular}";
        $data['title'] = sub_title( lang( 'users' ), lang( $plural ) );
        $data['view'] = $plural;
        
        $this->load_panel_template( $data );
    }
    
    /**
     * User Tickets Page
     *
     * @param   string $username
     * @return  void
     * @version 1.6
     */
    public function tickets( $username = '' )
    {
        $this->tickets_or_chats( 'tickets', 'ticket', $username );
    }
    
    /**
     * User Chats Page
     *
     * @param   string $username
     * @return  void
     * @version 1.6
     */
    public function chats( $username = '' )
    {
        $this->tickets_or_chats( 'chats', 'chat', $username );
    }
    
    /**
     * New User Page
     *
     * @return void
     */
    public function new_user()
    {
        $this->set_admin_reference( 'others' );
        
        $data['data']['roles'] = $this->Setting_model->roles();
        $data['title'] = sub_title( lang( 'users' ), lang( 'new_user' ) );
        $data['view'] = 'new_user';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Users Invites Page
     *
     * @return void
     */
    public function invites()
    {
        $this->set_admin_reference( 'others' );
        
        $config['base_url'] = env_url( 'admin/users/invites' );
        $config['total_rows'] = $this->User_model->invites( ['count' => true] );
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $invites = $this->User_model->invites([
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);
        
        $data['data']['invites'] = $invites;
        $data['delete_method'] = 'delete_invitation';
        $data['title'] = sub_title( lang( 'users' ), lang( 'invites' ) );
        $data['view'] = 'invites';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * User Sent Emails Page
     *
     * @param  string $username
     * @return void
     */
    public function sent_emails( $username = '' )
    {
        $this->set_admin_reference( 'others' );
        
        $username = do_secure_l( $username );
        $user = $this->User_model->get_by_username( $username );
        
        if ( empty( $user ) ) env_redirect( 'admin/users/manage' );
        
        $config['base_url'] = env_url( "admin/users/sent_emails/{$username}" );
        
        $config['total_rows'] = $this->User_model->sent_emails([
            'user_id' => $user->id,
            'count' => true
        ]);
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'], 5 );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $sent_emails = $this->User_model->sent_emails([
            'user_id' => $user->id,
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);

        $data['data']['sent_emails'] = $sent_emails;
        $data['data']['user_email_address'] = $user->email_address;
        $data['delete_method'] = 'delete_sent_email';
        $data['title'] = sub_title( lang( 'users' ), lang( 'sent_emails' ) );
        $data['view'] = 'sent_emails';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * User Sessions Page
     *
     * @param  string $username
     * @return void
     */
    public function sessions( $username = '' )
    {
        $this->set_admin_reference( 'others' );
        
        $username = do_secure_l( $username );
        $user = $this->User_model->get_by_username( $username );
        
        if ( empty( $user ) ) env_redirect( 'admin/users/manage' );
        
        $config['base_url'] = env_url( "admin/users/sessions/{$username}" );
        
        $config['total_rows'] = $this->Tool_model->user_sessions([
            'user_id' => $user->id,
            'count' => true
        ]);
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'], 5 );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $sessions = $this->Tool_model->user_sessions([
            'user_id' => $user->id,
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);
        
        $data['data']['sessions'] = $sessions;
        $data['data']['user_email_address'] = $user->email_address;
        $data['data']['username'] = $username;
        $data['title'] = sub_title( lang( 'users' ), lang( 'sessions' ) );
        $data['view'] = 'sessions';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Manage Users Page
     *
     * @return void
     */
    public function manage()
    {
        $this->set_admin_reference( 'others' );
        
        $searched = do_secure( get( 'search' ) );
        $filter = do_secure( get( 'filter' ) );
        $role = intval( get( 'role' ) );
        $config['base_url'] = env_url( 'admin/users/manage' );
        
        $config['total_rows'] = $this->User_model->users([
            'filter' => $filter,
            'searched' => $searched,
            'role' => $role,
            'count' => true
        ]);
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $data['data']['users'] = $this->User_model->users([
            'filter' => $filter,
            'searched' => $searched,
            'role' => $role,
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);
        
        $data['data']['roles'] = $this->Setting_model->roles();
        $data['delete_method'] = 'delete_user';
        $data['title'] = sub_title( lang( 'users' ), lang( 'manage' ) );
        $data['view'] = 'manage';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Edit User Page
     *
     * @param  integer $user_id
     * @return void
     */
    public function edit_user( $user_id = 0 )
    {
        $user_id = intval( $user_id );
        $user = $this->User_model->get_by_id( $user_id );
        
        if ( empty( $user ) ) env_redirect( 'admin/users/manage' );
        
        $this->set_admin_reference( 'others' );
        
        $data['title'] = sub_title( lang( 'users' ), lang( 'edit_user' ) );
        $data['data']['roles'] = $this->Setting_model->roles();
        $data['data']['user'] = $user;
        $data['view'] = 'edit_user';
        
        $this->load_panel_template( $data );
    }
}
