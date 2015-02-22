<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/header');
$username_error = ( trim(form_error('name')) != '' ) ? 'has-error' : '';
$password_error = ( trim(form_error('password')) != '' ) ? 'has-error' : '';
$login_error = '';
if(!empty($login_error_msg)){
	$login_error = $login_error_msg ? 'has-error' : '';
}

?>

<div class="container">

<?php echo form_open('admin/login?ref='.urlencode($this->referrer),array('name'=>'login','class'=>'form-signin')); ?>

<h2 class="form-signin-heading">用户登录页面:</h2>

 <div class="row">
 	<div class="col-md-6 <?php echo $username_error?>">
 	<input type="text" id="name" name="name" class="form-control" placeholder="请输入用户名">
 	</div>
 	<div class="col-md-6 <?php echo $username_error; echo $login_error;?>">
 		 <?php echo form_error('name'); ?>
 		 <?php echo (empty($login_error_msg))?'':'<p class="error-text">'.$login_error_msg.'</p>'; ?>
 	</div>
 </div>
 <br>
 
  <div class="row">
 	<div class="col-md-6  <?php echo $password_error?>">
 	<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码">
 	</div>
 	<div class="col-md-6">
 		 <?php echo form_error('password'); ?>
 	</div>
 </div>
 
 <div class="row">
 	<div class="col-md-3">
 	<button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
 	</div>
 </div>

 
 



<?php echo form_close(); ?>
</div>




<?php echo $this->load->view('admin/footer');?>