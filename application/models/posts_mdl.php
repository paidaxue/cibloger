<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月11日PHP
*/

//文章处理modeel
class Posts_mdl extends CI_Model{
	
	const TBL_POSTS = 'posts';
	const TBL_METAS = 'metas';
	const TBL_RELATIONSHIPS = 'relationships';
	const TBL_COMMENTS = 'comments';
	
	//内容类型 日志/附件/独立页面
	private $_post_type = array('post','attachment','page');
	
	//内容状态:	发布/草稿/未归档/等待审核
	private $_post_status = array('publish','draft','unattached','attached','waiting');
	
	//内容的唯一栏:pid/slug
	private $_post_unique_field = array('pid','slug');
	
	public function __construct(){
		parent::__construct();
		
	}
	
	//添加一个内容
	public function add_post($content_data){
		$this->db->insert(self::TBL_POSTS,$content_data);
		return ($this->db->affected_rows() == 1) ? $this->db->insert_id() : FALSE;
	}
	
	//处理slug重复问题
	public function get_slug_name($slug,$pid){
		$result = $slug;
		$count = 1;
		//根据表单提交的slug,查询数据库中slug的值等于提交的,并且pid不等于提交的pid	查询到行数
	
		while($this->db->select('pid')->where('slug',$result)->where('pid <>',$pid)->get(self::TBL_POSTS)->num_rows()>0){
			//对表单提交的$slug后面加下划线和数字
			$result = $slug.'_'.$count;
			$count ++;
		}
		
		//返回处理好的slug
		return $result;
	}
	
	//获取内容列表
	/**
	 * 
	 * @param string $type			内容类型:'post','attachment','page'文章/附件/独立页面
	 * @param string $status		内容状态:'publish','draft','unattached','attached','waiting'发布/草稿/未归档/等待审核
	 * @param string $author_id		作者ID(可选)
	 * @param string $limit			条数(可选)
	 * @param string $offset		偏移量(可选)
	 * @param number $category_filter	需要过滤的栏目ID(可选)
	 * @param string $title_filter	需要过滤的标题关键字(可选)
	 * @param string $feed_filter	是否显示在feed里面(可选)
	 */
	public function get_posts($type='post',$status='publish',$author_id=NULL,$limit=NULL,$offset=NULL,$category_filter=0,$title_filter='',$feed_filter=FALSE){

		//select * from posts and users.screenName join users where users.uid = posts.authorId');
		$this->db->select('posts.*,users.screenName');
		$this->db->join('users','users.uid=posts.authorId');
		
		//如果参数$type在数组$this->_post_type里面
		if($type && in_array($type,$this->_post_type)){
			
			//从posts表中选出对应类型的记录,例如,传入的是$type=post,那么就是选出post类型的所有记录
			$this->db->where('posts.type',$type);
		}
		
		//如果参数$status是在数组$this->_post_status里面
		if($status && in_array($status,$this->_post_status)){
			
			//从posts表中选出对应状态的记录,例如,传入的$status=publish,那么就选出publish状态的所有记录
			$this->db->where('posts.status',$status);
		}
		
		//如果传入的$author_id参数不为空
		if(!empty($author_id)){
			
			//从posts表中选出对应作者的记录
			$this->db->where('posts.authorId',intval($author_id));
		}
		
		//如果参数$category_filter存在
		if(!empty($category_filter)){
			//过滤,得到对应id的类目
			$this->db->join('relationships','posts.pid=relationships.pid','left');
			$this->db->where('relationships.mid',intval($category_filter));
		}
		
		//如果参数$title_filter存在
		if(!empty($title_filter)){
			
			//过滤,从posts表中查出title为$title_filter的记录
			$this->db->like('posts.title',$title_filter);
		}
		
		if($feed_filter){
			$this->db->where('allowFeed',1);	
		}
		
		//对查询结果排序
		$this->db->order_by('posts.created','DESC');
		
		//如果参数$limit存在,并且是整数数字
		if($limit && is_numeric($limit)){
			
			//限制条数
			$this->db->limit(intval($limit));
		}
		
		//查询结果的偏移量(从哪一个开始)
		if($offset && is_numeric($offset)){
			$this->db->offset(intval($offset));
		}
		
		//返回结果
		return $this->db->get(self::TBL_POSTS);
		
	}
	
	//更新文章
	public function update_post($pid,$data){
		$this->db->where('pid',intval($pid));
		$this->db->update(self::TBL_POSTS,$data);
		
		return ($this->db->affected_rows() == 1)?TRUE:FALSE;
	}
	
	
	/**
	 * 根据唯一键获取单个内容信息
	 *
	 * @access public
	 * @param  string $identity 内容标识栏位：{"pid"｜"slug"}
	 * @param  mixed  $value    标识栏位对应的值
	 * @return array  内容信息
	 */
	public function get_post_by_id($identity, $value)
	{
		if(!in_array($identity, $this->_post_unique_field))
		{
			return FALSE;
		}
	
		$this->db->select('posts.*,users.screenName');
		$this->db->join('users', 'users.uid = posts.authorId');
		$this->db->where($identity, $value);
	
		return $this->db->get(self::TBL_POSTS)->row();
	}
	
	
	
}

/*
End of file
Location:posts_mdl.php
*/