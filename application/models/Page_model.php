<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Page Model
 *
 * @author Shahzaib
 */
class Page_model extends MY_Model {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = 'pages';
    }
    
    /**
     * Pages
     *
     * @return object
     */
    public function pages()
    {
        return $this->get();
    }
    
    /**
     * Page
     *
     * @param  integer $id
     * @return object
     */
    public function page( $id )
    {
        $data['column_value'] = $id;
        
        return $this->get_one( $data );
    }
    
    /**
     * Update Page
     *
     * @param  array   $to_update
     * @param  integer $id
     * @return boolean
     */
    public function update_page( $to_update, $id )
    {
       $data['column_value'] = $id;
       $data['data'] = $to_update;
       
       return $this->update( $data );
    }
}
