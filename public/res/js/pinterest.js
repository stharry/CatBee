$(document).ready(function () {
    CreateAndInitializePinterestForm();
});


function CreateAndInitializePinterestForm() {

    $("#pinterestShare").click(function () {

        if ($('.pinterest-form').css('display') == 'none') {

            $('.pinterest-form').show();
            $('#pinterestShare').parent().addClass('active');

        }
        else {
            $('.pinterest-form').hide();
            $('#pinterestShare').parent().removeClass('active');


        }
    });

};
