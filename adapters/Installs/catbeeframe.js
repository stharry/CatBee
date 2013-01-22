cbf = {

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
        return 'http://127.0.0.1:8080/CatBee/api/deal/?action=' + params.catbeeAction + '&context=' +
            encodeURIComponent(JSON.stringify(params.urlParams));

    },

    setupFrame:function (params) {

        var insert = "<div id='modalDiv' style='padding: 0; width: 430; height: 340; top: 300'><iframe id='catbeeFrame' width='100%' height='100%' marginWidth='0' marginHeight='0' frameBorder='0' scrolling='auto' title='Dialog Title'></iframe></div>";

        jQuery('body').append(insert);

        jQuery("#modalDiv").dialog({
            modal      :true,
            autoOpen   :false,
            position   :'center',
            height     :params.initHeight,
            width      :params.initWidth,
            draggable  :false,
            resizable  :false,
            dialogClass:'tribziDialog',
            position: { my: 'left', at: 'right', of: jQuery(this) }
        });

        jQuery("#closebtn").button({ icons:{ primary:"ui-icon-close" } });
        jQuery('.tribziDialog div.ui-dialog-titlebar').hide();
        jQuery('#modalDiv').css('overflow', 'hidden');
        //jQuery('.tribziDialog').css('overflow', 'hidden');

        url = this.buildUrl(params);

        jQuery("#modalDiv").dialog("open");
        jQuery("#catbeeFrame").attr('src', url);

        var cssObj = {
            'position'  :'absolute',
            'top'       :'-18px',
            'right'     :'-18px',
            'width'     :'36px',
            'height'    :'36px',
            'cursor'    :'pointer',
            'z-index'   :'8040',
            'background':'url(\'http://127.0.0.1:8080/CatBee/public/res/images/fancybox_sprite.png\')'};

        if (params.closeButton) {
            jQuery('.tribziDialog').append("<div title='Close' class='dialog-close-button'></div>");
            jQuery('.dialog-close-button').css(cssObj)
                .click(function () {
                    jQuery("#modalDiv").dialog('close');
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
                        jQuery('.ui-dialog').css(sizes);
                        jQuery('#modalDiv').css(sizes);
                        break;
                    }
                    case 'close':
                    {
                        jQuery("#modalDiv").dialog('close');
                        break;
                    }
                    case "cookie":
                    {
                        cbf.setCookie(params['n'], params['v'], 1);
                        //todo set actions as array
                        jQuery("#modalDiv").dialog('close');
                        break;
                    }
                }
            }
            document.getElementById('catbeeFrame').contentWindow.name = 'catbeeFrame';
        }
    }
    setTimeout(checkIFrame, 200);
}

