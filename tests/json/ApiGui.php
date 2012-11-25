<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/3dParty/HtmlDom/simple_html_dom.php");

try
{
//    $html = new simple_html_dom();
//
//    $html->load_file("res/RichEmailTemplate001.html");
//
//    $ret = $html->find('img');
//
//    foreach ($ret as $a)
//    {
//        var_dump($a);
//    }

    $html = file_get_contents("res/RichEmailTemplate001.html");

    $dom = new DOMDocument();
    //if (!$dom->load("C:/Program Files/EasyPHP-12.1/www/CatBee/tests/json/res/RichEmailTemplate001.html"))
    if (!$dom->loadHTML($html))
    {
        echo 'Cannot load';

    }
    else
    {

//        $imgs = $dom->getElementsByTagName("img");
//
//        foreach ($imgs as $img)
//        {
//            foreach ($img->attributes as $attr)
//            {
//                if ($attr->name == 'src')
//                {
//                    echo $attr->value.'<p>';
//                }
//            }
//        }
//        $finder = new DomXPath($dom);
//        $classname="mcnImage";
//        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
//        $nodes = $finder->query("//a");
//

//        var_dump($nodes);
//
//        foreach ($nodes as $node)
//        {
//            echo $node->nodeName.' => ';
//            echo $node->nodeValue.'<p>';
//        }
//        $replacer = new DomTagReplacer();
//        $replacer->replaceTagsInDOM($dom);

        $share = new Share();
        $share->id = 222;
        $deal = new LeaderDeal();
        $deal->id = 111;
        $share->deal = $deal;


        $dealTag = 'deal';
        $idTag = 'id';

        echo 'res '.$share->$idTag.' <p> ';
        echo 'res '.$share->$dealTag->$idTag.' <p> ';

        var_dump($share->deal);

//        $newHtml = $dom->saveHTML();
//
//        echo $newHtml;
    }
} catch (Exception $e)
{
    echo $e->getMessage();
}
echo 'finished';