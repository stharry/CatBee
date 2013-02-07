cbf = {

    catBeeHost: function()
    {
        return cbf.valOrDefault(cbf.getScriptParams('catbeeframe').host, "http://api.tribzi.com/CatBee/");
    }
    ,

    viewPort:function () {
        var e = window, a = 'inner';
        if (!( 'innerWidth' in window )) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        return { width:e[ a + 'Width' ], height:e[ a + 'Height' ] }
    },

    loadScript:function (url, loaded) {
        var scr = document.createElement('script');
        scr.type = 'text/javascript';
        scr.src = url;
        if (navigator.userAgent.indexOf('MSIE') > -1) {
            scr.onload = scr.onreadystatechange = function () {
                if (this.readyState == "loaded" || this.readyState == "complete") {
                    if (loaded) {
                        loaded();
                    }
                }
                if (this.readyState != "loading")
                {
                    scr.onload = scr.onreadystatechange = null;
                }
            };
        }
        else {
            scr.onload = loaded;
        }
        document.getElementsByTagName('head')[0].appendChild(scr);
    },

    byId:function (str) {
        return document.getElementById(str);
    },

    addDiv:function (id, to) {
        var div = document.createElement('div');
        div.id = id;
        if (to === null || typeof to == 'undefined') {
            document.body.appendChild(div);
        }
        else {
            cbf.byId(to).appendChild(div);
        }
        return this;

    },

    css:function (to, css) {
        var elem = cbf.byId(to);

        if (typeof elem != 'undefined') {
            for (key in css) {
                try {elem.style[key] = css[key];}catch(e){}
            }
        }
        return this;
    },

    addEvt:function (to, eventName, handler) {
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

    addLoadEvt:function (loadEvent) {
        if (window.attachEvent) {
            window.attachEvent('onload', loadEvent);
        }
        else {
            if (window.onload) {
                var curronload = window.onload;
                var newonload = function () {
                    curronload();
                    loadEvent();
                };
                window.onload = newonload;
            }
            else {
                window.onload = loadEvent;
            }
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

    valOrDefault:function (val1, def1) {
        return (val1 === null) || (typeof val1 == 'undefined') ? def1 : val1;

    },

    getCatBeeUrl:function () {
        return cbf.catBeeHost();
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

    parseUrl:function (str) {

        var pars = str.split('?')[1];
        if (!pars || typeof pars == 'undefined') return {};

        var pairs = pars.split('&');
        var result = {};

        for (var i = 0; i < pairs.length; i++) {
            var singlePair = pairs[i].split('=');
            if (singlePair.length > 1) {
                result[singlePair[0]] = singlePair[1];
            }
            else {
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
            args.scriptSource = script_tag.src;
            return args;
        }
        else {
            return {scriptSource:script_tag.src};

        }
    },

    buildUrl:function (params) {
        return this.getCatBeeUrl() + 'api/deal/?action=' + params.catbeeAction + '&context=' +
            encodeURIComponent(JSON.stringify(params.urlParams));

    },

    setupRpc:function (params) {

        //todo: need to implement muli sockets
        url = this.buildUrl(params);

        //var catbeeXDM = { easyXDM: easyXDM.noConflict("catbee") };

        var rpc = new easyXDM.Rpc(
            {
                remote   :url,
                onReady  :function () {

                },
                container:document.getElementById("cbfContainer"),
                props    :{
                    style:{
                        //border  :"0px 0px 0px 0px",
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
                        cbf.css('cbfFrame', sizes);
                    },
                    closeFrame       :function () {
                        cbf.closeFrame();
                    },
                    sendCookieToFrame:function (code, value) {
                        cbf.setCookie(code, value, 1);
                    },
                    showAddressBook  :function () {

                        cloudsponge.launch();

                    }},
                remote:{ }
            });

        return this;
    },

    highZIndex: function()
    {
        function highZ(pa, limit){
            limit= limit || Infinity;
            pa= pa || document.body;
            var who, tem, mx= 1, A= [], i= 0, L;
            pa= pa.childNodes, L= pa.length;
            while(i<L){
                who= pa[i++]
                if(who.nodeType== 1){
                    tem= parseInt(deepCss(who,"z-index")) || 0;
                    if(tem> mx && tem<=limit) mx= tem;
                }
            }
            return mx;
        }

        function deepCss(who, css){
            var sty, val, dv= document.defaultView || window;
            if(who.nodeType== 1){
                sty= css.replace(/\-([a-z])/g, function(a, b){
                    return b.toUpperCase();
                });
                val= who.style[sty];
                if(!val){
                    if(who.currentStyle) val= who.currentStyle[sty];
                    else if(dv.getComputedStyle){
                        val= dv.getComputedStyle(who,"").getPropertyValue(css);
                    }
                }
            }
            return val || "";
        }

        return highZ();
    },

    buildFrame:function () {


        var maxZIndex = cbf.highZIndex();

        var params = this.frameParams;

        cbf.addDiv('cbfOverlay');

        var cssOverlay = {
            display           :'block',
            position          :'fixed',
            top               :'0px',
            left              :'0px',
            width             :'100%',
            height            :'100%',
            'z-index'         :maxZIndex + 100002,
            opacity           :0.8,
            'background-color':'rgba(0, 0, 0, 0.5)'
        };
        cbf.css('cbfOverlay', cssOverlay);
        cbf.byId('cbfOverlay').zIndex = maxZIndex + 100002;
        cbf.byId('cbfOverlay').style.zIndex = maxZIndex + 100002;

        cbf.addDiv('cbfFrame').addDiv('cbfContainer', 'cbfFrame');
        var left = Math.round(cbf.viewPort().width / 2 - params.initWidth / 2);
        var cssFrame = {
            display                :'block',
            position               :'fixed',
            top                    :'5%',
            left                   :left + 'px',
            width                  :params.initWidth + 'px',
            height                 :params.initHeight + 'px',
            'z-index'              :maxZIndex + 100003,

            //Round border
            'border-radius'        :'10px',
            '-moz-border-radius'   :'10px',
            '-webkit-border-radius':'10px',
            ' -khtml-border-radius':'10px',
            background             :'#FFF',
            border                 :'5px solid rgba(12, 80, 182, 0.2)'

        };
        cbf.css('cbfFrame', cssFrame);
        cbf.byId('cbfFrame').zIndex = maxZIndex + 100003;
        cbf.byId('cbfFrame').style.zIndex = maxZIndex + 100003;

        var cssDialog = {
            width:'100%', height:'100%'
        };
        cbf.css('cbfContainer', cssDialog);

        if (params.closeButton) {
            cbf.addDiv('cbfCloseBtn', 'cbfFrame');
            cbf.byId('cbfCloseBtn').title = "Close"
            var cssButton = {
                'position'        :'absolute',
                'top'             :'-18px',
                'right'           :'-18px',
                'width'           :'36px',
                'height'          :'36px',
                'cursor'          :'pointer',
                'z-index'         :maxZIndex + 800040,
                'background'      :'url(\'' + cbf.getCatBeeUrl() + 'public/res/images/Navigation.png\')',
                'background-color':'transparent'
            };

            cbf.css('cbfCloseBtn', cssButton)
                .addEvt('cbfCloseBtn', 'click', function () {
                    cbf.closeFrame();
                });
            cbf.byId('cbfCloseBtn').zIndex = maxZIndex + 800040;
            cbf.byId('cbfCloseBtn').style.zIndex = maxZIndex + 800040;
        }

        cbf.setupRpc(params);
        cbf.byId('cbfContainer').focus();

    },

    closeFrame:function () {
        cbf.css('cbfFrame', {'display':'none'});
        cbf.css('cbfOverlay', {'display':'none'});

    },

    setupFrame:function (params) {

        if (cbf.hasFrame) {
            return;
        }

        cbf.hasFrame = true;
        this.frameParams = params;
        if (typeof esyXDM == 'undefined') {

            if (typeof JSON == 'undefined') {
                var jsSrc = cbf.getCatBeeUrl() + "public/res/js/min/json2.min.js";
                cbf.loadScript(jsSrc);

            }
            var jsSrc = "https://api.cloudsponge.com/address_books.js";
            cbf.loadScript(jsSrc, function () {

                cloudsponge.init({
                    domain_key         :"RFULLDSNJ8E62YBDLS7S",
                    afterSubmitContacts:function (array_of_contacts) {
                        alert(1);
                    }
                })
                var jsSrc = cbf.getCatBeeUrl() + "public/res/js/min/easyXDM.js?reload";
                cbf.loadScript(jsSrc, function () {
                    cbf.buildFrame();
                });


            });


        }
        else {
            cbf.buildFrame();
        }

    }
};

window.cbf = cbf;
cbf.hasFrame = false;

