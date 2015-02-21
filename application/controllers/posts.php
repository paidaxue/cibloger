<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
2015年2月15日PHP
*/

//控制文章的前端显示
class Posts extends ST_Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	function index($slug = ''){
		
		//如果参数为空,那么跳转到首页
		if(empty($slug)){
			redirect(site_url());
		}
		
		//根据唯一键slug获取文章内容
		$post = $this->posts_mdl->get_post_by_id('slug',$slug);
		
		if(!$post){
			show_404();
		}
		
		//内容显示格式处理
		$post = $this->_prepare_post($post);
		
		/** 是否存在评论? */
		$comments = $this->comments_mdl->get_cmts($post->pid, '', 'approved', 0, 0, 'ASC');
		
		/** 评论显示格式化 */
		if($comments->num_rows() >0)
		{
			$comments = $this->_prepare_comments($post, $comments);
		}
		
		/** 页面初始化 */
		$data['page_title'] = $post->title;
		$data['page_description'] = Common::subStr(strip_tags($post->content), 0, 100, '...');
		$data['page_keywords'] = Common::format_metas($post->tags, ',', FALSE);
		$data['parsed_feed'] = Common::render_feed_meta('post', $post->slug, $post->title);
		$data['post'] = $post;
		$data['comments'] = $comments;
		
		$this->load->view('post', $data);
		
	}
	
	/**
	 * 内容格式化
	 *
	 * @access private
	 * @param  stdClass $post
	 * @return stdClass
	 */
	private function _prepare_post($post)
	{
		/** 日志发表日期 */
		$post->published = setting_item('post_date_format')
		? date(setting_item('post_date_format'), $post->created)
		: date('Y-m-d', $post->created);
	
		$post->modified = setting_item('post_date_format')
		? date(setting_item('post_date_format'), $post->modified)
		: date('Y-m-d', $post->modified);
	
		$this->metas_mdl->get_metas($post->pid);
		/** 日志分类 */
		$post->categories = $this->metas_mdl->metas['category'];
		/** 日志标签 */
		$post->tags = $this->metas_mdl->metas['tag'];
	
		$post->content = Common::get_content($post->text);
	
		$post->comment_allowed = (0 == $post->allowComment || Common::auto_closed($post->created, now())) ? FALSE : TRUE;
	
		$post->ping_allowed = (1 == $post->allowPing) ? TRUE : FALSE;
	
		$post->comment_post_url = site_url('comment/' . $post->pid);
	
		unset($post->text);
	
		return $post;
	}
	
	/**
	 * 评论格式化
	 *
	 * @access private
	 * @param  stdClass $post
	 * @param  array $comments
	 * @return array
	 */
	private function _prepare_comments($post, $comments)
	{
		foreach($comments->result() as $comment)
		{
			$comment->published = setting_item('comments_date_format')
			? date(setting_item('comments_date_format'), $comment->created)
			: date('Y-m-d', $comment->created);
	
			$comment->permalink = site_url('posts/'. $post->slug . '#comment-' . $comment->cid);
				
			$comment->author_link = $comment->author;
				
			if(!empty($comment->url))
			{
				$nofollow = array();
	
				if('1' == setting_item('comments_url_no_follow'))
				{
					$nofollow = array('rel' => 'external nofollow');
				}
	
				$comment->author_link = anchor($comment->url, $comment->author, $nofollow);
			}
				
			if('trackback' == $comment->type)
			{
				$text = unserialize($comment->text);
	
				$comment->author_link = '来自' . $comment->author_link .'在文章'. anchor($comment->url, $text['title']) .'中的引用';
				$comment->text = $text['excerpt'];
			}
	
			$comment->content = Common::cut_paragraph($comment->text);
				
			unset($comment->text);
		}
	
		return $comments;
	}
	
	
}

/*
End of file
Location:posts.php
*/