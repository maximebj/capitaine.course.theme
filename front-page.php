<?php get_header(); ?>

  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
    <h1 class="post__title"><?php the_title(); ?></h1>
    
    <div class="post__content">
      <?php the_content(); ?>
    </div>

    <h2>Les jeux-vidéo les mieux notés</h2>

    <?php 
      // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
      $args = array(
        'post_type' => 'post', // type de publication
        'category_name' => 'jeux-video', // Slug de la catégorie
        'order' => 'DESC', // De la meilleure note à la moins bonnte
        'orderby' => 'meta_value', // Rangé selon un champ personnalisé
        'meta_key' => 'note', // C'est ici qu'on indique quel est ce champ
        'posts_per_page' => 5 // 5 articles
      );

      // 2. On exécute la WP Query
      $my_query = new WP_Query( $args );

      // 3. On lance la boucle !
      if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();

          the_title();
          the_content();
          the_post_thumbnail();

      endwhile;
      endif;

      // 4. On réinitialise à la requête principale (important)
      wp_reset_postdata();
    ?>


  <?php endwhile; endif; ?>

<?php get_footer(); ?>