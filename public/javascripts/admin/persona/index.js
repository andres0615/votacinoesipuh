$(document).ready(function(){
	$('.persona_candidato').change(function(e){
		$.fn.activarCandidato($(this));		
	});

	$.fn.activarCandidato = function(el){
		var persona_id = el.data('persona-id');
		var candidato = el.prop('checked');
		var url = el.data('url');
		var token = el.data('token');

		var dataObject = {};
		dataObject["persona_id"] = persona_id;
		dataObject["candidato"] = candidato;

		$.ajax({
	        type: "POST",
	        url: url,
	        data: dataObject,
	        headers: {
	            'X-CSRF-TOKEN': token
	        }/*,
	        success: function(data) {
	              console.log(data);
	        }*/
	    });

	};

});