<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月10日PHP
*/

class Posts extends ST_Auth_Controller{
	
	private $_data  = array();
	
	public function __construct(){
		parent::__construct();
		
		$this->auth->exceed('contributor');
		
		$this->_data['parentPage'] = 'post';
		$this->_data['currentPage'] = 'post';
		$this->_data['page_title'] = '管理文章';
		
	}
	
	public function index(){
		redirect('admin/posts/write');
	}
	
	//方法分离:如果第四个参数存在,那么就编辑文章,不存在就添加文章
	public function write(){
		
		if(FALSE === $this->uri->segment(4)){
			$this->_write();
		}else{
			$pid = $this->security->xss_clean($this->uri->segment(4));
			is_numeric($pid)?$this->_edit($pid):show_error('禁止访问:危险操作');
		}
		
	}
	
	//添加一篇文章
	private function _write(){
		
	}
	
	
}


/*
End of file
Location:posts.php
*/