/*! jCarousel - v0.3.0-beta.2 - 2013-02-25
* http://sorgalla.com/jcarousel
* Copyright (c) 2013 Jan Sorgalla; Licensed MIT */
(function(t){"use strict";t.jCarousel.plugin("jcarouselAutoscroll",{_options:{target:"+=1",interval:3e3,autostart:!0},_timer:null,_init:function(){this.onDestroy=t.proxy(function(){this._destroy(),this.carousel().one("createend.jcarousel",t.proxy(this._create,this))},this),this.onAnimateEnd=t.proxy(this.start,this)},_create:function(){this.carousel().one("destroy.jcarousel",this.onDestroy),this.options("autostart")&&this.start()},_destroy:function(){this.stop(),this.carousel().unbind("destroy.jcarousel",this.onDestroy)},start:function(){return this.stop(),this.carousel().one("animateend.jcarousel",this.onAnimateEnd),this._timer=setTimeout(t.proxy(function(){this.carousel().jcarousel("scroll",this.options("target"))},this),this.options("interval")),this},stop:function(){return this._timer&&(this._timer=clearTimeout(this._timer)),this.carousel().unbind("animateend.jcarousel",this.onAnimateEnd),this}})})(jQuery);