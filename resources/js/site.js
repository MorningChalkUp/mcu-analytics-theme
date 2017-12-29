var click = ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) ? "touchstart" : "click";

(function($){
  function embedContainer() {
    jQuery('iframe[src*="youtube"]').each(function() {
      var $video = $(this);
      if ( ! $video.parent().hasClass('embed-container') ) $video.wrap("<div class='embed-container'></div>");
    });
  }
  
  $(function(){
    embedContainer();
  })
})(jQuery);
