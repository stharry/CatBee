$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

    $("#facebookShare").click(function () {

        var data = createCatBeeFillShareRequest();

        proceedCatBeeShareJsonRequest(data, shareViaFacebook);

        FB.init({appId: '369374193139831', xfbml: true, cookie: true});

        FB.ui({
            method: 'send',
            display: 'popup',
            name: 'Hi, I shared a great deal for you...:)',
            //redirect_uri: 'http://127.0.0.1:8080/CatBee/components/share/facebook/facebookLogin.php?kuku=1',
            description: 'Press on link below to start shopping...http://127.0.0.1:8080/CatBee/api/deal/?action=friendDeal&context%5Bleader%5D%5Bemail%5D=vadim.chebyshev%40retalix.com&context%5Bfriend%5D%5Bemail%5D=Enter+your+friends+e-mail&context%5Breward%5D%5Bvalue%5D=10&context%5Breward%5D%5Bcode%5D=ABCD1234_10&context%5Breward%5D%5Btype%5D=coupon&context%5Bstore%5D%5BauthCode%5D=19FB6C0C-3943-44D0-A40F-3DC401CB3703',
            link: 'http://www.TribZi.com'
        });
//        try
//        {
//        alert(filledShare.link);
//        }
//        catch (err)
//        {
//            alert("err:" + err.message);
//        }
//
//        FB.init({appId: '369374193139831', xfbml: true, cookie: true});
//
//        FB.ui({
//            method: 'send',
//            display: 'popup',
//            name: 'People Argue Just to Win',
//            description: '',
//            link: 'http://www.nytimes.com/2011/06/15/arts/people-argue-just-to-win-scholars-assert.html'
//        });

    });
});

function shareViaFacebook(data)
{

//    alert("txt " + data);
//    alert("d " + data["link"]);
//    try
//    {
//    var filledShare = $.parseJSON(data);
//    }
//    catch (err)
//    {
//        alert("err" + err.message);
//
//    }

//    FB.init({appId: '369374193139831', xfbml: true, cookie: true});
//
//    FB.ui({
//        method: 'send',
//        display: 'popup',
//        name: 'Share CatBee deal',
//        description: '',
//        link: 'http://www.facebook.com'
//    });
}

function createCatBeeFillShareRequest() {

    var rewardInd = $("#slider").slider("value");

    return {
        action:'fillshare',
        context:{

            sendFrom:$("#leaderEmail").text(),
            sendTo:$("#mail-input").val(),
            message:$("#message").val(),
            subject:$("#message").val(),
            context:{
                type:'email'
            },
            store:{
                authCode:$("#storeCode").text()
            },
            reward:
            {
                value: $('#friendRewardValue' + rewardInd).text(),
                type: $('#friendRewardType' + rewardInd).text(),
                code: $('#friendRewardCode' + rewardInd).text(),
                description: $('#friendRewardDesc' + rewardInd).text(),
                typeDescription: $('#friendRewardTypeDesc' + rewardInd).text()

            }
        }
    };
}
