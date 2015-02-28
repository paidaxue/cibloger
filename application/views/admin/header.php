<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<!DOCTYPE html>
<html  lang="zh-CN">

 <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="renderer" content="webkit">
  <metaname="viewport"content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url('css/admin.css'); ?>">



  
    <title></title>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <p class="navbar-text">博客后台管理</p>
    <?php if(isset($this->user->name)): ?>
	<ul class="nav nav-tabs navbar-right">
	  <p class="navbar-text">欢迎:</p>
	  <li role="presentation"><?php echo anchor(site_url('admin/profile/'),$this->user->name,array('class'=>'author important'));?></li>
	  <li role="presentation"><?php echo anchor(site_url('admin/login/logout'),'登出',array('class'=>'exit','title'=>'安全登出后台'));?></li>
	</ul>
	
	<?php endif; ?>
  </div>
</nav>
