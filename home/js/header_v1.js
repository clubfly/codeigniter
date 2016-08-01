$(function() {
  $(".gotop_icon").hide()     
  $(window).scroll(function(){
    if($(this).scrollTop()>1){
      $(".gotop_icon").fadeIn();
    } else {
      $(".gotop_icon").fadeOut();
    }
  });   
  $(".gotop_icon a").click(function(){
    $("html,body").animate({scrollTop:0},400);
    return false;  
  });
  $( ".hamburger_type_item" ).accordion({
    collapsible: true,
    active : false,
    heightStyle: "content"
  });
  $(".hamburger_list_wrap").hide();
  $(".hamburger_icon").click(function() {  
    $(".hamburger_list_wrap" ).toggle( "slide", 300 );
    $(".search_wrap").hide();
  }); 
  $(".search_wrap").hide();
  $(".search_icon").click(function() {
    $(".search_wrap" ).toggle( "blind", 300 );
    $(".hamburger_list_wrap").hide();
  });  
  $(".menu_icon").click(function(){
    $(".menu_icon a").removeClass("active");
    $(this).children(".menu_icon a").addClass("active");
  });
  $(".search_btn").click(function(){
    var search = $.trim($("#search_value").val());
    if (search != ""){
      top.location.href = "/search/"+search;
    } else {
      alert("請輸入關鍵字！");
    }
  });
  $(".buy_dialog_wrap").hide();
  $(".buy_buy").click(function() {
    var prod_id = $(this).attr("id");
    $.ajax({
      cache: false,
      method : "GET",
      url: "/models/"+prod_id,
      dataType : "html"
    }).done(function(msg) {
      $(".buy_dialog_wrap").html("");
      $(".buy_dialog_wrap").html(msg);
      setTimeout(
        $(".buy_dialog_wrap").dialog({
          width:'100%',
          modal: true,
          title: "加入購物車",
          draggable: false
        }),1500);
      setTimeout($(".buy_dialog_wrap").dialog("moveToTop"),2000);
    });
    $(".search_wrap").hide();
    $(".hamburger_list_wrap").hide();
  });
});
