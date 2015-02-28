<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('admin/header');
$this->load->view('admin/menu');
?>
<div class="container">
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

          <h2 class="sub-header">用户操作:</h2><h4><?php echo anchor(site_url('admin/users/user'),'新增用户',array('class'=>'button'));?></h4>
          <div class="table-responsive">
	          <table class="table table-striped table-bordered table-hover">
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
        </div>
</div>
</div>
<?php echo $this->load->view('admin/footer');?>