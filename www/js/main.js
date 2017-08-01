$(function(){
	//Bootstrap tooltip init
	$('[data-toggle="tooltip"]').tooltip(); 
	
	$('[data-check-all]').click(function (e) {
		e.preventDefault();
		
		var selector = $(this).attr('data-check-all');
		$(selector).each(function () {
			$(this).prop('checked', !$(this).prop('checked'));
		});
	});	
	
	$.fn.select2.defaults.set('theme', 'bootstrap');
	$('.select2-select-ajax').each(function(){
		$(this).select2({
			ajax: {
				dataType: 'json',
				delay: 50,
				processResults: function (data) {
					return {
						results: $.map( data, function (text, key) {
							return {
								text: text,
								id: key
							}
						})
					};
				},
				cache: true
			},
			escapeMarkup: function( markup ){
				return markup; //Disable escaping of HTML
			},
			templateResult: function( item ){ 
				return item.text ; 
			},
			minimumInputLength: 3
		});
	});
});
