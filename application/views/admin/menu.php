<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>


 <div class="container">
 
      
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><?php echo anchor(site_url('admin/posts/manage'),'控制面板',array('title'=>'控制面板'));?></li>
          </ul>
          <ul class="nav nav-sidebar">
          	<li><?php echo anchor(site_url('admin/users/manage/'),'用户',array('title'=>'用户管理'));?></li>
          	<li><?php echo anchor(site_url('admin/profile/'),'个人信息设置',array('title'=>'个人信息设置'));?></li>
            <li><?php echo anchor(site_url('admin/metas/manage/'),'标签和分类',array('title'=>'标签和分类'));?></li>
            <li><?php echo anchor(site_url('admin/posts/manage'),'文章管理',array('title'=>'文章管理'));?></li>
            <li><?php echo anchor(site_url('admin/posts/write'),'写新文章',array('title'=>'写新文章'));?></li>
          </ul>
        </div>
 </div>
       
        
        
