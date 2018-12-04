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
      
    
      var textarea = this.getElementsByClassName('adtextarea'),
          descriptor = this.getElementsByClassName('addescriptor'), 
          count = this.getElementsByClassName('charCount'),
          desctarget = this.getElementsByClassName('desctarget'),
          target = this.getElementsByClassName('target'),
          timeout = null;      
  
      function handleChange(){
        var newText = textarea[0].value;
        var descriptorText = descriptor[0].value;
        if (newText.length >= 500) {
          $(textarea[0]).parent('p').addClass('toolong');
        } else {
          $(textarea[0]).parent('p').removeClass('toolong');
        }
        do {
          orig = newText;
          newText = newText.replace('[','<a href="#"><strong>').replace(']','</strong></a>');
        } while(orig !== newText);
        newText = newText.replace(/\n/g, "<br/>");
        $(count[0]).html(' '+newText.length+'/500 characters');
        // $(desctarget[0]).html(descriptorText);
        $(target[0]).html(newText);
      }
 
      function eventHandler(){
        if(timeout) clearTimeout(timeout);
        timeout=setTimeout(handleChange, 50);
      }
 
      textarea[0].onkeydown=textarea[0].onkeyup=textarea[0].onclick=eventHandler;
      // descriptor[0].onkeydown=descriptor[0].onkeyup=descriptor[0].onclick=eventHandler;
      handleChange();
      $('.desctarget').text($('#descriptor').val());
      $('#descriptor').change(function() {
        $('.desctarget').text($('#descriptor').val());
      });
      
    })
  }
  
  
  
  $(function(){
    toggleMenu();
    popup();
    initRotater();
    adPreviewInit();
    
    $('#report_select').on('change', function () {
      console.log($(this).val());
      var url = $(this).val();
      if (url) { window.location = url; }
      return false;
    });
          
  })
})(jQuery);
