import './styles/menu.css';

const $ = require('jquery');

$(document).ready(function () {
  let touch = $('#resp-menu');
  let menu = $('.menu');

  $(touch).on('click', function (e) {
    e.preventDefault();
    menu.slideToggle();
  });

  $(window).resize(function () {
    var w = $(window).width();
    if (w > 767 && menu.is(':hidden')) {
      menu.removeAttr('style');
    }
  });

});
