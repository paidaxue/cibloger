<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$this->load->view('header');
?>

<div>
	
	<h3><?php echo $post->title; ?></h3>
	
	<h4>
		<span>发布于:<?php echo $post->published; ?></span>
		<span>分类:<?php echo Common::format_metas($post->categories, ',');?></span>
		<span>作者: <?php echo anchor(site_url('authors/'. $post->authorId), $post->screenName);?></span>
	</h4>
	<div>
	<?php echo $post->content;?>		
	</div>
	
	<div class="related">
						<h4><strong>相关日志:</strong></h4>
							<ul>
								<?php $this->plugin->trigger('Widget::Posts::Related', $post->pid, 5, '<li><a href="{permalink}">{title}</a>  ({date})</li>');?>
							</ul>				
					</div>
					
					<div class="tags">
						<?php if(!empty($post->tags)):?>
							<h4><strong>标签:</strong> <?php echo Common::format_metas($post->tags, ',');?></h4>
						<?php endif;?>
					</div>

</div>

<?php $this->load->view('sidebar');?>
<?php $this->load->view('footer');?>