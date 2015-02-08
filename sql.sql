--
-- 表的结构 `users`用户表
--保存用户的信息，包括用户名，密码，电子邮件，用户组等信息；
--

CREATE TABLE `users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户PK',
  `name` varchar(32) NOT NULL COMMENT '用户名称',
  `password` varchar(49) DEFAULT NULL COMMENT '用户密码',
  `mail` varchar(200) NOT NULL COMMENT '用户邮箱',
  `url` varchar(200) DEFAULT NULL COMMENT '用户主页',
  `screenName` varchar(32) DEFAULT NULL COMMENT '用户的显示名称',
  `created` int(10) unsigned NOT NULL COMMENT '用户的注册时间',
  `activated` int(10) unsigned NOT NULL COMMENT '最后活跃时间',
  `logged` int(10) unsigned NOT NULL COMMENT '上次登陆最后活跃时间',
  `group` varchar(16) NOT NULL COMMENT '用户所在组',
  `token` varchar(40) DEFAULT NULL COMMENT '令牌',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`,`mail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' ;

--
-- 转存表中的数据 `users`	密码:STBLOG
--

INSERT INTO `users` VALUES(1, 'admin', 'b5151557ed3f279bc20627b4f5c30c82c1678518adc9be976', 'huyanggang@gmail.com', 'http://www.cnsaturn.com/', 'admin', 1111, 1268550988, 1268550964, 'administrator', 'fd0c6074d67e1ce3b7418aac9462084a63ec53bd');


--
-- 表的结构 `posts`文章表
--最主要的一张表，用于保存文章，包括文章标题，内容，创作时间等；
--

CREATE TABLE `posts` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'post表主键',
  `title` varchar(200) DEFAULT NULL COMMENT '内容标题',
  `slug` varchar(200) DEFAULT NULL COMMENT '内容缩略名',
  `created` int(10) unsigned DEFAULT '0' COMMENT '内容生成时的GMT unix时间戳',
  `modified` int(10) unsigned DEFAULT '0' COMMENT '内容更改时的GMT unix时间戳',
  `text` text COMMENT '内容文字',
  `order` int(10) unsigned DEFAULT '0',
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '内容所属用户id',
  `template` varchar(32) DEFAULT NULL COMMENT '内容使用的模板',
  `type` varchar(16) DEFAULT 'post' COMMENT '内容类别',
  `status` varchar(16) DEFAULT 'publish' COMMENT '内容状态',
  `commentsNum` int(10) unsigned DEFAULT '0' COMMENT '内容所属评论数,冗余字段',
  `allowComment` char(1) DEFAULT '0' COMMENT '是否允许评论',
  `allowPing` char(1) DEFAULT '0' COMMENT '是否允许ping',
  `allowFeed` char(1) DEFAULT '0' COMMENT '允许出现在聚合中',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created` (`created`),
  KEY `authorId` (`authorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` VALUES(1, '欢迎使用stblog博客', 'start', 1268550720, 1268550824, '如果你看到这篇文章，说明你的stblog已经安装和配置成功了!\n\n这是一篇测试日志，你可以进入后台删除\n\nStblog的历史从今天开始', 0, 1, NULL, 'post', 'publish', 1, '1', '1', '1');

-- --------------------------------------------------------



--
-- 表的结构 `comments`评论表
--评论使得博客更易于交流，用于保存评论，包括评论者的姓名，电子邮件，内容，评论时间等；
--

CREATE TABLE `comments` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'comment表主键',
  `pid` int(10) unsigned DEFAULT '0' COMMENT 'post表主键,关联字段',
  `created` int(10) unsigned DEFAULT '0' COMMENT '评论生成时的GMT unix时间戳',
  `author` varchar(200) DEFAULT NULL COMMENT '评论作者',
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '评论所属用户id',
  `ownerId` int(10) unsigned DEFAULT '0' COMMENT '评论所属内容作者id',
  `mail` varchar(200) DEFAULT NULL COMMENT '评论者邮件',
  `url` varchar(200) DEFAULT NULL COMMENT '评论者网址',
  `ip` varchar(64) DEFAULT NULL COMMENT '评论者ip地址',
  `agent` varchar(200) DEFAULT NULL COMMENT '评论者客户端',
  `text` text COMMENT '评论文字',
  `type` varchar(16) DEFAULT 'comment' COMMENT '评论类型',
  `status` varchar(16) DEFAULT 'approved' COMMENT '评论状态',
  `parent` int(10) unsigned DEFAULT '0' COMMENT '父级评论',
  PRIMARY KEY (`cid`),
  KEY `cid` (`pid`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `comments`
--

INSERT INTO `comments` VALUES(1, 1, 1268550856, 'Tester', 0, 1, 'tester@tester.com', 'http://www.tester.com', '0.0.0.0', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; zh-CN; rv:1.9.2) Gecko/20100115 Firefox/3.6', '测试留言～', 'comment', 'approved', 0);

-- --------------------------------------------------------


-- 表的结构 `metas`项目表
-- 用于保存文章的分类和标签，包括项目名，描述以及类别(category/tag)等；
--

CREATE TABLE `metas` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目主键',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `slug` varchar(200) DEFAULT NULL COMMENT '项目缩略名',
  `type` varchar(32) NOT NULL COMMENT '项目类型',
  `description` varchar(200) DEFAULT NULL COMMENT '选项描述',
  `count` int(10) unsigned DEFAULT '0' COMMENT '项目所属内容个数',
  `order` int(10) unsigned DEFAULT '0' COMMENT '项目排序',
  PRIMARY KEY (`mid`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `metas`
--

INSERT INTO `metas` VALUES(1, '测试分类', 'test', 'category', '这里是分类描述，其内容会出现在分类查看页的meta标签中，有利于seo', 1, 0);


--
-- 表的结构 `relationships`项目映射表
-- 用于保存项目和文章之间的映射关系，包括文章ID以及项目ID；
--

CREATE TABLE `relationships` (
  `pid` int(10) unsigned NOT NULL COMMENT '内容主键',
  `mid` int(10) unsigned NOT NULL COMMENT '项目主键',
  PRIMARY KEY (`pid`,`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `relationships`
--

INSERT INTO `relationships` VALUES(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0' COMMENT '唯一的用户Session ID',
  `ip_address` varchar(16) NOT NULL DEFAULT '0' COMMENT '用户的 IP 地址',
  `user_agent` varchar(50) NOT NULL  COMMENT '用户浏览器信息（取前120个字符)',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0'  COMMENT '最新的一个活跃时间戳',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ci_sessions`
--

INSERT INTO `ci_sessions` VALUES('ecce7f70ea1f16d29f7076f17dde27b2', '0.0.0.0', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; zh', 1268550940, 'a:1:{s:4:"user";s:409:"a:11:{s:3:"uid";s:1:"1";s:4:"name";s:5:"admin";s:8:"password";s:49:"b5151557ed3f279bc20627b4f5c30c82c1678518adc9be976";s:4:"mail";s:20:"huyanggang@gmail.com";s:3:"url";s:24:"http://www.cnsaturn.com/";s:10:"screenName";s:5:"admin";s:7:"created";s:4:"1111";s:9:"activated";s:10:"1268550478";s:6:"logged";i:1268550964;s:5:"group";s:13:"administrator";s:5:"token";s:40:"fd0c6074d67e1ce3b7418aac9462084a63ec53bd";}";}');

-- --------------------------------------------------------


--
-- 表的结构 `settings`设置表
-- 保存博客的一些设置，如博客的名称，描述等其他一些个性化设置；
--

CREATE TABLE `settings` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '设置名称',
  `value` text NOT NULL COMMENT '设置值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='设置表' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `settings`
--

INSERT INTO `settings` VALUES(1, 'blog_title', '我的个人博客');
INSERT INTO `settings` VALUES(2, 'blog_slogan', 'php.linux学习笔记,日记');
INSERT INTO `settings` VALUES(3, 'blog_description', '博客描述:主要用来写平时的笔记,知识积累');
INSERT INTO `settings` VALUES(4, 'cache_enabled', '0');
INSERT INTO `settings` VALUES(5, 'current_theme', 'default');
INSERT INTO `settings` VALUES(6, 'blog_status', 'on');
INSERT INTO `settings` VALUES(7, 'offline_reason', '稍后公布');
INSERT INTO `settings` VALUES(8, 'blog_keywords', 'cyangbo,个人博客基于ci框架,php个人博客');
INSERT INTO `settings` VALUES(9, 'upload_dir', 'uploads/');
INSERT INTO `settings` VALUES(10, 'upload_exts', '*.zip;*.tar.gz;*.rar;*.jpg;*.gif;*.png;*.jpeg;*.bmp;*.tiff');
INSERT INTO `settings` VALUES(11, 'comments_date_format', 'F j, Y, g:i a');
INSERT INTO `settings` VALUES(12, 'comments_list_size', '10');
INSERT INTO `settings` VALUES(13, 'comments_url_no_follow', '1');
INSERT INTO `settings` VALUES(14, 'comments_require_moderation', '0');
INSERT INTO `settings` VALUES(15, 'comments_auto_close', '0');
INSERT INTO `settings` VALUES(16, 'comments_require_mail', '1');
INSERT INTO `settings` VALUES(17, 'comments_require_url', '0');
INSERT INTO `settings` VALUES(18, 'comments_allowed_html', '');
INSERT INTO `settings` VALUES(19, 'post_date_format', 'F j, Y, g:i a');
INSERT INTO `settings` VALUES(20, 'posts_page_size', '10');
INSERT INTO `settings` VALUES(21, 'posts_list_size', '10');
INSERT INTO `settings` VALUES(22, 'feed_full_text', '1');
INSERT INTO `settings` VALUES(23, 'cache_expire_time', '30');
INSERT INTO `settings` VALUES(26, 'active_plugins', 'a:6:{i:0;a:8:{s:9:"directory";s:12:"recent_posts";s:4:"name";s:18:"最新日志Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:24:"显示博客最新日志";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:1;a:8:{s:9:"directory";s:10:"navigation";s:4:"name";s:15:"导航拦Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:42:"根据创建的页面自动生成导航栏";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:3;a:8:{s:9:"directory";s:15:"recent_comments";s:4:"name";s:18:"最新评论Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:24:"显示博客最新评论";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:4;a:8:{s:9:"directory";s:10:"categories";s:4:"name";s:18:"分类列表Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:27:"显示博客的分类列表";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:5;a:8:{s:9:"directory";s:7:"archive";s:4:"name";s:24:"日志归档列表Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:30:"显示日志按月归档列表";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:6;a:8:{s:9:"directory";s:13:"related_posts";s:4:"name";s:18:"相关日志Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:33:"显示某篇日志的相关日志";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}}');
INSERT INTO `settings` VALUES(27, 'cache_file_limit', '200');

-- --------------------------------------------------------