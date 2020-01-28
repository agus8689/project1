<?php $flash_pesan=$this->session->flashdata('pesan')?>
<?php if (! empty($flash_pesan)) { ?>
    <div class="alert-info">
        <?php echo $flash_pesan;} ?>
    </div>
    <body class="login-page">
        <div class="login-box" style="margin-top:20px;">
            <div class="logo">
                <a href="javascript:void(0);">PT<b>HSK</b></a>
                <small>PT Handal Sukses Karya</small>
            </div>
            <div class="card">
                <div class="body">
                    <form action="<?php echo base_url('login/cek_login');?>" method="POST">
                        <div class="msg">Silakan Login Terlebih Dahulu</div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>