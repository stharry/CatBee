
TribZi ={

    init:function(text){
        this.deal = text;
        this.selectedRewardIndex = 0;
        this.targets = [];
        this.sharedTimes = 0;
        return this;
    },

    initFriendDeal:function(text){
        this.friendDeal = text;
        this.selectedRewardIndex = 0;
        this.targets = [];
        this.sharedTimes = 0;
        return this;
    },

    setUid: function(uid){
      this.uid = uid;
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

    addTarget: function(sender, recipients, shareTarget, shareContext)
    {
        var shareTarget = {
            name: shareTarget,
            from: sender,
            to: recipients,
            context:{
                type:shareContext
            }
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

    doShareAction: function(action, callback){

        var sendData = {
            action:action,
            context:{

                customMessage:this.deal.landing.customMessage,
                deal:this.deal,
                context:{
                    type: this.targets[0].context.type
                },
                reward:this.deal.landing.landingRewards[this.selectedRewardIndex],
                targets: this.targets
            }
        };

        if (this.uid)
        {
            sendData.context.context.uid = this.uid;
        }

        this.requestData(sendData, callback);

        return this;

    },

    share:function(callback){

        this.sharedTimes++;
        return this.doShareAction('share deal', callback);
    },

    fillShare:function(context, callback){

        return this.doShareAction('fill share', callback);
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
    },

    saveCoupon: function()
    {
        var tag = this.friendDeal.share.context.uid;

        $.cookie('CatBeeCpnCod', this.friendDeal.share.reward.friendReward.code);
        $.cookie('CatBeeCpnVal', this.friendDeal.share.reward.friendReward.value);
        $.cookie('CatBeeRefId', this.friendDeal.share.context.uid);
        return this;
    },

    getReferral: function()
    {
        return $.cookie('CatBeeRefId');
    },

    getCouponCode: function()
    {
        return $.cookie('CatBeeCpnCod');
    },

    getCouponValue: function()
    {
        return $.cookie('CatBeeCpnVal');
    },

    injectCoupon: function(elem)
    {
        $('#' + elem).value($.cookie('CatBeeCpnCod'));
    }

}
window.TribZi = TribZi;