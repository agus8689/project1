<!DOCTYPE html>
<html>
<meta http-equiv="refresh" content="10" />
<body class="theme-blue-grey">
	<!-- Widgets -->
	<div class="row clearfix">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="info-box-3 bg-light-green hover-expand-effect">
				<div class="icon">
					<i class="material-icons">equalizer</i>
				</div>
				<div class="content">
					<div class="text"><h4>RECEIVING</h4></div>
					<div class="number count-to" data-from="0" data-to="<?= $receiving; ?>" data-speed="1000" data-fresh-interval="20"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="info-box-3 bg-orange hover-expand-effect">
				<div class="icon">
					<i class="material-icons">equalizer</i>
				</div>
				<div class="content">
					<div class="text"><h4>SHIPPING</h4></div>
					<div class="number count-to" data-from="0" data-to="<?= $shipping; ?>" data-speed="1000" data-fresh-interval="20"></div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
			<div class="info-box-3 bg-pink hover-expand-effect">
				<div class="icon">
					<i class="material-icons">equalizer</i>
				</div>
				<div class="content">
					<div class="text"><h4>STOCK AWAL</h4></div>
					<div class="number count-to" data-from="0" data-to="<?= $stock_akhir; ?>" data-speed="1000" data-fresh-interval="20"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row clearfix">
		<!-- Line Chart -->
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h4>DAILY TRANSACTION</h4>
				</div>
				<div class="body">
					<canvas id="myChart" height="250px"></canvas>
				</div>
			</div>
		</div>
		<!-- #END# Line Chart -->
		<!-- Bar Chart -->
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h4>WAREHOUSE STOCK</h4>
				</div>
				<div class="body">
					<canvas id="myChart2" height="250px"></canvas>
				</div>
			</div>
		</div>
		<!-- #END# Bar Chart -->
	</div>
	<!-- #END# Widgets -->
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="body">
					<div class="body table-responsive">
						<table class="table table-condensed table-bordered">
							<thead >
								<tr class="bg-light-green">
									<td align="center"><label>DATE/TIME</label></td>
									<td align="center"><label>BRAND</label></td>
									<td align="center"><label>MODEL</label></td>
									<td align="center"><label>COLOR</label></td>
									<td align="center"><label>SIZE</label></td>
									<td align="center"><label>QUANTITY</label></td>
									<td align="center"><label>USER</label></td>
									<td align="center"><label>SCAN NO</label></td>    
								</tr>
							</thead>
							<tbody>
								<?php foreach ($result_receiving->result() as $row) {?>                                            
									<tr>
										<td align="center"><?php echo $row->date_time; ?></td>
										<td align="center"><?php echo $row->brand; ?></td>
										<td align="center"><?php echo $row->cust_model; ?></td>
										<td align="center"><?php echo $row->color; ?></td> 
										<td align="center"><?php echo $row->size; ?></td>
										<td align="center"><?php echo $row->quantity; ?></td>
										<td align="center"><?php echo $row->username; ?></td>
										<td align="center"><?php echo $row->scan_no; ?></td>                                       
									</tr>
								<?php } ?>                                      
							</tbody>
						</table>
						<table class="table table-condensed table-bordered">
							<thead>
								<tr class="bg-orange">
									<td align="center"><label>DATE/TIME</label></td>
									<td align="center"><label>BRAND</label></td>
									<td align="center"><label>MODEL</label></td>
									<td align="center"><label>COLOR</label></td>
									<td align="center"><label>SIZE</label></td>
									<td align="center"><label>QUANTITY</label></td>
									<td align="center"><label>USER</label></td>
									<td align="center"><label>SCAN NO</label></td>    
								</tr>
							</thead>
							<tbody style="border-color: green">
								<?php foreach ($result_shipping->result() as $row) {?>                                         
									<tr>
										<td align="center"><?php echo $row->date_time; ?></td>
										<td align="center"><?php echo $row->brand; ?></td>
										<td align="center"><?php echo $row->cust_model; ?></td>
										<td align="center"><?php echo $row->color; ?></td> 
										<td align="center"><?php echo $row->size; ?></td>
										<td align="center"><?php echo $row->quantity; ?></td>
										<td align="center"><?php echo $row->username; ?></td>
										<td align="center"><?php echo $row->scan_no; ?></td>                                       
									</tr>
								<?php } ?>                                    
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- #END# Task Info -->
	</div>
	<script src="<?php echo base_url();?>assets/plugins/chartjs2/chart.js"></script>
	<script>
		var ctx=document.getElementById("myChart").getContext('2d');
		var myChart=new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php foreach($chart2 as $data){ $tgl[]=$data->Tanggal; } echo json_encode($tgl); ?>,
				datasets: [{
					label: 'Receiving',
					data: <?php foreach($chart2 as $data){ $rec[]=$data->Receiving; } echo json_encode($rec); ?>,
					backgroundColor: [
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				},{
					label: 'Shipping',
					data : <?php foreach($chart2 as $data){ $shi[]=$data->Shipping; } echo json_encode($shi); ?>,
					backgroundColor: [
					'rgba(255, 206, 86, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(255, 206, 86, 0.2)'],
					borderColor: [
					'rgba(255, 206, 86, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(255, 206, 86, 1)'],
					borderWidth: 2
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
	<script src="<?php echo base_url();?>assets/plugins/chartjs2/chart.js"></script>
	<script>
		var ctx=document.getElementById("myChart2").getContext('2d');
		var myChart=new Chart(ctx, {
			type: 'pie',
			data: {
				labels: <?php foreach($chart as $data){ $model[]=$data->Model; } echo json_encode($model); ?>,
				datasets: [{
					label: '',
					data: <?php foreach($chart as $data){ $total[]=$data->Total; } echo json_encode($total); ?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.6)',
					'rgba(54, 162, 235, 0.6)',
					'rgba(255, 206, 86, 0.6)',
					'rgba(255, 153, 102, 0.6)',
					'rgba(204, 255, 51, 0.6)',
					'rgba(204, 153, 0, 0.6)',
					'rgba(102, 255, 255, 0.6)',
					'rgba(102, 204, 255, 0.6)',
					'rgba(255, 255, 102, 0.6)',
					'rgba(0, 153, 255, 0.6)',
					'rgba(204, 204, 0, 0.6)',
					'rgba(0, 204, 153, 0.6)',
					'rgba(153, 51, 51, 0.6)',
					'rgba(204, 51, 0, 0.6)',
					'rgba(204, 0, 153, 0.6)',
					'rgba(102, 102, 51, 0.6)',
					'rgba(255, 255, 153, 0.6)',
					'rgba(51, 102, 204, 0.6)',
					'rgba(0, 153, 204, 0.6)',
					'rgba(204, 255, 255, 0.6)',
					'rgba(51, 51, 153, 0.6)',
					'rgba(255, 51, 0, 0.6)',
					'rgba(255, 204, 153, 0.6)',
					'rgba(0, 102, 102, 0.6)',
					'rgba(204, 255, 102, 0.6)',
					'rgba(51, 102, 153, 0.6)',
					'rgba(153, 102, 51, 0.6)',
					'rgba(255, 0, 102, 0.6)',
					'rgba(51, 51, 0, 0.6)',
					'rgba(75, 192, 192, 0.6)',
					
					'rgba(255, 99, 132, 0.6)',
					'rgba(54, 162, 235, 0.6)',
					'rgba(255, 206, 86, 0.6)',
					'rgba(255, 153, 102, 0.6)',
					'rgba(204, 255, 51, 0.6)',
					'rgba(204, 153, 0, 0.6)',
					'rgba(102, 255, 255, 0.6)',
					'rgba(102, 204, 255, 0.6)',
					'rgba(255, 255, 102, 0.6)',
					'rgba(0, 153, 255, 0.6)',
					'rgba(204, 204, 0, 0.6)',
					'rgba(0, 204, 153, 0.6)',
					'rgba(153, 51, 51, 0.6)',
					'rgba(204, 51, 0, 0.6)',
					'rgba(204, 0, 153, 0.6)',
					'rgba(102, 102, 51, 0.6)',
					'rgba(255, 255, 153, 0.6)',
					'rgba(51, 102, 204, 0.6)',
					'rgba(0, 153, 204, 0.6)',
					'rgba(204, 255, 255, 0.6)',
					'rgba(51, 51, 153, 0.6)',
					'rgba(255, 51, 0, 0.6)',
					'rgba(255, 204, 153, 0.6)',
					'rgba(0, 102, 102, 0.6)',
					'rgba(204, 255, 102, 0.6)',
					'rgba(51, 102, 153, 0.6)',
					'rgba(153, 102, 51, 0.6)',
					'rgba(255, 0, 102, 0.6)',
					'rgba(51, 51, 0, 0.6)',
					'rgba(75, 192, 192, 0.6)',
					
					'rgba(255, 99, 132, 0.6)',
					'rgba(54, 162, 235, 0.6)',
					'rgba(255, 206, 86, 0.6)',
					'rgba(255, 153, 102, 0.6)',
					'rgba(204, 255, 51, 0.6)',
					'rgba(204, 153, 0, 0.6)',
					'rgba(102, 255, 255, 0.6)',
					'rgba(102, 204, 255, 0.6)',
					'rgba(255, 255, 102, 0.6)',
					'rgba(0, 153, 255, 0.6)',
					'rgba(204, 204, 0, 0.6)',
					'rgba(0, 204, 153, 0.6)',
					'rgba(153, 51, 51, 0.6)',
					'rgba(204, 51, 0, 0.6)',
					'rgba(204, 0, 153, 0.6)',
					'rgba(102, 102, 51, 0.6)',
					'rgba(255, 255, 153, 0.6)',
					'rgba(51, 102, 204, 0.6)',
					'rgba(0, 153, 204, 0.6)',
					'rgba(204, 255, 255, 0.6)',
					'rgba(51, 51, 153, 0.6)',
					'rgba(255, 51, 0, 0.6)',
					'rgba(255, 204, 153, 0.6)',
					'rgba(0, 102, 102, 0.6)',
					'rgba(204, 255, 102, 0.6)',
					'rgba(51, 102, 153, 0.6)',
					'rgba(153, 102, 51, 0.6)',
					'rgba(255, 0, 102, 0.6)',
					'rgba(51, 51, 0, 0.6)',
					'rgba(75, 192, 192, 0.6)'
					],
					borderWidth: 1
				}]
			}
		});
	</script>
</body>
</html>