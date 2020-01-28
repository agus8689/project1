<html>
<head><title>PT Handal Sukses Karya</title></head>
<body>
	<h2>DATA USER</h2>
	<p><strong>Edit User Data</strong></p>

	<form action="update" method="post">
		<?php echo $model->labels['id_user']; ?> <br  />
		<input type="text" class="form-control" name="id_user" size="30" maxlength="12" readonly value="<?php echo $model->id_user;?>"  /><br  /><br  />
		<?php echo form_error('id_user'); ?>

		<?php echo $model->labels['posisi']; ?> <br  />
		<input type="text" class="form-control" name="posisi" size="30" maxlength="25" value="<?php echo $model->posisi;?>"  /><br  /><br  />
		<?php echo form_error('posisi'); ?>

		<?php echo $model->labels['username']; ?> <br  />
		<input type="text" class="form-control" name="username" size="30" maxlength="25" value="<?php echo $model->username;?>"  /><br  /><br  />
		<?php echo form_error('username'); ?>

		<?php echo $model->labels['password']; ?> <br  />
		<input type="text" class="form-control" name="password" size="30" maxlength="11" value="<?php echo $model->password;?>"  /><br  /><br  />
		<?php echo form_error('password'); ?>

		<input type="submit" style="float:right" class="btn btn-info btn-lg" name="btnSubmit" value="Save">
		<input type="button" style="float:right;margin-right:15px" class="btn btn-warning btn-lg" value="Cancel" onclick="javascript:history.go(-1);"/>
	</form>


</body>
</html>

