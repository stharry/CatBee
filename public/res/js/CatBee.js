function proceedCatBeeShareJsonRequest(data, callback)
{
    var sharePoint = getCatBeeShareApiUrl();

    $.ajax({
        type:'POST',
        url:sharePoint,
        dataType: 'json',
        data: data,

        timeout: 7200,

        error: function(xhr, textStatus, error){

            callback(xhr.responseText);
        },

        success:function (data) {

            callback(data);
        }

    });

//    alert("before response");
//
//    var result = getCatBeeResponse();
//
//    alert("after response" + result);
//
//    return $.parseJSON(result);
}

function getCatBeeShareApiUrl()
{
    return $("#catBeeSharePoint").text()
}

function setCatBeeResponse(response)
{
    $('#shareResponse').innerText("kuku");
    try
    {
    alert($('#shareResponse').innerText);
        alert($('#shareResponse'));
    }
    catch (err)
    {
        alert(err.message);
    }
}

function getCatBeeResponse()
{
   return $('#shareResponse').innerHTML;
}