cbf = {

    catBeeHost:function () {

        return cbf.valOrDefault(cbfSettings.redirectTo,
            cbf.valOrDefault(cbf.getScriptParams('catbeeframe').host, "http://api.tribzi.com/CatBee/"));
    },

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
                if (this.readyState != "loading") {
                    scr.onload = scr.onreadystatechange = null;
                }
            };
        }
        else {
            scr.onload = loaded;
        }
        document.getElementsByTagName('head')[0].appendChild(scr);
    },

    loadCss:function (url) {
        var css = document.createElement("link");
        css.setAttribute("rel", "stylesheet");
        css.setAttribute("type", "text/css");
        css.setAttribute("href", url);
        document.getElementsByTagName('body')[0].appendChild(css);
    },

    byId:function (str) {
        return document.getElementById(str);
    },

    byClassList:function (str, parent) {
        if (parent == null || typeof parent == 'undefined') {
            var descendants = document.getElementsByTagName('*');
        }
        else {
            var descendants = cbf.byId(parent).getElementsByTagName('*');
        }
        var i = -1, e, result = [];
        while (e = descendants[++i]) {
            ((' ' + cbf.valOrDefault(e['class'], e.className) + ' ').indexOf(' ' + str + ' ') > -1) && result.push(e);
        }
        return result;

    },

    byClass:function (str, parent) {

        var result = cbf.byClassList(str, parent);
        return result.length > 0 ? result[0] : null;

    },

    getDiv:function (str) {
        if (!cbf.valOrDefault(str, null)) return null;
        return cbf.valOrDefault(cbf.byId(str), cbf.byClass(str));
    },
    addDiv:function (id, to, before) {
        var div = document.createElement('div');
        div.id = id;
        if (to === null || typeof to == 'undefined') {
            document.body.appendChild(div);
        }
        else {

            var parentElem = cbf.getDiv(to);

            var insertBeforeElem = cbf.getDiv(before);

            if (!insertBeforeElem) {
                parentElem.appendChild(div);
            }
            else {
                parentElem.insertBefore(div, insertBeforeElem);
            }
        }
        return this;

    },

    css:function (to, css) {
        var elem = cbf.byId(to);

        if (typeof elem != 'undefined') {
            for (key in css) {
                try {
                    if (typeof elem.style[key] == "string") {
                        elem.style[key] = css[key];
                    }
                } catch (e) {
                }
            }
        }
        return this;
    },

    setZIndex:function (to, val) {
        cbf.css(to, {'z-index':val});
        cbf.byId(to).zIndex = val;
        cbf.byId(to).style.zIndex = val;

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
            return {scriptSource:''};

        }
    },

    buildUrl:function (params) {
        return cbf.valOrDefault(params.customUrl,
            this.getCatBeeUrl() + 'api/deal/?action=' + params.catbeeAction + '&context=' +
                encodeURIComponent(JSON.stringify(params.urlParams)));

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

    highZIndex:function () {
        function highZ(pa, limit) {
            limit = limit || Infinity;
            pa = pa || document.body;
            var who, tem, mx = 1, A = [], i = 0, L;
            pa = pa.childNodes, L = pa.length;
            while (i < L) {
                who = pa[i++]
                if (who.nodeType == 1) {
                    tem = parseInt(deepCss(who, "z-index")) || 0;
                    if (tem > mx && tem <= limit) mx = tem;
                }
            }
            return mx;
        }

        function deepCss(who, css) {
            var sty, val, dv = document.defaultView || window;
            if (who.nodeType == 1) {
                sty = css.replace(/\-([a-z])/g, function (a, b) {
                    return b.toUpperCase();
                });
                val = who.style[sty];
                if (!val) {
                    if (who.currentStyle) val = who.currentStyle[sty];
                    else if (dv.getComputedStyle) {
                        val = dv.getComputedStyle(who, "").getPropertyValue(css);
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

        var appendToElem = params.appendTo ? cbf.getDiv(params.appendTo) : null;
        if (!appendToElem) {
            cbf.addDiv('cbfOverlay');

            var cssOverlay = {
                display :'block',
                position:'fixed',
                top     :'0px',
                left    :'0px',
                width   :'100%',
                height  :'100%',

                'background-color':'#000000',
                '-ms-filter'      :"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)",
                'filter'          :'alpha(opacity=50)',
                '-moz-opacity'    :'0.5',
                '-khtml-opacity'  :'0.5',
                'opacity'         :'0.5'

            };
            cbf.css('cbfOverlay', cssOverlay);
            cbf.setZIndex('cbfOverlay', maxZIndex + 10002);
            cbf.byId('cbfOverlay').backgroundColor = '#000000';
            cbf.byId('cbfOverlay').style.backgroundColor = '#000000';
            cbf.byId('cbfOverlay').style.opacity = 0.5;

            cbf.addDiv('cbfScreen');
            cssScreen = {
                display     :'block',
                position    :'fixed',
                top         :'0px',
                left        :'0px',
                width       :'100%',
                height      :'100%',
                'overflow-y':'auto'
            }
            cbf.css('cbfScreen', cssScreen);
            cbf.byId('cbfScreen').style.overflowY = 'auto';
            cbf.setZIndex('cbfScreen', maxZIndex + 10003);

            cbf.addDiv('cbfFrame', 'cbfScreen').addDiv('cbfContainer', 'cbfFrame');

            if (params.closeButton) {
                cbf.addDiv('cbfCloseBtn', 'cbfFrame');
                cbf.byId('cbfCloseBtn').title = "Close"
                var cssButton = {
                    'position':'absolute',
                    'top'     :'-18px',
                    'right'   :'-18px',
                    'width'   :'36px',
                    'height'  :'36px',
                    'cursor'  :'pointer',

                    'background'      :'url(\'' + cbf.getCatBeeUrl() + 'public/res/images/Navigation.png\')',
                    'background-color':'transparent'
                };

                cbf.css('cbfCloseBtn', cssButton)
                    .addEvt('cbfCloseBtn', 'click', function () {
                        cbf.closeFrame();
                    });

                cbf.setZIndex('cbfCloseBtn', maxZIndex + 10010);
            }
        }
        else {
            cbf.addDiv('cbfFrame', params.appendTo, params.setBefore).addDiv('cbfContainer', 'cbfFrame');
        }
        var cssFrame = {

            width :params.initWidth + 'px',
            height:params.initHeight + 'px'
        };
        cbf.css('cbfFrame', cssFrame);

        if (!appendToElem) {
            var scrW = cbf.viewPort().width;
            var left = Math.round((scrW / 2 - params.initWidth / 2) / scrW * 100);

            var cssFrame = {
                display                :'block',
                position               :'absolute',
                top                    :'5%',
                left                   :left + '%',

                //Round border
                'border-radius'        :'10px',
                '-moz-border-radius'   :'10px',
                '-webkit-border-radius':'10px',
                ' -khtml-border-radius':'10px',
                background             :'#FFF',
                color                  :'#FFF',
                border                 :'5px solid rgba(12, 80, 182, 0.2)'

            }
            cbf.css('cbfFrame', cssFrame);
        }
        else {

            var scrW = appendToElem.offsetWidth;
            var left = Math.round((scrW / 2 - params.initWidth / 2) / scrW * 100);

            var cssFrame = {
                position:'relative',
                left    :left + '%'
            }
            cbf.css('cbfFrame', cssFrame);
        }

        cbf.setZIndex('cbfFrame', maxZIndex + 10004);

        var cssDialog = {
            width:'100%', height:'100%'
        };
        cbf.css('cbfContainer', cssDialog);


        cbf.setupRpc(params);
        cbf.byId('cbfContainer').focus();

    },

    closeFrame:function () {
        if (cbf.valOrDefault(cbf.byId('cbfOverlay'), null) == null) {
            cbf.css('cbfFrame', {'display':'none'});
        }
        else {
            cbf.css('cbfScreen', {'display':'none'});
            cbf.css('cbfOverlay', {'display':'none'});
        }

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
                    //cbf.loadCss(cbf.getCatBeeUrl() + "adapters/Installs/style/catbeeframe.css");
                    cbf.buildFrame();
                });


            });


        }
        else {
            cbf.buildFrame();
        }

    },

    askApi:function (api, data, callback) {
        var sharePoint = cbf.getCatBeeUrl() + 'api/' + api + '/';

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
                var data2Send = data; //todo
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

    }
};

