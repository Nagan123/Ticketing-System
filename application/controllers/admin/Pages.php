<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Pages Controller ( Admin )
 *
 * @author Shahzaib
 */
class Pages extends MY_Controller {
    
    /**
     * Pages List Page
     *
     * @return void
     */
    public function index()
    {
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );
        
        check_page_authorization( 'pages' );
        
        $this->load->model( 'Page_model' );
        $this->set_admin_reference( 'others' );
        $this->area = 'admin';
        
        $data['data']['pages'] = $this->Page_model->pages();
        $data['title'] = lang( 'pages' );
        $data['view'] = 'pages';
        
        $this->load_panel_template( $data, false );
    }
}
