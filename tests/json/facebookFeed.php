<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vadim
 * Date: 22/10/12
 * Time: 00:27
 * To change this template use File | Settings | File Templates.
 */


$url = 'https://www.facebook.com/dialog/send?'
    .'app_id=369374193139831&'
    .'name=Myshmuku&'
    .'from=544794843&'
    .'to=531343506,638752301&'
    .'access_token=AAAFP8aGSQHcBAMppDZCgPVJITouNgZBNnLm8RLWFB0p0JHSqqkjSk2210SAGhtaql9UncT112YygVI2E6vePssMoVtkXzRssdKQGpn2AZDZD&'
    .'redirect_uri=http://127.0.0.1:8080/CatBee/components/share/facebook/facebookLogin.php&'
    .'link=http://kuku.com&';

//$url = 'http://www.facebook.com/dialog/feed?'
//    .'app_id=369374193139831&'
//    .'redirect_uri=http://127.0.0.1:8080/CatBee/components/share/facebook/facebookLogin.php&'
//    .'link=http://kuku.com&'
//    .'source=http://shmuku.com&'
//    .'name=Myshmuku&'
//    .'caption=wawWaw&'
//    .'description=pipi&'
//    .'to=531343506,638752301';

echo("<script> top.location.href='" . $url . "'</script>");