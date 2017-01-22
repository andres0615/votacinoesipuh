$().ready(function(){

  $('#form').validate({
    errorClass: "has-error",
    rules: {
      producto_nombre: "required",
      producto_precio: {
        required: true,
        number: true
      },
      producto_descripcion1: "required"
    },
    messages: {
      producto_nombre: "Por favor ingrese el nombre",
      producto_precio: {
        required: "Por favor ingresar el precio",
        number: "El precio debe ser numerico"
      },
      producto_descripcion1: "Por favor ingrese la descripcion"
    },
    showErrors: function(errorMap, errorList){
      //console.log(errorList);

      var validator = this;

      $.each(errorList,function(index, value){
        if($.isPlainObject(value)){
          var input = $(value.element);
          var msg = value.message;
          var div = input.parents('.form-group').first();
          div.addClass('has-warning');

          //console.log(value.message);

          input.popover('destroy');

          //popover
          input.popover({
            content: msg,
            placement: "top",
            animation: false,
            trigger: "manual"
          });

          input.popover('show');
        }
      });
    },
    onfocusout: function(element, event){
      var el = $(element);
      var div = el.parents('.form-group').first();

      if(this.numberOfInvalids() <= 0){
        event.preventDefault();
        div.removeClass('has-warning');
        el.popover('destroy');
      } else {
        if(el.valid() == true){
          el.removeClass('has-warning');
          el.popover('destroy');
        }
      }
    },
    onkeyup: function(element, event){

      var el = $(element);
      var div = el.parents('.form-group').first();

      if(this.numberOfInvalids() <= 0){
        div.removeClass('has-warning');
        el.popover('destroy');
      } else {
        if(el.valid() == true){
          div.removeClass('has-warning');
          el.popover('destroy');
        }
      }
    }
  });

});

