$(function() {

    'use strict';



$("#invite-button").buttonset();




        $.getJSON('http://www.apid.tribzi.com/CatBee/api/tribe', {
            "action":"get",
            "context":
            {
                "Customer":{
                    "email":"tomer.harry@gmail.com"
                }
            }
        }, function(tribeResponse, tribeStatus, tribeJqxhr) {
    console.log(tribeResponse);

            var gallery = $('#gallery'), url;
            $.each( tribeResponse.customers, function(index, tribeMember) {

                console.log("processing " + tribeMember.email);



                // http://www.flickr.com/services/api/misc.urls.html
                url = tribeMember.sharedPhoto;
                //url = 'tribeFriends/Mark-Zuckerberg.jpg'
                var img = $('<img>').prop({'src': url, 'title': tribeMember.firstName + ' ' + tribeMember.lastName, 'width' : 50, 'height' : 50});

                var link = document.createElement('a'),
                    li = document.createElement('li')

                link.href = url; //+ '_b.jpg';
                link.appendChild(img[0]);
                li.appendChild(link);
                gallery[0].appendChild(li);

                // lazy show the photos one by one
                img.on('load', function(e){
                    setTimeout( function(){
                        li.className = 'loaded';
                    }, 20*index);
                });


            });

        });

    $.ajax({
           /*     url: ,
         data: {
         format: 'json',


    },
         dataType: 'jsonp',
         jsonp: 'jsoncallback'*/
    }).done(function (data){
//		console.log(data);
       /*     var gallery = $('#gallery'), url;
             $.each( data.customers, function(index, tribeMember) {

            console.log("processing " + tribeMember.email);



             // http://www.flickr.com/services/api/misc.urls.html
             url = tribeMember.sharedPhoto;
             var img = $('<img>').prop({'src': url + '_t.jpg', 'title': tribeMember.firstName + ' ' + tribeMember.lastName});

             var link = document.createElement('a'),
             li = document.createElement('li')

             link.href = url; //+ '_b.jpg';
             link.appendChild(img[0]);
             li.appendChild(link);
             gallery[0].appendChild(li);

             // lazy show the photos one by one
             img.on('load', function(e){
             setTimeout( function(){
             li.className = 'loaded';
             }, 20*index);
             });


             });*/


            // finally, initialize photobox on all retrieved images
           /* $('#gallery').photobox('a', { thumbs:true }, callback);
            function callback(){
                console.log('loaded!');
            }*/
        });



});