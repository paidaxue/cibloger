<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>


<ul>
<ui><?php echo anchor(site_url('admin/users/manage/'),'用户',array('title'=>'用户'));?></ui>
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
