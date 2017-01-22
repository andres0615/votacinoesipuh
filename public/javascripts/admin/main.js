

$(document).ready(function(){

  $('#delete-modal').on('show.bs.modal', function (e){
    //e.preventDefault();

    var button = $(e.relatedTarget);
    var modal = $(this);

    var si = modal.find('#confirmar-eliminar-si');
    var no = modal.find('#confirmar-eliminar-no');

    si.attr('action', button.data('href'));

    no.click(function(e){
      modal.modal('hide');
    });

    //Eliminar masivo

    if(button.hasClass('btn-eliminar-masivo')){
      var records_chk = $('.record-check').toArray();
      var inputs_html = "";
      var checkeds = 0;

      $('#mensaje-confirmar-eliminar').html('Desea eliminar los registros seleccionados ?');

      $.each(records_chk, function(index, value){
        var chk = $(value);
        if(chk.prop('checked')){
          inputs_html += '<input type="hidden" name="ids[]" value="' + chk.data('codigo') + '" />';
          checkeds++;
        }
      });
      if(checkeds > 0){
        $('#adittional-inputs').html(inputs_html);
      } else {
        e.preventDefault();
        button.popover({
          content: 'Seleccione los registros que desea eliminar.',
          trigger: 'manual',
          animation: false,
          placement: "top"
        });
        button.popover('show');
        button.focusout(function(event){
          button.popover('destroy');
        });
      }
    } else {
      var inputs_html = '<input type="hidden" name="_method" value="delete" />';
      $('#adittional-inputs').html(inputs_html);
      $('#mensaje-confirmar-eliminar').html('Desea eliminar este registro?');
    }

  });

  $.fn.moduloTarget = function(href){
    $('#ir-modulo').attr('href', href);
  };

  $.fn.moduloTarget($('#modulo-select').val());

  $('#modulo-select').change(function(e){
    $.fn.moduloTarget($(this).val());
  });

  $('#chk-all-records').change(function(e){
    var records_chk = $('.record-check').toArray();
    if($(this).prop('checked')){
      $.fn.changeChkChecked(records_chk, true);
    } else {
      $.fn.changeChkChecked(records_chk, false);
    }
  });

  $.fn.changeChkChecked = function(records_chk, checked){
    $.each(records_chk, function(index, value){
      $(value).prop('checked', checked);
    });
  }

});