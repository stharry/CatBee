  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <style type="text/css">
        #slider { margin: 10px; }
    </style>
    <script>
        $(document).ready(function() {
            //$( ".selector" ).slider({ values: [1,5,9] });
            $("#slider").slider({min:0, max:2, change: function(event, ui)
            {
                var val =  ui.value;
                //alert(val);
                $("#LeaderReward").val((val + 1) * 5);
                $("#FriendReward").val((3 - val) * 5);

            }});
        });
    </script>


<div id="slider"></div>


