<html>
<head><title>PT Handal Sukses Karya</title></head>
<body>
	<h2 align="center">PT Handal Sukses Karya</h2>
	<h2 align="center">MASTER DATA</h2>
	<table border="1">
		<tr>
			<th>Original Barcode</th>
			<th>Brand</th>
			<th>Color</th>
			<th>Size</th>
			<th>Four Digit</th>
			<th>Unit</th>
			<th>Quantity</th>
			<th>Customer</th>
			<th>Customer Model</th>
			<th>Model Code</th>
			<th>Tooling Code</th>
			<th>Stock</th>	
		</tr>
		<?php
		$i=0;
		foreach ($rows as $row){
			$i=$i+1;
			?>
			<tr>
				<td align="left"><?php echo $row->original_barcode;?></td>
				<td align="left"><?php echo $row->brand;?></td>
				<td align="left"><?php echo $row->color;?></td>
				<td align="left"><?php echo $row->size;?></td>
				<td align="left"><?php echo $row->four_digit;?></td>
				<td align="left"><?php echo $row->unit;?></td>
				<td align="left"><?php echo $row->quantity;?></td>
				<td align="left"><?php echo $row->customer;?></td>
				<td align="left"><?php echo $row->cust_model;?></td>
				<td align="left"><?php echo $row->model_code;?></td>
				<td align="left"><?php echo $row->tooling_code;?></td>
				<td align="left"><?php echo $row->stock;?></td>
			</tr>

			<?php
		}
		?>
		<tr>
			<td colspan="11" align="center">TOTAL</td>
			<td ><?php echo $total->jumlah;?></td>
		</tr>
	</table>	
</body>
</html>
