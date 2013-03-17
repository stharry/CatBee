//--landing.js
function showSuccess(a){$(".thank-you").text(a?a:"Thank you for sharing");$("#slider-blue-content").find(".slider-description").addClass("inv");$("#slider-blue-content").find(".slider-wrapper").addClass("inv");$("#slider_inactive").removeClass("inv")}
function _makeCatYellow(){$(".cat_icon").css({"background-position":"-154px 0px"});$(".bee_icon").css({"background-position":"-283px 0px"});$("#bee_icon_opacity").css({opacity:1,"background-position":"-283px 0px"});$("#cat_icon_opacity").css({"background-position":"-154px 0px",opacity:1})}
function _makeBeesYellow(){$(".cat_icon").css({"background-position":"-77px 0px"});$(".bee_icon").css({"background-position":"-335px 0px"});$("#cat_icon_opacity").css({"background-position":"-77px 0px",opacity:1});$("#bee_icon_opacity").css({"background-position":"-335px 0px",opacity:1})}
function _calculateColor(a){var b=parseInt($("#slider").slider("option","max"))/2;parseInt($("#slider").slider("option","min"));a<b?(a=1-a/b,$("#cat_icon_opacity").css({opacity:a,"background-position":"-154px 0px"}),$(".cat_icon").css({"background-position":"0px 0px"}),$("#bee_icon_opacity").css({"background-position":"-283px 0px",opacity:a})):a>b?(a=(a-b)/b,$("#cat_icon_opacity").css({"background-position":"-77px 0px",opacity:a}),$(".cat_icon").css({"background-position":"0px 0px"}),$(".bee_icon").css({"background-position":"-283px 0px"}),
$("#bee_icon_opacity").css({"background-position":"-335px 0px",opacity:a})):($("#cat_icon_opacity").css("opacity",0.01),$("#bee_icon_opacity").css("opacity",0.01),$(".cat_icon").css({"background-position":"0px 0px"}),$(".bee_icon").css({"background-position":"-232px 0px"}))}function switchEmailBox(){"none"==$(".email-form").css("display")?($(".email-form").show(),$("#emailShare").parent().addClass("active")):($(".email-form").hide(),$("#emailShare").parent().removeClass("active"))}
$(document).ready(function(){$(".box").mutate("height width",function(){TribZi.resizeFrame(2,2)});$(".email-form").hide();$("#slider").slider({animate:!0,min:0,max:TribZi.deal.landing.landingRewards.length-1,value:Math.round((TribZi.deal.landing.landingRewards.length-1)/2),slide:function(a,b){updateRewards(b.value);0==b.value?_makeCatYellow():b.value==$(this).data("slider").options.max?_makeBeesYellow():_calculateColor(b.value)},start:function(a,b){b.handle.rel=b.value}});$(".cat_icon, #cat_icon_opacity").dblclick(function(){if($(this).hasClass("dontclick"))return!1;
$("#slider").slider("value",$("#slider").data("slider").options.min);updateRewards($("#slider").slider("value"));_makeCatYellow()});$(".cat_icon, #cat_icon_opacity").click(function(){if($(this).hasClass("dontclick"))return!1;var a=$("#slider").slider("value");parseInt($("#slider").slider("option","max"));parseInt($("#slider").slider("option","min"));0<a&&$("#slider").slider("value",a-1);0==$("#slider").slider("value")?_makeCatYellow():_calculateColor($("#slider").slider("value"));updateRewards($("#slider").slider("value"))});
$(".bee_icon, #bee_icon_opacity").dblclick(function(){if($(this).hasClass("dontclick"))return!1;$("#slider").slider("value",$("#slider").data("slider").options.max);_makeBeesYellow();updateRewards($("#slider").slider("value"))});$(".bee_icon, #bee_icon_opacity").click(function(){if($(this).hasClass("dontclick"))return!1;var a=$("#slider").slider("value");a<TribZi.deal.landing.landingRewards.length-1&&$("#slider").slider("value",a+1);$("#slider").slider("value")==$("#slider").data("slider").options.max?
_makeBeesYellow():_calculateColor($("#slider").slider("value"));updateRewards($("#slider").slider("value"))});updateBoxPosition();updateRewards(Math.round((TribZi.deal.landing.landingRewards.length-1)/2));$(".share-box a").hover(function(){$(".share-hover ."+$(this).attr("rel")).css("visibility","visible")},function(){$(".share-hover ."+$(this).attr("rel")).is(".active")||$(".share-hover ."+$(this).attr("rel")).css("visibility","hidden")});$('.share-box a[rel="email"]').click(function(){$("#message").css("color",
"#4F432D");"none"==$(".email-form").css("display")&&(hidePinterestBox(),hideTwitterBox(),$("#share_list").find("li").removeClass("active"));switchEmailBox()});$("textarea").each(function(){var a=$(this);""===a.val()&&(a.val(a.attr("title")),a.css("color","#bfbfbf"));a.focus(function(){a.val()===a.attr("title")&&(a.val(""),a.css("color","#000000"))});a.blur(function(){""===a.val()&&(a.val(a.attr("title")),a.css("color","#bfbfbf"))})})});function goToByScroll(){}
function openWindow(){$(".box-wrapper").fadeIn();return!1}function UpdateleaderRewardTypes(a,b){"$"==TribZi.deal.landing.landingRewards[a].leaderReward.typeDescription?$(b).text(""+TribZi.deal.landing.landingRewards[a].leaderReward.typeDescription+TribZi.deal.landing.landingRewards[a].leaderReward.value):$(b).text(""+TribZi.deal.landing.landingRewards[a].leaderReward.value+TribZi.deal.landing.landingRewards[a].leaderReward.typeDescription)}
function UpdateFriendRewardTypes(a,b){"$"==TribZi.deal.landing.landingRewards[a].friendReward.typeDescription?$(b).text(""+TribZi.deal.landing.landingRewards[a].friendReward.typeDescription+TribZi.deal.landing.landingRewards[a].friendReward.value):$(b).text(""+TribZi.deal.landing.landingRewards[a].friendReward.value+TribZi.deal.landing.landingRewards[a].friendReward.typeDescription)}
function UpdateFriendRewardTypesVal(a,b){"$"==TribZi.deal.landing.landingRewards[a].friendReward.typeDescription?$(b).val(""+TribZi.deal.landing.landingRewards[a].friendReward.typeDescription+TribZi.deal.landing.landingRewards[a].friendReward.value):$(b).val(""+TribZi.deal.landing.landingRewards[a].friendReward.value+TribZi.deal.landing.landingRewards[a].friendReward.typeDescription)}
function updateRewards(a){$("#LeaderRewardPhrase").text(TribZi.deal.landing.landingRewards[a].leaderReward.description);$("#LeaderReward").val(TribZi.deal.landing.landingRewards[a].leaderReward.typeDescription+TribZi.deal.landing.landingRewards[a].leaderReward.value);UpdateleaderRewardTypes(a,"#info_you");$("#info_you_desc").text(""+TribZi.deal.landing.landingRewards[a].leaderReward.type);$("#FriendRewardPhrase").text(TribZi.deal.landing.landingRewards[a].friendReward.description);UpdateFriendRewardTypes(a,
"#percent_friends");UpdateFriendRewardTypesVal(a,"#FriendReward");$("#info_friend_desc").text(""+TribZi.deal.landing.landingRewards[a].friendReward.type);TribZi.setRewardIndex(a);setTwitterMessage();setPinterestMessage()}function updateBoxPosition(){var a=$(window).height(),b=$(window).width();$(".box-wrapper").css("top",a/2-$(".box-wrapper").height()/2);$(".box-wrapper").css("left",b/2-$(".box-wrapper").width()/2)};

