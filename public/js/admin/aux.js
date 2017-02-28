$(document).ready(function(){
	//console.log();
	$('#persona_identificacion').easyAutocomplete({
		/*data: ["blue", "green", "pink", "red", "yellow"]*/
		//url: $('#data-route').val(),
		url: function(text){
			return $('#data-route').val() + '/' + text;
		},
		getValue: "persona_identificacion",
		list: {
			maxNumberOfElements: 10,
			match: {
				enabled: true
			},
			onChooseEvent: function(){
				//console.log($('#persona_identificacion').getSelectedItemData());
				var data = $('#persona_identificacion').getSelectedItemData();
				$('#persona_ingreso').prop('checked', data.persona_ingreso);
			}
		}
	});
});