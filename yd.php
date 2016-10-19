<?php
require_once('workflows.php');
require_once('ParserDom.php');
$wf = new Workflows();
$query = "{query}";
$query = str_replace('\\ ', ' ', trim($query));
$request = file_get_contents('http://dict.youdao.com/search?q='.urlencode($query).'&keyfrom=dict.top');
$html_dom = new \HtmlParser\ParserDom($request);

if(strstr($query, ' '))
{
    $result = $html_dom->find('#fanyiToggle .trans-container p');
    if(count($result) >= 3)
    {
        $result = $result[1];
        $wf->result( $query, $query, $query, trim($result->getPlainText()), 'icon.png' );
    }

}else{

    $result = $html_dom->find('#phrsListTab .trans-container ul li');
    foreach ($result as $value)
    {
        $value = explode('.', $value->getPlainText());
        $type = trim(array_shift($value)," ");
        $wf->result( $query, $query, $query.' - '.$type.'.', trim(implode(' ', $value)," "), 'icon.png' );
    }
}

echo $wf->toxml();