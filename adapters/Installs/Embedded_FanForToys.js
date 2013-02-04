function getOrderJson() {

    return {
        amount:'76.00',
        id:'123',
        items:[
            {
                itemcode:'1234567890',
                url:'http://api.tribzi.com/CatBee/adapters/demo/res/Train.jpg',
                price:'76.00',
                description:'toy'
            }
        ],
        customer:{
            email:'danny.t.leader@gmail.com',
            firstName:'Danny',
            lastName:'Leader'
        },
        branch:{
            shopId:'2',//'1',
            store:{
                'authCode':'54c5e6c3-6349-11e2-a702-0008cae720a7'//'19FB6C0C-3943-44D0-A40F-3DC401CB3703'
            }
        }

    }

}

cbf.addLoadEvt(function () {

    var jsonOrderData = getOrderJson();
    cbf.setupFrame(
        {
            initWidth   :424,
            initHeight  :372,
            catbeeAction:'deal',
            urlParams   :jsonOrderData,
            id          :'catbeeFrame',
            closeButton :true
        });

});

