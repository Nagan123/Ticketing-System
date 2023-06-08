<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>

<?php if ( $article->visibility != 1 ) { ?>
  <div class="alert alert-danger no-radius"><?php echo lang( 'hidden_post' ); ?></div>
<?php } ?>

<div class="z-posts container mt-5 extra-height-2">
  <div class="row mb-4">
    <div class="col">
      <?php load_view( 'home/support/breadcrumb', [
          'name' => $article->category_name,
          'slug' => $article->category_slug,
          'parent_id' => $article->category_parent_id,
          'article_page' => true
       ]); ?>
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
  <div class="row row-main">
    <div class="col-lg-8">
      <div class="shadow-sm">
        <?php if ( ! empty( $article ) ) {
          $article_url = env_url( get_kb_article_slug( $article->slug ) ); ?>
          <h3 class="fw-bold mb-2"><?php echo html_escape( $article->title ); ?></h3>
          <span class="d-inline-block small me-2">
            <i class="far fa-clock"></i> <?php printf( lang( 'posted_on' ), get_date_time_by_timezone( html_escape( $article->created_at ), true ) ); ?>
          </span>
          
          <?php if ( ! empty( $article->updated_at ) ) { ?>
            <span class="d-inline-block small me-2">
              <i class="far fa-clock"></i> <?php printf( lang( 'updated_on' ), get_date_time_by_timezone( html_escape( $article->updated_at ), true ) ); ?>
            </span>
          <?php } ?>
          
          <div class="content border-top">
            <div class="content-holder">
              <p><?php echo strip_extra_html( do_secure( $article->content, true ) ); ?></p>
            </div>
            <!-- /.content-holder -->
            <div class="social-share mt-5">
              <a
                class="btn-z" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo html_escape( $article_url ); ?>"
                data-bs-toggle="tooltip"
                title="<?php echo lang( 'share_on_facebook' ); ?>"
                target="_blank">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a
                class="btn-z" href="https://twitter.com/intent/tweet?url=<?php echo html_escape( $article_url ); ?>"
                data-bs-toggle="tooltip"
                title="<?php echo lang( 'share_on_twitter' ); ?>"
                target="_blank">
                <i class="fab fa-twitter"></i>
              </a>
              <a
                class="btn-z" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo html_escape( $article_url ); ?>"
                data-bs-toggle="tooltip"
                title="<?php echo lang( 'share_on_linkedin' ); ?>"
                target="_blank">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
            <!-- /.social-share -->
            <div class="border-top mt-4 pt-4 text-center">
              <h3 class="h4 fw-bold mb-3"><?php echo lang( 'found_article_helpful' ); ?></h3>
              <div class="mb-3">
                <button
                  class="btn btn-outline-success btn-wide article-vote me-1"
                  data-action="<?php echo env_url( 'support/article_vote/y/' . html_escape( $article->id ) ); ?>"
                  <?php echo ( $voted ) ? 'disabled' : ''; ?>>
                  <?php echo lang( 'yes' ); ?>
                </button>
                <button
                  class="btn btn-outline-danger btn-wide article-vote"
                  data-action="<?php echo env_url( 'support/article_vote/n/' . html_escape( $article->id ) ); ?>"
                  <?php echo ( $voted ) ? 'disabled' : ''; ?>>
                  <?php echo lang( 'no' ); ?>
                </button>
              </div>
              <div class="not-in-form"><div class="response-message"></div></div>
              <p class="mb-0" id="article-votes">[ <?php echo html_escape( sprintf( lang( 'found_helpful' ), $article->helpful, ( $article->helpful + $article->not_helpful ) ) ); ?> ]</p>
            </div>
          </div>
          <!-- /.content -->
        <?php } ?>
      </div>
    </div>
    <!-- /col -->
    <div class="col-lg-4">
      <div class="shadow-sm mb-4">
        <form class="mb-0" action="<?php echo env_url( 'search' ); ?>">
          <div class="input-group align-items-center">
            <input type="search" class="form-control" name="query" placeholder="<?php echo lang( 'search_articles' ); ?>" required>
            <button class="btn btn-sub btn-wide"><i class="fas fa-search"></i></button>
          </div>
          <!-- /.input-group -->
        </form>
      </div>
      
      <?php if ( ! empty( $related ) ) { ?>
        <div class="shadow-sm">
          <h3 class="h5 fw-bold mb-4 border-bottom pb-2"><?php echo lang( 'related_articles' ); ?></h3>
          <ul class="nav flex-column z-kb-list">
            <?php foreach ( $related as $related_article ) { ?>
              <li>
                <a href="<?php echo env_url( get_kb_article_slug( html_escape( $related_article->slug ) ) ); ?>">
                  <i class="far fa-file-alt me-2"></i> <?php echo html_escape( $related_article->title ); ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        </div>
      <?php } ?>
      
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
</div>
<!-- /.container -->

<?php load_view( 'home/still_no_luck' ); ?>