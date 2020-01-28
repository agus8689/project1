<?php
class sm_model extends CI_model{
	public $original_barcode;
	public $barcode_receiving;
	public $barcode_shipping;
	public $brand;
	public $color;
	public $size;
	public $four_digit;
	public $unit;
	public $quantity;
	public $customer;
	public $cust_model;
	public $model_code;
	public $tooling_code;
	public $date_time;
	public $stock;
	public $no;
	
	//array untuk menyimpan label dari masing-masing atribut
	public $labels=[];
	
	public function __construct(){
		parent::__construct();
		$this->labels=$this->_attributelabels();
		$this->load->database();	
	}
	
	public function insert(){
		$sql=sprintf("INSERT INTO master_database VALUES('%s','%s','%s','%s','%s','%s',%d,'%s','%s','%s','%s','%s')",
			$this->original_barcode,
			$this->brand,
			$this->color,
			$this->size,
			$this->four_digit,
			$this->unit,
			$this->quantity,
			$this->customer,
			$this->cust_model,
			$this->model_code,
			$this->tooling_code,
			$this->stock
		);
		$this->db->query($sql);
	}
	
	public function insertr(){
		$sql=sprintf("INSERT INTO data_receiving SELECT * FROM receiving WHERE date_time < '%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function trunr(){
		$sql=sprintf("DELETE FROM receiving WHERE date_time < '%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function inserts(){
		$sql=sprintf("INSERT INTO data_shipping SELECT * FROM shipping WHERE date_time < '%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function truns(){
		$sql=sprintf("DELETE FROM shipping WHERE date_time < '%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function update(){
		
	}
	
	public function delete(){
		$sql=sprintf("DELETE FROM master_database WHERE original_barcode ='%s'",
			$this->original_barcode
		);
		$this->db->query($sql);
	}
	
	public function delete2(){
		$sql=sprintf("DELETE FROM receiving WHERE date_time ='%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function delete3(){
		$sql=sprintf("DELETE FROM shipping WHERE date_time ='%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function delete4(){
		$sql=sprintf("DELETE FROM data_receiving WHERE date_time ='%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function delete5(){
		$sql=sprintf("DELETE FROM data_shipping WHERE date_time ='%s'",
			$this->date_time
		);
		$this->db->query($sql);
	}
	
	public function delete6(){
		$sql=sprintf("DELETE FROM stok WHERE no ='%s'",
			$this->no
		);
		$this->db->query($sql);
	}
	
	public function read(){
		$sql="SELECT * FROM master_database ORDER BY original_barcode";
		$query=$this->db->query($sql);
		return $query->result();
	}
	
	//metode untuk menentukan label dari masing-masing atribut 
	public function Getreportreceive($tanggal,$bulan,$tahun){
		$this->db->select('customer, brand, model, color, size, quantity, scan_no');
		$this->db->from('receiving');
		$this->db->where('id_pemasukan', $id);
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function Getkolor(){
		$this->db->select('original_barcode,color');
		$this->db->from('master_database');
		$this->db->group_by('color');
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function Getsize(){
		$this->db->select('original_barcode,size');
		$this->db->from('master_database');
		$this->db->group_by('size');
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function Getmodel(){
		$this->db->select('original_barcode,cust_model,model_code');
		$this->db->from('master_database');
		$this->db->group_by('model_code');
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function Getuser(){
		$this->db->select('id_user,posisi,username,password');
		$this->db->from('user_login');
		$this->db->group_by('id_user');
		$query=$this->db->get();
		return $query->result_array();
	}
	
	public function Getdataquantity($model,$size,$color){
		$this->db->where_in('cust_model', $model);
		$this->db->where_in('size', $size);
		$this->db->where_in('color', $color);
		$this->db->select_sum('quantity');
		$qty=$this->db->get('receiving')->row()->quantity;
	}
	
	public function Gettime(){
		$this->db->select('id,hour,value');
		$this->db->from('time');
		$this->db->order_by('id','ASC');
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function Getbarcodebykode($original_barcode){
		$hsl=$this->db->query("SELECT * FROM master_database WHERE original_barcode='$original_barcode'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'original_barcode' => $data->original_barcode,
					'brand' => $data->brand,
					'color' => $data->color,
					'size' => $data->size,
					'four_digit' => $data->four_digit,
					'unit' => $data->unit,
					'quantity' => $data->quantity,
					'customer' => $data->customer,
					'cust_model' => $data->cust_model,
					'model_code' => $data->model_code,
					'tooling_code' => $data->tooling_code,
				);
			}
		}
		return $hasil;
	}
	
	public function _attributelabels(){
		return [
			'original_barcode'=>'Original Barcode',
			'barcode_receiving'=>'Barcode Receiving',
			'barcode_shipping'=>'Barcode Shipping',
			'brand'=>'Brand',
			'color'=>'Color',
			'size'=>'Size',
			'four_digit'=>'Four Digit',
			'unit'=>'Unit',
			'quantity'=>'Quantity',
			'customer'=>'Customer',
			'cust_model'=>'Customer Model',
			'model_code'=>'Model Code',
			'tooling_code'=>'Tooling Code',
			'stock'=>'Stock',
			'date_time'=>'Date Time',
			'scan_no'=>'Scan No',
			'username'=>'Username',
			'no'=>'No',
			'date'=>'Tanggal',
			'stock_awal'=>'Stok Awal',
			'receiving'=>'Receiving',
			'shipping'=>'Shipping',
			'stock_akhir'=>'Stok Akhir'
		];
	}
	
	//get data for chartjs
	function get_data(){
		$query=$this->db->query("SELECT cust_model as Model, SUM(stock) as Total FROM master_database WHERE stock >= '0' AND stock != '0' GROUP BY cust_model ORDER BY cust_model"); 
		if($query->num_rows() > 0){
			foreach($query->result() as $data){
				$hasil[]=$data;
			}
			return $hasil;
		}
	}
	
	function get_data2(){
		$query=$this->db->query("SELECT DATE_FORMAT(date,'%d-%m') as Tanggal, receiving as Receiving, shipping as Shipping FROM stok ORDER BY date DESC LIMIT 5"); 
		if($query->num_rows() > 0){
			foreach($query->result() as $data){
				$hasil[]=$data;
			}
			return $hasil;
		}
	}
	
	//create datatable
	function get_all_barcode() {
		$this->datatables->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,stock');
		$this->datatables->from('master_database');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-sm" data-barcode="$1">Edit</a> <a href="javascript:void(0);" class="hapus_record btn btn-warning btn-sm" data-barcode="$1">Delete</a>','original_barcode');
		return $this->datatables->generate();
	}
	
	//create datatable
	function get_all_trans() {
		$this->datatables->select('no,stock_awal,receiving,shipping,stock_akhir,date');
		$this->datatables->from('stok');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-sm" data-no="$1">Edit</a> <a href="javascript:void(0);" class="hapus_record btn btn-warning btn-sm" data-no="$1">Delete</a>','no');
		return $this->datatables->generate();
	}
	
	//get original barcode
	function get_data_by_barcode($barcode){
		$hsl=$this->db->query("SELECT * FROM master_database WHERE original_barcode='$barcode'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'original_barcode' 	=> $data->original_barcode,
					'brand' 			=> $data->brand,
					'color' 			=> $data->color,
					'size' 				=> $data->size,
					'four_digit' 		=> $data->four_digit,
					'unit' 				=> $data->unit,
					'quantity' 			=> $data->quantity,
					'customer' 			=> $data->customer,
					'cust_model' 		=> $data->cust_model,
					'model_code' 		=> $data->model_code,
					'tooling_code' 		=> $data->tooling_code,
					'stock' 			=> $data->stock
				);
			}
		}
		return $hasil;
	}
	
	//get transaction
	function get_data_by_no($no){
		$hsl=$this->db->query("SELECT * FROM stok WHERE no='$no'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'no' 			=> $data->no,
					'stock_awal' 	=> $data->stock_awal,
					'receiving' 	=> $data->receiving,
					'shipping' 		=> $data->shipping,
					'stock_akhir' 	=> $data->stock_akhir,
					'date' 			=> $data->date
				);
			}
		}
		return $hasil;
	}
	
	public function upload_file($filename){
		$this->load->library('upload');

		$config['upload_path']='./excel/';
		$config['allowed_types']='xlsx';
		$config['max_size']='2048';
		$config['overwrite']=true;
		$config['file_name']=$filename;

		$this->upload->initialize($config);
		if($this->upload->do_upload('file')){
			$return=array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{
			$return=array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			return $return;
		}
	}

	public function update_multiple($data){
		$this->db->update_batch('master_database', $data,'original_barcode');
	}

	public function total(){
		$this->db->select_sum('stock','jumlah');
		$this->db->from('master_database');
		return $this->db->get('')->row();
	}
	
}