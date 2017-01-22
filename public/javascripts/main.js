/**
 * Created by andres on 11/09/16.
 */

$(document).ready(function(){

  /*$('.dropdown').hover(function(){
    $('.dropdown-toggle', this).trigger('click');
  });*/

  /*$('nav .dropdown').hover(function(){
    var ul = $(this).find('.dropdown-menu');
    ul.stop();
    ul.fadeIn();
  }, function(){
    var ul = $(this).find('.dropdown-menu');
    ul.stop();
    ul.fadeOut();
  });*/

  $('.navbar [data-toggle="dropdown"]').bootstrapDropdownHover({
    clickBehavior: 'disable',
    hideTimeout: 0
  });

});