<script>
window.fbAsyncInit = function() {
    FB.init({
        appId: '166495106822437',
        status: true,
        cookie: true,
        xfbml: true,
        oauth: true
    });
};

function facebookLogin() {
    FB.login(function(response) {
        if (response.authResponse) {
            console.log('Authenticated!');
            // location.reload(); //or do whatever you want
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    },
    {
        scope: 'email,user_checkins'
    });
}

(function(d) {
    var js,
    id = 'facebook-jssdk';
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement('script');
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
} (document));
</script>





<div id='fb-root></div><!-- required for SDK initialization -->
<a id='fb-login' href='#' onclick='facebookLogin()'>Login with Facebook</a>