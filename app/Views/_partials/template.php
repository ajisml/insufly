<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Invoice &mdash; <?= $title ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/css/all.min.css') ?>">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css') ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/costume.css') ?>">
  <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.js') ?>"></script>
  <?= $this->renderSection('head') ?>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1"></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="features-settings.html" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Insufly</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">IS</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item">
                <a href="<?= base_url('') ?>" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
              </li>
              <li class="menu-header">Starter</li>
              <li class="nav-item">
                <a href="<?= base_url('home/inv') ?>" class="nav-link"><i class="fas fa-file-invoice"></i><span>Invoice</span></a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('home/product') ?>" class="nav-link"><i class="fas fa-archive"></i><span>Kelola Produk</span></a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('home/variant') ?>" class="nav-link"><i class="fas fa-circle"></i><span>Kelola Variasi</span></a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('home/cat') ?>" class="nav-link"><i class="fas fa-circle"></i><span>Kelola Kategori</span></a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('home/users') ?>" class="nav-link"><i class="fas fa-users"></i><span>Kelola Pengguna</span></a>
              </li>
            </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
        <?= $this->renderSection('s-body') ?>
        </section>
      </div>
      <?= $this->renderSection('s-footer') ?>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
        </div>
        <div class="footer-right">
          2.3.0
        </div>
      </footer>
    </div>
  </div>
  <?= $this->renderSection('bottom') ?>
  <!-- General JS Scripts -->
  <script src="<?= base_url('assets/js/jquery-3.5.1.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/jquery.nicescroll.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/stisla.js') ?>"></script>

  <!-- JS Libraies -->
  <?= $this->renderSection('library') ?>
  <!-- Template JS File -->
  <script src="<?= base_url('assets/js/scripts.js') ?>"></script>
  <script src="<?= base_url('assets/js/custom.js') ?>"></script>
  <!-- Page Specific JS File -->
  <?= $this->renderSection('js') ?>
  <script>
    $(document).ready(function(){
      $('.btn-logout').click(function(){
        Swal.fire({
          title     : 'Yakin mau keluar ?',
          text      : 'Jika keluar maka sesi akan berakhir',
          icon      : 'warning',
          showCancelButton  : true,
        }).then((result)=>{
          if(result.isConfirmed){
            window.location = "<?= base_url('auth/psignout') ?>";
          }
        });
      });
    });
  </script>
</body>
</html>

