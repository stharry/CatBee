cbf.addLoadEvt(function () {

    var uriParams = cbf.parseUrl(location.href);

    var tribzisid = cbf.valOrDefault(uriParams.tribzisid, null);
    if (tribzisid) {

        var params =
        {
            share:{
                context:{
                    uid:tribzisid
                }}
        };

        cbf.setupFrame(
            {
                initWidth   :600,
                initHeight  :480,
                catbeeAction:'frienddeal',
                urlParams   :params
            });
    }
    else {
        var couponCode = cbf.getCookie('CatBeeCpnCod');

        if (couponCode) {
            var couponFldId = 'coupon_code';
            if (cbfSettings && cbfSettings.widgets.cpn &&
                cbfSettings.widgets.cpn.gui.appendTo) {
                couponFldId = cbfSettings.widgets.cpn.gui.appendTo;
            }
            else {
                var args = cbf.getScriptParams('catbeecart');
                couponFldId = args['cfid'];
            }

            var couponBox = cbf.getDiv(couponFldId);
            if (couponBox) {
                couponBox.value = couponCode;
            }
        }
    }

});
