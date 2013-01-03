
TribZi ={

    init:function(text){
        this.deal = text;
        this.selectedRewardIndex = 0;
        this.targets = [];
        return this;
    },

    setRewardIndex: function(index){
        this.selectedRewardIndex = index;
        return this;
    },

    setCustomMessage: function(message){
        this.deal.landing.customMessage = message;
        return this;
    },

    clearTargets: function()
    {
        this.targets = [];
        return this;
    },

    addTarget: function(sender, recipients, target)
    {
        var shareTarget = {
            name: target,
            from: sender,
            to: recipients
        }
        this.targets.push(shareTarget);
        return this;
    },

    requestData:function(data, callback){

        var sharePoint = this.deal.sharePoint;

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

                customMessage:this.deal.landing.customMessage,
                deal:this.deal,
                context:{
                    type:context
                },
                reward:{
                    id:this.deal.landing.landingRewards[this.selectedRewardIndex].id

                },
                targets: this.targets
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
    },

    parseMessage: function(message)
    {
        var replacePairs = [

            {key:"[reward.friendReward.code]", val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.code},
            {key:"[reward.friendReward.value]", val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.value},
            {key:"[reward.friendReward.typeDescription]", val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.typeDescription}
        ];

        var result = message;

        for (var i=0;i<replacePairs.length;i++)
        {
            result = result.replace(replacePairs[i].key, replacePairs[i].val);
        }
        return result;
    }
}
window.TribZi = TribZi;