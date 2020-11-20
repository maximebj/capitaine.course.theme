<?php 

// Calculer le temps de lecture
function capitaine_reading_time( $post_id, $post, $update )  {

	if( ! $update ) { return; }
	if( wp_is_post_revision( $post_id ) ) { return; }
	if( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) { return; }
	if( $post->post_type != 'post' ) { return; }

	// Calculer le temps de lecture
	$word_count = str_word_count( strip_tags( $post->post_content ) );

	// On prend comme base 250 mots par minute
	$minutes = ceil( $word_count / 250 );
	
	// On sauvegarde la meta
	update_post_meta( $post_id, 'reading_time', $minutes );
}
add_action( 'save_post', 'capitaine_reading_time', 10, 3 );


// Générer le sommaire
function capitaine_table_of_contents( $post_id, $post, $update )  {

  if( ! $update ) { return; }
  if( wp_is_post_revision( $post_id ) ) { return; }
  if( defined( 'DOING_AUTOSAVE' ) and DOING_AUTOSAVE ) { return; }
  if( $post->post_type != 'post' ) { return; }
	
  require_once get_template_directory() . '/lib/simple_html_dom.php';
  $html = str_get_html( $post->post_content );
    
  // On initialise le html du sommaire
	$summary = "<ul class='summary'>";

  foreach( $html->find( 'h2, h3, h4' ) as $element ):

    $title = $element->innertext;
    if ( $title == "" ) { continue; }

    // Mon titre deviendra alors mon-titre
    $slug = sanitize_title( $title );

    // On ajoute id="mon-titre" à chaque titre
    $element->id = $slug;

    // Pour éviter une boucle infinie, on désactive le hook
    remove_action( 'save_post', 'capitaine_table_of_contents', 10, 3 );

    // On met à jour le HTML de l'article
    wp_update_post( array( 'ID' => $post_id, 'post_content' => $html ) );

    // Réactiver le hook
    add_action( 'save_post', 'capitaine_table_of_contents', 10, 3 );
  
  // On ajoute une entrée au sommaire
  $summary .= "<li><a href='#$slug'>$title</a></li>";

  endforeach;
    
  // On referme le sommaire
	$summary .= "</ul>";

	// Et on l'enregistre dans une meta liée à l'article
	update_post_meta( $post_id, 'summary', $summary );
}
add_action( 'save_post', 'capitaine_table_of_contents', 10, 3 );