<?php get_header(); ?>

  <h1>En direct du blog</h1>

  <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
       
    <div class="post">

      <h2>
        <a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
        </a>
      </h2>

      <?php the_post_thumbnail(); ?>
      
      <?php the_excerpt(); ?>
      
      <p>Publié le <?php the_date(); ?> par <?php the_author(); ?> / <?php comments_number(); ?></p>
    </div>

  <?php endwhile; endif; ?>

<?php get_footer(); ?>