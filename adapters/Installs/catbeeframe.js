cbf = {

    loadScript:function (url, loaded) {
        var scr = document.createElement('script');
        scr.type = 'text/javascript';
        scr.src = url;
        if (navigator.userAgent.indexOf('MSIE') > -1) {
            scr.onload = scr.onreadystatechange = function () {
                if (this.readyState == "loaded" || this.readyState == "complete") {
                    if (loaded) { loaded(); }
                }
                scr.onload = scr.onreadystatechange = null;
            };
        } else {
            scr.onload = loaded;
        }
        document.getElementsByTagName('head')[0].appendChild(scr);
    },

    byId: function(str)
    {
        return document.getElementById(str);
    },

    addDiv: function(id, to)
    {
        var div = document.createElement('div');
        div.id = id;
        if (to === null || typeof to == 'undefined')
        {
            document.body.appendChild(div);
        }
        else
        {
            cbf.byId(to).appendChild(div);
        }
        return this;

    },

    css: function(to, css)
    {
        var elem = cbf.byId(to);

        if (typeof elem != 'undefined')
        {
            for (key in css)
            {
                elem.style[key] = css[key];
            }
        }
        return this;
    },

    addEvt: function(to, eventName, handler)
    {
        var element = cbf.byId(to);
        if (element.addEventListener) {
            element.addEventListener(eventName, handler, false);
        }
        else if (element.attachEvent) {
            element.attachEvent('on' + eventName, handler);
        }
        else {
            element['on' + eventName] = handler;
        }
    },

    isMobileClient:function () {
        var isMobile = {
            Android   :function () {
                return navigator.userAgent.match(/Android/i);
            },
            BlackBerry:function () {
                return navigator.userAgent.match(/BlackBerry/i);
            },
            iOS       :function () {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i);
            },
            Opera     :function () {
                return navigator.userAgent.match(/Opera Mini/i);
            },
            Windows   :function () {
                return navigator.userAgent.match(/IEMobile/i);
            },
            any       :function () {
                return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
            }}

        return isMobile.any();
    },

    getCatBeeUrl:function () {
        return "http://api.tribzi.com/CatBee/";
        //return "http://127.0.0.1:8080/CatBee/";
    },

    setCookie:function (c_name, value, exdays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + exdays);
        var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
        document.cookie = c_name + "=" + c_value;
    },

    getCookie:function (c_name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == c_name) {
                return unescape(y);
            }
        }
    },

    parseUrl:function(str){

      var pars = str.split('?')[1];
        if (!pars || typeof pars == 'undefined') return {};

        var pairs = pars.split('&');
        var result = {};

        for (var i = 0; i < pairs.length; i++)
        {
            var singlePair =  pairs[i].split('=');
            if (singlePair.length > 1)
            {
                result[singlePair[0]] = singlePair[1];
            }
            else
            {
                result[singlePair[0]] = null;
            }
        }
        return result;
    },

    getScriptParams:function (scriptName) {

        var all_script_tags = document.getElementsByTagName('script');
        var script_tag = null;

        for (var i = 0; i < all_script_tags.length; i++) {
            if (all_script_tags[i].src.toString().indexOf(scriptName) > 0) {
                script_tag = all_script_tags[i];
                break;
            }
        }
        if (script_tag) {
            var query = script_tag.src.replace(/^[^\?]+\??/, '');

            var vars = query.split("&");
            var args = {};
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                args[pair[0]] = decodeURI(pair[1]).replace(/\+/g, ' ');  // decodeURI doesn't expand "+" to a space
            }
            return args;
        }
        else {
            return [];

        }
    },

    buildUrl:function (params) {
        return this.getCatBeeUrl() + 'api/deal/?action=' + params.catbeeAction + '&context=' +
            encodeURIComponent(JSON.stringify(params.urlParams));

    },

    setupRpc:function (params) {

        //todo: need to implement muli sockets
        url = this.buildUrl(params);

        var rpc = new easyXDM.Rpc(
            {
                remote   :url,
                onReady  :function () {

                },
                container:document.getElementById("cbfContainer"),
                props    :{
                    style:{
                        border  :"0px 0px 0px 0px",
                        padding :"0px 0px 0px 0px",
                        overflow:"hidden",
                        width   :"100%",
                        height  :"100%"
                    }
                }
            },
            {
                local :{
                    resizeFrame      :function (newWidth, newHeight) {
                        var sizes = {
                            height:newHeight + 'px',
                            width :newWidth + 'px'
                        };

                        cbf.css('cbfContainer', sizes);
                    },
                    closeFrame       :function () {
                        cbf.closeFrame();
                    },
                    sendCookieToFrame:function (code, value) {
                        cbf.setCookie(code, value, 1);
                    }},
                remote:{ }
            });

        return this;
    },

    buildFrame:function () {
        var params = this.frameParams;

        cbf.addDiv('cbfOverlay');

        var cssOverlay = {
            display  :'block',
            position :'fixed',
            top      :'0px',
            left     :'0px',
            width    :'100%',
            height   :'100%',
            'z-index':'1002',
            opacity  :0.8
        };
        cbf.css('cbfOverlay', cssOverlay);

        cbf.addDiv('cbfFrame').addDiv('cbfContainer', 'cbfFrame');
        var cssFrame = {
            display  :'block',
            position :'fixed',
            top      :'5%',
            left     :'40%',
            width    :params.initWidth + 'px',
            height   :params.initHeight + 'px',
            'z-index':'1003'
        };
        cbf.css('cbfFrame', cssFrame);

        var cssDialog = {
            width:'100%', height:'100%'
        };
        cbf.css('cbfContainer', cssDialog);

        if (params.closeButton) {
            cbf.addDiv('cbfCloseBtn', 'cbfFrame');
            cbf.byId('cbfCloseBtn').title="Close"
            var cssButton = {
                'position'        :'absolute',
                'top'             :'-18px',
                'right'           :'-18px',
                'width'           :'36px',
                'height'          :'36px',
                'cursor'          :'pointer',
                'z-index'         :'8040',
                'background'      :'url(\'' + cbf.getCatBeeUrl() + 'public/res/images/Navigation.png\')',
                'background-color':'transparent'
            };

            cbf.css('cbfCloseBtn', cssButton)
                .addEvt('cbfCloseBtn', 'click', function () {
                    cbf.closeFrame();
                });
        }

        this.setupRpc(params);

    },

    closeFrame:function () {
        cbf.css('cbfFrame', {'display' : 'none'});
        cbf.css('cbfOverlay', {'display' : 'none'});

    },

    setupFrame:function (params) {

        this.frameParams = params;
        if (typeof esyXDM == 'undefined') {
            if (typeof JSON == 'undefined') {
                var jsSrc = cbf.getCatBeeUrl() + "public/res/js/min/json2.min.js";
                cbf.loadScript(jsSrc);

            }
            var jsSrc = cbf.getCatBeeUrl() + "public/res/js/min/easyXDM.min.js";
            cbf.loadScript(jsSrc, function () {
                cbf.buildFrame();
            });

        }
        else {
            cbf.buildFrame();
        }

    }
};

window.cbf = cbf;
