<?php get_header(); ?>
  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
    <div class="post">
      
      <div class="post__thumbnail">
        <?php the_post_thumbnail(); ?>
      </div>

      <h1 class="post__title"><?php the_title(); ?></h1>

      <div class="post__meta">
        <div class="post__meta__avatar">
          <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
        </div>
        <div class="post__meta__by">
          Publié le <?php the_date(); ?><br>
          par <?php the_author(); ?>
        </div>
        <div class="post__meta__cat">
          Catégorie <br>
          <?php the_category(); ?>
        </div>
        <div class="post__meta__tag">
          Étiquettes <br>
          <span><?php the_tags( '' ); ?></span>
        </div>
      </div>

      <?php echo get_post_meta( $post->ID, 'summary', true ); ?>

      <div class="post__content">
        <?php the_content(); ?>
      </div>

      <?php if( has_category( 'jeux-video' ) ): ?>
        <div class="review">
          <div class="review__score"><?php the_field( 'note' ); ?></div>

          <div class="review__cols">
            <?php 
              $image_id = get_field( 'pochette' );
              if( $image_id ):
            ?>
              <div class="review__picture">
                <?php echo wp_get_attachment_image( $image_id, 'full' ); ?>
              </div>
            <?php endif; ?>
            <div class="review__pros">
              <p class="review__title">Les plus</p>
              <?php the_field( 'les_plus' ); ?>
            </div>
            <div class="review__cons">
              <p class="review__title">Les moins</p>
              <?php the_field( 'les_moins' ); ?>
            </div>
          </div>
          
          <div class="review__date">Sorti le <?php the_field( 'date_de_sortie' ); ?></div>
        
        </div>

      <?php endif; ?>

      <?php 
        // Commentaires version classique
        // comments_template(); 
      ?>

      <?php // Commentaires version Ajax ?>
      <h2>Il y a <?php comments_number(); ?></h2>
      
      <?php if( get_comments_number() ): ?>
        <form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" method="post" class="js-load-comments">
          <input type="hidden" name="postid" value="<?php echo get_the_ID(); ?>">
          <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('capitaine_load_comments'); ?>">
          <input type="hidden" name="action" value="capitaine_load_comments">
          <button class="comments-load-button">Charger les commentaires</button>
        </form>
      
        <ol class="comments"></ol>
      <?php endif; ?>
    </div>

  <?php endwhile; endif; ?>

  <div class="site__navigation">
    <div class="site__navigation__prev">
      <?php previous_post_link( 'Article Précédent<br>%link' ); ?>
    </div>
    <div class="site__navigation__next">
        <?php next_post_link( 'Article Suivant<br>%link' ); ?> 
    </div>
  </div>

<?php get_footer(); ?>