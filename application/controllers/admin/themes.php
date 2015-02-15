<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月15日PHP
*/
//前端显示主题管理
class Themes extends ST_Auth_Controller{
	
	//传递到视图的数据
	private $_data = array();
	
	//当前主题
	private $_current_theme = '';
	
	public function __construct(){
		parent::__construct();
		
		$this->auth->exceed('administrator');
		
		//setting_item()是Common类的方法,得到current_theme对应的值,当前主题
		$this->_current_theme = setting_item('current_theme');
		
		//加载主题model类
		$this->load->model('themes_mdl');
		
		$this->_data['parentPage'] = 'dashboard';
		$this->_data['currentPage'] = 'themes';
	}
	
	public function index(){
		redirect('admin/themes/manage');
	}
	
	public function manage(){
		
		$this->_data['page_title'] = '网站外观';
		//得到所有主题
		$this->_data['themes'] = $this->themes_mdl->get_all();
		
		$this->load->view('admin/themes',$this->_data);
	}
	
	
	
}

/*
End of file
Location:theme.php
*/