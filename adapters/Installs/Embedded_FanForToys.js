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

    buildUri:function () {
        var jsonOrderData = this.getOrderJson();

        //http://127.0.0.1:8080
        return '/CatBee/api/deal/?action=deal&context=' +
            encodeURIComponent(JSON.stringify(jsonOrderData));

    }

};

window.TribZiEmbd = TribZiEmbd;

$(document).ready(function() {
    var insert = "<div id='modalDiv' style='padding: 0; width: 430; height: 340; top: 300'><iframe id='catbeeFrame' width='100%' height='100%' marginWidth='0' marginHeight='0' frameBorder='0' scrolling='auto' title='Dialog Title'></iframe></div>";

    $('body').append(insert);

    $("#modalDiv").dialog({
        modal: true,
        autoOpen: false,
        position:'center',
        height: '340',
        width: '430',
        draggable: false,
        resizable: false,
        dialogClass: 'tribziDialog'
    });

    $("#closebtn").button({ icons: { primary: "ui-icon-close" } });
    $('.tribziDialog div.ui-dialog-titlebar').hide();
    $('#modalDiv').css('overflow', 'hidden');

    url = TribZiEmbd.buildUri();//'myPage.html';
    $("#modalDiv").dialog("open");
    $("#catbeeFrame").attr('src',url);

    var cssObj = {
        'position': 'absolute',
        'top': '-18px',
        'right': '-18px',
        'width': '36px',
        'height': '36px',
        'cursor': 'pointer',
        'z-index': '8040',
        'background': 'url(\'http://127.0.0.1:8080/CatBee/public/res/images/fancybox_sprite.png\')'};

    $('.tribziDialog').append("<div title='Close' class='dialog-close-button'></div>");
    $('.dialog-close-button').css(cssObj)
        .click(function(){
            $("#modalDiv").dialog('close');});

    setTimeout(checkIFrame, 200);

});

function checkIFrame()
{
    var frameElement = document.getElementById('catbeeFrame');

    if (frameElement && (frameElement.contentWindow)) {
        var command = frameElement.contentWindow.name;
        if ((command) && (command.toString().indexOf('#') >= 0)) {
            command = command.substr(command.indexOf('#') + 1);

            pairs = command.split(';');
            params = [];

            for (var i = 0; i < pairs.length; i++) {
                pair = pairs[i].split('=');
                params[pair[0]] = pair[1];
            }

            if ((params['act']) && (params['act'] == 'resize')) {
                var sizes = {
                    height:params['h'],
                    width:params['w']
                };
                $('.ui-dialog').css(sizes);
                $('#modalDiv').css(sizes);
            }
            document.getElementById('catbeeFrame').contentWindow.name = 'catbeeFrame';
        }
    }
    setTimeout(checkIFrame, 200);
}
