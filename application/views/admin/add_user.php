<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>

<form action="" method="post">
	<ul>
		<li>
		<label>用户名*</label>
		<input name="uname" type="text" class="text" <?php if(isset($uid) && is_numeric($uid)){echo 'readonly';}?> value="<?php echo set_value('uname',(isset($uname))?$uname:''); ?>"/>
		<?php echo form_error('name','<p>','</p>')?>
		</li>
	</ul>
	
	<ul>
		<li>
		<label>Email邮箱*</label>
		<input name="mail" type="text" class="text" value="<?php echo set_value('mail',(isset($mail))?$mail:''); ?>"/>
		<?php echo form_error('mail','<p>','</p>')?>
		</li>
	</ul>
	
	<ul>
		<li>
		<label>用户昵称</label>
		<input name="screenName" type="text" class="text" value="<?php echo set_value('screenName',(isset($screenName))?$screenName:''); ?>"/>
		<?php echo form_error('screenName','<p>','</p>')?>
		</li>
	</ul>
	
	<ul>
		<li>
		<label>用户密码*</label>
		<input name="password" type="password" class="password" value="<?php echo set_value('password',(isset($password))?$password:''); ?>"/>
		<?php echo form_error('password','<p>','</p>')?>
		</li>
	</ul>

	<ul>
		<li>
		<label>用户密码确认*</label>
		<input name="confirm" type="password" class="password"/>
		<?php echo form_error('confirm','<p>','</p>')?>
		</li>
	</ul>
	
	<ul>
		<li>
		<label>个人主页</label>
		<input name="url" type="text" class="text" value="<?php echo set_value('url',(isset($url))?$url:''); ?>"/>
		</li>
	</ul>
	
	<select name="group" id="group">
		<option value="contributor"<?php echo set_select('group', 'contributor', ('contributor' != $group)?FALSE:TRUE); ?>>
		贡献者</option>
		<option value="editor"<?php echo set_select('group', 'editor', ('editor' != $group)?FALSE:TRUE); ?>>
		编辑</option>
		<option value="administrator"<?php echo set_select('group', 'administrator', ('administrator' != $group)?FALSE:TRUE); ?>>
		管理员</option>
	</select>
	
					<button type="submit">
				<?php echo (isset($uid) && is_numeric($uid))?'编辑用户':'添加用户';?>
				</button>

</form>



