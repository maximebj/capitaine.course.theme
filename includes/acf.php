<?php 

// Clé Google Maps pour le champ ACF
function capitaine_acf_google_map_api( $api ){
  $api['key'] = '...................';
  return $api;
}
add_filter( 'acf/fields/google_map/api', 'capitaine_acf_google_map_api' );