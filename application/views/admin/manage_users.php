<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>
<?php echo anchor(site_url('admin/users/user'),'新增用户',array('class'=>'button'));?>
<table>
	<thead>
		<th>用户名</th>
		<th>昵称</th>
		<th>邮箱Email</th>
		<th>用户组</th>
		<th>操作</th>
	</thead>
	
	<tbody>
		<?php foreach($users->result() as $user): ?>
		<tr>
		<td><?php echo anchor('admin/users/user/'.$user->uid,$user->name); ?></td>
		<td><?php echo $user->screenName;?></td>
		<td><?php echo $user->mail ?></td>
		<td><?php switch($user->group ){
			case 'administrator':
				echo '管理员';
				break;
			case 'editor':
				echo '编辑';
				break;
			case 'contributor':
				echo '作者';
				break;			
		}		
		?></td>
		<td><?php echo anchor(site_url('admin/users/remove/'.$user->uid),'删除用户',array('class'=>'button'));?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	
</table>