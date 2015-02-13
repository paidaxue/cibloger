<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月10日PHP
*/

class Metas extends ST_Auth_Controller{
	
	private $_data = array();
	
	//当前操作的类目/标签id
	private $_mid = 0;
	
	//设置默认为类目,另一个是标签tag
	private $_type = 'category';
	
	//中英文转化表
	private $_map = array('category' => '分类', 'tag' => '标签');
	
	public function __construct(){
		
		parent::__construct();
		
		//作者不能访问,至少需要编辑,或者管理员
		$this->auth->exceed('editor');
		
		$this->load->model('metas_mdl');
		
		$this->_data['page_title'] = '分类与标签';
		$this->_data['parentPage'] = 'manage-posts';
		$this->_data['currentPage'] = 'manage-metas';
		
	}
	
	public function index(){
		redirect('admin/metas/manage');
	}
	
	//分类管理:功能包括:1.查询列出所有分类;2.添加分类;3.编辑分类
	//因为查询,编辑,添加都是在同一个view里面,所以提交到同一个方法好操作?
	//默认是管理分类
	public function manage($type = 'category',$mid=NULL){
		
		$this->_data['type'] = $type;	//传入的meta,默认是category
		$this->_data[$type] = $this->metas_mdl->list_metas($type);
		
		//print_r($this->_data[$type]);
		
		//如果是编辑,那么会传入参数,得到分类的$mid
		if($mid && is_numeric($mid)){
			$this->_data['mid'] = $mid;
			
			//根据$mid查询分类信息
			$meta = $this->metas_mdl->get_meta('BYID',$mid);
			
			$this->_data['name'] = $meta->name;
			$this->_data['slug'] = $meta->slug;
			$this->_data['description'] = $meta->description;
			
			unset($meta);
		}
		
		//添加分类或者编辑分类
		$this->_operate($type,$mid);
		
		$this->load->view('admin/manage_metas',$this->_data);
		
	}
	
	//添加或者编辑metas
	public function _operate($type,$mid){
		
		$this->_type = $type;
		$this->_mid = $mid;
		
		$this->_load_validation_rules();
		
		if($this->form_validation->run() === FALSE){
			return;
		}else{
			$action = $this->input->post('do',TRUE);
			$name = $this->input->post('name',TRUE);
			$slug = $this->input->post('slug',TRUE);
			$description = $this->input->post('description',TRUE);
			
			$data = array(
				'name' => $name,
				'type' => $type,
				'slug' => $slug,
				'description' => (!$description)?NULL:$description		
			);
			
			if('insert' == $action){
				$this->metas_mdl->add_meta($data);
				
				$this->session->set_flashdata('success',$this->_map[$type].'添加成功');
				
			}
			
			if('update' == $action){
				$this->metas_mdl->update_meta($mid,$data);
				
				$this->session->set_flashdata('success',$this->_map[$type].'更新成功');
			}
			
			redirect('admin/metas/manage/'.$this->_type);
			
		}
	}
	

	//操作分发:删除,刷新,合并metas
	public function operate($type,$mid,$do){
		$this->_type = $type;
		switch($do){
			case 'delete':
				$this->_remove($type,$mid);
				break;
			case 'refresh':
				echo "shuashua";
				break;
			default:
				exit;
				break;
		}
	}
	
	//删除metas
	private function _remove($type,$mid){
		$this->metas_mdl->remove_meta($mid);
		$res = $this->metas_mdl->remove_relationship('mid',$mid);
		
		$msg = $res ? $this->_map[$type].'删除成功':$this->_map[$type].'没有被删除';
		$notify = $res ? 'success':'error';
		
		redirect('admin/metas/manage/'.$this->_type);
		
	}
	
	//前端类目验证
	private function _load_validation_rules(){
		$this->form_validation->set_rules('name','名称','required|trim|htmlspecialchars');
		
		if('category' == $this->_type){
			$this->form_validation->set_rules('slug', '缩略名', 'trim|alpha_dash|htmlspecialchars');
		}else
		{
			$this->form_validation->set_rules('slug', '缩略名', 'trim|htmlspecialchars');	
		}
		
		$this->form_validation->set_rules('description', '描述', 'trim|htmlspecialchars');	
		
	}
	
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


/*
End of file
Location:metas.php
*/