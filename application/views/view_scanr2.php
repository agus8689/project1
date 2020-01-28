<html>
<head>
	<title>PT HANDAL SUKSES KARYA</title>
	<style type="text/css">
		.table-wrapper-scroll-y {
			display: block;
			max-height: 400px;
			overflow-y: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}
	</style>
	<script>   
		$('#notifications').slideDown('slow').slideUp('slow');
	</script>
	<style type="text/css">
		#notifications {
			cursor: pointer;
			position: fixed;
			left: 900px;
			top: 450px;
			z-index: 9999;
		}
	</style>
</head>
<body>
	<?php $array_hari=array(1=>'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	$hari=$array_hari[date('N')]; ?>
	<?php $tipe="receiving" ?>
	<?php $hari1=date('d-m-Y') ?>
	<?php $jam=date('G:i:s') ?>
	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">  
					<h3 align="center">SCAN RECEIVING</h3>
					<div class="form-group" align="center">
						<div class="form-group">
							<div align="center col-lg-">
								<button type="button" class="btn btn-default">
									<i class="material-icons">date_range</i>
									<span><?php echo $hari.' '.date('Y-m-d') ?></span>
								</button>
								<button type="button" class="btn btn-default">
									<i class="material-icons">access_alarm</i>
									<span><?php echo date('h:i A') ?></span>
								</button>
							</div>				
						</div>
					</div>
				</div>	
				<div class="header" style="background-color: #8BC34A ">
					<form method="POST" action="<?php echo site_url('scan/getscanr2');?>">	
						<div class="col-lg-12"> 
							<div class="col-lg-4">   
								<div class="form-group" style="background-color: #8BC34A" align="right" >
									<label style="color:white">Scan</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group">
									<input type="text" name="barcode" maxlength="15" size="30" class="form-control" required autocomplete="off" autofocus="autofocus" width="10%">
								</div>
							</div>
							<div class="col-lg-4"></div> 	  
						</div><br/>   
					</form><br/>
				</div>
				<div class="col-md-12">
					<a href="<?php echo site_url()."stock_monitoring/ekspor2/$tipe/$hari1/$jam"?>"><button class="btn btn-default pull-right"><span class="glyphicon glyphicon-save-file"></span> Print Report</button></a>
					<button class="btn btn-default pull-right" data-toggle="modal" data-target="#ModalPindah"><span class="glyphicon glyphicon-open"></span> Move Data</button>
				</div>
				<br/>
				<br/>
				<br/>
				<div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div> 
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed" id="mytable">
							<thead>
								<tr class="success">
									<th>DATE/TIME</th>
									<th>BRAND</th>
									<th>MODEL</th>
									<th>COLOR</th>
									<th>SIZE</th>
									<th>QUANTITY</th>
									<th>USER</th>
									<th>SCAN NO</th>
									<th width="100">ACTION</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				
				<!-- modal edit receiving -->
				<form id="add-row-form" action="<?php echo base_url().'scan/edit_rec'?>" method="post">
					<div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Edit Receiving</h2>
								</div>
								<div class="row" style="padding:25px">
									<div class="col-md-6">
										<div class="form-group">
											<label for="barcode">Original Barcode:</label>
											<input type="text" name="barcode_edit" id="barcode" class="form-control" placeholder="Original Barcode" maxlength="15" required>
										</div>
										<div class="form-group">
											<label for="brand">Brand:</label>
											<input type="text" name="brand_edit" class="form-control" placeholder="Brand" maxlength="11" readonly required>
										</div>				 
										<div class="form-group">
											<label for="color">Color:</label>
											<input type="text" name="color_edit" class="form-control" placeholder="Color" maxlength="25" readonly required>
										</div>
										<div class="form-group">
											<label for="size">Size:</label>
											<input type="text" name="size_edit" class="form-control" placeholder="Size" maxlength="6" readonly required>
										</div>
										<div class="form-group">
											<label for="digit">Four Digit:</label>
											<input type="text" name="digit_edit" class="form-control" placeholder="Four Digit" maxlength="4" readonly required>
										</div>				 
										<div class="form-group">
											<label for="unit">Unit:</label>
											<input type="text" name="unit_edit" class="form-control" placeholder="Unit" maxlength="3" readonly required>
										</div>
										<div class="form-group">
											<label for="quantity">Quantity:</label>
											<input type="text" name="quantity_edit" class="form-control" placeholder="Quantity" maxlength="7" readonly required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="customer">Customer:</label>
											<input type="text" name="customer_edit" class="form-control" placeholder="Customer" maxlength="30" readonly required>
										</div>				 
										<div class="form-group">
											<label for="cust">Customer Model:</label>
											<input type="text" name="cust_edit" class="form-control" placeholder="Customer Model" maxlength="20" readonly required>
										</div>
										<div class="form-group">
											<label for="model">Model Code:</label>
											<input type="text" name="model_edit" class="form-control" placeholder="Model Code" maxlength="3" readonly required>
										</div>
										<div class="form-group">
											<label for="tooling">Tooling Code:</label>
											<input type="text" name="tooling_edit" class="form-control" placeholder="Tooling Code" maxlength="6" readonly required>
										</div>				 
										<div class="form-group">
											<label for="Date">Date Time:</label>
											<input type="text" name="date_edit" class="form-control" placeholder="Date" maxlength="10" readonly required>
										</div>
										<div class="form-group">
											<label for="scan">Scan No:</label>
											<input type="text" name="scan_edit" class="form-control" placeholder="Scan No" maxlength="6" readonly required>
										</div>
										<div class="form-group">
											<label for="username">Username:</label>
											<input type="text" name="username_edit" class="form-control" placeholder="Username" maxlength="10" readonly required>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" id="add-row" class="btn btn-success">Save</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<!-- modal delete receiving -->
				<form id="add-row-form" action="<?php echo base_url().'scan/delete_rec'?>" method="post">
					<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Delete Receiving</h2>
								</div>
								<div class="modal-body">
									<input type="hidden" name="date" class="form-control" placeholder="Original Barcode" required>
									<input type="hidden" name="scan" class="form-control" placeholder="Scan No" required>
									<input type="hidden" name="user" class="form-control" placeholder="Username" required>
									<strong>Anda yakin mau menghapus transaksi ini?</strong>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" id="add-row" class="btn btn-success">Delete</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<!-- modal pindah receiving -->
				<form id="add-row-form" action="<?php echo base_url().'stock_monitoring/mover/'?>" method="post">
					<div class="modal fade" id="ModalPindah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Move Receiving</h2>
								</div>
								<div class="modal-body">
									<strong>Anda yakin mau memindahkan semua data transaksi?</strong>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" id="add-row" class="btn btn-success">Move</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<!-- load jquery -->	
				<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
				<script src="<?php echo base_url();?>assets/js/pages/tables/jquery-datatable.js"></script>
				
				<script>
					$(document).ready(function(){
		//setup datatables
		$.fn.dataTableExt.oApi.fnPagingInfo=function(oSettings)
		{
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		var table=$("#mytable").dataTable({
			initComplete: function() {
				var api=this.api();
				$('#mytable_filter input')
				.off('.DT')
				.on('input.DT', function() {
					api.search(this.value).draw();
				});
			},
			oLanguage: {
				sProcessing: "loading..."
			},
			processing: true,
			serverSide: true,
			ajax: {"url": "<?php echo base_url().'scan/get_guest_json'?>", "type": "POST"},
			columns: [
			{"data": "date_time"},
			{"data": "brand"},
			{"data": "cust_model"},
			{"data": "color"},
			{"data": "size"},
			{"data": "quantity"},
			{"data": "username"},
			{"data": "scan_no"},
			{"data": "view"}
			],
			order: [[0, 'desc']],
			rowCallback: function(row, data, iDisplayIndex) {
				var info=this.fnPagingInfo();
				var page=info.iPage;
				var length=info.iLength;
				$('td:eq(0)', row).html();
			}

		});
		//end setup datatables
		
		//get edit receiving
		$('#mytable').on('click','.edit_record',function(){
			var date=$(this).data('date');
			var scan=$(this).data('scan');
			var user=$(this).data('user');
			$.ajax({
				type : "GET",
				url  : "<?php echo base_url('scan/get_barcode')?>",
				dataType : "JSON",
				data : {date:date, scan:scan, user:user},
				success: function(data){
					$.each(data,function(original_barcode, brand, color, size, four_digit, unit, quantity, customer, cust_model, model_code, tooling_code, date_time, scan_no, username){
						$('#ModalUpdate').modal('show');
						$('[name="barcode_edit"]').val(data.original_barcode);
						$('[name="brand_edit"]').val(data.brand);
						$('[name="color_edit"]').val(data.color);
						$('[name="size_edit"]').val(data.size);
						$('[name="digit_edit"]').val(data.four_digit);
						$('[name="unit_edit"]').val(data.unit);
						$('[name="quantity_edit"]').val(data.quantity);
						$('[name="customer_edit"]').val(data.customer);
						$('[name="cust_edit"]').val(data.cust_model);
						$('[name="model_edit"]').val(data.model_code);
						$('[name="tooling_edit"]').val(data.tooling_code);
						$('[name="date_edit"]').val(data.date_time);
						$('[name="scan_edit"]').val(data.scan_no);
						$('[name="username_edit"]').val(data.username);
					});
				}
			});
			return false;
		});
		//end get receiving
		
		//get delete receiving
		$('#mytable').on('click','.hapus_record',function(){
			var date=$(this).data('date');
			var scan=$(this).data('scan');
			var user=$(this).data('user');
			$('#ModalHapus').modal('show');
			$('[name="date"]').val(date);
			$('[name="scan"]').val(scan);
			$('[name="user"]').val(user);
		});
		//end get delete receiving
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#barcode').on('input',function(){  
			var barcode=$(this).val();
			$.ajax({
				type : "POST",
				url  : "<?php echo base_url('scan/get_code')?>",
				dataType : "JSON",
				data : {barcode: barcode},
				cache:false,
				success: function(data){
					$.each(data,function(original_barcode, brand, color, size, four_digit, unit, quantity, customer, cust_model, model_code, tooling_code){
						$('[name="brand_edit"]').val(data.brand);
						$('[name="color_edit"]').val(data.color);
						$('[name="size_edit"]').val(data.size);
						$('[name="digit_edit"]').val(data.four_digit);
						$('[name="unit_edit"]').val(data.unit);
						$('[name="quantity_edit"]').val(data.quantity);
						$('[name="customer_edit"]').val(data.customer);
						$('[name="cust_edit"]').val(data.cust_model);
						$('[name="model_edit"]').val(data.model_code);
						$('[name="tooling_edit"]').val(data.tooling_code);
					});
					
				}
			});
			return false;
		});
	});
</script>

</div>
</div>
</div>
</body>
</html>	