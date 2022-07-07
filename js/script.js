(function ($) {
  $(document).ready(function () {
    
    // Chargment des commentaires en Ajax
    $('.js-load-comments').submit(function (e) {
      
      // Empêcher l'envoi classique du formulaire
      e.preventDefault();
      
      // L'URL qui réceptionne les requêtes Ajax
      const ajaxurl = $(this).attr('action');
      
      // Les données de notre formulaire
      const data = {
        action: $(this).find('input[name=action]').val(), // Ne changez pas le nom "action" !
        nonce: $(this).find('input[name=nonce]').val(),
        postId: $(this).find('input[name=postid]').val(),
      }

      // Pour vérifier qu'on a bien récupéré les données
      console.log(ajaxurl);
      console.log(data);

      // Requête Ajax en JS natif via Fetch
      fetch(ajaxurl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'Cache-Control': 'no-cache',
        },
        body: new URLSearchParams(data),
      })
      .then(response => response.json())
      .then(response => {
        console.log(response);
        
        // En cas d'erreur
        if(!response.success) {
          alert(response.data);
          return;
        }
        
        // Et en cas de réussite
        $(this).hide(); // Cacher le formulaire
        $('.comments').html(response.data); // Et afficher le HTML
      });

    });
  });
})(jQuery);
