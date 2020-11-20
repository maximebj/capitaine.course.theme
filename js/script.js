(function ($) {
  $(document).ready(function () {
    
    // Load comments
    $('.comments-load-button').click(function () {
      
      var post_id = $('.comments').attr('data-post-id');
      
      $.ajax({
        url: ajaxurl,
        type: "POST",
        data: {
          'action': 'load_comments',
          'post_id': post_id
        }
      }).done(function (response) {
        
        $('.comments').html(response); // Afficher le HTML
        $('.comments-load-button').hide(); // Cacher le bouton
      });

    });

  });
})(jQuery);
