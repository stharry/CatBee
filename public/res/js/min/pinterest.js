$(document).ready(function(){$(".jcarousel").jcarousel({list:".jcarousel-list",vertical:!0,animation:{easing:"linear"}}).jcarouselAutoscroll({autostart:!1,interval:0});$(".jcarousel-prev").hover(function(){$(".jcarousel").jcarouselAutoscroll("reload",{target:"-=1"});$(".jcarousel").jcarouselAutoscroll("start")},function(){$(".jcarousel").jcarouselAutoscroll("stop")});$(".jcarousel-next").hover(function(){$(".jcarousel").jcarouselAutoscroll("reload",{target:"+=1"});$(".jcarousel").jcarouselAutoscroll("start")},
function(){$(".jcarousel").jcarouselAutoscroll("stop")});$.each(TribZi.deal.order.items,function(a,b){$(".jcarousel-list").append('<li><img src="'+decodeURIComponent(b.url)+'" width="75" height="75" alt="" /></li>')});$("ul.jcarousel-list li").click(function(){$(this).addClass("selected-image").removeClass("unselected-image").siblings().addClass("unselected-image").removeClass("selected-image")});var a=$(".jcarousel").jcarousel("fullyvisible");a&&1<=a.length&&a[Math.floor(a.length/2)].click();$("#pinterestSubmit").click(function(){$("a#pinterestSubmit").attr("href",
function(a,b){var c=b.indexOf("&"),d=encodeURIComponent(""),e=encodeURIComponent($(".selected-image").children().attr("src")),f=encodeURIComponent($("#pinterest-message").val());console.log("returning "+b.substr(0,c)+d+"&media="+e+"&description"+f);return b.substr(0,c)+d+"&media="+e+"&description="+f})});CreateAndInitializePinterestForm()});
function CreateAndInitializePinterestForm(){$("#pinterestShare").click(function(){"none"===$(".pinterest-form").css("display")?showPinterestBox():hidePinterestBox()})}function hidePinterestBox(){$("#pinterestForm").hide();$("#pinterest_shadow_div").addClass("inv");$("#pinterestShare").parent().removeClass("active")}
function showPinterestBox(){"none"!==$("#emailForm").css("display")&&$("#emailForm").css("display","none");"none"!==$("#tbox").css("display")&&hideTwitterBox();"none"!==$("#facebookForm").css("display")&&$("#facebookForm").css("display","none");$("#pinterestForm").show();$("#share_list").find("li").removeClass("active");$("#pinterestShare").parent().addClass("active");$("#pinterest_shadow_div").removeClass("inv")}function createPinterestBox(){};