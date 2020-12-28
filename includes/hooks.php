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

  // Étape 1 : création des ancres dans le contenu

  // Recherche des titres H2 à H4 dans le contenu
  $content = preg_replace_callback( 
    "/<h([2-4])(.*?)>(.*?)<\/h([2-4])>/i", // L'expression régulière
    function( $matches ) { // La fonction de remplacement
      $level = $matches[1];
      $slug = sanitize_title( $matches[3] );
      $title = $matches[3];

      return "<h$level id='$slug'>$title</h$level>";
    }, 
    $post->post_content // Le contenu dans lequel faire la recherche
  );

  // Pour éviter une boucle infinie, on désactive le hook
  remove_action( 'save_post', 'capitaine_table_of_contents', 10, 3 );

  // On met à jour le HTML de l'article
  wp_update_post( array( 'ID' => $post_id, 'post_content' => $content ) );

  // Réactiver le hook
  add_action( 'save_post', 'capitaine_table_of_contents', 10, 3 );


  // Étape 2 : génération du sommaire

  // On initialise le html du sommaire
  $summary = "<ul class='summary'>";

  // On récupère
  preg_match_all(
    "/<h([2-4])(.*?)>(.*?)<\/h([2-4])>/i",
    $post->post_content,
    $matches,
    PREG_SET_ORDER
  );

  // On ajoute une entrée au sommaire
  foreach( $matches as $match ) {
    $slug = sanitize_title( $match[3] );
    $title = $match[3];
    
    $summary .= "<li><a href='#$slug'>$title</a></li>";
  }
  
  // On referme le sommaire
  $summary .= "</ul>";

	// Et on l'enregistre dans une meta liée à l'article
	update_post_meta( $post_id, 'summary', $summary );
}
add_action( 'save_post', 'capitaine_table_of_contents', 10, 3 );