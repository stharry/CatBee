
TribZi ={

    init:function(text){
        this.sessionData = text;
        this.selectedRewardIndex = 0;

        return this;
    },

    setRewardIndex: function(index){
        this.selectedRewardIndex = index;
        return this;
    },

    setCustomMessage: function(message){
        this.sessionData.landing.customMessage = message;
        return this;
    },

    setRecipients: function(recipients){
        this.recipients = recipients;
        return this;
    },

    requestData:function(data, callback){

        var sharePoint = this.sessionData.sharePoint;

        this.requestResult = null;

        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200 &&
                this.requestResult == null)
            {
                try
                {
                    this.requestResult = JSON.parse(xmlhttp.responseText);

                    if (callback !== null)
                    {
                        callback(this.requestResult);
                    }
                }
                catch (e)
                {
                    //alert(e);
                }
            }
        }

        try {
            var data2Send = jQuery.param(data);

            xmlhttp.open("POST", sharePoint, true);
            xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xmlhttp.setRequestHeader("Content-Length", data2Send.length);
            xmlhttp.send(data2Send);
        }
        catch (e) {
//            alert(e);
        }

    },


    shareToEmail:function(callback){

        return this.share('email', callback);
    },

    share:function(shareTo, callback){

        var sendData = {
            action:'share deal',
            context:{

                sendFrom:this.sessionData.order.customer.email,
                sendTo:this.recipients,
                customMessage:this.sessionData.landing.customMessage,
                deal:{
                    id:this.sessionData.id
                },
                context:{
                    type:shareTo
                },
                reward:{
                    id:this.sessionData.landing.landingRewards[this.selectedRewardIndex].id

                }
            }
        }

        this.requestData(sendData, callback);

        return this;

    },

    shareToFbc:function(message, rewardInd){

        var data = {
            action:'fill share',
            context:{

                "context":{
                    "type":"facebook"
                },
                "deal":{
                    "id":this.sessionData.id
                },
                "reward":{
                    "id":this.sessionData.landing.landingRewards[rewardInd].id
                }
            }
        }

        var callback = function(params)
        {

            try
            {
//            alert(params.context.application.redirectUrl);
//                alert(TribZi.sessionData.order.items[0].url);
//                alert(params.link);

            FB.init({
                appId: params.context.application.applicationCode,

                status:true, cookie:true});

            FB.ui({
                    method:'feed',
                    display:'popup',
                    name: TribZi.sessionData.landing.customMessage,
                    picture: TribZi.sessionData.order.items[0].url,
                    redirect_uri: params.context.application.redirectUrl,
                    caption: ' ',
                    description: params.message,
                    link: params.link
                },
                function(response) {
                    if (response && response.post_id) {
                        alert('Post was published.' + response.post_id);
                    } else {
                        alert('Post was not published.');
                    }
                }
            );
            }
            catch (e)
            {
                alert('err' + e);
            }

        }

        this.requestData(data, false, callback);

        return this
    }
}
window.TribZi = TribZi;