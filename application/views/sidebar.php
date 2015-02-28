<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="col-md-3">
 <h5>关于博客</h5>
 <p>这是个人博客,写写笔记<br /></p>
    
    <!-- categories -->
    <h5>日志分类</h5>
 <ul class="list-unstyled">
     <?php $this->plugin->trigger('Widget::Categories', '<li><a href="{permalink}" title="{description}">{title} [{count}]</a></li>');?>
 </ul>
    
    <h5>最新日志</h5>
 <ul class="list-unstyled">
        <?php $this->plugin->trigger('Widget::Posts::Recent', '<li><a href="{permalink}" title="{title}">{title}</a></li>');?>
 </ul>
    
    <h5>最新评论</h5>
 <ul class="list-unstyled">
     <?php $this->plugin->trigger('Widget::Comments::Recent', '<li><a href="{permalink}" title="{parent_post_desc}">{title}: </a><p>{content}</p></li>', 50, '...');?>
 </ul>
 
 <h5>日志归档</h5>
 <ul class="list-unstyled">
     <?php $this->plugin->trigger('Widget::Posts::Archive', '<li><a href="{permalink}">{title} [{count}]</a></li>', 'month', 'Y年m月');?>
 </ul>


</div>