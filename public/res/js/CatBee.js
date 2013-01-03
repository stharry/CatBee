var catBeeResult = null;

function waitCatBeeResultAndRun(timeoutMs, callback) {
    try {
        if (timeoutMs <= 0) {
            //need to set any kind of alert
        }
        else if (catBeeResult == null) {
            setTimeout(function () {
                waitCatBeeResultAndRun(timeoutMs - 500, callback)
            }, 500)
        }
        else {
            callback();
        }
    }
    catch (e) {
        alert(e);
    }
}

function proceedCatBeeShareJsonRequest(data, resultName) {

    var sharePoint = getCatBeeShareApiUrl();

    catBeeResult = null;

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {

        if (xmlhttp.readyState == 4 && xmlhttp.status == 200 && catBeeResult == null) {
            catBeeResult = xmlhttp.responseText;
            localStorage.setItem(resultName, catBeeResult);
        }
    }

    try {
        var kuku = jQuery.param(data);

        xmlhttp.open("POST", sharePoint, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.setRequestHeader("Content-Length", kuku.length);
        xmlhttp.send(kuku);
    }
    catch (e) {
        alert(e);
    }
//    alert(sharePoint);
//
//    $.ajax({
//        type:'POST',
//        url:sharePoint,
//        dataType:'json',
//        data:data,
//
//        timeout:7200,
//
//        error:function (xhr, textStatus, error) {
//
//            try
//            {
//            catBeeResult = JSON.parse(xhr.responseText);
//            callback(xhr.responseText);
//            }
//            catch (e)
//            {
//                alert(JSON.stringify(xhr));
//                alert(textStatus);
//                alert(error.toString());
//                catBeeResult = "";
//                callback("");
//            }
//        },
//
//        success:function (data) {
//
//            try
//            {
//            catBeeResult = data;
//            callback(data);
//            }
//            catch (e)
//            {
//            }
//        }
//
//    });

//    alert("before response");
//
//    var result = getCatBeeResponse();
//
//    alert("after response" + result);
//
//    return $.parseJSON(result);
}

function getCatBeeShareApiUrl() {
    return TribZi.deal.sharePoint;
}
