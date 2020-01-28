<html>
<head>
	<title>PT HANDAL SUKSES KARYA</title>
	<style type="text/css">
		.table-wrapper-scroll-y {
			display: block;
			max-height: 550px;
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
	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">  
					<h3 align="center">MASTER DATA</h3>
					<button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalAdd">Add Barcode</button>
					<a href="<?php echo base_url();?>stock_monitoring/opnameexcel"><button class="btn btn-success btn-lg">Stock Opname Using Excel</button></a>
					<a href="<?php echo base_url();?>stock_monitoring/print_excel_master"><button class="btn btn-success btn-lg pull-right" style="margin-left:5px;">Report Excel</button></a>
					<a href="<?php echo base_url();?>excel/format.xlsx"><button class="btn btn-success btn-lg pull-right">Format Excel</button></a>
				</div>
				<br></br>
				<div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div> 
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed" id="mytable">
							<thead>
								<tr class="info">
									<th>ORIGINAL BARCODE</th>
									<th>BRAND</th>
									<th>COLOR</th>
									<th>SIZE</th>
									<th>FOUR DIGIT</th>
									<th>UNIT</th>
									<th>QUANTITY</th>
									<th>CUSTOMER</th>
									<th>CUSTOMER MODEL</th>
									<th>MODEL CODE</th>
									<th>TOOLING CODE</th>
									<th>STOCK</th>
									<th width="100">ACTION</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				
				<!-- modal add data -->
				<form id="add-row-form" action="<?php echo base_url().'stock_monitoring/save_barcode'?>" method="post">
					<div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Add Barcode</h2>
								</div>
								<div class="row" style="padding:25px">
									<div class="col-md-6">
										<div class="form-group">
											<label for="barcode">Original Barcode:</label>
											<input type="text" name="barcode" class="form-control" placeholder="Original Barcode" maxlength="15" required>
										</div>
										<div class="form-group">
											<label for="brand">Brand:</label>
											<input type="text" name="brand" class="form-control" placeholder="Brand" maxlength="11" required>
										</div>				 
										<div class="form-group">
											<label for="color">Color:</label>
											<input type="text" name="color" class="form-control" placeholder="Color" maxlength="25" required>
										</div>
										<div class="form-group">
											<label for="size">Size:</label>
											<input type="text" name="size" class="form-control" placeholder="Size" maxlength="6" required>
										</div>
										<div class="form-group">
											<label for="digit">Four Digit:</label>
											<input type="text" name="digit" class="form-control" placeholder="Four Digit" maxlength="4" required>
										</div>				 
										<div class="form-group">
											<label for="unit">Unit:</label>
											<input type="text" name="unit" class="form-control" placeholder="Unit" maxlength="3" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="quantity">Quantity:</label>
											<input type="text" name="quantity" class="form-control" placeholder="Quantity" maxlength="7" required>
										</div>
										<div class="form-group">
											<label for="customer">Customer:</label>
											<input type="text" name="customer" class="form-control" placeholder="Customer" maxlength="30" required>
										</div>				 
										<div class="form-group">
											<label for="cust">Customer Model:</label>
											<input type="text" name="cust" class="form-control" placeholder="Customer Model" maxlength="30" required>
										</div>
										<div class="form-group">
											<label for="model">Model Code:</label>
											<input type="text" name="model" class="form-control" placeholder="Model Code" maxlength="3" required>
										</div>
										<div class="form-group">
											<label for="tooling">Tooling Code:</label>
											<input type="text" name="tooling" class="form-control" placeholder="Tooling Code" maxlength="6" required>
										</div>				 
										<div class="form-group">
											<label for="stock">Stock:</label>
											<input type="text" name="stock" class="form-control" placeholder="Stock" value="0" maxlength="7" required readonly>
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
				
				<!-- modal edit data -->
				<form id="add-row-form" action="<?php echo base_url().'stock_monitoring/edit_barcode'?>" method="post">
					<div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Edit Barcode</h2>
								</div>
								<div class="row" style="padding:25px">
									<div class="col-md-6">
										<div class="form-group">
											<label for="barcode">Original Barcode:</label>
											<input type="text" name="barcode_edit" class="form-control" placeholder="Original Barcode" maxlength="15" readonly required>
										</div>
										<div class="form-group">
											<label for="brand">Brand:</label>
											<input type="text" name="brand_edit" class="form-control" placeholder="Brand" maxlength="11" required>
										</div>				 
										<div class="form-group">
											<label for="color">Color:</label>
											<input type="text" name="color_edit" class="form-control" placeholder="Color" maxlength="25" required>
										</div>
										<div class="form-group">
											<label for="size">Size:</label>
											<input type="text" name="size_edit" class="form-control" placeholder="Size" maxlength="6" required>
										</div>
										<div class="form-group">
											<label for="digit">Four Digit:</label>
											<input type="text" name="digit_edit" class="form-control" placeholder="Four Digit" maxlength="4" required>
										</div>				 
										<div class="form-group">
											<label for="unit">Unit:</label>
											<input type="text" name="unit_edit" class="form-control" placeholder="Unit" maxlength="3" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="quantity">Quantity:</label>
											<input type="text" name="quantity_edit" class="form-control" placeholder="Quantity" maxlength="7" required>
										</div>
										<div class="form-group">
											<label for="customer">Customer:</label>
											<input type="text" name="customer_edit" class="form-control" placeholder="Customer" maxlength="30" required>
										</div>				 
										<div class="form-group">
											<label for="cust">Customer Model:</label>
											<input type="text" name="cust_edit" class="form-control" placeholder="Customer Model" maxlength="30" required>
										</div>
										<div class="form-group">
											<label for="model">Model Code:</label>
											<input type="text" name="model_edit" class="form-control" placeholder="Model Code" maxlength="3" required>
										</div>
										<div class="form-group">
											<label for="tooling">Tooling Code:</label>
											<input type="text" name="tooling_edit" class="form-control" placeholder="Tooling Code" maxlength="6" required>
										</div>				 
										<div class="form-group">
											<label for="stock">Stock:</label>
											<input type="text" name="stock_edit" class="form-control" placeholder="Stock" maxlength="7" required>
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
				
				<!-- modal delete data -->
				<form id="add-row-form" action="<?php echo base_url().'stock_monitoring/delete_barcode'?>" method="post">
					<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Delete Barcode</h2>
								</div>
								<div class="modal-body">
									<input type="hidden" name="barcode" class="form-control" placeholder="Original Barcode" required>
									<strong>Anda yakin mau menghapus barcode ini?</strong>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button type="submit" id="add-row" class="btn btn-success">Delete</button>
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
			ajax: {"url": "<?php echo base_url().'stock_monitoring/get_guest_json'?>", "type": "POST"},
			columns: [
			{"data": "original_barcode"},
			{"data": "brand"},
			{"data": "color"},
			{"data": "size"},
			{"data": "four_digit"},
			{"data": "unit"},
			{"data": "quantity"},
			{"data": "customer"},
			{"data": "cust_model"},
			{"data": "model_code"},
			{"data": "tooling_code"},
			{"data": "stock"},
			{"data": "view"}
			],
			order: [[0, 'asc']],
			rowCallback: function(row, data, iDisplayIndex) {
				var info=this.fnPagingInfo();
				var page=info.iPage;
				var length=info.iLength;
				$('td:eq(0)', row).html();
			}

		});
		//end setup datatables
		
		//get edit barcode
		$('#mytable').on('click','.edit_record',function(){
			var barcode=$(this).data('barcode');
			$.ajax({
				type : "GET",
				url  : "<?php echo base_url('stock_monitoring/get_barcode')?>",
				dataType : "JSON",
				data : {barcode:barcode},
				success: function(data){
					$.each(data,function(original_barcode, brand, color, size, four_digit, unit, quantity, customer, cust_model, model_code, tooling_code, stock){
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
						$('[name="stock_edit"]').val(data.stock);
					});
				}
			});
			return false;
		});
		//end get edit barcode
		
		//get delete barcode
		$('#mytable').on('click','.hapus_record',function(){
			var barcode=$(this).data('barcode');
			$('#ModalHapus').modal('show');
			$('[name="barcode"]').val(barcode);
		});
		//end get delete barcode
	});
</script>

</div>
</div>
</div>
</body>
</html>
