<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
2015年2月8日PHP
*/
//常用公共类
class Common{
	
	//判断密码是否相等
	public static function hash_Validate($source,$target){
		return (self::do_hash($source,$target) == $target);
	}
	
	//对字符串进行hash加密
	public static function do_hash($string,$salt = NULL){	
		//如果$salt参数为空,那么随机产生一个数字,md5加密,在截取1到10位数
		if (null == $salt){
			//参数定义constants.php	define('ST_SALT_LENGTH', 9);
			$salt = substr(md5(uniqid(rand(),true)),0,ST_SALT_LENGTH);
		}
		//如果$salt不为空,那么直接截取1到10位数
		else{
			$salt = substr($salt,0,ST_SALT_LENGTH);
		}
		return $salt.sha1($salt.$string);
		
	}
	
	
}

/*
End of file
Location:Common.php
*/