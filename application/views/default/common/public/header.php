<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );
$new_notifications = $this->Notification_model->check_for_new_notifications( true );
$new_announcements = $this->Tool_model->check_for_new_announcements();
?>
<!DOCTYPE html>
<html lang="<?php echo lang( 'lang_iso_code' ); ?>">

<head>

<!-- Meta: -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php if ( ! empty( $page_meta_description ) ) { ?>
  <meta name="description" content="<?php echo html_escape( $page_meta_description ); ?>">
  <meta property="og:description" content="<?php echo html_escape( $page_meta_description ); ?>">
<?php } else { ?>
  <meta name="description" content="<?php echo html_escape( db_config( 'site_description' ) ); ?>">
<?php } ?>


<?php if ( ! empty( $page_meta_keywords ) ) { ?>
  <meta name="keywords" content="<?php echo html_escape( $page_meta_keywords ); ?>">
<?php } else { ?>
  <meta name="keywords" content="<?php echo html_escape( db_config( 'site_keywords' ) ); ?>">
<?php } ?>

<meta property="og:url" content="<?php echo current_url(); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">


<?php
if ( empty( $page_title ) )
{
    $page_title = db_config( 'site_name' ) . ' - ' . db_config( 'site_tagline' ); 
}
else
{
    $page_title = manage_title( $page_title );
}
?>

<title><?php echo html_escape( $page_title ); ?></title>
<meta property="og:title" content="<?php echo html_escape( $page_title ); ?>">

<?php if ( ! empty( db_config( 'site_logo' ) ) ) { ?>
  <meta property="og:image" content="<?php echo general_uploads( html_escape( db_config( 'site_logo' ) ) ); ?>">
<?php } ?>

<!-- Favicon: -->
<link rel="icon" href="<?php echo general_uploads( html_escape( db_config( 'site_favicon' ) ) ); ?>">

<!-- Google Fonts: -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@700&family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,700&display=swap" rel="stylesheet">

<!-- Font Awesome CSS: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/fontawesome-free/css/all.min.css' ); ?>">

<!-- Pace CSS: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/pace/pace.css' ); ?>">

<!-- Bootstrap CSS: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/bootstrap/css/bootstrap.min.css' ); ?>">

<!-- Select 2: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/select2/css/select2.min.css' ); ?>">

<!-- Stylesheets: -->
<link rel="stylesheet" href="<?php assets_path( 'vendor/loading_io/icon.css' ); ?>">
<link rel="stylesheet" href="<?php assets_path( 'css/public/style.css?v=' . v_combine() ); ?>">
<link rel="stylesheet" href="<?php assets_path( 'css/public/color_' . html_escape( db_config( 'site_color' ) ) . '.css?v=' . v_combine() ); ?>">

<!-- jQuery: -->
<script src="<?php assets_path( 'vendor/jquery/jquery.min.js' ); ?>"></script>

<!-- Dynamic Variables: -->
<script>
  const csrfToken = '<?php echo $this->security->get_csrf_hash(); ?>';
  const googleAnalyticsID = '<?php echo html_escape( db_config( "google_analytics_id" ) ); ?>';
  const baseURL = '<?php echo base_url(); ?>';
  const chatCookie = '<?php echo CHAT_COOKIE; ?>';
  const liveChattingStatus = '<?php echo db_config( "sp_live_chatting" ); ?>';
  var proceedChat = '<?php echo intval( $this->zuser->is_logged_in ); ?>';
  
  const errors = {
    'wentWrong': "<?php echo err_lang( 'went_wrong' ); ?>",
    401: "<?php echo err_lang( '401' ); ?>",
    403: "<?php echo err_lang( '403' ); ?>",
    404: "<?php echo err_lang( '404' ); ?>",
    500: "<?php echo err_lang( '500' ); ?>",
    502: "<?php echo err_lang( '502' ); ?>",
    503: "<?php echo err_lang( '503' ); ?>"
  };
  
  <?php if ( get( 'to_move_box' ) ) { ?>
    const moveToBoxId = '<?php echo get( "to_move_box" ); ?>';
    const subtractBoxMove = 85;
  <?php } ?>
