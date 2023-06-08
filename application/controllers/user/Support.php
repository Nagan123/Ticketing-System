<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Support Controller
 *
 * @author Shahzaib
 */
class Support extends MY_Controller {
    
    /**
     * Logged in User ID
     *
     * @var integer
     */
    private $user_id;
    
    
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
        
        $this->sub_area = 'support';
        $this->user_id = $this->zuser->get( 'id' );
        $this->area = 'user';
        
        $this->load->model( 'Support_model' );
    }
    
    /**
     * Tickets Page
     *
     * @param  string $type
     * @return void
     */
    public function tickets( $type = '' )
    {
        $this->load->library( 'pagination' );
        $this->set_user_reference( 'tickets' );
        
        $to_fetch = ['user_id' => $this->user_id];
        $to_count = $to_fetch;
        
        $config['per_page'] = PER_PAGE_RESULTS;
        $offset = get_offset( $config['per_page'], 5 );
        $to_fetch['limit'] = $config['per_page'];
        $to_count['count'] = true;
        $data['data']['page_all'] = false;
        $searched = do_secure( get( 'search' ) );
        
        $to_fetch['searched'] = $searched;
        $to_count['searched'] = $searched;
        
        if ( $type === 'all' )
        {
            $config['base_url'] = env_url( 'user/support/tickets/all' );
            $data['title'] = lang( 'all' );
            $data['data']['page_all'] = true;
        }
        else if ( $type === 'opened' )
        {
            $config['base_url'] = env_url( 'user/support/tickets/opened' );
            $data['title'] = lang( 'opened' );
            $to_fetch['status'] = 1;
            $to_count['status'] = 1;
        }
        else if ( $type === 'closed' )
        {
            $config['base_url'] = env_url( 'user/support/tickets/closed' );
            $data['title'] = lang( 'closed' );
            $to_fetch['status'] = 0;
            $to_count['status'] = 0;
        }
        else
        {
            redirect();
        }
        
        $to_fetch['offset'] = $offset;
        $config['total_rows'] = $this->Support_model->tickets( $to_count );
        
        $this->pagination->initialize( $config );
        
        $data['data']['searched'] = $searched;
        $data['data']['pagination'] = $this->pagination->create_links();
        $tickets = $this->Support_model->tickets( $to_fetch );
        $data['data']['tickets'] = $tickets;
        $data['view'] = 'tickets';
        
        $this->load_public_template( $data );
    }
    
    /**
     * Ticket Page
     *
     * @param  integer $id
     * @return void
     */
    public function ticket( $id = 0 )
    {
        if ( empty( $id ) ) env_redirect( 'user/support/tickets/all' );
        
        $ticket = $this->Support_model->ticket( intval( $id ), $this->user_id );
        
        if ( empty( $ticket ) ) env_redirect( 'user/support/tickets/all' );
        
        $this->load->model( 'Custom_field_model' );

        $replies = $this->Support_model->tickets_replies( $ticket->id );
        
        if ( ( $ticket->sub_status == 2 || ( $ticket->sub_status == 3 && $ticket->last_reply_area != 2 ) ) && $ticket->is_read == 0 )
        {
            $this->Support_model->update_ticket( ['is_read' => 1], $ticket->id, false );
        }
        
        $this->set_user_reference( 'tickets' );
        $data['data']['gr_field'] = true;
        $data['data']['ticket'] = $ticket;
        $data['data']['replies'] = $replies;
        $data['data']['fields'] = $this->Custom_field_model->custom_fields_data( $ticket->id );
        $data['title'] = $ticket->id;
        $data['view'] = 'ticket';
        
        $this->load_public_template( $data );
    }
    
    /**
     * Create Ticket Page
     *
     * @return void
     */
    public function create_ticket()
    {
        $this->load->model( 'Custom_field_model' );
        
        $this->set_user_reference( 'tickets' );
        $data['data']['gr_field'] = true;
        $data['data']['departments'] = $this->Support_model->departments( 1 );
        $data['data']['fields'] = $this->Custom_field_model->custom_fields( 'ASC' );
        $data['data']['form_class'] = 'mb-3';
        $data['data']['label_required_class'] = 'text-danger';
        $data['title'] = lang( 'create_ticket' );
        $data['view'] = 'create_ticket';
        
        $this->load_public_template( $data );
    }
}
