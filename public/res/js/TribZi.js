TribZi = {

    setupTribZi:function () {
        if (typeof String.prototype.trim !== 'function') {
            String.prototype.trim = function () {
                return this.replace(/^\s+|\s+$/g, '');
            }
        }

        return this;
    },

    openSocket:function () {

        //var catbeeXDM = { easyXDM: easyXDM.noConflict("catbee") };
        this.rpc = new easyXDM.Rpc(
            {},
            {
                remote:{
                    resizeFrame      :{},
                    closeFrame       :{},
                    sendCookieToFrame:{},
                    showAddressBook  :{}}
            });

        return this;

    },

    init:function (params) {
        this.deal = params.deal;
        this.selectedRewardIndex = 0;
        this.targets = [];
        this.sharedTimes = 0;
        this.sharePoint = params.sharePoint;

        this.setupTribZi();
        this.openSocket();

        return this;
    },

    initFriendDeal:function (params) {
        this.friendDeal = params.friendDeal;
        this.selectedRewardIndex = 0;
        this.targets = [];
        this.sharedTimes = 0;
        this.sharePoint = params.sharePoint;

        this.setupTribZi();
        this.openSocket();

        return this;
    },

    setUid:function (uid) {
        this.uid = uid;
        return this;
    },

    setShareLink:function (link) {
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
            name   :shareTarget,
            from   :sender,
            to     :recipients,
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

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
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
            else {
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
            action :action,
            context:{

                customMessage:this.deal.landing.customMessage,
                deal         :this.deal,
                context      :{
                    type:this.targets[0].context.type
                },
                reward       :this.deal.landing.landingRewards[this.selectedRewardIndex],
                urlShare     :this.deal.urlShareContext.link,
                targets      :this.targets
            }
        };

        if (this.uid) {
            sendData.context.context.uid = this.uid;
        }

        this.requestData(sendData, callback);

        return this;

    },

    share:function (callback) {

        if (this.sharedTimes == 0) {
            this.addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.branch.email, 'leader', 'email');
        }

        this.doShareAction('share deal', callback);

        if (this.sharedTimes == 0) {
            this.clearTargets()
                .addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'friend', 'urlShare')
                .setUid(TribZi.deal.urlShareContext.uid)
                .doShareAction('share deal', null);
        }

        this.sharedTimes++;

        return this;
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

        this.rpc.sendCookieToFrame('CatBeeCpnCod', this.friendDeal.share.reward.friendReward.code);
        this.rpc.sendCookieToFrame('CatBeeCpnVal', this.friendDeal.share.reward.friendReward.value);
        this.rpc.sendCookieToFrame('CatBeeRefId', this.friendDeal.share.context.uid);


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

    getRoot:function () {
        url = this.sharePoint.toString().replace(/^(.*\/\/[^\/?#]*).*$/, "$1");
        if (url.toLowerCase().indexOf('/CatBee') == -1) {
            url = url + '/CatBee';
        }
        return url;
    },

    closeFrame:function () {
        this.rpc.closeFrame();
        return this;
    },

    resizeFrame:function (widthOffset, heightOffset, frameElem) {
        function toNumber(n) {
            if (!isNaN(parseFloat(n)) && isFinite(n)) {
                return parseFloat(n);
            }
            return 0;
        }

        function toString(prop) {
            if (typeof prop == 'undefined' || prop == null) {
                return '0';
            }
            return prop.replace('px', '');
        }

        function sumBorders(elem, borders) {
            var sum = 0;

            for (var i = 0; i < borders.length; i++) {
                var bstr = toString($(elem).css(borders[i]));
                sum += Math.round(toNumber(bstr));
            }
            return sum;
        }

        var elem = frameElem ? frameElem : '.box';

        var newWidth = Math.round(parseFloat($(elem).width())) +
            sumBorders(elem, ['border-left', 'padding-left', 'border-right', 'padding-right']);

        var newHeight = Math.round(parseFloat($(elem).height())) +
            sumBorders(elem, ['border-top', 'padding-top', 'border-bottom', 'padding-bottom']);

        if (widthOffset) {
            newWidth += widthOffset;
        }

        if (heightOffset) {
            newHeight += heightOffset;
        }

        this.rpc.resizeFrame(newWidth, newHeight);
        return this;

//        var str = "act=resize;w=" + newWidth + "px;h=" + newHeight + "px";
//
//        return this.sendToFrame(str);
    }

};
window.TribZi = TribZi;