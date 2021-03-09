<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Insufly &mdash; <?= $title ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css') ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
  <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.js') ?>"></script>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <img src="../assets/img/stisla-fill.svg" alt="logo" width="80" class="shadow-light rounded-circle mb-5 mt-2">
            <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">Insufly</span></h4>
            <p class="text-muted">Sebelum mengakses dashboard, kamu perlu login menggunakan akun yang pernah dibuat.</p>
            <form method="POST" class="needs-validation" novalidate="">
              <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                <div class="invalid-feedback">
                  Please fill in your username
                </div>
              </div>
              <div class="form-group">
                <div class="d-block">
                  <label for="password" class="control-label">Password</label>
                </div>
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="invalid-feedback">
                  please fill in your password
                </div>
              </div>
              <div class="form-group text-right">
                <button type="button" class="btn btn-primary btn-signin btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button>
              </div>
            </form>
            <div class="text-center mt-5 text-small">
              Copyright &copy; Insufly. Made with 💙
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="../assets/img/unsplash/login-bg.jpg">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">Hi, People</h1>
                <h5 class="font-weight-normal text-muted-transparent">Bali, Indonesia</h5>
              </div>
              Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="<?= base_url('assets/js/jquery-3.5.1.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/jquery.nicescroll.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/stisla.js') ?>"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
  <script src="<?= base_url('assets/js/custom.js') ?>"></script>

  <!-- Page Specific JS File -->
  <script>
    $(document).ready(function(){
      $('.btn-signin').click(function(){
        var username    = $('#username').val();
        var password    = $('#password').val();
        $.ajax({
          type          : 'POST',
          url           : "<?= base_url('auth/psignin') ?>",
          data          : {username:username,password:password},
          dataType      : 'JSON',
          success       : (res)=>{
            if(res.success === true){
              Swal.fire(
                'Berhasil Masuk',
                res.data,
                'success'
              ).then((result)=>{
                window.location = res.url;
              });
            }else{
              Swal.fire(
                'Gagal Masuk',
                res.data,
                'error'
              );
            }
          }
        });
      });
    });
  </script>
</body>
</html>

