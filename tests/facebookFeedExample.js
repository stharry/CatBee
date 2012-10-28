$(document).ready(function () {

    $("#fbcTest").click(function() {

        sendFacebookMessage(catBeeResult);
    });

    $("#feedTest").click(function () {

        var data = createCatBeeFillShareRequest();

        proceedCatBeeShareJsonRequest(data, function(){

           // $('#fbcTest').trigger('click');
        });

        setTimeout(function(){

            //$('#fbcTest').trigger('click');
            sendFacebookMessage(catBeeResult);
        }, 1000);

        //sendFacebookMessage(catBeeResult);

    });
});

function wait(msecs)
{
    var start = new Date().getTime();
    var cur = start
    while((cur - start < msecs) && (catBeeResult === null))
    {
        cur = new Date().getTime();
    }
}

function callback2(response) {
    document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
}

function sendFacebookMessage(data)
{

    alert(data);

    try
    {
    //window.open ("http://www.javascript-coder.com","mywindow");

    FB.init({appId: "369374193139831", status: true, cookie: true, xfbml: true});

    var obj = {
        method: 'send',
        display: 'popup',
        link: 'http://www.TribZi.com/adapters/demo/api/?act=welcome&pdl=1&shr=facebook',
        picture: 'http://www.medfordmailboxshop.com/Merchant/Images_Product/Box/Wood/198-wood-train-L.jpg',
        name: 'Hi, I shared a great deal for you...:)',
        caption: 'TribZi Deal',
        description: 'Press on link below to start shopping...http://127.0.0.1:8080/CatBee/adapters/demo/api/?act=welcome&pdl=1&shr=facebook',
        redirect_uri: 'http://127.0.0.1:8080/CatBee/components/share/facebook/facebookLogin.php'
    };


    FB.ui(obj, callback2);
    }
    catch (e)
    {
        alert(e);
    }
   // alert('after fbc');

//    alert(5);

}

function createCatBeeFillShareRequest() {

    return {
        action:'fillshare',
        context:{

            sendFrom:"vadim.chebyshev@retalix.com",
            sendTo:"regev147@013.net",
            context:{
                type:'facebook'
            },
            store:{
                authCode:"19FB6C0C-3943-44D0-A40F-3DC401CB3703"
            }
        }
    };
}