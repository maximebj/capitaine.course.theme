<?php

add_action( 'wp_ajax_capitaine_load_comments', 'capitaine_load_comments' );
add_action( 'wp_ajax_nopriv_capitaine_load_comments', 'capitaine_load_comments' );

function capitaine_load_comments() {
  
  // Vérification de sécurité
  if( ! isset( $_REQUEST['nonce'] ) or ! wp_verify_nonce( $_REQUEST['nonce'], 'capitaine_load_comments' ) ) {
    wp_send_json_error( "Vous n’avez pas l’autorisation d’effectuer cette action." );
  }

  // On vérifie que l'identifiant a bien été envoyé
  if( ! isset( $_POST['postid'] ) ) {
    wp_send_json_error( "L'identifiant de l'article est manquant." );
  }

  // Récupération des données du formulaire
  $post_id = intval( $_POST['postId'] );

  // Utilisez sanitize_text_field() pour une chaine de caractères.
  // exemple : $name = sanitize_text_field( $_POST['name'] );

  // Requête des commentaires
  $comments = get_comments( [
    'post_id' => $post_id,
    'status' => 'approve'
  ] );

  // Préparer le HTML des commentaires
  $html = wp_list_comments( [
    'per_page' => -1,
    'avatar_size' => 76,
    'echo' => false,
  ], $comments );

  // Envoyer les données au navigateur
	wp_send_json_success( $html );
}