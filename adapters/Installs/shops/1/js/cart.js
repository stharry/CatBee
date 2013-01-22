jQuery(document).ready(function () {

    var couponCode = cbf.getCookie('CatBeeCpnCod');

    if (couponCode) {
        var couponBox = document.getElementById('coupon_code');
        if (couponBox) {
            couponBox.value = couponCode;
        }
    }
});

