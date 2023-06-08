<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Reports Controller ( Admin )
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
        
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );
        
        check_page_authorization( 'reports' );
        
        $this->load->model( 'Report_model' );
        
        $this->area = 'admin';
    }
    
    /**
     * Reports List Page
     *
     * @return void
     */
    public function index()
    {
        $this->load->library( 'pagination' );
        $this->set_admin_reference( 'others' );
        
        $config['base_url'] = env_url( 'admin/reports/index' );
        $config['total_rows'] = $this->Report_model->reports( true );
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $data['data']['reports'] = $this->Report_model->reports(
            false,
            $config['per_page'],
            $offset
        );
        
        $data['title'] = lang( 'reports' );
        $data['view'] = 'reports';
        
        $this->load_panel_template( $data, false );
    }
    
    /**
     * Report ( PDF )
     *
     * @param  integer $id
     * @return void
     */
    public function report( $id = 0 )
    {
        if ( empty( $id ) ) env_redirect( 'admin/reports' );
        
        $data = $this->Report_model->report( $id );
        
        if ( empty( $data ) ) env_redirect( 'admin/reports' );
        
        $css_file = FCPATH . 'assets/' . get_theme_name() . 'css/report_pdf.css';
        $css = '<style>' . file_get_contents( $css_file ) . '</style>';
        
        $html = read_view( 'admin/report', $data );
        
        $this->load->library( 'Zpdf' );
        $this->zpdf->loadHtml( $css . $html );
        $this->zpdf->setPaper( 'A4' );
        $this->zpdf->render();
        
        $this->zpdf->stream( $id . '.pdf', ['Attachment' => 0] );
    }
}
