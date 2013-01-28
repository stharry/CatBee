$(document).ready(function () {

    $('.box').mutate('height width',function (element,info){
        TribZi.resizeFrame(30, 30, '.box-wrapper');
    });

    var imageSrc = TribZi.getRoot() + '/adapters/installs/shops/1/res/train.jpg';

    $("#productImage").attr("src", imageSrc);

    $('#go-btn').click(function(){

        TribZi.saveCoupon().closeFrame();
    });


});
