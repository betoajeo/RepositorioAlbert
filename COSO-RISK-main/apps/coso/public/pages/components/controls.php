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
include_once(DB . 'connection_db.php');
include(MODEL_PATH . '/risk/Risk.php');
include(MODEL_PATH . '/user/user.php');
include(MODEL_PATH . '/user/Personal.php');
include(MODEL_PATH . '/risk/control.php');
include_once(DB . '/public/public.php');

$user_reference = new UserDTO();

$params = array(
    $_GET['UID']
);

$user_reference->call_procedure_one("ValidateUser", $params, $user_reference);

if ($user_reference->Exists == 0):
    header("location:../helpers/sign-in.php");
endif;

$risk = new RiskDTO();

$params_riskDTO = array(
    $_GET['UID'],
    intval($_GET['id'])
);

$risk->call_procedure_one("GetRiskById", $params_riskDTO, $risk);

if (is_null($risk->RiskTypeName)):
    header("location:../helpers/sign-in.php");
endif;

$personal = new PersonalCompanyDTO();

$responsables = $personal->call_procedure_multi("ResponsableByCompany", $params, $personal);


if (isset($_GET["control"])) {
    $controlRisk = new ControlToRisk();
    $insertion = array(
        $_GET['UID'],
        intval($_GET['id'])
    );
    $controlRisk->control = intval($_GET['control']);
    $generic = new GenericResponse();
    $generic = $controlRisk->insert_model('AddControlToRisk', $insertion, $controlRisk);
}

$control = new Control();
$controls = $control->call_procedure_multi('GetControlByRiskId', $params_riskDTO, $control);



if (isset($_POST["NombreControl"])) {

    $controlInsert = new ControlInsert();
    $controlInsert->Name = strval($_POST["NombreControl"]);
    $controlInsert->Description = strval($_POST["DescripcionControl"]);
    $controlInsert->Responsable = intval($_POST["Responsable"]);
    $controlInsert->RiskId = intval($_GET['id']);

    $generic = new GenericResponse();

    $generi = $controlInsert->insert_model('InsertControl', $params, $controlInsert);


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include(VIEWS . "head.php");
    ?>
</head>

<body class="bg-soft">

<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none">
    <a class="navbar-brand mr-lg-5" href="../../index.html">
        <img class="navbar-brand-dark" src="../../assets/img/brand/light.svg" alt="Volt logo"/> <img
                class="navbar-brand-light" src="../../assets/img/brand/dark.svg" alt="Volt logo"/>
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-md-none collapsed" type="button" data-toggle="collapse"
                data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container-fluid bg-soft">
    <div class="row">
        <div class="col-12">

            <?php
            // insert the nav of the user
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
                            <li class="breadcrumb-item active" aria-current="page">Controles de Riesgo</li>
                        </ol>
                    </nav>
                    <h2 class="h4">Controles para '<?php echo $risk->IdRisk; ?>'</h2>
                    <p class="mb-0">Favor rellene los siguientes campos que detallan los controles.</p>


                    <div class="btn-toolbar  justify-content-md-end">
                        <button class="btn btn-primary btn-sm mr-2 dropdown-toggle" aria-haspopup="true"
                                aria-expanded="false" data-toggle="modal" data-target="#modal-form">
                            <span class="fas fa-plus mr-2"></span>Agregar
                        </button>
                        <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="card border-light p-4">
                                            <div class="card-header border-0 text-center pb-0">
                                                <h2 class="h4">Control</h2>
                                                <span>Por favor rellene los siguientes datos.</span>
                                            </div>
                                            <div class="card-body">
                                                <form action="#" class="mt-4" method="post">
                                                    <!-- Form -->
                                                    <div class="form-group mb-4">
                                                        <label for="NombreControl">Nombre de Control</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" id="NombreControl"
                                                                   name="NombreControl" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-group mb-4">
                                                            <label for="DescripcionControl">Descripción</label>
                                                            <div class="input-group">
                                                                <textarea class="form-control" id="DescripcionControl"
                                                                          name="DescripcionControl"
                                                                          placeholder="Detalle..." rows="5"
                                                                          required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="my-1 mr-2" for="Responsable">Responsable</label>
                                                        <select class="form-select" id="Responsable"
                                                                aria-label="Default select example" name="Responsable"
                                                                required>
                                                            <?php
                                                            for ($iterator = 0; $iterator < count($responsables); ++$iterator) {
                                                                $responsable = $responsables[$iterator];
                                                                if ($iterator == 0) {
                                                                    echo '<option value="' . $responsable->IdPersonal . '" selected>' . $responsable->Name . '</option>';
                                                                } else {
                                                                    echo '<option  value="' . $responsable->IdPersonal . '">' . $responsable->Name . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-block btn-primary">Guardar
                                                    </button>
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
                                <h5>Controles definidos</h5>
                                <div class="card border-light shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap mb-0 rounded">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th class="border-0">#</th>
                                                    <th class="border-0">Nombre</th>
                                                    <th class="border-0">Descripción</th>
                                                    <th class="border-0">Responsable</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php

                                                foreach ($controls as $con) {

                                                    echo "<tr>";
                                                    echo '<td class="border-0">' . $con->ControlId . '</td>';
                                                    echo '<td class="border-0 font-weight-bold">
                                                                    <a href="#" class="text-primary font-weight-bold">
                                                                      ' . $con->ControlName . '
                                                                    </a>
                                                                  </td>';
                                                    echo '<td class="border-0">
                                                                    ' . $con->ControlDescription . '
                                                                  </td>';
                                                    echo '<td class="border-0">
                                                                    ' . $con->Responsable . '
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

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card border-light shadow-sm components-section">
                            <div class="card-body">
                                <h5>Controles disponibles no incluidos</h5>
                                <div class="card border-light shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap mb-0 rounded">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th class="border-0">#</th>
                                                    <th class="border-0">Nombre</th>
                                                    <th class="border-0">Descripción</th>
                                                    <th class="border-0">Responsable</th>
                                                    <th class="border-0">Agregar Control</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php


                                                $control2 = new Control();
                                                $controls2 = $control->call_procedure_multi('GetControlAvalaible', $params_riskDTO, $control2);
                                                foreach ($controls2 as $con) {
                                                    echo "<tr>";
                                                    echo '<td class="border-0">' . $con->ControlId . '</td>';
                                                    echo '<td class="border-0 font-weight-bold">
                                                    <a href="#" class="text-primary font-weight-bold">
                                                     ' . $con->ControlName . '
                                                     </a>
                                                       </td>';
                                                    echo '<td class="border-0 text-wrap"> ' . $con->ControlDescription . '</td>';
                                                    echo '<td class="border-0">' . $con->Responsable . '</td>';
                                                    echo '<td class="border-0">
                                                       <a href="./controls.php?UID=' . $_GET["UID"] . '&id=' . $_GET["id"] . '&control=' . $con->ControlId . '" class="btn w-10 btn-sm btn-secondary border-0" style="margin:0;" type="button">Agregar Control</a>
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
            </main>
            <?php
            include(VIEWS . "scripts.php");
            ?>
        </div>
    </div>
</div>


</body>

</html>
