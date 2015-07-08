<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>企业后台</title>
<?php $baseUrl = Wave::app()->request->baseUrl;?>
<?php $homeUrl = Wave::app()->homeUrl;?>
</head>
<frameset rows="50,*" framespacing="0" frameborder="0">
<frame src="<?php echo $homeUrl.'site/header';?>" frameborder="no" marginwidth="0" marginheight="0" noresize>
<frameset cols="200,*" framespacing="0" frameborder="0">
    <frame src="<?php echo $homeUrl.'site/lefttree';?>" frameborder="no" marginwidth="0" marginheight="0" noresize>
    <frame src="<?php echo $homeUrl.'site/right';?>" frameborder="no" marginwidth="0" marginheight="0" noresize name="right_frame">
</frameset>
</frameset>
</html>
