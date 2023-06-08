<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Language Controller
 *
 * @author Shahzaib
 */
class Language extends MY_Controller {
    
    /**
     * Switch ( Action )
     *
     * @param  string $lang_key
     * @return void
     */
    public function switch( $lang_key = '' )
    {
        if ( empty( $lang_key ) ) redirect();
        
        if ( array_key_exists( $lang_key, AVAILABLE_LANGUAGES ) )
        {
            set_cookie( LANG_COOKIE, $lang_key, strtotime( '+1 year' ) );
        }
        
        if ( ! empty( $_SERVER['HTTP_REFERER'] ) )
        {
            redirect( $_SERVER['HTTP_REFERER'] );
            exit;
        }
        
        redirect();
    }
}
