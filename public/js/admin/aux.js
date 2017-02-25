$(document).ready(function(){
	console.log();
	$('#persona_identificacion').easyAutocomplete({
		/*data: ["blue", "green", "pink", "red", "yellow"]*/
		url: $('#data-route').val()
	});
});