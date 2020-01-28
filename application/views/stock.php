<html>
<head>
	<style type="text/css">
		.table-wrapper-scroll-y {
			display: block;
			max-height: 400px;
			overflow-y: auto;
			-ms-overflow-style: -ms-autohiding-scrollbar;
		}
	</style>
</head>
<body>
	<?php $array_hari=array(1=>'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
	$hari=$array_hari[date('N')]; ?>
	<?php $hari1=date('d-m-Y') ?>
	<?php $jam=date('G:i:s') ?>
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h3 align="center">WAREHOUSE STOCK</h3>
					<form action="stock" method="post" align="center">
						<select name="model">
							<option value="" disable selected>Select Models</option>
							<?php 
							foreach($models as $data){
								echo "<option value=".$data['model_code'].">".$data['cust_model']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="color">
							<option value="" disable selected>Select Colors</option>
							<?php 
							foreach($kolor as $data){
								echo "<option value=".$data['color'].">".$data['color']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="size">
							<option value="" disable selected>Select Sizes</option>
							<?php 
							foreach($sizes as $data){
								echo "<option value=".$data['size'].">".$data['size']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="submit" name="btnSubmit" value="FILTER" class="btn">
					</form>    		
				</div>
				<div>
					<table class="table table-bordered table-fixed">
						<?php if($model==null){
							$model='n';
						}else{
							$model=$model;
						}
						if($color==null){
							$color='n';
						}else{
							$color=$color;
						}
						if($size==null){
							$size='n';
						}else{
							$size=$size;
						}
						?>
						<a href="<?php echo site_url()."stock_monitoring/ekspor4/$model/$color/$size/$hari1/$jam"?>"><button class="btn btn-default pull-right"><span class="glyphicon glyphicon-save-file"></span> Print Detail</button></a>
					</table>
				</div>
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed">
							<thead>
								<tr>
									<td align="center"><label>NO</label></td>
									<td align="center"><label>BRAND</label></td>
									<td align="center"><label>MODEL</label></td>
									<td align="center"><label>COLOR</label></td>
									<td align="center"><label>SIZE</label></td>
									<td align="center"><label>QUANTITY</label></td>
									<td align="center"><label>STOCK</label></td>
								</tr>
							</thead>
							<tbody>
								<?php
								$no=1;
								foreach($detail as $data){
									?>
									<tr>
										<td align="center"><?php echo $no; ?></td>
										<td align="center"><?php echo $data->Brand ?></td>
										<td align="center"><?php echo $data->Model ?></td>
										<td align="center"><?php echo $data->Color ?></td>
										<td align="center"><?php echo $data->Size ?></td>	
										<td align="center"><?php echo $data->Quantity ?></td>	
										<td align="center"><?php echo $data->Stock ?></td>
									</tr>
									<?php 
									$no++; 
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>  		
</body>
</html>	