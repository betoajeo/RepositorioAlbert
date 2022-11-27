<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    ob_start();


    header("Expires: Fri, 14 Mar 1980 20:53:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    if (!isset($_GET['UID'])) {
        header("location:../helpers/sign-in.php");
    }

    include '../../../core/model/user/UserReference.php';
    $user_reference = new UserReference();

    include_once('../../../../../helpers/vars.php');

    if ($isProduction) { 
      include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
    } else {
      include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
    }
    include(VIEWS . "head.php");
    include_once(DB . 'connection_db.php');

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
                        <div class="btn-toolbar dropdown">
                            <button class="btn btn-primary btn-sm mr-2 dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fas fa-plus mr-2"></span>Agregar
                            </button>
                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-left mt-2">
                                <a class="dropdown-item font-weight-bold" href="<?php echo "../components/forms.php?user_name="; ?>"><span class="fas fa-exclamation-circle"></span>Riesgo</a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-bomb"></span>Incidencia</a>
                                <div role="separator" class="dropdown-divider"></div>
                                <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-user-shield"></span>Monitoreo</a>
                                <!-- <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-rocket text-danger"></span>Upgrade to Pro</a> -->
                            </div>
                        </div>
                        <div class="btn-group">
                            <!-- <button type="button" class="btn btn-sm btn-outline-primary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Export</button> -->
                        </div>
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-12 mb-4">
                            <div class="card bg-yellow-alt shadow-sm">
                                <div class="card-header d-flex flex-row align-items-center flex-0">
                                    <div class="d-block">
                                        <div class="h5 font-weight-normal mb-2">Costo por Incidencias</div>
                                        <h2 class="h3">$10,567</h2>
                                        <div class="small mt-2">
                                            <span class="font-weight-bold mr-2">Yesterday</span>
                                            <span class="fas fa-angle-up text-success"></span>
                                            <span class="text-success font-weight-bold">10.57%</span>
                                        </div>
                                    </div>
                                    <div class="d-flex ml-auto">
                                        <!-- <a href="#" class="btn btn-secondary text-dark btn-sm mr-2">Month</a>
                                        <a href="#" class="btn btn-primary btn-sm mr-3">Week</a> -->
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="ct-chart-sales-value ct-double-octave ct-series-g"></div>
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
<?php
ob_end_flush();
?>