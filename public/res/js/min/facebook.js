$(document).ready(function(){$(".facebook-form").hide();$("#ContactsArea").hide();FB.init({appId:TribZi.deal.fbcContext.application.applicationCode,status:!0,cookie:!0});$("#facebookShare").click(function(){$("#share_list").find("li").removeClass("active");$(this).parent().addClass("active");"none"!=$("#emailForm").css("display")&&$("#emailForm").css("display","none");hidePinterestBox();hideTwitterBox();StartFacebookSharing()})});
function StartFacebookSharing(){try{var b=TribZi.setShareLink(TribZi.deal.fbcContext.link).parseMessage(TribZi.deal.fbcContext.message),a={method:"feed",name:TribZi.deal.fbcContext.customMessage,picture:decodeURIComponent(TribZi.deal.order.items[0].url),caption:" ",description:b,link:TribZi.deal.fbcContext.link};FB.ui(a,function(a){null===a||"undefined"==typeof a||(TribZi.clearTargets().setUid(TribZi.deal.fbcContext.uid).addTarget(TribZi.deal.order.customer.email,a.post_id,"friend","facebook").setCustomMessage($("#message").val()).setRewardIndex($("#slider").slider("value")),
TribZi.share(),showSuccess("Thanks For Sharing! Your reward for next purchase is on the way - Keep on sharing"),$("#emailShare").click())})}catch(c){alert(c)}}function fbcResponse(b){b&&b.post_id?alert("Post was published."+b.post_id):alert("Post was not published.")}
$.initFacebook=function(b){$("#fb-root").remove();$("body").append('<div id="fb-root"></div>');var a={appId:null,callback:null,channelUrl:null,status:!0,cookie:!0,xfbml:!0};b&&$.extend(a,b);"undefined"==typeof xc_app_id&&(window.xc_app_id=a.appId);window.fbAsyncInit=function(){null==a.channelUrl?FB.init({appId:a.appId,status:a.status,cookie:a.cookie,xfbml:a.xfbml,oauth:!0,authResponse:!0}):(a.channelUrl=location.protocol+"//"+a.channelUrl,FB.init({appId:a.appId,status:a.status,cookie:a.cookie,xfbml:a.xfbml,
oauth:!0,authResponse:!0,channelUrl:a.channelUrl}));"function"==typeof a.callback&&a.callback.call(this)}};
function createShareObj(){var b=$("#slider").slider("value");return{customMessage:TribZi.deal.fbcContext.customMessage,deal:{id:TribZi.deal.id,order:TribZi.deal.order,campaign:{id:TribZi.deal.campaign.id}},reward:TribZi.deal.landing.landingRewards[b],context:{type:"email",uid:TribZi.deal.fbcContext.uid},targets:[{name:"leader",from:TribZi.deal.order.branch.email,to:TribZi.deal.order.customer.email}]}};