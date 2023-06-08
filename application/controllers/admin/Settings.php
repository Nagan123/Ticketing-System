<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Settings Controller ( Admin )
 *
 * @author Shahzaib
 */
class Settings extends MY_Controller {
    
    /**
     * Class Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );

        check_page_authorization( 'settings' );
        
        $this->sub_area = 'settings';
        $this->area = 'admin';
    }
    
    /**
     * General Settings Page
     *
     * @return void
     */
    public function general()
    {
        $this->set_admin_reference( 'others' );
        
        $data['title'] = sub_title( lang( 'settings' ), lang( 'general' ) );
        $data['view'] = 'general';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Support Settings Page
     *
     * @return void
     */
    public function support()
    {
        $this->set_admin_reference( 'others' );
        
        $data['title'] = sub_title( lang( 'settings' ), lang( 'support' ) );
        $data['view'] = 'support';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Roles Setting Page
     *
     * @param  integer $id
     * @return void
     */
    public function roles( $id = 0 )
    {
        check_page_authorization( 'roles_and_permissions' );
        
        $this->set_admin_reference( 'others' );
        
        $data['title'] = sub_title( lang( 'settings' ), lang( 'roles' ) );
        
        if ( ! empty( $id ) )
        {
            $role = $this->Setting_model->role( $id );
            
            if ( ! empty( $role ) )
            {
                $data['data']['permissions'] = $this->Setting_model->permissions();
                $data['data']['role'] = $role->name;
                $data['data']['role_id'] = $role->id;
                $data['view'] = 'roles_permissions';
            }
            else
            {
                env_redirect( 'admin/settings/roles' );
            }
        }
        else
        {
            $data['data']['roles'] = $this->Setting_model->roles();
            $data['delete_method'] = 'delete_role';
            $data['view'] = 'roles';
        }
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Permissions Setting Page
     *
     * @return void
     */
    public function permissions()
    {
        check_page_authorization( 'roles_and_permissions' );
        
        $this->set_admin_reference( 'others' );
        
        $data['data']['permissions'] = $this->Setting_model->permissions();
        $data['title'] = sub_title( lang( 'settings' ), lang( 'permissions' ) );
        $data['view'] = 'permissions';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Users Settings Page
     *
     * @return void
     */
    public function users()
    {
        $this->set_admin_reference( 'others' );
        
        $data['data']['roles'] = $this->Setting_model->roles();
        $data['title'] = sub_title( lang( 'settings' ), lang( 'users' ) );
        $data['view'] = 'users';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * APIs Settings Page
     *
     * @return void
     */
    public function apis()
    {
        $this->set_admin_reference( 'others' );
        
        $data['title'] = sub_title( lang( 'settings' ), lang( 'apis' ) );
        $data['view'] = 'apis';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Email Settings Page
     *
     * @return void
     */
    public function email()
    {
        $this->set_admin_reference( 'others' );
        
        $data['title'] = sub_title( lang( 'settings' ), lang( 'email' ) );
        $data['view'] = 'email';
        
        $this->load_panel_template( $data );
    }
}
