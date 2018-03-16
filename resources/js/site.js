(function($){
  
  function toggleMenu(){
    $('#menubtn').click(function(e){
      e.preventDefault();
      $('#menu').toggleClass('open');
      $(this).find('[data-fa-i2svg]').toggleClass('fa-chevron-down').toggleClass('fa-times');
      return false;
    });
  }
  
  $(function(){
    toggleMenu()
    
    $('#report_select').on('change', function () {
      console.log($(this).val());
      var url = $(this).val();
      if (url) { window.location = url; }
      return false;
    });
          
  })
})(jQuery);
