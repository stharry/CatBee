
jQuery(document).ready(function () {

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
                initWidth :570,
                initHeight:450,
                catbeeAction: 'frienddeal',
                urlParams :params
            });
    }

});
