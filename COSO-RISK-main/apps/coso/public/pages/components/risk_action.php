<?php
// primeramente se consulta si existen los _GET
// sino, simplemente no está logeado
header("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

//echo "<script>alert(" .$_GET['UID']. ") </script> ";

if (!isset($_GET['UID']) && !isset($_POST['UID'])) {
    header("location:../helpers/sign-in.php");
}


include_once('../../../../../helpers/vars.php');

if ($isProduction) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(DB . 'connection_db.php');
include_once(MODEL_PATH . '/risk/Risk.php');
include(DB . '/public/public.php');
include(MODEL_PATH . '/user/user.php');
include(MODEL_PATH . '/user/Personal.php');

if(isset($_POST['UID'])){


    if (isset($_POST['Nombre'])) {

//        echo "<script>
//            alert(".$_GET['UID'].") </script>
//        ";
        $riskUpdate = new RiskSingleDTO();
        $paramsNew = array(
            $_POST['UID']
        );
        $Tipo = "";

        switch ($_POST["Tipo"]) {
            case '0':
                $Tipo = "Mixto";
                break;
            case '1':
                $Tipo = "Económico";
                break;
            case '2':
                $Tipo = "Financiero";
                break;
            case '3':
                $Tipo = "Sistemático";
                break;
            case '4':
                $Tipo = "Ambiental";
                break;
            case '5':
                $Tipo = "Político";
                break;
            case '6':
                $Tipo = "Seguridad Informática";
                break;
            case '7':
                $Tipo = "Legal";
                break;
        }
        $Clasificacion = "";

        switch ($_POST["Clasificacion"]) {
            case '1':
                $Clasificacion = "Riesgo Bajo";
                break;
            case '2':
                $Clasificacion = "Riesgo Medio";
                break;
            case '3':
                $Clasificacion = "Riesgo Alto";
                break;
        }


        $riskUpdate->RiskName = strval($_POST['Nombre']);
        $riskUpdate->RiskType = strval($Tipo);
        $riskUpdate->RiskLevel = strval($Clasificacion);
        $riskUpdate->RiskDescription = strval($_POST["Descripcion"]);
        $riskUpdate->RiskProbabilityAcceptable = intval($_POST["Porcentaje"]);
        $riskUpdate->Responsable = intval($_POST["Responsable"]);
        $riskUpdate->RsikId = intval($_POST["id"]);

//        echo  'Name-'.$riskUpdate->RiskName . 'type-'.$riskUpdate->RiskType. 'level-'.$riskUpdate->RiskLevel. 'description-'.$riskUpdate->RiskDescription. '-';
//        echo '-prob-'.$riskUpdate->RiskProbabilityAcceptable. '-responsable-'.$riskUpdate->Responsable. '-id-'.$riskUpdate->RsikId;
//        return;

        $result = $riskUpdate->insert_model('UpdateRiskById', $paramsNew, $riskUpdate);
        if(!$result) {
            echo 'se para por falla';
            return;
        }
//      $resultado = $conn->query('UPDATE `riesgo` SET Nombre="'.$_POST["Nombre"].'", Descripcion="'.$_POST["Descripcion"].'",Tipo="'.$Tipo.'",ProbAceptable='.$_POST["Porcentaje"].',IdResponsable='.$_POST["Responsable"].',Clasificacion="'.$Clasificacion.'" WHERE IdRiesgo='.$_POST["id"]);
//        echo "<script>alert(" .$_POST['UID']. ") </script> ";

//    if ($resultado) {
        header("location:./controls.php?UID=" . $_POST["UID"] ."&id=".$_POST['id']);
//    } else {
//        echo $conn->error;
//    }

    }
}

//        echo "<script>
//            alert(".$_GET['UID'].") </script>
//        ";
$user_reference = new UserDTO();

$uid = (!isset($_GET['UID']))? $_POST['UID']:$_GET['UID'];

$params = array(
$uid
);

$user_reference->call_procedure_one("ValidateUser", $params, $user_reference);

if ($user_reference->Exists == 0):
    header("location:../helpers/sign-in.php");
endif;

$personal = new PersonalCompanyDTO();

$risk = new RiskSingle();

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

// si el cuestionario esta lleno
// se procede a rescatar la información e insertar los datos


//    if(isset($_GET["id"])) {
//      include "../../../model/connection_db.php";
//
//      $resultado = $conn->query('SELECT Nombre, Descripcion, ProbAceptable, IdResponsable, Tipo, Clasificacion FROM Riesgo where IdRiesgo='.$_GET["id"]);
//
//      $Nombre = "";
//      $Descripcion = "";
//      $Aceptacion = "";
//      $IdResponsable = "";
//      $Tipo = "";
//      $Clasificacion = "";
//
//      while ($fila = $resultado->fetch_row()) {
//         $Nombre = $fila[0];
//         $Descripcion = $fila[1];
//         $Aceptacion = $fila[2];
//         $IdResponsable = $fila[3];
//         $Tipo = $fila[4];
//         $Clasificacion = $fila[5];
//      }
//    }
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
            // inser the manu
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
                            <li class="breadcrumb-item"><a href="#">Riesgo</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Insertar Riesgo</li>
                        </ol>
                    </nav>
                    <div class="d-flex justify-content-between w-100 flex-wrap">
                        <div class="mb-3 mb-lg-0">
                            <h1 class="h4">Entrada de Riesgo</h1>
                            <p class="mb-0">Favor rellene los siguientes campos que detallan el riesgo.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card border-light shadow-sm components-section">
                            <div class="card-body">

                                <form action="" method="post">
                                    <div class="row mb-4">

                                        <div class="col-lg-4 col-sm-6">
                                            <!-- Form -->
                                            <div class="mb-4">
                                                <label for="Nombre">Nombre</label>
                                                <input type="text" class="form-control" id="Nombre" name="Nombre"
                                                       value="<?php echo $risk->RiskName; ?>" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="my-1 mr-2" for="Responsable">Responsable</label>
                                                <select class="form-select" id="Responsable"
                                                        aria-label="Default select example" name="Responsable">
                                                    <?php

                                                    for ($iterator = 0; $iterator < count($responsables); ++$iterator) {
                                                        $responsable = $responsables[$iterator];
                                                        if ($iterator == $risk->Responsable) {
                                                            echo '<option value="' . $responsable->IdPersonal . '" selected>' . $responsable->Name . '</option>';
                                                        } else {
                                                            echo '<option  value="' . $responsable->IdPersonal . '">' . $responsable->Name . '</option>';
                                                        }
                                                        $iterator = $iterator + 1;
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="Aceptacion">% de Aceptación por la empresa</label>
                                                <input type="number" class="form-control" id="Aceptacion"
                                                       placeholder="0 a 100" name="Porcentaje"
                                                       value="<?php echo $risk->RiskProbabilityAcceptable * 100; ?>"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">

                                            <!-- Form -->
                                            <div class="mb-4">
                                                <label for="textarea">Descripción</label>
                                                <textarea class="form-control" placeholder="Detalle..." id="textarea"
                                                          rows="9"
                                                          name="Descripcion"><?php echo $risk->RiskDescription; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="mb-4">
                                                <label class="my-1 mr-2" for="Tipo">Tipo Riesgo</label>
                                                <select class="form-select" id="Tipo"
                                                        aria-label="Default select example" name="Tipo">
                                                    <?php

                                                    $arreglo = array(
                                                        0 => "Mixto",
                                                        1 => "Económico",
                                                        2 => "Financiero",
                                                        3 => "Sistemático",
                                                        4 => "Ambiental",
                                                        5 => "Político",
                                                        6 => "Seguridad Informática",
                                                        7 => "Legal",
                                                    );

                                                    for ($i = 0; $i < count($arreglo); $i++) {
                                                        if ($arreglo[$i] == $risk->RiskTypeName) {
                                                            echo '<option value="' . $i . '" selected>' . $arreglo[$i] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $i . '">' . $arreglo[$i] . '</option>';
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="my-1 mr-2" for="Clasificacion">Clasificación</label>
                                                <select class="form-select" id="Clasificacion"
                                                        aria-label="Default select example" name="Clasificacion">
                                                    <?php
                                                    $riesgo_arreglo = array(
                                                        1 => array("Riesgo Bajo", "background-color:#2DB822;color:white;"),
                                                        2 => array("Riesgo Medio", "background-color:#F48625;color:white;"),
                                                        3 => array("Riesgo Alto", "background-color:#D53E30;color:white;"),
                                                    );

                                                    for ($i = 1; $i < count($riesgo_arreglo) + 1; $i++) {
                                                        if ($i == $risk->RiskLevel) {
                                                            echo '<option value="' . $i . '" selected style="' . $riesgo_arreglo[$i][1] . '" >' . $riesgo_arreglo[$i][0] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $i . '" style="' . $riesgo_arreglo[$i][1] . '" >' . $riesgo_arreglo[$i][0] . '</option>';
                                                        }
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                            <div style="display:none;">
                                                <input name="id" type="numeric" value="<?php echo $_GET["id"]; ?>">
                                            </div>
                                            <div style="display:none;">
                                                <input name="UID" type="text" value="<?php echo $_GET["UID"]; ?>">
                                            </div>
                                            <div class="form-file mb-3  d-md-flex justify-content-md-end ">
                                                <button class="btn btn-success large" type="submit">Continuar</button>
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


</body>

</html>
