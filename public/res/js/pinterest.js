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

    $.each(TribZi.deal.order.items, function(i, item) {
        $(".jcarousel-list").append('<li><img src="'+ decodeURIComponent(item.url) + '" width="75" height="75" alt="" /></li>');
     });
    $("ul.jcarousel-list li").click(function() {
        $(this).addClass('selected-image').removeClass('unselected-image').siblings().addClass('unselected-image').removeClass('selected-image')
    });

    var visibleImages = $('.jcarousel').jcarousel('fullyvisible');
    if(visibleImages && visibleImages.length >= 1) {
        visibleImages[Math.floor(visibleImages.length / 2)].click();
    }

    $('#pinterestSubmit').click(function() {


        $('a#pinterestSubmit').attr('href', function(index, val) {

            //Format of URL parameters: url=&media=&description=

            //location of URL parameter
            var loc = val.indexOf('&');

            var newUrl = encodeURIComponent('')
            var newImg = encodeURIComponent($('.selected-image').children().attr('src'))
            var newDescrip = encodeURIComponent($('#pinterest-message').val())
            console.log("returning " + val.substr(0,loc) + newUrl + '&media=' + newImg + '&description' + newDescrip )
            return (val.substr(0,loc) + newUrl + '&media=' + newImg + '&description=' + newDescrip);
        });


    });


    CreateAndInitializePinterestForm();
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


