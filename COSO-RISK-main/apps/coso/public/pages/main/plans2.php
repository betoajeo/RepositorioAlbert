<?php
// primeramente se consulta si existen los _GET
// sino, simplemente no está logeado
if (!isset($_GET['user_name']) || !isset($_GET['user_id'])) {
  header("location:../examples/sign-in.php");
}

$es_removible = false;
// if(isset($_GET["remove"])) {

//   $es_removible = true;
//   include "../../model/connectBion_db.php";

//   $repuesta = $conn->query('UPDATE Riesgo set Estado = 0 where IdRiesgo='.$_GET["id"]);
//   if(!$repuesta) {
//     $es_removible = false;
//   }

// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>3CLICS - Planes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="title" content="Volt Bootstrap 5 Dashboard - Transactions">
  <meta name="author" content="Themesberg">
  <meta name="description" content="Volt is a free and open source Bootstrap 5 Admin Dashboard featuring 11 example pages, 100 components and 3 plugins with Vanilla JS.">
  <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, free bootstrap 5 dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
  <link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://demo.themesberg.com/volt">
  <meta property="og:title" content="Volt Bootstrap 5 Dashboard - Transactions">
  <meta property="og:description" content="Volt is a free and open source Bootstrap 5 Admin Dashboard featuring 11 example pages, 100 components and 3 plugins with Vanilla JS.">
  <meta property="og:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-bootstrap-5-dashboard/volt-bootstrap-5-dashboard-preview.jpg">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="https://demo.themesberg.com/volt">
  <meta property="twitter:title" content="Volt Bootstrap 5 Dashboard - Transactions">
  <meta property="twitter:description" content="Volt is a free and open source Bootstrap 5 Admin Dashboard featuring 11 example pages, 100 components and 3 plugins with Vanilla JS.">
  <meta property="twitter:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-bootstrap-5-dashboard/volt-bootstrap-5-dashboard-preview.jpg">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">

  <!-- Fontawesome -->
  <link type="text/css" href="../vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">
  <link type="text/css" href="../css/our-styless.css" rel="stylesheet">

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

</head>

