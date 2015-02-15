<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月15日PHP
*/

/**
 * Stcache Library Class
 *
 * 一个简单的key-value文件缓存实现，非常适合缓存系统经常调用的（从数据库中提取的）一些数据，比如用户参数信息.
 *
 *	为什么用户参数信息的存储不使用CI默认提供的DB缓存？
 *		因为CI提供的DB缓存的生成是以controller/method的形式生成，对于那些被*多个控制器同时调用*的公共数据,
 *		比如配置信息，采用DB缓存会生成同样内容的缓存文件。所以，我绝不是因为蛋疼而写了这个类。
 *
 * 使用方法：请参见 ./application/st_plugins/ 官方编写的插件文件.
 */

class Stcache{
	//缓存路径
	private $_cache_path;
	
	//缓存过期时间,单位是秒
	private $_cache_expire;
	
	//初始化,设置缓存过期时间和存储路径
	public function __construct(){
		$this->_cache_expire = 1200;
		$this->_cache_path = APPPATH . ST_DB_CACHE_DIR . DIRECTORY_SEPARATOR;;
	}
	
	//设置缓存
	public function set($key,$data){
		$value = serialize($data);
		
		$file = $this->_file($key);
		//write_file()是ci系统方法
		return write_file($file,$value);
	}
	
	//缓存的文件名
	private function _file($key){
		return $this->_cache_path.md5($key);
	}
	
	/**
	 * 获取缓存
	 *
	 * @access public
	 * @param  string $key 缓存的唯一键
	 * @return mixed
	 */
	public function get($key)
	{
		$file = $this->_file($key);
	
		/** 文件不存在或目录不可写 */
		if (!file_exists($file) || !is_really_writable($file))
		{
			return false;
		}
	
		/** 缓存没有过期，仍然可用 */
		if ( time() < (filemtime($file) + $this->_cache_expire) )
		{
				
			$data = read_file($file);
				
			if(FALSE !== $data)
			{
				return unserialize($data);
			}
				
			return FALSE;
		}
	
		/** 缓存过期，删除之 */
		@unlink($file);
		return FALSE;
	}
	
	
	
}

/*
End of file
Location:Stcache.php
*/