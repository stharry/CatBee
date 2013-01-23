TribZi = {

    openSocket: function()
    {
//        this. socket = new easyXDM.Socket({
//            onMessage:function(message, origin) {
//                //do something with message
//            }
//        });

    },

    init:function (params) {
        this.deal = params.deal;
        this.selectedRewardIndex = 0;
        this.targets = [];
        this.sharedTimes = 0;
        this.sharePoint = params.sharePoint;
        this.openSocket();

        return this;
    },

    initFriendDeal:function (params) {
        this.friendDeal = params.friendDeal;
        this.selectedRewardIndex = 0;
        this.targets = [];
        this.sharedTimes = 0;
        this.sharePoint = params.sharePoint;
        this.openSocket();

        return this;
    },

    setUid:function (uid) {
        this.uid = uid;
        return this;
    },

    setShareLink: function(link)
    {
        this.shareLink = link;
        return this;
    },

    setRewardIndex:function (index) {

        this.selectedRewardIndex = index;
        return this;
    },

    setCustomMessage:function (message) {
        this.deal.landing.customMessage = message;
        return this;
    },

    clearTargets:function () {
        this.targets = [];
        return this;
    },

    addTarget:function (sender, recipients, shareTarget, shareContext) {
        var shareTarget = {
            name:shareTarget,
            from:sender,
            to:recipients,
            context:{
                type:shareContext
            }
        }

        this.targets.push(shareTarget);
        return this;
    },

    shortenLink:function (link, callback) {


        var uri = 'https://api-ssl.bitly.com/v3/shorten?' +
            'access_token=57973b2f6a137f2c5f0f4d1b852032c2d3993bcd&longUrl=' +
            encodeURIComponent(link);

        this.requestAnyData(uri, null,
            function (response) {

                callback(response.data.url);
            });
    },

    requestData:function (data, callback) {

        return this.requestAnyData(this.sharePoint, data, callback);
    },

    requestAnyData:function (url, data, callback) {

        var sharePoint = url;

        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else {// code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                try {
                    var requestResult = JSON.parse(xmlhttp.responseText);

                    if (callback !== null) {
                        callback(requestResult);
                    }
                }
                catch (e) {
                    //alert(e);
                }
            }
        }

        try {


            if (data) {
                var data2Send = jQuery.param(data);
                xmlhttp.open("POST", sharePoint, true);
                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xmlhttp.setRequestHeader("Content-Length", data2Send.length);
                xmlhttp.send(data2Send);
            }
            else
            {
                xmlhttp.open("GET", sharePoint, true);
                xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xmlhttp.send();
            }
        }
        catch (e) {
//            alert(e);
        }

    },

    doShareAction:function (action, callback) {

        var sendData = {
            action:action,
            context:{

                customMessage:this.deal.landing.customMessage,
                deal:this.deal,
                context:{
                    type:this.targets[0].context.type
                },
                reward:this.deal.landing.landingRewards[this.selectedRewardIndex],
                targets:this.targets
            }
        };

        if (this.uid) {
            sendData.context.context.uid = this.uid;
        }

        this.requestData(sendData, callback);

        return this;

    },

    share:function (callback) {

        this.sharedTimes++;
        return this.doShareAction('share deal', callback);
    },

    fillShare:function (context, callback) {

        return this.doShareAction('fill share', callback);
    },

    parseMessage:function (message) {
        var replacePairs = [

            {key:"[reward.friendReward.code]", val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.code},
            {key:"[reward.friendReward.value]", val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.value},
            {key:"[reward.friendReward.typeDescription]", val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.typeDescription},
            {key:"[context.link]", val:this.shareLink}
        ];

        var result = message;

        for (var i = 0; i < replacePairs.length; i++) {
            result = result.replace(replacePairs[i].key, replacePairs[i].val);
        }
        return result;
    },

    saveCoupon:function () {
        var tag = this.friendDeal.share.context.uid;

        $.cookie('CatBeeCpnCod', this.friendDeal.share.reward.friendReward.code);
        $.cookie('CatBeeCpnVal', this.friendDeal.share.reward.friendReward.value);
        $.cookie('CatBeeRefId', this.friendDeal.share.context.uid);

        this.sendToFrame('act=cookie;n=CatBeeCpnCod;v=' + this.friendDeal.share.reward.friendReward.code);
        return this;
    },

    getReferral:function () {
        return $.cookie('CatBeeRefId');
    },

    getCouponCode:function () {
        return $.cookie('CatBeeCpnCod');
    },

    getCouponValue:function () {
        return $.cookie('CatBeeCpnVal');
    },

    injectCoupon:function (elem) {
        $('#' + elem).value($.cookie('CatBeeCpnCod'));
    },

    getRoot: function()
    {
        url = this.sharePoint.toString().replace(/^(.*\/\/[^\/?#]*).*$/, "$1");
        if (url.toLowerCase().indexOf('/CatBee') == -1)
        {
            url = url + '/CatBee';
        }
        return url;
    },

    sendToFrame: function(str)
    {
//        sessionStorage.setItem('a', '1');
//        var params = {
//            act:'set',
//            shop:1,
//            a:str
//        }
//        this.requestAnyData('/CatBee/components/actions/shopActions.php', params);

        var index = window.location.hash.indexOf('#');

        if (index > 0)
        {
            var currName = window.name.substr(0, index);
            window.name = currName + '#' + str;
        }
        else
        {
            window.name =  window.name + '#' + str;

        }
        return this;
    },

    closeFrame: function()
    {
        return this.sendToFrame('act=close');
    },

    resizeFrame: function(widthOffset, heightOffset, frameElem)
    {
        function toNumber(n) {
            if (!isNaN(parseFloat(n)) && isFinite(n))
            {
                return parseFloat(n);
            }
            return 0;
        }

        var elem = frameElem ? frameElem: '.box';

        var lb = $(elem).css('border-left').replace('px', '');
        var rb = $(elem).css('border-right').replace('px', '');
        var tb = $(elem).css('border-top').replace('px', '');
        var bb = $(elem).css('border-bottom').replace('px', '');

        var newWidth = Math.round(parseFloat($(elem).width())) +
            Math.round(toNumber(lb)) + Math.round(toNumber(rb));

        var newHeight =  Math.round(parseFloat($(elem).height())) +
            Math.round(toNumber(tb)) + Math.round(toNumber(bb));

        if (widthOffset)
        {
            newWidth += widthOffset;
        }

        if (heightOffset)
        {
            newHeight += heightOffset;
        }

        var str = "act=resize;w=" + newWidth + "px;h=" + newHeight + "px";

        return this.sendToFrame(str);
    }


};
window.TribZi = TribZi;