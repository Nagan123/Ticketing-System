<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Custom Fields Controller ( Admin, Actions )
 *
 * @author  Shahzaib
 * @version 1.5
 */
class Custom_fields extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        if ( ! $this->zuser->is_logged_in ) r_s_jump( 'login' );
        
        check_action_authorization( 'custom_fields' );
        
        $this->load->library( 'form_validation' );
        
        $this->load->model( 'Custom_field_model' );
    }
    
    /**
     * Option Required
     *
     * @param  string $type
     * @param  string $options Comma Separated
     * @return void
     */
    private function option_required( $type, $options )
    {
        $types = ['checkbox', 'radio', 'select'];
        
        if ( in_array( $type, $types ) && empty( $options ) ) r_error( 'options_req' );
    }
    
    /**
     * Add Custom Field Input Handling.
     *
     * @return void
     */
    public function add_custom_field()
    {
        if ( $this->form_validation->run( 'custom_field' ) )
        {
            $data = [
                'name' => do_secure( post( 'name' ) ),
                'is_required' => only_binary( post( 'is_required' ) ),
                'guide_text' => do_secure( post( 'guide_text' ) ),
                'type' => do_secure_l( post( 'type' ) ),
                'options' => do_secure( post( 'options' ) ),
                'created_at' => time()
            ];
            
            $this->option_required( $data['type'], $data['options'] );
            
            $id = $this->Custom_field_model->add_custom_field( $data );
                
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                
                $html = read_view( 'admin/responses/add_custom_field', $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Edit Custom Field ( Response ).
     *
     * @return void
     */
    public function edit_custom_field()
    {
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Custom_field_model->custom_field( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_custom_field', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Custom Field Input Handling.
     *
     * @return void
     */
    public function update_custom_field()
    {
        if ( $this->form_validation->run( 'custom_field' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'name' => do_secure( post( 'name' ) ),
                'is_required' => only_binary( post( 'is_required' ) ),
                'guide_text' => do_secure( post( 'guide_text' ) ),
                'type' => do_secure_l( post( 'type' ) ),
                'options' => do_secure( post( 'options' ) )
            ];
            
            $this->option_required( $data['type'], $data['options'] );
            
            if ( $this->Custom_field_model->update_custom_field( $data, $id ) )
            {
                $data = $this->Custom_field_model->custom_field( $id );
                $html = read_view( 'admin/responses/update_custom_field', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Custom Field
     *
     * @return void
     */
    public function delete()
    {
        $id = intval( post( 'id' ) );
        
        if ( $this->Custom_field_model->delete_custom_field( $id ) )
        {
            $this->Custom_field_model->delete_tickets_custom_fields( $id );
            
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
}
