
$(function(){

    $('.t-header-toggler').on('click',function(){
        $(this).toggleClass('sidebar-toggled');

        if($(this).hasClass('sidebar-toggled')){
            $('.t-header-toggler .icon').removeClass('mdi-menu');
            $('.t-header-toggler .icon').addClass('mdi-arrow-left');
        }else{
            $('.t-header-toggler .icon').removeClass('mdi-arrow-left');
            $('.t-header-toggler .icon').addClass('mdi-menu');
        }
        
        $('body').toggleClass('sidebar-minimized');
        //console.log('toggled');
    });

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "inherit" );
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css( "overflow", "auto" );
    })
});

// @@ Override theme function from template.js
// CHECK FOR CURRENT PAGE AND ADDS AN ACTIVE CLASS FOR TO THE ACTIVE LINK
var base_url = $('meta[name="base-url"]').attr('content');console.log(base_url);
var part = location.href.replace(base_url, '');
var segments = location.href.replace(base_url, '').split('/').splice(1);
var current = segments[0];
$('.navigation-menu li a', TemplateSidebar).each(function () {
  var $this = $(this);

  $(this).parents('li').removeClass('active');
  $(this).closest('.collapse').removeClass('show');

    if ($this.attr('href').indexOf(part) !== -1) {
        $(this).parents('li').last().addClass('active');
        if ($(this).parents('.navigation-submenu').length) {
          $(this).addClass('active');
        }
    }
    if ($this.attr('href').indexOf(current) !== -1) {
        $(this).parents('li').last().addClass('active');
      if (current !== "index.html") {
        $(this).parents('li').last().find("a").attr("aria-expanded", "true");
        if ($(this).parents('.navigation-submenu').length) {
          $(this).closest('.collapse').addClass('show');
        }
      }
    }
  
});