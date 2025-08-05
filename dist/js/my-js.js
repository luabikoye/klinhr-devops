$(document).ready(function() {
	
	
	$('#bank_details').hide();
	$('#card_details').hide();
	$('#cod').hide();
	$('#shippingprice').hide();
	$('.payment_method').click(function(){
		
			var payment_method = $("input[type='radio'][name='payment_method']:checked");
			selectedPay = payment_method.val();
			
			if(selectedPay == 'Bank Transfer')
			{
				$('#bank_details').show(50);
				$('#card_details').hide(50);
				$('#cod').hide(50);	
			}
			else if(selectedPay == 'Cash On Delivery')
			{
				$('#cod').show(50);
				$('#bank_details').hide(50);
				$('#card_details').hide(50);	
			}
			else
			{
				$('#card_details').show(50);
				$('#bank_details').hide(50);
				$('#cod').hide(50);	
			}
				
	});
	
	function validate_shipping()
	{
		//On Checkout-1.php paga
		var sub_total = $('#sub_total').val()
		var shipping = $('#shipping_cost').text();
		var sub_total = parseInt(sub_total);
		var shipping = parseInt(shipping);
		var amount = sub_total+shipping;
		
		var total = CurrencyFormatted(amount);
			
		$('#total_cost').text(total);
	}
	
	validate_shipping();
	
	$("#state").change(function(){
			
			
			$('#shippingprice').show(50);
			$('#show_state').text($(this).val());
			
			
			if ($(this).val() == 'FCT' || $(this).val() == 'Rivers' || $(this).val() == 'Delta' || $(this).val() == 'Oyo' || $(this).val() == 'Ogun' || $(this).val() == 'Enugu' || $(this).val() == 'Ondo' || $(this).val() == 'Ekiti' || $(this).val() == 'Osun' || $(this).val() == 'Kwara' || $(this).val() == 'Edo')
			{
				$('#shipping_cost').text('1500');
				$('#shippingcost').text('1500');
				
			}
			else if($(this).val() == 'Lagos')
			{
				$('#shipping_cost').text('1000');
				$('#shippingcost').text('1000');
				
			}
			else
			{
				$('#shipping_cost').text('2000');
				$('#shippingcost').text('2000');
				
			}
			
			//recalculate shipping 
			validate_shipping();
	});
	
	
		$(".fancybox").fancybox();
	});
	
	
	function CurrencyFormatted(amount)
{
    var i = parseFloat(amount);
    if(isNaN(i)) { i = 0.00; }
    var minus = '';
    if(i < 0) { minus = '-'; }
    i = Math.abs(i);
    i = parseInt((i + .005) * 100);
    i = i / 100;
    s = new String(i);
    if(s.indexOf('.') < 0) { s += '.00'; }
    if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
    s = minus + s;
    return s;
}