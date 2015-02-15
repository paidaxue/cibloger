<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月15日PHP
*/

//评论相关model
class Comments_mdl extends CI_Model{
	
	const TBL_USERS = 'users';
	const TBL_COMMENTS = 'comments';
	
	/**
	 * 类型：评论/引用
	 *
	 * @access private
	 * @var array
	 */
	private $_type = array('comment', 'trackback');
	
	/**
	 * 状态：通过/待审核/垃圾
	 *
	 * @access private
	 * @var array
	*/
	private $_status = array('approved', 'waiting', 'spam');
	
	/**
	 * 构造函数
	 *
	 * @access public
	 * @return void
	*/
	public function __construct()
	{
		parent::__construct();
	
		log_message('debug', "STBLOG: Comments Model Class Initialized");
	}
	
	/**
	 * 获取评论列表，支持分页
	 *
	 * @access public
	 * @param  int    $pid 		post id
	 * @param  string $status 	评论状态
	 * @param  string $type		评论类型，包括comment和ping back
	 * @param  int    $limit 	limit
	 * @param  int    $offset 	offset
	 * @param  string $order 	DESC|ASC
	 * @param  string $filter 	内容过滤关键字
	 * @return object
	 */
	public function get_cmts($pid = 0, $type = 'comment', $status = 'approved', $limit = 0, $offset = 0, $order = 'DESC', $filter = '')
	{
		if($pid && is_numeric($pid))
		{
			$this->db->where('pid', intval($pid));
		}
		 
		if($type && in_array($type, $this->_type))
		{
			$this->db->where(self::TBL_COMMENTS.'.type', $type);
		}
	
		if($status && in_array($status,$this->_status))
		{
			$this->db->where(self::TBL_COMMENTS.'.status', $status);
		}
	
		if(!empty($filter))
		{
			$this->db->like('text', $filter);
		}
		 
		if($limit && is_numeric($limit))
		{
			$this->db->limit(intval($limit));
		}
		 
		if($offset && is_numeric($offset))
		{
			$this->db->offset(intval($offset));
		}
		 
		if($order && in_array($order, array('DESC', 'ASC')))
		{
			$this->db->order_by(self::TBL_COMMENTS.'.cid', $order);
		}
	
		return $this->db->get(self::TBL_COMMENTS);
	}
	
}


/*
End of file
Location:comments_mdl.php
*/