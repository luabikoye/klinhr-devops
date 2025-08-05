<script>
	$(document).ready(function() {
		$('#locationLabel1').change(function() {
			var selectedValue = $(this).val();

			$.ajax({
				url: 'check_data.php', // Replace with your server-side script to check data in the database
				method: 'POST',
				data: {
					value: selectedValue
				},
				success: function(response) {
					if (response !== '') {
						$('#list_courses').html(response);
					} else {
						$('#yourInput').val('');
					}
				},
				error: function() {
					console.log('Error occurred during AJAX request.');
				}
			});
		});
	});
</script>