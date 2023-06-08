<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Custom Fields Controller ( Admin )
 *
 * @author  Shahzaib
 * @version 1.5
 */
class Custom_fields extends MY_Controller {
    
    /**
     * Custom Fields List Page
     *
     * @return void
     */
    public function index()
    {
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );
        
        check_page_authorization( 'custom_fields' );
        
        $this->load->model( 'Custom_field_model' );
        $this->set_admin_reference( 'others' );
        $this->area = 'admin';
        
        $data['data']['custom_fields'] = $this->Custom_field_model->custom_fields();
        $data['data']['delete_message_lang_key'] = 'sure_delete_field';
        $data['title'] = lang( 'custom_fields' );
        $data['view'] = 'custom_fields';
        
        $this->load_panel_template( $data, false );
    }
}
