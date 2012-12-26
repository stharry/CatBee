
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

    doShareAction: function(action, context, callback){

        var sendData = {
            action:action,
            context:{

                sendFrom:this.sessionData.order.customer.email,
                sendTo:this.recipients,
                customMessage:this.sessionData.landing.customMessage,
                deal:this.sessionData,
                context:{
                    type:context
                },
                reward:{
                    id:this.sessionData.landing.landingRewards[this.selectedRewardIndex].id

                }
            }
        }

        this.requestData(sendData, callback);

        return this;

    },

    share:function(context, callback){

        return this.doShareAction('share deal', context, callback);
    },

    fillShare:function(context, callback){

        return this.doShareAction('fill share', context, callback);
    }
}
window.TribZi = TribZi;