//--pinterest.js
$(document).ready(function(){$(".jcarousel").jcarousel({list:".jcarousel-list",vertical:!0,animation:{easing:"linear"}}).jcarouselAutoscroll({autostart:!1,interval:0});$(".jcarousel-prev").hover(function(){$(".jcarousel").jcarouselAutoscroll("reload",{target:"-=1"});$(".jcarousel").jcarouselAutoscroll("start")},function(){$(".jcarousel").jcarouselAutoscroll("stop")});$(".jcarousel-next").hover(function(){$(".jcarousel").jcarouselAutoscroll("reload",{target:"+=1"});$(".jcarousel").jcarouselAutoscroll("start")},
function(){$(".jcarousel").jcarouselAutoscroll("stop")});$.each(TribZi.deal.order.items,function(a,b){$(".jcarousel-list").append('<li><img src="'+decodeURIComponent(b.url)+'" width="75" height="75" alt="" /></li>')});$("ul.jcarousel-list li").click(function(){$(this).addClass("selected-image").removeClass("unselected-image").siblings().addClass("unselected-image").removeClass("selected-image")});3>=TribZi.deal.order.items.length&&($(".jcarousel-prev").hide(),$(".jcarousel-next").hide());1<=$("ul.jcarousel-list li").length&&
$("ul.jcarousel-list li:first").click();$("#pinterestSubmit").click(function(a){a.preventDefault();var b=$("#pinterest-message").text();$("a#pinterestSubmit").attr("href",function(a,c){var d=c.indexOf("url="),e=encodeURIComponent(TribZi.deal.pintContext.link),f=encodeURIComponent($(".selected-image").children().attr("src"));encodeURIComponent($("#pinterest-message").val());console.log("returning "+c.substr(0,d)+e+"&media="+f+"&description="+b);return c.substr(0,d+4)+e+"&media="+f+"&description="+
b});window.open($("a#pinterestSubmit").attr("href"),"Pinterest","width=690,height=255");TribZi.clearTargets().addTarget(TribZi.deal.order.customer.email,TribZi.deal.order.customer.email,"friend","pinterest").setCustomMessage(b).setRewardIndex($("#slider").slider("value")).setUid(TribZi.deal.pintContext.uid);TribZi.share(null);showSuccess("Thanks For sharing! Your reward for next purchase is on the way!")});CreateAndInitializePinterestForm();hidePinterestBox()});
function CreateAndInitializePinterestForm(){$("#pinterestShare").click(function(){"none"===$(".pinterest-form").css("display")?showPinterestBox():hidePinterestBox()})}function hidePinterestBox(){$("#pinterestForm").hide();$("#pinterest_shadow_div").addClass("inv");$("#pinterestShare").parent().removeClass("active")}
function showPinterestBox(){"none"!==$("#emailForm").css("display")&&$("#emailForm").css("display","none");"none"!==$("#tbox").css("display")&&hideTwitterBox();"none"!==$("#facebookForm").css("display")&&$("#facebookForm").css("display","none");$("#pinterestForm").show();$("#share_list").find("li").removeClass("active");$("#pinterestShare").parent().addClass("active");$("#pinterest_shadow_div").removeClass("inv")}function createPinterestBox(){}
function setPinterestMessage(){var a=TribZi.setShareLink(TribZi.deal.pintContext.link).parseMessage(TribZi.deal.pintContext.message);$("#pinterest-message").text(a)};

