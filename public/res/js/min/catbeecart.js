cbf.addLoadEvt(function(){var a=cbf.parseUrl(location.href);if(a=cbf.valOrDefault(a.tribzisid,null))cbf.setupFrame({initWidth:600,initHeight:480,catbeeAction:"frienddeal",urlParams:{share:{context:{uid:a}}}});else if(a=cbf.getCookie("CatBeeCpnCod")){var b="coupon_code",b=cbfSettings&&cbfSettings.widgets.cpn&&cbfSettings.widgets.cpn.gui.appendTo?cbfSettings.widgets.cpn.gui.appendTo:cbf.getScriptParams("catbeecart").cfid;if(b=cbf.getDiv(b))b.value=a}});