</script>
  
</head>

<body>

<!-- Navbar: -->
<nav class="navbar navbar-expand-lg navbar-light navbar-z brand-logo shadow fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand pb-0" href="<?php echo base_url(); ?>">
      <?php if ( ! empty( db_config( 'site_logo' ) ) ) { ?>
        <img class="logo" src="<?php echo general_uploads( html_escape( db_config( 'site_logo' ) ) ); ?>" alt="<?php echo html_escape( db_config( 'site_name' ) ); ?>">
      <?php } else { ?>
        <h3 class="p-0 mb-0"><?php echo html_escape( db_config( 'site_name' ) ); ?></h3>
      <?php } ?>
    </a>
    <div class="d-flex">
      <?php if ( $this->zuser->is_logged_in ) { ?>
        <a class="text-muted me-4 d-lg-none" href="<?php echo env_url( 'user/notifications' ); ?>">
          <?php if ( user_panel_activate_child_page( 'notifications' ) ) { ?>
            <i class="fas fa-bell notifications-bell text-sub"></i>
          <?php } else { ?>
            <i class="far fa-bell notifications-bell"></i>
          <?php } ?>
          
          <?php if ( $new_notifications ) { ?>
            <span class="badge bg-danger notifications-count"><?php echo html_escape( $new_notifications ); ?></span>
          <?php } ?>
        </a>
      <?php } ?>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle Navigation">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav mx-auto mb-0 mt-2 mt-lg-0">
        <!--<li class="nav-item">-->
        <!--  <a class="nav-link <?php echo ( empty( $this->uri->segment( 1 ) ) ) ? 'active' : ''; ?>" href="<?php echo base_url(); ?>"><?php echo lang( 'home' ); ?></a>-->
        <!--</li>-->
        
        <!--<?php if ( ! $this->zuser->is_logged_in ) { ?>-->
        <!--  <li class="nav-item">-->
          
        <!--    <?php if ( db_config( 'sp_guest_ticketing' ) == 1 ) { ?>-->
        <!--      <a class="nav-link <?php echo activate_page( 'create_ticket' ); ?>" href="<?php echo env_url( 'create_ticket' ); ?>"><?php echo lang( 'submit_ticket' ); ?></a>-->
        <!--    <?php } else { ?>-->
        <!--      <a class="nav-link <?php echo activate_page( 'login' ); ?>" href="<?php echo env_url( 'user/support/create_ticket' ); ?>"><?php echo lang( 'submit_ticket' ); ?></a>-->
        <!--    <?php } ?>-->
            
        <!--  </li>-->
        <!--<?php } ?>-->
        
        <!--<li class="nav-item">-->
        <!--  <a class="nav-link <?php echo activate_page( 'faqs' ); ?>" href="<?php echo env_url( 'faqs' ); ?>"><?php echo lang( 'faqs' ); ?></a>-->
        <!--</li>-->
        
        <!--<?php if ( $this->zuser->is_logged_in ) { ?>-->
        <!--  <li class="nav-item">-->
        <!--    <a class="nav-link <?php echo user_panel_activate_sub_child_page( ['announcements', 'announcement'] ); ?>" href="<?php echo env_url( 'user/tools/announcements' ); ?>">-->
        <!--      <?php echo lang( 'announcements' ); ?>-->
              
        <!--      <?php if ( $new_announcements ) { ?>-->
        <!--        <span class="z-dot bg-danger"></span>-->
        <!--      <?php } ?>-->
        <!--    </a>-->
        <!--  </li>-->
          
        <!--  <?php if ( get_session( 'impersonating' ) ) { ?>-->
        <!--    <li class="nav-item">-->
        <!--      <a class="nav-link text-danger" href="<?php admin_action( 'users/deimpersonate' ); ?>"><?php echo lang( 'stop_impersonating' ); ?></a>-->
        <!--    </li>-->
        <!--  <?php } ?>-->
          
        <!--<?php } ?>-->
      </ul>
      <ul class="navbar-nav d-block d-lg-flex auth-btns">
        <?php if ( ! $this->zuser->is_logged_in ) {
          $h_login_btn_class = ( db_config( 'u_enable_registration' ) == 0 ) ? 'btn btn-z btn-wide text-white' : 'nav-link';
          ?>
          <li class="nav-item d-none d-lg-block">
            <a class="<?php echo $h_login_btn_class; ?>" href="<?php echo env_url( 'login' ); ?>"><?php echo lang( 'login' ); ?></a>
          </li>
          
          <li class="nav-item d-inline-block d-lg-none btn-login">
            <a class="btn btn-sub ms-lg-3 btn-wide" href="<?php echo env_url( 'login' ); ?>"><?php echo lang( 'login' ); ?></a>
          </li>
          
          <?php if ( db_config( 'u_enable_registration' ) == 1 ) { ?>
            <li class="btn-register">
              <a class="btn btn-z ms-lg-3 btn-wide" href="<?php echo env_url( 'register' ); ?>"><?php echo lang( 'register' ); ?></a>
            </li>
          <?php } ?>
          
        <?php } else { ?>
          
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?php echo env_url( 'user/notifications' ); ?>">
              <?php if ( user_panel_activate_child_page( 'notifications' ) ) { ?>
                <i class="fas fa-bell notifications-bell text-sub"></i>
              <?php } else { ?>
                <i class="far fa-bell notifications-bell"></i>
              <?php } ?>
              
              <?php if ( $new_notifications ) { ?>
                <span class="badge bg-danger notifications-count"><?php echo html_escape( $new_notifications ); ?></span>
              <?php } ?>
            </a>
          </li>
          
          <li class="nav-item dropdown">
            <a class="nav-link pe-0" href="#" id="account-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo html_escape( $this->zuser->get( 'first_name' ) . ' ' .  $this->zuser->get( 'last_name' ) ); ?>
              <i class="ms-1 fas fa-chevron-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end rounded border-0 shadow-lg" aria-labelledby="account-dropdown">
              <li>
                <a class="dropdown-item <?php echo activate_page( 'dashboard' ); ?>" href="<?php echo env_url( 'dashboard' ); ?>">
                  <i class="fas fa-tachometer-alt"></i> <?php echo lang( 'dashboard' ); ?>
                </a>
              </li>
              <li>
                <a class="dropdown-item <?php echo user_panel_activate_sub_child_page( 'create_ticket' ); ?>" href="<?php echo env_url( 'user/support/create_ticket' ); ?>">
                  <i class="fas fa-plus-circle"></i> <?php echo lang( 'submit_ticket' ); ?>
                </a>
              </li>
              <li>
                <a class="dropdown-item <?php echo user_panel_activate_sub_child_page( ['tickets', 'ticket'] ); ?>" href="<?php echo env_url( 'user/support/tickets/all' ); ?>">
                  <i class="fas fa-headset"></i> <?php echo lang( 'tickets' ); ?>
                </a>
              </li>
              <li>
                <a class="dropdown-item <?php echo user_panel_activate_child_page( 'sessions' ); ?>" href="<?php echo env_url( 'user/sessions' ); ?>">
                  <i class="fab fa-firefox"></i> <?php echo lang( 'sessions' ); ?>
                </a>
              </li>
              <li>
                <a class="dropdown-item <?php echo user_panel_activate_sub_child_page( 'profile_settings' ); ?>" href="<?php echo env_url( 'user/account/profile_settings' ); ?>">
                  <i class="fas fa-cog"></i> <?php echo lang( 'settings' ); ?>
                </a>
              </li>
              
              <?php if ( $this->zuser->is_team_member() ) { ?>
                <li>
                  <a class="dropdown-item" href="<?php echo env_url( 'admin/dashboard' ); ?>">
                    <i class="fas fa-th-large"></i>
                    <?php echo lang( 'admin_panel' ); ?>
                  </a>
                </li>
              <?php } ?>
              
              <li>
                <a class="dropdown-item" href="<?php echo env_url( 'logout' ); ?>">
                  <i class="fas fa-power-off"></i> <?php echo lang( 'logout' ); ?>
                </a>
              </li>
            </ul>
          </li>
        <?php } ?>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>