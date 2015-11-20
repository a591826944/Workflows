<?php
require_once('workflows.php');
require_once('ParserDom.php');
$wf = new Workflows();
$query = "{query}";
$request = file_get_contents('http://dict.youdao.com/search?q='.$query.'&keyfrom=dict.top');
$html_dom = new \HtmlParser\ParserDom($request);
$result = $html_dom->find('#phrsListTab .trans-container ul li');
foreach ($result as $value) 
{
	$value = explode('.', $value->getPlainText());
	$type = trim(array_shift($value)," ");
	$wf->result( $query, $query, $query.' - '.$type.'.', trim(implode(' ', $value)," "), 'icon.png' );
}
echo $wf->toxml();