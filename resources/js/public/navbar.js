// Navbar
$(document).ready(function(){

    $('#main_nav').scrollToFixed({
        fixed : function(){
            $('#navbar').addClass('menu-fixed');
            // $('.navbar-brand').show();
        },
        postFixed : function() {
            // $('.navbar-brand').hide();
            $('#navbar').removeClass('menu-fixed');
        }
    });

});
