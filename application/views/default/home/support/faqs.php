<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="z-faqs container mt-5 extra-height-2">
  <div class="row mb-3">
    <div class="col">
      <h2 class="h4 fw-bold"><?php echo lang( 'faqs_detailed' ); ?></h2>
    </div>
    <!-- /col -->
  </div>
  <!-- /.row -->
  <?php if ( ! empty( $categories ) ) {
    foreach ( $categories as $category ) {
      $faqs = get_faqs_by_category( $category->id );
      $i = 0; ?>
    <div class="row row-main">
      <div class="col">
        <div class="shadow-sm">
          <h3 class="h5 mb-4 fw-bold border-bottom pb-2"><?php echo html_escape( $category->name ); ?></h3>
          <div class="accordion" id="faqs-<?php echo md5( $category->id ); ?>">
            <?php if ( ! empty( $faqs ) ) {
              foreach ( $faqs as $faq ) {
              $i++; ?>
              <div class="accordion-item">
                <p class="accordion-header" id="faq-title-<?php echo md5( $faq->id ); ?>">
                  <button
                  
                    <?php if ( $i == 1 ) { ?>
                      class="accordion-button fw-bold"
                    <?php } else { ?>
                      class="accordion-button fw-bold collapsed"
                    <?php } ?>
                    
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#faq-<?php echo md5( $faq->id ); ?>"
                    aria-expanded="<?php echo ( $i == 1 ) ? 'true' : 'false'; ?>"
                    aria-controls="faq-<?php echo md5( $faq->id ); ?>">
                    <?php echo html_escape( $faq->question ); ?>
                  </button>
                </p>
                <div
                  id="faq-<?php echo md5( $faq->id ); ?>"
                  
                  <?php if ( $i == 1 ) { ?>
                    class="accordion-collapse collapsed show"
                  <?php } else { ?>
                    class="accordion-collapse collapse"
                  <?php } ?>
                  
                  aria-labelledby="faq-title-<?php echo md5( $faq->id ); ?>"
                  data-bs-parent="#faqs-<?php echo md5( $category->id ); ?>">
                  <div class="accordion-body">
                    <?php echo html_escape( $faq->answer ); ?>
                  </div>
                  <!-- /.accordion-body -->
                </div>
                <!-- /.collapse -->
              </div>
              <!-- /.accordion-item -->
            <?php }
            }?>
          </div>
          <!-- /.accordion -->
        </div>
      </div>
      <!-- /col -->
    </div>
    <!-- /.row -->
    <?php }
    } else { ?>
    <div class="row row-main">
    <div class="col">
      <div class="shadow-sm">
        <div class="text-center">
          <img class="not-found mt-2 mb-4" src="<?php illustration_by_color( 'not_found' ); ?>" alt="">
          <h2 class="h4 fw-bold"><?php echo lang( 'no_records_found' ); ?></h2>
        </div>
      </div>
    </div>
    <!-- /col -->
    </div>
    <!-- /.row -->
  <?php } ?>
</div>
<!-- /.container -->

<?php load_view( 'home/still_no_luck' ); ?>