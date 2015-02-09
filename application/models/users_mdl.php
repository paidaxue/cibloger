<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月8日PHP
*/

/**用户逻辑*/
class Users_mdl extends CI_Model{
	
	const TBL_USERS = 'users';
	
	private $_unique_key = array('name','screenName','mail');
	
	public function __construct(){
		parent::__construct();
		
		//载入数据库类
		$this->load->database();
	}
	
	//检查用户是否通过验证,传入参数:输入的用户名,密码
	public function validate_user($username,$password){
		
		$data = FALSE;
		//查询数据库,两行等于select * from users where 'name'==$username;
		$this->db->where('name',$username);
		$query = $this->db->get(self::TBL_USERS);
		
		//如果查询结果是1个
		if($query->num_rows() == 1){
			//以数组形式返回查询的结果,赋值给$data
			$data = $query->row_array();
			
		}
		//如果用户名存在,查出了结果
		if(!empty($data)){
			//调用公共类Common的方法,验证密码,hash_Validate(输入的密码,数据库查询来的密码)对比
			//如果密码正确,那么返回用户信息$data,如果密码错误,$data=FALSE;
			$data = (Common::hash_Validate($password,$data['password'])) ? $data:FALSE;
			
		}	
		//释放掉这个查询
		$query->free_result();		
		//返回用户信息
		return $data;
	}
	
	//修改用户信息
	public function update_user($uid,$data,$hashed = TRUE){
		
		//如果密码没有加密,那么给密码加密
		if(!$hashed){
			$data['password'] = Common::do_hash($data['password']);
		}
		//更新数据库
		//intval — 获取变量的整数值
		$this->db->where('uid',intval($uid));
		$this->db->update(self::TBL_USERS,$data);
		
		//如果更新的条数>0,返回true
		return ($this->db->affected_rows()>0)?TRUE:FALSE;
	}
	
	//获取单个用户信息
	public function get_user_by_id($uid){
		
		$data = array();
		
		$this->db->select('*')->from(self::TBL_USERS)->where('uid',$uid)->limit(1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$data = $query->row_array();
		}
		$query->free_result();
		return $data;
	}
	
	//获取所有用户信息
	public function get_users(){
		return $this->db->get(self::TBL_USERS);
	}
	
	//添加一个用户
	public function add_user($data){
		
		//给密码加密,再用来传入数据库
		$data['password'] = Common::do_hash($data['password']);
		
		//插入数据库
		$this->db->insert(self::TBL_USERS,$data);
		
		//如果插入成功,返回TRUE
		return ($this->db->affected_rows() > 0)? TRUE : FALSE;
	}
	
	//删除一个用户
	public function remove_user($uid){
		$this->db->delete(self::TBL_USERS,array('uid' => intval($uid)));
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
}


/*
End of file
Location:users_mdl.php
*/