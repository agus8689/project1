<html>
<head>
	<style type="text/css">
		.table-wrapper-scroll-y {
			display: block;
			max-height: 400px;
			overflow-y: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}

	</style>
</head>
<body>
	<?php $array_hari=array(1=>'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	$hari=$array_hari[date('N')]; ?>
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h3 ALIGN="CENTER">TRANSACTION</h3>
					<form action="transaction" method="post"  align="center">
						<select name="tipe" required>
							<option value="" disable selected>Select Transaction</option>
							<option value="receiving">Receiving</option>
							<option value="shipping">Shipping</option>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						From &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="date" id="start" name="tanggal1"
						min="2018-01-01" max="2050-12-31">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						to &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp	
						<input type="date" id="start" name="tanggal2"
						min="2018-01-01" max="2050-12-31">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="submit" name="btnSubmit" value="FILTER" class="btn">
					</form>    		
				</div>
				<center><h4>DATA <?php echo strtoupper($tipe) ?> DARI TANGGAL <?php echo $tanggal1 ?> SAMPAI <?php echo $tanggal2 ?></center></h4>
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed">
							<thead>
								<tr style="background-color:#0066FF;color:white">
									<td align="center"><label>SCAN NO</label></td>
									<td align="center"><label>DATE/TIME</label></td>
									<td align="center"><label>ORIGINAL BARCODE</label></td>
									<td align="center"><label>BRAND</label></td>
									<td align="center"><label>COLOR</label></td>
									<td align="center"><label>SIZE</label></td>
									<td align="center"><label>FOUR DIGIT</label></td>
									<td align="center"><label>UNIT</label></td>
									<td align="center"><label>QUANTITY</label></td>
									<td align="center"><label>CUSTOMER</label></td>
									<td align="center"><label>CUST MODEL</label></td>
									<td align="center"><label>MODEL CODE</label></td>
									<td align="center"><label>TOOLING CODE</label></td>
									<td align="center"><label>USER</label></td>
									<td align="center" colspan="2"><label>ACTION</label></td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($detail as $data){?>
									<tr>
										<td align="center"><?php echo $data->scan_no ?></td>
										<td align="center"><?php echo $data->date_time ?></td>
										<td align="center"><?php echo $data->original_barcode ?></td>
										<td align="center"><?php echo $data->brand ?></td>		
										<td align="center"><?php echo $data->color ?></td>	
										<td align="center"><?php echo $data->size ?></td>	
										<td align="center"><?php echo $data->four_digit ?></td>	
										<td align="center"><?php echo $data->unit ?></td>	
										<td align="center"><?php echo $data->quantity ?></td>	
										<td align="center"><?php echo $data->customer ?></td>	
										<td align="center"><?php echo $data->cust_model ?></td>	
										<td align="center"><?php echo $data->model_code ?></td>
										<td align="center"><?php echo $data->tooling_code ?></td>
										<td align="center"><?php echo $data->username ?></td>
										<td align="center"><?php echo anchor('/stock_monitoring/update2/'.$tipe.'/'.$data->date_time,'Ubah',array('class'=>'btn btn-info btn-sm'));?></td>
										<td align="center"><a href="/hskpro/stock_monitoring/delete2/<?php echo $tipe.'/'.$data->date_time; ?>" class="btn btn-warning btn-sm">Hapus</a></td>				
									</tr>
								<?php }	?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>  		
</body>
</html>	