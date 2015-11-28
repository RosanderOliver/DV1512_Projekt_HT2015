
$(function() {

    // Menu
    $("#menu ul li ul").addClass( "submenu" );
    $('.submenu li').hide();
    $('.submenu').parent().hover(function () {
      $(this).find("li").stop().show("slow");
    }, function () {
      $(this).find("li").stop().hide("slow");
    });

});
