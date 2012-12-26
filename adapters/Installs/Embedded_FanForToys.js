TribZiEmbd = {
    getOrderJson:function () {
        return {
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

    },

    attachIFrame:function () {
        var jsonOrderData = this.getOrderJson();

        //http://127.0.0.1:8080
        var tribziIfamerUrl =
//            'http://tribzi.azurewebsites.net/CatBee/api/deal/?action=deal&context=' +
             'http://127.0.0.1:8080/CatBee/api/deal/?action=deal&context=' +
                encodeURIComponent(JSON.stringify(jsonOrderData));

        var divElement = document.createElement('div');
        divElement.id = 'myDiv';
        divElement.style.postion = '';
        var iframeElement = document.createElement('iframe');
        iframeElement.src = tribziIfamerUrl;
        iframeElement.height = 800;
        iframeElement.width = 500;
        iframeElement.frameBorder = 0;
        divElement.appendChild(iframeElement)
        document.body.appendChild(divElement);
    }


}
window.TribZiEmbd = TribZiEmbd;

window.onload=function(){
    TribZiEmbd.attachIFrame();
    document.getElementById('iframe').height = document.body.offsetHeight;
}

