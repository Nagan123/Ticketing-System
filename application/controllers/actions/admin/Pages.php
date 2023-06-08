<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Pages Controller ( Admin, Actions )
 *
 * @author Shahzaib
 */
class Pages extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        if ( ! $this->zuser->is_logged_in ) r_s_jump( 'login' );
        
        check_action_authorization( 'pages' );
        
        $this->load->library( 'form_validation' );
        $this->load->model( 'Page_model' );
    }
    
    /**
     * Update Page Input Handling.
     *
     * @return void
     */
    public function update_page()
    {
        if ( $this->form_validation->run( 'page' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'meta_description' => do_secure( post( 'meta_description' ) ),
                'meta_keywords' => do_secure( post( 'meta_keywords' ) ),
                'content' => do_secure( post( 'content' ), true )
            ];
            
            if ( $this->Page_model->update_page( $data, $id ) )
            {
                r_s_jump( 'admin/pages', 'updated' );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
}
