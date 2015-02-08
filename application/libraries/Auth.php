<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月8日PHP
*/

//控制用户登录和登出,以及一个简单的权限控制ACL实现

class Auth{
	
	//存储用户信息
	private $_user = array();
	
	//是否已经登录
	private $_hasLogin = NULL;
	
	//CI句柄
	private $_CI;
	
	public function __construct(){
		//自定义的库调用get_instance()方法,才能使用ci资源库
		$this->_CI = & get_instance();
		
		$this->_CI->load->model('users_mdl');

	}
	
	//判断用户是否已经登录
	public function hasLogin(){
		
		//如果$this->_hasLogin不等于空,说明已经登录,返回数据
		if(NULL != $this->_hasLogin){
			return $this->_hasLogin;
		}
		else{
			
			if(!empty($this->_user) && NULL != $this->_user['uid']){
				
				
				
			}
			
		}
		
	}

	//处理用户登录
	public function process_login($user){
		//获取用户信息
		$this->_user = $user;
		
		//每次登录时需要更新数据
		//上次登陆最后活跃时间
		$this->_user['logged'] = now();
		//最后活跃时间
		$this->_user['activated'] = $user['logged'];
		//每次登录,更新一次token
		$this->_user['token'] = sha1(now().rand());
		
		//调用model层,更新数据库用户登录信息,$this->_user['uid']是从数据库调用出来的用户uid
		//如果更新成功,设置session
		if($this->_CI->users_mdl->update_user($this->_user['uid'],$this->_user)){
			
			//设置session
			$this->_set_session();
			
			//是否登录设置成TRUE
			$this->_hasLogin = TRUE;
			return TRUE;
			
		}
		return FALSE;
	}
	
	//设置session
	private function _set_session(){
		//对用户信息序列化
		$session_data = array('user' => serialize($this->_user));
		//把session添加到浏览器,同时添加到数据库中
		$this->_CI->session->set_userdata($session_data);
	}

	
}

/*
End of file
Location:Auth.php
*/