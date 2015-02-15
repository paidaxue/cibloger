<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月15日PHP
*/

//实用函数
class Utility{
	
	private $_CI;
	
	public function __construct(){
		
		$this->_CI =& get_instance();
		
	}
	
	//清空缓存文件
	public function clear_file_cache(){
		
		$this->_CI->load->helper('file');
		
		$path = $this->_CI->config->item('cache_path');
		
		delete_files($path);
		
		@copy(APPPATH.'index.html', $this->_CI->config->item('cache_path').'/index.html');
		
	}
	
	//清空数据库缓存文件
	public function clear_db_cache()
	{
		$this->_CI->load->helper('file');
	
		delete_files(APPPATH . "dbcache" . DIRECTORY_SEPARATOR, TRUE);
	
		@copy(APPPATH . 'index.html', APPPATH . "dbcache/" . 'index.html');
	}
	
	//获取激活的插件
	public function get_active_plugins(){
		
		//从数据库中获取激活的插件
		$active_plugins = setting_item('active_plugins');
		
		if(empty($active_plugins)){
			return array();
		}
		
		//反序列化
		$plugins = unserialize($active_plugins);
		
		return $plugins ? (is_array($plugins) ? $plugins : array($plugins)):array();
		
	}
	
}

/*
End of file
Location:Utility.php
*/