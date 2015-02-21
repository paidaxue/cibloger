<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <title><?php echo setting_item('blog_title');?> &raquo; <?php echo $page_title;?></title>
    <meta name="Keywords" content="<?php echo $page_keywords;;?>" />
	<meta name="Description" content="<?php echo $page_description;?>" />
	
	<?php echo $parsed_feed;?>
	<?php echo isset($extra_header)?$extra_header:'';?>
	
</head>
<body>

<div id="header">
	
	<form method="get" action="<?php echo site_url('search'); ?>">
		<div>
			<input type="text" name="s" size="25"/>
			<input type="submit" value="Search" />
		</div>
	
	</form>

	<?php echo anchor(site_url(), setting_item('blog_title'));?>
    <?php echo setting_item('blog_slogan');?>
    <?php $this->plugin->trigger('hook_test');?>
    
     <div id="topbar">
        	<ul>
			    <li><?php echo anchor(site_url(), '首页');?></li>
			    <?php $this->plugin->trigger('Widget::Navigation', '<li><a href="{permalink}">{title}</a></li>');?>
			</ul>
		</div>
    
</div>