<body>

  <nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none">
    <a class="navbar-brand mr-lg-5" href="../../index.html">
      <img class="navbar-brand-dark" src="../../assets/img/brand/light.svg" alt="Volt logo" /> <img class="navbar-brand-light" src="../../assets/img/brand/dark.svg" alt="Volt logo" />
    </a>
    <div class="d-flex align-items-center">
      <button class="navbar-toggler d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <div class="container-fluid bg-soft">
    <div class="row">
      <div class="col-12">

        <nav id="sidebarMenu" class="sidebar d-md-block bg-primary text-white collapse" data-simplebar>
          <div class="sidebar-inner px-4 pt-3">
            <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
              <div class="d-flex align-items-center">
                <div class="user-avatar lg-avatar mr-4">
                  <img src="../../assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white" alt="Bonnie Green">
                </div>
              </div>
              <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" class="fas fa-times" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation"></a>
              </div>
            </div>
            <ul class="nav flex-column">
              <li class="nav-item  active ">
                <a href="<?php echo './dashboard/dashboard.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>" class="nav-link">
                  <span class="sidebar-icon"><span class="fas fa-home"></span></span>
                  <span>Inicio</span>
                </a>
              </li>
              <li class="nav-item ">
                <a href="<?php echo './transactions.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>" class="nav-link">
                  <span class="sidebar-icon"><span class="fas fa-exclamation-circle"></span></span>
                  <span>Riesgos</span>
                </a>
              </li>
              <li class="nav-item ">
                <a href="<?php echo './settings.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>" class="nav-link">
                  <span class="sidebar-icon"><span class="fas fa-clipboard"></span></span>
                  <span>Planes</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo './tables/bootstrap-tables.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>" class="nav-link">
                  <span class="sidebar-icon"><span class="fas fa-table"></span></span>
                  <span>Bitácora</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo './components/buttons.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>" class="nav-link">
                  <span class="sidebar-icon"><span class="fas fa-sliders-h"></span></span>
                  <span>Configuración</span>
                </a>
              </li>
              <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
              <li class="nav-item">
                <a href="https://www.piranirisk.com/es/academia/especiales/coso-una-vision-360-grados-para-gestionar-el-riesgo" class="nav-link d-flex align-items-center">
                  <span class="sidebar-icon">
                    <img src="../assets/img/brand/light.svg" height="20" width="20" alt="Volt Logo">
                  </span>
                  <span class="mt-1">Conocer más</span>
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main class="content">

          <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark pl-0 pr-2 pb-0">
            <div class="container-fluid px-0">
              <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
                <div class="d-flex">
                  <form class="navbar-search form-inline" id="navbar-search-main">
                    <div class="input-group input-group-merge search-bar">
                      <span class="input-group-text" id="topbar-addon" style="display:none;"><span class="fas fa-search"></span></span>
                      <input type="text" class="form-control" id="topbarInputIconLeft" style="display:none;" placeholder="Search" aria-label="Search" aria-describedby="topbar-addon">
                    </div>
                  </form>
                </div>
                <!-- Navbar links -->
                <ul class="navbar-nav align-items-center">
                  <li class="nav-item dropdown">
                    <a class="nav-link pt-1 px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <div class="media d-flex align-items-center">
                        <img class="user-avatar md-avatar rounded-circle" alt="Image placeholder" src="../assets/img/illustrations/user.jpg">
                        <div class="media-body ml-2 text-dark align-items-center d-none d-lg-block">
                          <span class="mb-0 font-small font-weight-bold"><?php echo $_GET["user_name"]; ?></span>
                        </div>
                      </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-right mt-2">
                      <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-sign-out-alt text-danger"></span>Salir</a>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </nav>

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                  <li class="breadcrumb-item"><a href="<?php echo './dashboard/dashboard.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>"><span class="fas fa-home"></span></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Riesgos</li>
                </ol>
              </nav>
              <h2 class="h4">Lista de Planes</h2>
              <p class="mb-0">Planes disponibles bajo 3CLICS.</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
              <div class="btn-toolbar">
                <a class="btn btn-primary btn-sm mr-2 dropdown-toggle" aria-haspopup="true" aria-expanded="false" href="<?php echo './components/forms.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id']; ?>">
                  <span class="fas fa-plus mr-2"></span>Agregar
                </a>

              </div>
            </div>
          </div>
          <div class="table-settings mb-4">
          </div>
          <div class="card card-body border-light shadow-sm table-wrapper table-responsive pt-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Responsable</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php

                include "../../model/connection_db.php";
                $resultado =
                  $conn->query("SELECT p.idplan, p.nombre, concat(pr.PrimerNombre, ' ', pr.PrimerApellido) 
                                          from plan p
                                          inner join personal pr
                                          on pr.IdPersonal = p.IdPersonal
                                          where p.Estado = 1
                                          order by p.idplan asc");
                while ($fila = $resultado->fetch_row()) {
                  echo "<tr>";
                  echo '<td><a href="./components/form_edit.php?id=' . $fila[0] . '&user_name=' . $_GET["user_name"] . '&user_id=' . $_GET["user_id"] . '" class="font-weight-bold">' . $fila[0] . '</a></td>';
                  echo '<td><a href="./components/form_edit.php?id=' . $fila[0] . '&user_name=' . $_GET["user_name"] . '&user_id=' . $_GET["user_id"] . '" class="font-weight-bold resalt text-wrap">' . $fila[1] . '</a></td>';
                  echo '<td><span class="font-weight-bold">' . $fila[2] . '</span></td>';
                  echo '<td>
                                            <div class="btn-group">
                                                <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="icon icon-sm">
                                                        <span class="fas fa-ellipsis-h icon-dark"></span>
                                                    </span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" data-toggle="modal" data-target="#modal-default' . $fila[0] . '">
                                                      <span class="fas fa-eye mr-2"></span>Ver Acciones
                                                    </a>  
                                                    <a class="dropdown-item text-danger" href="./transactions.php?id=' . $fila[0] . '&user_name=' . $_GET["user_name"] . '&user_id=' . $_GET["user_id"] . '&remove=true"><span class="fas fa-trash-alt mr-2"></span>Remover</a>
                                                  </div> 
                                          </td>';
                  echo "</tr>";
                }
                ?>

              </tbody>
            </table>
            <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">

            </div>
          </div>
          <footer class="footer section py-5">
            <div class="row">
              <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <p class="mb-0 text-center text-xl-left">Copyright © 2019-<span class="current-year"></span> <a class="text-primary font-weight-normal" href="https://themesberg.com" target="_blank">Themesberg</a></p>
              </div>

              <div class="col-12 col-lg-6">
                <ul class="list-inline list-group-flush list-group-borderless text-center text-xl-right mb-0">
                  <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/about">About</a>
                  </li>
                  <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/themes">Themes</a>
                  </li>
                  <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/blog">Blog</a>
                  </li>
                  <li class="list-inline-item px-0 px-sm-2">
                    <a href="https://themesberg.com/contact">Contact</a>
                  </li>
                </ul>
              </div>
            </div>
          </footer>
        </main>
      </div>
    </div>
  </div>

  <!-- Core -->
  <script src="../vendor/popper.js/dist/umd/popper.min.js"></script>
  <script src="../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Vendor JS -->
  <script src="../vendor/onscreen/dist/on-screen.umd.min.js"></script>

  <!-- Slider -->
  <script src="../vendor/nouislider/distribute/nouislider.min.js"></script>

  <!-- Jarallax -->
  <script src="../vendor/jarallax/dist/jarallax.min.js"></script>

  <!-- Smooth scroll -->
  <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

  <!-- Count up -->
  <script src="../vendor/countup.js/dist/countUp.umd.js"></script>

  <!-- Notyf -->
  <script src="../vendor/notyf/notyf.min.js"></script>

  <!-- Charts -->
  <script src="../vendor/chartist/dist/chartist.min.js"></script>
  <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

  <!-- Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

  <!-- Simplebar -->
  <script src="../vendor/simplebar/dist/simplebar.min.js"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- Volt JS -->
  <script src="../assets/js/volt.js"></script>

  <?php
  if ($es_removible) {

    echo '<script> 
        const notyf = new Notyf({
                  position: {
                      x: "right",
                      y: "bottom",
                  },
                  types: [
                      {
                        type: "error",
                        background: "#FA5151",
                        icon: {
                            className: "fas fa-times",
                            tagName: "span",
                            color: "#fff"
                        },
                        dismissible: false
                    }
                  ]
              });
              notyf.open({
                  type: "error",
                  message: "Ya no se mostrará el Riesgo."
              });
        
        </script>';
  }

  ?>

</body>

</html>