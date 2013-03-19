$(function(){

counter = 0;

$('#comct').children().click(function() {

    $('fb\\:comments').attr('href','http://www.apid.tribzi.com/PinBoard/public/testPage.html');

     FB.XFBML.parse($('fb\\:comments')[0]);

});

    var setdialog = function(product_no,product_url, unique_no, unique_no_class) {
        var div_str = "<div class='pb-add-comment-text' id=" + product_no + "><iframe frameBorder='0' scrolling='no' width='450' height='400' src='http://www.facebook.com/plugins/comments.php?href=" + product_url + "&amp;ref=PDP'></iframe></div>"
        var selector =' #tiles #li'+product_no;
        $(selector).append(div_str);
        prod_no_id = unique_no;
        prod_no_class = unique_no_class;
        prod_url = product_url;
        prod_no_com = unique_no.replace('#','');
        $(prod_no_id).dialog({
            modal:true,
            width:'auto',
            close: function() {$(prod_no_class).empty();
                $(unique_no).remove();
                get_comments(prod_url, prod_no_com);
                $('ul#tiles li').wookmark();}
        });
    }


    var itemsToBuy = [
        {
         imageURL : 'res/images/cookies.png',
         imageHeight: '200',
         imageWidth: '200',
         imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/cookies.html',
         imagePrice : '25',
         title : 'Yummy cookies',
         id : 0
        },
        {
            imageURL : 'res/images/milk.png',
            imageHeight: '200',
            imageWidth: '200',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/milk.html',
            imagePrice : '15',
            title: 'Yummy milk',
            id : 1

        },{
            imageURL : 'res/images/cookies.png',
            imageHeight: '200',
            imageWidth: '200',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/cookies.html',
            imagePrice : '25',
            title : 'Yummy cookies',
            id : 1
        },
        {
            imageURL : 'res/images/milk.png',
            imageHeight: '200',
            imageWidth: '200',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/milk.html',
            imagePrice : '15',
            title: 'Yummy milk',
            id : 0
        },{
            imageURL : 'res/images/cookies.png',
            imageHeight: '200',
            imageWidth: '200',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/cookies.html',
            imagePrice : '25',
            title : 'Yummy cookies',
            id : 1
        },
        {
            imageURL : 'res/images/milk.png',
            imageHeight: '200',
            imageWidth: '200',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/milk.html',
            imagePrice : '15',
            title: 'Yummy milk',
            id : 0
        },{
            imageURL : 'res/images/cookies.png',
            imageHeight: '200',
            imageWidth: '200',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/cookies.html',
            imagePrice : '25',
            title : 'Yummy cookies',
            id : 1
        }/*,
        {
            imageURL : 'res/images/milk.png',
            imageHeight: '300',
            imageWidth: '300',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/milk.html',
            imagePrice : '15',
            title: 'Yummy milk',
            id : 0
        },{
            imageURL : 'res/images/cookies.png',
            imageHeight: '300',
            imageWidth: '300',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/cookies.html',
            imagePrice : '25',
            title : 'Yummy cookies',
            id : 1
        },
        {
            imageURL : 'res/images/milk.png',
            imageHeight: '300',
            imageWidth: '300',
            imageTargetURL: 'http://www.apid.tribzi.com/PinBoard/milk.html',
            imagePrice : '15',
            title: 'Yummy milk',
            id : 0
        }*/
    ]

    var $container = $('#pinBoard');
    var $fbModalComments = $('#basic-modal-content');
    $fbModalComments.click(function(){

    });
    var $pinItem = $container.children('.storeItem');


    var itemTemplate = $('<div class="storeItem"><div class="imageContainer"><div class="imageParent"><a><img></a></div></div><div class="tbCt"></div><div class="comments"><div class="bottomToolbar" style="border-bottom: medium none; padding-bottom: 0px;"><span class="button noComment">Add comment</span></div></div></div>');

        //itemTemplate.find('.bottomToolbar span').hover(function() {$(this).css('color','red');}, function() {$(this).css('color','black');});
   /*

    });
*/



    $container.append(
    $.map(itemsToBuy,function(itemToBuy, i) {
            var newItem = itemTemplate.clone();
            newItem.find('.imageParent a').attr('href',itemToBuy.imageTargetURL);
            newItem.find('.imageParent img').attr('src',itemToBuy.imageURL);
        newItem.find('.imageParent img').attr('height',itemToBuy.imageHeight);
        newItem.find('.imageParent img').attr('width',itemToBuy.imageWidth);
        newItem.find('.bottomToolbar span').hover(function() {$(this).css('color','red');}, function() {$(this).css('color','#999999');})
            .click(function(){console.log("clicked");
                $('fb\\:comments').attr('href',itemToBuy.imageTargetURL);

                FB.XFBML.parse($('fb\\:comments')[0]);

                $fbModalComments.find('.commentToolHeader .content span').replaceWith('<span>' + itemToBuy.title +'</span>');
                //$fbModalComments.find('.fb-comments').replaceWith('<div class="fb-comments" data-href="' + itemToBuy.imageTargetURL  + '" data-width="470" data-num-posts="1"></div>');


                $fbModalComments.find('.imageCt img').attr('src',itemToBuy.imageURL);
                console.log("");
                //FB.XFBML.parse(YOUR_DIV)
                $fbModalComments.find('.footer a').attr('href',itemToBuy.imageTargetURL)
//overlayId: 'fbCommentsModal-overlay', containerId : 'fbCommentsModal-container', dataId : 'fbCommentsModal'
                $fbModalComments.modal({overlayClose:true, minHeight : 550, minWidth: 650, onOpen: function (dialog) {
                    dialog.overlay.fadeIn('slow', function () {
                        dialog.data.hide();
                        dialog.container.fadeIn('slow', function () {
                            dialog.data.slideDown('slow');
                        });
                    });
                }, onClose: function (dialog) {
                    dialog.data.fadeOut('slow', function () {
                        dialog.container.hide('slow', function () {
                            dialog.overlay.slideUp('slow', function () {
                                $.modal.close();
                            });
                        });
                    });
                } });
                //$fbModalComments.find('iframe').replaceWith("<iframe frameBorder='0' scrolling='no' width='450' height='400' src='http://www.facebook.com/plugins/comments.php?href=" + itemToBuy.imageTargetURL + "&amp;ref=PDP'></iframe>");

              //  $fbModalComments.find('#commentsCt').children().attr('href',itemToBuy.imageTargetURL);

               // FB.XFBML.parse($fbModalComments.find('#commentsCt').children());



            });

            return newItem;
            //return '';
        }));




    $container.imagesLoaded(function(){
        $container.masonry({
            itemSelector : '.storeItem',
            isFitWidth: true,
            columnWidth : 250,
            gutterWidth: 25
        });
})});