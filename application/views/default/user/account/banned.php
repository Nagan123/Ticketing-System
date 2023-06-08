<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-align-middle">
  <div class="card z-card-mini-box text-center">
    <img class="mb-4" src="<?php illustration_by_color( 'banned' ); ?>" alt="">
    <h4 class="fw-bold text-danger"><?php echo lang( 'account_banned' ); ?></h4>
    <p class="mb-0"><?php printf( lang( 'account_banned_msg' ), env_url( 'terms' ) ); ?></p>
  </div>
  <!-- /.card -->
</div>
<!-- /.z-align-middle -->