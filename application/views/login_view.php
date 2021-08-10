<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/lib/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/fontawesome-free-5.12.0-web/css/all.min.css')?>">
    <title>Login</title>
  </head>
  <body>
    <div class="container mt-5" style="width:32rem;">
      <form action="<?php echo site_url('login/auth')?>" method="post">
        <label for="basic-url" class="form-label">Nama</label>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
          <input name="username" type="text" class="form-control form-control-lg" placeholder="Nama" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <label for="basic-url" class="form-label">Sandi</label>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><i class="fas fa-key"></i></span>
          <input name="password" type="password" class="form-control form-control-lg" placeholder="Sandi" aria-label="Password" aria-describedby="basic-addon1">
        </div>
        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sign-in-alt"></i> Masuk</button>

        <span class="text-danger"><?php echo $this->session->flashdata('msg')?></span>
      </form>

    </div>
  </body>
</html>
