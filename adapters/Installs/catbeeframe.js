cbf = {

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

    parseUri:function (str) {

        var opts = {
            strictMode:false,
            key       :["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"],
            q         :{
                name  :"queryKey",
                parser:/(?:^|&)([^&=]*)=?([^&]*)/g
            },
            parser    :{
                strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                loose :/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|jQuery)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
            }
        };
        var o = opts,
            m = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
            uri = {},
            i = 14;

        while (i--) uri[o.key[i]] = m[i] || "";

        uri[o.q.name] = {};
        uri[o.key[12]].replace(o.q.parser, function (jQuery0, jQuery1, jQuery2) {
            if (jQuery1) uri[o.q.name][jQuery1] = jQuery2;
        });

        return uri;
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

                        jQuery('#cbfContainer').css(sizes);
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
        jQuery('<div id="cbfOverlay"></div>').appendTo('body');

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
        jQuery('#cbfOverlay').css(cssOverlay);

        jQuery('<div id="cbfFrame"><div id="cbfContainer"></div></div>').appendTo('body');
        var cssFrame = {
            display  :'block',
            position :'fixed',
            top      :'10%',
            left     :'40%',
            width    :params.initWidth + 'px',
            height   :params.initHeight + 'px',
            'z-index':'1003'
        };
        jQuery('#cbfFrame').css(cssFrame);

        var cssDialog = {
            width:'100%', height:'100%'
        };
        jQuery('#cbfContainer').css(cssDialog);

        if (params.closeButton) {
            jQuery('<div title="Close" id="cbfCloseBtn"></div>').appendTo('#cbfFrame');
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

            jQuery('#cbfCloseBtn').css(cssButton)
                .click(function () {
                    cbf.closeFrame();
                });
        }

        this.setupRpc(params);

    },

    closeFrame:function () {
        jQuery('#cbfFrame').css('display', 'none');
        jQuery('#cbfOverlay').css('display', 'none');

    },

    setupFrame:function (params) {

        this.frameParams = params;
        if (typeof esyXDM == 'undefined') {
            if (typeof JSON == 'undefined') {
                var jsSrc = cbf.getCatBeeUrl() + "public/res/js/min/json2.min.js";
                jQuery.getScript(jsSrc);

            }
            var jsSrc = cbf.getCatBeeUrl() + "public/res/js/min/easyXDM.min.js";
            jQuery.getScript(jsSrc, function (data, textStatus, jqxhr) {
                cbf.buildFrame();
            });

        }
        else {
            cbf.buildFrame();
        }

    }
};

window.cbf = cbf;
