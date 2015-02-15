<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月9日PHP
*/

//前台所有控制器的父类
class ST_Controller extends CI_Controller{
	
	function __construct(){
		
		parent::__construct();
		
		//检查服务器上的PHP版本
		//$this->utility->check_compatibility();
		
		//检查站点当前状态
		//$this->utility->check_blog_status();
		
		//$this->load->library('common');
		
		//设置当前使用的主题皮肤
		$this->load->theme = setting_item('current_theme');
		
		//前台页面均使用主题皮肤功能
		$this->load->switch_theme_on();
		
	}
	
	/**
	 * 加载某个主题页面下的VIEW
	 *
	 * 第1/2/4个参数分别对应CI原有的load view中的第1/2/3参数，这里的第三个参数用于一些特殊场合：
	 * 当整站缓存功能被开启时，为了避免当前被操作的页面缓存，可以设置第三个参数为FALSE避免。
	 *
	 *
	 * @access   public
	 * @param    string
	 * @param    array
	 * @param	 bool
	 * @param    bool
	 * @return   void
	 */
	function load_theme_view($view,$vars=array(),$cached=TRUE,$return=FALSE){
		
	/** 加载对应主题下的view */
		//DIRECTORY_SEPARATOR:目录分隔符，是定义php的内置常量。在调试机器上，在windows我们习惯性的使用“\”作为文件分隔符，但是在linux上系统不认识这个标识，于是就要引入这个php内置常量了：DIRECTORY_SEPARATOR
		if(file_exists(FCPATH. ST_THEMES_DIR. DIRECTORY_SEPARATOR . setting_item('current_theme'). DIRECTORY_SEPARATOR . $view .'.php')) 
		{
			echo $this->load->view($view, $vars,$return);
		}
		else 
		{
			show_404();
		}
		
		/** 是否开启缓存? */
		if(1 == intval(setting_item('cache_enabled')) && $cached)
		{
			$cache_expired = setting_item('cache_expire_time');
			
			$cache_expired = ($cache_expired && is_numeric($cache_expired)) ? intval($cache_expired) : 60;
			
			/** 开启缓存 */
			$this->output->cache($cache_expired);
		}
		
	}
	
	
	
}


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