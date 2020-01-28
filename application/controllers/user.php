<?php
class user extends CI_controller{	
	public $model = NULL;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('model_transaksi');
		$this->model =$this->user_model;
		$this->load->library('datatables');
	}
	
	public function index(){
		$this->read();
	}
	
	//get all data user by JSON object
	function get_guest_json() {
		header('Content-Type: application/json');
		echo $this->user_model->get_all_user();
	}
	
	//get data user by id
	function get_user(){
		$id=$this->input->get('id_user');
		$data=$this->user_model->get_data_by_id($id);
		echo json_encode($data);
	}
	
	//function save user
	function save_user(){
		$data=array(
			'id_user'		=> $this->input->post('id_user'),
			'posisi'		=> $this->input->post('posisi'),
			'username'		=> $this->input->post('username'),
			'password'		=> $this->input->post('password')
		);
		$this->db->insert('user_login',$data);
		$this->session->set_flashdata
		('msg','<div class="alert bg-green alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Diinputkan
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1', 'user_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	//function edit user
	function edit_user(){
		$id=$this->input->post('id_user_edit');
		$data=array(
			'posisi'		=> $this->input->post('posisi_edit'),
			'username'		=> $this->input->post('username_edit'),
			'password'		=> $this->input->post('password_edit')
		);
		$this->db->where('id_user',$id);
		$this->db->update('user_login',$data);
		$this->session->set_flashdata
		('msg','<div class="alert bg-blue alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Diperbarui
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1', 'user_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	//function delete barcode
	function delete_user(){
		$id=$this->input->post('id');
		$this->db->where('id_user',$id);
		$this->db->delete('user_login');
		$this->session->set_flashdata
		('msg','<div class="alert bg-orange alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Dihapus
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1', 'user_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	public function create() {
		$username=$this->session->userdata['username'];
		$this->form_validation->set_rules('id_user', 'id_user', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('posisi', 'posisi', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('username', 'username', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('password', 'password', 'trim|required|alpha_numeric');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><li>','</li></div>');
		
		if($this->form_validation->run() != false) {
			
			if (isset($_POST['btnSubmit'])) {
				$this->model->id_user=$_POST['id_user'];
				$this->model->posisi=$_POST['posisi'];
				$this->model->username=$_POST['username'];
				$this->model->password=$_POST['password'];
				$this->model->insert();
				echo "FORM VALIDATION OKE";
				redirect('user/master');
			}else{
				$this->template->load('template1', 'user_create_view',['model'=>$this->model,'username'=>$username]);
			}
			
		}else{
			$this->template->load('template1', 'user_create_view',['model'=>$this->model,'username'=>$username]);
		}
	}
	
	public function read() {
		$rows=$this->model->read();
		$this->template->load('template1', 'user_read_view',['rows'=>$rows]);
	}
	
	public function master() {
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1', 'user_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	public function update($id){
		$username=$this->session->userdata['username'];
		//if($this->form_validation->run() != false) {
		if (isset($_POST['btnSubmit'])) {
			$id_user=$_POST['id_user'];
			$posisi=$_POST['posisi'];
			$username=$_POST['username'];
			$password=$_POST['password'];
			$this->model_transaksi->custom_query("UPDATE user_login set posisi='$posisi', username='$username', password='$password' where id_user='$id_user'");
			redirect('user/master');
		}else{
			$query= $this->db->query("SELECT * FROM user_login WHERE id_user='$id'");
			$row=$query->row();
			$this->model->id_user=$row->id_user;
			$this->model->posisi=$row->posisi;
			$this->model->username=$row->username;
			$this->model->password=$row->password;
			$this->template->load('template1', 'user_update_view',['model'=>$this->model,'username'=>$username]);
		}
	}
	
	public function delete($id) {
		$this->model->id_user=$id;
		$this->model->delete();
		redirect('user/master');

	}
}