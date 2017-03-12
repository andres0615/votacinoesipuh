$(document).ready(function(){
	$('#confirm-modal').on('show.bs.modal', function (e){
    //e.preventDefault();

	    var button = $(e.relatedTarget);
	    var modal = $(this);
	    var input = $('input.candidato_input:checked');
	    var candidato_nombre = input.next().text().trim();

	    var si = modal.find('#confirmar-si');
	    var no = modal.find('#confirmar-no');

	    //si.attr('action', button.data('href'));

	    si.click(function(e){
	    	$('#form').submit();
	    });

	    no.click(function(e){
	      modal.modal('hide');
	    });

	  if(input.length > 0){
	  	$('#mensaje-confirmar-eliminar').html('Desea votar por ' + candidato_nombre + ' ?');
	  	$('#confirm-buttons').css('display','block');
	  } else {
	  	$('#mensaje-confirmar-eliminar').html('Por favor seleccione un candidato para votar');
	  	$('#confirm-buttons').css('display','none');
	  }

  });
});