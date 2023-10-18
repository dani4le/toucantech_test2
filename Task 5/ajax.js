//part of code that populates the fields of the view that needs data from the model, it runs twice: one time for the schools, another for the countries
$(window).on('load', function(){
	$('#search select').each(function(i, elem){
		const name = elem.name;
		$.post('./controller.php', {populate: name}, function(response){
			if(response != ''){
				JSON.parse(response).forEach(function(e){
					var id, text;
					if(name == 'schools'){
						//elements to create and append to the view specific to schools data
						id = e.id;
						text = e.Name;
						$('fieldset').append('<label class="d-block"><input type="checkbox" class="form-check-input" value="' + id + '"><span  class="form-check-label">' + text + '</span></label>');
					}
					else{
						id = text = e.Country;
					}
					//element created and displayed both for schools and countries
					$('select[name=' + name + ']').append('<option value="' + id + '">' + text + '</option>');
				});
			}
		});
	});
});

//when submitting a new member, prevent the form to load a new page and gather data to forward it with ajax
$('#newMember').on('submit', function(e){
	e.preventDefault();
	var data = {};
	$(e.target).find('[name]').each(function(i, elem){
		element = $(elem);
		data[element.attr('name')] = element.val();
	});
	$.post('./controller.php', data, function(response){
		if(response == 1){
			//if everything went well, clear the form for a new submission
			e.target.reset();
		}
	});
});

//ajax call to search the DB by school or country
$('#search select').on('change', function(e){
	$('table tbody').empty();
	$.post('./controller.php', {type:e.target.name, param: e.target.value}, function(response){
		if(response != ''){
			JSON.parse(response).forEach(function(e){
				var row = $('<tr>').appendTo('table tbody');
				for(var attr in e){
					$('<td>' + e[attr] + '</td>').appendTo(row);
				}
			});
		}
	});
});