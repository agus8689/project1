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
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h3 align="center">TRANSACTION STOCK</h3>
				</div>
				<table class="table table-bordered table-fixed">
					<a href="<?php echo site_url()."stock_monitoring/ekspor_stock_report1"?>"><button class="btn btn-default pull-right"><span class="glyphicon glyphicon-print"></span> Print</button></a>
				</table>
				<div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div> 
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed" id="mytable">
							<thead>
								<tr class="info">
									<th>TANGGAL</th>
									<th>STOCK AWAL</th>
									<th>RECEIVING</th>
									<th>SHIPPING</th>
									<th>STOCK AKHIR</th>
									<th width="100">ACTION</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				
				<!-- modal edit transaction -->
				<form id="add-row-form" action="<?php echo base_url().'stock_monitoring/edit_transaction'?>" method="post">
					<div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Edit Transaction</h2>
								</div>
								<div class="row" style="padding:25px">
									<div class="col-md-6">
										<div class="form-group">
											<label for="barcode">No:</label>
											<input type="text" name="no_edit" class="form-control" placeholder="No" maxlength="15" readonly required>
										</div>
										<div class="form-group">
											<label for="brand">Tanggal:</label>
											<input type="text" name="tanggal_edit" class="form-control" placeholder="Tanggal" maxlength="15" readonly required>
										</div>				 
										<div class="form-group">
											<label for="color">Stock Awal:</label>
											<input type="text" name="awal_edit" class="form-control" placeholder="Stock Awal" maxlength="15" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="size">Receiving:</label>
											<input type="text" name="receiving_edit" class="form-control" placeholder="Receiving" maxlength="15" required>
										</div>
										<div class="form-group">
											<label for="digit">Shipping:</label>
											<input type="text" name="shipping_edit" class="form-control" placeholder="Shipping" maxlength="15" required>
										</div>				 
										<div class="form-group">
											<label for="unit">Stock Akhir:</label>
											<input type="text" name="akhir_edit" class="form-control" placeholder="Stock Akhir" maxlength="15" required>
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
				
				<!-- modal delete transaction -->
				<form id="add-row-form" action="<?php echo base_url().'stock_monitoring/delete_transaction'?>" method="post">
					<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Delete Transaction</h2>
								</div>
								<div class="modal-body">
									<input type="hidden" name="no" class="form-control" placeholder="No" required>
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
			ajax: {"url": "<?php echo base_url().'stock_monitoring/get_json_trans'?>", "type": "POST"},
			columns: [
			{"data": "date"},
			{"data": "stock_awal"},
			{"data": "receiving"},
			{"data": "shipping"},
			{"data": "stock_akhir"},
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
		
		//get edit transaction
		$('#mytable').on('click','.edit_record',function(){
			var no=$(this).data('no');
			$.ajax({
				type : "GET",
				url  : "<?php echo base_url('stock_monitoring/get_trans')?>",
				dataType : "JSON",
				data : {no:no},
				success: function(data){
					$.each(data,function(no, stock_awal, receiving, shipping, stock_akhir, date){
						$('#ModalUpdate').modal('show');
						$('[name="no_edit"]').val(data.no);
						$('[name="awal_edit"]').val(data.stock_awal);
						$('[name="receiving_edit"]').val(data.receiving);
						$('[name="shipping_edit"]').val(data.shipping);
						$('[name="akhir_edit"]').val(data.stock_akhir);
						$('[name="tanggal_edit"]').val(data.date);
					});
				}
			});
			return false;
		});
		//end get transaction
		
		//get delete transaction
		$('#mytable').on('click','.hapus_record',function(){
			var no=$(this).data('no');
			$('#ModalHapus').modal('show');
			$('[name="no"]').val(no);
		});
		//end get delete transaction
	});
</script>

</div>
</div>
</div>  		
</body>
</html>	