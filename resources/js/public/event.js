// Event
$(document).ready(function(){

    $('input[type=radio]').click(function(){
        let $val = $(this).val();
        if($val === 'інше'){
            $('#if_other input').attr('required', true);
            $('#if_other').animate({
                height: "show"
            });
        }else{
            $('#if_other input').attr('required', false);
            $('#if_other').animate({
                height: "hide"
            });
        }
    });

});
