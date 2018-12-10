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
  
 
  function adPreviewInit(){
    $('.panel').each(function(){
      
      var target = $(this).find('.preview .target'),
          desctarget = $(this).find('.preview .desctarget'),
          timeout = null;
      
      // Trigger Preview 
      $(this).find('.adtextarea').each(function(){
        $(this).focus(function(){
          handleChange(this);
        })
        $(this).on('input', function(){
          handleChange(this);
        })
      })
      handleChange($(this).find('.adtextarea')[0]);
      
      function handleChange(adtextarea){
        var newText = adtextarea.value,
            previewLabel = $(adtextarea).data('label');
        if (newText.length >= 500) {
          $(adtextarea).parent('p').addClass('toolong');
        } else {
          $(adtextarea).parent('p').removeClass('toolong');
        }
        do {
          orig = newText;
          newText = newText.replace('[','<a href="#"><strong>').replace(']','</strong></a>');
        } while(orig !== newText);
        newText = newText.replace(/\n/g, "<br/>");
        $(adtextarea).parent('p').find('.charCount').html(' '+newText.length+'/500 characters');
        $(target).html(newText);
        
        $('.preview-label').html(previewLabel);
      }
      
      $(this).find('.desctarget').text($(this).find('.addescriptor').val());
      $(this).find('.addescriptor').change(function() {
        desctarget.text($(this).val());
      });
      
    })
  }
  
  
  
  $(function(){
    toggleMenu();
    popup();
    initRotater();
    adPreviewInit();
    
    $('#report_select').on('change', function () {
      var url = $(this).val();
      if (url) { window.location = url; }
      return false;
    });
          
  })
})(jQuery);
