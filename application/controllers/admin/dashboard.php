<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月9日PHP
*/

//博客后台控制台控制器

class Dashboard extends ST_Auth_Controller{
	
	//传递到对应视图的数据
	private $_data = array();
	
	public function __construct(){
		parent::__construct();
		
		//页面导航栏和标题
		$this->_data['page_title'] = '网站概要';
		$this->_data['parentPage'] = 'dashboard';
		$this->_data['currentPage'] = 'dashboard';
	}
	
	public function index(){
		
		//本方法需要的权限
		$this->auth->exceed('contributor');
		
		//加载页面
		$this->load->view('admin/dashboard',$this->_data);
	}
	
}

/*
End of file
Location:dashboard.php
*/