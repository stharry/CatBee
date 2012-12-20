TribZiEmbd = {
    getOrderJson:function () {
        return {
            action:'deal',
            context:{
                amount:'76.00',
                id:'123',
                items:[
                    {
                        itemcode:'1234567890',
                        url:'http://tribzi.azurewebsites.net/CatBee/adapters/demo/res/Train.jpg',
                        price:'76.00',
                        description:'toy'
                    }
                ],
                customer:{
                    email:'danny.t.leader@gmail.com',
                    firstName:'Danny',
                    lastName:'Leader',
                    nickName:'leader'
                },
                branch:{
                    shopId:'1',
                    store:{
                        'authCode':'19FB6C0C-3943-44D0-A40F-3DC401CB3703'
                    }
                }

            }
        }

    },

    attachIFrame:function () {
        var jsonOrderData = this.getOrderJson();

        var tribziIfamerUrl = 'http://tribzi.azurewebsites.net/CatBee/api/deal/?' + encodeURIComponent(JSON.stringify(jsonOrderData));

        var divElement = document.createElement('div');
        divElement.id = 'myDiv';
        divElement.style.postion = '';
        var iframeElement = document.createElement('iframe');
        iframeElement.src = tribziIfamerUrl;
        divElement.appendChild(iframeElement)
        document.body.appendChild(divElement);
    }


}
window.TribZiEmbd = TribZiEmbd;

TribZiEmbd.attachIFrame();

