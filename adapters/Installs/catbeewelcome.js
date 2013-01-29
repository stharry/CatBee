
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
                initWidth :570,
                initHeight:450,
                catbeeAction: 'frienddeal',
                urlParams :params
            });
    }

});
