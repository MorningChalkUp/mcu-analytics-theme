(function($){
  
  function toggleMenu(){
    $('#menubtn').click(function(e){
      e.preventDefault();
      $('#menu').toggleClass('open');
      $(this).find('[data-fa-i2svg]').toggleClass('fa-chevron-down').toggleClass('fa-times');
      return false;
    });
  }
  
  // Inline Modal
  function popup() {
    if ( jQuery('.popup').length ) {
      jQuery('.popup').magnificPopup({
        type: 'inline',
        midClick: true
      });
    }
  }
  
	function initRotater(){
		$('#panels .panel').first().addClass('active');
    $('#tabs .tab').first().addClass('active');
		rotater();
	}
	function rotater(){
		$('#tabs').on('click', '.tab', function(e){
			e.preventDefault();
			var target = $(this).attr('href');
			$('#panels .panel.active').removeClass('active');
			$('#tabs .tab.active').removeClass('active');
			$(this).addClass('active');
			$(target).addClass('active');
		})
	}
  
  $(function(){
    toggleMenu();
    popup();
    initRotater();
    
    $('#report_select').on('change', function () {
      console.log($(this).val());
      var url = $(this).val();
      if (url) { window.location = url; }
      return false;
    });
          
  })
})(jQuery);
