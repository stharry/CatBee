function getOrderJson() {

    var args = cbf.getScriptParams('catbeepostpurchase');

    orderParams = {
        amount  :args['ot'],
        id      :args['id'],
        customer:{
            email    :args['ce'],
            firstName:args['cn']
        },
        branch  :{
            shopId:args['shop'], //'2',
            store :{
                'authCode':args['adpt']//'54c5e6c3-6349-11e2-a702-0008cae720a7'
            }
        }
    }

    orderParams.items = [];

    var itemsCount = cbf.valOrDefault(args['icnt'], 0);

    var defaultUrl = cbf.valOrDefault(args['defUrl'], "http://www.glassesmarket.com/skin/frontend/glassesmarket2/default/images/logo.png");
    var defaultUpc = cbf.valOrDefault(args['defUpc'], "1234567890");
    if (itemsCount == 0) {
        orderParams.items.push({
            itemcode:defaultUpc,
            url     :defaultUrl
        })
    }
    else {
        for (var i = 0; i < itemsCount; i++) {
            orderParams.items.push({
                itemcode:cbf.valOrDefault(args['i' + (i + 1) + 'upc'], defaultUpc),
                url     :cbf.valOrDefault(args['i' + (i + 1) + 'url'], defaultUrl)
            })


        }
    }


    var referralUid = cbf.getCookie('CatBeeRefId');

    if (referralUid) {
        orderParams.successfulReferral = referralUid;
    }
    return orderParams;

}

cbf.addLoadEvt(function () {

    var jsonOrderData = getOrderJson();
    cbf.setupFrame(
        {
            initWidth   :424,
            initHeight  :369,
            catbeeAction:'deal',
            urlParams   :jsonOrderData,
            closeButton :true
        });

});
