cbf = {

    getCatBeeUrl: function()
    {
        return "http://www.api.tribzi.com/CatBee/";
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

    parseUri :function (str) {

        var opts = {
            strictMode:false,
            key       :["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"],
            q         :{
                name  :"queryKey",
                parser:/(?:^|&)([^&=]*)=?([^&]*)/g
            },
            parser    :{
                strict:/^(?:([^:\/?#]+):)?(?:\/\/((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?))?((((?:[^?#\/]*\/)*)([^?#]*))(?:\?([^#]*))?(?:#(.*))?)/,
                loose :/^(?:(?![^:@]+:[^:@\/]*@)([^:\/?#.]+):)?(?:\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?([^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|jquery_fiveconnect)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/
            }
        };
        var o = opts,
            m = o.parser[o.strictMode ? "strict" : "loose"].exec(str),
            uri = {},
            i = 14;

        while (i--) uri[o.key[i]] = m[i] || "";

        uri[o.q.name] = {};
        uri[o.key[12]].replace(o.q.parser, function (jquery_fiveconnect0, jquery_fiveconnect1, jquery_fiveconnect2) {
            if (jquery_fiveconnect1) uri[o.q.name][jquery_fiveconnect1] = jquery_fiveconnect2;
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
            encodeURIComponent(jQuery.param(params.urlParams));

    },

    setupFrame:function (params) {

        var insert = "<div id='modalDiv' style='padding: 0; width: 430; height: 340; top: 300'><iframe id='catbeeFrame' width='100%' height='100%' marginWidth='0' marginHeight='0' frameBorder='0' scrolling='auto' title='Dialog Title'></iframe></div>";

        jquery_fiveconnect('body').append(insert);

        jquery_fiveconnect("#modalDiv").dialog({
            modal      :true,
            autoOpen   :false,
            position   :'center',
            height     :params.initHeight,
            width      :params.initWidth,
            draggable  :false,
            resizable  :false,
            dialogClass:'tribziDialog',
            //position: { my: 'top', at: 'top+10%', of: jquery_fiveconnect(this) }
            open: function(event, ui) {
                jquery_fiveconnect(event.target).parent().css('position', 'fixed');
                jquery_fiveconnect(event.target).parent().css('top', '5%');
                //jquery_fiveconnect(event.target).parent().css('left', '10px');
            }
        });

        jquery_fiveconnect("#closebtn").button({ icons:{ primary:"ui-icon-close" } });
        jquery_fiveconnect('.tribziDialog div.ui-dialog-titlebar').hide();
        jquery_fiveconnect('#modalDiv').css('overflow', 'hidden');
        //jquery_fiveconnect('.tribziDialog').css('overflow', 'hidden');

        url = this.buildUrl(params);

        jquery_fiveconnect("#modalDiv").dialog("open");
        jquery_fiveconnect("#catbeeFrame").attr('src', url);

        var cssObj = {
            'position'  :'absolute',
            'top'       :'-18px',
            'right'     :'-18px',
            'width'     :'36px',
            'height'    :'36px',
            'cursor'    :'pointer',
            'z-index'   :'8040',
            'background':'url(\'' + this.getCatBeeUrl() + 'public/res/images/fancybox_sprite.png\')'};

        if (params.closeButton) {
            jquery_fiveconnect('.tribziDialog').append("<div title='Close' class='dialog-close-button'></div>");
            jquery_fiveconnect('.dialog-close-button').css(cssObj)
                .click(function () {
                    jquery_fiveconnect("#modalDiv").dialog('close');
                });
        }

        setTimeout(checkIFrame, 200);

    }
};

window.cbf = cbf;

function checkIFrame() {
    var frameElement = document.getElementById('catbeeFrame');

    if (frameElement && (frameElement.contentWindow)) {
        var command = frameElement.contentWindow.name;
        if ((command) && (command.toString().indexOf('#') >= 0)) {

            command = command.substr(command.indexOf('#') + 1);

            pairs = command.split(';');
            params = [];

            for (var i = 0; i < pairs.length; i++) {
                pair = pairs[i].split('=');
                params[pair[0]] = pair[1];
            }

            if (params['act']) {
                switch (params['act'].toLowerCase()) {
                    case 'resize':
                    {
                        var sizes = {
                            height:params['h'],
                            width :params['w']
                        };
                        jquery_fiveconnect('.ui-dialog').css(sizes);
                        jquery_fiveconnect('#modalDiv').css(sizes);
                        break;
                    }
                    case 'close':
                    {
                        jquery_fiveconnect("#modalDiv").dialog('close');
                        break;
                    }
                    case "cookie":
                    {
                        cbf.setCookie(params['n'], params['v'], 1);
                        //todo set actions as array
                        jquery_fiveconnect("#modalDiv").dialog('close');
                        break;
                    }
                }
            }
            document.getElementById('catbeeFrame').contentWindow.name = 'catbeeFrame';
        }
    }
    setTimeout(checkIFrame, 200);
}

