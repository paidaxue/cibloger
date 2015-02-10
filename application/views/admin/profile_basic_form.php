<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<form action="<?php echo site_url('admin/profile/updateProfile'); ?>" method="post">
	
	<ul>
		<li>
			<label>昵称</label>
			<input name="screenName" type="text" value="<?php echo $this->user->screenName; ?>" />
			<?php echo form_error('screenName','<p>','</p>') ?>
		</li>
	</ul>

	<ul>
		<li>
			<label>个人主页地址</label>
			<input name="url" type="text" value="<?php echo $this->user->url; ?>" />
			<?php echo form_error('url','<p>','</p>') ?>
		</li>
	</ul>
	
	<ul>
		<li>
			<label>电子邮箱地址*</label>
			<input name="mail" type="text" value="<?php echo $this->user->mail; ?>" />
			<?php echo form_error('mail','<p>','</p>') ?>
		</li>
	</ul>	
	
	<ul>
		<li>
			<button type="submit">更新我的档案</button>
		</li>
	
	</ul>
	
</form>