<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月9日PHP
*/

//后台所有控制器父类
class ST_Auth_Controller extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		//加载验证类
		$this->load->library('auth');
		
		//检查登录
		if(!$this->auth->hasLogin()){
			//echo "st_auth_con验证没通过";
			//echo urlencode($this->uri->uri_string());
			redirect('admin/login?ref='.urlencode($this->uri->uri_string()));
		}  
		
		//加载后台控制器公共类
		$this->load->library('form_validation');
		$this->load->library('user');
		
		//加载后台控制器公共模型
		$this->load->model('users_mdl');
		
		//后台管理页面,不适用皮肤
		//$this->load->switch_theme_off();
		
	}
	
}

/*
End of file
Location:MY_Controller.php
*/