//--email.js
$(document).ready(function(){CreateAndInitializeEmailForm()});
function CreateAndInitializeEmailForm(){$(".import-contacts").click(function(){TribZi.rpc.showAddressBook()});$("#message").val(TribZi.deal.landing.customMessage);$("#contact").submit(function(){return!1});$("#message").keyup(function(){TribZi.setCustomMessage($("#message").val())});$("#emailSubmit").click(function(){var a=$("#mail-input").val(),b=$("#message").val().length,a=validateEmail(a);!1==a?$("#mail-input").addClass("error"):!0==a&&$("#mail-input").removeClass("error");4>b?$("#message").addClass("error"):
4<=b&&$("#message").removeClass("error");!0==a&&4<=b&&(TribZi.clearTargets().setUid(null).addTarget(TribZi.deal.order.customer.email,$("#mail-input").val(),"friend","email").setCustomMessage($("#message").val()).setRewardIndex($("#slider").slider("value")),TribZi.share(null),showSuccess("Your message has been sent! Your reward for next purchase is on the way! Keep on sharing"),switchToTwitter())})}
function switchToTwitter(){setTimeout(function(){$("#emailShare").click();$("#twitterShare").click();$("#tbox").find("iframe").contents().find("#tweet-box").focus()},500)}function validateEmail(a){a=a.split(",");if(0==a.length)return!1;for(i=0;i<a.length;i++){var b=a[i].trim();if(0==b.length)break;if(!/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(b))return!1}return!0};

