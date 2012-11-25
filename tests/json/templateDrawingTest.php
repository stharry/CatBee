<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include_once($_SERVER[ 'DOCUMENT_ROOT' ] . "/CatBee/scripts/globals.php");

$adapter = new JsonTemplateAdapter();
$template = new Template();
$template->style->addElement('cc', '11')->addElement('hh', '23');

$section = $template->addSection();
$section->style->addElement('A', '2')->addElement('B', '2');

$field = $section->addField();
$field->style->addElement('a', '1')->addElement('b', '4');

$str = $adapter->toArray($template);
//echo '<p>'.json_encode($str).'<p>';


$tempStr = file_get_contents("res/sampleEmailTemplate.json");

$template = $adapter->fromArray(json_decode($tempStr, true));

//echo '<p>'.$tempStr.'<p>';
//var_dump($template->style->elements);

$share = new Share();

$builder = new TemplateBuilder();
$result = $builder->buildTemplate($share, $template);

file_put_contents('c:/kuku.html', $result);
