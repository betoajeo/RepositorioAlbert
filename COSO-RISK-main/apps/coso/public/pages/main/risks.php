<?php
$es_removible = false;

header("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

if (!isset($_GET['UID'])) {
  header("location:../helpers/sign-in.php");
}

include '../../../core/model/user/user.php';


include_once('../../../../../helpers/vars.php');

if ($isProduction) { 
  include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
  include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(DB . 'connection_db.php');
include(DB . '/public/public.php');
include(MODEL_PATH . '/risk/Risk.php'); 

$user_reference = new UserDTO();

$params_user = array(
  $_GET['UID']
);


$params_risk = array(
    $_GET['UID']
);

if (isset($_GET["remove"])) {

    $dele = new DeleteRisk();
    $dele->RiskId = intval( $_GET["id"]);
    $params_risk_deleted = array(
        $_GET['UID']
    );

    $result = new GenericResponse();

    $result = $dele->call_procedure_one('DeleteRisk', $params_risk, $dele);

    $es_removible = true;

}

$user_reference->call_procedure_one("ValidateUser", $params_user, $user_reference);

if ($user_reference->Exists == 0):
  header("location:../helpers/sign-in.php");
endif;

$risk = new RiskDTO();

$risks = $risk->call_procedure_multi("GetRisks", $params_risk, $risk);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include(VIEWS . "head.php");
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
          // inser the manu
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
                  <li class="breadcrumb-item"><a href="<?php echo './dashboard.php?UID=' . $_GET['UID']; ?>"><span class="fas fa-home"></span></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Riesgos</li>
                </ol>
              </nav>
              <h2 class="h4">Lista de Riesgos</h2>
              <p class="mb-0">Riesgos disponibles bajo 3CLICS.</p>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
              <div class="btn-toolbar">
                <a class="btn btn-primary btn-sm mr-2 dropdown-toggle" aria-haspopup="true" aria-expanded="false" href="<?php echo '../components/add_risk.php?UID=' . $_GET['UID']; ?>">
                  <span class="fas fa-plus mr-2"></span>Agregar
                </a>

              </div>
            </div>
          </div>
          <div class="table-settings mb-4">
          </div>
          <div class="card card-body border-light shadow-sm table-wrapper table-responsive ">
            <table class="table table-hover">
              <thead class="thead-light">
                <tr>
                  <th class="border-0">#</th>
                  <th class="border-0">Nombre</th>
                  <th class="border-0">Responsable</th>
                  <th class="border-0">Tipo</th>
                  <th class="border-0">Monto Total</th>
                  <th class="border-0">% Aceptación</th>
<!--                  <th class="border-0">Descripción</th>-->
                  <th class="border-0">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (count($risks) > 0): 
                  foreach ($risks as $risk_one) {
                    echo "<tr>";
                    echo '<td  class="border-0"><a href="../components/risk_action.php?id=' . $risk_one->IdRisk . '&UID=' . $_GET["UID"] . '" class="font-weight-bold">' . $risk_one->IdRisk . '</a></td>';
                    echo '<td  class="border-0"><a href="../components/risk_action.php?id=' . $risk_one->IdRisk . '&UID=' . $_GET["UID"]. '" class="font-weight-bold resalt text-wrap">' . $risk_one->RiskName . '</a></td>';
                    echo '<td class="border-0"><span class="font-weight-bold">' . $risk_one->Responsable . '</span></td>';
                    echo '<td class="border-0"><span class="font-weight-bold text-wrap">' . $risk_one->RiskTypeName . '</span></td>';
                    echo '<td class="border-0"><span class="font-weight-bold ">$' . 0 . '</span></td>';
                    echo '<td class="border-0" ><div class="row d-flex align-items-center">
                                                                    <div class="col-12 col-xl-2 px-0">
                                                                        <div class="small font-weight-bold">' . $risk_one->RiskProbabilityAcceptable . '%   </div>
                                                                    </div>
                                                                    <div class="col-12 col-xl-10 px-0 px-xl-1">
                                                                        <div class="progress progress-lg mb-0">
                                                                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="' . $risk_one->RiskProbabilityAcceptable . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $risk_one->RiskProbabilityAcceptable * 100 . '%;"></div>
                                                                        </div>
                                                                    </div>
                                                                </div></div>';
//                    echo '<td><span class="font-weight-bold ">'.$risk_one->RiskDescription.'%</span></td>';
                    if (!is_null($risk_one->IdPlan)) {
                      echo '<td  class="border-0">
                                                    <div class="btn-group">
                                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <span class="icon icon-sm">
                                                                <span class="fas fa-ellipsis-h icon-dark"></span>
                                                            </span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#modal-default' . $risk_one->IdRisk . '">
                                                              <span class="fas fa-eye mr-2"></span>Ver Detalles
                                                            </a> 
                                                            <a class="dropdown-item" href="./components/accions.php?user_name=' . $user_reference->Name . '&UID=' . $user_reference->UID . '&plan=' . $risk_one->IdRisk . '">
                                                              <span class="fas fa-eye mr-2"></span>Ver Acciones
                                                            </a>  
                                                            <a class="dropdown-item text-danger" href="./risks.php?id=' . $risk_one->IdRisk . '&UID=' . $_GET['UID'] . '&remove=1"><span class="fas fa-trash-alt mr-2"></span>Remover</a>
                                                          </div>
                                                          <div class="modal fade" id="modal-default' . $risk_one->IdRisk . '" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                                                              <div class="modal-dialog modal-dialog-centered" role="document">
                                                                  <div class="modal-content">
                                                                      <div class="modal-header">
                                                                          <h2 class="h6 modal-title">' . $risk_one->RiskName . '</h2>
                                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                              <span aria-hidden="true">&times;</span>
                                                                          </button>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                          <h4>Descripción</h4>
                                                                          <p class="text-wrap">' . $risk_one->RiskDescription . '</p>
                                                                          <h5>Clasificación de riesgo</h5>
                                                                          <p>' . $risk_one->RiskLevel . '</p>
                                                                      </div>
                                                                      <div class="modal-footer">
                                                                          <a type="button" class="btn btn-sm btn-secondary" href="./components/controls.php?user_name=' . $user_reference->Name . '&UID' . $user_reference->UID . '&id=' . $risk_one->IdRisk . '">
                                                                            Ver Controles
                                                                          </a>
                                                                          <button type="button" class="btn btn-link text-danger ml-auto" data-dismiss="modal">Close</button>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                              </div>  
                                                          </div>
                                                       </td>';
                    } else {
                      echo '<td  class="border-0">
                                                  <div class="btn-group">
                                                      <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          <span class="icon icon-sm">
                                                              <span class="fas fa-ellipsis-h icon-dark"></span>
                                                          </span>
                                                          <span class="sr-only">Toggle Dropdown</span>
                                                      </button>
                                                      <div class="dropdown-menu">
                                                          <a class="dropdown-item" data-toggle="modal" data-target="#modal-default' . $risk_one->IdRisk . '">
                                                            <span class="fas fa-eye mr-2"></span>Ver Detalles
                                                          </a>  
                                                          <a class="dropdown-item text-danger" href="./risks.php?id=' . $risk_one->IdRisk . '&UID=' . $_GET['UID'] . '&remove=1"><span class="fas fa-trash-alt mr-2"></span>Remover</a>
                                                        </div>
                                                        <div class="modal fade" id="modal-default' . $risk_one->IdRisk . '" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 class="h6 modal-title">' . $risk_one->RiskName . '</h2>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h4>Descripción</h4>
                                                                        <p class="text-wrap">' . $risk_one->RiskDescription . '</p>
                                                                        <h5>Clasificación de riesgo</h5>
                                                                        <p>' . $risk_one->RiskLevel . '</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <a type="button" class="btn btn-sm btn-secondary" href="../components/controls.php?user_name=' . $user_reference->Name. '&UID=' . $user_reference->UID . '&id=' . $risk_one->IdRisk . '">
                                                                          Ver Controles
                                                                        </a>
                                                                        <button type="button" class="btn btn-link text-danger ml-auto" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                </td>';
                    }
                    echo "</tr>";
                  }
                endif;
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
  v
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
    navs[1].className += " active";
    navs[0].className = "nav-item";
  </script>

</body>

</html>