<html>
<head>
</head>
<body>
	<h3 ALIGN="CENTER">STOCK REPORT</h3>
	<div class="body table-responsive">
		<div class="table-wrapper-scroll-y">                          
			<table class="table table-bordered table-fixed" border="1">
				<thead>
					<tr>
						<td align="center"><label>Tanggal</label></td>
						<td align="center"><label>Stok Awal</label></td>
						<td align="center"><label>Receiving</label></td>
						<td align="center"><label>Shipping</label></td>
						<td align="center"><label>Stok Akhir</label></td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($detail_stok as $data){?>
						<tr>
							<td align="center"><?php echo $data->date ?></td>
							<td align="center"><?php echo $data->stock_awal ?></td>	
							<td align="center"><?php echo $data->receiving ?></td>
							<td align="center"><?php echo $data->shipping ?></td>	
							<td align="center"><?php echo $data->stock_akhir ?></td>			
						</tr>
					<?php }	?>
				</tbody>
			</table>
		</div>
	</div>  		
</body>
</html>	