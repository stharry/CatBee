(function(f){var k=f.jCarousel={};k.version="0.3.0-beta.2";var l=/^([+\-]=)?(.+)$/;k.parseTarget=function(a){var c=!1,b="object"!==typeof a?l.exec(a):null;b?(a=parseInt(b[2],10)||0,b[1]&&(c=!0,"-="===b[1]&&(a*=-1))):"object"!==typeof a&&(a=parseInt(a,10)||0);return{target:a,relative:c}};k.detectCarousel=function(a){for(var c;0<a.size();){c=a.filter("[data-jcarousel]");if(0<c.size())return c;c=a.find("[data-jcarousel]");if(0<c.size())return c;a=a.parent()}return null};k.base=function(a){return{version:k.version,
_options:{},_element:null,_carousel:null,_init:f.noop,_create:f.noop,_destroy:f.noop,_reload:f.noop,create:function(){this._element.attr("data-"+a.toLowerCase(),!0).data(a,this);if(!1===this._trigger("create"))return this;this._create();this._trigger("createend");return this},destroy:function(){if(!1===this._trigger("destroy"))return this;this._destroy();this._trigger("destroyend");this._element.removeData(a).removeAttr("data-"+a.toLowerCase());return this},reload:function(a){if(!1===this._trigger("reload"))return this;
a&&this.options(a);this._reload();this._trigger("reloadend");return this},element:function(){return this._element},options:function(a,b){if(0===arguments.length)return f.extend({},this._options);if("string"===typeof a){if("undefined"===typeof b)return"undefined"===typeof this._options[a]?null:this._options[a];this._options[a]=b}else this._options=f.extend({},this._options,a);return this},carousel:function(){this._carousel||(this._carousel=k.detectCarousel(this.options("carousel")||this._element))||
f.error('Could not detect carousel for plugin "'+a+'"');return this._carousel},_trigger:function(c,b,e){var d,g=!1;e=[this].concat(e||[]);(b||this._element).each(function(){d=f.Event((c+"."+a).toLowerCase());f(this).trigger(d,e);d.isDefaultPrevented()&&(g=!0)});return!g}}};k.plugin=function(a,c){var b=f[a]=function(a,b){this._element=f(a);this.options(b);this._init();this.create()};b.fn=b.prototype=f.extend({},k.base(a),c);f.fn[a]=function(c){var d=Array.prototype.slice.call(arguments,1),g=this;"string"===
typeof c?this.each(function(){var b=f(this).data(a);if(!b)return f.error("Cannot call methods on "+a+' prior to initialization; attempted to call method "'+c+'"');if(!f.isFunction(b[c])||"_"===c.charAt(0))return f.error('No such method "'+c+'" for '+a+" instance");var j=b[c].apply(b,d);if(j!==b&&"undefined"!==typeof j)return g=j,!1}):this.each(function(){var d=f(this).data(a);d instanceof b?d.reload(c):new b(this,c)});return g};return b}})(jQuery);
(function(f,k){var l=function(a){return parseFloat(a)||0};f.jCarousel.plugin("jcarousel",{animating:!1,tail:0,inTail:!1,resizeTimer:null,lt:null,vertical:!1,rtl:!1,circular:!1,underflow:!1,_options:{list:function(){return this.element().children().eq(0)},items:function(){return this.list().children()},animation:400,wrap:null,vertical:null,rtl:null,center:!1},_list:null,_items:null,_target:null,_first:null,_last:null,_visible:null,_fullyvisible:null,_init:function(){var a=this;this.onWindowResize=
function(){a.resizeTimer&&clearTimeout(a.resizeTimer);a.resizeTimer=setTimeout(function(){a.reload()},100)};this.onAnimationComplete=function(c){a.animating=!1;var b=a.list().find("[data-jcarousel-clone]");0<b.size()&&(b.remove(),a._reload());a._trigger("animateend");f.isFunction(c)&&c.call(a,!0)};return this},_create:function(){this._reload();f(k).bind("resize.jcarousel",this.onWindowResize)},_destroy:function(){f(k).unbind("resize.jcarousel",this.onWindowResize)},_reload:function(){this.vertical=
this.options("vertical");null==this.vertical&&(this.vertical=this.list().height()>this.list().width());this.rtl=this.options("rtl");if(null==this.rtl){var a;a=this._element;if("rtl"===(""+a.attr("dir")).toLowerCase())a=!0;else{var c=!1;a.parents("[dir]").each(function(){if(/rtl/i.test(f(this).attr("dir")))return c=!0,!1});a=c}this.rtl=a}this.lt=this.vertical?"top":"left";this._items=null;a=this._target&&0<=this.index(this._target)?this._target:this.closest();this.circular="circular"===this.options("wrap");
this.underflow=!1;0<a.size()?(this._prepare(a),this.list().find("[data-jcarousel-clone]").remove(),this._items=null,this.underflow=this._fullyvisible.size()>=this.items().size(),this.circular=this.circular&&!this.underflow,this.list().css(this.lt,this._position(a)+"px")):this.list().css({left:0,top:0});return this},list:function(){if(null===this._list){var a=this.options("list");this._list=f.isFunction(a)?a.call(this):this._element.find(a)}return this._list},items:function(){if(null===this._items){var a=
this.options("items");this._items=(f.isFunction(a)?a.call(this):this.list().find(a)).not("[data-jcarousel-clone]")}return this._items},index:function(a){return this.items().index(a)},closest:function(){var a=this,c=this.list().position()[this.lt],b=f(),e=!1,d=this.vertical?"bottom":this.rtl?"left":"right",g;this.rtl&&!this.vertical&&(c=-1*(c+this.list().width()-this.clipping()));this.items().each(function(){b=f(this);if(e)return!1;var h=a.dimension(b);c+=h;if(0<=c)if(g=h-l(b.css("margin-"+d)),0>=
Math.abs(c)-h+g/2)e=!0;else return!1});return b},target:function(){return this._target},first:function(){return this._first},last:function(){return this._last},visible:function(){return this._visible},fullyvisible:function(){return this._fullyvisible},hasNext:function(){if(!1===this._trigger("hasnext"))return!0;var a=this.options("wrap"),c=this.items().size()-1;return 0<=c&&(a&&"first"!==a||this.index(this._last)<c||this.tail&&!this.inTail)?!0:!1},hasPrev:function(){if(!1===this._trigger("hasprev"))return!0;
var a=this.options("wrap");return 0<this.items().size()&&(a&&"last"!==a||0<this.index(this._first)||this.tail&&this.inTail)?!0:!1},clipping:function(){return this._element["inner"+(this.vertical?"Height":"Width")]()},dimension:function(a){return a["outer"+(this.vertical?"Height":"Width")](!0)},scroll:function(a,c,b){if(this.animating||!1===this._trigger("scroll",null,[a,c]))return this;f.isFunction(c)&&(b=c,c=!0);var e=f.jCarousel.parseTarget(a);if(e.relative){var d=this.items().size()-1,g=Math.abs(e.target),
h=this.options("wrap");if(0<e.target){var j=this.index(this._last);if(j>=d&&this.tail)this.inTail?"both"===h||"last"===h?this._scroll(0,c,b):this._scroll(Math.min(this.index(this._target)+g,d),c,b):this._scrollTail(c,b);else if(e=this.index(this._target),this.underflow&&a===d&&("circular"===h||"both"===h||"last"===h)||!this.underflow&&j===d&&("both"===h||"last"===h))this._scroll(0,c,b);else if(g=e+g,this.circular&&g>d){h=d;for(d=this.items().get(-1);h++<g;)d=this.items().eq(0),d.after(d.clone(!0).attr("data-jcarousel-clone",
!0)),this.list().append(d),this._items=null;this._scroll(d,c,b)}else this._scroll(Math.min(g,d),c,b)}else if(this.inTail)this._scroll(Math.max(this.index(this._first)-g+1,0),c,b);else if(a=this.index(this._first),e=this.index(this._target),a=this.underflow?e:a,g=a-g,0>=a&&(this.underflow&&"circular"===h||"both"===h||"first"===h))this._scroll(d,c,b);else if(this.circular&&0>g){h=g;for(d=this.items().get(0);0>h++;)d=this.items().eq(-1),d.after(d.clone(!0).attr("data-jcarousel-clone",!0)),this.list().prepend(d),
this._items=null,g=l(this.list().css(this.lt)),a=this.dimension(d),g=this.rtl&&!this.vertical?g+a:g-a,this.list().css(this.lt,g+"px");this._scroll(d,c,b)}else this._scroll(Math.max(g,0),c,b)}else this._scroll(e.target,c,b);this._trigger("scrollend");return this},_scroll:function(a,c,b){if(this.animating)return f.isFunction(b)&&b.call(this,!1),this;"object"!==typeof a?a=this.items().eq(a):"undefined"===typeof a.jquery&&(a=f(a));if(0===a.size())return f.isFunction(b)&&b.call(this,!1),this;this.inTail=
!1;this._prepare(a);a=this._position(a);var e=l(this.list().css(this.lt));if(a===e)return f.isFunction(b)&&b.call(this,!1),this;e={};e[this.lt]=a+"px";this._animate(e,c,b);return this},_scrollTail:function(a,c){if(this.animating||!this.tail)return f.isFunction(c)&&c.call(this,!1),this;var b=this.list().position()[this.lt],b=this.rtl?b+this.tail:b-this.tail;this.inTail=!0;var e={};e[this.lt]=b+"px";this._update({target:this._target.next(),fullyvisible:this._fullyvisible.slice(1).add(this._visible.last())});
this._animate(e,a,c);return this},_animate:function(a,c,b){if(!1===this._trigger("animate"))return f.isFunction(b)&&b.call(this,!1),this;this.animating=!0;var e=this.options("animation");if(!e||!1===c)this.list().css(a),this.onAnimationComplete(b);else{var d=this;if(f.isFunction(e))e.call(this,a,function(){d.onAnimationComplete(b)});else{c="object"===typeof e?f.extend({},e):{duration:e};var g=c.complete;c.complete=function(){d.onAnimationComplete(b);f.isFunction(g)&&g.call(this)};this.list().animate(a,
c)}}return this},_prepare:function(a){var c=this.index(a),b=c,e=this.dimension(a),d=this.clipping(),g=this.vertical?"bottom":this.rtl?"left":"right",h={target:a,first:a,last:a,visible:a,fullyvisible:e<=d?a:f()},j,k;this.options("center")&&(e/=2,d/=2);if(e<d)for(;;){j=this.items().eq(++b);if(0===j.size())if(this.circular){j=this.items().eq(0);if(a.get(0)===j.get(0))break;j.after(j.clone(!0).attr("data-jcarousel-clone",!0));this.list().append(j);this._items=null}else break;e+=this.dimension(j);h.last=
j;h.visible=h.visible.add(j);k=l(j.css("margin-"+g));e-k<=d&&(h.fullyvisible=h.fullyvisible.add(j));if(e>=d)break}if(!this.circular&&e<d)for(b=c;!(0>--b);){j=this.items().eq(b);if(0===j.size())break;e+=this.dimension(j);h.first=j;h.visible=h.visible.add(j);k=l(j.css("margin-"+g));e-k<=d&&(h.fullyvisible=h.fullyvisible.add(j));if(e>=d)break}this._update(h);this.tail=0;"circular"!==this.options("wrap")&&("custom"!==this.options("wrap")&&this.index(h.last)===this.items().size()-1)&&(e-=l(h.last.css("margin-"+
g)),e>d&&(this.tail=e-d));return this},_position:function(a){var c=this._first,b=c.position()[this.lt];this.rtl&&!this.vertical&&(b-=this.clipping()-this.dimension(c));this.options("center")&&(b-=this.clipping()/2-this.dimension(c)/2);(this.index(a)>this.index(c)||this.inTail)&&this.tail?(b=this.rtl?b-this.tail:b+this.tail,this.inTail=!0):this.inTail=!1;return-b},_update:function(a){var c=this,b={target:this._target||f(),first:this._first||f(),last:this._last||f(),visible:this._visible||f(),fullyvisible:this._fullyvisible||
f()},e=this.index(a.first||b.first)<this.index(b.first),d,g=function(d){var g=[],k=[];a[d].each(function(){0>b[d].index(this)&&g.push(this)});b[d].each(function(){0>a[d].index(this)&&k.push(this)});e?g=g.reverse():k=k.reverse();c._trigger("item"+d+"in",f(g));c._trigger("item"+d+"out",f(k));c["_"+d]=a[d]};for(d in a)g(d);return this}})})(jQuery,window);