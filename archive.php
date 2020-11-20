<?php get_header(); ?>

  <h1 class="site__heading">Le blog</h1>

  <div class="site__blog">
    <main>
      <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
        <article class="post">
          <h2 class="post__title"><?php the_title(); ?></h2>
          
          <div class="post__thumbnail">
            <?php the_post_thumbnail(); ?>
          </div>

          <p class="post__meta"><?php _e( 'Published on', 'capitaine' ); ?> <?php the_time( get_option( 'date_format' ) ); ?> par <?php the_author(); ?> • <?php comments_number(); ?></p>

          <?php the_excerpt(); ?> 
          
          <p>
            <a href="<?php the_permalink(); ?>" class="post__link"><?php _e( 'Read more', 'capitaine' ); ?></a>
          </p>
        </article>
      <?php endwhile; endif; ?>

      <?php the_posts_pagination(); ?>


      <?php //posts_nav_link(); ?>

      <!-- <div class="site__navigation">
        <div class="site__navigation__prev">
          <?php previous_posts_link( 'Page Précédente' ); ?>
        </div>
        <div class="site__navigation__next">
          <?php next_posts_link( 'Page Suivante' ); ?> 
        </div>
      </div> -->

    </main>

    <aside>
      <?php dynamic_sidebar( 'blog' ); ?>
    </aside>

  </div> 
<?php get_footer(); ?>