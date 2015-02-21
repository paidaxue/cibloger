<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$this->load->view('header');
?>

<div id="main">
	
	<?php $this->load->view('posts'); ?>
	
</div>

<?php $this->load->view('sidebar');?>

<?php $this->load->view('footer'); ?>
