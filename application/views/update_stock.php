<html>
<head><title>PT Handal Sukses Karya</title></head>
<body>
	<h2>STOCK REPORT</h2>
	<p><strong>Edit Stock</strong></p>
	<form action="update5" method="post">
		<?php echo $model->labels['no']; ?> <br  />
		<input type="text" class="form-control" name="no" size="30" readonly maxlength="12" value="<?php echo $model->no;?>"  /><br  /><br  />
		<?php echo form_error('no'); ?>

		<?php echo $model->labels['date']; ?> <br  />
		<input type="text" class="form-control" name="date" size="30" readonly maxlength="12" value="<?php echo $model->date;?>"  /><br  /><br  />
		<?php echo form_error('date'); ?>

		<?php echo $model->labels['stock_awal']; ?> <br  />
		<input type="text" class="form-control" name="stock_awal" size="30" maxlength="25" value="<?php echo $model->stock_awal;?>"  /><br  /><br  />
		<?php echo form_error('stock_awal'); ?>

		<?php echo $model->labels['receiving']; ?> <br  />
		<input type="text" class="form-control" name="receiving" size="30" maxlength="25" value="<?php echo $model->receiving;?>"  /><br  /><br  />
		<?php echo form_error('receiving'); ?>

		<?php echo $model->labels['shipping']; ?> <br  />
		<input type="text" class="form-control" name="shipping" size="30" maxlength="25" value="<?php echo $model->shipping;?>"  /><br  /><br  />
		<?php echo form_error('shipping'); ?>

		<?php echo $model->labels['stock_akhir']; ?> <br  />
		<input type="text" class="form-control" name="stock_akhir" size="30" maxlength="25" value="<?php echo $model->stock_akhir;?>"  /><br  /><br  />
		<?php echo form_error('stock_akhir'); ?>
		<input type="submit" style="float:right" class="btn btn-info btn-lg" name="btnSubmit"  value="Save">
		<input type="button" style="float:right;margin-right:15px" class="btn btn-warning btn-lg" value="Cancel" onclick="javascript:history.go(-1);"/>
	</form>
</body>
</html>

