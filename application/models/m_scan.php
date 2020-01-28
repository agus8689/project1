<?php
class m_scan extends CI_Model{

	public function getoriginalbarcode($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('original_barcode');
		return $this->db->get('master_database')->row()->original_barcode;
	}
	
	public function getbarcodereceiving($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('original_barcode');
		return $this->db->get('master_database')->row()->original_barcode;
	}
	
	public function getbarcodeshipping($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('barcode_shipping');
		return $this->db->get('master_database')->row()->barcode_shipping;
	}
	
	public function getbrand($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('brand');
		return $this->db->get('master_database')->row()->brand;
	}
	
	public function getcolor($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('color');
		return $this->db->get('master_database')->row()->color;
	}
	
	public function getsize($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('size');
		return $this->db->get('master_database')->row()->size;
	}
	
	public function getfourdigit($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('four_digit');
		return $this->db->get('master_database')->row()->four_digit;
	}
	
	public function getunit($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('unit');
		return $this->db->get('master_database')->row()->unit;
	}
	
	public function getquantity($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('quantity');
		return $this->db->get('master_database')->row()->quantity;
	}
	
	public function getcustomer($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('customer');
		return $this->db->get('master_database')->row()->customer;
	}
	
	public function getcustmodel($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('cust_model');
		return $this->db->get('master_database')->row()->cust_model;
	}
	
	public function getmodelcode($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('model_code');
		return $this->db->get('master_database')->row()->model_code;
	}
	
	public function gettoolingcode($id){
		$this->db->where('original_barcode', $id);
		$this->db->select('tooling_code');
		return $this->db->get('master_database')->row()->tooling_code;
	}
	
	public function Generatereceiving($original_barcode, $brand, $color, $size, $four_digit, $unit, $quantity, $customer, $cust_model, $model_code, $tooling_code, $username){
		$waktu=date('Y-m-d');
		$this->db->where("date_format(date_time,'%Y-%m-%d')", $waktu);
		$this->db->select_max('scan_no');
		$scan_no=$this->db->get('receiving')->row()->scan_no;
		$scan_no=$scan_no + 1;
		date_default_timezone_set("Asia/Bangkok");
		$date=date('Y-m-d H:i:s');
		$input=array(
			'original_barcode' => $original_barcode,
			'brand' => $brand,
			'color' => $color,
			'size' => $size,
			'four_digit' => $four_digit,
			'unit' => $unit,
			'quantity' => $quantity,
			'customer' => $customer,
			'cust_model' => $cust_model,
			'model_code' => $model_code,
			'tooling_code' => $tooling_code,
			'date_time' => $date,
			'scan_no' => $scan_no,
			'username' => $username,
		);
		$this->db->insert('receiving', $input);

	}
	
	function role_exists($key)
	{
		$this->db->where('rolekey',$key);
		$query=$this->db->get('roles');
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function Generateshipping($original_barcode, $brand, $color, $size, $four_digit, $unit, $quantity, $customer, $cust_model, $model_code, $tooling_code, $username){
		$waktu=date('Y-m-d');
		$this->db->where("date_format(date_time,'%Y-%m-%d')", $waktu);			
		$this->db->select_max('scan_no');
		$scan_no=$this->db->get('shipping')->row()->scan_no;
		$scan_no=$scan_no + 1;
		date_default_timezone_set("Asia/Bangkok");
		$date=date('Y-m-d H:i:s');
		$input=array(
			'original_barcode' => $original_barcode,
			'brand' => $brand,
			'color' => $color,
			'size' => $size,
			'four_digit' => $four_digit,
			'unit' => $unit,
			'quantity' => $quantity,
			'customer' => $customer,
			'cust_model' => $cust_model,
			'model_code' => $model_code,
			'tooling_code' => $tooling_code,
			'date_time' => $date,
			'scan_no' => $scan_no,
			'username' => $username,
		);
		$this->db->insert('shipping', $input);		
	}
	
	//data receiving
	public function fetchdatar(){
		$this->db->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,date_time,scan_no,username');
		$this->db->from('receiving');
		$this->db->order_by('date_time','DESC');
		$this->db->limit('15');
		$query=$this->db->get();
		return $query->result();
	}
	
	//data shipping
	public function fetchdatas(){
		$this->db->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,date_time,scan_no,username');
		$this->db->from('shipping');
		$this->db->order_by('date_time','DESC');
		$this->db->limit('15');
		$query=$this->db->get();
		return $query->result();
	}
	
	//data receiving IT
	public function fetchdatar2(){
		$this->db->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,date_time,scan_no,username');
		$this->db->from('receiving');
		$this->db->order_by('date_time','DESC');
		$query=$this->db->get();
		return $query->result();
	}
	
	//data shipping IT
	public function fetchdatas2(){
		$this->db->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,date_time,scan_no,username');
		$this->db->from('shipping');
		$this->db->order_by('date_time','DESC');
		$query=$this->db->get();
		return $query->result();
	}
	
	public function custom_query($query){
		$sql=$this->db->query($query);
		return $sql;
	}
	
	//create datatable receiving
	function get_all_rec() {
		$this->datatables->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,date_time,scan_no,username');
		$this->datatables->from('receiving');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-sm" data-date="$1" data-kode="$1" data-scan="$2" data-user="$3">Edit</a> <a href="javascript:void(0);" class="hapus_record btn btn-warning btn-sm" data-date="$1" data-scan="$2" data-user="$3">Delete</a>','date_time,scan_no,username');
		return $this->datatables->generate();
	}
	
	//create datatable shipping
	function get_all_shi() {
		$this->datatables->select('original_barcode,brand,color,size,four_digit,unit,quantity,customer,cust_model,model_code,tooling_code,date_time,scan_no,username');
		$this->datatables->from('shipping');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-sm" data-date="$1" data-kode="$1" data-scan="$2" data-user="$3">Edit</a> <a href="javascript:void(0);" class="hapus_record btn btn-warning btn-sm" data-date="$1" data-scan="$2" data-user="$3">Delete</a>','date_time,scan_no,username');
		return $this->datatables->generate();
	}
	
	//get original barcode
	function get_data_rec($date,$scan,$user){
		$hsl=$this->db->query("SELECT * FROM receiving WHERE date_time='$date' AND scan_no='$scan' AND username='$user'");
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
					'date_time' 		=> $data->date_time,
					'scan_no' 			=> $data->scan_no,
					'username' 			=> $data->username
				);
			}
		}
		return $hasil;
	}
	
	//get original barcode
	function get_data_shi($date,$scan,$user){
		$hsl=$this->db->query("SELECT * FROM shipping WHERE date_time='$date' AND scan_no='$scan' AND username='$user'");
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
					'date_time' 		=> $data->date_time,
					'scan_no' 			=> $data->scan_no,
					'username' 			=> $data->username
				);
			}
		}
		return $hasil;
	}
}