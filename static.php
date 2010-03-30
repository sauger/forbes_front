<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<meta http-equiv=Content-Language content=zh-cn>
	<title>福布斯-页面静态化</title>
</head>
<body></body>
</html>
<?php
include 'frame.php';
#$url_head = "http://admin.forbeschina.com";
$url_head = "http://localhost";
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
	return write_to_file($file,$content,'w');
}

function static_index() {
	global $url_head;
	$content = file_get_contents("{$url_head}/index.php");
	return write_to_file("./index.html",$content,'w');
}
switch ($type) {
	case 'news':
		if(static_news($id)){
			echo '静态新闻成功！';
		}else{
			echo '静态新闻失败！';
		};
	break;
	case 'index':
		if(static_index()){
			echo '静态首页成功！';
		}else{
			echo '静态首页失败！';
		};
		break;
	default:
		;
	break;
}
