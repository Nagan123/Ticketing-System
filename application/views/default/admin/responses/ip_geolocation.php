<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<div class="modal-header">
  <h5 class="modal-title"><?php echo lang( 'ip_geolocation' ); ?></h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<!-- /.modal-header -->
<div class="modal-body">
  <ul class="list-group">
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'ip_address' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $ip ) )
        {
            echo html_escape( $ip );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'city' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $city ) )
        {
            echo html_escape( $city );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'region' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $region ) )
        {
            echo html_escape( $region );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'country' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $country ) )
        {
            echo html_escape( $country );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'isp' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $org ) )
        {
            echo html_escape( $org );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'postal_code' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $postal ) )
        {
            echo html_escape( $postal );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
    <li class="list-group-item">
      <span class="font-weight-bold"><?php echo lang( 'timezone' ); ?>:</span>
      <span class="float-right">
        <?php
        if ( ! empty( $timezone ) )
        {
            echo html_escape( $timezone );
        }
        else
        {
            echo lang( 'n_a' );
        }
        ?>
      </span>
    </li>
  </ul>
</div>
<!-- /.modal-body -->  