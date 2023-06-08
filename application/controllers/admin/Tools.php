<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Tools Controller ( Admin )
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
        
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );
        
        $this->sub_area = 'tools';
        $this->area = 'admin';
        
        $this->load->library( 'pagination' );
    }
    
    /**
     * Announcements Page
     *
     * @return void
     */
    public function announcements()
    {
        check_page_authorization( 'announcements' );
        
        $this->set_admin_reference( 'others' );
        
        $config['base_url'] = env_url( 'admin/tools/announcements' );
        $config['total_rows'] = $this->Tool_model->announcements( true );
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $announcements = $this->Tool_model->announcements(
            false,
            $config['per_page'],
            $offset
        );
        
        $data['data']['announcements'] = $announcements;
        $data['delete_method'] = 'delete_announcement';
        $data['title'] = lang( 'announcements' );
        $data['view'] = 'announcements';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Email Templates Page
     *
     * @return void
     */
    public function email_templates()
    {
        check_page_authorization( 'email_templates' );
        
        $this->set_admin_reference( 'others' );
        
        $data['data']['templates'] = $this->Tool_model->email_templates();
        $data['delete_method'] = 'delete_email_template';
        $data['title'] = lang( 'email_templates' );
        $data['view'] = 'email_templates';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Sessions Page
     *
     * @return void
     */
    public function sessions()
    {
        check_page_authorization( 'users' );
        
        $this->set_admin_reference( 'others' );
        
        $config['base_url'] = env_url( 'admin/tools/sessions' );
        $config['total_rows'] = $this->Tool_model->user_sessions( ['count' => true] );
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $sessions = $this->Tool_model->user_sessions([
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);
        
        $data['data']['sessions'] = $sessions;
        $data['title'] = lang( 'sessions' );
        $data['view'] = 'sessions';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Backup Page
     *
     * @return void
     */
    public function backup()
    {
        check_page_authorization( 'backup' );
        
        $this->load->helper( 'z_backup' );
        
        $this->set_admin_reference( 'others' );
        
        $config['base_url'] = env_url( 'admin/tools/backup' );
        $config['total_rows'] = $this->Tool_model->backup_log( true );
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $backup_log = $this->Tool_model->backup_log(
            false,
            $config['per_page'],
            $offset
        );
        
        $data['data']['backup_log'] = $backup_log;
        $data['delete_method'] = 'delete_a_backup_log';
        $data['title'] = lang( 'backup' );
        $data['view'] = 'backup';
        
        $this->load_panel_template( $data );
    }
}
