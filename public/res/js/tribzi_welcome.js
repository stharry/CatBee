TribZiBootstrap = {

    tribziApiUrl:'http://127.0.0.1:8080/CatBee/api/deal/',

    parseUri:function (str) {

        var opts = {
            strictMode:false,
            key:["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"],
            q:{
                name:"queryKey",
                parser:/(?:^|&)([^&=]*)=?([^&]*)/g
            },
            parser:{
                strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                loose:/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
            }
        };
        var o = opts,
            m = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
            uri = {},
            i = 14;

        while (i--) uri[o.key[i]] = m[i] || "";

        uri[o.q.name] = {};
        uri[o.key[12]].replace(o.q.parser, function ($0, $1, $2) {
            if ($1) uri[o.q.name][$1] = $2;
        });

        return uri;
    },

    attachIFrame:function (iFrameTag, uri) {

        var iframe = document.getElementById(iFrameTag);
        if (!iframe) {
            var divElement = document.createElement('div');
            divElement.id = 'myDiv';
            divElement.style.postion = '';
            var iframe = document.createElement('iframe');
            iframe.src = uri;
            iframe.height = 280;
            iframe.width = 580;
            iframe.frameBorder = 0;
            iframe.setAttribute('id', iFrameTag);
            divElement.appendChild(iframe);
            document.body.appendChild(divElement);

            alert(1);
        }
        else {

            iframe.src = uri;
        }
    },

    bootstrap:function () {

        var uriParams = this.parseUri(location.href);

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
            var uri = this.tribziApiUrl + '?action=frienddeal&context=' +
                encodeURIComponent(JSON.stringify(params));

            this.attachIFrame('catbeeFrame', uri);

        }
    }

};

window.TribZiBootstrap = TribZiBootstrap;

(function () {
    function loadTribZi() {
        TribZiBootstrap.bootstrap();
        //todo document.getElementById('iframe').height = document.body.offsetHeight;
    }

    var oldonload = window.onload;
    window.onload = (typeof window.onload != "function") ?
        loadTribZi : function () {
        oldonload();
        loadTribZi();
    };
})();

