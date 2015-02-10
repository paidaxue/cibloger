<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form action="<?php echo site_url('admin/metas/manage/category'.((isset($mid) && is_numeric($mid))?'/'.$mid:'')); ?>" method="post">

<ul>
	<li><label>分类名称*</label></li>
	<?php echo form_error('name','<p>','</p>'); ?>
	<input name="name" type="text" value="<?php echo set_value('name',(isset($name))?htmlspecialchars_decode($name):''); ?>" />
</ul>

<ul>
	<li><label>分类url缩略名</label></li>
	<?php echo form_error('slug','<p>','</p>'); ?>
	<input name="slug" type="text" value="<?php echo set_value('slug',(isset($slug))?htmlspecialchars_decode($slug):''); ?>" />
</ul>

<ul>
	<li><label>分类描述</label></li>
	<?php echo form_error('description','<p>','</p>'); ?>
	<input name="description" type="text" value="<?php echo set_value('slug',(isset($description))?htmlspecialchars_decode($description):''); ?>" />
</ul>

<input name="do" type="hidden" value="<?php echo (isset($mid) && is_numeric($mid))?'update':'insert'; ?>" />

<ul>
	<li>
		<button type="submit">
			<?php echo(isset($mid) && is_numeric($mid))?'更新分类':'添加分类'; ?>
		</button>
	</li>
</ul>

</form>
