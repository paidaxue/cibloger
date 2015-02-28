<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="col-md-9">
<?php if(isset($current_view_hints)): ?>
	<strong>正在查看:</strong><?php echo $current_view_hints; ?>
<?php endif; ?>

<?php if(!empty($posts) && is_array($posts)): ?>
	<?php foreach($posts as $post): ?>
		<h3><?php echo anchor($post->permalink,$post->title); ?></h3>
		<h4>
			<span>发布于:<?php echo $post->published; ?></span>
			<span>分类:<?php echo Common::format_metas($post->categories,','); ?></span>
			<span>作者:<?php echo anchor(site_url('authors/'.$post->authorId),$post->screenName); ?></span>
			<span><?php echo anchor($post->permalink.'#comments',$post->commentsNum.'个评论'); ?></span>
		</h4>
		
		<div>
			<p>文章简略:</p>
			<?php echo $post->excerpt; ?>
			
			<?php if($post->more): ?>
				<p><?php echo anchor($post->permalink,'&raquo;阅读全文'); ?></p>
			<?php endif; ?>
			
			<div>
				<?php if(!empty($post->tags)): ?>
					标签:<?php echo Common::format_metas($post->tags,','); ?>
				<?php endif; ?>
			</div>		
		</div>
		
	<?php endforeach; ?>

<?php endif; ?>

<?php if(isset($pagination)):?>
	<?php echo $pagination;?>
<?php endif;?>

</div>