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
    alert('wow');
}

function sendFacebookMessage(data)
{
   // alert(3);
    try
    {
    //window.open ("http://www.javascript-coder.com","mywindow");

    FB.init({appId: "369374193139831",
        status: false,
        cookie: false});

    var obj = {
        app_id:'369374193139831',
        api_key: '369374193139831',
        user_message_prompt: 'asdasdasdsa',
        sdk:'joey',
        method: 'feed',
        display: 'popup',
        link: 'http://www.TribZi.com/adapters/demo/api/?act=welcome&pdl=1&shr=facebook',
        picture: 'http://tribzidemo.azurewebsites.net/CatBee/adapters/demo/res/train.jpg',
        name: 'Hi, I shared a great deal for you...:)',
        caption: 'TribZi Deal',
        redirect_uri: 'http://tribzidemo.azurewebsites.net/CatBee/components/share/facebook/facebookLogin.php',

        description: 'Press on link below to start shopping'
    };


    FB.ui(obj, function(response) {
        if (response && response.post_id) {
            alert('Post was published.' + response.post_id);
        } else {
            alert('Post was not published.');
        }
    });
    }
    catch (e)
    {
        alert(e);
    }
   // alert('after fbc');

 //   alert(5);

}
