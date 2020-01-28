<html>
<head>
	<title></title>
</head>
<body>
	<h3 align="center">DAILY REPORT <?php echo strtoupper($tipe) ?> <?php echo $tanggal1?> SAMPAI <?php echo $tanggal2?></h3>
	<table border="1">
		<tr>
			<th>SCAN NO</th>
			<th>TANGGAL</th>
			<th>CUSTOMER</th>
			<th>BRAND</th>
			<th>MODEL</th>
			<th>COLOR</th>
			<th>SIZE</th>
			<th>USERNAME</th>
			<th>QUANTITY</th>
		</tr>
		<?php 
		$subtotal=0;
		foreach($detail as $data){
			$subtotal=$subtotal+$data->quantity;	
			?>
			<tr>
				<td><?php echo $data->scan_no ?></td>
				<td><?php echo $data->date_time ?></td>
				<td><?php echo $data->customer ?></td>
				<td><?php echo $data->brand ?></td>	
				<td><?php echo $data->cust_model ?></td>	
				<td><?php echo $data->color ?></td>	
				<td align="center"><?php echo $data->size ?></td>	
				<td><?php echo $data->username ?></td>	
				<td align="center"><?php echo $data->quantity ?></td>					
			</tr>
		<?php }	?>
		<tr>
			<td align="center" colspan="8"><strong>GRAND TOTAL</strong></td><td align="center"><strong><?php echo $subtotal ?></strong></td>
		</tr>		
	</table>
</body>
</html>