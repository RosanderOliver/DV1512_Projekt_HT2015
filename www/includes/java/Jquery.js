
var pageSize = function() {
    $("#page").height($(document).height() - 125);
}

$(function() {

  // Page
  pageSize();
  $(window).resize(pageSize());

  // Menu
  $("#menu ul li ul").addClass( "submenu" );
  $(".submenu li").hide();
  $(".submenu").parent().hover(function () {
    $(this).find("li").stop().show("slow");
  }, function () {
    $(this).find("li").stop().hide("slow");
  });

});
