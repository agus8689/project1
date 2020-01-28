<html>
<head>
	<title>PT HANDAL SUKSES KARYA</title>
	<style type="text/css">
		.table-wrapper-scroll-y {
			display: block;
			max-height: 500px;
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
					<h3 align="center">DATA USER</h3>
					<button class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalAdd">Add User</button>
				</div>
				<br>
				<br>
				<div id="notifications"><?php echo $this->session->flashdata('msg'); ?></div> 
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed" id="mytable">
							<thead>
								<tr class="info">
									<th>ID USER</th>
									<th>POSISI</th>
									<th>USERNAME</th>
									<th>PASSWORD</th>
									<th width="100">ACTION</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
				
				<!-- modal add data -->
				<form id="add-row-form" action="<?php echo base_url().'user/save_user'?>" method="post">
					<div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Add User</h2>
								</div>
								<div class="row" style="padding:25px">
									<div class="col-md-6">
										<div class="form-group">
											<label for="id_user">ID User:</label>
											<input type="text" name="id_user" class="form-control" placeholder="ID User" maxlength="7" required>
										</div>
										<div class="form-group">
											<label for="posisi">Posisi:</label>
											<select class="form-control" name="posisi">
												<option value="">Pilih Posisi</option>
												<option value="manajemen">manajemen</option>
												<option value="monitor">monitor</option>
												<option value="it">it</option>
												<option value="receiving">receiving</option>
												<option value="shipping">shipping</option>
											</select>
										</div>				 
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="username">Username:</label>
											<input type="text" name="username" class="form-control" placeholder="Username" maxlength="15" required>
										</div>
										<div class="form-group">
											<label for="password">Password:</label>
											<input type="password" name="password" class="form-control" placeholder="Password" maxlength="10" required>
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
				<form id="add-row-form" action="<?php echo base_url().'user/edit_user'?>" method="post">
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
											<label for="id_user">ID User:</label>
											<input type="text" name="id_user_edit" class="form-control" placeholder="ID User" maxlength="7" readonly required>
										</div>
										<div class="form-group">
											<label for="posisi_edit">Posisi:</label>
											<select class="form-control" name="posisi_edit">
												<option value="">Pilih Posisi</option>
												<option value="manajemen">manajemen</option>
												<option value="monitor">monitor</option>
												<option value="it">it</option>
												<option value="receiving">receiving</option>
												<option value="shipping">shipping</option>
											</select>
										</div>				 
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="username">Username:</label>
											<input type="text" name="username_edit" class="form-control" placeholder="Username" maxlength="15" required>
										</div>
										<div class="form-group">
											<label for="password">Password:</label>
											<input type="password" name="password_edit" class="form-control" placeholder="Password" maxlength="10" required>
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
				<form id="add-row-form" action="<?php echo base_url().'user/delete_user'?>" method="post">
					<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h2 class="modal-title" align="center" id="myModalLabel">Delete Barcode</h2>
								</div>
								<div class="modal-body">
									<input type="hidden" name="id" class="form-control" placeholder="Original Barcode" required>
									<strong>Anda yakin mau menghapus user ini?</strong>
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
			ajax: {"url": "<?php echo base_url().'user/get_guest_json'?>", "type": "POST"},
			columns: [
			{"data": "id_user"},
			{"data": "posisi"},
			{"data": "username"},
			{"data": "password"},
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
		
		//get edit barcode
		$('#mytable').on('click','.edit_record',function(){
			var id=$(this).data('id');
			$.ajax({
				type : "GET",
				url  : "<?php echo base_url('user/get_user')?>",
				dataType : "JSON",
				data : {id_user:id},
				success: function(data){
					$.each(data,function(id_user, username, password){
						$('#ModalUpdate').modal('show');
						$('[name="id_user_edit"]').val(data.id_user);
						$('[name="username_edit"]').val(data.username);
						$('[name="password_edit"]').val(data.password);
					});
				}
			});
			return false;
		});
		//end get edit barcode
		
		//get delete barcode
		$('#mytable').on('click','.hapus_record',function(){
			var id=$(this).data('id');
			$('#ModalHapus').modal('show');
			$('[name="id"]').val(id);
		});
		//end get delete barcode
	});
</script>

</div>
</div>
</div>
</body>
</html>

