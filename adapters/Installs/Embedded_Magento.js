TribZiEmbd = {

    getScriptParams: function(){

        var all_script_tags = document.getElementsByTagName('script');
        var script_tag = all_script_tags[all_script_tags.length - 1];

        var query = script_tag.src.replace(/^[^\?]+\??/,'');

        var vars = query.split("&");
        var args = {};
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            args[pair[0]] = decodeURI(pair[1]).replace(/\+/g, ' ');  // decodeURI doesn't expand "+" to a space
        }
        return args;
    },

    getOrderJson:function () {

        var args = this.getScriptParams();
        return {
            amount:args['ot'],
            id:args['id'],
            //todo
//            items:[
//                {
//                    itemcode:'1234567890',
//                    url:'http://tribzi.azurewebsites.net/CatBee/adapters/demo/res/Train.jpg',
//                    price:'76.00',
//                    description:'toy'
//                }
//            ],
            customer:{
                email:args['ce'],
                firstName:args['cn']
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

$(document).ready(function() {
    var insert = "<div id='modalDiv' style='padding: 0; width: 430; height: 340; top: 300'><iframe id='catbeeFrame' width='100%' height='100%' marginWidth='0' marginHeight='0' frameBorder='0' scrolling='auto' title='Dialog Title'></iframe></div>";

    $('body').append(insert);

    $("#modalDiv").dialog({
        modal: true,
        autoOpen: false,
        position:'center',
        height: '340',
        //height: 'auto',
        //width: 'auto',
        width: '430',
        draggable: false,
        resizable: false,
        dialogClass: 'tribziDialog',
        //resizeable: false,
        title: 'IFrame Modal Dialog'
    });

    $('.tribziDialog div.ui-dialog-titlebar').hide();
    $('#modalDiv').css('overflow', 'hidden');

    url = TribZiEmbd.buildUri();//'myPage.html';
    $("#modalDiv").dialog("open");
    $("#catbeeFrame").attr('src',url);

    setTimeout(checkIFrame, 200);

});

function checkIFrame()
{
    var command = document.getElementById('catbeeFrame').contentWindow.name;
    if (command.indexOf('#') >= 0)
    {
        command = command.substr(command.indexOf('#') + 1);

        pairs = command.split(';');
        params = [];

        for (var i = 0; i < pairs.length; i++)
        {
            pair = pairs[i].split('=');
            params[pair[0]] = pair[1];
        }

        if ((params['act']) && (params['act'] == 'resize'))
        {
            var sizes = {
                height : params['h'],
                width : params['w']
            };
            $('.ui-dialog').css(sizes);
            $('#modalDiv').css(sizes);
        }
        document.getElementById('catbeeFrame').contentWindow.name = 'catbeeFrame';
    }
    setTimeout(checkIFrame, 200);
}