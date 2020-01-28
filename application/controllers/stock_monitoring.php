<?php
class stock_monitoring extends CI_controller{
	private $filename="import_data";
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata['username']==NULL){
			echo '<script>alert(\'Silakan Login Terlebih Dahulu\');document.location=\''.base_url('login/home').'\'</script>';
		}			
		$this->load->model('sm_model');
		$this->load->model('model_transaksi');
		$this->model=$this->sm_model;
		$this->load->library('datatables');
	}
	
	//get all data barcode by JSON object
	function get_guest_json(){
		header('Content-Type: application/json');
		echo $this->sm_model->get_all_barcode();
	}
	
	//get all data transaction by JSON object
	function get_json_trans(){
		header('Content-Type: application/json');
		echo $this->sm_model->get_all_trans();
	}
	
	//get data barcode by original barcode
	function get_barcode(){
		$barcode=$this->input->get('barcode');
		$data=$this->sm_model->get_data_by_barcode($barcode);
		echo json_encode($data);
	}
	
	//get data transaction by no
	function get_trans(){
		$no=$this->input->get('no');
		$data=$this->sm_model-> get_data_by_no($no);
		echo json_encode($data);
	}
	
	//function save barcode
	function save_barcode(){
		$id=$_POST['barcode'];
		$this->db->where('original_barcode',$id);
		$query=$this->db->get('master_database');
		if ($query->num_rows()==0) 
		{
			$data=array(
				'original_barcode'	=> $this->input->post('barcode'),
				'brand'				=> $this->input->post('brand'),
				'color'				=> $this->input->post('color'),
				'size'				=> $this->input->post('size'),
				'four_digit'		=> $this->input->post('digit'),
				'unit'				=> $this->input->post('unit'),
				'quantity'			=> $this->input->post('quantity'),
				'customer'			=> $this->input->post('customer'),
				'cust_model'		=> $this->input->post('cust'),
				'model_code'		=> $this->input->post('model'),
				'tooling_code'		=> $this->input->post('tooling'),
				'stock'				=> $this->input->post('stock')
			);
			$this->db->insert('master_database',$data);
			$username=$this->session->userdata['username'];
			$rows=$this->model->read();
			$this->session->set_flashdata
			('msg','<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
				Data Berhasil Diinputkan
				</div>');
			$this->template->load('template1','master_read_view',['rows'=>$rows,'username'=>$username]);
		}else{
			$username=$this->session->userdata['username'];
			$rows=$this->model->read();
			$this->session->set_flashdata
			('msg','<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
				Data Gagal Diinputkan
				</div>'); 
			$this->template->load('template1','master_read_view',['rows'=>$rows,'username'=>$username]);
		}
	}

	//function edit barcode
	function edit_barcode(){
		$barcode=$this->input->post('barcode_edit');
		$data=array(
			'brand'				=> $this->input->post('brand_edit'),
			'color'				=> $this->input->post('color_edit'),
			'size'				=> $this->input->post('size_edit'),
			'four_digit'		=> $this->input->post('digit_edit'),
			'unit'				=> $this->input->post('unit_edit'),
			'quantity'			=> $this->input->post('quantity_edit'),
			'customer'			=> $this->input->post('customer_edit'),
			'cust_model'		=> $this->input->post('cust_edit'),
			'model_code'		=> $this->input->post('model_edit'),
			'tooling_code'		=> $this->input->post('tooling_edit'),
			'stock'				=> $this->input->post('stock_edit')
		);
		$this->db->where('original_barcode',$barcode);
		$this->db->update('master_database',$data);
		$this->session->set_flashdata
		('msg','<div class="alert bg-blue alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Diperbarui
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1','master_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	//function edit transaction
	function edit_transaction(){
		$no=$this->input->post('no_edit');
		$data=array(
			'stock_awal'		=> $this->input->post('awal_edit'),
			'receiving'			=> $this->input->post('receiving_edit'),
			'shipping'			=> $this->input->post('shipping_edit'),
			'stock_akhir'		=> $this->input->post('akhir_edit')
		);
		$this->db->where('no',$no);
		$this->db->update('stok',$data);
		$this->session->set_flashdata
		('msg','<div class="alert bg-blue alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Diperbarui
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1','stock_report',['rows'=>$rows,'username'=>$username]);
	}

	//function delete barcode
	function delete_barcode(){
		$barcode=$this->input->post('barcode');
		$this->db->where('original_barcode',$barcode);
		$this->db->delete('master_database');
		$this->session->set_flashdata
		('msg','<div class="alert bg-orange alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Dihapus
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1','master_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	//function delete transaction
	function delete_transaction(){
		$no=$this->input->post('no');
		$this->db->where('no',$no);
		$this->db->delete('stok');
		$this->session->set_flashdata
		('msg','<div class="alert bg-orange alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Dihapus
			</div>');
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1','stock_report',['rows'=>$rows,'username'=>$username]);
	}
	
	public function index(){
		$username=$this->session->userdata['username'];
		$this->read();
	}
	
	//daily report
	public function report(){
		$data['username']=$this->session->userdata['username'];
		$tanggal1="";
		$tanggal2="";
		$tipe="";
		$model="";
		$color="";
		$size="";
		$user="";
		if(isset($_POST['btnSubmit'])){
			$tanggal1=$_POST['tanggal1'];
			$tanggal2=$_POST['tanggal2'];
			$tipe=$_POST['tipe'];
			$model=$_POST['model'];
			$color=str_replace("_", " ", $_POST['color']);
			$size=$_POST['size'];
			$user=$_POST['user'];
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			if($tipe=="receiving"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND username='$user' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' ORDER BY date_time")->result();
				}
			}elseif($tipe=="shipping"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND username='$user' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' ORDER BY date_time")->result();
				}
			}
		}
		else{
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE cust_model='0'")->result();	
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tipe']=$tipe;
		$data['model']=$model;
		$data['color']=$color;
		$data['size']=$size;
		$data['user']=$user;

		$this->template->load('template2', 'daily_report', $data);
	}
	
	public function stock_report(){
		$data['username']=$this->session->userdata['username'];
		$this->template->load('template2', 'stock_report', $data);
	}
	
	public function stock_report1(){
		$data['username']=$this->session->userdata['username'];
		$this->template->load('template1', 'stock_report', $data);
	}
	
	public function ekspor_stock_report1(){
		$data['username']=$this->session->userdata['username'];
		$data['detail_stok']=$this->model_transaksi->custom_query("select no, stock_awal, receiving, shipping, stock_akhir, date from stok order by date asc")->result();
		$file_name=date('d-m-Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$this->load->view('laporan_stok_bulan',$data);
	}
	
	//daily report 
	public function report1(){
		$data['username']=$this->session->userdata['username'];
		$tanggal1="";
		$tanggal2="";
		$tipe="";
		$model="";
		$color="";
		$size="";
		$user="";
		if(isset($_POST['btnSubmit'])){
			$tanggal1=$_POST['tanggal1'];
			$tanggal2=$_POST['tanggal2'];
			$tipe=$_POST['tipe'];
			$model=$_POST['model'];
			$color=str_replace("_", " ", $_POST['color']);
			$size=$_POST['size'];
			$user=$_POST['user'];
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			if($tipe=="receiving"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND username='$user' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' ORDER BY date_time")->result();
				}
			}elseif($tipe=="shipping"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND username='$user' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' ORDER BY date_time")->result();
				}
			}
		}
		else{
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE cust_model='0'")->result();	
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tipe']=$tipe;
		$data['model']=$model;
		$data['color']=$color;
		$data['size']=$size;
		$data['user']=$user;

		$this->template->load('template1', 'daily_report1', $data);
	}
	
	//hourly report IT
	public function report2(){
		$data['username']=$this->session->userdata['username'];
		$tanggal1="";
		$tanggal2="";
		$tipe="";
		$model="";
		$color="";
		$size="";
		$user="";
		$jam1="";
		$jam2="";
		if(isset($_POST['btnSubmit'])){
			$tanggal1=$_POST['tanggal1'];
			$tanggal2=$_POST['tanggal2'];
			$tipe=$_POST['tipe'];
			$model=$_POST['model'];
			$color=str_replace("_", " ", $_POST['color']);
			$size=$_POST['size'];
			$user=$_POST['user'];
			$jam1=$_POST['jam1'];
			$jam2=$_POST['jam2'];
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			$data['hours']=$this->sm_model->Gettime();
			if($tipe=="receiving"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' ORDER BY date_time")->result();
				}
			}elseif($tipe=="shipping"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' ORDER BY date_time")->result();
				}
			}
		}
		else{
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			$data['hours']=$this->sm_model->Gettime();
			$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM data_shipping WHERE cust_model='0'")->result();	
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tipe']=$tipe;
		$data['model']=$model;
		$data['color']=$color;
		$data['size']=$size;
		$data['user']=$user;
		$data['jam1']=$jam1;
		$data['jam2']=$jam2;
		$this->template->load('template1', 'report_hour', $data);
	}
	
	//hourly report Monitoring
	public function report3(){
		$data['username']=$this->session->userdata['username'];
		$tanggal1="";
		$tanggal2="";
		$tipe="";
		$model="";
		$color="";
		$size="";
		$user="";
		$jam1="";
		$jam2="";
		if(isset($_POST['btnSubmit'])){
			$tanggal1=$_POST['tanggal1'];
			$tanggal2=$_POST['tanggal2'];
			$tipe=$_POST['tipe'];
			$model=$_POST['model'];
			$color=str_replace("_", " ", $_POST['color']);
			$size=$_POST['size'];
			$user=$_POST['user'];
			$jam1=$_POST['jam1'];
			$jam2=$_POST['jam2'];
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			$data['hours']=$this->sm_model->Gettime();
			if($tipe=="receiving"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' ORDER BY date_time")->result();
				}
			}elseif($tipe=="shipping"){
				if($model!=null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
				}elseif($model!=null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model!=null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' ORDER BY date_time")->result();	
				}elseif($model==null && $color!=null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size!=null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user!=null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' ORDER BY date_time")->result();	
				}elseif($model==null && $color==null && $size==null && $user==null){
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' ORDER BY date_time")->result();	
				}else{
					$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' ORDER BY date_time")->result();
				}
			}
		}
		else{
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['models']=$this->sm_model->Getmodel();
			$data['users']=$this->sm_model->Getuser();
			$data['hours']=$this->sm_model->Gettime();
			$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE cust_model='0'")->result();	
		}
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tipe']=$tipe;
		$data['model']=$model;
		$data['color']=$color;
		$data['size']=$size;
		$data['user']=$user;
		$data['jam1']=$jam1;
		$data['jam2']=$jam2;
		$this->template->load('template2', 'report_hour2', $data);
	}
	
	//stock
	public function stock(){
		$data['username']=$this->session->userdata['username'];
		$model="";
		$color="";
		$size="";
		if(isset($_POST['btnSubmit'])){
			$model=$_POST['model'];
			$color=$_POST['color'];
			$size=$_POST['size'];
			$data['models']=$this->sm_model->Getmodel();
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			if($model!=null && $color!=null && $size!=null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND color='$color' AND size='$size' AND stock !='0' ORDER BY original_barcode")->result();
			}elseif($model!=null && $color==null && $size==null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND stock !='0' ORDER BY original_barcode ASC")->result();	
			}elseif($model==null && $color!=null && $size==null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE color='$color' AND stock !='0' ORDER BY original_barcode ASC")->result();
			}elseif($model==null && $color==null && $size!=null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE size='$size' AND stock !='0' ORDER BY original_barcode ASC")->result();	
			}elseif($model!=null && $color!=null && $size==null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND color='$color' AND stock !='0' ORDER BY original_barcode ASC")->result();	
			}elseif($model!=null && $color==null && $size!=null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND size='$size' AND stock !='0' ORDER BY original_barcode ASC")->result();	
			}elseif($model==null && $color!=null && $size!=null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE color='$color' AND size='$size' AND stock !='0' ORDER BY original_barcode ASC")->result();	
			}elseif($model==null && $color==null && $size==null){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE stock !='0' ORDER BY original_barcode ASC")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM master_database WHERE original_barcode='0' ORDER BY original_barcode")->result();
			}
		}
		else{
			$data['models']=$this->sm_model->Getmodel();
			$data['kolor']=$this->sm_model->Getkolor();
			$data['sizes']=$this->sm_model->Getsize();
			$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM master_database WHERE original_barcode='0' ORDER BY original_barcode")->result();	
		}	
		$data['model']=$model;
		$data['color']=$color;
		$data['size']=$size;
		$this->template->load('template1', 'stock', $data);
	}
	
	//ekspor daily report
	public function ekspor($tanggal1,$tanggal2,$tipe,$model,$color,$size,$user){
		$data['username']=$this->session->userdata['username'];
		$color=preg_replace('/%20/', ' ', $color);
		$end_date=date('Y-m-d 07:59:59',strtotime('+1 day'));
		$end_date=date('Y-m-d 07:59:59',strtotime('-1 day'));
		if($tipe=="receiving"){
			if($model!='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND username='$user' ORDER BY date_time")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_receiving WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' ORDER BY date_time")->result();
			}
		}elseif($tipe="shipping") {
			if($model!='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND model_code='$model' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' AND username='$user' ORDER BY date_time")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT DISTINCT * FROM data_shipping WHERE date_time BETWEEN '$tanggal1 06:30:00' AND '$tanggal2 06:29:59' ORDER BY date_time")->result();
			}
		}	
		$file_name=date('d-m-Y')."-Selected";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tipe']=$tipe;
		$this->load->view('laporan_stok',$data);
	}
	
	public function ekspor2($tipe,$hari1,$jam){
		$data['username']=$this->session->userdata['username'];
		if($tipe=="receiving"){
			$data['detail']=$this->model_transaksi->custom_query("select * from receiving order by date_time")->result();
			$file_name="Report Receiving_".date('d-m-Y');
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename={$file_name}.xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			$data['tipe']=$tipe;
			$data['hari']=$hari1;
			$data['jam']=$jam;
			$this->load->view('laporan_stok3',$data);
		}elseif($tipe=="shipping"){
			$data['detail']=$this->model_transaksi->custom_query("select * from shipping order by date_time")->result();
			$file_name="Report Shipping_".date('d-m-Y');
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename={$file_name}.xls");
			header("Expires: 0");
			$data['tipe']=$tipe;
			$data['hari']=$hari1;
			$data['jam']=$jam;
			$this->load->view('laporan_stok3',$data);
		}
	}
	
	public function ekspor3($tanggal1,$tanggal2,$tipe,$model,$color,$size,$user,$jam1,$jam2){
		$data['username']=$this->session->userdata['username'];
		$color=preg_replace('/%20/', ' ', $color);
		$end_date=date('Y-m-d 07:59:59',strtotime('+1 day'));
		$end_date=date('Y-m-d 07:59:59',strtotime('-1 day'));
		if($tipe=="receiving"){
			if($model!='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' ORDER BY date_time")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM receiving WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' ORDER BY date_time")->result();
			}
		}elseif($tipe=="shipping"){
			if($model!='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' ORDER BY date_time")->result();
			}elseif($model!='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' ORDER BY date_time")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' ORDER BY date_time")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM shipping WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' ORDER BY date_time")->result();
			}
		}
		$file_name="Detail Hourly_".date('d-m-Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['tipe']=$tipe;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['jam1']=$jam1;
		$data['jam2']=$jam2;
		$this->load->view('laporan_stok2',$data);
	}
	
	public function ekspor4($model,$color,$size,$hari1,$jam){
		$data['username']=$this->session->userdata['username'];
		$end_date=date('Y-m-d 07:59:59',strtotime('+1 day'));
		$end_date=date('Y-m-d 07:59:59',strtotime('-1 day'));
		if($model!='n' && $color!='n' && $size!='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND color='$color' AND size='$size' AND stock !='0' ORDER BY original_barcode")->result();
		}elseif($model!='n' && $color=='n' && $size=='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND stock !='0' ORDER BY original_barcode ASC")->result();	
		}elseif($model=='n' && $color!='n' && $size=='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE color='$color' AND stock !='0' ORDER BY original_barcode ASC")->result();
		}elseif($model=='n' && $color=='n' && $size!='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE size='$size' AND stock !='0' ORDER BY original_barcode ASC")->result();	
		}elseif($model!='n' && $color!='n' && $size=='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND color='$color' AND stock !='0' ORDER BY original_barcode ASC")->result();	
		}elseif($model!='n' && $color=='n' && $size!='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE model_code='$model' AND size='$size' AND stock !='0' ORDER BY original_barcode ASC")->result();	
		}elseif($model=='n' && $color!='n' && $size!='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE color='$color' AND size='$size' AND stock !='0' ORDER BY original_barcode ASC")->result();	
		}elseif($model=='n' && $color=='n' && $size=='n'){
			$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, stock as Stock FROM master_database WHERE stock !='0' ORDER BY original_barcode ASC")->result();	
		}else{
			$data['detail']=$this->model_transaksi->custom_query("SELECT * FROM master_database WHERE original_barcode='0' ORDER BY original_barcode")->result();
		}
		$file_name="Detail Stock_".date('d-m-Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['hari']=$hari1;
		$data['jam']=$jam;
		$this->load->view('laporan_stok4',$data);
	}
	
	public function ekspor_hour($tanggal1,$tanggal2,$tipe,$model,$color,$size,$user,$jam1,$jam2){
		$data['username']=$this->session->userdata['username'];
		$color=preg_replace('/%20/', ' ', $color);
		$end_date=date('Y-m-d 07:59:59',strtotime('+1 day'));
		$end_date=date('Y-m-d 07:59:59',strtotime('-1 day'));
		if($tipe=="receiving"){
			if($model!='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();
			}elseif($model!='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();
			}elseif($model!='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `receiving` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();
			}
		}elseif($tipe=="shipping"){
			if($model!='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();
			}elseif($model!='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();
			}elseif($model!='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND color='$color' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model!='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND model_code='$model' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color!='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND color='$color' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size!='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND size='$size' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user!='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' AND username='$user' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}elseif($model=='n' && $color=='n' && $size=='n' && $user=='n'){
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();	
			}else{
				$data['detail']=$this->model_transaksi->custom_query("SELECT brand as Brand, cust_model as Model, color as Color, size as Size, quantity as Quantity, COUNT(*) as Jumlah, COUNT(*) * quantity as Total FROM `shipping` WHERE date_time BETWEEN '$tanggal1 $jam1' AND '$tanggal2 $jam2' WHERE scan_no='0' GROUP BY model_code, color, size, quantity ORDER BY model_code, color, size ASC")->result();
			}
		}
		$file_name="Summary Hourly_".date('d-m-Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['tipe']=$tipe;
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['jam1']=$jam1;
		$data['jam2']=$jam2;
		$this->load->view('laporan_summary',$data);
	}
	
	public function ekspor_all_receive(){
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->model_transaksi->custom_query("select * from data_receiving")->result();	
		$file_name=date('d-m-Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['tanggal']=$tanggal;
		$data['bulan']=$bulan;
		$data['tahun']=$tahun;
		$data['tipe']=$tipe;
		$this->load->view('laporan_stok_all_receive',$data);
	}
	
	public function ekspor_all_ship(){
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->model_transaksi->custom_query("select * from data_shipping")->result();		
		$file_name=date('d-m-Y');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['tanggal']=$tanggal;
		$data['bulan']=$bulan;
		$data['tahun']=$tahun;
		$data['tipe']=$tipe;
		$this->load->view('laporan_stok_all_ship',$data);
	}
	
	//ekspor summary report
	public function ekspor_pivot($tanggal1,$tanggal2,$tipe,$model,$color,$size){
		$data['username']=$this->session->userdata['username'];	
		if($tipe=="receiving"){
			if($model!='n' && $color!='n' && $size!='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' and b.color='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time between '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model'  and b.color='$color' and b.size='$size' group by b.cust_model,b.color,b.size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' and b.size='$size' and b.model_code='$model' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' and model_code='$model' and color='$color' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' and b.color='$color' and b.size='$size' ")->row()->all_size;
			}elseif($model!='n' && $color!='n' && $size=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model'  and b.color='$color' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' and b.color='$color' group by a.cust_model,a.color,a.size) as b")->result();$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and color='$color' and model_code='$model' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' and b.color='$color' ")->row()->all_size;
			}elseif($model!='n' && $size!='n' && $color=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model ")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' and b.size='$size' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' and b.size='$size' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' and model_code='$model' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' group by color, size, cust_model order by cust_model,color,size ASC")->result();	
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' ")->row()->all_size;
			}elseif($color!='n' && $size!='n' && $model=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model ")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' and b.size='$size' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' and b.size='$size' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' and color='$color' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and b.size='$size' and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and b.size='$size' and b.color='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and b.color='$color' and b.size='$size' ")->row()->all_size;
			}elseif($model!='n' && $color=='n' && $size=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' b.model_code='$model' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and  group by scan_no group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' ")->row()->all_size;
			}elseif($color!='n' && $model=='n' && $size=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model ")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' b.color='$color' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and color='$color' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.color='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();	
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.color='$color' ")->row()->all_size;
			}elseif($size!='n' && $color=='n' && $model=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model ")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.size='$size' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' b.size='$size' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.size='$size' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.size='$size' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.size='$size' ")->row()->all_size;			
			}else{
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_receiving where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_receiving where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model ")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_receiving group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by cust_model, color, size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_receiving where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_receiving where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_receiving WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_receiving where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' ")->row()->all_size;
			}
		}elseif ($tipe=="shipping"){
			if($model!='n' && $color!='n' && $size!='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' and b.color='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time between '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model'  and b.color='$color' and b.size='$size' group by b.cust_model,b.color,b.size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' and b.size='$size' and b.model_code='$model' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' and model_code='$model' and color='$color' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' and b.color='$color' and b.size='$size' ")->row()->all_size;
			}elseif($model!='n' && $color!='n' && $size=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model'  and b.color='$color' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' and b.color='$color' group by a.cust_model,a.color,a.size) as b")->result();$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and color='$color' and model_code='$model' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' and b.color='$color' ")->row()->all_size;
			}elseif($model!='n' && $size!='n' && $color=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' and b.size='$size' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' and b.size='$size' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' and model_code='$model' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' group by color, size, cust_model order by cust_model,color,size ASC")->result();	
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model'  and b.size='$size' ")->row()->all_size;
			}elseif($color!='n' && $size!='n' && $model=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' and b.size='$size' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' and b.size='$size' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' and color='$color' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and b.size='$size' and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and b.size='$size' and b.color='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and b.color='$color' and b.size='$size' ")->row()->all_size;
			}elseif($model!='n' && $color=='n' && $size=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.model_code='$model' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' b.model_code='$model' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and  group by scan_no group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.model_code='$model' ")->row()->all_size;
			}elseif($color!='n' && $model=='n' && $size=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.color='$color' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' b.color='$color' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and color='$color' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.color='$color' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.color='$color' group by color, size, cust_model order by cust_model,color,size ASC")->result();	
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.color='$color' ")->row()->all_size;
			}elseif($size!='n' && $color=='n' && $model=='n'){
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' and b.size='$size' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' b.size='$size' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' and size='$size' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.size='$size' and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.size='$size' group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' and b.size='$size' ")->row()->all_size;			
			}else{
				$data['saiz']=$this->model_transaksi->custom_query("SELECT size from master_database group by size")->result();	
				$data['mdl']=$this->model_transaksi->custom_query("SELECT cust_model from master_database group by cust_model")->result();	
				$data['clr']=$this->model_transaksi->custom_query("SELECT color from master_database group by color")->result();
			//$data['qty']=$this->sm_model->Getdataquantity($data['mdl'],$data['saiz'],$data['clr']);
			//$data['qty']=$this->model_transaksi->custom_query("SELECT sum(quantity) as quantity from data_shipping where size IN(".implode("SELECT size from master_database group by size").") and color IN (SELECT color from master_database group by color) and cust_model in (SELECT cust_model from master_database group by cust_model) ")->result();	
				$data['qty']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from data_shipping where cust_model IN (SELECT cust_model from master_database) group by color, size, cust_model")->result();	
			//$data['detail']=$this->model_transaksi->custom_query("SELECT cust_model, color, size from data_shipping group by cust_model,color,size")->result();
				$data['detail']=$this->model_transaksi->custom_query("select a.cust_model,a.color,a.size,sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by cust_model,color,size")->result();
				$data['totals']=$this->model_transaksi->custom_query("select sum(quantity) as quantity from (select sum(b.quantity) as quantity from master_database a join (select * from data_shipping where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by scan_no,date_time) b on a.original_barcode=b.original_barcode where date_time BETWEEN '$tanggal1 07:00:00' AND '$tanggal2 07:00:00' group by a.cust_model,a.color,a.size) as b")->result();
				$data['gt']=$this->model_transaksi->custom_query("select a.size, sum(b.quantity) as quantity from (select * from data_shipping where date_time between '$tanggal1 07:00:00' and '$tanggal2 07:00:00' group by scan_no, date_time) b right outer join master_database a on a.original_barcode=b.original_barcode group by size")->result();
			//$data['details']=$this->model_transaksi->custom_query("Select sum(quantity) as quantity, color, size,cust_model from (SELECT * FROM data_shipping WHERE date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  and DATE_FORMAT(date_time, '%H:%i')>='06.30' GROUP BY SCAN_NO) AS B where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2'  group by color, size, cust_model order by cust_model,color,size ASC")->result();
			//$data['data_all_size']=$this->model_transaksi->custom_query("Select count(size) as all_size from data_shipping where cust_model IN (SELECT cust_model from master_database) and date(date_time) BETWEEN '$tanggal1' AND '$tanggal2' ")->row()->all_size;
			}
		}			
		$file_name=date('d-m-Y')."-Summary";
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}.xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data['tanggal1']=$tanggal1;
		$data['tanggal2']=$tanggal2;
		$data['tipe']=$tipe;
		$data['data_jumlah_baris']=$this->model_transaksi->custom_query("select count(size) as jumlah_baris from (select size from master_database group by size) as a")->row()->jumlah_baris;
		$this->load->view('laporan_stok_pivots',$data,['data_all_size'=>$data_all_size],['data_jumlah_baris'=>$data_jumlah_baris],['tanggal1'=>$tanggal1],['tanggal2'=>$tanggal2]);
	}
	
	public function create(){
		$username=$this->session->userdata['username'];
		$this->form_validation->set_rules('original_barcode', 'original_barcode', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('brand', 'brand', 'trim|required');
		$this->form_validation->set_rules('color', 'color', 'trim|required');
		$this->form_validation->set_rules('four_digit', 'four_digit', 'trim|required|alpha_numeric');
		$this->form_validation->set_rules('unit', 'unit', 'trim|required|alpha');
		$this->form_validation->set_rules('quantity', 'quantity', 'trim|required|numeric|is_natural_no_zero');
		$this->form_validation->set_rules('customer', 'customer', 'trim|required');
		$this->form_validation->set_rules('cust_model', 'cust_model', 'trim|required');
		$this->form_validation->set_rules('model_code', 'model_code', 'trim|required');
		
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><li>','</li></div>');
		
		if($this->form_validation->run() !=false) {

			if (isset($_POST['btnSubmit'])) {
				$this->model->original_barcode=$_POST['original_barcode'];
				$this->model->brand=$_POST['brand'];
				$this->model->color=$_POST['color'];
				$this->model->size=$_POST['size'];
				$this->model->four_digit=$_POST['four_digit'];
				$this->model->unit=$_POST['unit'];
				$this->model->quantity=$_POST['quantity'];
				$this->model->customer=$_POST['customer'];
				$this->model->cust_model=$_POST['cust_model'];
				$this->model->model_code=$_POST['model_code'];
				$this->model->tooling_code=$_POST['tooling_code'];
				$this->model->stock=$_POST['stock'];
				$this->model->insert();
				echo "FORM VALIDATION OKE";
				redirect('stock_monitoring/master');
			}else{
				$this->template->load('template1', 'master_create_view',['model'=>$this->model,'username'=>$username]);
			}
		}else{
			$this->template->load('template1', 'master_create_view',['model'=>$this->model,'username'=>$username]);
		}
	}
	
	public function print_excel_master(){
		$data['username']=$this->session->userdata['username'];
		header("Content-type=appalication/vnd.ms.excel");
		header("Content-disposition: attachment; filename=Master Data.xls");
		$rows=$this->model->read();
		$total=$this->sm_model->total();
		$this->load->view('master_excel_view',['rows'=>$rows,'total'=>$total]);
	}
	
	public function read(){
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1', 'master_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	public function master(){
		$username=$this->session->userdata['username'];
		$rows=$this->model->read();
		$this->template->load('template1', 'master_read_view',['rows'=>$rows,'username'=>$username]);
	}
	
	//Update Stock
	public function update5($no){
		$username=$this->session->userdata['username'];
		//if($this->form_validation->run() !=false) {
		if (isset($_POST['btnSubmit'])) {
			$no=$_POST['no'];
			$date=$_POST['date'];
			$stock_awal=$_POST['stock_awal'];
			$receiving=$_POST['receiving'];
			$shipping=$_POST['shipping'];
			$stock_akhir=$_POST['stock_akhir'];
			$this->model_transaksi->custom_query("UPDATE stok set date='$date', stock_awal='$stock_awal', receiving='$receiving', shipping='$shipping', stock_akhir='$stock_akhir' where no='$no'");
			redirect('stock_monitoring/stock_report1');
		}else{
			$query=$this->db->query("SELECT * FROM stok WHERE no='$no'");
			$row=$query->row();
			$this->model->no=$row->no;
			$this->model->stock_awal=$row->stock_awal;
			$this->model->receiving=$row->receiving;
			$this->model->shipping=$row->shipping;
			$this->model->stock_akhir=$row->stock_akhir;
			$this->model->date=$row->date;
			$this->template->load('template1', 'update_stock',['model'=>$this->model,'username'=>$username]);
		}
	}
	
	//Delete Stock
	public function delete_stock($no){
		$this->model->no=$no;
		$this->model->delete6();
		redirect('stock_monitoring/stock_report1');
	}
	
	//Pindah Data ke Data Receiving
	public function mover(){
		$data1=date('Y-m-d');
		$data2=" 06:30:00";
		$date=$data1.$data2;
		$this->model->date_time=$date;
		$this->model->insertr();
		$this->model->trunr();
		redirect('scan/viewscanreceiving2');
	}
	
	//Pindah Data ke Data Shipping
	public function moves(){
		$data1=date('Y-m-d');
		$data2=" 06:30:00";
		$date=$data1.$data2;
		$this->model->date_time=$date;
		$this->model->inserts();
		$this->model->truns();
		redirect('scan/viewscanshipping2');
	}

	public function dashboard(){
		$data['username']=$this->session->userdata['username'];

		$tanggal=date('Y-m-d H:i:s');
		
		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$date_now=date('Y-m-d');
		$date_yesterday=date('Y-m-d',strtotime("-1 day"));

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');

			$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
			$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");

		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));

			$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now' and date_format(date,'%Y-%m-%d')<>'$date_yesterday'")->row()->date;
			$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' and date_format(date,'%Y-%m-%d')<>'$date_yesterday'");
		}

		$now=date('Y-m-d');

		$rec=$this->model_transaksi->custom_query("select sum(quantity) as rec from receiving where date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->rec;
		$shi=$this->model_transaksi->custom_query("select sum(quantity) as shi from shipping where date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->shi;
		$sto=$this->model_transaksi->custom_query("select sum(stock) as total from master_database")->row()->total;
		$stc=($rec - $shi) + $sto; 
		
		$data1=array(
			'stock_awal'=>$sto,
			'receiving'=>$rec,
			'shipping'=>$shi,
			'stock_akhir'=>$stc
		);

		if($tanggal<=$date1 && $tanggal>=$start){
			$update_stock=$this->model_transaksi->update("stok", $data1, "date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'");
		}else{
			$update_stock=$this->model_transaksi->update("stok", $data1, "date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'");
		}

		$waktu=date('H:i:s');
		$waktu2=date('H:i:s');
		$trans=date('06:30:01');
		$trans2=date('06:30:10');
		//catatan : setiap pukul 06.30 tunggu sampai pukul 06.31 baru mulai pergunakan barcode scanner.
		if($waktu>=$trans && $waktu<=$trans2){
			$this->model_transaksi->custom_query("insert into data_receiving select * from receiving where date(date_time)<='$date_now'");
			$this->model_transaksi->custom_query("insert into data_shipping select * from shipping where date(date_time)<='$date_now'");
			$this->model_transaksi->custom_query("truncate table receiving");
			$this->model_transaksi->custom_query("truncate table shipping");
		}else{
			$this->model_transaksi->custom_query("insert into data_receiving select * from receiving where cust_model='0'");	
		}

		$data['chart']=$this->sm_model->get_data();
		$data['chart2']=$this->sm_model->get_data2();
		$data['receiving']=$this->model_transaksi->custom_query("select sum(quantity) as jml_receiving from receiving WHERE date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->jml_receiving;
		$data['shipping']=$this->model_transaksi->custom_query("select sum(quantity) as jml_shipping from shipping WHERE date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->jml_shipping;
		$data['stock_akhir']=$this->model_transaksi->custom_query("select sum(stock) as jml_stock from master_database")->row()->jml_stock;			
		$data['result_receiving']=$this->model_transaksi->custom_query("select * from receiving order by date_time desc limit 5");
		$data['result_shipping']=$this->model_transaksi->custom_query("select * from shipping order by date_time desc limit 5");
		$this->template->load('template5','dashboard',$data);
	}

	public function dashboard1(){
		$data['username']=$this->session->userdata['username'];

		$tanggal=date('Y-m-d H:i:s');
		
		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$date_now=date('Y-m-d');
		$date_yesterday=date('Y-m-d',strtotime("-1 day"));

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');

			$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
			$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");

		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));

			$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now' and date_format(date,'%Y-%m-%d')<>'$date_yesterday'")->row()->date;
			$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' and date_format(date,'%Y-%m-%d')<>'$date_yesterday'");
		}

		$now=date('Y-m-d');

		$rec=$this->model_transaksi->custom_query("select sum(quantity) as rec from receiving where date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->rec;
		$shi=$this->model_transaksi->custom_query("select sum(quantity) as shi from shipping where date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->shi;
		$sto=$this->model_transaksi->custom_query("select sum(stock) as total from master_database")->row()->total;
		$stc=($rec - $shi) + $sto; 
		
		$data1=array(
			'stock_awal'=>$sto,
			'receiving'=>$rec,
			'shipping'=>$shi,
			'stock_akhir'=>$stc
		);

		if($tanggal<=$date1 && $tanggal>=$start){
			$update_stock=$this->model_transaksi->update("stok", $data1, "date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'");
		}else{
			$update_stock=$this->model_transaksi->update("stok", $data1, "date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'");
		}

		$waktu=date('H:i:s');
		$waktu2=date('H:i:s');
		$trans=date('06:30:01');
		$trans2=date('06:30:10');
		//catatan : setiap pukul 06.30 tunggu sampai pukul 06.31 baru mulai pergunakan barcode scanner.
		if($waktu>=$trans && $waktu<=$trans2){
			$this->model_transaksi->custom_query("insert into data_receiving select * from receiving where date(date_time)<='$date_now'");
			$this->model_transaksi->custom_query("insert into data_shipping select * from shipping where date(date_time)<='$date_now'");
			$this->model_transaksi->custom_query("truncate table receiving");
			$this->model_transaksi->custom_query("truncate table shipping");
		}else{
			$this->model_transaksi->custom_query("insert into data_receiving select * from receiving where cust_model='0'");	
		}

		$data['chart']=$this->sm_model->get_data();
		$data['chart2']=$this->sm_model->get_data2();
		$data['receiving']=$this->model_transaksi->custom_query("select sum(quantity) as jml_receiving from receiving WHERE date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->jml_receiving;
		$data['shipping']=$this->model_transaksi->custom_query("select sum(quantity) as jml_shipping from shipping WHERE date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->jml_shipping;
		$data['stock_akhir']=$this->model_transaksi->custom_query("select sum(stock) as jml_stock from master_database")->row()->jml_stock;			
		$data['result_receiving']=$this->model_transaksi->custom_query("select * from receiving order by date_time desc limit 5");
		$data['result_shipping']=$this->model_transaksi->custom_query("select * from shipping order by date_time desc limit 5");
		$this->template->load('template1','dashboard',$data);
	}

	public function dashboard2(){
		$data['username']=$this->session->userdata['username'];

		$tanggal=date('Y-m-d H:i:s');
		
		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$date_now=date('Y-m-d');
		$date_yesterday=date('Y-m-d',strtotime("-1 day"));

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');

			$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
			$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");

		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));

			$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now' and date_format(date,'%Y-%m-%d')<>'$date_yesterday'")->row()->date;
			$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' and date_format(date,'%Y-%m-%d')<>'$date_yesterday'");
		}

		$now=date('Y-m-d');

		$rec=$this->model_transaksi->custom_query("select sum(quantity) as rec from receiving where date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->rec;
		$shi=$this->model_transaksi->custom_query("select sum(quantity) as shi from shipping where date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->shi;
		$sto=$this->model_transaksi->custom_query("select sum(stock) as total from master_database")->row()->total;
		$stc=($rec - $shi) + $sto; 
		
		$data1=array(
			'stock_awal'=>$sto,
			'receiving'=>$rec,
			'shipping'=>$shi,
			'stock_akhir'=>$stc
		);

		if($tanggal<=$date1 && $tanggal>=$start){
			$update_stock=$this->model_transaksi->update("stok", $data1, "date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'");
		}else{
			$update_stock=$this->model_transaksi->update("stok", $data1, "date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'");
		}

		$waktu=date('H:i:s');
		$waktu2=date('H:i:s');
		$trans=date('06:30:01');
		$trans2=date('06:30:10');
		//catatan : setiap pukul 06.30 tunggu sampai pukul 06.31 baru mulai pergunakan barcode scanner.
		if($waktu>=$trans && $waktu<=$trans2){
			$this->model_transaksi->custom_query("insert into data_receiving select * from receiving where date(date_time)<='$date_now'");
			$this->model_transaksi->custom_query("insert into data_shipping select * from shipping where date(date_time)<='$date_now'");
			$this->model_transaksi->custom_query("truncate table receiving");
			$this->model_transaksi->custom_query("truncate table shipping");
		}else{
			$this->model_transaksi->custom_query("insert into data_receiving select * from receiving where cust_model='0'");	
		}

		$data['chart']=$this->sm_model->get_data();
		$data['chart2']=$this->sm_model->get_data2();
		$data['receiving']=$this->model_transaksi->custom_query("select sum(quantity) as jml_receiving from receiving WHERE date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->jml_receiving;
		$data['shipping']=$this->model_transaksi->custom_query("select sum(quantity) as jml_shipping from shipping WHERE date_format(date_time,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date'")->row()->jml_shipping;
		$data['stock_akhir']=$this->model_transaksi->custom_query("select sum(stock) as jml_stock from master_database")->row()->jml_stock;			
		$data['result_receiving']=$this->model_transaksi->custom_query("select * from receiving order by date_time desc limit 5");
		$data['result_shipping']=$this->model_transaksi->custom_query("select * from shipping order by date_time desc limit 5");
		$this->template->load('template2','dashboard',$data);
	}

	public function export(){
		$data['username']=$this->session->userdata['username'];
		$file_name=date('Y-m-d');
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename={$file_name}");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		$data=array(
		// define your selfe
		);
		$this->load->view("view_name", $data);
	}
	
	public function opnameexcel(){
		$data['username']=$this->session->userdata['username'];
		$this->template->load('template1','opname',$data);	
	}
	
	public function preview_opnameexcel(){
		$data=array();

		if(isset($_POST['preview'])){

			$upload=$this->sm_model->upload_file($this->filename);

			if($upload['result']=="success"){ 

				include APPPATH.'third_party/PHPExcel/PHPExcel.php';

				$excelreader=new PHPExcel_Reader_Excel2007();
				$loadexcel=$excelreader->load('excel/'.$this->filename.'.xlsx');
				$sheet=$loadexcel->getActiveSheet()->toArray(null, true, true ,true);

				$data['sheet']=$sheet; 
			}else{
				$data['upload_error']=$upload['error']; 
			}
		}
		$data['username']=$this->session->userdata['username'];
		$this->template->load('template1','opname',$data);
	}

	public function importopname(){
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';

		$excelreader=new PHPExcel_Reader_Excel2007();
		$loadexcel=$excelreader->load('excel/'.$this->filename.'.xlsx');
		$sheet=$loadexcel->getActiveSheet()->toArray(null, true, true ,true);

		$data=[];

		$numrow=1;
		foreach($sheet as $row){

			if($numrow > 1){

				array_push($data, [
					'original_barcode'=>$row['A'],
					'brand'=>$row['B'],
					'color'=>$row['C'],
					'size'=>$row['D'],
					'four_digit'=>$row['E'],
					'unit'=>$row['F'],
					'quantity'=>$row['G'],
					'customer'=>$row['H'],
					'cust_model'=>$row['I'],
					'model_code'=>$row['J'],
					'tooling_code'=>$row['K'],
					'stock'=>$row['L'],
				]);
			}

			$numrow++;
		}

		$this->sm_model->update_multiple($data);
		redirect("stock_monitoring/master");
	}
}