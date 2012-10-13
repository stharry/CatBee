$(document).ready(function () {

    $("#autostart").fancybox({

        'width' : 490,
        'height' : 500,
        'autoScale' : false,
        'transitionIn' : 'none',
        'transitionOut' : 'none',
        'type' : 'iframe',
        'scrolling'   : 'no',
        overlay : {
            css : {
                'background' : 'rgba(238,238,238,0.85)'
            }
        }



        /*
        helpers : {
            title : {
                type : 'inside'
            },
            overlay : {
                css : {
                    'background' : 'rgba(238,238,238,0.85)'
                }
            }
        }
        */
    });
}); // document ready
