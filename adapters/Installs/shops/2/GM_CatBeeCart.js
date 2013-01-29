
jquery_fiveconnect(document).ready(function () {

    var uriParams = cbf.parseUri(location.href);

    if (uriParams['queryKey'] &&
        uriParams['queryKey']['plugin'] &&
        (uriParams['queryKey']['plugin'].toLowerCase() == 'tribzi') &&
        uriParams['queryKey']['sid']) {

        var params =
        {
            share:{
                context:{
                    uid:uriParams['queryKey']['sid']
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
            var couponBox = document.getElementById('coupon_code');
            if (couponBox) {
                couponBox.value = couponCode;
            }
        }
    }

});
