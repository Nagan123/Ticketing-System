<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!-- Generate Report Modal: -->
<div class="modal close-after" id="generate-report">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form class="z-form" action="<?php admin_action( 'reports/generate_report' ); ?>" method="post">
        <div class="modal-body">
          <div class="response-message"></div>
          <p class="mb-2"><?php echo lang( 'sure_generate_report' ); ?></p>
          <select class="form-control select2 search-disabled" name="period">
            <option value="1"><?php echo lang( 'past_3_days' ); ?></option>
            <option value="2"><?php echo lang( 'past_7_days' ); ?></option>
            <option value="3"><?php echo lang( 'past_2_weeks' ); ?></option>
            <option value="4"><?php echo lang( 'past_1_month' ); ?></option>
            <option value="5"><?php echo lang( 'past_3_months' ); ?></option>
            <option value="6"><?php echo lang( 'past_6_months' ); ?></option>
            <option value="7"><?php echo lang( 'past_12_months' ); ?></option>
            <option value="8"><?php echo lang( 'all_time' ); ?></option>
          </select>
        </div>
        <!-- /.modal-body -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary text-sm" data-dismiss="modal">
            <i class="fas fa-times-circle mr-2"></i> <?php echo lang( 'no' ); ?>
          </button>
          <button type="submit" class="btn btn-primary text-sm">
            <i class="fas fa-check-circle mr-2"></i> <?php echo lang( 'yes' ); ?>
          </button>
        </div>
        <!-- /.modal-footer -->
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->