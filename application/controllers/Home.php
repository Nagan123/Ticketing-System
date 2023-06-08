<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Home Controller
 *
 * @author Shahzaib
 */
class Home extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->area = 'home';
    }
    
    /**
     * Ticket Verification ( Action ).
     *
     * @param   integer $ticket_id
     * @param   string  $token
     * @return  void
     * @version 1.6
     */
    public function tverify( $ticket_id = 0, $token = '' )
    {
        $this->load->model( 'Email_token_model' );
        
        if ( $this->Email_token_model->email_token( $token, 'ticket_verification', $ticket_id ) )
        {
            $this->load->model( 'Support_model' );
            
            $ticket = $this->Support_model->ticket( $ticket_id );
                
            if ( empty( $ticket ) ) error_redirect( 'went_wrong', '' );
            
            $togo = 'ticket/guest/' . $ticket->security_key. "/{$ticket_id}";
            
            if ( $this->Support_model->mark_as_tverified( $ticket_id ) )
            {
                $this->Email_token_model->delete_email_token( $ticket_id, 'ticket_verification' );
                
                log_ticket_activity( 'ticket_verified', $ticket_id );
                
                success_redirect( 'ticket_verified', $togo );
            }
            
            error_redirect( 'went_wrong', $togo );
        }
        
        error_redirect( 'invalid_token', '' );
    }
    
    /**
     * Index Page
     *
     * @return void
     */
    public function index()
    {
        $this->load->model( 'Support_model' );
        
        $data['data']['popular_topics'] = $this->Support_model->popular_topics();
        $data['view'] = 'welcome';
        
        $this->load_public_template( $data, false );
    }
    
    /**
     * Page ( Terms of Use and Privacy Policy ).
     *
     * @param  integer $value
     * @return void
     */
    public function page( $value = 0 )
    {
        $value = do_secure( $value );
        
        $this->load->model( 'Page_model' );
        
        $page = $this->Page_model->page( $value );
        
        if ( empty( $page ) ) show_404();
        
        $data['data']['page'] = $page;
        $data['meta_description'] = $page->meta_description;
        $data['meta_keywords'] = $page->meta_keywords;
        $data['title'] = get_page_name( $value );
        $data['view'] = 'page';
        
        $this->load_public_template( $data, false );
    }
}
