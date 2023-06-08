/**
 * Script ( User )
 *
 * @author Shahzaib
 */

"use strict";

$( function ()
{
  // Alert box management for the guest ticketing option:
  // @version 1.6
  $( '#guest-ticketing' ).on( 'change', function ()
  {
    if ( this.value === '1' )
    {
      $( '#guest-ticketing-alert' ).addClass( 'd-block' );
      $( '#guest-ticketing-alert' ).removeClass( 'd-none' );
    }
    else
    {
      $( '#guest-ticketing-alert' ).addClass( 'd-none' );
      $( '#guest-ticketing-alert' ).removeClass( 'd-block' );
    }
  });
  
  
  // On the page load, move the scroll down of that box
  // where the chat messages are displayed:
  // @version 1.4
  chatScrollDown( '#chat-box-body' );
  
  
  if ( $( window ).width() < 768 )
  {
    $( 'body' ).removeClass( 'layout-fixed layout-navbar-fixed' );
  }
  
  
  // Manage modal ( get data ) by sending the ajax request:
  $( '.z-table, .z-card' ).on( 'click', function ( event )
  {
    var $element = $( event.target );
    var isFine   = true;
    var source   = '';
    
    /**
     * The element you want to use to send a request to read some data from the server,
     * must have a class "get-data-tool".
     *
     * If the requesting element is the child of "get-data-tool" class, add the
     * "get-data-tool-c" class also to the child element.
     *
     * The element that is having "get-data-tool" class, must have these attributes:
     * "data-id" Record ID
     *
     * "data-reference" Area/Controller name e.g. admin/tools
     * "data-requirement" Data requirement
     *
     * OR
     *
     * "data-source" Full URL
     */
    
    if ( $element.hasClass( 'get-data-tool-c' ) )
    {
      $element = $element.parent( '.get-data-tool' );
    }
    else
    {
      if ( ! $element.hasClass( 'get-data-tool' ) )
      {
        isFine = false;
      }
    }
    
    if ( isFine === true )
    {
      var dataSource = $element.attr( 'data-source' );
      var dataID     = $element.attr( 'data-id' );
      
      
      if ( ! dataSource )
      {
        var dataReference   = $element.attr( 'data-reference' );
        var dataRequirement = $element.attr( 'data-requirement' );        
        
        /**
         * The request receiver controller must be inside the "actions/" directory.
         * The receiver controller must have a method called "read()".
         *
         * @global string baseURL ( with slash at the end )
         */
        source  = baseURL + 'actions/' + dataReference + '/read/';
        source += dataRequirement;
      }
      else
      {
        source = $element.attr( 'data-source' );
      }
      
      if ( source !== '' )
      {
        getRecord( dataID, source, $element );
      }
      else
      {
        console.log( 'Invalid Source' );
      }
    }
  });
  
  
  // Tooltip:
  $( '[data-toggle="tooltip"]' ).tooltip();
  
  
  // Popover:
  $( '[data-toggle="popover"]' ).popover(
  {
    trigger: 'focus'
  });
  
  
  /**
   * jQuery Upload Preview
   *
   * @global string changeFile
   */
  var jupJson = {
    input_field: "#image-upload",
    preview_box: "#image-preview",
    label_field: "#image-label"
  };
  
  if ( typeof changeFile !== 'undefined' )
  {
    jupJson.label_selected = changeFile;
  }
  
  if ( typeof chooseFile !== 'undefined' )
  {
    jupJson.label_default = chooseFile;
  }
  
  $.uploadPreview( jupJson );
  
  
  // Prevent Checkbox to Mark as Checked:
  $( '.prevent-cb' ).on( 'click', function( event )
  {
    if ( ! $( this ).is( ':checked' ) )
    {
      event.preventDefault();
    }
  });
  
  
  /**
   * Fields management for the email settings page.
   *
   * @global string eProtocol
   */
  if ( typeof eProtocol !== 'undefined' )
  {
    if ( eProtocol === 'smtp' )
    {
      $( '.smtp-field' ).css( 'display', 'block' );
    }
  }
  
  $( '#protocol' ).on( 'change', function ()
  {
    if ( this.value === 'smtp' )
    {
      $( '.smtp-field' ).css( 'display', 'block' );
    }
    else
    {
      $( '.smtp-field' ).css( 'display', 'none' );
    }
  });
  
  
  // Fields management for the departement modals:
  $( document ).on( 'change', 'select.d-users-selection', function ()
  {
    if ( this.value == 1 )
    {
      $( '.select-users-wrapper' ).css( 'display', 'block' );
    }
    else
    {
      $( '.select-users-wrapper' ).css( 'display', 'none' );
    }
  });
  
  
  // Get canned replies based on user selection:
  $( document ).on( 'change', 'select#canned-reply', function ()
  {
    $.ajax(
    {
      url: $( this ).attr( 'data-action' ),
      data: {z_csrf: csrfToken, reply_id: this.value},
      method: 'POST',
      success: function ( response )
      {
        response = jsonResponse( response );
        
        if ( response.status !== 'true' )
        {
          if ( response.status === 'jump' )
          {
            window.location = response.value;
            return false;
          }
          
          showResponseMessage( $( '.add-reply-admin' ), response.value, 0 );
        }
        else
        {
          var yourReplyArea = $( 'textarea#your-reply' );
          
          yourReplyArea.val( yourReplyArea.val() + response.value );
        }
      }
    });
  });
  
  
  // Manage the state (e.g. collapsed) of sidebar menu:
  if ( $.isFunction( $.cookie ) )
  {
    $( '.sidebar-toggle' ).on( 'click', function ()
    {
      var collapsed = 1;
      
      if ( $.cookie( sidebarCookie ) == 1 ) collapsed = 0;
      
      $.cookie( sidebarCookie, collapsed, { expires: 365, path: '/' } );
    });
  }
  
  
  // Take backup form behaviour management:
  $( '#backup-action' ).on( 'change', function ()
  {
    if ( this.value == 1 )
    {
      $( '#take-backup-form' ).removeClass( 'form' );
    }
    else
    {
      $( '#take-backup-form' ).addClass( 'form' );
    }
  });
  
  
  // Summernote:
  if ( $.isFunction( $.fn.summernote ) )
  {
    $( '.textarea' ).summernote(
    {
      height: 245,
      dialogsInBody: true,
      callbacks: {
        // https://github.com/summernote/summernote/issues/303
        onPaste: function ( event )
        {
          const bufferText = ( ( event.originalEvent || event ).clipboardData || window.clipboardData ).getData( 'Text' );

          event.preventDefault();

          setTimeout( function ()
          {
            document.execCommand( 'insertText', false, bufferText );
          }, 10 );
        },
        onImageUpload: function ( image )
        {
          sendFile( image[0], this );
        },
        onMediaDelete: function ( image )
        {
          deleteFile( image[0].src );
        }
      },
      toolbar: [
        [
          'style',
          [
            'style'
          ]
        ],
        [
          'font',
          [
            'bold',
            'underline'
          ]
        ],
        [
          'fontsize',
          [
            'fontsize'
          ]
        ],
        [
          'para',
          [
            'paragraph',
            'ul',
            'ol'
          ]
        ],
        [
          'table',
          [
            'table'
          ]
        ],
        ['insert',
          [
            'link',
            'picture',
            'video'
          ]
        ],
        [
          'view', 
          [
            'codeview',
            'fullscreen'
          ]
        ]
      ]
    });
  }
});
