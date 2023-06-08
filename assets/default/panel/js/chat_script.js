/**
 * Script ( Public Area )
 *
 * @author  Shahzaib
 * @version 1.4
 */

"use strict";

$( function ()
{
  // Check for the active chat, if exists, then send the ajax
  // request(s) to the server for the real time experience:
  setInterval( function ()
  {
    var source = $( '#chat-messages' ).attr( 'data-chat-action' );
    var lastReplyId = $( '.chat-message:last' ).attr( 'data-reply-id' );
    var chatStatus = $( '#chat-messages' ).attr( 'data-chat-status' );
    
    lastReplyId = ( typeof lastReplyId !== 'undefined' ) ? lastReplyId : 0;
    
    if ( chatStatus != 0 )
    {
      $.ajax(
      {
        url: source,
        data: { last_reply_id: lastReplyId, z_csrf: csrfToken },
        method: 'POST',
        success: function( response )
        {
          response = jsonResponse( response );
          
          if ( response.status === 'admin_chat_replies' )
          {
            if ( response.value.having_replies === 'true' )
            {
              $( '#chat-box-body' ).append( response.value.chat_body );
              
              chatScrollDown( '#chat-box-body' );
            }
          }
        }
      });
    }
  }, 3000 );
  
  
  // Submit the form to store a chat reply when the
  // user hit the enter key:
  $( document ).on( 'keypress', '#your-reply', function ( event )
  {
    if ( event.which === 13 && ! event.shiftKey )
    {
      event.preventDefault();
      
      if ( $( this ).val() !== '' )
      {
        $( this ).closest( 'form' ).submit();
      }
    }
  });
});