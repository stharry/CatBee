$(document).ready(function () {

    $('.box').mutate('height width',function (element,info){
        TribZi.resizeFrame(0, 0, '.box-wrapper');
    });

    var imageSrc = "http://media-cache-lt0.pinterest.com/550/b9/eb/78/b9eb786ad849a05497051c97d0defeab.jpg";

    $("#product-img").attr("src", imageSrc);

    $('#go-btn').click(function(){

        TribZi.saveCoupon().closeFrame();
    });


});
