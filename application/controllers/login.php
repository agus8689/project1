<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	
	function cek_login(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		if(isset($_POST['username'],$_POST['password'])){
			$username=$_POST['username'];
			$password=$_POST['password'];
			$query=$this->m_login->cek_username_pass($username,$password);
			if($query->num_rows() != 0){
				foreach($query->result_array() as $data){
					$sess_data['username']=$data['username'];
					$sess_data['password']=$data['password'];
					$sess_data['posisi']=$data['posisi'];
					$this->session->set_userdata($sess_data);
				}
				$posisi=$this->session->userdata('posisi');
				if($posisi == "manajemen"){
					redirect('stock_monitoring/report');
				}elseif($posisi == "receiving"){
					redirect('scan/viewscanreceiving');
				}elseif($posisi == "shipping"){
					redirect('scan/viewscanshipping');
				}elseif($posisi == "monitor"){
					redirect('stock_monitoring/dashboard');
				}elseif($posisi == "it"){
					redirect('stock_monitoring/dashboard1');
				}
			}else{
				$this->session->set_flashdata('pesan', 'Username/Password Salah!');
				redirect('login/home');
			}
		}else{
			$username="";
			$password="";
			$query=$this->m_login->cek_username_pass($username,$password);
			if($query->num_rows() != 0){
				foreach($query->result_array() as $data){
					$sess_data['username']="";
					$sess_data['password']="";
					$sess_data['posisi']="";
					$this->session->set_userdata($sess_data);
				}
			}
		}
	}
	
	public function home(){
		$username="";
		$password="";
		$this->template->load('templates', 'home');
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('login/home');
	}
}