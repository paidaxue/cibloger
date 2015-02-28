<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>


<div class="col-md-12 col-md-offset-2 main">

	<h2>个人信息设置:</h2>
	<br>
	
	<div class="row">
		
	  <div class="col-md-4">
		<form action="<?php echo site_url('admin/profile/updatePassword'); ?>" method="post">
		<div class="row">
		<div class="form-group password-form">
			<label class="col-md-4">用户密码:</label>
			<div class="col-md-8">
			<input name="confirm" class="form-control" type="password" placeholder="请输入密码"/>
			<?php echo form_error('password','<p>','</p>') ?>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group password-form">
			<label class="col-md-4">确认密码:</label>
			<div class="col-md-8">
			<input name="password" class="form-control" type="password" placeholder="再次输入确认"/>
			<?php echo form_error('confirm','<p>','</p>') ?>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="form-group">
		    <div class="col-md-4">
		      <button type="submit" class="btn btn-default">更新密码</button>
		    </div>
	  	</div>	
	  	</div>
	  	
		</form>
	  </div>
		
		
		<div class="col-md-8">
		<form action="<?php echo site_url('admin/profile/updateProfile'); ?>" method="post">
		
			<div class="row password-form">
				<div class="input-group col-md-6">
  					<span class="input-group-addon" id="basic-addon1">昵称:</span>
					<input class="form-control" name="screenName" type="text" value="<?php echo $this->user->screenName; ?>" />
					<?php echo form_error('screenName','<p>','</p>') ?>
				</div>
			</div>
			
			<div class="row password-form">
				<div class="input-group col-md-6">
					<span class="input-group-addon" id="basic-addon1">个人主页地址:</span>
					<input class="form-control" name="url" type="text" value="<?php echo $this->user->url; ?>" />
					<?php echo form_error('url','<p>','</p>') ?>
				</div>
			</div>
			
			<div class="row password-form">
				<div class="input-group col-md-6">
				<span class="input-group-addon" id="basic-addon1">电子邮箱地址*</span>
					<input class="form-control" name="mail" type="text" value="<?php echo $this->user->mail; ?>" />
					<?php echo form_error('mail','<p>','</p>') ?>
				</div>
			</div>
			
			<div class="row password-form">
				<div class="col-md-3">
		      		<button type="submit" class="btn btn-default">更新我的档案</button>
		    	</div>
			</div>

	  
	</form>
	
		</div>
	
	</div>

</div>

</div>
<?php echo $this->load->view('admin/footer');?>