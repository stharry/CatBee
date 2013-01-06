/* Copyright (c) 2010 Chris O'Hara <cohara87@gmail.com>. MIT Licensed */

var head = document.getElementsByTagName('head')[0] || document.documentElement;

addMethod('load', function (args, argc) {
    for (var queue = [], i = 0; i < argc; i++) {
        (function (i) {
            queue.push(asyncLoadScript(args[i]));
        }(i));
    }
    this.call('run', queue);
});

function asyncLoadScript(src) {
    return function (onload, onerror) {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = src;
        script.onload = onload;
        script.onerror = onerror;
        script.onreadystatechange = function () {
            var state = this.readyState;
            if (state === 'loaded' || state === 'complete') {
                script.onreadystatechange = null;
                onload();
            }
        };
        head.insertBefore(script, head.firstChild);
    }
}
