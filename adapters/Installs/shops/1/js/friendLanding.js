$(document).ready(function () {

    var imageSrc = TribZi.getRoot() + '/adapters/installs/shops/1/res/train.jpg';

    $("#productImage").attr("src", imageSrc);

    TribZi.resizeFrame(3, 3);

    $('.go-btn').click(function(){

        TribZi.saveCoupon();
    });


});