//--twitter.js
$(document).ready(function(){$.getScript("https://platform.twitter.com/widgets.js",function(){twttr.events.bind("tweet",function(a){a&&(TribZi.clearTargets().addTarget(TribZi.deal.order.customer.email,TribZi.deal.order.customer.email,"friend","twitter").setCustomMessage($("#twitterShare").attr("custom_message")).setRewardIndex($("#slider").slider("value")).setUid(TribZi.deal.twitContext.uid),TribZi.share(null),showSuccess("Thanks For Tweeting! Your reward for next purchase is on the way! Keep on sharing"),
$("#twitterShare").click(),$("#emailShare").click())});setTwitterMessage()});$("#twitterShare").click(function(){setTwitterMessage();"none"!==$(".email-form").css("display")&&switchEmailBox();hidePinterestBox()})});
function setTwitterMessage(){var a=TribZi.setShareLink(TribZi.deal.twitContext.link).parseMessage(TribZi.deal.twitContext.message),b="https://twitter.com/intent/tweet?text="+encodeURIComponent(a)+"&tw_p=tweetbutton&url=%20";$("#twitterShare").attr("href",b);$("#twitterShare").attr("custom_message",a)}function hideTwitterBox(){};

//--facebook.js
$(document).ready(function(){InitFacebook()});function InitFacebook(){$(".facebook-form").hide();$("#ContactsArea").hide();FB.init({appId:TribZi.deal.fbcContext.application.applicationCode,status:!0,cookie:!0});$("#facebookShare").click(function(){$("#share_list").find("li").removeClass("active");$(this).parent().addClass("active");"none"!=$("#emailForm").css("display")&&$("#emailForm").css("display","none");hidePinterestBox();hideTwitterBox();StartFacebookSharing()})}
function StartFacebookSharing(){try{var b=TribZi.setShareLink(TribZi.deal.fbcContext.link).parseMessage(TribZi.deal.fbcContext.message),a={method:"feed",name:TribZi.deal.fbcContext.customMessage,picture:decodeURIComponent(TribZi.deal.order.items[0].url),caption:" ",description:b,link:TribZi.deal.fbcContext.link};FB.ui(a,function(a){null===a||"undefined"==typeof a||(TribZi.clearTargets().setUid(TribZi.deal.fbcContext.uid).addTarget(TribZi.deal.order.customer.email,a.post_id,"friend","facebook").setCustomMessage($("#message").val()).setRewardIndex($("#slider").slider("value")),
TribZi.share(),showSuccess("Thanks For Sharing! Your reward for next purchase is on the way - Keep on sharing"),$("#emailShare").click())})}catch(c){alert(c)}}function fbcResponse(b){b&&b.post_id?alert("Post was published."+b.post_id):alert("Post was not published.")}
$.initFacebook=function(b){$("#fb-root").remove();$("body").append('<div id="fb-root"></div>');var a={appId:null,callback:null,channelUrl:null,status:!0,cookie:!0,xfbml:!0};b&&$.extend(a,b);"undefined"==typeof xc_app_id&&(window.xc_app_id=a.appId);window.fbAsyncInit=function(){null==a.channelUrl?FB.init({appId:a.appId,status:a.status,cookie:a.cookie,xfbml:a.xfbml,oauth:!0,authResponse:!0}):(a.channelUrl=location.protocol+"//"+a.channelUrl,FB.init({appId:a.appId,status:a.status,cookie:a.cookie,xfbml:a.xfbml,
oauth:!0,authResponse:!0,channelUrl:a.channelUrl}));"function"==typeof a.callback&&a.callback.call(this)}};
function createShareObj(){var b=$("#slider").slider("value");return{customMessage:TribZi.deal.fbcContext.customMessage,deal:{id:TribZi.deal.id,order:TribZi.deal.order,campaign:{id:TribZi.deal.campaign.id}},reward:TribZi.deal.landing.landingRewards[b],context:{type:"email",uid:TribZi.deal.fbcContext.uid},targets:[{name:"leader",from:TribZi.deal.order.branch.email,to:TribZi.deal.order.customer.email}]}};

