<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Tools Controller ( User, Actions )
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
    }
    
    /**
     * Delete User Session
     *
     * @return void
     */
    public function delete_user_session()
    {
        $id = intval( post( 'id' ) );
        $user_id = $this->zuser->get( 'id' );
        $session = $this->Tool_model->user_session( $id, $user_id );
        $current = false;
        
        if ( empty( $session ) ) r_error( 'invalid_req' );
        
        if ( $session->user_id == $this->zuser->get( 'id' ) )
        {
            if ( $session->token == get_session( USER_TOKEN ) )
            {
                $current = true;
            }
            
            if ( $this->Tool_model->delete_user_session( $id ) )
            {
                if ( $current )
                {
                    r_s_jump( 'login', 'u_sess_deleted' );
                }
                
                r_s_jump( 'user/sessions', 'u_sess_deleted' );
            }
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Logout From Other Device(s)
     *
     * @return void
     */
    public function logout_my_others()
    {
        if ( $this->Tool_model->logout_my_others() )
        {
            r_s_jump( 'user/sessions', 'lom_others' );
        }
        
        r_error( 'went_wrong' );
    }
}
