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
	<div class="row clearfix">
		<!-- Task Info -->
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="card">
				<div class="header">
					<h3 align="center">HOURLY REPORT</h3>
					<form action="report3" method="post" align="center">
						<select name="tipe" required>
							<option value="" disable selected>Select Transaction</option>
							<option value="receiving">Receiving</option>
							<option value="shipping">Shipping</option>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="model">
							<option value="" disable selected>Select Models</option>
							<?php 
							foreach($models as $data){
								echo "<option value=".$data['model_code'].">".$data['cust_model']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="color">
							<option value="" disable selected>Select Colors</option>
							<?php 
							foreach($kolor as $data){
								$data1=str_replace(" ", "_", $data);
								echo "<option value=".$data1['color'].">".$data['color']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="size">
							<option value="" disable selected>Select Sizes</option>
							<?php 
							foreach($sizes as $data){
								echo "<option value=".$data['size'].">".$data['size']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="user">
							<option value="" disable selected>Select Users</option>
							<?php 
							foreach($users as $data){
								echo "<option value=".$data['username'].">".$data['username']."</option>";
							}		
							?>
						</select><br></br>
						From &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="date" name="tanggal1"
						min="2018-01-01" max="2050-12-31">
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="jam1">
							<option value="" disable selected>Select Hours</option>
							<?php 
							foreach($hours as $data){
								echo "<option value=".$data['value'].">".$data['hour']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						To &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="date" name="tanggal2"
						min="2018-01-01" max="2050-12-31">
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<select name="jam2">
							<option value="" disable selected>Select Hours</option>
							<?php 
							foreach($hours as $data){
								echo "<option value=".$data['value'].">".$data['hour']."</option>";
							}		
							?>
						</select>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<input type="submit" name="btnSubmit" value="FILTER" class="btn">
					</form>    		
				</div>
				<div>
					<table class="table table-bordered table-fixed">
						<?php if($tanggal1==null){
							$tanggal1='n';
						}else{
							$tanggal1=$tanggal1;
						}
						if($tanggal2==null){
							$tanggal2='n';
						}else{
							$tanggal2=$tanggal2;
						}
						if($tipe==null){
							$tipe='n';
						}else{
							$tipe=$tipe;
						}
						if($model==null){
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
						if($user==null){
							$user='n';
						}else{
							$user=$user;
						}
						if($jam1==null){
							$jam1='n';
						}else{
							$jam1=$jam1;
						}
						if($jam2==null){
							$jam2='n';
						}else{
							$jam2=$jam2;
						}
						?>
						<a href="<?php echo site_url()."stock_monitoring/ekspor_hour/$tanggal1/$tanggal2/$tipe/$model/$color/$size/$user/$jam1/$jam2"?>"><button class="btn btn-default pull-right"><span class="glyphicon glyphicon-save-file"></span> Print Summary</button></a>
						<a href="<?php echo site_url()."stock_monitoring/ekspor3/$tanggal1/$tanggal2/$tipe/$model/$color/$size/$user/$jam1/$jam2"?>"><button class="btn btn-default pull-right"><span class="glyphicon glyphicon-save-file"></span> Print Detail</button></a>
					</table>
				</div>
				<div class="body table-responsive">
					<div class="table-wrapper-scroll-y">                          
						<table class="table table-bordered table-fixed">
							<thead>
								<tr>
									<td align="center"><label>CUSTOMER</label></td>
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
								<?php foreach($detail as $data){?>
									<tr>
										<td align="center"><?php echo $data->customer ?></td>
										<td align="center"><?php echo $data->brand ?></td>	
										<td align="center"><?php echo $data->cust_model ?></td>	
										<td align="center"><?php echo $data->color ?></td>	
										<td align="center"><?php echo $data->size ?></td>	
										<td align="center"><?php echo $data->quantity ?></td>	
										<td align="center"><?php echo $data->username ?></td>	
										<td align="center"><?php echo $data->scan_no ?></td>		
									</tr>
								<?php }	?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>  		
</body>
</html>	