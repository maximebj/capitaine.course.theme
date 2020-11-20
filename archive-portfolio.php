<?php get_header(); ?>

  <h1 class="site__heading"><?php post_type_archive_title(); ?></h1>

  <main class="site__portfolio">
    <?php 
      if( have_posts() ) : while( have_posts() ) : the_post();

      $url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'post-thumbnail' );
    ?>
      <div class="project" style='background-image: url("<?php echo $url[0]; ?>")'>
        <h2 class="project__title">
          <a href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
          </a>
        </h2>
        <p class="project__type">
          <?php the_terms( get_the_ID() , 'type-projets' ); ?>
        </p>
      </div>
    <?php endwhile; endif; ?>
</main> 

<?php the_posts_pagination(); ?>
<?php get_footer(); ?>