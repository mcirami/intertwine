jQuery(document).ready(function($) {

 /*   var currentURL = window.location.href;*/

    var redirectLink;

    if ($('.nav-next a').attr('href') != null) {
        redirectLink = $('.nav-next a').attr('href');
        createCookie('redirectLink', redirectLink, 1);
    } else if ($('.nav-previous a').attr('href') != null) {
        redirectLink = $('.nav-previous a').attr('href');
        createCookie('redirectLink', redirectLink, 1);
    }

    function createCookie(name, value, days) {
        var expires;
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        }
        else {
            expires = "";
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }


/*    if (window.location.href.indexOf("trashed") > -1) {
        var redirectTo = getCookie("redirectLink");
        window.location.href = redirectTo;
    }*/

/*    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length,c.length);
            }
        }
        return cname;
    }*/

});
