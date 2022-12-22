// CV

$(document).ready(function(){

    $('.social-checkbox').click(function(){
        if($(this).prop('checked') === false){
            $('input[name='+this.id+']').hide();
        }else{
            $('input[name='+this.id+']').show();
        }
    });

});
