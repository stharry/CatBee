$(document).ready(function () {

    $("#autostart").fancybox({

        'width' : '175%',
        'height' : '175%',
        'autoScale' : true,
        'transitionIn' : 'none',
        'transitionOut' : 'none',
        'type' : 'iframe',
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
