TribZi={setupTribZi:function(){"function"!==typeof String.prototype.trim&&(String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g,"")});return this},openSocket:function(){this.rpc=new easyXDM.Rpc({},{remote:{resizeFrame:{},closeFrame:{},sendCookieToFrame:{},showAddressBook:{}}});return this},init:function(a){this.deal=a.deal;this.selectedRewardIndex=0;this.targets=[];this.sharedTimes=0;this.sharePoint=a.sharePoint;this.setupTribZi();this.openSocket();return this},initFriendDeal:function(a){this.friendDeal=
a.friendDeal;this.selectedRewardIndex=0;this.targets=[];this.sharedTimes=0;this.sharePoint=a.sharePoint;this.setupTribZi();this.openSocket();return this},setUid:function(a){this.uid=a;return this},setShareLink:function(a){this.shareLink=a;return this},setRewardIndex:function(a){this.selectedRewardIndex=a;return this},setCustomMessage:function(a){this.deal.landing.customMessage=a;return this},clearTargets:function(){this.targets=[];return this},addTarget:function(a,c,b,f){b={name:b,from:a,to:c,context:{type:f}};
this.targets.push(b);return this},shortenLink:function(a,c){var b="https://api-ssl.bitly.com/v3/shorten?access_token=57973b2f6a137f2c5f0f4d1b852032c2d3993bcd&longUrl="+encodeURIComponent(a);this.requestAnyData(b,null,function(a){c(a.data.url)})},requestData:function(a,c){return this.requestAnyData(this.sharePoint,a,c)},requestAnyData:function(a,c,b){xmlhttp=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");xmlhttp.onreadystatechange=function(){if(4==xmlhttp.readyState&&
200==xmlhttp.status)try{var a=JSON.parse(xmlhttp.responseText);null!==b&&b(a)}catch(c){}};try{if(c){var f=jQuery.param(c);xmlhttp.open("POST",a,!0);xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");xmlhttp.setRequestHeader("Content-Length",f.length);xmlhttp.send(f)}else xmlhttp.open("GET",a,!0),xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),xmlhttp.send()}catch(d){}},doShareAction:function(a,c){var b={action:a,context:{customMessage:this.deal.landing.customMessage,
deal:this.deal,context:{type:this.targets[0].context.type},reward:this.deal.landing.landingRewards[this.selectedRewardIndex],urlShare:this.deal.urlShareContext.link,targets:this.targets}};this.uid&&(b.context.context.uid=this.uid);this.requestData(b,c);return this},share:function(a){0==this.sharedTimes&&this.addTarget(TribZi.deal.order.branch.email,TribZi.deal.order.branch.email,"leader","email");this.doShareAction("share deal",a);0==this.sharedTimes&&this.clearTargets().addTarget(TribZi.deal.order.branch.email,
TribZi.deal.order.customer.email,"friend","urlShare").setUid(TribZi.deal.urlShareContext.uid).doShareAction("share deal",null);this.sharedTimes++;return this},fillShare:function(a,c){return this.doShareAction("fill share",c)},parseMessage:function(a){for(var c=[{key:"[reward.friendReward.code]",val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.code},{key:"[reward.friendReward.value]",val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.value},{key:"[reward.friendReward.typeDescription]",
val:this.deal.landing.landingRewards[this.selectedRewardIndex].friendReward.typeDescription},{key:"[context.link]",val:this.shareLink}],b=0;b<c.length;b++)a=a.replace(c[b].key,c[b].val);return a},saveCoupon:function(){$.cookie("CatBeeCpnCod",this.friendDeal.share.reward.friendReward.code);$.cookie("CatBeeCpnVal",this.friendDeal.share.reward.friendReward.value);$.cookie("CatBeeRefId",this.friendDeal.share.context.uid);this.rpc.sendCookieToFrame("CatBeeCpnCod",this.friendDeal.share.reward.friendReward.code);
this.rpc.sendCookieToFrame("CatBeeCpnVal",this.friendDeal.share.reward.friendReward.value);this.rpc.sendCookieToFrame("CatBeeRefId",this.friendDeal.share.context.uid);return this},getReferral:function(){return $.cookie("CatBeeRefId")},getCouponCode:function(){return $.cookie("CatBeeCpnCod")},getCouponValue:function(){return $.cookie("CatBeeCpnVal")},injectCoupon:function(a){$("#"+a).value($.cookie("CatBeeCpnCod"))},getRoot:function(){url=this.sharePoint.toString().replace(/^(.*\/\/[^\/?#]*).*$/,"$1");
-1==url.toLowerCase().indexOf("/CatBee")&&(url+="/CatBee");return url},closeFrame:function(){this.rpc.closeFrame();return this},resizeFrame:function(a,c,b){function f(a,b){for(var c=0,d=0;d<b.length;d++){var e;e=$(a).css(b[d]);e="undefined"==typeof e||null==e?"0":e.replace("px","");c+=Math.round(!isNaN(parseFloat(e))&&isFinite(e)?parseFloat(e):0)}return c}var d=b?b:".box";b=Math.round(parseFloat($(d).width()))+f(d,["border-left","padding-left","border-right","padding-right"]);d=Math.round(parseFloat($(d).height()))+
f(d,["border-top","padding-top","border-bottom","padding-bottom"]);a&&(b+=a);c&&(d+=c);this.rpc.resizeFrame(b,d);return this}};window.TribZi=TribZi;