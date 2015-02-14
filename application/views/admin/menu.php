<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div>
<ul>
<ui><?php echo anchor(site_url('admin/users/manage/'),'用户',array('title'=>'用户'));?></ui>
</ul>

<ul>
	文章及分类管理
	<ui><?php echo anchor(site_url('admin/metas/manage/'),'标签和分类',array('title'=>'标签和分类'));?></ui>
	
</ul>

<ul>
	<li>
		<?php echo anchor(site_url('admin/posts/manage'),'文章管理',array('title'=>'文章管理'));?>
	</li>
	<li>
		<?php echo anchor(site_url('admin/posts/write'),'写新文章',array('title'=>'写新文章'));?>
	</li>
</ul>


<ul>
	<li>欢迎, <?php 
				echo anchor(site_url('admin/profile/'),$this->user->name,array('class'=>'author important'));?>||
	</li>
	<li>
		<?php 
			echo anchor(site_url('admin/login/logout'),'登出',array('class'=>'exit','title'=>'安全登出后台'));?>
	</li>

</ul>
</div>
<br/><br/>