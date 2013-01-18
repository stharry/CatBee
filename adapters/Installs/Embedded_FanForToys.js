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

    buildUri: function (){
        var jsonOrderData = this.getOrderJson();

        //http://127.0.0.1:8080
        return 'http://127.0.0.1:8080/CatBee/api/deal/?action=deal&context=' +
            encodeURIComponent(JSON.stringify(jsonOrderData));

    },

    attachIFrame:function (iFrameTag) {
        //http://127.0.0.1:8080
        var tribziIfamerUrl = this.buildUri();

        var iframe = document.getElementById(iFrameTag);
        if (!iframe) {
            var divElement = document.createElement('div');
            divElement.id = 'myDiv';
            divElement.style.postion = '';
//            divElement.width = 700;
//            divElement.height = 500;

            var iframe = document.createElement('iframe');

            iframe.height = '100%';
            iframe.width = '100%';
            iframe.frameBorder = 0;
            iframe.setAttribute('id', iFrameTag);
            divElement.appendChild(iframe);
            document.body.appendChild(divElement);

            $("#myDiv").dialog({
                modal: true,
                autoOpen: false,
                height: '500',
                //height: '180',
                //width: 'auto',
                width: '700',
                draggable: true,
                resizeable: true,
                //resizeable: false,
                title: 'IFrame Modal Dialog'
            });

            $("#myDiv").dialog("open");

            iframe.src = tribziIfamerUrl;

            setTimeout(checkIFrame, 200);
        }
        else {

            iframe.src = uri;
        }
    },



    resizeCatBee:function(){
        $('.ui-dialog').css({with : 700});
    }

};

window.TribZiEmbd = TribZiEmbd;

(function () {
    function loadTribZi() {
        TribZiEmbd.attachIFrame('catbeeFrame');
        //todo document.getElementById('iframe').height = document.body.offsetHeight;
    }

    var oldonload = window.onload;
    window.onload = (typeof window.onload != "function") ?
        loadTribZi : function () {
        oldonload();
        loadTribZi();
    };
})();


function checkIFrame()
{
    var command = document.getElementById('catbeeFrame').contentWindow.name
    if (command.indexOf('#') > 0)
    {
        command = command.substr(command.indexOf('#') + 1);

        pairs = command.split(';');
        params = [];

        for (var i = 0; i < pairs.length; i++)
        {
            pair = pairs[i].split('=');
            params[pair[0]] = pair[1];
        }

        if (params['w'])
        {
            alert('1');
        }
        document.getElementById('catbeeFrame').contentWindow.name = 'catbeeFrame';
    }
    setTimeout(checkIFrame, 200);
}