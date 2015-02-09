<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月9日PHP
*/

//存储已经登录后台的用户信息
//任何加载了这个类的类
//eg.如果要得到目前登录后台的账号uid	可以$this->user->uid

class User{
	
	private $_user = array();
	
	public $uid = 0;	//用户ID
	public $name = '';	//登录名
	public $mail = '';	//Email
	public $screenName = '';	//昵称
	public $created = 0;	//账号创建日期
	public $activated = 0;	//最后活跃时间
	public $logged = 0;		//上次登录
	public $group = 'visitor';	//所属用户组
	public $token = '';		//本次登录Token
	private $_CI;	//CI句柄
	
	public function __construct(){
		
		$this->_CI = & get_instance();
		
		//从浏览器反序列化,得到用户信息
		$this->_user = unserialize($this->_CI->session->userdata('user'));
		
		if(!empty($this->_user)){
			$this->uid = $this->_user['uid'];
			$this->name = $this->_user['name'];
			$this->mail = $this->_user['mail'];
			$this->url = $this->_user['url'];
			$this->screenName = $this->_user['screenName'];
			$this->created = $this->_user['created'];
			$this->activated = $this->_user['activated'];
			$this->logged = $this->_user['logged'];
			$this->group = $this->_user['group'];
			$this->token = $this->_user['token'];
		}
		
	}
	
}

/*
End of file
Location:User.php
*/