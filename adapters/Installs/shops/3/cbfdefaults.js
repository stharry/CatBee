cbfSettings.redirectTo = 'https://www.apid2.tribzi.com/CatBee/';

cbfSettings.widgets.ppw = {
    gui:{
        appendTo   :'cbfRoot',
        setBefore  :null,
        closeButton:true
    },
    sites:{
        run:false
    }};

cbfSettings.widgets.cpn = {
    gui:{
        appendTo:'coupon_code'
    },
    sites:{
        run:true
    }
};

cbf.addLoadEvt(function () {
    checkPages();
});

function checkPages() {
    var uriParams = cbf.parseUrl(location.href);

    if (cbf.valOrDefault(uriParams.p, '') == 'cart') {
        var items = cbf.byClassList('CatalogItemLight');

        var urls = [], codes = [];
        for (var i = 0; i < items.length; i++) {
            var imgs = items[i].getElementsByTagName('img');
            if ((imgs.length > 0) &&
                (typeof imgs[0].src !== 'undefined') &&
                (imgs[0].src.indexOf('images/products') > 0)) {
                urls.push(imgs[0].src);
            }
            else {
                var ind = items[i].innerText.indexOf('Product ID: ');
                if (ind > 0) {
                    codes.push(items[i].innerText.substr(ind + 12, 9));
                }
            }
        }

        cbf.setCookie('cbf_icnt', urls.length);

        for (i = 0; i < urls.length; i++) {
            cbf.setCookie('cbf_iurl' + i, urls[i]);
            if (i < codes.length) {
                cbf.setCookie('cbf_iupc' + i, codes[i]);
            }
            else {
                cbf.setCookie('cbf_iupc' + i, 'ZZZ');
            }
        }

    }
    else if (cbf.valOrDefault(uriParams.p, '') == 'invoice') {
        setOrderProp('invoice');
        setOrderProp('amount');
        setOrderProp('address_name');
        setOrderProp('email');
    }
    else if (cbf.valOrDefault(uriParams.p, '') == 'completed') {
        showPPWidget();
    }


}

function setOrderProp(prop) {
    var invElems = document.getElementsByName(prop);
    if (invElems.length > 0) {
        cbf.setCookie('cbf_' + prop, invElems[0].value);
    }
}

function showPPWidget() {
    var orderParams = {
        amount  :cbf.getCookie('cbf_amount'),
        id      :cbf.getCookie('cbf_invoice'),
        customer:{
            email    :cbf.getCookie('cbf_email'),
            firstName:cbf.getCookie('cbf_address_name')
        },
        branch  :{
            shopId:3
        },
        items   :[]
    };

    for (var i = 0; i < cbf.getCookie('cbf_icnt'); i++) {
        orderParams.items.push({
            itemCode:cbf.getCookie('cbf_iupc' + i),
            url     :cbf.getCookie('cbf_iurl' + i)
        })
    }
    cbWidgets.postPurchaseWidget(orderParams);

}