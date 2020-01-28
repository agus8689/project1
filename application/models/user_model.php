<?php
class user_model extends CI_model{
	//array untuk menyimpan label dari masing-masing atribut
	public $labels=[];
	
	public function __construct(){
		parent::__construct();
		$this->labels=$this->_attributelabels();
		$this->load->database();	
	}
	
	//create datatable
	function get_all_user() {
		$this->datatables->select('id_user,posisi,username,password');
		$this->datatables->from('user_login');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-sm" data-id="$1">Edit</a> <a href="javascript:void(0);" class="hapus_record btn btn-warning btn-sm" data-id="$1">Delete</a>','id_user');
		return $this->datatables->generate();
	}
	
	//get id
	function get_data_by_id($id){
		$hsl=$this->db->query("SELECT * FROM user_login WHERE id_user='$id'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'id_user' 			=> $data->id_user,
					'username' 			=> $data->username,
					'password' 			=> $data->password
				);
			}
		}
		return $hasil;
	}
	
	public function insert(){
		$sql=sprintf("INSERT INTO user_login VALUES('%s','%s','%s','%s')",
			$this->id_user,
			$this->posisi,
			$this->username,
			$this->password
		);
		$this->db->query($sql);
	}
	
	
	public function delete(){
		$sql=sprintf("DELETE FROM user_login WHERE id_user ='%s'",
			$this->id_user
		);
		$this->db->query($sql);
	}
	
	public function read(){
		$sql="SELECT * FROM user_login ORDER BY id_user";
		$query=$this->db->query($sql);
		return $query->result();
	}
	
	//metode untuk menentukan label dari masing-masing atribut 
	public function _attributelabels(){
		return [
			'id_user'=>'ID User',
			'posisi'=>'Posisi',
			'username'=>'User Name',
			'password'=>'Password',
		];	
	}
	
}