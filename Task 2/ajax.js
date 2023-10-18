//this is the only part of code that gets data from the view and sends it to the DB, it's not a proper controller
$('form').on('submit', function(e){
	e.preventDefault();
	$('table tbody').empty();
	$.post( "./model.php", {name: $('input').val()}, function(response) {
		if(response != ''){
			JSON.parse(response).forEach(function(e){
				var row = $('<tr>').appendTo('table tbody');
				for(var attr in e){
					$('<td>'+e[attr]+'</td>').appendTo(row);
				}
			});
		}
	});
});