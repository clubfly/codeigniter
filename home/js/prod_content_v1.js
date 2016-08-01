$(function(){
  $(".prod_bn").slick({
    dots: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false
  });
  $(".prod_info_wrap").accordion({
    collapsible: true,
    active : false,
    heightStyle: "content"
  });
});
