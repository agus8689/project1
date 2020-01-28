<html>
<head>
	<title></title>
</head>
<body>
	<h3 align="center">REPORT ALL Shipping</h3>
	<table border="1">
		<tr>
			<th>SCAN NO</th>
			<th>DATE</th>
			<th>CUSTOMER</th>
			<th>BRAND</th>
			<th>MODEL</th>
			<th>COLOR</th>
			<th>SIZE</th>
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
				<td><?php echo $data->quantity ?></td>
			<?php }	?>
		</tr>
		
		<tr><td colspan="7">GRAND TOTAL</td><td><?php echo $subtotal ?></td></tr>
	</table>
</body>
</html>