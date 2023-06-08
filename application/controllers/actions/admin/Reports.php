<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Reports Controller ( Admin, Actions )
 *
 * @author  Shahzaib
 * @version 1.4
 */
class Reports extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        if ( ! $this->zuser->is_logged_in ) r_s_jump( 'login' );
        
        check_action_authorization( 'reports' );
        
        $this->load->model( 'Report_model' );
    }
    
    /**
     * Get Period Language Key
     *
     * @param  integer $period
     * @return string
     */
    private function get_period_language_key( $period )
    {
        if ( $period === 1 ) $key = 'past_3_days';
        else if ( $period === 2 ) $key = 'past_7_days';
        else if ( $period === 3 ) $key = 'past_2_weeks';
        else if ( $period === 4 ) $key = 'past_1_month';
        else if ( $period === 5 ) $key = 'past_3_months';
        else if ( $period === 6 ) $key = 'past_6_months';
        else if ( $period === 7 ) $key = 'past_12_months';
        else $key = 'all_time';
        
        return $key;
    }
    
    /**
     * Get Period Timestamp
     *
     * @param  integer $period
     * @return integer
     */
    private function get_period_timestamp( $period )
    {
        if ( $period === 1 ) $stamp = subtract_time( '3 days' );
        else if ( $period === 2 ) $stamp = subtract_time( '7 days' );
        else if ( $period === 3 ) $stamp = subtract_time( '14 days' );
        else if ( $period === 4 ) $stamp = subtract_time( '1 month' );
        else if ( $period === 5 ) $stamp = subtract_time( '3 months' );
        else if ( $period === 6 ) $stamp = subtract_time( '6 months' );
        else if ( $period === 7 ) $stamp = subtract_time( '12 months' );
        else $stamp = 0;
        
        return $stamp;
    }
    
    /**
     * Generate Report Input Handling.
     *
     * @return void
     */
    public function generate_report()
    {
        $period = intval( post( 'period' ) );
        $stamp = $this->get_period_timestamp( $period );
        
        $data = [
            'users' => $this->Report_model->users( $stamp ),
            'opened_tickets' => $this->Report_model->opened_tickets( $stamp ),
            'closed_tickets' => $this->Report_model->closed_tickets( $stamp ),
            'solved_tickets' => $this->Report_model->solved_tickets( $stamp ),
            'total_tickets' => $this->Report_model->total_tickets( $stamp ),
            'active_chats' => $this->Report_model->active_chats( $stamp ),
            'ended_chats' => $this->Report_model->ended_chats( $stamp ),
            'total_chats' => $this->Report_model->total_chats( $stamp ),
            'period' => $this->get_period_language_key( $period ),
            'generated_at' => time()
        ];
        
        $id = $this->Report_model->add_report( $data );
        
        if ( ! empty( $id ) )
        {
            $data['id'] = $id;
            
            $html = read_view( 'admin/responses/add_report', $data );
            
            r_success_add( $html, 'report_generated' );
        }
        
        r_error( 'went_wrong' );
    }
    
    /**
     * Delete Report
     *
     * @return void
     */
    public function delete()
    {
        $id = intval( post( 'id' ) );
        
        if ( $this->Report_model->delete_report( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
}
