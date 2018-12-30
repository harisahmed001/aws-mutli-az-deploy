<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		
		$data['error'] = '';
		$data['user'] = '';
		$data['instanceID'] = file_get_contents("http://169.254.169.254/latest/meta-data/instance-id");

		if($_POST){
			$query = $this->db->query('select * from users where username="'.$_POST['username'].'" and password=md5("'.$_POST['password'].'")');
			if($query->num_rows() > 0){
				$user = $query->row();
				$this->session->set_userdata('user', $user);
			}else{
				$data['error'] = 'no user is there';
			}
		}

		if($this->session->userdata('user')){
			$data['user'] = 'Name: '.$this->session->userdata('user')->name.' and username '.$this->session->userdata('user')->username.' is logined<br><a href="'.base_url('test/logout').'">Logout</a>';
		}



		$this->load->view('test', $data);
	}


	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
