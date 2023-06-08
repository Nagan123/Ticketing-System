<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<span class="d-inline-block small mb-2">
  <i class="far fa-folder"></i>
  <?php if ( ! empty( $article ) ) {
    if ( $article->category_parent_id != null ) {
    $parent_category = get_articles_category_data( $article->category_parent_id );
    if ( ! empty( $parent_category ) ) { ?>
      <a href="<?php echo env_url( get_kb_category_slug( html_escape( $parent_category->slug ) ) ); ?>">
        <?php echo html_escape( $parent_category->name ); ?>
      </a>
      <i class="fas fa-chevron-right category-separator"></i>
      <a href="<?php echo env_url( html_escape( get_kb_category_slug( $parent_category->slug, $article->category_slug ) ) ); ?>">
        <?php echo html_escape( $article->category_name ); ?>
      </a>
  <?php }
  } else { ?>
    <a href="<?php echo env_url( get_kb_category_slug( html_escape( $article->category_slug ) ) ); ?>"><?php echo html_escape( $article->category_name ); ?></a>
  <?php }
  } ?>
</span>