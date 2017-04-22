(function($){

    // Show or Hide popup
    $('body').change('.nl-dont-show-again', function(){
        if( $('.nl-dont-show-again').is(':checked') ) {
            createCookie('nl_dont_show_again', 1);
        } else {
            eraseCookie('nl_dont_show_again');
        }
    });

    var test_trans = trans('Test JS trans', 'nl');


})(jQuery);



$(window).load(function() {
	showNewsletterPopup();
});

function showNewsletterPopup(){
    if( readCookie('nl_dont_show_again') || !is_home() ) return;
    if($(window).width() + scrollCompensate() >= 768){
        ajax_handler('modules/newsletter/inc/popup.php', {}, 'post', function(response) {
            if( response.content ){
                $.magnificPopup.open({
                    items: {
                        src: response.content,
                        type: 'inline'
                    }
                });     
            }
        });
    }
}

// Submit form and save email
function nl_subscribe(target) {
    event.preventDefault();
    var email = jQuery(target).find('input#nl-email').val();
    ajax_handler('modules/newsletter/inc/subscribe.php', {email: $('#nl-email').val()}, 'post', function(response) {
        if( response.success ){
            message_notif(response.success, {
                type : "success", 
            }); 
        } else {
            message_notif(response.error, {
                type : "danger", 
            });
        }
        $.magnificPopup.close();
    });
}


/**
 * Scroll Compensate
 */
function scrollCompensate(){
    var inner = document.createElement('p');
    inner.style.width = "100%";
    inner.style.height = "200px";
    var outer = document.createElement('div');
    outer.style.position = "absolute";
    outer.style.top = "0px";
    outer.style.left = "0px";
    outer.style.visibility = "hidden";
    outer.style.width = "200px";
    outer.style.height = "150px";
    outer.style.overflow = "hidden";
    outer.appendChild(inner);
    document.body.appendChild(outer);
    var w1 = parseInt(inner.offsetWidth);
    outer.style.overflow = 'scroll';
    var w2 = parseInt(inner.offsetWidth);
    if (w1 == w2) w2 = outer.clientWidth;
    document.body.removeChild(outer);
    return (w1 - w2);
}