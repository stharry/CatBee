
cbf.addLoadEvt(function () {

    var uriParams = cbf.parseUrl(location.href);

    if (uriParams.plugin &&
        (uriParams.plugin.toLowerCase() == 'tribzi') &&
        uriParams.sid) {

        var params =
        {
            share:{
                context:{
                    uid:uriParams.sid
                }}
        };

        cbf.setupFrame(
            {
                initWidth :600,
                initHeight:480,
                catbeeAction: 'frienddeal',
                urlParams :params
            });
    }
    else
    {
        var couponCode = cbf.getCookie('CatBeeCpnCod');

        if (couponCode) {
            var args = cbf.getScriptParams('catbeecart');

            var couponFldId = cbf.valOrDefault(args['cfid'], 'coupon_code');
            var couponBox = cbf.byId(couponFldId);
            if (couponBox) {
                couponBox.value = couponCode;
            }
        }
    }

});
