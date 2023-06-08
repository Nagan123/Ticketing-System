<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="response-message no-radius no-mb"><?php echo alert_message(); ?></div>



<!-- ARTICLES: -->
<?PHP IF ( ! EMPTY( $CATEGORIES = GET_ARTICLES_CATEGORIES() ) ) {
  FOREACH ( $CATEGORIES AS $CATEGORY ) { ?>
  <DIV CLASS="Z-POSTS CONTAINER MY-5">
    <DIV CLASS="ROW MB-3">
      <DIV CLASS="COL">
        <H2 CLASS="H4 FW-BOLD BORDER-BOTTOM PB-2">
          <A HREF="<?PHP ECHO ENV_URL( GET_KB_CATEGORY_SLUG( HTML_ESCAPE( $CATEGORY->SLUG ) ) ); ?>"><?PHP ECHO HTML_ESCAPE( $CATEGORY->NAME ); ?></A>
        </H2>
      </DIV>
      <!-- /COL -->
    </DIV>
    <!-- /.ROW -->
    <?PHP IF ( ! EMPTY( $CHILD_CATEGORIES = GET_ARTICLES_SUBCATEGORIES( $CATEGORY->ID ) ) ) { ?>
      <DIV CLASS="ROW ROW-MAIN">
        <?PHP FOREACH ( $CHILD_CATEGORIES AS $CHILD_CATEGORY ) { ?>
          <DIV CLASS="COL-XL-4 COL-LG-6">
            <H3 CLASS="H5 MB-4 FW-BOLD BORDER-BOTTOM PB-2">
              <A HREF="<?PHP ECHO ENV_URL( HTML_ESCAPE( GET_KB_CATEGORY_SLUG( $CATEGORY->SLUG, $CHILD_CATEGORY->SLUG ) ) ); ?>">
                <?PHP ECHO HTML_ESCAPE( $CHILD_CATEGORY->NAME ); ?>
                (<?PHP ECHO GET_ARTICLES_BY_CATEGORY( $CHILD_CATEGORY->ID, TRUE ); ?>)
              </A>
            </H3>
            <?PHP IF ( ! EMPTY( $ARTICLES = GET_ARTICLES_BY_CATEGORY( $CHILD_CATEGORY->ID ) ) ) { ?>
              <UL CLASS="NAV FLEX-COLUMN Z-KB-LIST">
                <?PHP FOREACH ( $ARTICLES AS $ARTICLE ) { ?>
                  <LI>
                    <A HREF="<?PHP ECHO ENV_URL( GET_KB_ARTICLE_SLUG( HTML_ESCAPE( $ARTICLE->SLUG ) ) ); ?>">
                      <I CLASS="FAR FA-FILE-ALT ME-2"></I> <?PHP ECHO HTML_ESCAPE( $ARTICLE->TITLE ); ?>
                    </A>
                  </LI>
                <?PHP } ?>
              </UL>
            <?PHP } ?>
          </DIV>
          <!-- /COL -->
        <?PHP } ?>
      </DIV>
      <!-- /.ROW -->
    <?PHP } ?>
  </DIV>
  <!-- /.CONTAINER -->
<?PHP }
} ELSE { ?>
  <DIV CLASS="Z-LIST CONTAINER MY-5">
    <DIV CLASS="SHADOW-SM">
      <DIV CLASS="ROW">
        <DIV CLASS="COL">
          <DIV CLASS="LIST-ITEM">
            <DIV CLASS="ROW">
              <DIV CLASS="COL">
                <DIV CLASS="TEXT-CENTER">
                  <IMG CLASS="NOT-FOUND MT-2 MB-4" SRC="<?PHP ILLUSTRATION_BY_COLOR( 'NOT_FOUND' ); ?>" ALT="">
                  <H2 CLASS="H4 FW-BOLD"><?PHP ECHO LANG( 'NO_RECORDS_FOUND' ); ?></H2>
                </DIV>
              </DIV>
              <!-- /COL -->
            </DIV>
            <!-- /.ROW -->
          </DIV>
          <!-- /.LIST-ITEM -->
        </DIV>
        <!-- /COL -->
      </DIV>
      <!-- /.ROW -->
    </DIV>
    <!-- /.SHADOW-SM -->
  </DIV>
  <!-- /.Z-LIST -->
<?php } ?>

<?php load_view( 'home/still_no_luck' ); ?>