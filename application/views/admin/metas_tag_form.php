<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form action="<?php echo site_url('admin/metas/manage/tag'.((isset($mid) && is_numeric($mid))?'/'.$mid:'')); ?>" method="post">

<ul>
	<li><label>标签名称*</label></li>
	<?php echo form_error('name','<p>','</p>'); ?>
	<input name="name" type="text" value="<?php echo set_value('name',(isset($name))?htmlspecialchars_decode($name):''); ?>" />
</ul>

<ul>
	<li><label>标签url缩略名</label></li>
	<?php echo form_error('slug','<p>','</p>'); ?>
	<input name="slug" type="text" value="<?php echo set_value('slug',(isset($slug))?htmlspecialchars_decode($slug):''); ?>" />
</ul>

<ul>
	<li><label>标签描述</label></li>
	<?php echo form_error('description','<p>','</p>'); ?>
	<input name="description" type="text" value="<?php echo set_value('slug',(isset($description))?htmlspecialchars_decode($description):''); ?>" />
</ul>

<input name="do" type="hidden" value="<?php echo (isset($mid) && is_numeric($mid))?'update':'insert'; ?>" />

<ul>
	<li>
		<button type="submit">
			<?php echo(isset($mid) && is_numeric($mid))?'更新标签':'添加标签'; ?>
		</button>
	</li>
</ul>

</form>

