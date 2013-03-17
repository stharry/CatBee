<?php
if (!empty($_SERVER['HTTPS']))
{
    $twitBase = 'HTTPS';
}
else
{
    $twitBase = 'HTTP';
}
?>

<html>
<head>
    <script src="<?php echo $twitBase; ?>://platform.twitter.com/anywhere.js?v=1" type="text/javascript"></script>
    <script type="text/javascript">
        try {
            window.opener.app.twitterAuthCallback();
        } catch (e) {

        }
    </script>
</head>
<body>
</body>
</html>
