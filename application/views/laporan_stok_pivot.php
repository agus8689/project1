<html>
<head>
	<title></title>
</head>
<body>
	<h3 align="center">SUMMARY REPORT <?php echo $tipe ?> <?php echo $tanggal1?>-<?php echo $tanggal2?></h3>
	<table border="1">
		<tr>
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
				<td><?php echo $data->cust_model ?></td>	
				<td><?php echo $data->color ?></td>						
				<td align="center"><?php echo $data->size ?></td>						
				<td><?php echo $data->quantity ?></td>						
			<?php }	?>
		</tr>
		<tr><td colspan="3">GRAND TOTAL</td><!--<td><?php echo $data_all_size ?></td--><td><?php echo $subtotal ?></td></tr>
		
	</table>
</body>
</html>