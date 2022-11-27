<?php
    // primeramente se consulta si existen los _GET
    // sino, simplemente no está logeado
    if(!isset($_GET['user_name']) || !isset($_GET['user_id'])) {
        header("location:../examples/sign-in.php");
    }
    
    include "../../../model/connection_db.php"; 
    
    $Nombre = "";
    $Riesgo = "";

    $respuesta = $conn->query("SELECT p.Nombre, r.nombre FROM plan p inner join riesgo r on r.idplan = p.idplan where p.idplan=".$_GET["plan"]);
    if($fila = $respuesta->fetch_row()) {
      $Nombre = $fila[0];
      $Riesgo = $fila[1];
    }

    if(isset($_POST["NombreAccion"])) {
      $estado = 1;

      $insertado = $conn->query('INSERT into accion (Nombre, Descripcion, Costo, IdResponsablbe, Estado, IdPlan) 
                                  values("'.$_POST["NombreAccion"].'", "'.$_POST["DescripcionAccion"].'", '.$_POST["Costo"].', '.$_POST["Responsable"].', '.$estado .', '.$_GET["plan"].')');
      if(!$insertado) {
        echo $conn->error;
      }
    } 

?>
<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<title>3CLICS - Plan</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="Volt Bootstrap 5 Dashboard - Forms">
<meta name="author" content="Themesberg">
<meta name="description" content="Volt is a free and open source Bootstrap 5 Admin Dashboard featuring 11 example pages, 100 components and 3 plugins with Vanilla JS.">
<meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, free bootstrap 5 dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, themesberg, themesberg dashboard, themesberg admin dashboard" />
<link rel="canonical" href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://demo.themesberg.com/volt">
<meta property="og:title" content="Volt Bootstrap 5 Dashboard - Forms">
<meta property="og:description" content="Volt is a free and open source Bootstrap 5 Admin Dashboard featuring 11 example pages, 100 components and 3 plugins with Vanilla JS.">
<meta property="og:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-bootstrap-5-dashboard/volt-bootstrap-5-dashboard-preview.jpg">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://demo.themesberg.com/volt">
<meta property="twitter:title" content="Volt Bootstrap 5 Dashboard - Forms">
<meta property="twitter:description" content="Volt is a free and open source Bootstrap 5 Admin Dashboard featuring 11 example pages, 100 components and 3 plugins with Vanilla JS.">
<meta property="twitter:image" content="https://themesberg.s3.us-east-2.amazonaws.com/public/products/volt-bootstrap-5-dashboard/volt-bootstrap-5-dashboard-preview.jpg">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="../../assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="../../assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<!-- Fontawesome -->
<link type="text/css" href="../../vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

<!-- Notyf -->
<link type="text/css" href="../../vendor/notyf/notyf.min.css" rel="stylesheet">

<!-- Volt CSS -->
<link type="text/css" href="../../css/volt.css" rel="stylesheet">

<!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

</head>

<body class="bg-soft">

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
            <a href="#sidebarMenu" class="fas fa-times" data-toggle="collapse"
                data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
                aria-label="Toggle navigation"></a>
        </div>
      </div>
      <ul class="nav flex-column">
        <li class="nav-item  active ">
          <a href="<?php echo '../../pages/dashboard/dashboard.php?user_name='.$_GET['user_name'].'&user_id='.$_GET['user_id']; ?>" class="nav-link">
            <span class="sidebar-icon"><span class="fas fa-home"></span></span>
            <span>Inicio</span>
          </a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo '../../pages/transactions.php?user_name='.$_GET['user_name'].'&user_id='.$_GET['user_id']; ?>" class="nav-link">
              <span class="sidebar-icon"><span class="fas fa-exclamation-circle"></span></span>
              <span>Riesgos</span>
          </a>
        </li>
        <li class="nav-item ">
          <a href="<?php echo '../../pages/settings.php?user_name='.$_GET['user_name'].'&user_id='.$_GET['user_id']; ?>" class="nav-link">
              <span class="sidebar-icon"><span class="fas fa-clipboard"></span></span>
              <span>Planes</span>
          </a>
        </li>
        <li class="nav-item">
            <a href="<?php echo '../tables/bootstrap-tables.php?user_name='.$_GET['user_name'].'&user_id='.$_GET['user_id']; ?>" class="nav-link">
              <span class="sidebar-icon"><span class="fas fa-table"></span></span>
              <span>Bitácora</span>
            </a> 
        </li>
        <li class="nav-item">
            <a href="<?php echo '../components/buttons.php?user_name='.$_GET['user_name'].'&user_id='.$_GET['user_id']; ?>" class="nav-link">
              <span class="sidebar-icon"><span class="fas fa-sliders-h"></span></span> 
              <span>Configuración</span>
            </a> 
        </li>
        <li role="separator" class="dropdown-divider mt-4 mb-3 border-black"></li>
        <li class="nav-item">
          <a href="https://www.piranirisk.com/es/academia/especiales/coso-una-vision-360-grados-para-gestionar-el-riesgo" class="nav-link d-flex align-items-center">
            <span class="sidebar-icon">
              <img src="../../assets/img/brand/light.svg" height="20" width="20" alt="Volt Logo">
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
          <!-- Search form -->
          <form class="navbar-search form-inline" id="navbar-search-main">
            <div class="input-group input-group-merge search-bar">
                <span class="input-group-text" id="topbar-addon"><span class="fas fa-search"></span></span>
                <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Search" aria-label="Search" aria-describedby="topbar-addon">
            </div>
          </form>
        </div>
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center">
          <li class="nav-item dropdown"> 
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link pt-1 px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media d-flex align-items-center">
                <img class="user-avatar md-avatar rounded-circle" alt="Image placeholder" src="../../assets/img/illustrations/user.jpg">
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

                        <div class="py-4">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                    <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Acciones de Plan</li>
                                </ol>
                            </nav>
                            <h2 class="h4 text-wrap">Acciones del Plan  '<?php echo $Nombre; ?>'</h2>
                            <h3 class="h4 text-wrap">Para el Riesgo '<?php echo $Riesgo; ?>'</h3>
                             

                            <div class="btn-toolbar  justify-content-md-end">
                                <button class="btn btn-primary btn-sm mr-2 dropdown-toggle" aria-haspopup="true" aria-expanded="false"  data-toggle="modal" data-target="#modal-form">
                                    <span class="fas fa-plus mr-2"></span>Agregar
                                </button> 
                                <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <div class="card border-light p-4">
                                                    <div class="card-header border-0 text-center pb-0">
                                                        <h2 class="h4">Acción</h2>
                                                        <span>Por favor rellene los siguientes datos.</span>   
                                                    </div>
                                                    <div class="card-body">
                                                        <form action="<?php echo './accions.php?plan='.$_GET["plan"].'&user_name='.$_GET["user_name"].'&user_id='.$_GET["user_id"]; ?>" class="mt-4" method="post">
                                                            <!-- Form -->
                                                            <div class="form-group mb-4">
                                                                <label for="NombreAccion">Nombre de la Acción</label>
                                                                <div class="input-group"> 
                                                                    <input type="text" class="form-control" id="NombreAccion" name="NombreAccion" required>
                                                                </div>  
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="form-group mb-4">
                                                                    <label for="DescripcionAccion">Descripción</label>
                                                                    <div class="input-group"> 
                                                                        <textarea class="form-control" id="DescripcionAccion" name="DescripcionAccion" placeholder="Detalle..." rows="5" required></textarea>
                                                                    </div>  
                                                                </div>
                                                            </div>
                                                            <div class="mb-4">
                                                              <label class="my-1 mr-2" for="Responsable">Responsable</label>
                                                              <select class="form-select" id="Responsable" aria-label="Default select example" name="Responsable" required>
                                                                <?php

                                                                  $resultado = 
                                                                    $conn->query("SELECT PrimerNombre, PrimerApellido, IdPersonal FROM Personal where Estado = 1");
                                                                  $iterador = 1;
                                                                  while ($fila = $resultado->fetch_row()) {
                                                                    if($iterador == 1) {
                                                                      echo '<option value="'.$fila[2].'" selected>'.$fila[0].' '.$fila[1].'</option>';
                                                                    } else {
                                                                      echo '<option  value="'.$fila[2].'">'.$fila[0].' '.$fila[1].'</option>';
                                                                    }
                                                                    $iterador = $iterador + 1;
                                                                  } 
                                                                ?> 
                                                              </select>
                                                          </div> 
                                                          <div class="mb-4">
                                                            <label for="Costo">Costo de implementación</label>
                                                            <input type="number" class="form-control" id="Costo" placeholder="Más a 0" name="Costo" required> 
                                                          </div> 
                                                            <button type="submit" class="btn btn-block btn-primary">Guardar</button>
                                                        </form> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-12 mb-4">
                            <div class="card border-light shadow-sm components-section">
                              <div class="card-body">  
                                 <h5>Acciones definidas</h5>
                                        <div class="card border-light shadow-sm mb-4">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-centered table-nowrap mb-0 rounded">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th class="border-0">#</th>
                                                                <th class="border-0">Nombre</th>
                                                                <th class="border-0">Descripción</th>
                                                                <th class="border-0">Costo</th>
                                                                <th class="border-0">Responsable</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php

                                                          $controles = $conn->query('SELECT IdAccion, nombre, descripcion, costo, concat(p.primernombre, " ", p.primerapellido) 
                                                            from accion a inner join personal p on p.idpersonal = a.idresponsablbe
                                                            where idplan='.$_GET["plan"]);
                                                          while ($fila = $controles->fetch_row()) {
                                                            echo "<tr>";
                                                            echo '<td class="border-0">'.$fila[0].'</td>';
                                                            echo '<td class="border-0 font-weight-bold">
                                                                    <a href="#" class="text-primary font-weight-bold">
                                                                      '.$fila[1].'
                                                                    </a>
                                                                  </td>';
                                                            echo '<td class="border-0 text-wrap">
                                                                    '.$fila[2].'
                                                                  </td>';
                                                            echo '<td class="border-0">
                                                                    $'.$fila[3].'
                                                                  </td>';
                                                            echo '<td class="border-0">
                                                                    '.$fila[4].'
                                                                  </td>';
                                                            echo "</tr>";
                                                          }

                                                        ?> 
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
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
<script src="../../vendor/popper.js/dist/umd/popper.min.js"></script>
<script src="../../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Vendor JS -->
<script src="../../vendor/onscreen/dist/on-screen.umd.min.js"></script>

<!-- Slider -->
<script src="../../vendor/nouislider/distribute/nouislider.min.js"></script>

<!-- Jarallax -->
<script src="../../vendor/jarallax/dist/jarallax.min.js"></script>

<!-- Smooth scroll -->
<script src="../../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

<!-- Count up -->
<script src="../../vendor/countup.js/dist/countUp.umd.js"></script>

<!-- Notyf -->
<script src="../../vendor/notyf/notyf.min.js"></script>

<!-- Charts -->
<script src="../../vendor/chartist/dist/chartist.min.js"></script>
<script src="../../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>

<!-- Datepicker -->
<script src="../../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script>

<!-- Simplebar -->
<script src="../../vendor/simplebar/dist/simplebar.min.js"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Volt JS -->
<script src="../../assets/js/volt.js"></script>
<script src="../../assets/js/helpers.js"></script>

</body>

</html>
