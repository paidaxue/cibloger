<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>

<div>
	<p>密码设置</p>
	<?php $this->load->view('admin/profile_password_form'); ?>
</div>

<div>
	<p>个人信息设置</p>
	<?php $this->load->view('admin/profile_basic_form'); ?>
</div>