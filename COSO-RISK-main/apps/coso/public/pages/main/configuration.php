 <!DOCTYPE html>
 <html lang="en">

 <?php
  // include "../../../model/connection_db.php"; 

//  if (isset($_POST["PrimerNombre"])) {
//    $nuevo_personal = $conn->query('INSERT INTO Personal (PrimerNombre, SegundoNombre, PrimerApellido, SegundoApellido, Cargo, Estado)
//                                      values ("' . $_POST["PrimerNombre"] . '","' . $_POST["SegundoNombre"] . '","' . $_POST["PrimerApellido"] . '","' . $_POST["SegundoApellido"] . '",
//                                      "' . $_POST["Cargo"] . '",1)');
//    if ($nuevo_personal) {
//      $ultima_persona = $conn->query('SELECT LAST_INSERT_ID() from Personal');
//      while ($unica_fila = $ultima_persona->fetch_row()) {
//        $resultado = $conn->query('INSERT INTO Usuario (Nombre, Correo, Contrasenia, Estado, IdRol, IdPersonal)
//                                      values ("' . $_POST["PrimerNombre"] . ' ' . $_POST["PrimerApellido"] . '","' . $_POST["Correo"] . '","' . $_POST["Contrasenia"] . '",1,' . $_POST["Rol"] . ',' . $unica_fila[0] . ')');
//        if (!$resultado) {
//          // echo $conn->error;
//        }
//      }
//    }
//  }

  ?>

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

    $Connection = new Connection();
    $conn = $Connection->getConnection();

    if ($result = $conn->query("CALL ValidateUser('" . $_GET['UID'] . "')")) {
      if ($row = $result->fetch_row()) {
        if ($row[0] != 0) {
          $user_reference->charger($row[1], $row[2], $row[3], $row[4], $_GET['UID']);
        } else {
          header("location:../helpers/sign-in.php");
        }
      } else {
        header("location:../helpers/sign-in.php");
      }
    } else {
      header("location:../helpers/sign-in.php");
    }

    $Connection->closeConnection();


    ?>
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

         <?php
          // insert the manu
          include(VIEWS . "menu.php");
          ?>

         <main class="content">
           <?php
            // insert the nav of the user
            include(VIEWS . "nav.php");
            ?>

           <div class="py-4">
             <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                 <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span></a></li>
                 <li class="breadcrumb-item"><a href="#">Configuración</a></li>
               </ol>
             </nav>
             <div class="d-flex justify-content-between w-100 flex-wrap">
               <div class="mb-3 mb-lg-0">
                 <h1 class="h4">Accesos</h1>
                 <p class="mb-0">Personal con acceso al sistema.</p>
               </div>
             </div>
           </div>

           <div class="row">
             <div class="col-12 mb-4">
               <div class="card border-light shadow-sm components-section">
                 <div class="card-body">
                   <div class="table-responsive">
                     <table class="table table-centered table-nowrap mb-0 rounded">
                       <thead class="thead-light">
                         <tr>
                           <th class="border-0">#</th>
                           <th class="border-0">Nombre y Apellido</th>
                           <th class="border-0">Rol</th>
                           <th class="border-0">Correo</th>
                           <th class="border-0">Estado</th>
                           <th class="border-0">Cargo</th>
                         </tr>
                       </thead>
                       <tbody>

                         <?php

                          // $respuesta = $conn->query('SELECT u.IdUsuario, concat(p.PrimerNombre," ", p.PrimerApellido), 
                          //                         r.Nombre, u.Correo, if(u.estado=0,"Inactivo","Activo"), p.Cargo
                          //                         from usuario u
                          //                         inner join rol r
                          //                         on u.IdRol = r.IdRol
                          //                         inner join personal p
                          //                         on p.IdPersonal = u.IdPersonal');

                          // while ($fila = $respuesta->fetch_row()) {
                          //   echo '<tr>';
                          //   echo '<td  class="border-0">' . $fila[0] . '</td>';
                          //   echo '<td  class="border-0">' . $fila[1] . '</td>';
                          //   echo '<td  class="border-0">' . $fila[2] . '</td>';
                          //   echo '<td  class="border-0">' . $fila[3] . '</td>';
                          //   echo '<td  class="border-0">' . $fila[4] . '</td>';
                          //   echo '<td  class="border-0">' . $fila[5] . '</td>';
                          //   echo '</tr>';
                          // }


                          ?>
                       </tbody>
                     </table>
                   </div>

                 </div>
               </div>
             </div>
           </div>

           <div class="row">
             <div class="col-12 mb-4">
               <div class="card border-light shadow-sm components-section">
                 <div class="card-body">
                   <h4>Formulario de Inserción de Personal</h4>
                   <form action="" method="post">
                     <div class="row mb-4">

                       <div class="col-lg-4 col-sm-6">
                         <div class="mb-4">
                           <label for="PrimerNombre">Primer Nombre</label>
                           <input type="text" class="form-control" id="PrimerNombre" name="PrimerNombre" placeholder="Primer Nombre" required>
                         </div>
                         <div class="mb-4">
                           <label for="SegundoNombre">Segundo Nombre</label>
                           <input type="text" class="form-control" id="SegundoNombre" name="SegundoNombre" placeholder="Segundo Nombre">
                         </div>
                       </div>
                       <div class="col-lg-4 col-sm-6">
                         <div class="mb-4">
                           <label for="PrimerApellido">Primer Apellido</label>
                           <input type="text" class="form-control" id="PrimerApellido" name="PrimerApellido" placeholder="Primer Apellido" required>
                         </div>
                         <div class="mb-4">
                           <label for="SegundoApellido">Segundo Apellido</label>
                           <input type="text" class="form-control" id="SegundoApellido" name="SegundoApellido" placeholder="Segundo Apellido">
                         </div>

                       </div>
                       <div class="col-lg-4 col-sm-6">
                         <div class="mb-4">
                           <label for="Correo">Correo Electrónico</label>
                           <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Correo para el login" required>
                         </div>
                         <div class="mb-4">
                           <label for="Contrasenia">Contraseña</label>
                           <input type="password" class="form-control" id="Contrasenia" name="Contrasenia" placeholder="Contraseña de ingreso" required>
                         </div>
                       </div>
                       <hr>
                       <div class="col-lg-4 col-sm-6">
                         <div class="mb-4">
                           <label for="Cargo">Cargo</label>
                           <input type="text" class="form-control" id="Cargo" name="Cargo" placeholder="Cargo" required>
                         </div>
                       </div>
                       <div class="col-lg-4 col-sm-6">
                         <div class="mb-4">
                           <label class="my-1 mr-2" for="Rol">Rol de Acceso</label>
                           <select class="form-select" id="Rol" aria-label="Default select example" name="Rol">
                             <option value="1">Administrador</option>
                             <option value="5">Staff - Colaborador</option>
                             <option value="15" selected>Visitante</option>
                           </select>
                         </div>
                       </div>
                       <div class="col-lg-4 col-sm-6">
                         <div class="mb-3">
                           <button class="btn btn-success large" style="margin: 10%;" type="submit">Salvar Información</button>
                         </div>
                       </div>
                     </div>
                   </form>
                 </div>
               </div>
             </div>
           </div>

         </main>


         <?php

          include(VIEWS . "scripts.php");
          ?>

       </div>
     </div>
   </div>

   <!-- Active the menu select -->
   <script>
     let navs = document.getElementsByClassName("nav-item");
     navs[4].className += " active";
     navs[0].className = "nav-item";
   </script>


 </body>

 </html>