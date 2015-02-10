<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月10日PHP
*/

class Metas_mdl extends CI_Model{
	
	const TBL_METAS = 'metas';
	const TBL_RELATIONSHIPS = 'relationships';
	const TBL_POSTS = 'posts';
	
	private $_type = array('category','tag');
	
	//文章元数据
	public $metas = NULL;
	
	public function __construct(){
		parent::__construct();
	}
	
	//获取所有metas
	public function list_metas($type = 'category'){
		
		//如果传入的参数category或者是tag,那么执行查询
		if(in_array($type,$this->_type)){
			$this->db->where(self::TBL_METAS.'.type',$type);
		}
		
		//返回查询结果
		return $this->db->get(self::TBL_METAS);
		
	}
	
	//添加meta
	public function add_meta($meta_data){
		$this->db->insert(self::TBL_METAS,$meta_data);
		
		return($this->db->affected_rows() == 1)?$this->db->insert_id():FALSE;
		
	}
	
	//获取元数据
	public function get_meta($type = 'category',$name = ''){
		
		if(empty($name)){
			exit();
		}
		
		if($type == 'BYID'){
			$this->db->where(self::TBL_METAS.'.mid',intval($name));
		}
		return $this->db->get(self::TBL_METAS)->row();
		
	}
	
	//修改meta信息
	public function update_meta($mid,$data){
		$this->db->where('mid',intval($mid));
		$this->db->update(self::TBL_METAS,$data);
		
		return ($this->db->affected_rows() == 1)? TRUE:FALSE;
	}
	
	//删除一个meta
	public function remove_meta($mid){
		$this->db->delete(self::TBL_METAS,array('mid' => intval($mid)));
		
		return ($this->db->affected_rows == 1)?TRUE:FALSE;
	}
	
	//删除一个关系
	public function remove_relationship($column = 'pid',$value){
		$this->db->delete(self::TBL_RELATIONSHIPS,array($column => intval($value)));
		
		return ($this->db->affected_rows() == 1)?TRUE:FALSE;
	}
	
}

/*
End of file
Location:metas_mdl.php
*/