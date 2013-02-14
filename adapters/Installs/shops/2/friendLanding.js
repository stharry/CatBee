$(document).ready(function () {

    $('.box').mutate('height width',function (element,info){
        TribZi.resizeFrame(2, 2, '.box-wrapper');
    });

    var imageSrc = "http://media-cache-lt0.pinterest.com/550/b9/eb/78/b9eb786ad849a05497051c97d0defeab.jpg";

    setTimeout(function(){
        $("#product-img").attr("src", imageSrc);
    }, 200);


    $('#go-btn').click(function(){

        TribZi.saveCoupon().closeFrame();
    });


    TribZi.resizeFrame(2, 2, '.box-wrapper');

});
