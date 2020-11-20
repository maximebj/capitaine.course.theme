<?php 

function capitaine_shortcode_best_games( $atts ) {
    
  $args = array(
    'post_type' => 'post',
    'category_name' => 'jeux-video',
    'posts_per_page' => 3,
    'order' => 'DESC', 
    'orderby' => 'meta_value',
    'meta_key' => 'note',
  );

	$my_query = new WP_Query( $args );

  ob_start(); // On démarre la rétention

  if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();

    get_template_part( 'templates/parts/games' );

  endwhile;
  endif;

  $html = ob_get_contents(); // On récupère les contenus retenus
  ob_end_flush(); // On vide

  wp_reset_postdata();
    
  return $html;
}
add_shortcode( 'jeux', 'capitaine_shortcode_best_games' );