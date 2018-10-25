(function($){
  $('.purchase-checkbox').change(function() {
    if ($(this).prop('checked')) {
      html = `
        <div class="cart-item ${$(this).data('id')}" data-item_total="${$(this).data('price')}">
          <h4>${$(this).data('range')} <span class="price">$${$(this).data('price')}</span></h4>
          <div class="inside">
            <p>Notes here</p>
            <h5>Add-ons:</h5>
            <ul class="add-ons">
              <li><input type="checkbox" data-id="${$(this).data('id')}" class="facebook" data-price="250" id="facebook-${$(this).data('id')}"/> <label for="facebook-${$(this).data('id')}">Facebook Retargeting</label> <span class="price">+ $250</span></li>
              <li><input type="checkbox" data-id="${$(this).data('id')}" class="ab" data-price="250" id="ab-${$(this).data('id')}"/> <label for="ab-${$(this).data('id')}">A/B Testing</label> <span class="price">+ $250</span></li>
              <li><input type="checkbox" data-id="${$(this).data('id')}" class="wewrite" data-price="250" id="wewrite-${$(this).data('id')}"/> <label for="wewrite-${$(this).data('id')}">We Write Your Ads</label> <span class="price">+ $250</span></li>
            </ul>
          </div>
        </div>`
      $('#cart #list').append(html);
      $('#checkoutButton').data('total', $('#checkoutButton').data('total') + $(this).data('price'));
      $('.total #amt').text($('#checkoutButton').data('total'));
    } else {
      remove_id = $(this).data('id');
      $('.'+remove_id).remove();
      $('#checkoutButton').data('total', $('#checkoutButton').data('total') - $(this).data('price'));
      $('.total #amt').text($('#checkoutButton').data('total'));
    }
  });
})(jQuery);
$=jQuery;
$('input.facebook').change(function() {
  console.log('fb');
  if ($(this).prop('checked')) {
    $('#checkoutButton').data('total', $('#checkoutButton').data('total') + $(this).data('price'));
    $('.total #amt').text($('#checkoutButton').data('total'));
  }
});