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
	
	//对slug格式处理	
	/**
	 * 
	 * @param unknown $str	传入的需要处理的slug
	 * @param string $default	默认的缩略名
	 * @param number $marLength	缩略名最大长度
	 * @param string $charset	字符编码
	 */
	public static function repair_slugName($str,$default=NULL,$marLength=200,$charset='UTF-8'){
		
		//替换特殊字符
		$str = str_replace(array("'",":","\\","/"),"",$str);
		$str = str_replace(array("+", ",", " ", ".", "?", "=", "&", "!", "<", ">", "(", ")", "[", "]", "{", "}"), "_", $str);
		//过滤两头空格
		$str = empty($str) ? $default : $str;
	    
	    return function_exists('mb_get_info') ? mb_strimwidth($str, 0, 128, '', $charset) : substr($str, $maxLength);
	}
	
	
	/**
	 * 抽取多维数组的某个元素,组成一个新数组,使这个数组变成一个扁平数组
	 * 使用方法:
	 * <code>
	 * <?php
	 * $fruit = array(array('apple' => 2, 'banana' => 3), array('apple' => 10, 'banana' => 12));
	 * $banana = Common::arrayFlatten($fruit, 'banana');
	 * print_r($banana);
	 * //outputs: array(0 => 3, 1 => 12);
	 * ?>
	 * </code>
	 *
	 * @access public
	 * @param array $value 被处理的数组
	 * @param string $key 需要抽取的键值
	 * @return array
	 */
	//当创建文章中,传入的参数:$this->metas_mdl->metas['category'],'mid'
	public static function array_flatten($value = array(), $key)
	{
		$result = array();
	
		if($value)
		{
			foreach ($value as $inval)
			{
				if(is_array($inval) && isset($inval[$key]))
				{
					$result[] = $inval[$key];
				}
				else
				{
					break;
				}
			}
		}
	
		return $result;
	}
	
}

/*
End of file
Location:Common.php
*/