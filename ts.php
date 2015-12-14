<?php
date_default_timezone_set('Asia/Shanghai');

require 'workflows.php';

$wf = new Workflows();

$query = "{query}";
$placeholder = '请输入 时间戳/格式化时间 ...';

if(empty($query))
{
	$query = trim(`pbpaste`);
	$query = iconv(mb_detect_encoding($query), "UTF-8", $query);
}

$query = str_replace('\\', '', $query);

if(ctype_digit($query))
{
  if(strlen($query) > 10)
  {
	$query = $query / 1000;

  } else {

	$query = intval($query);
  }

  $result = date('Y-m-d H:i:s', $query);

} else {

  $result = strtotime($query);
}

if (empty($query)) 
{
	$query = $placeholder;
}
if (empty($result)) 
{
	$result = $placeholder;
}

$wf->result( $query, $result, $result, $query, 'icon.png' );

echo $wf->toxml();