<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Support Controller ( Admin )
 *
 * @author Shahzaib
 */
class Support extends MY_Controller {

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
        $this->area = 'admin';
        
        $this->load->model( 'Support_model' );
        $this->load->library( 'pagination' );
    }
    
    /**
     * Chats Page
     *
     * @param   string $type
     * @return  void
     * @version 1.4
     */
    public function chats( $type = '' )
    {
        check_page_authorization( 'chats' );
        
        $this->set_admin_reference( 'chats' );
        
        $to_fetch = [];
        $to_count = [];
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        $to_fetch['limit'] = $config['per_page'];
        $to_count['count'] = true;
        $data['data']['assigned'] = false;
        $to_fetch['assigned'] = false;
        $to_count['assigned'] = false;
        $searched = do_secure( get( 'search' ) );
        $reply_status = intval( get( 'reply_status' ) );
        
        $to_fetch['searched'] = $searched;
        $to_count['searched'] = $searched;
        $to_fetch['reply_status'] = $reply_status;
        $to_count['reply_status'] = $reply_status;
        
        if ( $type === 'all' )
        {
            $config['base_url'] = env_url( 'admin/chats/all' );
            $data['title'] = lang( 'all_chats' );
        }
        else if ( $type === 'active' )
        {
            $config['base_url'] = env_url( 'admin/chats/active' );
            $data['title'] = lang( 'active_chats' );
            $to_fetch['status'] = 1;
            $to_count['status'] = 1;
        }
        else if ( $type === 'ended' )
        {
            $config['base_url'] = env_url( 'admin/chats/ended' );
            $data['title'] = lang( 'ended_chats' );
            $to_fetch['status'] = 0;
            $to_count['status'] = 0;
        }
        else if ( $type === 'assigned' )
        {
            $config['base_url'] = env_url( 'admin/chats/assigned' );
            $data['title'] = lang( 'assigned_chats' );
            $data['data']['assigned'] = true;
            $to_fetch['assigned'] = true;
            $to_count['assigned'] = true;
        }
        else
        {
            env_redirect( get_related_dashboard() );
        }
        
        $to_fetch['offset'] = $offset;
        $config['total_rows'] = $this->Support_model->chats( $to_count );
        
        $this->pagination->initialize( $config );
        
        $data['data']['pagination'] = $this->pagination->create_links();
        $data['data']['chats'] = $this->Support_model->chats( $to_fetch );
        $data['data']['card_title'] = $data['title'];
        $data['data']['main_controller'] = 'support';
        $data['delete_method'] = 'delete_chat';
        $data['view'] = 'chats';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Chat Page
     *
     * @param   integer $id
     * @return  void
     * @version 1.4
     */
    public function chat( $id = 0 )
    {
        check_page_authorization( 'chats' );
        
        $chat = $this->Support_model->chat( intval( $id ) );
        
        if ( empty( $chat ) ) env_redirect( 'admin/chats/all' );
        
        $this->set_admin_reference( 'chats' );

        $replies = $this->Support_model->chat_replies( $chat->id );
        $user_id = $this->zuser->get( 'id' );
        
        if ( $chat->is_read_assigned == 0 && ( $chat->assigned_to == $user_id && get( 'read' ) != 'false' ) )
        {
            $this->Support_model->update_chat( ['is_read_assigned' => 1], $chat->id, false );
        }
        
        if ( ( $chat->sub_status == 1 && $chat->is_read == 0 && ( $chat->assigned_to == null || $chat->assigned_to == $user_id ) ) )
        {
            $this->Support_model->update_chat( ['is_read' => 1], $chat->id, false );
        }
        
        $data['title'] = $chat->id;
        $data['data']['scripts'] = [get_assets_path( 'panel/js/chat_script.js?v=' . v_combine() )];
        $data['data']['canned_replies'] = $this->Support_model->canned_replies();
        $data['data']['chat'] = $chat;
        $data['data']['replies'] = $replies;
        $data['data']['main_controller'] = 'support';
        $data['view'] = 'chat';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Tickets Departments Page
     *
     * @param  integer $id
     * @param  string  $type
     * @return void
     */
    public function departments( $id = 0, $type = 'tickets' )
    {
        check_page_authorization( 'departments' );
        
        $this->set_admin_reference( 'tickets_and_chats' );
        
        if ( ! empty( $id ) )
        {
            $id = intval( $id );
            $department = $this->Support_model->department( $id );
            
            if ( ! empty( $department ) )
            {
                if ( ! in_array( $type, ['tickets', 'chats'] ) )
                {
                    env_redirect( 'admin/support/departments' );
                }
                
                $data['title'] = sub_title( lang( 'departments' ), $department->name );
                $config['per_page'] = PER_PAGE_RESULTS_PANEL;
                $offset = get_offset( $config['per_page'], 6 );
                $config['base_url'] = env_url( "admin/support/departments/{$id}/{$type}" );
                
                if ( $type === 'tickets' )
                {
                    check_page_authorization( 'tickets' );                       

                    $data['delete_method'] = 'delete_ticket';
                    $data['view'] = 'department_tickets';
                }
                else
                {
                    check_page_authorization( 'chats' );
                    
                    $data['delete_method'] = 'delete_chat';
                    $data['view'] = 'department_chats';
                }
                
                $total_rows = ['department_id' => $id, 'count' => true];
                $rows_data = ['department_id' => $id, 'limit' => $config['per_page'], 'offset' => $offset];
                
                if ( $type === 'chats' )
                {
                    if ( ! $this->zuser->has_permission( 'all_chats' ) )
                    {
                        $total_rows['assigned'] = true;
                        $rows_data['assigned'] = true;
                    }
                }
                
                $all_rows = $this->Support_model->{$type}( $total_rows );
                
                $config['total_rows'] = $all_rows;
                
                if ( $type == 'tickets' )
                {
                    $data['data']['all_tickets'] = $all_rows;
            
                    $total_rows['status'] = 1;
                    $data['data']['opened_tickets'] = $this->Support_model->tickets( $total_rows );
                    
                    $total_rows['status'] = 0;
                    $data['data']['closed_tickets'] = $this->Support_model->tickets( $total_rows );
                }
                else
                {
                    $data['data']['all_chats'] = $all_rows;
            
                    $total_rows['status'] = 1;
                    $data['data']['active_chats'] = $this->Support_model->chats( $total_rows );
                    
                    $total_rows['status'] = 0;
                    $data['data']['ended_chats'] = $this->Support_model->chats( $total_rows );
                }
                
                $data['data'][$type] = $this->Support_model->{$type}( $rows_data );
                
                $this->pagination->initialize( $config );
                
                $data['data']['pagination'] = $this->pagination->create_links();
                $data['data']['card_title'] = $department->name;
                $data['data']['main_controller'] = 'support';
            }
            else
            {
                env_redirect( 'admin/support/departments' );
            }
        }
        else
        {
            $data['data']['departments'] = $this->Support_model->departments();
            $data['delete_method'] = 'delete_department';
            $data['title'] = lang( 'departments' );
            $data['view'] = 'departments';
        }
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Canned Replies Page
     *
     * @return void
     */
    public function canned_replies()
    {
        check_page_authorization( 'canned_replies' );
        
        $this->set_admin_reference( 'tickets_and_chats' );
        
        $config['base_url'] = env_url( 'admin/support/canned_replies' );
        $config['total_rows'] = $this->Support_model->canned_replies( true );
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        
        $this->pagination->initialize( $config );
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $data['data']['canned_replies'] = $this->Support_model->canned_replies(
            false,
            $config['per_page'],
            $offset
        );
        
        $data['delete_method'] = 'delete_canned_reply';
        $data['title'] = lang( 'canned_replies' );
        $data['view'] = 'canned_replies';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * FAQs Page
     *
     * @param  string $page
     * @return void
     */
    public function faqs( $page = 'list' )
    {
        check_page_authorization( 'faqs' );
        
        if ( $page === 'list' )
        {
            $config['base_url'] = env_url( 'admin/support/faqs/list' );
            $config['total_rows'] = $this->Support_model->faqs( true );
            $config['per_page'] = PER_PAGE_RESULTS_PANEL;
            $offset = get_offset( $config['per_page'], 5 );
            
            $this->pagination->initialize( $config );
            $data['data']['pagination'] = $this->pagination->create_links();
            
            $data['data']['faqs'] = $this->Support_model->faqs(
                false,
                $config['per_page'],
                $offset
            );
            
            $data['delete_method'] = 'delete_faq';
            $data['title'] = lang( 'faqs' );
            $data['view'] = 'faqs';
        }
        else if ( $page === 'categories' )
        {
            $page_title = sub_title( lang( 'faqs' ), lang( 'categories' ) );
            $categories = $this->Support_model->faqs_categories();
            
            $data['data']['faqs_categories'] = $categories;
            $data['delete_method'] = 'delete_faqs_category';
            $data['title'] = $page_title;
            $data['view'] = 'faqs_categories';
        }
        else
        {
            env_redirect( 'admin/support/faqs' );
        }
        
        $this->set_admin_reference( 'others' );
        $this->load_panel_template( $data );
    }
    
    /**
     * Tickets Pages
     *
     * @param  string $type
     * @return void
     */
    private function tickets( $type = 'all' )
    {
        check_page_authorization( 'tickets' );
        
        $this->set_admin_reference( 'tickets' );
        
        $to_fetch = [];
        $to_count = [];
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'] );
        $to_fetch['limit'] = $config['per_page'];
        $to_count['count'] = true;
        $data['data']['assigned'] = false;
        $searched = do_secure( get( 'search' ) );
        $reply_status = intval( get( 'reply_status' ) );
        $priority = do_secure_l( get( 'priority' ) );
        
        $to_fetch['searched'] = $searched;
        $to_count['searched'] = $searched;
        $to_fetch['reply_status'] = $reply_status;
        $to_count['reply_status'] = $reply_status;
        $to_fetch['priority'] = $priority;
        $to_count['priority'] = $priority;
        
        if ( $type === 'all' )
        {
            $config['base_url'] = env_url( 'admin/tickets/all' );
            $data['title'] = lang( 'all_tickets' );
        }
        else if ( $type === 'opened' )
        {
            $config['base_url'] = env_url( 'admin/tickets/opened' );
            $data['title'] = lang( 'opened_tickets' );
            $to_fetch['status'] = 1;
            $to_count['status'] = 1;
        }
        else if ( $type === 'closed' )
        {
            $config['base_url'] = env_url( 'admin/tickets/closed' );
            $data['title'] = lang( 'closed_tickets' );
            $to_fetch['status'] = 0;
            $to_count['status'] = 0;
        }
        else if ( $type === 'assigned' )
        {
            if ( ! $this->zuser->has_permission( 'all_tickets' ) )
            {
                env_redirect( get_related_dashboard() );
            }
            
            $config['base_url'] = env_url( 'admin/tickets/assigned' );
            $data['title'] = lang( 'assigned_tickets' );
            $data['data']['assigned'] = true;
            $to_fetch['assigned'] = true;
            $to_count['assigned'] = true;
        }
        else
        {
            env_redirect( get_related_dashboard() );
        }
        
        $to_fetch['offset'] = $offset;
        $config['total_rows'] = $this->Support_model->tickets( $to_count );
        
        $this->pagination->initialize( $config );
        
        $data['data']['pagination'] = $this->pagination->create_links();
        $data['data']['tickets'] = $this->Support_model->tickets( $to_fetch );
        $data['data']['card_title'] = $data['title'];
        $data['data']['main_controller'] = 'support';
        $data['delete_method'] = 'delete_ticket';
        $data['view'] = 'tickets';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * All Tickets Page
     *
     * @return void
     */
    public function all_tickets()
    {
        $this->tickets( 'all' );
    }
    
    /**
     * Opened Tickets Page
     *
     * @return void
     */
    public function opened_tickets()
    {
        $this->tickets( 'opened' );
    }
    
    /**
     * Closed Tickets Page
     *
     * @return void
     */
    public function closed_tickets()
    {
        $this->tickets( 'closed' );
    }
    
    /**
     * Assigned Tickets Page
     *
     * @return void
     */
    public function assigned_tickets()
    {
        $this->tickets( 'assigned' );
    }
    
    /**
     * Create Ticket Page
     *
     * @return  void
     * @version 1.1
     */
    public function create_ticket()
    {
        if ( ! $this->zuser->is_logged_in ) env_redirect( 'login' );
        
        check_page_authorization( 'all_tickets' );
        
        $this->load->model( 'User_model' );
        $this->load->model( 'Custom_field_model' );
        
        $this->set_admin_reference( 'tickets' );
        
        $data['data']['departments'] = $this->Support_model->departments();
        $data['data']['customers'] = $this->User_model->active_users();
        $data['data']['fields'] = $this->Custom_field_model->custom_fields( 'ASC' );
        $data['data']['form_class'] = 'form-group';
        $data['data']['label_required_class'] = 'required';
        $data['title'] = lang( 'create_ticket' );
        $data['view'] = 'create_ticket';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Ticket Page
     *
     * @param  integer $id
     * @return void
     */
    public function ticket( $id = 0 )
    {
        check_page_authorization( 'tickets' );
        
        $this->load->model( 'Custom_field_model' );
        
        $ticket = $this->Support_model->ticket( intval( $id ) );
        
        if ( empty( $ticket ) ) env_redirect( 'admin/tickets/all' );

        $replies = $this->Support_model->tickets_replies( $ticket->id );
        $user_id = $this->zuser->get( 'id' );
        
        if ( $ticket->is_read_assigned == 0 && ( $ticket->assigned_to == $user_id && get( 'read' ) != 'false' ) )
        {
            $this->Support_model->update_ticket( ['is_read_assigned' => 1], $ticket->id, false );
        }
        
        if ( ( $ticket->sub_status == 1 || ( $ticket->sub_status == 3 && $ticket->last_reply_area != 1 ) ) &&
        $ticket->is_read == 0 && ( $ticket->assigned_to == null || $ticket->assigned_to == $user_id ) )
        {
            $this->Support_model->update_ticket( ['is_read' => 1], $ticket->id, false );
        }
        
        $this->set_admin_reference( 'tickets' );
        
        $data['title'] = $ticket->id;
        
        $data['data']['history'] = $this->Support_model->ticket_history([
            'ticket_id' => $id,
            'limit' => 3
        ]);
        
        $data['data']['history_count'] = $this->Support_model->ticket_history([
            'ticket_id' => $id,
            'count' => true
        ]);
        
        $data['data']['canned_replies'] = $this->Support_model->canned_replies();
        $data['data']['fields'] = $this->Custom_field_model->custom_fields_data( $ticket->id );
        $data['data']['ticket'] = $ticket;
        $data['data']['replies'] = $replies;
        $data['data']['main_controller'] = 'support';
        $data['delete_method'] = 'delete_reply';
        $data['view'] = 'ticket';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Ticket History Page
     *
     * @param  integer $id
     * @return void
     */
    public function ticket_history( $id = 0 )
    {
        check_page_authorization( 'tickets' );

        $ticket = $this->Support_model->ticket( intval( $id ) );

        if ( empty( $ticket ) ) env_redirect( 'admin/tickets/all' );
        
        $this->set_admin_reference( 'tickets' );
        
        $config['base_url'] = env_url( 'admin/tickets/history/' . $id . '/page' );
        
        $config['total_rows'] = $this->Support_model->ticket_history([
            'ticket_id' => $id,
            'count' => true
        ]);
        
        $config['per_page'] = PER_PAGE_RESULTS_PANEL;
        $offset = get_offset( $config['per_page'], 6 );
        
        $this->pagination->initialize( $config );
        
        $data['data']['pagination'] = $this->pagination->create_links();
        
        $data['title'] = sub_title( lang( 'ticket_history' ), $ticket->id );
        
        $data['data']['history'] = $this->Support_model->ticket_history([
            'ticket_id' => $id,
            'limit' => $config['per_page'],
            'offset' => $offset
        ]);
        
        $data['view'] = 'ticket_history';
        
        $this->load_panel_template( $data );
    }
    
    /**
     * Articles Categories ( Knowledge Base ) Page.
     *
     * @param  string $type
     * @return void
     */
    public function articles_categories( $type = 'parent' )
    {
        check_page_authorization( 'knowledge_base' );
        
        if ( $type === 'parent' )
        {
            $page_title = sub_title( lang( 'knowledge_base' ), lang( 'categories' ) );
            
            $data['data']['categories'] = $this->Support_model->articles_categories();
            $data['title'] = $page_title;
            $data['view'] = 'knowledge_base/categories';
        }
        else if ( $type === 'sub' )
        {
            $page_title = sub_title( lang( 'knowledge_base' ), lang( 'subcategories' ) );
            
            $data['data']['categories'] = $this->Support_model->articles_categories( 'sub' );
            $data['title'] = $page_title;
            $data['view'] = 'knowledge_base/subcategories';
        }
        else
        {
            env_redirect( get_related_dashboard() );
        }
        
        $data['delete_method'] = 'delete_articles_category';
        $data['data']['main_controller'] = 'support';
        
        $this->set_admin_reference( 'others' );
        $this->load_panel_template( $data );
    }
    
    /**
     * Articles ( Knowledge Base ) Page.
     *
     * @param  string  $type
     * @param  integer $id
     * @return void
     */
    public function articles( $type = 'list', $id = 0 )
    {
        check_page_authorization( 'knowledge_base' );
        
        $this->set_admin_reference( 'others' );
        
        $page_title = sub_title( lang( 'knowledge_base' ), lang( 'articles' ) );
        
        if ( $type === 'list' )
        {
            $options = [];
            $options['searched'] = do_secure( get( 'search' ) );
            $options['visibility'] = do_secure_l( get( 'visibility' ) );
            
            $config['base_url'] = env_url( 'admin/knowledge_base/articles/list' );
            $config['total_rows'] = $this->Support_model->articles( true, 0, 0, $options );
            $config['per_page'] = PER_PAGE_RESULTS_PANEL;
            $offset = get_offset( $config['per_page'], 5 );
            
            $this->pagination->initialize( $config );
            $data['data']['pagination'] = $this->pagination->create_links();
            
            $data['data']['articles'] = $this->Support_model->articles(
                false,
                $config['per_page'],
                $offset,
                $options
            );
            
            $data['data']['main_controller'] = 'support';
            $data['delete_method'] = 'delete_article';
            $data['view'] = 'knowledge_base/articles';
        }
        else if ( $type === 'new' )
        {
            $page_title = sub_title( $page_title, lang( 'new_article' ) );
            $data['view'] = 'knowledge_base/new_article';
        }
        else
        {
            $article = $this->Support_model->article( $id );
            
            if ( empty( $article ) ) env_redirect( 'admin/knowledge_base/articles' );
        
            $page_title = sub_title( $page_title, lang( 'edit_article' ) );
            $data['data']['article'] = $article;
            $data['view'] = 'knowledge_base/edit_article';
        }
        
        $data['title'] = $page_title;
        $this->load_panel_template( $data );
    }
}
