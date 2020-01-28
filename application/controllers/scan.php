<?php
class Scan extends CI_controller{
	public function __construct(){
		parent:: __construct();
		if($this->session->userdata['username']==""){
			echo '<script>alert(\'Silakan Login Terlebih Dahulu\');document.location=\''.base_url('login/home').'\'</script>';
		}
		$this->load->library('datatables');
	}
	
	//get all data barcode by JSON object
	function get_guest_json() {
		header('Content-Type: application/json');
		echo $this->m_scan->get_all_rec();
	}
	
	function get_guest_json_2() {
		header('Content-Type: application/json');
		echo $this->m_scan->get_all_shi();
	}
	
	//get data barcode for receiving
	function get_barcode(){
		$date=$this->input->get('date');
		$scan=$this->input->get('scan');
		$user=$this->input->get('user');
		$data=$this->m_scan->get_data_rec($date,$scan,$user);
		echo json_encode($data);
	}
	
	//get data barcode for shipping
	function get_barcode_2(){
		$date=$this->input->get('date');
		$scan=$this->input->get('scan');
		$user=$this->input->get('user');
		$data=$this->m_scan->get_data_shi($date,$scan,$user);
		echo json_encode($data);
	}
	
	//get all code
	function get_code(){
		$barcode=$this->input->post('barcode');
		$data=$this->sm_model->get_data_by_barcode($barcode);
		echo json_encode($data);
	}
	
