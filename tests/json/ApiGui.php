<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");


//include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/3dParty/HtmlDom/simple_html_dom.php");

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

//    $html = file_get_contents("http://127.0.0.1:8080/bbb.html");
    $html = file_get_contents("http://127.0.0.1:8080/bbb.html");

    $dom = new DOMDocument();
    //if (!$dom->load("C:/Program Files/EasyPHP-12.1/www/CatBee/tests/json/res/RichEmailTemplate001.html"))
    if (!$dom->loadHTML($html))
    {
        echo 'Cannot load';

    }
    else
    {
        ////printNode($dom->documentElement);

        $adapter = new MailChimpTemplateAdapter();



        $template = $adapter->convertToTribziTemplate($dom);

        $jsonAdapter = new JsonTemplateAdapter();


        $templateProps = str_replace('\u00a0', '', json_encode($jsonAdapter->toArray($template)));
        echo $templateProps;

        $template = $jsonAdapter->fromArray(json_decode($templateProps, true));

        $decorator = new HtmlTemplateDecorator();
        $builder = new TemplateBuilder();
        $output = $builder->buildTemplate($share, $template, $decorator);

        echo $output;


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


//        $newHtml = $dom->saveHTML();
//
//        echo $newHtml;
    }
} catch (Exception $e)
{
    echo $e->getMessage();
}
echo 'finished';

function printNode($node, $tab = '')
{
    $val = $node->nodeType == XML_TEXT_NODE ? $node->nodeValue : '';
    echo $tab.'name: '.$node->nodeName.' val: '.$val.'<br>';

    if ($node->hasChildNodes())
    {
        foreach ($node->childNodes as $childNode)
        {
            printNode($childNode, $tab."___");
        }
    }
}