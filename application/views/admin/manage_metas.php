<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>
<ul >
<li><?php echo anchor(site_url('admin/metas/manage'),'分类');?></li>||
<li><?php echo anchor(site_url('admin/metas/manage/tag'),'标签');?></li>
</ul>

<?php if('category' == $type):?>

<form method="post" action="<?php echo site_url('admin/metas/operate/'.$type); ?>">
<table>

	<thead>
		<tr>
			<th>名称</th>
			<th></th>
			<th>url缩略名</th>
			<th>文章数</th>
			<th>操作</th>
		</tr>
	</thead>
	
	<tbody>
		<?php if($category->num_rows() > 0): ?>
			
			<?php foreach($category->result() as $cate): ?>
				<tr>
					<td>
						<?php echo anchor('admin/metas/manage/category/'.$cate->mid,$cate->name);?>
					</td>
					<td>
					</td>
					<td>
						<?php echo $cate->slug; ?>
					</td>
					<td>
					</td>
					
					<td>
						<?php echo anchor('admin/metas/operate/'.$type.'/'.$cate->mid.'/delete','删除');?>			
					</td>
				</tr>
			
			<?php endforeach; ?>
		
		<?php else: ?>
			<tr>
				<td>没有任何分类</td>
			</tr>
		
		<?php endif;?>
	</tbody>
	
</form>
<?php else:?>
标签
面板

<?php endif; ?>
	
	
	
	<table>
	
	                <?php if('category' == $type):?>
                	<?php $this->load->view('admin/metas_cate_form');?>
                <?php endif;?>
                
                <?php if('tag' == $type):?>
                	<?php $this->load->view('admin/metas_tag_form');?>
                <?php endif;?>
	</table>

</table>