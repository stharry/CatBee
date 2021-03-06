TribZiBootstrap = {

    tribziApiUrl:'http://127.0.0.1:8080/CatBee/api/deal/',


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

