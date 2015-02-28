<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>
<form role="form" action="<?php echo site_url('admin/metas/manage/category'.((isset($mid) && is_numeric($mid))?'/'.$mid:'')); ?>" method="post">

<div class="form-group">
  <label>分类名称*</label><?php echo form_error('name','<p>','</p>'); ?>
  <input class="form-control" name="name" type="text" value="<?php echo set_value('name',(isset($name))?htmlspecialchars_decode($name):''); ?>" />
</div>

<div class="form-group">
  <label>分类url缩略名</label><?php echo form_error('slug','<p>','</p>'); ?>
  <input class="form-control" name="slug" type="text" value="<?php echo set_value('slug',(isset($slug))?htmlspecialchars_decode($slug):''); ?>" />
</div>

<div class="form-group">
  <label>分类描述</label><?php echo form_error('description','<p>','</p>'); ?>
  <input class="form-control" name="description" type="text" value="<?php echo set_value('slug',(isset($description))?htmlspecialchars_decode($description):''); ?>" />
</div>

<input name="do" type="hidden" value="<?php echo (isset($mid) && is_numeric($mid))?'update':'insert'; ?>" />

<div class="form-group">
		<button type="submit" class="btn btn-default">
			<?php echo(isset($mid) && is_numeric($mid))?'更新分类':'添加分类'; ?>
		</button>
</div>
</form>
