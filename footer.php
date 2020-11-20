  </main>

  <footer class="site__footer">
  <?php 
    wp_nav_menu( 
          array( 
              'theme_location' => 'footer', 
              'container' => 'ul', // afin d'éviter d'avoir une div autour 
              'menu_class' => 'site__header__menu', // ma classe personnalisée 
          ) 
      ); 
  ?>
  </footer>
  
  <?php wp_footer(); ?>

</body>
</html>