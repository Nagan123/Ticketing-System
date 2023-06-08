<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * Support Controller ( Admin, Actions )
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
        
        if ( ! $this->zuser->is_logged_in ) r_s_jump( 'login' );
        
        $this->load->library( 'form_validation' );
        $this->load->model( 'Support_model' );
    }
    
    /**
     * Resend Ticket Access URL
     *
     * @return  void
     * @version 1.6
     */
    public function ticket_resend_access()
    {
        check_action_authorization( 'tickets' );
        
        if ( ! is_email_settings_filled() ) r_error( 'missing_email_config_a' );
        
        $id = intval( post( 'id' ) );
        $ticket = $this->Support_model->ticket( $id );
        
        if ( empty( $ticket ) ) r_error( 'invalid_req' );
        
        $hook = 'resend_ticket_access';
        $template = $this->Tool_model->email_template_by_hook_and_lang( $hook, get_language() );
        
        if ( empty( $template ) ) r_error( 'missing_template' );
        
        $subject = $template->subject;
        
        $message = replace_placeholders( $template->template, [
            '{TICKET_URL}' => env_url( 'ticket/guest/' . $ticket->security_key . "/{$id}" ),
            '{TICKET_ID}' => $id,
            '{SITE_NAME}' => db_config( 'site_name' )
        ]);
        
        $email_address = $ticket->email_address;
        
        if ( empty( $email_address ) ) r_error( 'invalid_req' );
        
        $this->load->library( 'ZMailer' );

        if ( $this->zmailer->send_email( $email_address, $subject, $message ) )
        {
            log_ticket_activity( 'ticket_access_resent', $id );
            
            r_success_cm( 'email_sent' );
        }
        
        r_error( 'failed_email_status' );
    }
    
    /**
     * Add Chat Reply Input Handling.
     *
     * @return void
     */
    public function add_chat_reply()
    {
        check_action_authorization( 'chats' );
        
        $chat_id = intval( post( 'id' ) );
        $chat = $this->Support_model->chat( $chat_id );
        $my_id = $this->zuser->get( 'id' );
        $to_update = [];
        
        if ( empty( $chat ) ) r_error( 'invalid_req' );
        
        if ( $chat->status == 0 ) r_error( 'chat_ended' );
        
        if ( $this->form_validation->run( 'add_reply' ) )
        {
            $data = [
                'chat_id' => $chat_id,
                'user_id' => $my_id,
                'area' => 1,
                'message' => do_secure( post( 'reply' ), true ),
                'replied_at' => time()
            ];
            
            $to_update['sub_status'] = 2;
            
            $id = $this->Support_model->add_chat_reply( $data );
            
            if ( ! empty( $id ) )
            {
                $this->Support_model->update_chat( $to_update, $chat_id );
                
                r_reset_form();
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( form_error( 'reply' ) );
    }
    
    /**
     * Chat Subject ( Read More ) Response.
     *
     * @return  void
     * @version 1.4
     */
    public function chat_subject()
    {
        check_action_authorization( 'chats' );
        
        $id = intval( post( 'id' ) );
        $data = $this->Support_model->chat( $id );
        
        if ( ! empty( $data ) )
        {
            $data = [
                'detail' => $data->subject,
                'type' => lang( 'subject' ),
                'id' => $id
            ];
            
            display_view( 'admin/responses/read_more', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Get Chat Messages
     *
     * @param   integer $id
     * @return  void
     * @version 1.4
     */
    public function get_chat_messages( $id = 0 )
    {
        check_action_authorization( 'chats' );
        
        $id = intval( $id );
        
        $chat = $this->Support_model->chat( $id );
        
        if ( ! empty( $chat ) )
        {
            $data['having_replies'] = 'false';
            $last_reply_id = intval( post( 'last_reply_id' ) );
            $replies = $this->Support_model->chat_replies( $id, $last_reply_id );
            $body = ['replies' => $replies];
            
            if ( ! empty( $replies ) ) $data['having_replies'] = 'true';
            
            $data['chat_body'] = read_view( 'admin/responses/chat_body', $body );
            
            r_admin_chat_replies( $data );
        }
    }
    
    /**
     * End Chat
     *
     * @return  void
     * @version 1.4
     */
    public function end_chat()
    {
        check_action_authorization( 'chats' );
        
        $id = intval( post( 'id' ) );
        
        $data = $this->Support_model->chat( $id );
        
        if ( empty( $data ) ) r_error( 'invalid_req' );
        
        if ( $this->Support_model->end_chat( $id ) )
        {
            r_s_jump( "admin/chats/chat/{$id}", 'chat_ended' );
        }
        
        r_error( 'invalid_req' );
    }
    
     /**
     * Delete Chat
     *
     * @return  void
     * @version 1.4
     */
    public function delete_chat()
    {
        check_action_authorization( 'chats' );
        
        $id = intval( post( 'id' ) );
        
        $chat = $this->Support_model->chat( $id );
        
        if ( empty( $chat ) ) r_error( 'invalid_req' );
        
        if ( $this->Support_model->delete_chat( $id ) )
        {
            $this->Support_model->delete_chat_replies( $id );
            
            r_success_remove( $id );
        }
        
        r_error( 'went_wrong' );
    }
    
    /**
     * Ticket Subject ( Read More ) Response.
     *
     * @return  void
     * @version 1.4
     */
    public function ticket_subject()
    {
        check_action_authorization( 'tickets' );
        
        $id = intval( post( 'id' ) );
        $data = $this->Support_model->ticket( $id );
        
        if ( ! empty( $data ) )
        {
            $data = [
                'detail' => $data->subject,
                'type' => lang( 'subject' ),
                'id' => $id
            ];
            
            display_view( 'admin/responses/read_more', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Summernote Image Upload
     *
     * @return  void
     * @version 1.3
     */
    public function sn_image_upload()
    {
        if ( ! empty( $_FILES['file']['name'] ) )
        {
            $this->load->library( 'ZFiles' );
            
            $file = $this->zfiles->upload_image_file( 'file', 'attachments' );
            
            echo attachments_uploads( $file );
        }
    }
    
    /**
     * Summernote Image Delete
     *
     * @return  void
     * @version 1.3
     */
    public function sn_image_delete()
    {
        $file = do_secure( post( 'file' ) );
        $file = str_replace( base_url(), '', $file );
        
        if ( file_exists( $file ) )
        {
            unlink( $file );
        }
    }
    
    /**
     * Add Canned Reply Input Handling.
     *
     * @return void
     */
    public function add_canned_reply()
    {
        check_action_authorization( 'canned_replies' );
        
        if ( $this->form_validation->run( 'canned_reply' ) )
        {
            $data = [
                'subject' => do_secure( post( 'subject' ) ),
                'message' => do_secure( post( 'message' ), true ),
                'created_at' => time()
            ];
            
            $id = $this->Support_model->add_canned_reply( $data );
            
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                
                $html = read_view( 'admin/responses/add_canned_reply', $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Canned Reply ( Read More ) Response.
     *
     * @return void
     */
    public function canned_reply()
    {
        check_action_authorization( 'canned_replies' );
        
        $id = intval( post( 'id' ) );
        $data = $this->Support_model->canned_reply( $id );
        
        if ( ! empty( $data ) )
        {
            $data = [
                'detail' => $data->message,
                'type' => lang( 'message' ),
                'id' => $id
            ];
            
            display_view( 'admin/responses/read_more', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Get Canned Reply
     *
     * @param  integer $data_id
     * @param  string  $type
     * @return void
     */
    public function get_canned_reply( $data_id = 0, $type = 'ticket' )
    {
        $this->load->model( 'User_model' );
        
        $data_id = intval( $data_id );
        $agent_id = $this->zuser->get( 'id' );
        $id = intval( post( 'reply_id' ) );
        
        if ( empty( $id ) ) d_r_success( '' );
        
        if ( $type === 'ticket' )
        {
            $data = $this->Support_model->ticket( $data_id );
        }
        else if ( $type === 'chat' )
        {
            $data = $this->Support_model->chat( $data_id );
        }
        else
        {
            r_error( 'invalid_req' );
        }
        
        $reply = $this->Support_model->canned_reply( $id );
        $agent = $this->User_model->get_by_id( $agent_id );
        
        if ( empty( $data ) || empty( $reply ) || empty( $agent ) )
        {
            r_error( 'invalid_req' );
        }
        
        $requester_name = $data->first_name . ' ' . $data->last_name;
        
        if ( $data->user_id == null )
        {
            $requester_name = lang( 'customer' );
        }
        
        $message = replace_placeholders( $reply->message, [
            '{REQUESTER_NAME}' => $requester_name,
            '{SUBJECT}' => strip_tags( trim( $data->subject ) ),
            '{AGENT_NAME}' => $agent->first_name . ' ' . $agent->last_name,
            '{SITE_NAME}' => db_config( 'site_name' )
        ]);
        
        d_r_success( $message );
    }
    
    /**
     * Edit Canned Reply ( Response ).
     *
     * @return void
     */
    public function edit_canned_reply()
    {
        check_action_authorization( 'canned_replies' );
        
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Support_model->canned_reply( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_canned_reply', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Canned Reply Input Handling.
     *
     * @return void
     */
    public function update_canned_reply()
    {
        check_action_authorization( 'canned_replies' );
        
        if ( $this->form_validation->run( 'canned_reply' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'subject' => do_secure( post( 'subject' ) ),
                'message' => do_secure( post( 'message' ), true )
            ];
            
            if ( $this->Support_model->update_canned_reply( $data, $id ) )
            {
                $data = $this->Support_model->canned_reply( $id );
                $html = read_view( 'admin/responses/update_canned_reply', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Canned Reply
     *
     * @return void
     */
    public function delete_canned_reply()
    {
        check_action_authorization( 'canned_replies' );
        
        $id = intval( post( 'id' ) );
        
        if ( $this->Support_model->delete_canned_reply( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Add FAQ Input Handling.
     *
     * @return void
     */
    public function add_faq()
    {
        check_action_authorization( 'faqs' );
        
        if ( $this->form_validation->run( 'faq' ) )
        {
            $data = [
                'question' => do_secure( post( 'question' ) ),
                'answer' => do_secure( post( 'answer' ), true ),
                'category_id' => intval( post( 'category' ) ),
                'visibility' => only_binary( post( 'visibility' ) ),
                'created_at' => time()
            ];
            
            $result = array_search( $data['category_id'], array_column( get_faqs_categories(), 'id' ) );
                
            if ( $result === false ) r_error( 'invalid_req' );
            
            $id = $this->Support_model->add_faq( $data );
            
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                
                $html = read_view( 'admin/responses/add_faq', $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * FAQ ( Read More ) Response.
     *
     * @param  string $type
     * @return void
     */
    public function faq( $type = '' )
    {
        check_action_authorization( 'faqs' );
        
        $id = intval( post( 'id' ) );
        $data = $this->Support_model->faq( $id );
        
        if ( ! in_array( $type, ['question', 'answer'] ) )
        {
            r_error( 'invalid_req' );
        }
        
        if ( ! empty( $data ) )
        {
            $data = [
                'detail' => $data->{$type},
                'type' => lang( $type ),
                'id' => $id
            ];
            
            display_view( 'admin/responses/read_more', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Edit FAQ ( Response ).
     *
     * @return void
     */
    public function edit_faq()
    {
        check_action_authorization( 'faqs' );
        
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Support_model->faq( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_faq', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update FAQ Input Handling.
     *
     * @return void
     */
    public function update_faq()
    {
        check_action_authorization( 'faqs' );
        
        if ( $this->form_validation->run( 'faq' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'question' => do_secure( post( 'question' ) ),
                'answer' => do_secure( post( 'answer' ), true ),
                'category_id' => intval( post( 'category' ) ),
                'visibility' => only_binary( post( 'visibility' ) ),
            ];
            
            $result = array_search( $data['category_id'], array_column( get_faqs_categories(), 'id' ) );
                
            if ( $result === false ) r_error( 'invalid_req' );
            
            if ( $this->Support_model->update_faq( $data, $id ) )
            {
                $data = $this->Support_model->faq( $id );
                $html = read_view( 'admin/responses/update_faq', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Canned Reply
     *
     * @return void
     */
    public function delete_faq()
    {
        check_action_authorization( 'faqs' );
        
        $id = intval( post( 'id' ) );
        
        if ( $this->Support_model->delete_faq( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Add FAQs Category Input Handling.
     *
     * @return void
     */
    public function add_faqs_category()
    {
        check_action_authorization( 'faqs' );
        
        if ( $this->form_validation->run( 'faqs_category' ) )
        {
            $data = [
                'name' => do_secure( post( 'category' ) ),
                'created_at' => time()
            ];
            
            $id = $this->Support_model->add_faqs_category( $data );
            
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                
                $html = read_view( 'admin/responses/add_faqs_category', $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( form_error( 'category' ) );
    }
    
    /**
     * Edit FAQs Category ( Response ).
     *
     * @return void
     */
    public function edit_faqs_category()
    {
        check_action_authorization( 'faqs' );
        
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Support_model->faqs_category( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_faqs_category', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update FAQs Category Input Handling.
     *
     * @return void
     */
    public function update_faqs_category()
    {
        check_action_authorization( 'faqs' );
        
        if ( $this->form_validation->run( 'faqs_category' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'name' => do_secure( post( 'category' ) )
            ];
            
            if ( $this->Support_model->update_faqs_category( $data, $id ) )
            {
                $data = $this->Support_model->faqs_category( $id );
                $html = read_view( 'admin/responses/update_faqs_category', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( form_error( 'category' ) );
    }
    
    /**
     * Delete FAQs Category.
     *
     * @return void
     */
    public function delete_faqs_category()
    {
        check_action_authorization( 'faqs' );
        
        $id = intval( post( 'id' ) );
        
        $has = $this->Support_model->has_faqs( $id );
        
        if ( $has ) r_error( 'delete_faqs' );
        
        if ( $this->Support_model->delete_faqs_category( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Add Articles Category Input Handling.
     *
     * @param  string $type
     * @return void
     */
    public function add_articles_category( $type = 'parent' )
    {
        check_action_authorization( 'knowledge_base' );
        
        if ( $type !== 'parent' && $type !== 'sub' )
        {
            r_error( 'invalid_req' );
        }
        
        if ( $this->form_validation->run( 'articles_category' ) )
        {
            $parent = false;
            
            $data = [
                'name' => do_secure( post( 'category' ) ),
                'slug' => do_secure( post( 'slug' ) ),
                'meta_description' => do_secure( post( 'meta_description' ) ),
                'meta_keywords' => do_secure( post( 'meta_keywords' ) ),
                'created_at' => time()
            ];
            
            if ( $type === 'sub' )
            {
                $parent = true;
                
                if ( ! post( 'parent_category' ) ) r_error( 'missing_parent_cat' );
                
                $data['parent_id'] = intval( post( 'parent_category' ) );
                
                $result = array_search( $data['parent_id'], array_column( get_articles_categories(), 'id' ) );
                
                if ( $result === false ) r_error( 'invalid_req' );
            }
            
            if ( empty( $data['slug'] ) )
            {
                $data['slug'] = $this->Support_model->articles_category_slug( $data['name'], 0, $parent );
            }
            
            if ( $this->Support_model->articles_category( $data['slug'], 'slug', $parent ) )
            {
                r_error( 'slug_exists' );
            }
            
            $id = $this->Support_model->add_articles_category( $data );
            
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                $view = ( $type === 'parent' ) ? 'category' : 'subcategory';
                $html = read_view( 'admin/responses/add_articles_' . $view, $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Edit Articles Category ( Response ).
     *
     * @param  string $type
     * @return void
     */
    public function edit_articles_category( $type = 'parent' )
    {
        check_action_authorization( 'knowledge_base' );
        
        if ( $type !== 'parent' && $type !== 'sub' ) r_error( 'invalid_req' );
        else if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Support_model->articles_category( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            $view = ( $type === 'parent' ) ? 'category' : 'subcategory';
            display_view( 'admin/responses/forms/edit_articles_' . $view, $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Articles Category Input Handling.
     *
     * @param  string $type
     * @return void
     */
    public function update_articles_category( $type = 'parent' )
    {
        check_action_authorization( 'knowledge_base' );
        
        if ( $type !== 'parent' && $type !== 'sub' )
        {
            r_error( 'invalid_req' );
        }
        
        if ( $this->form_validation->run( 'articles_category' ) )
        {
            $id = intval( post( 'id' ) );
            $category = $this->Support_model->articles_category( $id );
            $parent = false;
            
            $data = [
                'name' => do_secure( post( 'category' ) ),
                'slug' => do_secure( post( 'slug' ) ),
                'meta_description' => do_secure( post( 'meta_description' ) ),
                'meta_keywords' => do_secure( post( 'meta_keywords' ) )
            ];
            
            if ( $type === 'sub' )
            {
                $parent = true;
                
                if ( $category->parent_id == null ) r_error( 'invalid_req' );
                else if ( ! post( 'parent_category' ) ) r_error( 'missing_parent_cat' );
                
                $data['parent_id'] = intval( post( 'parent_category' ) );
                
                $result = array_search( $data['parent_id'], array_column( get_articles_categories(), 'id' ) );
                
                if ( $result === false ) r_error( 'invalid_req' );
            }
            else
            {
                if ( $category->parent_id != null ) r_error( 'invalid_req' );
            }
            
            if ( empty( $data['slug'] ) )
            {
                $data['slug'] = $this->Support_model->articles_category_slug(
                    $data['name'],
                    $id,
                    $parent
                );
            }
            
            if ( $this->Support_model->is_ac_slug_exists( $data['slug'], $id, $parent ) )
            {
                r_error( 'slug_exists' );
            }
            
            if ( $this->Support_model->update_articles_category( $data, $id ) )
            {
                $data = $this->Support_model->articles_category( $id );
                $view = ( $type === 'parent' ) ? 'category' : 'subcategory';
                $html = read_view( 'admin/responses/update_articles_' . $view, $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Articles Category.
     *
     * @return void
     */
    public function delete_articles_category()
    {
        check_action_authorization( 'knowledge_base' );
        
        $id = intval( post( 'id' ) );
        $data = $this->Support_model->articles_category( $id );
        
        if ( empty( $data ) ) r_error( 'invalid_req' );
        
        if ( $data->parent_id == null )
        {
            $has = $this->Support_model->has_articles_subcategories( $id );
            
            if ( $has ) r_error( 'delete_subcategories' );
        }
        
        $has = $this->Support_model->has_articles( $id );
        
        if ( $has ) r_error( 'delete_articles' );
        
        if ( $this->Support_model->delete_articles_category( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Add Article Input Handling.
     *
     * @return void
     */
    public function add_article()
    {
        check_action_authorization( 'knowledge_base' );
        
        if ( $this->form_validation->run( 'article' ) )
        {
            $data = [
                'title' => do_secure( post( 'title' ) ),
                'slug' => do_secure( post( 'slug' ) ),
                'content' => do_secure( post( 'content' ), true ),
                'meta_keywords' => do_secure( post( 'meta_keywords' ) ),
                'meta_description' => do_secure( post( 'meta_description' ) ),
                'visibility' => only_binary( post( 'visibility' ) ),
                'category_id' => intval( post( 'category' ) ),
                'created_at' => time()
            ];
            
            $result = array_search( $data['category_id'], array_column( get_articles_categories( 'all' ), 'id' ) );
                
            if ( $result === false ) r_error( 'invalid_req' );
            
            if ( empty( $data['slug'] ) )
            {
                $data['slug'] = $this->Support_model->article_slug( $data['title'] );
            }
            
            if ( $this->Support_model->article( $data['slug'], 'slug' ) )
            {
                r_error( 'slug_exists' );
            }
            
            $id = $this->Support_model->add_article( $data );
            
            if ( ! empty( $id ) )
            {
                r_s_jump( 'admin/knowledge_base/articles', 'added' );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Update Article Input Handling.
     *
     * @return void
     */
    public function update_article()
    {
        check_action_authorization( 'knowledge_base' );
        
        if ( $this->form_validation->run( 'article' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'title' => do_secure( post( 'title' ) ),
                'slug' => do_secure( post( 'slug' ) ),
                'content' => do_secure( post( 'content' ), true ),
                'meta_keywords' => do_secure( post( 'meta_keywords' ) ),
                'meta_description' => do_secure( post( 'meta_description' ) ),
                'visibility' => only_binary( post( 'visibility' ) ),
                'category_id' => intval( post( 'category' ) )
            ];
            
            $result = array_search( $data['category_id'], array_column( get_articles_categories( 'all' ), 'id' ) );
                
            if ( $result === false ) r_error( 'invalid_req' );
            
            if ( empty( $data['slug'] ) )
            {
                $data['slug'] = $this->Support_model->article_slug( $data['title'] );
            }
            
            if ( $this->Support_model->is_article_exists_by( $data['slug'], $id ) )
            {
                r_error( 'slug_exists' );
            }
            
            if ( $this->Support_model->update_article( $data, $id ) )
            {
                r_s_jump( "admin/knowledge_base/edit_article/{$id}", 'updated' );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Delete Article
     *
     * @return void
     */
    public function delete_article()
    {
        check_action_authorization( 'knowledge_base' );
        
        $id = intval( post( 'id' ) );
        
        if ( $this->Support_model->delete_article( $id ) )
        {
            $this->Support_model->delete_article_votes( $id );
            
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Get Team Users Data ( For Department ).
     *
     * @return string
     */
    private function get_team_users()
    {
        if ( post( 'users' ) == 1 )
        {
            $ids = [];
            
            if ( empty( post( 'team' ) ) )
            {
                r_error( 'missing_team_users' );
            }
            else if ( ! is_array( post( 'team' ) ) )
            {
                r_error( 'invalid_req' );
            }
            
            foreach ( post( 'team' ) as $user_id )
            {
                $users = get_team_users( 'result_array' );
                $result = array_search( $user_id, array_column( $users, 'id' ) );
                
                if ( $result === false )
                {
                    r_error( 'invalid_req' );
                }
                
                $ids['users'][] = intval( $user_id );
            }
            
            $data = json_encode( $ids );
        }
        else
        {
            $data = 'all_users';
        }
        
        return $data;
    }
    
    /**
     * Add Department Input Handling.
     *
     * @return void
     */
    public function add_department()
    {
        check_action_authorization( 'departments' );
        
        if ( $this->form_validation->run( 'tickets_department' ) )
        {
            $data = [
                'name' => do_secure( post( 'department' ) ),
                'team' => $this->get_team_users(),
                'visibility' => only_binary( post( 'visibility' ) ),
                'created_at' => time()
            ];
            
            $id = $this->Support_model->add_department( $data );
            
            if ( ! empty( $id ) )
            {
                $data['id'] = $id;
                
                $html = read_view( 'admin/responses/add_tickets_department', $data );
                
                r_success_add( $html );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( form_error( 'department' ) );
    }
    
    /**
     * Edit Department ( Response ).
     *
     * @return void
     */
    public function edit_department()
    {
        check_action_authorization( 'departments' );
        
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Support_model->department( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_tickets_department', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Dpartment Input Handling.
     *
     * @return void
     */
    public function update_department()
    {
        check_action_authorization( 'departments' );
        
        if ( $this->form_validation->run( 'tickets_department' ) )
        {
            $id = intval( post( 'id' ) );
            
            $data = [
                'name' => do_secure( post( 'department' ) ),
                'visibility' => only_binary( post( 'visibility' ) ),
                'team' => $this->get_team_users()
            ];
            
            if ( $this->Support_model->update_department( $data, $id ) )
            {
                $data = $this->Support_model->department( $id );
                $html = read_view( 'admin/responses/update_tickets_department', $data );
                
                r_success_replace( $id, $html );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( form_error( 'department' ) );
    }
    
    /**
     * Delete Department.
     *
     * @return void
     */
    public function delete_department()
    {
        check_action_authorization( 'departments' );
        
        $id = intval( post( 'id' ) );
        
        $has = $this->Support_model->has_department_tickets( $id );
        
        if ( $has ) r_error( 'delete_dep_tickets' );
        
        if ( $this->Support_model->delete_department( $id ) )
        {
            r_success_remove( $id );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Assign Ticket to the User Input Handling.
     *
     * @param  string $type
     * @return void
     */
    public function assign_user( $type = 'ticket' )
    {
        $permission = ( $type === 'ticket' ) ? 'tickets' : 'chats';
        
        check_action_authorization( $permission );
        
        $this->load->model( 'User_model' );
        
        $data_id = intval( post( 'id' ) );
        $user_id = intval( post( 'user' ) );
        
        if ( $type === 'ticket' )
        {
            $togo = "admin/tickets/ticket/{$data_id}";
            $data = $this->Support_model->ticket( $data_id );
            $final_key = 'assigned_user';
        }
        else if ( $type == 'chat' )
        {
            $togo = "admin/chats/chat/{$data_id}";
            $data = $this->Support_model->chat( $data_id );
            $final_key = 'assigned_user_c';
        }
        
        if ( empty( $data ) ) r_error( 'invalid_req' );
        
        if ( $data->assigned_to != null && $user_id == 0 )
        {
            $user_id = null;
        }
        else
        {
            $users = get_team_users( 'result_array' );
            $result = array_search( $user_id, array_column( $users, 'id' ) );
            
            $user = $this->User_model->get_by_id( $user_id );
            
            if ( empty( $user ) || $result === false ) r_error( 'invalid_req' );
        }
        
        if ( $data->status == 0 )
        {
            $term = ( $type === 'ticket' ) ? 'closed' : 'ended';
            
            r_error( "cant_assign_{$term}" );
        }
        
        if ( $user_id == $data->user_id && $data->user_id != null )
        {
            $cant_assign_key = ( $type === 'chat' ) ? 'cant_self_assign_chat' : 'cant_self_assign';
            
            r_error( $cant_assign_key );
        }
        
        if ( $this->Support_model->assign_user( $data_id, $user_id, $type . 's' ) )
        {
            if ( $user_id !== null )
            {
                if ( $type === 'ticket' )
                {
                    log_ticket_activity( 'ticket_assigned', $data_id, $user_id );
                }
                
                send_notification( "{$type}_assigned", $togo, $user_id, 1 );

                if ( is_email_settings_filled() && is_notifications_enabled( $user_id ) )
                {
                    $email_address = $user->email_address;
                    $language = get_user_closer_language( $user->language );
                    $hook = "{$type}_assigned";
                    $template = $this->Tool_model->email_template_by_hook_and_lang( $hook, $language );

                    if ( empty( $template ) ) r_error( 'assigned_no_template' );
                    
                    $subject = $template->subject;
                    
                    $message = replace_placeholders( $template->template, [
                        '{USER_NAME}' => $user->first_name . ' ' . $user->last_name,
                        '{' . strtoupper( $type ) .'_URL}' => env_url( $togo ),
                        '{SITE_NAME}' => db_config( 'site_name' )
                    ]);
                    
                    $this->load->library( 'ZMailer' );

                    $this->zmailer->send_email( $email_address, $subject, $message );
                }
            }
            else
            {
                $final_key = 'unassigned';
                
                if ( $type === 'ticket' )
                {
                    log_ticket_activity( 'ticket_unassigned', $data_id );
                }
            }
            
            if ( $user_id == $this->zuser->get( 'id' ) )
            {
                $togo .= '?read=false';
            }
            
            r_s_jump( $togo, $final_key );
        }
        
         r_error( 'not_updated_user' );
    }
    
    /**
     * Add Reply Input Handling.
     *
     * @return void
     */
    public function add_reply()
    {
        check_action_authorization( 'tickets' );
        
        $ticket_id = intval( post( 'id' ) );
        
        $ticket = $this->Support_model->ticket( $ticket_id );
        $my_id = $this->zuser->get( 'id' );
        
        if ( empty( $ticket ) ) r_error( 'invalid_req' );
        
        if ( $ticket->status == 0 ) r_error( 'ticket_closed' );
        
        if ( post( 'solved' ) && ! post( 'reply' ) )
        {
            if ( $ticket->sub_status != 3 )
            {
                $is_read = ( $ticket->last_reply_area == 2 ) ? 1 : 0;
                
                $to_update = ['sub_status' => 3, 'is_read' => $is_read, 'last_reply_area' => 1];
                
                if ( post( 'assign_to_me' ) )
                {
                    if ( $ticket->user_id == $my_id )
                    {
                        r_error( 'cant_self_assign' );
                    }
                    
                    $to_update['assigned_to'] = $my_id;
                }
            
                $this->Support_model->update_ticket( $to_update, $ticket_id );
                
                log_ticket_activity( 'ticket_solved_admin', $ticket_id );
                
                r_s_jump( "admin/tickets/ticket/{$ticket_id}", 'ticket_solved' );
            }
            
            r_error( 'invalid_req' );
        }
        
        if ( $this->form_validation->run( 'add_reply' ) )
        {
            $data = [
                'ticket_id' => $ticket_id,
                'user_id' => $my_id,
                'message' => do_secure( post( 'reply' ), true ),
                'replied_at' => time()
            ];
            
            if ( ! empty( $_FILES['attachment']['tmp_name'] ) )
            {
                $this->load->library( 'ZFiles' );
                
                $file = $this->zfiles->upload_attachment();
                
                $data['attachment_name'] = do_secure( $file['client_name'] );
                $data['attachment'] = $file['file_name'];
            }
            
            $sub_status = ( post( 'solved' ) == 1 ) ? 3 : 2;
            
            $to_update = [
                'sub_status' => $sub_status,
                'last_agent_replied_at' => time(),
                'last_reply_area' => 1,
                'reopened_awaiting' => 0,
                'is_read' => 0
            ];
            
            if ( post( 'assign_to_me' ) )
            {
                if ( $ticket->user_id == $my_id )
                {
                    r_error( 'cant_self_assign' );
                }
                
                $to_update['assigned_to'] = $my_id;
            }
            
            $id = $this->Support_model->add_reply( $data );
            
            if ( ! empty( $id ) )
            {
                log_ticket_activity( 'ticket_replied_agent', $ticket_id );
                
                if ( $ticket->user_id == null )
                {
                    send_guest_reply_notification( $ticket_id, $id );
                }
                else
                {
                    if ( ! send_reply_notification( $ticket->user_id, $ticket_id, $id ) )
                    {
                        r_error( 'ticket_fe' );
                    }
                }
                
                $this->Support_model->update_ticket( $to_update, $ticket_id );
                
                r_s_jump( "admin/tickets/ticket/{$ticket_id}", 'ticket_replied' );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( form_error( 'reply' ) );
    }
    
    /**
     * Edit Ticket Reply ( Response ).
     *
     * @return  void
     * @version 1.1
     */
    public function edit_ticket_reply()
    {
        check_action_authorization( 'tickets' );
        
        if ( ! post( 'id' ) ) r_error( 'invalid_req' );
        
        $data = $this->Support_model->ticket_reply( intval( post( 'id' ) ) );
        
        if ( ! empty( $data ) )
        {
            display_view( 'admin/responses/forms/edit_ticket_reply', $data );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Update Ticket Reply Input Handling.
     *
     * @param   integer $ticket_id
     * @return  void
     * @version 1.1
     */
    public function update_ticket_reply( $ticket_id = 0 )
    {
        check_action_authorization( 'tickets' );
        
        if ( $this->form_validation->run( 'update_ticket_reply' ) )
        {
            $id = intval( post( 'id' ) );
            
            $result = $this->Support_model->ticket_reply( $id );
            
            if ( empty( $result ) ) r_error( 'invalid_req' );
            
            $data = ['message' => do_secure( post( 'message' ), true )];
            
            if ( ! empty( $_FILES['attachment']['tmp_name'] ) )
            {
                $this->load->library( 'ZFiles' );
                
                if ( ! empty( $result->attachment ) )
                {
                    $this->zfiles->delete_image_file( 'attachments', $result->attachment );
                }
                
                $file = $this->zfiles->upload_attachment();
                
                $data['attachment_name'] = do_secure( $file['client_name'] );
                $data['attachment'] = $file['file_name'];
            }
            
            $ticket_id = $result->ticket_id;
            $my_id = $this->zuser->get( 'id' );
            
            if ( $this->Support_model->update_reply( $data, $id ) )
            {
                log_ticket_activity( 'ticket_reply_updated', $ticket_id, $my_id );
                r_s_jump( "admin/tickets/ticket/{$ticket_id}", 'updated' );
            }
            
            r_error( 'not_updated' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Create Ticket Input Handling.
     *
     * @return  void
     * @version 1.1
     */
    public function create_ticket()
    {
        check_action_authorization( 'all_tickets' );
        
        $type = do_secure_l( post( 'type' ) );
        
        if ( ! in_array( $type, ['unregistered_users', 'registered_users'] ) )
        {
            r_error( 'invalid_req' );
        }
        
        $key = 'create_ticket_admin';
        
        if ( $type == 'unregistered_users' )
        {
            $key = 'create_ticket_admin_unregistered_users';
        }
        
        if ( $this->form_validation->run( $key ) )
        {
            $this->load->model( 'User_model' );
            
            $data = [
                'subject' => do_secure( post( 'subject' ) ),
                'message' => do_secure( post( 'message' ), true ),
                'priority' => do_secure_l( post( 'priority' ) ),
                'department_id' => intval( post( 'department' ) ),
                'created_month_year' => date( 'n-Y' ),
                'created_at' => time()
            ];
            
            if ( $type === 'unregistered_users' )
            {
                $data['email_address'] = do_secure_l( post( 'email_address' ) );
                $data['security_key'] = get_short_random_string();
                $data['is_verified'] = 1;
            }
            else
            {
                $data['user_id'] = intval( post( 'customer' ) );
                
                $user = $this->User_model->get_by_id( $data['user_id'] );
                
                if ( empty( $user ) ) r_error( 'invalid_req' );
            }
            
            $department = $this->Support_model->department( $data['department_id'] );
            
            if ( empty( $department ) )
            {
                r_error( 'invalid_department' );
            }
            
            if ( ! in_array( $data['priority'], ['low', 'medium', 'high'] ) )
            {
                r_error( 'invalid_priority' );
            }
            
            $mcfi = manage_custom_field_input( null, true );
            
            if ( $mcfi !== true ) r_error( $mcfi );
            
            if ( ! empty( $_FILES['attachment']['tmp_name'] ) )
            {
                $this->load->library( 'ZFiles' );
                
                $file = $this->zfiles->upload_attachment();
                
                $data['attachment_name'] = do_secure( $file['client_name'] );
                $data['attachment'] = $file['file_name'];
            }
            
            $id = $this->Support_model->add_ticket( $data );
            
            if ( ! empty( $id ) )
            {
                log_ticket_activity( 'ticket_created_admin', $id );
                
                manage_custom_field_input( $id );
                
                if ( $type === 'unregistered_users' )
                {
                    $slug = 'ticket/guest/' . $data['security_key'] . "/{$id}";
                    
                    send_guest_ticket_notification( $data['email_address'], $slug );
                }
                
                inform_department_users( $department, $id );
                
                r_s_jump( "admin/tickets/ticket/{$id}", 'ticket_created' );
            }
            
            r_error( 'went_wrong' );
        }
        
        d_r_error( validation_errors() );
    }
    
    /**
     * Re-open Ticket
     *
     * @return void
     */
    public function reopen_ticket()
    {
        check_action_authorization( 'tickets' );
        
        $id = intval( post( 'id' ) );
        
        $data = $this->Support_model->ticket( $id );
        
        if ( empty( $data ) ) r_error( 'invalid_req' );
        
        if ( $this->Support_model->reopen_ticket( $id ) )
        {
            log_ticket_activity( 'ticket_reopened_agent', $id );
            r_s_jump( "admin/tickets/ticket/{$id}", 'ticket_reopened' );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Close Ticket
     *
     * @return void
     */
    public function close_ticket()
    {
        check_action_authorization( 'tickets' );
        
        $id = intval( post( 'id' ) );
        
        $data = $this->Support_model->ticket( $id );
        
        if ( empty( $data ) ) r_error( 'invalid_req' );
        
        if ( $this->Support_model->close_ticket( $id ) )
        {
            log_ticket_activity( 'ticket_closed_agent', $id );
            r_s_jump( "admin/tickets/ticket/{$id}", 'ticket_closed' );
        }
        
        r_error( 'invalid_req' );
    }
    
    /**
     * Delete Ticket Reply
     *
     * @return void
     */
    public function delete_reply()
    {
        check_action_authorization( 'tickets' );
        
        $id = intval( post( 'id' ) );
        
        $reply = $this->Support_model->ticket_reply( $id );
        
        if ( empty( $reply ) ) r_error( 'invalid_req' );
        
        $attachment = $reply->attachment;
        
        if ( $this->Support_model->delete_ticket_reply( $id ) )
        {
            log_ticket_activity( 'ticket_reply_deleted', $reply->ticket_id );
            
            if ( ! empty( $attachment ) )
            {
                $this->load->library( 'ZFiles' );
                
                $this->zfiles->delete_image_file( 'attachments', $attachment );
            }
            
            r_s_jump( "admin/tickets/ticket/{$reply->ticket_id}", 'tr_deleted' );
        }
        
        r_error( 'went_wrong' );
    }
    
    /**
     * Delete Ticket
     *
     * @return void
     */
    public function delete_ticket()
    {
        check_action_authorization( 'tickets' );
        
        $id = intval( post( 'id' ) );
        
        $ticket = $this->Support_model->ticket( $id );
        
        if ( empty( $ticket ) ) r_error( 'invalid_req' );
        
        $attachment = $ticket->attachment;
        
        if ( $this->Support_model->delete_ticket( $id ) )
        {
            $this->load->model( 'Custom_field_model' );
            
            $this->Support_model->delete_ticket_history( $id );
            $this->load->library( 'ZFiles' );
            
            $replies = $this->Support_model->tickets_replies( $id );
            
            if ( ! empty( $replies ) )
            {
                // Delete the ticket replies attachment(s) ( if attached ):
                foreach ( $replies as $reply )
                {
                    if ( ! empty( $reply->attachment ) )
                    {
                        $this->zfiles->delete_image_file(
                            'attachments',
                            $reply->attachment
                        );
                    }
                }
            }
            
            // Delete the main attachment of the ticket ( if attached ):
            if ( ! empty( $attachment ) )
            {
                $this->zfiles->delete_image_file(
                    'attachments',
                    $attachment
                );
            }
            
            $this->Custom_field_model->delete_ticket_custom_fields( $id );
            
            $this->Support_model->delete_ticket_replies( $id );
            r_success_remove( $id );
        }
        
        r_error( 'went_wrong' );
    }
}
