(function($){
  
  $(function(){

    console.log('load');
    $('#report_select').on('change', function () {
      console.log($(this).val());
      var url = $(this).val();
      if (url) { window.location = url; }
      return false;
    });
          
  })
})(jQuery);
