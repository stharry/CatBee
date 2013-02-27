$(document).ready(function () {



    $('.jcarousel')
        .jcarousel({
            'list': '.jcarousel-list',
            'vertical': true,
            animation: {'easing': 'linear'}
        })
        .jcarouselAutoscroll({
            'autostart': false,
            'interval' : 0
        });

    $('.jcarousel-prev').hover(function() {
        $('.jcarousel').jcarouselAutoscroll('reload', {
            'target' : '-=1'
        });
        $('.jcarousel').jcarouselAutoscroll('start');
    }, function() {
        $('.jcarousel').jcarouselAutoscroll('stop');
    });


    $('.jcarousel-next').hover(function() {
        $('.jcarousel').jcarouselAutoscroll('reload', {
            'target' : '+=1'
        });
        $('.jcarousel').jcarouselAutoscroll('start');
    }, function() {
        $('.jcarousel').jcarouselAutoscroll('stop');
    });

    //Populate carousel with deal images
    $.each(TribZi.deal.order.items, function(i, item) {
        $(".jcarousel-list").append('<li><img src="'+ decodeURIComponent(item.url) + '" width="75" height="75" alt="" /></li>');
    });
    $("ul.jcarousel-list li").click(function() {
        $(this).addClass('selected-image').removeClass('unselected-image').siblings().addClass('unselected-image').removeClass('selected-image')
    });

    //If don't need to scroll then remove scrollers
    if (TribZi.deal.order.items.length <= 3) {
        $('.jcarousel-prev').hide();
        $('.jcarousel-next').hide();
    }

    //highlight first item
    if ($("ul.jcarousel-list li").length >= 1) {
        $("ul.jcarousel-list li")[0].click();
    }

    $('#pinterestSubmit').click(function(event) {

        event.preventDefault();

        var message = $('#pinterest-message').text();

        $('a#pinterestSubmit').attr('href', function(index, val) {

            //Format of URL parameters: url=&media=&description=

            //location of URL parameter
            var loc = val.indexOf('url=');

            var newUrl = encodeURIComponent(TribZi.deal.pintContext.link);
            var newImg = encodeURIComponent($('.selected-image').children().attr('src'));
            var newDescrip = encodeURIComponent($('#pinterest-message').val());
            console.log("returning " + val.substr(0,loc) + newUrl + '&media=' + newImg + '&description=' + message )
            return (val.substr(0,loc + 4) + newUrl + '&media=' + newImg + '&description=' + message);
        });

        window.open($('a#pinterestSubmit').attr('href'), "Pinterest", "width=690,height=255");

        TribZi.clearTargets()
            .addTarget(TribZi.deal.order.customer.email, TribZi.deal.order.customer.email, 'friend', 'pinterest')
            .setCustomMessage(message)
            .setRewardIndex($("#slider").slider("value"))
            .setUid(TribZi.deal.pintContext.uid);

        TribZi.share(null);

    });


    CreateAndInitializePinterestForm();
    hidePinterestBox();
});


function CreateAndInitializePinterestForm() {
    $("#pinterestShare").click(function () {
        if ($('.pinterest-form').css('display') === 'none') {
            showPinterestBox();
        }
        else {
            hidePinterestBox();
        }
    });

};

function hidePinterestBox()
{
    $('#pinterestForm').hide();
    $('#pinterest_shadow_div').addClass('inv');
    $('#pinterestShare').parent().removeClass('active');
}

function showPinterestBox() {
    if ($('#emailForm').css('display') !== 'none') {
        $('#emailForm').css('display', 'none');
    }

    if ($('#tbox').css('display') !== 'none') {
        hideTwitterBox();
    }

    if ($('#facebookForm').css('display') !== 'none') {
        $('#facebookForm').css('display', 'none');
    }

    $('#pinterestForm').show();

    $('#share_list').find('li').removeClass('active');
    $('#pinterestShare').parent().addClass('active');

    $('#pinterest_shadow_div').removeClass('inv');
}

function createPinterestBox() {


}

function setPinterestMessage()
{
    var message = TribZi.setShareLink(TribZi.deal.pintContext.link)
        .parseMessage(TribZi.deal.pintContext.message);

    $('#pinterest-message').text(message);
}

