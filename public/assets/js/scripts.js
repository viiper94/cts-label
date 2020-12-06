$(document).ready(function(){
    $('#main_nav').scrollToFixed({
        fixed : function(){$('#nav').addClass('menu-fixed');$('.navbar-brand').show()},
        postFixed : function() {$('.navbar-brand').hide();$('#nav').removeClass('menu-fixed')}
    });
    var hash = window.location.hash;
    if ($(hash + '-menu').length > 0) {
        $('#about-menu').removeClass('active');
        $(hash + '-menu').addClass('active');
    }

    $('#contacts-menu,#demo-menu').on('click',function(){
        $('#about-menu').removeClass('active');
        $('#contacts-menu').removeClass('active');
        $('#demo-menu').removeClass('active');
        $(this).addClass('active');
    })
    $('a[href^="#"]').on('click', function(event) {

        var target = $( $(this).attr('href') );

        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 60
            }, 500);
        }

    });
	 $('.course-button').on('click', function(event) {

        var target = $( '#prices' );

        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 60
            }, 500);
        }

    });
    $('.switch-btn').click(function(){
        /*var id = $(this).attr('toggle');
        console.log(id);
        $('.switch-btn').each(function(){
            $(this).removeClass('active');
        })
        $(this).addClass('active');
        $('#ru,#en,#ua').hide();
        $('#'+id).show();*/
        setCookie('lang', $(this).data('lang'), {
            expires : 3600 * 24 * 365,
            path : '/'
        });
    });
    $('#collapsable').ajaxForm({
        url : '/subscribe/',
        type : 'POST',
        dataType : 'json',
        success : function(response) {
            if (response.status == 'ok') {
                alert(response.text);
            } else {
                if (response.errors.length > 0) {
                    alert(response.errors.join("\n"));
                }
            }
            $('#collapsable')[0].reset();

        }
    });

	$('.share-share').on( "mouseout", function(){
		var timer = setTimeout(function(){
			if(!$('.share-share').is(':hover') && !$('.share-share').hasClass('collapsed')){
				$('.share-share').click();
			}
		}, 1500);
		$('.share-share').on( "mouseover", function(){
			clearTimeout(timer);
		});
	});

	$('.social-checkbox').click(function(){
	    if($(this).prop('checked') === false){
            $('input[name='+$(this).data('target')+']').hide();
        }else{
            $('input[name='+$(this).data('target')+']').show();
        }
    });

});

function shareSocial(social) {
	var title = $('.release-title').html();
	var description = $('.content-ru').html();
	var img = $('.release-image').attr('src');
    switch (social) {
        case 'fb' :
            var url = 'https://www.facebook.com/sharer.php?u='+window.location.href+'&picture=http://cts-label.com'+img+'&description='+description;
            break;
        case 'google' :
            var url = 'https://plus.google.com/share?url='+window.location.href;
            break;
        case 'twitter' :
            var url = 'http://twitter.com/intent/tweet?text=@CTS_RECORDS+'+title+'%0A&url='+window.location.href+'&hashtags=CTS';
            break;
        case 'pin' :
            var url = 'http://pinterest.com/pin/create/bookmarklet/?&url='+window.location.href+'&is_video=false';
            break;
		case 'vk' :
			var url = 'http://vk.com/share.php?description='+description+'&url='+window.location.href+'&image=http://cts-label.com'+img;
            break;
		case 'lj' :
			var url = 'http://www.livejournal.com/update.bml?event=<a href='+window.location.href+'><img src=http://cts-label.com'+img+'></img></a>%0A'+description+'&subject='+title;
            break;
		case 'mail' :
			var url = 'mailto:?Subject='+title+'&body='+window.location.href;
            break;
    }
    window.open(url,'share-dialog',"resizable=0,width=626,height=436,scrollbars=yes");
}

function setCookie(name, value, options) {
    options = options || {};

    var expires = options.expires;

    if (typeof expires == "number" && expires) {
        var d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }

    value = encodeURIComponent(value);

    var updatedCookie = name + "=" + value;

    for (var propName in options) {
        updatedCookie += "; " + propName;
        var propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }

    document.cookie = updatedCookie;
}
