<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form action="<?php echo site_url('admin/profile/updatePassword'); ?>" method="post">
	
	<ul>
		<li>
			<label>用户密码</label>
			<input name="password" type="password" />
			<?php echo form_error('password','<p>','</p>') ?>
		</li>
	</ul>

	<ul>
		<li>
			<label>用户密码确认</label>
			<input name="confirm" type="password" />
			<?php echo form_error('confirm','<p>','</p>') ?>
		</li>
	</ul>
	
	<ul>
		<li>
			<button type="submit">更新密码</button>
		</li>
	
	</ul>
	
</form>