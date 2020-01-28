<html>
<head>
	<title></title>
</head>
<body>
	<h3 align="center">REPORT STOCK TANGGAL <?php echo $hari?> JAM <?php echo $jam?> </h3> 

	<table border="1">
		<tr>
			<th>NO</th>
			<th>BRAND</th>
			<th>MODEL</th>
			<th>COLOR</th>
			<th>SIZE</th>
			<th>QUANTITY</th>
			<th>STOCK</th>
		</tr>
		<?php 
		$no=1;
		$subtotal=0;
		foreach($detail as $data){
			$subtotal=$subtotal+$data->Stock;	
			?>
			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $data->Brand ?></td>
				<td><?php echo $data->Model ?></td>
				<td><?php echo $data->Color ?></td>
				<td align="center"><?php echo $data->Size ?></td>	
				<td align="center"><?php echo $data->Quantity ?></td>	
				<td align="center"><?php echo $data->Stock ?></td>					
			</tr>
			<?php 
			$no++;
		}
		?>
		<tr><td align="center" colspan="6"><strong>GRAND TOTAL</strong></td><td align="center"><strong><?php echo $subtotal ?></strong></td></tr>		
	</table>
</body>
</html>