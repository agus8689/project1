<html>
<head><title>PT Handal Sukses Karya</title></head>
<body>
	<h2>MASTER DATA</h2>
	<p><strong>Create Data</strong></p>
	<form action="create" method="post">
		<div class="row">
			<div class="col-md-6">
				<?php echo $model->labels['original_barcode']; ?> <br  />
				<input type="text" class="form-control" name="original_barcode" size="30" maxlength="26"  /><br  /><br  />
				<?php echo form_error('original_barcode'); ?>

				<?php echo $model->labels['brand']; ?> <br  />
				<input type="text" class="form-control" name="brand" size="30" maxlength="25"  /><br  /><br  />
				<?php echo form_error('brand'); ?>

				<?php echo $model->labels['color']; ?> <br  />
				<input type="text" class="form-control" name="color" size="30" maxlength="25"   /><br  /><br  />
				<?php echo form_error('color'); ?>

				<?php echo $model->labels['size']; ?> <br  />
				<input type="text" class="form-control" name="size" size="30" maxlength="11"   /><br  /><br  />
				<?php echo form_error('size'); ?>

				<?php echo $model->labels['four_digit']; ?> <br  />
				<input type="text" class="form-control" name="four_digit" size="30" maxlength="4"  /><br  /><br  />
				<?php echo form_error('four_digit'); ?>

				<?php echo $model->labels['unit']; ?> <br  />
				<input type="text" class="form-control" name="unit" size="30" maxlength="4"  /><br  /><br  />
				<?php echo form_error('unit'); ?>

			</div>
			<div class="col-md-6">

				<?php echo $model->labels['quantity']; ?> <br  />
				<input type="text" class="form-control" name="quantity" size="30" maxlength="6"  /><br  /><br  />
				<?php echo form_error('quantity'); ?>

				<?php echo $model->labels['customer']; ?> <br  />
				<input type="text" class="form-control" name="customer" size="30" maxlength="50"   /><br  /><br  />
				<?php echo form_error('customer'); ?>

				<?php echo $model->labels['cust_model']; ?> <br  />
				<input type="text" class="form-control" name="cust_model" size="30" maxlength="50"   /><br  /><br  />
				<?php echo form_error('cust_model'); ?>

				<?php echo $model->labels['model_code']; ?> <br  />
				<input type="text" class="form-control" name="model_code" size="30" maxlength="4"   /><br  /><br  />
				<?php echo form_error('model_code'); ?>

				<?php echo $model->labels['tooling_code']; ?> <br  />
				<input type="text" class="form-control" name="tooling_code" size="30" maxlength="5"  /><br  /><br  />
				<?php echo form_error('tooling_code'); ?>

				<?php echo $model->labels['stock']; ?> <br  />
				<input type="text" class="form-control" name="stock" size="30" maxlength="5" readonly value="0"  /><br  /><br  />
				<?php echo form_error('stock'); ?>

				<input type="submit" style="float:right" class="btn btn-info btn-lg" name="btnSubmit" value="Save">
				<input type="button" style="float:right;margin-right:15px" class="btn btn-warning btn-lg" value="Cancel" onclick="javascript:history.go(-1);"/>

			</div>
		</div>
	</form>

</body>
</html>

