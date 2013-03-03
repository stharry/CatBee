<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include_once($_SERVER['DOCUMENT_ROOT'] . "/CatBee/scripts/globals.php");

$jsFiles = array("TribZi.js", "email.js",
    "facebook.js", "landing.js", "pinterest.js",
    "twitter.js", "jcookie.js",
    "jquery.jcarousel-core.js",
    "jquery.jcarousel-autoscroll.js");

foreach ($jsFiles as $jsFile)
{
    $fileName = $_SERVER['DOCUMENT_ROOT'] . "/CatBee/public/res/js/{$jsFile}";
    echo "Started " . $fileName . "...</p>";

    $post   = array(
        "js_code"           => file_get_contents($fileName),
        "compilation_level" => "SIMPLE_OPTIMIZATIONS",
        "output_format"     => "json",
        "output_info"       => "statistics",
        "output_file_name"  => $jsFile
    );
    $result = json_decode(RestUtils::SendFreePostRequest("http://closure-compiler.appspot.com/compile", $post), true);

    $in  = fopen("http://closure-compiler.appspot.com" . $result['outputFilePath'], 'r');
    $out = fopen($_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/CatBee/public/res/js/min/{$jsFile}", 'w');

    while (!feof($in))
    {

        $buffer = fread($in, 2048);

        fwrite($out, $buffer);
    }

    fclose($in);
    fclose($out);

    echo "Finished " . $fileName . "...</p>";
}

echo "The END";
