<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

if ( ! empty( $fields ) && ! empty( $form_class ) ) {
  foreach ( $fields as $field ) {
    $required = ( $field->is_required ) ? 'required' : '';
    $id = $field->id; ?>
  <div class="<?php echo html_escape( $form_class ); ?>">
      <label class="form-label" for="cf-<?php echo html_escape( $id ); ?>">
        <?php echo html_escape( $field->name ); ?>
        <?php echo ( $field->is_required ) ? '<span class="' . html_escape( $label_required_class ) . '">*</span>' : ''; ?>
      </label>
    <?php if ( $field->type === 'text' || $field->type === 'email' ) { ?>
      <input
        type="<?php echo html_escape( $field->type ); ?>"
        id="cf-<?php echo html_escape( $id ); ?>"
        class="form-control"
        name="cf_<?php echo html_escape( $id ); ?>"
        <?php echo html_escape( $required ); ?>>
    <?php } else if ( $field->type === 'textarea' ) { ?>
      <textarea
        id="cf-<?php echo html_escape( $id ); ?>"
        class="form-control"
        name="cf_<?php echo html_escape( $id ); ?>"
        rows="6"
        <?php echo html_escape( $required ); ?>></textarea>
    <?php } else if ( $field->type === 'checkbox' || $field->type === 'radio' ) {
      $options = explode( ',', $field->options );
      if ( count( $options ) > 0 ) {
        foreach ( $options as $key => $option ) { ?>
        <div class="icheck icheck-primary">
          <?php if ( $field->type === 'checkbox' ) { ?>
            <input
              type="checkbox"
              id="cf_<?php echo html_escape( $id ); ?>_<?php echo html_escape( $key ); ?>"
              name="cf_<?php echo html_escape( $id ); ?>_<?php echo html_escape( $key ); ?>"
              value="1">
          <?php } else { ?>
            <input
              type="radio"
              id="cf_<?php echo html_escape( $id ); ?>_<?php echo html_escape( $key ); ?>"
              name="cf_<?php echo html_escape( $id ); ?>"
              value="<?php echo html_escape( $key ); ?>"
              <?php echo html_escape( $required ); ?>>
          <?php } ?>
          <label for="cf_<?php echo html_escape( $id ); ?>_<?php echo html_escape( $key ); ?>">
            <?php echo html_escape( trim( $option ) ); ?>
          </label>
        </div>
        <!-- /.icheck -->
      <?php }
      }
    } else if ( $field->type === 'select' ) {
      $options = explode( ',', $field->options );
      if ( count( $options ) > 0 ) { ?>
        <select
          class="form-control select2 search-disabled"
          id="cf-<?php echo html_escape( $id ); ?>"
          data-placeholder="<?php echo html_escape( $field->name ); ?>"
          name="cf_<?php echo html_escape( $id ); ?>"
          <?php echo html_escape( $required ); ?>>
          <option></option>
          
          <?php foreach ( $options as $key => $option ) { ?>
            <option value="<?php echo html_escape( $key ); ?>"><?php echo html_escape( $option ); ?></option>
          <?php } ?>
        </select>
    <?php } } ?>
    
    <?php if ( ! empty( $field->guide_text ) ) { ?>
      <small class="form-text text-muted"><?php echo html_escape( $field->guide_text ); ?></small>
    <?php } ?>
    
  </div>
  
<?php } } ?>