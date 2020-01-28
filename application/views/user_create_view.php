<html>
<head><title>PT Handal Sukses Karya</title></head>
<body>
	<h2>DATA USER</h2>
	<p><strong>Tambah User Data</strong></p>

	<form action="create" method="post">
		<?php echo $model->labels['id_user']; ?> <br  />
		<input type="text" class="form-control" name="id_user" size="30" maxlength="12"  /><br  /><br  />
		<?php echo form_error('id_user'); ?>

		<?php echo $model->labels['posisi']; ?> <br  />
		<input type="text" class="form-control" name="posisi" size="30" maxlength="13"  /><br  /><br  />
		<?php echo form_error('posisi'); ?>

		<?php echo $model->labels['username']; ?> <br  />
		<input type="text" class="form-control" name="username" size="30" maxlength="13"   /><br  /><br  />
		<?php echo form_error('username'); ?>

		<?php echo $model->labels['password']; ?> <br  />
		<input type="text" class="form-control" name="password" size="30" maxlength="25"  /><br  /><br  />
		<?php echo form_error('password'); ?>

		<input type="submit" class="btn btn-info btn-sm" name="btnSubmit"  value="Tambah">
		<input type="button" class="btn btn-warning btn-sm" value="Batal" onclick="javascript:history.go(-1);"/>
	</form>


</body>
</html>

