<?php
// primeramente se consulta si existen los _GET
// sino, simplemente no está logeado
// if(!isset($_GET['user_name']) || !isset($_GET['user_id'])) {
//     header("location:../examples/sign-in.php");
// }


$es_removible = false;
//if (isset($_GET["remove"])) {
//  $es_removible = true;
//
//  include "../../model/connection_db.php";
//
//  $repuesta = $conn->query('UPDATE Riesgo set idplan = 0 where idplan=' . $_GET["id"]);
//  if (!$repuesta) {
//    $es_removible = false;
//  } else {
//    $removido = $conn->query('UPDATE Plan set estado = 0 where idplan = ' . $_GET["id"]);
//  }
//}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  header("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache");

  if (!isset($_GET['UID'])) {
    header("location:../helpers/sign-in.php");
  }


  include_once('../../../../../helpers/vars.php');

    if ($isProduction) { 
      include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
    } else {
      include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
    }
  include(VIEWS . "head.php");
  include(DB . 'connection_db.php');


  include '../../../core/model/user/UserReference.php';
  $user_reference = new UserReference();

//  $Connection = new Connection();
//  $conn = $Connection->getConnection();

//  if ($result = $conn->query("CALL ValidateUser('" . $_GET['UID'] . "')")) {
//    if ($row = $result->fetch_row()) {
//      if ($row[0] != 0) {
//        $user_reference->charger($row[1], $row[2], $row[3], $row[4], $_GET['UID']);
//      } else {
//        header("location:../helpers/sign-in.php");
//      }
//    } else {
//      header("location:../helpers/sign-in.php");
//    }
//  } else {
//    header("location:../helpers/sign-in.php");
//  }

//  $Connection->closeConnection();


  ?>
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

        <?php
        // insert the manu
        include(VIEWS . "menu.php");
        ?>

        <main class="content">

          <?php
          // insert the nav of the user
          include(VIEWS . "nav.php");
          ?>

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
            <div class="d-block mb-4 mb-md-0">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                  <li class="breadcrumb-item"><a href="<?php echo './dashboard/dashboard.php?user_name='; ?>"><span class="fas fa-home"></span></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Planes</li>
                </ol>
              </nav>
              <h2 class="h4">Lista de Planes</h2>
              <p class="mb-0">Planes disponibles bajo 3CLICS.</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
              <div class="btn-toolbar">
                <a class="btn btn-primary btn-sm mr-2 dropdown-toggle" aria-haspopup="true" aria-expanded="false" href="<?php echo './components/form_plan.php?user_name='; ?>">
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
                  <th>Riesgo</th>
                  <th>Responsable</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php

                // include "../../model/connection_db.php";
                // $resultado =
                //   $conn->query("SELECT p.idplan, p.nombre, r.nombre, concat(pr.PrimerNombre, ' ', pr.PrimerApellido) 
                //                           from plan p
                //                           inner join riesgo r
                //                           on r.idplan = p.idplan
                //                           inner join personal pr
                //                           on pr.IdPersonal = p.IdPersonal
                //                           where p.Estado = 1
                //                           order by p.idplan asc");
                // while ($fila = $resultado->fetch_row()) {
                //   echo "<tr>";
                //   echo '<td><a href="./components/form_plan.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id'] . '&plan=' . $fila[0] . '" class="font-weight-bold">' . $fila[0] . '</a></td>';
                //   echo '<td><a href="./components/form_plan.php?user_name=' . $_GET['user_name'] . '&user_id=' . $_GET['user_id'] . '&plan=' . $fila[0] . '" class="font-weight-bold resalt text-wrap">' . $fila[1] . '</a></td>';
                //   echo '<td><span class="font-weight-bold">' . $fila[2] . '</span></td>';
                //   echo '<td><span class="font-weight-bold">' . $fila[3] . '</span></td>';
                //   echo '<td>
                //                             <div class="btn-group">
                //                                 <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                //                                     <span class="icon icon-sm">
                //                                         <span class="fas fa-ellipsis-h icon-dark"></span>
                //                                     </span>
                //                                     <span class="sr-only">Toggle Dropdown</span>
                //                                 </button>
                //                                 <div class="dropdown-menu">
                //                                     <a class="dropdown-item" data-toggle="modal" href="./components/accions.php?plan=' . $fila[0] . '&user_name=' . $_GET["user_name"] . '&user_id=' . $_GET["user_id"] . '">
                //                                       <span class="fas fa-eye mr-2"></span>Ver Acciones
                //                                     </a>  
                //                                     <a class="dropdown-item text-danger" href="./settings.php?id=' . $fila[0] . '&user_name=' . $_GET["user_name"] . '&user_id=' . $_GET["user_id"] . '&remove=true"><span class="fas fa-trash-alt mr-2"></span>Remover</a>
                //                                   </div> 
                //                           </td>';
                //   echo "</tr>";
                // }
                ?>

              </tbody>
            </table>
            <div class="card-footer px-3 border-0 d-flex align-items-center justify-content-between">

            </div>
          </div>
        </main>

        <?php

        include(VIEWS . "scripts.php");
        ?>

      </div>
    </div>
  </div>

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
  <!-- Active the menu select -->
  <script>
    let navs = document.getElementsByClassName("nav-item");
    navs[2].className += " active";
    navs[0].className = "nav-item";
  </script>
</body>

</html>