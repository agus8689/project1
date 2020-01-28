<div class="card">
	<div class="header">
		<h2>
			Stock Opname Using Excel
		</h2>
	</div>
	<div class="body">
		<form method="post" action="<?php echo base_url('stock_monitoring/preview_opnameexcel'); ?>" enctype="multipart/form-data">
			<label>File</label>
			<div class="form-group">
				<div class="form-line">
					<input type="file" name="file" class="form-control" placeholder="masukkan file excel" required>
				</div>
			</div>
			<button class="btn btn-info btn-sm" style="margin-left:5px;" type="submit" name="preview"> Preview</button>
			<button class="btn btn-warning btn-sm" style="margin-left:5px;" onclick="javascript:history.go(-1)"> Cancel</button>
		</form>
		<script src="<?php echo base_url();?>template1/bower_components/jquery/dist/jquery.min.js"></script>
		<?php
		if(isset($_POST['preview'])){
			if(isset($upload_error)){
				echo "<div style='color: red;'>".$upload_error."</div>";
				die;
			}
			echo "<form method='post' action='".base_url("stock_monitoring/importopname")."'>";
			
			echo "<table id='example1' class='table table-bordered table-striped'>
			<tr>
			<th colspan='12' bgcolor='darkgrey' style='color:white;'><center>Preview Data</center></th>
			</tr>
			<tr>
			<th><center>ORIGINAL BARCODE</center></th>
			<th><center>BRAND</center></th>
			<th><center>COLOR</center></th>
			<th><center>SIZE</center></th>
			<th><center>FOUR DIGIT</center></th>
			<th><center>UNIT</center></th>
			<th><center>QUANTITY</center></th>
			<th><center>CUSTOMER</center></th>
			<th><center>CUSTOMER MODEL</center></th>
			<th><center>MODEL CODE</center></th>
			<th><center>TOOLING CODE</center></th>
			<th><center>STOCK</center></th>
			
			</tr>";

			$numrow=1;
			$kosong=0;

			foreach($sheet as $row){ 
				$original_barcode=$row['A'];
				$brand=$row['B'];
				$color=$row['C'];
				$size=$row['D'];
				$four_digit=$row['E'];
				$unit=$row['F'];
				$quantity=$row['G'];
				$customer=$row['H'];
				$customer_model=$row['I'];
				$model_code=$row['J'];
				$tooling_code=$row['K'];
				$stock=$row['L'];

				if(empty($original_barcode) && empty($brand) && empty($color)&& empty($size) && empty($four_digit)&& empty($unit) && empty($quantity)&& empty($customer) && empty($customer_model)&& empty($model_code) && empty($tooling_code)&& empty($stock))
					continue;

				if($numrow > 1){
					$original_barcode_td=( ! empty($original_barcode))? "" : " style='background: #E07171;'";
					$brand_td=( ! empty($brand))? "" : " style='background: #E07171;'";
					$color_td=( ! empty($color))? "" : " style='background: #E07171;'";
					$size_td=( ! empty($size))? "" : " style='background: #E07171;'";
					$four_digit_td=( ! empty($four_digit))? "" : " style='background: #E07171;'";
					$unit_td=( ! empty($unit))? "" : " style='background: #E07171;'";
					$quantity_td=( ! empty($quantity))? "" : " style='background: #E07171;'";
					$customer_td=( ! empty($customer))? "" : " style='background: #E07171;'";
					$customer_model_td=( ! empty($customer_model))? "" : " style='background: #E07171;'";
					$model_code_td=( ! empty($model_code))? "" : " style='background: #E07171;'";
					$tooling_code_td=( ! empty($tooling_code))? "" : " style='background: #E07171;'";
					$stock_td=( ! empty($stock))? "" : " style='background: #E07171;'";
					
					if(empty($original_barcode) && empty($brand) && empty($color)&& empty($size) && empty($four_digit)&& empty($unit) && empty($quantity)&& empty($customer) && empty($customer_model)&& empty($model_code) && empty($tooling_code)&& empty($stock)){
						$kosong++;
					}

					echo "<tr>";
					echo "<td".$original_barcode_td.">".$original_barcode."</td>";
					echo "<td".$brand_td.">".$brand."</td>";
					echo "<td".$color_td.">".$color."</td>";
					echo "<td".$size_td.">".$size."</td>";
					echo "<td".$four_digit_td.">".$four_digit."</td>";
					echo "<td".$unit_td.">".$unit."</td>";
					echo "<td".$quantity_td.">".$quantity."</td>";
					echo "<td".$customer_td.">".$customer."</td>";
					echo "<td".$customer_model_td.">".$customer_model."</td>";
					echo "<td".$model_code_td.">".$model_code."</td>";
					echo "<td".$tooling_code_td.">".$tooling_code."</td>";
					echo "<td".$stock_td.">".$stock."</td>";
					
					echo "</tr>";
				}

				$numrow++;
			}

			echo "</table>";

			if($kosong > 1){
				?> 
				<script>
					$(document).ready(function(){
						
						$("#jumlah_kosong").html('<?php echo $kosong; ?>');

						$("#kosong").show();
					});
				</script>
				<?php
			}else{
				echo "<hr>";
				echo "<div class='box-footer' style='height:20px;'>";
				echo "<button class='btn btn-success btn-sm' type='submit' name='import' style='float:right;margin-top:-15px;'>Import</button>";
				echo "<a href='".base_url("stock_monitoring/opnameexcel")."'><button class='btn btn-warning btn-sm' style='float:right;margin-right:5px;margin-top:-15px;'>Cancel</button></a>";
				
				echo "</div>";
			}
			echo "</form>";	
		}
		?>
	</div>
</div>

<script src="<?php echo base_url();?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script>
	$(function () {
		$('#example1').DataTable()
		$('#example2').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : false,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : false
		})
	})
</script>