cbWidgets = {


    postPurchaseWidget:function (orderParams) {

        function callFrame(orderParams, guiParams)
        {
            cbf.setupFrame(
                {
                    initWidth   :424,
                    initHeight  :372,
                    catbeeAction:'deal',
                    urlParams   :orderParams,
                    closeButton :guiParams.closeButton,
                    appendTo    :guiParams.appendTo,
                    setBefore   :guiParams.setBefore
                });
        }

        var referralUid = cbf.getCookie('CatBeeRefId');
        if (referralUid) {
            orderParams.successfulReferral = referralUid;
        }


        if (cbf.valOrDefault(cbfSettings.gui, null)) {
            callFrame(orderParams, cbfSettings.gui);
        }
        else {
            var askParams = "action=get+config&context%5BshopId%5D=" + orderParams.branch.shopId + "&context%5BwidgetId%5D=1";
            cbf.askApi('store', askParams, function (response) {

                guiParams = response.length > 0 && cbf.valOrDefault(response[0].gui, null)
                    ? response[0].gui
                    : {closeButton:true, appendTo:null};

                callFrame(orderParams, guiParams);
            });
        }

    },

    welcomeWidget:function () {

    }
};

window.cbf = cbf;
cbfSettings = {};
window.cbfSettings = cbfSettings;
cbf.hasFrame = false;

window.cbWidgets = cbWidgets;

