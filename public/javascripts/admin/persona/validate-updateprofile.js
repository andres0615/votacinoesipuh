$().ready(function(){

  var validate = $('#form').validate({
    //debug: true,
    errorClass: "has-error",
    rules: {
    },
    messages: {
      persona_codigo_alterno: "Este campo es requerido",
      persona_codigo_alterno_confirm: "Este campo es requerido"
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

//console.log(validate.settings);

$('#persona_codigo_alterno').change(function(){

  var value = $(this).val();

  if(value.length > 0){
    $.fn.validatePasswords();
  } else {
    $.fn.dontValidatePasswords();
  }

});

$('#persona_codigo_alterno_confirm').change(function(){

  var value = $(this).val();

  if(value.length > 0){
    $.fn.validatePasswords();
  } else {
    $.fn.dontValidatePasswords();
  }

});

$.fn.validatePasswords = function(){
  validate.settings.rules = {
    persona_codigo_alterno: "required",
    persona_codigo_alterno_confirm: "required"
  };
};

$.fn.dontValidatePasswords = function(){
  validate.settings.rules = {};
};

});

