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
  

 
  /* setupUpdater will be called once, on page load.
   */
 
  function setupUpdater(){
    var input=document.getElementById('adtextarea')
      , count=document.getElementById('charCount')
      , orig=document.getElementById('original')
    , timeout=null;
  
    /* handleChange is called 50ms after the user stops 
     typing. */
    function handleChange(){
     var newText=input.value;
     if (newText.length >= 400) {
       $(input).parent('p').addClass('toolong');
     } else {
       $(input).parent('p').removeClass('toolong');
     }
     newText = newText.replace('[','<a href="#">').replace(']','</a>');
     newText = newText.replace(/\n/g, "<br/>");
     $(count).html(' '+newText.length+'/500 characters');
     $(orig).html(newText);
     
    }
 
    /* eventHandler is called on keyboard and mouse events.
     If there is a pending timeout, it cancels it.
     It sets a timeout to call handleChange in 50ms. */
    function eventHandler(){
     if(timeout) clearTimeout(timeout);
     timeout=setTimeout(handleChange, 50);
    }
 
    input.onkeydown=input.onkeyup=input.onclick=eventHandler;
    handleChange();
  }
 
  
  
  
  $(function(){
    toggleMenu();
    popup();
    initRotater();
    setupUpdater();
    
    $('#report_select').on('change', function () {
      console.log($(this).val());
      var url = $(this).val();
      if (url) { window.location = url; }
      return false;
    });
          
  })
})(jQuery);
