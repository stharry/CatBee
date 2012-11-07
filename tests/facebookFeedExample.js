$(document).ready(function () {

    //alert(1);
    $("#fbcTest").click(function() {

        sendFacebookMessage(null);
    });

    //alert(2);
    $("#feedTest").click(function () {

            //$('#fbcTest').trigger('click');
            sendFacebookMessage(null);

        //sendFacebookMessage(catBeeResult);

    });
});



function callback2(response) {
    document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
}

function sendFacebookMessage(data)
{
   // alert(3);
    try
    {
    //window.open ("http://www.javascript-coder.com","mywindow");

    FB.init({appId: "369374193139831", status: true, cookie: true, xfbml: true});

    var obj = {
        method: 'feed',
        display: 'popup',
        link: 'http://www.TribZi.com/adapters/demo/api/?act=welcome&pdl=1&shr=facebook',
        picture: 'http://tribzidemo.azurewebsites.net/CatBee/adapters/demo/res/train.jpg',
        name: 'Hi, I shared a great deal for you...:)',
        caption: 'TribZi Deal',
        description: 'Press on link below to start shopping',
        redirect_uri: 'http://tribzidemo.azurewebsites.net/CatBee/components/share/facebook/facebookLogin.php'
    };


    FB.ui(obj, callback2);
    }
    catch (e)
    {
        alert(e);
    }
   // alert('after fbc');

 //   alert(5);

}
