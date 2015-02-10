<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月10日PHP
*/

class Profile extends ST_Auth_Controller{
	private $_data = array();
	
	public function __construct(){
		parent::__construct();
		
		$this->_data['page_title'] = '个人设置';
		$this->_data['parentPage'] = 'dashboard';
		$this->_data['currentPage'] = 'profile';
		
	}
	
	//加载个人信息更新界面
	public function index(){
		$this->auth->exceed('contributor');
		$this->load->view('admin/profile',$this->_data);
	}
	
	//修改个人密码
	public function updatePassword(){
		
		$this->form_validation->set_rules('password', '新的密码', 'required|min_length[6]|trim|matches[confirm]');
		$this->form_validation->set_rules('confirm', '确认的密码', 'required|min_length[6]|trim');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('admin/profile',$this->_data);
		}else{
			
			//根据用户id查询用户信息
			$user = $this->users_mdl->get_user_by_id($this->user->uid);
			
			//如果存在用户信息
			if($user){
				
				//得到新提交的密码
				$user['password'] = $this->input->post('password',TRUE);
				
				//更新密码
				$this->users_mdl->update_user($this->user->uid,$user,FALSE);
			}
			
			$this->session->set_flashdata('success','密码已经更新');
			redirect('admin/profile');
		}
		
	}
	
	//修改个人信息
	public function updateProfile(){
		
		$this->form_validation->set_rules('screenName', '昵称', 'trim|callback__screenName_check');
		$this->form_validation->set_rules('url', '个人主页', 'trim|prep_url');
		$this->form_validation->set_rules('mail', '邮箱地址', 'required|trim|valid_email|callback__email_check');
		
		if($this->form_validation->run() == FALSE){
			$this->load->view('admin/profile',$this->_data);
		}else{
			
			$user = $this->users_mdl->get_user_by_id($this->user->uid);
			
			if($user){		
				$user['screenName'] = $this->input->post('screenName') ? $this->input->post('screenName',TRUE):trim($user['name']);
				$user['url'] = $this->input->post('url',TRUE);
				$user['mail'] = $this->input->post('mail',TREU);
				
				$this->users_mdl->update_user($this->user->uid,$user);
				
			}	
			
			//更新数据后,重新登录,这样信息才会在页面上更新
			$this->auth->process_login($user);
			
			$this->session->set_flashdata('success','个人信息已经更新');
			redirect('admin/profile');	
		}
		
	}
	
}

/*
End of file
Location:profile.php
*/