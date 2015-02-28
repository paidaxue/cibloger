<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html  lang="zh-CN">

 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="renderer" content="webkit">
  <metaname="viewport"content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('css/admin.css'); ?>">

    <title><?php echo setting_item('blog_title');?> &raquo; <?php echo $page_title;?></title>
    <meta name="Keywords" content="<?php echo $page_keywords;;?>" />
	<meta name="Description" content="<?php echo $page_description;?>" />
	
	<?php echo $parsed_feed;?>
	<?php echo isset($extra_header)?$extra_header:'';?>
	
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
	  <?php echo anchor(site_url(), setting_item('blog_title'),array('class'=>'navbar-brand'));?>
    </div>
    
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li><?php echo anchor(site_url(), '首页');?></li>
        <?php $this->plugin->trigger('Widget::Categories', '<li><a href="{permalink}" title="{description}">{title}</a></li>');?>
      </ul>
      <form class="navbar-form navbar-right" role="search" method="get" action="<?php echo site_url('search'); ?>">
		<div class="form-group">
			<input class="form-control" placeholder="搜索" type="text" name="s" size="25"/>
			<button class="form-control" type="submit" >搜索</button>
		</div>
	  </form>
    </div>
    
    
    
  </div>
</nav>
<div class="container">

