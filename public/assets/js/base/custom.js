
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