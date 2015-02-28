<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>

<div class="container">
<div class="col-md-offset-2">


<form role="form" class="form-horizontal" action="" method="post" name="write_post">

<div class="form-group">
  <label class="col-md-2" for="title">标题</label>
  <div class="col-md-10">
    <input class="form-control" type="text" name="title" placeholder="文章标题" value="<?php echo set_value('title',(isset($title))?htmlspecialchars_decode($title):''); ?>" />
    <?php echo form_error('title','<p>','</p>'); ?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2">内容</label>
  <div class="col-md-10">
    <textarea rows="10" class="form-control input-sm" name="text" placeholder="文章内容"><?php echo set_value('text',(isset($text))?$text:''); ?></textarea>
    <?php echo form_error('text','<p>','</p>'); ?>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2">标签</label>
  <div class="col-md-10">
    <input name="tags" class="form-control" type="text" placeholder="文章标签" value="<?php echo set_value('tags',(isset($tags))?htmlspecialchars_decode($tags):''); ?>" />
  </div>
</div>

<div class="form-group">
  <label class="col-md-2">引用通告</label>
  <div class="col-md-10">
    <textarea rows="6" class="form-control input-sm" name="trackback" placeholder="每一行一个引用地址,用回车隔开"></textarea>
  </div>
</div>

<div class="form-group form-inline">
<label class="col-md-2">权限控制</label>
<div class="checkbox">
    <label>
      <input class="form-control" type="checkbox" value="1" <?php echo set_checkbox('allowComment','1',(1==$allow_comment)?TRUE:FALSE); ?> >允许评论
    </label>
</div>
<div class="checkbox">
    <label>
      <input type="checkbox" value="1" <?php echo set_checkbox('allowPing','1',(1==$allow_ping)?TRUE:FALSE); ?> >允许被引用
    </label>
</div>
<div class="checkbox">
    <label>
      <input type="checkbox" value="1" <?php echo set_checkbox('allowFeed','1',(1==$allow_feed)?TRUE:FALSE); ?> >允许在聚合中出现
    </label>
</div>
</div>

<div class="row form-group  form-inline">
<label class="col-md-2">选择发布日期:</label>
<input class="form-control" size="4" maxlength="4" type="text" name="year" value="<?php echo $this->form_validation->year; ?>" /><label>&nbsp;年&nbsp;&nbsp;&nbsp;</label>
<select name="month" class="form-control col-md-1">
				<option value="1" <?php if(1 == $this->form_validation->month): ?>select="true"<?php endif; ?>>一月</option>
				<option value="2" <?php if (2 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>二月</option>
                <option value="3" <?php if (3 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>三月</option>
                <option value="4" <?php if (4 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>四月</option>
                <option value="5" <?php if (5 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>五月</option>
                <option value="6" <?php if (6 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>六月</option>
                <option value="7" <?php if (7 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>七月</option>
                <option value="8" <?php if (8 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>八月</option>
                <option value="9" <?php if (9 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>九月</option>
                <option value="10" <?php if (10 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>十月</option>
                <option value="11" <?php if (11 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>十一月</option>
                <option value="12" <?php if (12 == $this->form_validation->month): ?>selected="true"<?php endif; ?>>十二月</option>
</select>&nbsp;&nbsp;
<input class="form-control" size="4" maxlength="4" type="text" name="day" value="<?php echo $this->form_validation->day; ?>" /><label>&nbsp;日&nbsp;&nbsp;&nbsp;</label>
<input class="form-control" size="4" maxlength="4" type="text" name="hour" value="<?php echo $this->form_validation->hour; ?>" /><label>&nbsp;时&nbsp;&nbsp;&nbsp;</label>
<input class="form-control" size="4" maxlength="4" type="text" name="min" value="<?php echo $this->form_validation->minute; ?>" /><label>&nbsp;分&nbsp;&nbsp;&nbsp;</label>
</div>
	
<div class="form-group">
<label class="col-md-2">选择分类</label>
<div class="col-md-10" >
<?php echo form_error('category[]','<p>','</p>') ?>
			<ul class="list-unstyled list-inline">
				<?php if($all_categories->num_rows() >0): ?>
					<?php foreach($all_categories->result() as $category): ?>
						<li>
							<input type="checkbox" value="<?php echo $category->mid; ?>" name="category[]" <?php echo set_checkbox('category[]', $category->mid,(isset($post_category) && in_array($category->mid, $post_category))?TRUE:FALSE); ?>/>
							<label><?php echo $category->name;?></label>
						</li>
					<?php endforeach; ?>
				<?php else: ?>
					没有任何分类,可以先添加分类
				<?php endif; ?>
			</ul>
</div>
</div>
	
<div class="form-group">
<label class="col-md-2" for="slug">缩略名:</label>
<div class="col-md-10">
<input class="form-control" type="text" placeholder="为文章自定义链接地址,有利于SEO" name="slug" value="<?php echo set_value('slug',(isset($slug))?htmlspecialchars_decode($slug):''); ?>" />
<?php echo form_error('slug','<p>','</p>'); ?>
</div>
</div>

<div class="form-group">
	<div class="col-md-offset-4">
    <button class="btn btn-default" type="submit" name="draft" value="1">保存并继续编辑</button>
    <button class="btn btn-default" type="submit" name="publish" value="0">发布这篇文章 &raquo;</button>
    </div>
</div>


</form>


</div>
</div>


<?php echo $this->load->view('admin/footer');?>
