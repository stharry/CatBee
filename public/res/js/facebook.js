$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

    $("#facebookShare").click(function () {

        StartFacebookSharing();

        waitCatBeeResultAndRun(7200, waitAndShare);
    });
});

function StartFacebookSharing() {

    var request = createCatBeeFillShareRequest();
    proceedCatBeeShareJsonRequest(request);
}

function waitAndShare() {
    try {
        FB.init({appId:catBeeResult.context.application.applicationCode,
            xfbml:true, cookie:true});

        FB.ui({
            method:'feed',
            display:'popup',
            name:'Hi, I shared a great deal for you...:)',
            picture:catBeeData.order.purchases[0].url,
            redirect_uri:catBeeResult.context.application.redirectUrl,
            description:catBeeResult.message,
            link:'http://www.TribZi.com'
        });
    }
    catch (e) {
        alert(e);
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
            "store":{
                "authCode":$("#storeCode").text()
            },
            "deal":{
                "id":catBeeData.id
            }
        }
    };
}
$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

    $("#facebookShare").click(function () {

        StartFacebookSharing();

    });
});

function StartFacebookSharing() {

    var request = createCatBeeFillShareRequest();
    proceedCatBeeShareJsonRequest(request, shareViaFacebook);

}

function shareViaFacebook() {

    alert(1);
    try {
        //catBeeResult = JSON.parse(data);

        FB.init({appId:catBeeResult.context.application.applicationCode,
            xfbml:true, cookie:true});

        FB.ui({
            method:'feed',
            display:'popup',
            name:'Hi, I shared a great deal for you...:)',
            picture:catBeeData.order.purchases[0].url,
            redirect_uri:catBeeResult.context.application.redirectUrl,
            description:catBeeResult.message,
            link:'http://www.TribZi.com'
        });
    }
    catch (e) {
        alert(e);
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
            "store":{
                "authCode":$("#storeCode").text()
            },
            "deal":{
                "id":catBeeData.id
            }
        }
    };
}
