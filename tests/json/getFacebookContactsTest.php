<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <title>get contacts test</title>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script src="http://127.0.0.1:8080/CatBee/tests/json/res/getFacebookContacts.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
        }
        html, body {
            height: 100%;
            overflow: hidden;
        }
        #ContactsArea {
            height: 200px;
            width: 400px;
            overflow: auto;
            -moz-column-count: 2;
            -moz-column-gap: 10px;
            -webkit-column-count: 2;
            -webkit-column-gap: 10px;
            column-count: 3;
            column-gap: 20px;
        -webkit-column-width: 200px;
        -moz-column-width: 200px;
        }
    </style>
</head>
<body>

<div>
    <div>
        <img src="https://graph.facebook.com/700203087/picture"/><label for="checkbox1"> asaadasdada</label>
        <input type="checkbox" id="checkbox1" name="checkbox1" value="1"/>
    </div>
    <div>
        <img src="https://graph.facebook.com/700203087/picture"/><label for="checkbox2"> asaadasdada</label>
        <input type="checkbox" id="checkbox2" name="checkbox1" value="1"/>
    </div>
</div>
<input id="aaa" type="submit" value="Click here to get contacts"/>

<div id="ContactsArea"></div>
</body>
</html>