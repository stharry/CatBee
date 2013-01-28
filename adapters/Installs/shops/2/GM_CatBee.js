function getOrderJson() {

    var args = cbf.getScriptParams('GM_CatBee');

    orderParams = {
        amount  :args['ot'],
        id      :args['id'],
        //todo
        "items" :[
            {
                "itemcode":"1234567890",
                "url"     :"http://www.glassesmarket.com/skin/frontend/glassesmarket2/default/images/logo.png"
            }
        ],
        customer:{
            email    :args['ce'],
            firstName:args['cn']
        },
        branch  :{
            shopId:'2',
            store :{
                'authCode':'54c5e6c3-6349-11e2-a702-0008cae720a7'
            }
        }
    }

    var referralUid = cbf.getCookie('CatBeeRefId');

    if (referralUid) {
        orderParams.successfulReferral = referralUid;
    }
    return orderParams;

}

jquery_fiveconnect(document).ready(function () {

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
