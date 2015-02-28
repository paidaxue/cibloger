<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>
<div class="container">
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">


<div class="row">
<form  action="" method="post">
  <div class="panel panel-success">
  <div class="panel-heading">
    <?php echo (isset($uid) && is_numeric($uid))?'编辑用户':'添加用户';?>操作:
  </div>

  <div class="panel-body">

  <div class="form-group col-sm-9">
    <label>用户名*</label>
    <input name="uname" type="text" class="form-control" placeholder="请输入用户名,用于用户登录"  <?php if(isset($uid) && is_numeric($uid)){echo 'readonly';}?> value="<?php echo set_value('uname',(isset($uname))?$uname:''); ?>" />
    <?php echo form_error('name','<p>','</p>')?>
  </div>
  
  <div class="form-group col-sm-9">
    <label>Email邮箱*</label>
    <input name="mail" type="text" class="form-control" placeholder="输入联系的E-mail" value="<?php echo set_value('mail',(isset($mail))?$mail:''); ?>" />
    <?php echo form_error('mail','<p>','</p>')?>
  </div>
  
  <div class="form-group col-sm-9">
    <label>用户昵称</label>
    <input name="screenName" type="text" class="form-control" placeholder="输入昵称" value="<?php echo set_value('screenName',(isset($screenName))?$screenName:''); ?>" />
    <?php echo form_error('screenName','<p>','</p>')?>
  </div>
  
  <div class="form-group col-sm-9">
    <label>用户密码*</label>
    <input name="password" type="password" class="form-control" placeholder="设置用户登录密码" value="<?php echo set_value('password',(isset($password))?$password:''); ?>" />
    <?php echo form_error('password','<p>','</p>')?>
  </div>
  
  <div class="form-group col-sm-9">
    <label>确认密码*</label>
    <input name="confirm" type="password" class="form-control" placeholder="再次输入密码" value="<?php echo set_value('password',(isset($password))?$password:''); ?>" />
    <?php echo form_error('confirm','<p>','</p>')?>
  </div>
  
  <div class="form-group col-sm-9">
    <label>个人主页</label>
    <input name="url" type="text" class="form-control" placeholder="个人主页" value="<?php echo set_value('url',(isset($url))?$url:''); ?>"/>
    <?php echo form_error('screenName','<p>','</p>')?>
  </div>
  
  <div class="form-group col-sm-9">
  <div class="row">
  <div class="col-md-3">
  <select name="group" id="group" class="form-control">
		<option value="contributor"<?php echo set_select('group', 'contributor', ('contributor' != $group)?FALSE:TRUE); ?>>
		贡献者</option>
		<option value="editor"<?php echo set_select('group', 'editor', ('editor' != $group)?FALSE:TRUE); ?>>
		编辑</option>
		<option value="administrator"<?php echo set_select('group', 'administrator', ('administrator' != $group)?FALSE:TRUE); ?>>
		管理员</option>
	</select>
  </div>
  <button type="submit" class="btn btn-default"><?php echo (isset($uid) && is_numeric($uid))?'编辑用户':'添加用户';?></button>
  </div>
  </div>
  
 
 </div>
 
  </div>  
</form>
</div>
</div>
</div>


<?php echo $this->load->view('admin/footer');?>
