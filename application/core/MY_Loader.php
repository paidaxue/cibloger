<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月15日PHP
*/

//重写CI的loader库,用来支持前端显示的皮肤系统
class MY_Loader extends CI_Loader{
	
	//系统当前皮肤
	public $theme = 'default';
	
	public function __construct(){
		parent::__construct();
	}
	
	//打开皮肤功能
	public function switch_theme_on(){
		$this->_ci_view_paths = array(FCPATH . ST_THEMES_DIR . DIRECTORY_SEPARATOR . $this->theme . DIRECTORY_SEPARATOR	=> TRUE);
	}
	
	/**
	 * 关闭皮肤功能
	 *
	 * @access public
	 * @return void
	 */
	public function switch_theme_off()
	{
		//just do nothing
	}
	
}

/*
End of file
Location:MY_Loader.php
*/