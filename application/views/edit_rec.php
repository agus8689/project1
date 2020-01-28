<html>
<head><title>PT Handal Sukses Karya</title></head>
<body>
	<h2>RECEIVING</h2>
	<p><strong>EDIT RECEIVING</strong></p>
	<form action="update3" method="post">
		<div class="row">
			<div class="col-md-6">
				<input type="hidden" class="form-control" name="tipe" size="10" maxlength="12" value="Receiving"/>
				
				<?php echo $model->labels['scan_no'];?><br/>
				<input type="text" class="form-control" name="scan_no" size="30" maxlength="5" readonly value="<?php echo $model->scan_no;?>"/><br/><br/>
				<?php echo form_error('scan_no');?>
				
				<?php echo $model->labels['date_time'];?><br/>
				<input type="text" class="form-control" name="date_time" size="30" maxlength="25" readonly value="<?php echo $model->date_time;?>"/><br/><br/>
				<?php echo form_error('date_time');?>
				
				<?php echo $model->labels['original_barcode'];?><br/>
				<input type="text" class="form-control" name="original_barcode" id="original_barcode" size="30" maxlength="15" value="<?php echo $model->original_barcode;?>" onkeyup="this.value=this.value.toUpperCase()"/><br/><br/>
				<?php echo form_error('original_barcode');?>

				<?php echo $model->labels['brand'];?><br/>
				<input type="text" class="form-control" name="brand" size="30" maxlength="25" readonly value="<?php echo $model->brand;?>"/><br/><br/>
				<?php echo form_error('brand');?>
				
				<?php echo $model->labels['cust_model'];?><br/>
				<input type="text" class="form-control" name="cust_model" size="30" maxlength="25" readonly value="<?php echo $model->cust_model;?>"/><br/><br/>
				<?php echo form_error('cust_model');?>
				
				<input type="hidden" class="form-control" name="model_code" size="30" maxlength="5" readonly value="<?php echo $model->model_code;?>"/>
				
				<input type="hidden" class="form-control" name="tooling_code" size="30" maxlength="5" readonly value="<?php echo $model->tooling_code;?>"/>		

			</div>
			<div class="col-md-6">

				<?php echo $model->labels['color'];?><br/>
				<input type="text" class="form-control" name="color" size="30" maxlength="25" readonly value="<?php echo $model->color;?>"/><br/><br/>
				<?php echo form_error('color');?>

				<?php echo $model->labels['size'];?><br/>
				<input type="text" class="form-control" name="size" size="30" maxlength="11" readonly value="<?php echo $model->size;?>"/><br/><br/>
				<?php echo form_error('size');?>
				
				<input type="hidden" class="form-control" name="four_digit" size="30" maxlength="5" readonly value="<?php echo $model->four_digit;?>"/>
				
				<input type="hidden" class="form-control" name="unit" size="30" maxlength="5" readonly value="<?php echo $model->unit;?>"/>

				<?php echo $model->labels['quantity'];?><br/>
				<input type="text" class="form-control" name="quantity" size="30" maxlength="4" readonly value="<?php echo $model->quantity;?>"/><br/><br/>
				<?php echo form_error('quantity');?>

				<input type="hidden" class="form-control" name="customer" size="30" maxlength="15" readonly value="<?php echo $model->customer;?>"/>
				
				<?php echo $model->labels['username'];?><br/>
				<input type="text" class="form-control" name="username" size="30" maxlength="10" readonly value="<?php echo $model->username;?>"/><br/><br/>
				<?php echo form_error('username');?>
				<input type="submit" style="float:right" class="btn btn-info btn-lg" name="btnSubmit" value="Save">
				<input type="button" style="float:right;margin-right:15px" class="btn btn-warning btn-lg" value="Cancel" onclick="javascript:history.go(-1);"/>

			</div>
		</div>
	</form>
	<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.js'?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#original_barcode').on('input',function(){  
				var original_barcode=$(this).val();
				$.ajax({
					type : "POST",
					url  : "<?php echo base_url('stock_monitoring/get_barcode')?>",
					dataType : "JSON",
					data : {original_barcode: original_barcode},
					cache:false,
					success: function(data){
						$.each(data,function(original_barcode, brand, color, size, four_digit, unit, quantity, customer, cust_model, model_code, tooling_code){
							$('[name="brand"]').val(data.brand);
							$('[name="color"]').val(data.color);
							$('[name="size"]').val(data.size);
							$('[name="four_digit"]').val(data.four_digit);
							$('[name="unit"]').val(data.unit);
							$('[name="quantity"]').val(data.quantity);
							$('[name="customer"]').val(data.customer);
							$('[name="cust_model"]').val(data.cust_model);
							$('[name="model_code"]').val(data.model_code);
							$('[name="tooling_code"]').val(data.tooling_code);
						});
						
					}
				});
				return false;
			});
		});
	</script>
</body>
</html>