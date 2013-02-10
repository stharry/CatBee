function getOrderJson() {

    var args = cbf.getScriptParams('Embedded_Magento');

    return {
        amount  :args['ot'],
        id      :args['id'],

            items:[
                {
                    itemcode:'1234567890',
                    url:'http://api.tribzi.com/CatBee/adapters/demo/res/Train.jpg',
                    price:'76.00',
                    description:'toy'
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

}

jQuery(document).ready(function () {

    var jsonOrderData = getOrderJson();
    cbf.setupFrame(
        {
            initWidth   :424,
            initHeight  :369,
            catbeeAction:'deal',
            urlParams   :jsonOrderData,
            id          :'catbeeFrame',
            closeButton :true
        });

});
