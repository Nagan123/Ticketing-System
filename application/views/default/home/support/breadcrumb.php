<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<p class="mb-0">
  <a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> <?php echo lang( 'home' ); ?></a>
  <i class="fas fa-chevron-right category-separator"></i>
  
  <?php if ( $parent_id != null ) {
    $parent_category = get_articles_category_data( $parent_id );
    if ( ! empty( $parent_category ) ) { ?>
      <a href="<?php echo env_url( get_kb_category_slug( html_escape( $parent_category->slug ) ) ); ?>"><?php echo html_escape( $parent_category->name ); ?></a>
      <i class="fas fa-chevron-right category-separator"></i>
      <?php if ( isset( $article_page ) ) { ?>
        <a href="<?php echo env_url( html_escape( get_kb_category_slug( $parent_category->slug, $slug ) ) ); ?>">
          <?php echo html_escape( $name ); ?>
        </a>
      <?php } else { ?>
        <span class="text-muted"><?php echo html_escape( $name ); ?></span>
      <?php } ?>
  <?php }
  } else { ?>
    
    <?php if ( isset( $article_page ) ) { ?>
      <a href="<?php echo env_url( get_kb_category_slug( html_escape( $slug ) ) ); ?>"><?php echo html_escape( $name ); ?></a>
    <?php } else { ?>
      <span class="text-muted"><?php echo html_escape( $name ); ?></span>
    <?php } ?>
    
  <?php } ?>
  
  <?php if ( isset( $article_page ) ) { ?>
    <i class="fas fa-chevron-right category-separator"></i>
    <span class="text-muted"><?php echo lang( 'article' ); ?></a>
  <?php } ?>
  
</p>