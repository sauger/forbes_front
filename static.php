<?php
include 'frame.php';
$url_head = "http://admin.forbeschina.com";
$types = array('news','index');
$type = strtolower($_GET['type']);
if(!in_array($type,$types)) die('invalid static type!'); 
$id = intval($_GET['id']);
function static_news($id) {
	if(!$id){
		return false;
	};
	global $url_head;
	$news = new table_class('fb_news');
	$news->find($id);
	$url = "{$url_head}/news/news.php?id={$id}";
	$content = file_get_contents($url);
	$date = date('Ym',strtotime($news->created_at));
	$dir  = "./review/{$date}";
	if(!is_dir($dir)){
		mkdir($dir);
	}
	$file = $dir ."/{$id}.html";
	write_to_file($file,$content,'w');
}

function static_index() {
	global $url_head;
	$content = file_get_contents("{$url_head}/index.php");
	write_to_file("./index.html",$content,'w');
}
switch ($type) {
	case 'news':
		static_news($id);
	break;
	case 'index':
		static_index();
		break;
	default:
		;
	break;
}
