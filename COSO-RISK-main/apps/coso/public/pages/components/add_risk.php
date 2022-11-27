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
include(DB . '/public/public.php');
include(MODEL_PATH . '/user/user.php');
include(MODEL_PATH . '/user/Personal.php');

$user_reference = new UserDTO();

$params = array(
  $_GET['UID']
);

$user_reference->call_procedure_one("ValidateUser", $params, $user_reference);

if ($user_reference->Exists == 0):
  header("location:../helpers/sign-in.php");
endif;

$personal = new PersonalCompanyDTO();

$responsables = $personal->call_procedure_multi("ResponsableByCompany", $params, $personal);


if(isset($_POST['Nombre'])) {

    $Tipo = "";

    switch ($_POST["Tipo"]) {
        case '0':
            $Tipo= "Mixto";
            break;
        case '1':
            $Tipo= "Económico";
            break;
        case '2':
            $Tipo= "Financiero";
            break;
        case '3':
            $Tipo= "Sistemático";
            break;
        case '4':
            $Tipo= "Ambiental";
            break;
        case '5':
            $Tipo= "Político";
            break;
        case '6':
            $Tipo= "Seguridad Informática";
            break;
        case '7':
            $Tipo= "Legal";
            break;
    }

    $Clasificacion = "";

    switch ($_POST["Clasificacion"]) {
        case '0':
            $Clasificacion = "Riesgo Bajo";
            break;
        case '1':
            $Clasificacion = "Riesgo Medio";
            break;
        case '2':
            $Clasificacion = "Riesgo Alto";
            break;
    }

    $result = new GenericResponse();

    $risk = new RiskInsert();
    $risk->RiskName = strval($_POST['Nombre']);
    $risk->RiskResponsable = intval($_POST["Responsable"]);
    $risk->RiskProbabilityAcceptable = doubleval(doubleval($_POST["Porcentaje"]) / 100);
    $risk->RiskDescription = strval($_POST["Descripcion"]);
    $risk->RiskTypeName = $Tipo;
    $risk->RiskLevel = $Clasificacion;

    $result = $risk->insert_model("InsertRisk", $params, $risk);

    if (!is_null($result->InsertedObjectId)):
        header("location:./controls.php?UID=".$_GET["UID"]."&id=".$result->InsertedObjectId);
    endif;

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

                        <div class="py-4">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                                    <li class="breadcrumb-item"><a href="../main/dashboard.php?UID=<?php echo $_GET["UID"] ?>"><span class="fas fa-home"></span></a></li>
                                    <li class="breadcrumb-item"><a href="../main/risks.php?UID=<?php echo $_GET["UID"] ?>">Riesgo</a></li>
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
                                                    <input type="text" class="form-control" id="Nombre" name="Nombre" required> 
                                                </div> 
                                                <div class="mb-4">
                                                    <label class="my-1 mr-2" for="Responsable">Responsable</label>
                                                    <select class="form-select" id="Responsable" aria-label="Default select example" name="Responsable">
                                                      <?php
                                                        for($iterator = 0; $iterator < count($responsables); ++$iterator) {
                                                            $responsable = $responsables[$iterator];
                                                            if($iterator == 1) {
                                                                echo '<option value="'.$responsable->IdPersonal.'" selected>'.$responsable->Name.'</option>';
                                                            } else {
                                                                echo '<option  value="'.$responsable->IdPersonal.'">'.$responsable->Name.'</option>';
                                                            }
                                                            $iterator = $iterator + 1;
                                                        }
                                                      ?> 
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="Aceptacion">% de Aceptación por la empresa</label>
                                                    <input type="number" class="form-control" id="Aceptacion" placeholder="0 a 100" name="Porcentaje" required> 
                                                </div> 
                                            </div>
                                            <div class="col-lg-4 col-sm-6"> 
                                                <div class="mb-4">
                                                    <label for="textarea">Descripción</label>
                                                    <textarea class="form-control" placeholder="Detalle..." id="textarea" rows="9" name="Descripcion"></textarea>
                                                  </div> 
                                            </div>
                                            <div class="col-lg-4 col-sm-6"> 
                                                <div class="mb-4">
                                                    <label class="my-1 mr-2" for="Tipo">Tipo Riesgo</label>
                                                    <select class="form-select" id="Tipo" aria-label="Default select example" name="Tipo">
                                                        <option value="0" selected>Mixto</option>
                                                        <option value="1">Económico</option>
                                                        <option value="2">Financiero</option>
                                                        <option value="3">Sistemático</option>
                                                        <option value="4">Ambiental</option>
                                                        <option value="5">Político</option>
                                                        <option value="6">Seguridad Informática</option>
                                                        <option value="7">Legal</option>
                                                      </select> 
                                                </div>  
                                                <div class="mb-4">
                                                  <label class="my-1 mr-2" for="Clasificacion " >Clasificación</label>
                                                  <select class="selectpicker my-select form-select" id="Clasificacion"  aria-label="Default select example" name="Clasificacion">
                                                    <option value="0" style="background: #5cb85c; color: #fff;" selected  >Riesgo Bajo</option>
                                                    <option value="1" style="background: #F48625; color: #fff;">Riesgo Medio</option>
                                                    <option value="2" style="background: #D53E30; color: #fff;">Riesgo Alto</option>
                                                  </select>
                                                </div>
                                                <div class="form-file mb-3  d-md-flex justify-content-md-end ">
                                                  <button class="btn btn-success large" type="submit">Guardar y Continuar</button>
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

 
<script>
  $('.my-select').selectpicker();
</script>

</html>
