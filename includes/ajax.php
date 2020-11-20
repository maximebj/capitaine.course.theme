<?php

add_action( 'wp_ajax_load_comments', 'capitaine_load_comments' );
add_action( 'wp_ajax_nopriv_load_comments', 'capitaine_load_comments' );

function capitaine_load_comments() {
  
  $post_id = $_POST['post_id'];

  $comments = get_comments(array(
    'post_id' => $post_id,
    'status' => 'approve'
  ));

  wp_list_comments(array(
    'per_page' => -1,
    'avatar_size' => 76
  ), $comments );

	wp_die();
}