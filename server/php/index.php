<?php

date_default_timezone_set("UTC");

$url = sprintf("http://testing.lib.wvu.edu/mike/middleware_test/index.%s",strtolower($_GET['type']));

exit(json_encode($_GET['type'](file_get_contents($url))));

function xml($content) {
	$content = simplexml_load_string($content);
	return array("status"  => strtolower($content->status), 
				 "date"    => time(), 
				 "content" => array(	
				 	"date"    => process_date($content->date),
				 	"message" => (string)$content->content
				 	));
}

function json($content) {
	$content = json_decode($content,true);
	return array("status"  => strtolower($content['status']), 
				 "date"    => time(), 
				 "content" => array(	
				 	"date"    => process_date($content['date']),
				 	"message" => $content['content']
				 	));
}

function html($content) {
	preg_match("/<body>.*<p>(.*)<\/p>.*<time>(.*)<\/time>.*<\/body>/msU",$content,$matches);
	return array("status"  => "ok", 
				 "date"    => time(), 
				 "content" => array(	
				 	"date"    => process_date($matches[2]),
				 	"message" => $matches[1]
				 	));
}

function process_date($date) {
	return date("Y-m-d", strtotime($date));
}

?>