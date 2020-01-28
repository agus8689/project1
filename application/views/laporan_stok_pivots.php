<html>
<head>
	<title></title>
</head>
<body>
	<h3 align="center">SUMMARY REPORT <?php //echo $tipe ?> <?php //echo $model ?> <?php echo $tanggal1?>-<?php echo $tanggal2?></h3>
	<table border="1">
		<tr>
			<th rowspan="2">MODEL</th>
			<th rowspan="2">COLOR</th>
			<th colspan="<?php echo $data_jumlah_baris?>">SIZE</th>
			<th rowspan="2">TOTAL</th>
			<tr>
				<?php 
				foreach($saiz as $data){	
					?>
					<th><?php echo $data->size ?></th>	
				<?php }	?>
				<?php
				foreach($detail as $data){
					?>
					<tr>
						<td><?php echo $data->cust_model ?></td>	
						<td><?php echo $data->color ?></td>
						<?php 
						foreach($saiz as $row){
							?>
							<?php	if($row->size== $data->size){ ?>
								<td><?php echo $data->quantity ?></td>
							<?php } else { ?>
								<td>-</td>
							<?php }	?>			
						<?php }	?>
						<td><?php echo $data->quantity ?></td>
						<tr>
						<?php }	?>				
					</tr>
					
					
					
					<td COLSPAN="2">GRAND TOTAL</td>
					<?php
					foreach($gt as $datas){
						?>
						<?php	if($datas->quantity != NULL){ ?>
							<td><?php echo $datas->quantity ?></td>
						<?php } else { ?>
							<td>0</td>
						<?php }	?>			
					<?php }	?>
					<?php foreach($totals as $dataaa){
						?>
						<td><?php echo $dataaa->quantity ?></td>		
					<?php }	?>
					
				</TR>
				
				
				
				
			</table>
		</body>
		</html>