$().ready(function(){

  $('#form').validate({
    //debug: true,
    errorClass: "has-error",
    rules: {
      name: "required",
      email: {
        required: true,
        email: true
      },
      password: "required"
    },
    messages: {
      name: "Por favor ingrese el nombre",
      email: {
        required: "Por favor ingrese su correo",
        email: "Este email no es valido"
      },
      password: "Por favor ingrese la contraseña"
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

