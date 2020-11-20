<div id="commentaires" class="comments">
  <?php if ( have_comments() ) : ?>
    <h2 class="comments__title">
      <?php echo get_comments_number(); ?> Commentaire(s)
    </h2>
    
    <ol class="comment__list">
      <?php
        // La fonction qui liste les commentaires
        wp_list_comments( array(
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 74,
        ) );
      ?>
    </ol>
        
    <?php if ( ! comments_open() && get_comments_number() ) : ?>
      <p class="comments__none">Il n'y a pas de commentaires pour le moment. Soyez le premier à participer !</p>
    <?php endif; ?>
  <?php endif; ?>
 
  <?php comment_form(); // Le formulaire d'ajout de commentaire ?>
</div>