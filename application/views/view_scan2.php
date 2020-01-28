<html>
<head>
	<style type="text/css">
		.table-wrapper-scroll-y {
			display: block;
			max-height: 340px;
			overflow-y: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}
	</style>
</head>
<body>
	<?php $array_hari=array(1=>'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	$hari=$array_hari[date('N')]; ?>
	<div class="row clearfix">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h3 ALIGN="CENTER">SCAN SHIPPING</h3>
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
				<div class="header" style="background-color: orange">
					<form method="POST" action="<?php echo site_url('scan/getscans1');?>">	
						<div class="col-lg-12"> 
							<div class="col-lg-4">   
								<div class="form-group" style="background-color: orange" align="right" >
									<label style="color:white">Scan</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="input-group">
									<input type="text" name="barcode" maxlength="15" size="30" class="form-control" required autocomplete="off" autofocus="autofocus" width="10%">
								</div>
							</div>
							<div class="col-lg-4"></div> 	  
						</div><br />   
					</form><br />
				</div>
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">
						<table class="table table-bordered table-striped">
							<thead>
								<tr class="bg-orange">
									<td align="center"><label>DATE/TIME</label></td>
									<td align="center"><label>BRAND</label></td>
									<td align="center"><label>MODEL</label></td>
									<td align="center"><label>COLOR</label></td>
									<td align="center"><label>SIZE</label></td>
									<td align="center"><label>QUANTITY</label></td>
									<td align="center"><label>SCAN NO</label></td>
								</tr>
							</thead>
							<tbody>
								<?php foreach($detail1 as $data){?>
									<tr>
										<td align="center"><?php echo $data->date_time ?></td>
										<td align="center"><?php echo $data->brand ?></td>	
										<td align="center"><?php echo $data->cust_model ?></td>	
										<td align="center"><?php echo $data->color ?></td>	
										<td align="center"><?php echo $data->size ?></td>	
										<td align="center"><?php echo $data->quantity ?></td>	
										<td align="center"><?php echo $data->scan_no ?></td>		
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