	//function edit receiving
	function edit_rec(){
		$date=$this->input->post('date_edit');
		$scan=$this->input->post('scan_edit');
		$user=$this->input->post('username_edit');
		$data=array(
			'original_barcode'	=> $this->input->post('barcode_edit'),
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
			'scan_no'			=> $this->input->post('scan_edit'),
			'username'			=> $this->input->post('username_edit')
		);
		$this->db->where('date_time',$date);
		$this->db->where('scan_no',$scan);
		$this->db->where('username',$user);
		$this->db->update('receiving',$data);
		$this->session->set_flashdata
		('msg','<div class="alert bg-blue alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Diperbarui
			</div>');
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->m_scan->fetchdatar2();
		$this->template->load('template1', 'view_scanr2', $data);
	}
	
	//function edit shipping
	function edit_shi(){
		$date=$this->input->post('date_edit');
		$scan=$this->input->post('scan_edit');
		$user=$this->input->post('username_edit');
		$data=array(
			'original_barcode'	=> $this->input->post('barcode_edit'),
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
			'scan_no'			=> $this->input->post('scan_edit'),
			'username'			=> $this->input->post('username_edit')
		);
		$this->db->where('date_time',$date);
		$this->db->where('scan_no',$scan);
		$this->db->where('username',$user);
		$this->db->update('shipping',$data);
		$this->session->set_flashdata
		('msg','<div class="alert bg-blue alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Diperbarui
			</div>');
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->m_scan->fetchdatar2();
		$this->template->load('template1', 'view_scans2', $data);
	}
	
	//function delete receiving
	function delete_rec(){
		$date=$this->input->post('date');
		$scan=$this->input->post('scan');
		$user=$this->input->post('user');
		$this->db->where('date_time',$date);
		$this->db->where('scan_no',$scan);
		$this->db->where('username',$user);
		$this->db->delete('receiving');
		$this->session->set_flashdata
		('msg','<div class="alert bg-orange alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Dihapus
			</div>');
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->m_scan->fetchdatar2();
		$this->template->load('template1', 'view_scanr2', $data);
	}
	
	//function delete shipping
	function delete_shi(){
		$date=$this->input->post('date');
		$scan=$this->input->post('scan');
		$user=$this->input->post('user');
		$this->db->where('date_time',$date);
		$this->db->where('scan_no',$scan);
		$this->db->where('username',$user);
		$this->db->delete('shipping');
		$this->session->set_flashdata
		('msg','<div class="alert bg-orange alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
			Data Berhasil Dihapus
			</div>');
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->m_scan->fetchdatar2();
		$this->template->load('template1', 'view_scans2', $data);
	}
	
	//halaman receiving	
	public function viewscanreceiving(){
		$data['username']=$this->session->userdata['username'];
		$username=$this->session->userdata['username'];
		$data['detail']=$this->m_scan->fetchdatar();
		$this->template->load('template3', 'view_scanr', $data);
	}
	
	//halaman receiving IT
	public function viewscanreceiving2(){
		$data['username']=$this->session->userdata['username'];
		$data['detail']=$this->m_scan->fetchdatar2();
		$this->template->load('template1', 'view_scanr2', $data);
	}
	
	//halaman shipping
	public function viewscanshipping(){
		$data['username']=$this->session->userdata['username'];
		$data['detail1']=$this->m_scan->fetchdatas();
		$this->template->load('template4', 'view_scans', $data);
	}
	
	//halaman shipping IT
	public function viewscanshipping2(){
		$data['username']=$this->session->userdata['username'];
		$data['detail1']=$this->m_scan->fetchdatas2();
		$this->template->load('template1', 'view_scans2', $data);
	}
	
	public function getscanr(){
		$data['username']=$this->session->userdata['username'];
		$user=$this->session->userdata['username'];
		$tanggal=date('Y-m-d H:i:s');

		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');
		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));
		}

		$date=date('Y-m-d H:i:s');
		$date_now=date('Y-m-d');
		$date_kemarin=date('Y-m-d',strtotime("-1 day"));
		$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
		$maxdate=date('Y-m-d',strtotime($max_date));

		$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date' limit 1");
		if($stok->num_rows()>0){
			foreach($stok->result() as $row){
				$stock_awal= $row->stock_awal;
				$receiving=$row->receiving;
				$shipping=$row->shipping;
				$stock_akhir=$row->stock_akhir;
				$date=$row->date;
			}
		}else{
			$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date_before' and '$end_date_before' limit 1");
			if($stok->num_rows()>0){
				foreach($stok->result() as $row){
					$stok_awal=$row->stock_akhir;
				}
			}elseif($stok->num_rows()==0){
				$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");
				if($cek_data->num_rows()!=0){
					$stok_awal=$this->model_transaksi->custom_query("select stock_akhir as stock_akhir from stok WHERE date_format(date,'%Y-%m-%d')='$maxdate'")->row()->stock_akhir;
				}else{
					$stok_awal=0;	
				}
			}
			$data_stok=array(
				'stock_awal'=>$stok_awal,		
				'receiving'=>0,
				'shipping'=>0,
				'stock_akhir'=>$stok_awal,
				'date'=>$date
			);
			$q=$this->model_transaksi->insert('stok', $data_stok);
		}		
		$id=$_POST['barcode'];
		$this->db->where('original_barcode',$id);
		$query=$this->db->get('master_database');
		if ($query->num_rows()!=0)
		{
			$original_barcode=$this->m_scan->getoriginalbarcode($id);
			$brand=$this->m_scan->getbrand($id);
			$color=$this->m_scan->getcolor($id);
			$size=$this->m_scan->getsize($id);
			$four_digit=$this->m_scan->getfourdigit($id);
			$unit=$this->m_scan->getunit($id);
			$quantity=$this->m_scan->getquantity($id);
			$customer=$this->m_scan->getcustomer($id);
			$cust_model=$this->m_scan->getcustmodel($id);
			$model_code=$this->m_scan->getmodelcode($id);
			$tooling_code=$this->m_scan->gettoolingcode($id);
			$username=$user;
			$this->m_scan->generatereceiving($original_barcode, $brand, $color, $size, $four_digit, $unit, $quantity, $customer, $cust_model, $model_code, $tooling_code, $username);

			redirect('scan/viewscanreceiving/');
		}else{
			redirect('scan/viewscanreceiving/');
		}
	}

	public function getscans(){
		$data['username']=$this->session->userdata['username'];
		$user=$this->session->userdata['username'];
		$tanggal=date('Y-m-d H:i:s');

		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');
		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));
		}

		$date=date('Y-m-d H:i:s');
		$date_kemarin=date('Y-m-d',strtotime("-1 day"));
		$date_now=date('Y-m-d');
		$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
		$maxdate=date('Y-m-d',strtotime($max_date));		

		$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date' limit 1");
		if($stok->num_rows()>0){
			foreach($stok->result() as $row){
				$stock_awal= $row->stock_awal;
				$receiving=$row->receiving;
				$shipping=$row->shipping;
				$stock_akhir=$row->stock_akhir;
				$date=$row->date;
			}
		}else{

			$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date_before' and '$end_date_before' limit 1");
			if($stok->num_rows()>0){
				foreach($stok->result() as $row){
					$stok_awal=$row->stock_akhir;
				}
			}elseif($stok->num_rows()==0){
				$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");
				if($cek_data->num_rows()!=0){
					$stok_awal=$this->model_transaksi->custom_query("select stock_akhir as stock_akhir from stok WHERE date_format(date,'%Y-%m-%d')='$maxdate'")->row()->stock_akhir;
				}else{
					$stok_awal=0;	
				}
			}	

			$data_stok=array(
				'stock_awal'=>$stok_awal,		
				'receiving'=>0,
				'shipping'=>0,
				'stock_akhir'=>$stok_awal,
				'date'=>$date
			);

			$q=$this->model_transaksi->insert('stok', $data_stok);
		}		
		$id=$_POST['barcode'];
		$this->db->where('original_barcode',$id);
		$query=$this->db->get('master_database');
		if ($query->num_rows()!=0)
		{
			$original_barcode=$this->m_scan->getoriginalbarcode($id);
			$brand=$this->m_scan->getbrand($id);
			$color=$this->m_scan->getcolor($id);
			$size=$this->m_scan->getsize($id);
			$four_digit=$this->m_scan->getfourdigit($id);
			$unit=$this->m_scan->getunit($id);
			$quantity=$this->m_scan->getquantity($id);
			$customer=$this->m_scan->getcustomer($id);
			$cust_model=$this->m_scan->getcustmodel($id);
			$model_code=$this->m_scan->getmodelcode($id);
			$tooling_code=$this->m_scan->gettoolingcode($id);
			$username=$user;
			$this->m_scan->generateshipping($original_barcode, $brand, $color, $size, $four_digit, $unit, $quantity, $customer, $cust_model, $model_code, $tooling_code, $username);
			
			redirect('scan/viewscanshipping/');
		}else{
			redirect('scan/viewscanshipping/');
		}
	}

	public function getscanr2(){
		$data['username']=$this->session->userdata['username'];
		$user=$this->session->userdata['username'];
		$tanggal=date('Y-m-d H:i:s');

		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');
		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));
		}

		$date=date('Y-m-d H:i:s');
		$date_kemarin=date('Y-m-d',strtotime("-1 day"));
		$date_now=date('Y-m-d');
		$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
		$maxdate=date('Y-m-d',strtotime($max_date));
		
		// $field=array('*');
		$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date' limit 1");
		if($stok->num_rows()>0){
			foreach($stok->result() as $row){
				$stock_awal=$row->stock_awal;
				$receiving=$row->receiving;
				$shipping=$row->shipping;
				$stock_akhir=$row->stock_akhir;
				$date=$row->date;
			}
		}else{
			$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date_before' and '$end_date_before' limit 1");
			if($stok->num_rows()>0){
				foreach($stok->result() as $row){
					$stok_awal=$row->stock_akhir;
				}
			}elseif($stok->num_rows()==0){
				$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");
				if($cek_data->num_rows()!=0){
					$stok_awal=$this->model_transaksi->custom_query("select stock_akhir as stock_akhir from stok WHERE date_format(date,'%Y-%m-%d')='$maxdate'")->row()->stock_akhir;
				}else{
					$stok_awal=0;	
				}
			}
			$data_stok=array(
				'stock_awal'=>$stok_awal,		
				'receiving'=>0,
				'shipping'=>0,
				'stock_akhir'=>$stok_awal,
				'date'=>$date
			);

			$q=$this->model_transaksi->insert('stok', $data_stok);
		}		
		$id=$_POST['barcode'];
		$this->db->where('original_barcode',$id);
		$query=$this->db->get('master_database');
		if ($query->num_rows()!=0)
		{
			$original_barcode=$this->m_scan->getoriginalbarcode($id);
			$brand=$this->m_scan->getbrand($id);
			$color=$this->m_scan->getcolor($id);
			$size=$this->m_scan->getsize($id);
			$four_digit=$this->m_scan->getfourdigit($id);
			$unit=$this->m_scan->getunit($id);
			$quantity=$this->m_scan->getquantity($id);
			$customer=$this->m_scan->getcustomer($id);
			$cust_model=$this->m_scan->getcustmodel($id);
			$model_code=$this->m_scan->getmodelcode($id);
			$tooling_code=$this->m_scan->gettoolingcode($id);
			$username=$user;
			$this->m_scan->generatereceiving($original_barcode, $brand, $color, $size, $four_digit, $unit, $quantity, $customer, $cust_model, $model_code, $tooling_code, $username);
			
			$this->session->set_flashdata
			('msg','<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
				Data Berhasil Diinputkan
				</div>');
			redirect('scan/viewscanreceiving2/');
		}else{
			$this->session->set_flashdata
			('msg','<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
				Data Gagal Diinputkan
				</div>');
			redirect('scan/viewscanreceiving2/');
		} 	
	}

	public function getscans2(){
		$data['username']=$this->session->userdata['username'];
		$user=$this->session->userdata['username'];
		$tanggal=date('Y-m-d H:i:s');

		$date1=date('Y-m-d 23:59:59');
		$date2=date('Y-m-d 00:00:01');

		$start=date('Y-m-d 06:30:00');

		if($tanggal<=$date1 && $tanggal>=$start){
			$start_date=date('Y-m-d 06:30:00');
			$end_date=date('Y-m-d 06:29:59',strtotime("+1 day"));

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date_before=date('Y-m-d 06:29:59');
		}elseif ($tanggal>=$date2 && $tanggal<=$start) {
			$start_date=date('Y-m-d 06:30:00',strtotime("-1 day"));
			$end_date=date('Y-m-d 06:29:59');

			$start_date_before=date('Y-m-d 06:30:00',strtotime("-2 day"));
			$end_date_before=date('Y-m-d 06:29:59',strtotime("-1 day"));
		}

		$date=date('Y-m-d H:i:s');
		$date_kemarin=date('Y-m-d',strtotime("-1 day"));
		$date_now=date('Y-m-d');
		$max_date=$this->model_transaksi->custom_query("select max(date) as date from stok where date_format(date,'%Y-%m-%d')<>'$date_now'")->row()->date;
		$maxdate=date('Y-m-d',strtotime($max_date));
		
		// $field=array('*');
		$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date' and '$end_date' limit 1");
		if($stok->num_rows()>0){
			foreach($stok->result() as $row){
				$stock_awal=$row->stock_awal;
				$receiving=$row->receiving;
				$shipping=$row->shipping;
				$stock_akhir=$row->stock_akhir;
				$date=$row->date;
			}
		}else{
			$stok=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d %H:%i:%s') between '$start_date_before' and '$end_date_before' limit 1");
			if($stok->num_rows()>0){
				foreach($stok->result() as $row){
					$stok_awal=$row->stock_akhir;
				}
			}elseif($stok->num_rows()==0){
				$cek_data=$this->model_transaksi->custom_query("select * from stok where date_format(date,'%Y-%m-%d')<>'$date_now' ");
				if($cek_data->num_rows()!=0){
					$stok_awal=$this->model_transaksi->custom_query("select stock_akhir as stock_akhir from stok WHERE date_format(date,'%Y-%m-%d')='$maxdate'")->row()->stock_akhir;
				}else{
					$stok_awal=0;	
				}
			}	

			$data_stok=array(
				'stock_awal'=>$stok_awal,		
				'receiving'=>0,
				'shipping'=>0,
				'stock_akhir'=>$stok_awal,
				'date'=>$date
			);

			$q=$this->model_transaksi->insert('stok', $data_stok);
		}		
		$id=$_POST['barcode'];
		$this->db->where('original_barcode',$id);
		$query= $this->db->get('master_database');
		if ($query->num_rows()!=0)
		{
			$original_barcode=$this->m_scan->getoriginalbarcode($id);
			$brand=$this->m_scan->getbrand($id);
			$color=$this->m_scan->getcolor($id);
			$size=$this->m_scan->getsize($id);
			$four_digit=$this->m_scan->getfourdigit($id);
			$unit=$this->m_scan->getunit($id);
			$quantity=$this->m_scan->getquantity($id);
			$customer=$this->m_scan->getcustomer($id);
			$cust_model=$this->m_scan->getcustmodel($id);
			$model_code=$this->m_scan->getmodelcode($id);
			$tooling_code=$this->m_scan->gettoolingcode($id);
			$username=$user;
			$this->m_scan->generateshipping($original_barcode, $brand, $color, $size, $four_digit, $unit, $quantity, $customer, $cust_model, $model_code, $tooling_code, $username);

			$this->session->set_flashdata
			('msg','<div class="alert bg-green alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
				Data Berhasil Diinputkan
				</div>');
			redirect('scan/viewscanshipping2/');
		}else{
			$this->session->set_flashdata
			('msg','<div class="alert bg-red alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
				Data Gagal Diinputkan
				</div>');
			redirect('scan/viewscanshipping2/');
		}
	}
}