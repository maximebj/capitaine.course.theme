<?php 

// Prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 900, 0, false );
add_image_size( 'products', 800, 600, false );
add_image_size( 'square', 256, 256, true );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );

// Textdomain pour la traduction du thème
load_theme_textdomain( 'capitaine', get_template_directory() . '/languages' );

// Menus
register_nav_menus( array(
  'main' => __( 'Main menu', 'capitaine' ),
  'footer' => __( 'Footer menu', 'capitaine' ),
) );

// Sidebar
register_sidebar( array(
  'id' => 'blog-sidebar',
  'name' => 'Blog',
  'before_widget'  => '<div class="site__sidebar__widget %2$s">',
  'after_widget'  => '</div>',
  'before_title' => '<p class="site__sidebar__widget__title">',
  'after_title' => '</p>',
) );


// Script et styles
function capitaine_assets() {

  wp_enqueue_style( 'capitaine', get_stylesheet_uri(), array(), '1.0' );
  wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap', array(), '1.0' );

  wp_deregister_script( 'jquery' );
  wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false, '3.3.1', true );

  // Charger notre script
  wp_enqueue_script( 'capitaine', get_template_directory_uri() . '/js/script.js', array( 'jquery' ), '1.0', true );

  // Envoyer une variable de PHP à JS proprement
  wp_localize_script( 'capitaine', 'ajaxurl', admin_url( 'admin-ajax.php' ) );

}
add_action( 'wp_enqueue_scripts', 'capitaine_assets' );


// Custom Post Types & Taxonomies
function capitaine_register_post_types() {
  
  // Type de publication
  $labels = array(
    'name' => __( 'Portfolio', 'capitaine' ),
    'all_items' => __( 'All projects', 'capitaine' ),
    'singular_name' => __( 'Project', 'capitaine' ),
    'add_new_item' => __( 'Add a project', 'capitaine' ),
    'edit_item' => __( 'Edit project', 'capitaine' ),
    'menu_name' => __( 'Portfolio', 'capitaine' )
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_in_rest' => true,
    'has_archive' => true,
    'supports' => array( 'title', 'editor','thumbnail' ),
    'menu_position' => 5,
    'menu_icon' => 'dashicons-admin-customizer', // https://developer.wordpress.org/resource/dashicons/
  );

  register_post_type( 'portfolio', $args );

  // Taxonomie
  $labels = array(
    'name' => 'Types de projets',
    'singular_name' => 'Type de projet',
    'add_new_item' => 'Ajouter un Type de Projet',
    'new_item_name' => 'Nom du nouveau Projet',
    'parent_item' => 'Type de projet parent',
  );

  $args = array( 
    'labels' => $labels,
    'public' => true,
    'show_in_rest' => true,
    'hierarchical' => true, 
  );

  register_taxonomy( 'type-projets', 'portfolio', $args );

}
add_action( 'init', 'capitaine_register_post_types' );


// Personnaliser la page de connexion
function capitaine_login_logo() {
	wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/css/custom-login.css', array( 'login' ) );
}
add_action( 'login_enqueue_scripts', 'capitaine_login_logo' );




// Réglages pour ACF
include get_template_directory() . '/includes/acf.php';

// Hooks save_post
include get_template_directory() . '/includes/hooks.php';

// Ajax
include get_template_directory() . '/includes/ajax.php';

// Shortcodes
include get_template_directory() . '/includes/shortcodes.php';