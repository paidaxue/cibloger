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
		
		$this->load->model('metas_mdl');
		$this->load->model('posts_mdl');
		
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
		
		//标题
		$this->_data['page_title'] = '撰写行文章';
		
		//从数据库获取数据,显示在撰写新文章的页面:例如,所有分类,所有标签
		
		//从数据库取出所有分类
		$this->_data['all_categories'] = $this->metas_mdl->list_metas('category');
		
		//从数据库取出所有标签
		$this->_data['all_tags'] = $this->metas_mdl->list_metas('tag');
		
		//获取附件	unattached:未归档	$this->user->uid:作者id	100数量	0偏移量
		$this->_data['attachments'] = $this->posts_mdl->get_posts('attachment','unattached',$this->user->uid,100,0);
		
		$this->_data['allow_comment'] = 1;	//允许被评论;
		$this->_data['allow_ping'] = 1;		//允许被引用
		$this->_data['allow_feed'] = 1;		//允许被聚合
		
		//加载验证规则
		$this->_load_validation_rules();
		
		if($this->form_validation->run() === FALSE){
			
			//验证输入的日期
			$this->form_validation->month = date('n');
			$this->form_validation->day = date('j');
			$this->form_validation->year = date('Y');
			$this->form_validation->hour = date('G');
			$this->form_validation->minute = date('i');
			
			//加载撰写文章视图
			$this->load->view('admin/write_post',$this->_data);
			
		}else{
			//获取表单提交的数据
			//$cc = $this->_get_form_data();
			//$draft = $this->input->post('draft', TRUE);
			//print_r($cc);
			//print_r($draft);
			
			//插入数据库,添加文章
			$this->_insert_post();
			
		}
		
		
	}
	
	//获取表单数据
	private function _get_form_data(){
		return array(
			'title'			=> $this->input->post('title',TRUE),
			'text'			=> $this->input->post('text',TRUE),
			'allowComment'	=> $this->input->post('allowComment',TRUE),
			'allowPing'		=> $this->input->post('allowPing',TRUE),
			'allowFeed'		=> $this->input->post('allowFeed',TRUE),
			'tags'			=> $this->input->post('tags',TRUE),
			'trackback'		=> $this->input->post('trackback',TRUE),	//引用通告
			'attachment'	=> $this->input->post('attachment',TRUE),	//附件
			'category'		=> $this->input->post('category',TRUE),
			'slug'			=> $this->input->post('slug',TRUE) 	
		);
		
		
	}
	
	//添加一篇文章,插入数据库
	private function _insert_post(){
		//获取表单数据
		$content = $this->_get_form_data();
		//文章类型
		$content['type'] = 'post';
		//文章状态	如果点击的是保存那么提交的表单post('draft',TRUE)的值是1,不是点这个按钮的话,值是null
		$draft = $this->input->post('draft',TRUE);		//draft设置文章状态为草稿
		
		$content['status'] = $draft ? 'waiting':'publish';
		
		//获取创建时间
		$content['created'] = $this->_get_created();
		
		//文章排序,默认为0
		$content['order'] = 0;
		$content['commentsNum'] = 0;
		
		$insert_struct = array(

			'title'		=> empty($content['title']) ? NULL : $content['title'],
			'created'	=> empty($content['created']) ? now() : $content['created'],
			'modified'	=> now(),
			'text'		=> empty($content['text']) ? NULL : $content['text'],
			'order'		=> empty($content['order']) ? 0 : intval($content['order']),
			'authorId'	=> isset($content['authorId']) ? $content['authorId'] :$this->user->uid,
			'type'		=> empty($content['type']) ? 'post' : $content['type'],
			'status'	=> $content['status'],
			'commentsNum'=>empty($content['commentsNum']) ? 0 : $content['commentsNum'],
			'allowComment'=>!empty($content['allowComment']) && 1 == $content['allowComment'] ? 1:0,
			'allowPing'	=> !empty($content['allowPing']) && 1 == $content['allowPing']?1:0,
			'allowFeed'	=> !empty($content['allowFeed']) && 1 == $content['allowFeed']?1:0
			//备注:这里没有插入slug,slug单独的插入
				
		);
		
		//将文章写入数据库,如果插入成功,返回文章的pid,如果失败,返回FALSE
		$insert_id = $this->posts_mdl->add_post($insert_struct);
		
		//根据pid来插入slug缩略名
		$this->_apply_slug($insert_id);
		
		//如果文章写入数据库成功
		if($insert_id > 0){
			
			//给对应文章写入对应分类,这里的传入参数:插入文章的id,文章的类型,文章状态是否是publish
			$this->_set_categories($insert_id,$content['category'],false,'publish' == $content['status']);
			
			//设置标签
			$this->_set_tags($insert_id,empty($content['tags'])?NULL:$content['tags'],false,'publish'==$content['status']);
			
			//设置附件
			$this->_attachment_related($insert_id,$content['attachment']);
			
		}
		
		//trackback应用通告
		$trackback = array_unique(preg_split("/(\r|\n|\r\n)/", trim($content['trackback'])));
		if(!empty($trackback)){
			$this->_send_trackback($pid,$trackback);
		}
		
		if($content['status'] == 'draft'){
			$this->session->set_flashdata('success','草稿"'.$content['title'].'"已经保存');
			redirect('admin/posts/write'.'/'.$pid);
		}else{
			$this->session->set_flashdata('success','文章<b>'.$content['title'].'</b>修改成功');
			redirect('admin/posts/manage');
		}
		
		
		
		
		
	}
	
	//获取创建时间
	private function _get_created(){
		
		$create = now();
		
		$second = 0;
		$min = intval($this->input->post('min',TRUE));	
		$hour = intval($this->input->post('hour',TRUE));
		$year = intval($this->input->post('year',TRUE));
		$month = intval($this->input->post('month',TRUE));
		$day = intval($this->input->post('day',TRUE));
		
		return mktime($hour,$min,$second,$month,$day,$year);
		
	}
	
	//加载验证规则
	private function _load_validation_rules(){
		$this->form_validation->set_rules('title','标题','required|trim|htmlspecialchars');
		$this->form_validation->set_rules('text','内容','required|trim');
		$this->form_validation->set_rules('tags','标签','trim|htmlspecialchars');
		$this->form_validation->set_rules('category[]','分类','required|trim');
		$this->form_validation->set_rules('allowComment','允许评论','trim');
		$this->form_validation->set_rules('allowPing','允许被引用','trim');
		$this->form_validation->set_rules('allowFeed','允许聚合中出现','trim');
		$this->form_validation->set_rules('slug','缩略名','trim|alpha_dash|htmlspecialchars');
	}
	
	//为新建的内容应用slug缩略名,传入的参数:文章的id
	private function _apply_slug($pid){
		
		//得到表单提交的slug
		$slug = $this->input->post('slug',TRUE);
		
		//如果有提交的表单slug为空,那么设置为NULL
		$slug = (!empty($slug)) ? $slug : NULL;
		
	 	//对slug的格式进行处理,返回处理好的$slug
	 	$slug = Common::repair_slugName($slug,$pid);
	 	
	 	//根据pid来更新slug字段,get_slug_name()用来处理:如果slug与数据库记录中重复,那么给sulg加上数字
	 	$this->posts_mdl->update_post($pid,array('slug'=>$this->posts_mdl->get_slug_name($slug,$pid)));
	 	
		
	}
	
	//设置分类
	public function _set_categories($pid, $categories=array(), $before_count=true, $after_count=true){
		
		//array_map()是php方法,对传入的$categories参数,应用trim()方法,再返回结果,这个是对参数左右去掉空格
		//array_unique()是对里面的参数去掉重复的值
		$categories = array_unique(array_map('trim',$categories));
		
		//根据文章id取出meta
		$this->metas_mdl->get_metas($pid);
		
		//
		$exist_categories = Common::array_flatten($this->metas_mdl->metas['category'],'mid');
		
		if($exist_categories){
			
			foreach($exist_categories as $category){
				//删除关系
				$this->metas_mdl->remove_relationship_strict($pid,$category);
				
				if($before_count){
					//meta个数自减一
					$this->metas_mdl->meta_num_minus($category);
				}
				
			}
			
		}
		
		if($categories){
			
			foreach($categories as $category){
				
				//获取元数据
				if(!$this->metas_mdl->get_meta('BYID',$category)){
					continue;
				}
				
				//添加元数据/内容关系
				$this->metas_mdl->add_relationship(array('pid'=>$pid,'mid'=>$category));
				
				if($after_count){
					//meta个数自增一
					$this->metas_mdl->meta_num_plus($category);
				}
				
			}
			
		}
		
		
	}
	
	
	//设置内容的标签
	private function _set_tags($pid,$tags,$before_count=true,$after_count=true){
		
		$tags = str_replace(', ',',',$tags);
		$tags = array_unique(array_map('trim',explode(',',$tags)));
		
		//取出已有meta
		$this->metas_mdl->get_metas($pid);
		
		//取出已有tag
		$exist_tags = Common::array_flatten($this->metas_mdl->metas['tag'],'mid');
		
		if($exist_tags){
			
			foreach($exist_tags as $tag){
				$this->metas_mdl->remove_relationship_strict($pid,$tag);
				
				if($before_count){
					$this->metas_mdl->meta_num_minus($tag);
				}
				
			}
			
		}
		
		$insert_tags = $this->metas_mdl->scan_tags($tags);
		
		if($insert_tags){
			
			foreach($insert_tags as $tag){
				$this->metas_mdl->add_relationship(array('pid'=>$pid,'mid'=>$tag));
				
				if($after_count){
					$this->metas_mdl->meta_num_plus($tag);
				}
				
			}
			
		}
		
		
	}
	
	
	//关联附件
	private function _attachment_related($pid,$attachments=array()){
		if(empty($pid) || empty($attachments)){
			return;
		}
		foreach ($attachments as $attachment){
			$this->posts_mdl->update_post($attachment,array('order'=>$pid,'status'=>'attached'));
		}
	}
	
	
	/**
	 * 发送Ping
	 *
	 * @access private
	 * @param  string $pid
	 * @param  array  $trackbacks
	 * @return void
	 */
	private function _send_trackback($pid, $trackbacks = array())
	{
		if(empty($pid))
		{
			return;
		}
	
		$post = $this->posts_mdl->get_post_by_id('pid', $pid);
	
		$trackbacks = ($trackbacks) ? (is_array($trackbacks) ? $trackbacks : array($trackbacks)) : array();
	
		$this->load->library('trackback');
	
		foreach($trackbacks as $trackback)
		{
			if(empty($trackback))
			{
				continue;
			}
				
			$tb_data = array(
					'ping_url'  => $trackback,
					'url'       => site_url('posts/'. $post->slug),
					'title'     => $post->title,
					'excerpt'   => Common::get_excerpt($post->text),
					'blog_name' => setting_item('blog_title'),
					'charset'   => 'utf-8'
			);
			 
			if ( ! $this->trackback->send($tb_data))
			{
				log_message('error', $this->trackback->display_errors());
			}
		}
	}
	
	
	
	
	//管理文章
	public function manage($status = 'publish'){
		
		//设置标题
		$this->_data['page_title'] = '管理文章';
		
		//分页的query string
		$query = array();
		
		//从数据库中得到登录作者的uid
		$author_id = $this->user->uid;
		
		//如果具有编辑以上权限才能进入编辑管理
		if($this->auth->exceed('editor',TRUE)){
			//得到表单提交的作者名
			$author = $this->input->get('author',TRUE);
			
			if($author && is_numeric($author)){
				//得到作者用户信息
				$author_info = $this->users_mdl->get_user_by_id($author);
				
				if($author_info){
					//把表单提交的作者uid赋值给变量$author_id
					$author_id = $author;
					//把表单提交的作者uid赋值给数组
					$this->_data['author_id'] = $author;
					$this->_data['page_title'] = $author_info['screenName'].'的文章';
					//把作者存储到数组中
					$query[] = 'author='.$author;
					
				}
				//清空保存在$author_info的用户信息
				unset($author_info);
				
			}
			
			//设置是否查看全部文章
			$all_posts = $this->input->get('__all_posts',TRUE);
			
			if(!empty($all_posts)){
				
				if('on' == $all_posts){
					$this->session->set_userdata('__all_posts','on');
					
					$author_id = NULL;
					
				}else if('off' == $all_posts){
					$this->session->unset_userdata('__all_posts');
				}
				
			}else{
				if('on' == $this->session->userdata('__all_posts')){
					$author_id = NULL;
				}
			}
			
			//如果传入的参数$status不存在数组,那么自动跳转到文章管理页面
			if(!in_array($status,array('publish','draft','waiting'))){
				redirect('admin/posts/manage');
			}
			
			//分类过滤
			$category_filter = $this->input->get('category',TRUE);
			$category_filter = (!empty($category_filter)) ? intval($category_filter):0;

			//如果传入了文章类型过滤
			if(!empty($category_filter)){
				//把对应类型存储到数组中
				$query[] = 'category='.$category_filter;
			}
			
			//搜索标题输入的关键词(用来标题过滤)
			//trip_tags — 从字符串中去除 HTML 和 PHP 标记
			$title_filter = strip_tags($this->input->get('keywords',TRUE));
			if(!empty($title_filter)){
				$this->_data['page_title'] = '搜索文章:'.$title_filter;
				$query[] = 'keywords='.$title_filter;
			}
			
			//页码标记
			$page = $this->input->get('p',TRUE);
			$page = (!empty($page) && is_numeric($page)) ? intval($page) : 1;
			$limit = 10;
			$offset = ($page - 1) * $limit;
			
			if($offset < 0){
				redirect('admin/posts/manage');
			}
			
			//下面部分是没有传任何参数时,显示所有的文章
			//得到文章,默认:$status=publish;$author_id=$this->user->uid;$limit=10;$offset=0;$category_filter=0;
			$posts = $this->posts_mdl->get_posts('post',$status,$author_id,$limit,$offset,$category_filter,$title_filter);
			//计算文章数量
			$posts_count = $this->posts_mdl->get_posts('post',$status,$author_id,10000,0,$category_filter,$title_filter)->num_rows();
			
			if($posts){
				foreach($posts->result() as $post){
					$this->metas_mdl->get_metas($post->pid);
					$post->categories = $this->metas_mdl->metas['category'];
				}
				
				$pagination = '';
				
				if($posts_count > $limit){
					
					$this->dpagination->currentPage($page);			//当前是第几页
					$this->dpagination->items($posts_count);		//当前文章中暑
					$this->dpagination->limit($limit);				//每页文章数
					$this->dpagination->adjacents(5);				//总共的页数
					$this->dpagination->target(site_url('admin/posts/manage?'.implode('&',$query)));
					$this->dpagination->parameterName('p');			//页面的前缀,例如:p=2	如果换成psss,就是psss=2
					$this->dpagination->nextLabel('下一页');
					$this->dpagination->PrevLabel('上一页');
					
					$pagination = $this->dpagination->getOutput();
					
				}
				
				$this->_data['pagination'] = $pagination;
				
			}
			
			$this->_data['status'] = $status;
			$this->_data['parentPage'] = 'manage-posts';
			$this->_data['currentPage'] = 'manage-posts';
			$this->_data['posts'] = $posts;
			$this->_data['categories'] = $this->metas_mdl->list_metas('category');
			
			$this->load->view('admin/manage_posts',$this->_data);
			
			
		}
		
		
	}
	
	/**
     * 修改一个日志（与用户交互）
     *
     * @access private
     * @return void
     */
	private function _edit($pid)
	{
		//根据唯一键获取单个内容信息,返回文章信息
		$post_db = $this->posts_mdl->get_post_by_id('pid', $pid);
		
		
		if(empty($post_db))
		{
			show_error('发生错误：文章不存在或已被删除。');
			exit();
		}
		
		//权限要至少为edit,并且只能修改自己的文章
		if($this->user->group == 'contributor' && $this->user->uid != $post_db->authorId)
		{
			show_error('权限错误：你仅能修改自己的文章。');
			exit();
		}
		
		//根据post id获取分类数据,存储在metas_mdl的变量$metas中
		$this->metas_mdl->get_metas($pid);
		//得到文章的分类
		$pop_categories = Common::array_flatten($this->metas_mdl->metas['category'], 'mid');
		//得到文章的标签
		$pop_tags = Common::format_metas($this->metas_mdl->metas['tag'], ',' , FALSE);
		
		
		$this->_data['parentPage'] = 'post';
		$this->_data['currentPage'] = 'post';
		$this->_data['page_title'] = '编辑文章：'.$post_db->title;
		$this->_data['all_categories'] = $this->metas_mdl->list_metas('category');	//列出所有分类
		$this->_data['all_tags'] = $this->metas_mdl->list_metas('tag');		//列出所有标签
		$this->_data['pid'] = $pid;		
		$this->_data['title'] = $post_db->title;
		$this->_data['text'] = $post_db->text;
		$this->_data['post_category'] = $pop_categories;		//文章的分类
		$this->_data['created'] = $post_db->created;
		$this->_data['slug'] = $post_db->slug;
		$this->_data['tags'] = $pop_tags;						//文章的标签
		$this->_data['attachments'] = $this->posts_mdl->get_posts('attachment','unattached',$this->user->uid,100,0);		//附件
		$this->_data['allow_comment'] = $post_db->allowComment;
		$this->_data['allow_ping'] = $post_db->allowPing;
		$this->_data['allow_feed'] = $post_db->allowFeed;
		
		
		
		$this->_load_validation_rules();
		$this->form_validation->month = date('n', $post_db->created);
		$this->form_validation->day = date('j',$post_db->created);
		$this->form_validation->year = date('Y', $post_db->created);
		$this->form_validation->hour = date('G', $post_db->created);
		$this->form_validation->minute = date('i', $post_db->created);
		
		
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('admin/write_post',$this->_data);
		}
		else
		{
			//更新文章
			$this->_update_post($pid, $post_db);	
		}
	}

	/**
     * 修改一个日志（与数据库交互）
     *
     * @access private
     * @return void
     */
	private function _update_post($pid, $exist_post)
	{
		/** 获取表单数据 */
		$content = $this->_get_form_data();
		/** 文章类型 */
		$content['type'] = 'post';
		/** 文章状态 */
		$draft = $this->input->post('draft', TRUE);
		$content['status'] = $draft ? 'draft' : (($this->auth->exceed('editor', TRUE) && !$draft) ? 'publish' : 'waiting');
		/** 处理相关时间 */
		$content['created'] = $this->_get_created();

		
		$update_struct = array(
            'title'         =>  empty($content['title']) ? NULL : $content['title'],
            'created'       =>  empty($content['created']) ? now() : $content['created'],
            'modified'      =>  now(),
            'text'          =>  empty($content['text']) ? NULL : $content['text'],
            'order'         =>  empty($content['order']) ? 0 : intval($content['order']),
            'authorId'      =>  isset($content['authorId']) ? $content['authorId'] : $this->user->uid,
            'type'          =>  empty($content['type']) ? 'post' : $content['type'],
            'status'        =>  empty($content['status']) ? 'publish' : $content['status'],
            'allowComment'  =>  !empty($content['allowComment']) && 1 == $content['allowComment'] ? 1 : 0,
            'allowPing'     =>  !empty($content['allowPing']) && 1 == $content['allowPing'] ? 1 : 0,
            'allowFeed'     =>  !empty($content['allowFeed']) && 1 == $content['allowFeed'] ? 1 : 0
        );
        
        /** 核心数据进主库 */
		$updated_rows = $this->posts_mdl->update_post($pid, $update_struct);
			
		/** 应用缩略名 */
		$this->_apply_slug($pid);

		if($updated_rows >0)
		{
			/** 插入分类 */
            $this->_set_categories($pid, $content['category'], 'publish' == $exist_post->status, 'publish' == $content['status']);
            
            /** 插入标签 */
            $this->_set_tags($pid, empty($content['tags']) ? NULL : $content['tags'], 'publish' == $exist_post->status, 'publish' == $content['status']);
            
            /** 同步附件 */
            $this->_attachment_related($pid, $content['attachment']);
		}
		
		/** 发送trackback */
		$trackback = array_unique(preg_split("/(\r|\n|\r\n)/", trim($content['trackback'])));
		if(!empty($trackback))
		{
			$this->_send_trackback($pid, $trackback);	
		}
				
		if($content['status'] == 'draft')
		{
			$this->session->set_flashdata('success', '草稿"'.$content['title'].'"已经保存');
			redirect('admin/posts/write'.'/'.$pid);
		}
		else
		{
			$this->session->set_flashdata('success', '文章 <b>'.$content['title'].'</b> 修改成功');
			redirect('admin/posts/manage');
		}
	}

	
}

/*
End of file
Location:posts.php
*/