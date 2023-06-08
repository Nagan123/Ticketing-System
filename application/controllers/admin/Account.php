<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Account Controller ( Admin )
 *
 * @author Shahzaib
 */
class Account extends MY_Controller {
    
    /**
     * Change Password Page ( Admin ).
     *
     * @return void
     */
    public function change_password()
    {
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );
        
        if ( ! $this->zuser->is_team_member() )
        {
            env_redirect( get_related_dashboard() );
        }
        
        $this->sub_area = 'account';
        $this->area = 'admin';
        $this->set_admin_reference( 'account' );
        
        $data['title'] = lang( 'change_password' );
        $data['view'] = 'settings/change_password';
        
        $this->load_panel_template( $data );
    }
}
