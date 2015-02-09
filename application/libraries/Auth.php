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
	
	//设置用户组,数字越小权限越大:管理员,编辑,贡献者
	public $groups = array('administrator'=>0,'editor'=>1,'contributor'=>2);
	
	//CI句柄
	private $_CI;
	
	public function __construct(){
		//自定义的库调用get_instance()方法,才能使用ci资源库
		$this->_CI = & get_instance();
		
		$this->_CI->load->model('users_mdl');
		
		//从session数据库中去除数据,反序列化
		$this->_user = unserialize($this->_CI->session->userdata('user'));
		//var_dump($this->_user);
		//print_r($this->_user);

	}
	
	//判断用户是否已经登录,这个方法要结合下面方法process_login(),清晰一些
	public function hasLogin(){
		
		//如果$this->_hasLogin不等于空,说明已经登录,返回数据(登录过一次,浏览器已经有session)
		if(NULL !== $this->_hasLogin){
			return $this->_hasLogin;
		}
		else{
			
			//在浏览器第一次登录
			
			//$this->_user是数据库中取出的用户信息
			//如果用户信息不等于空,并且用户uid不等于空
			if(!empty($this->_user) && NULL !== $this->_user['uid']){
				
				//根据用户的uid取出用户信息
				$user = $this->_CI->users_mdl->get_user_by_id($this->_user['uid']);
				
				if($user && $user['token'] == $this->_user['token']){
					$user['activated'] = time();
					//更新最后活跃时间
					$this->_CI->users_mdl->update_user($this->_user['uid'],$user);
					return ($this->_hasLogin = TRUE);
				}
			}
			
			return ($this->_hasLogin = FALSE);
			
		 }
		 
		 
	}

	
	//处理用户登录
	public function process_login($user){
		//$this->_user在反序列化的初始化后,得到数据库的session信息,传递出来的$user数据覆盖原来的$this->_user
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

	//定义调用需要的权限,跟用户拥有的权限做对比
	public function exceed($group,$return = false){
		
		//如果权限验证通过,那么返回TRUE
		if(!!(array_key_exists($group,$this->groups) && $this->groups[$this->_user['group']] <= $this->groups[$group])){
			return TRUE;
		}
		
		//权限验证未通过，同时为返回模式
		if($return){
			return FALSE;
		}
		//非返回模式
		show_error('禁止访问,你的权限不足');
		return;
	}
	
}

/*
End of file
Location:Auth.php
*/