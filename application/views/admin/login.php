<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/header');?>

<div>
<?php $this->load->view('admin/notify'); ?>
<?php echo form_open('admin/login?ref='.urlencode($this->referrer),array('name'=>'login')); ?>

<ul><?php echo validation_errors(); ?> </ul>
<p><label for="name">用户名:</label><input type="text" id="name" name="name" class="text" /></p>
<p><label for="password">密码:</label><input type="password" id="password" name="password" class="text" /></p>
<p class="submit"><button type="submit">登录</button></p>

<?php echo form_close(); ?>

后台登录页面
</div>




<?php echo $this->load->view('admin/footer');?>