;(function($) {
    $(function() {
        $('#my-button').bind('click', function(e) {
            e.preventDefault();
            $('#element_to_pop_up').bPopup({
                content:'iframe', //'iframe' or 'ajax'
                contentContainer:'.content',
                loadUrl: 'http://127.0.0.1:8080/CatBee/adapters/demo/demoActions/goDeal.php'
            });
        });
    });
})(jQuery);