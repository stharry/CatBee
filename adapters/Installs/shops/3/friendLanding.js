$(document).ready(function () {

    $('.box').mutate('height width',function (element,info){
        TribZi.resizeFrame(2, 2, '.box-wrapper');
    });

    var imageSrc = "https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc6/c27.138.173.173/s160x160/183798_10150146597285056_6304744_n.jpg";

    setTimeout(function(){
        $("#product-img").attr("src", imageSrc);
    }, 200);


    $('#go-btn').click(function(){

        TribZi.saveCoupon().closeFrame();
    });


    TribZi.resizeFrame(2, 2, '.box-wrapper');

});
