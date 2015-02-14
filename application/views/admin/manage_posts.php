<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>

<div>
	<div>
		<ul>
			<li <?php if('publish' == $status): ?> class="current" <?php endif; ?> >
				<?php echo anchor('admin/posts/manage'.(isset($author_id)?'?author='.$this->input->get('author',TRUE):''),'已发布'); ?>
			</li>
			
			<li <?php if('draft' == $status): ?> class="current" <?php endif; ?> >
				<a href="<?php echo site_url('admin/posts/manage/draft'.(isset($author_id)?'?author='.$this->input->get('author',TRUE):'')); ?>" >草稿
				<?php if('on' !== $this->session->userdata('__all_posts') && !isset($author_id) && ($my_draft_num = $this->stats->count_posts('post','draft',$this->user->uid)) > 0): ?>
					<?php echo $my_draft_num ?>
				
				<?php elseif('on' == $this->session->userdata('__all_posts') && !isset($author_id) && ($all_draft_num = $this->stats->count_posts('post','draft',NULL))>0): ?>
					<?php echo $all_draft_num; ?>
				
				<?php elseif('on' !== $this->session->userdata('__all_posts') && isset($author_id) && ($author_draft_num = $this->stats->count_posts('post','draft',$author_id))>0): ?>
					<?php $author_draft_num; ?>
				
				<?php endif; ?>
				</a>
			</li>
			
			<li <?php if('waiting' ==$status): ?> class="current" <?php endif; ?> >
				<a href="<?php echo site_url('admin/posts/manage/waiting'.(isset($author_id)?'?author='.$this->input->get('author',TRUE):'')); ?>" >待审核
					<?php if('on' !== $this->session->userdata('__all_posts') && !isset($author_id) && ($my_waiting_num = $this->stats->count_posts('post','waiting',$this->user->uid))>0): ?>
						<?php echo $my_waiting_num; ?>
					<?php elseif('on' == $this->session->userdata('_all_posts') && !isset($author_id) && ($all_waiting_num = $this->stats->count_posts('post','waiting',NULL))>0): ?>
						<?php echo $all_waiting_num; ?>
					<?php elseif('on' !== $this->session->userdata('__all_posts') && isset($author_id) && ($author_waiting_num = $this->stats->count_posts('post','waiting',$author_id))>0): ?>
						<?php echo $author_waiting_num; ?>
					<?php endif; ?>
				</a>
			</li>	
			<?php if($this->auth->exceed('editor',TRUE) && !isset($author_id)): ?>
				<li class="right<?php if('on' == $this->session->userdata('__all_posts')): ?> current<?php endif; ?>"><?php echo anchor("admin/posts/manage/$status?__all_posts=on",'所有'); ?></li>
				<li class="right<?php if('on' !== $this->session->userdata('__all_posts')): ?> current<?php endif; ?>"><?php echo anchor("admin/posts/manage/$status?__all_posts=off",'我发布的'); ?></li>
				
			<?php endif; ?>
		</ul>
	</div>
</div>

<form method="post" name="manage_posts" action="<?php echo site_url('admin/posts/operate'); ?>">
<table>
	<thend>
		<th>选中</th>
		<th>评论数</th>
		<th>标题</th>
		<th>浏览</th>
		<th>作者</th>
		<th>分类</th>
		<th>发布日期</th>
	</thend>
	
	<tbody>
		<?php if($posts->num_rows()>0): ?>
			<?php foreach($posts->result() as $post): ?>
				<tr <?php echo ($post->pid % 2==0)?'':'class="even"' ?> id="<?php echo 'post-'.$post->pid; ?>">
					<td><input type="checkbox" value="<?php echo $post->pid; ?>" name="pid[]" ></td>
					<td>评论数</td>
					<td><?php echo anchor(site_url('admin/posts/write/'.$post->pid),$post->title); ?></td>
					<td>浏览</td>
					<td><?php echo anchor("admin/posts/manage/$status?author=".$post->authorId,$post->screenName); ?></td>
					<td>
						<?php 
							$length = count($post->categories);
							foreach($post->categories as $key => $val):?>
							<?php 
								echo '<a href="';
								echo site_url("admin/posts/manage/$status?category=".$val['mid'].(isset($author)?'&author='.$this->input->get('author',TRUE):''));
								echo '">'.$val['name']. '</a>' .($key < $length - 1 ? ',':'');?>	
						<?php endforeach; ?>
						
					</td>
					<td><?php echo Common::dateWord($post->created, now());?></td>
					
					
					
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	
	</tbody>
	
	
</table>

</form>

<?php echo isset($pagination)?$pagination:''; ?>