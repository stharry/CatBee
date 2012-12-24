var facebookParams = null;

$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

//    TribZi.fillShare('facebook', facebookCallback)
    $("#facebookShare").click(function () {
try{
        TribZi.fillShare('facebook', kukuFbc);
}
        catch (e)
        {
            alert(e);
        }
        //getFacebookShare();

        //waitAndShare();

        //waitCatBeeResultAndRun(7200, waitAndShare);
    });


});

function kukuFbc(params)
{
    localStorage.setItem('facebookParams', JSON.stringify(params));
    //alert(JSON.stringify(params));

    setTimeout(StartFacebookSharing, 500);
}

function getFacebookShare() {

    var request = createCatBeeFillShareRequest();
    proceedCatBeeShareJsonRequest(request, 'facebookParams');
}

function StartFacebookSharing()
{
    try {

        var s = localStorage.getItem('facebookParams');

        facebookParams = JSON.parse(s);

        var fcbDisplayMode = 'popup';

        FB.init({
            appId: facebookParams.context.application.applicationCode,

            status:true, cookie:true});

        FB.ui({
                method:'feed',
                show_error: true,
                display:fcbDisplayMode,
                name: catBeeData.landing.customMessage,
                picture: catBeeData.order.items[0].url,
                redirect_uri: facebookParams.context.application.redirectUrl,
                caption: ' ',
                description: facebookParams.message,
                level: 'debug',
                link: facebookParams.link
            },
            function(response) {
                if (response && response.post_id) {
                 //   alert('Post was published.' + response.post_id);
                } else {
                  //  alert('Post was not published.');
                }
            }
        );

        localStorage.removeItem('facebookParams');
    }
    catch (e)
    {
        alert(e);
    }

}

function waitAndShare() {

    if (localStorage.getItem('facebookParams') === null)
    {
        setTimeout(waitAndShare, 500);
    }
    else
    {
        StartFacebookSharing();
    }
}

function createCatBeeFillShareRequest() {

    var rewardInd = $("#slider").slider("value");

    return {
        action:'fillshare',
        context:{

            "context":{
                "type":"facebook"
            },
            "deal":{
                "id":catBeeData.id
            },
            "reward":{
                "id":catBeeData.landing.landingRewards[rewardInd].id
            }
        }
    };
}
