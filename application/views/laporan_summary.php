<html>
<head>
	<title></title>
</head>
<body>
	<h3 align="center">SUMMARY HOURLY <?php echo strtoupper($tipe)?> TANGGAL <?php echo $tanggal1?> JAM <?php echo $jam1?> SAMPAI <?php echo $tanggal2?> <?php echo $jam2?></h3> 

	<table border="1">
		<tr>
			<th>NO</th>
			<th>BRAND</th>
			<th>MODEL</th>
			<th>COLOR</th>
			<th>SIZE</th>
			<th>QUANTITY</th>
			<th>JUMLAH</th>
			<th>TOTAL</th>
		</tr>
		<?php 
		$no=1;
		$subtotal=0;
		foreach($detail as $data){
			$subtotal=$subtotal+$data->Total;	
			?>
			<tr>
				<td><?php echo $no ?></td>
				<td><?php echo $data->Brand ?></td>
				<td><?php echo $data->Model ?></td>
				<td><?php echo $data->Color ?></td>
				<td align="center"><?php echo $data->Size ?></td>	
				<td align="center"><?php echo $data->Quantity ?></td>	
				<td align="center"><?php echo $data->Jumlah ?></td>				
				<td align="center"><?php echo $data->Total ?></td>				
			</tr>
			<?php
			$no++;
		}
		?>
		<tr><td align="center" colspan="7"><strong>GRAND TOTAL</strong></td><td align="center"><strong><?php echo $subtotal ?></strong></td></tr>		
	</table>
</body>
</html>