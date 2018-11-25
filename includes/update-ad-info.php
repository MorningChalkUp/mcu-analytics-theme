<?php
/* Recheck if user is logged in just to be sure, this should have been done already */
if( !is_user_logged_in() ) {
  wp_redirect( home_url() );
  exit;
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['action'] ) && $_POST['action'] == 'update-ads' ) {

  $current_user = wp_get_current_user();

  /* Check nonce first to see if this is a legit request */
  if( !isset( $_POST['_wpnonce'] ) || !wp_verify_nonce( $_POST['_wpnonce'], 'update-ads' ) ) {
    wp_redirect( get_permalink() . '?validation=unknown' );
    exit;
  }
  /* Check honeypot for autmated requests */
  if( !empty($_POST['honey-name']) ) {
    wp_redirect( get_permalink() . '?validation=unknown' );
    exit;
  }

  /* Update Ads */
  $row = array(
    'descriptor' => $_POST['descriptor'],
    'link' => $_POST['link'],
    'copy' => $_POST['ad']
  );

  update_row('days', $_POST['row'], $row, $_POST['post']);
}