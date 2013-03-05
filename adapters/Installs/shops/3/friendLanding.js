$(document).ready(function () {

    $('.box').mutate('height width',function (element,info){
        TribZi.resizeFrame(2, 2, '.box-wrapper');
    });

    var imageSrc = "http://sphotos-b.ak.fbcdn.net/hphotos-ak-snc6/180251_10150132162005056_6394899_n.jpg";

    setTimeout(function(){
        $("#product-img").attr("src", imageSrc);
    }, 200);


    $('#go-btn').click(function(){

        TribZi.saveCoupon().closeFrame();
    });


    TribZi.resizeFrame(2, 2, '.box-wrapper');

});
