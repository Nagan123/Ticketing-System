<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="col">
  <?php if ( ! empty( $articles ) ) {
    foreach ( $articles as $article ) { ?>
    <div class="post shadow-sm">
      <div class="clearfix">
        <p class="h5 fw-bold float-lg-start"><a href="<?php echo env_url( get_kb_article_slug( html_escape( $article->slug ) ) ); ?>"><?php echo html_escape( $article->title ); ?></a></p>
        <span class="found-helpful float-lg-end my-2 my-lg-0">
          <?php echo html_escape( sprintf( lang( 'found_helpful' ), $article->helpful, ( $article->helpful + $article->not_helpful ) ) ); ?>
        </span>
      </div>
      <span class="d-inline-block small me-2">
        <i class="far fa-clock"></i> <?php printf( lang( 'posted_on' ), get_date_time_by_timezone( html_escape( $article->created_at ), true ) ); ?>
      </span>
      
      <?php if ( ! empty( $display_category ) ) { ?>
        <?php load_view( 'home/support/its_category', ['article' => $article] ); ?>
      <?php } ?>
      
      <p class="text-muted mt-1 mb-0"><?php echo get_sized_text( strip_tags( $article->content ), 345, true ); ?></p>
      
      <?php if ( is_increased_length( $article->content, 345 ) ) { ?>
        <a class="mt-3 d-inline-block" href="<?php echo env_url( get_kb_article_slug( html_escape( $article->slug ) ) ); ?>">
          <?php echo lang( 'read_more' ); ?> <i class="ms-1 fas fa-angle-right"></i>
        </a>
      <?php } ?>
    </div>
    <!-- /.post -->
  <?php }
  } else { ?>
    <div class="text-center shadow-sm">
      <img class="not-found mt-2 mb-4" src="<?php illustration_by_color( 'not_found' ); ?>" alt="">
      <h2 class="h4 fw-bold"><?php echo lang( 'no_records_found' ); ?></h2>
    </div>
  <?php } ?>
</div>
<!-- /col -->