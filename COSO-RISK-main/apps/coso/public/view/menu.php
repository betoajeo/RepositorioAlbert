<?php
$isMainFolder = file_exists("./dashboard.php");

$dirs = null;

if ($isMainFolder):
    $dirs = array(
        './dashboard.php?UID=',
        './risks.php?UID=',
        './plans.php?UID=',
        './binnacle.php?UID=',
        './configuration.php?UID=',
    );
else:
    $dirs = array(
        '../main/dashboard.php?UID=',
        '../main/risks.php?UID=',
        '../main/plans.php?UID=',
        '../main/binnacle.php?UID=',
        '../main/configuration.php?UID=',
    );
endif;

?>

<nav id="sidebarMenu" class="sidebar d-md-block bg-primary text-white collapse" data-simplebar>
    <div class="sidebar-inner px-4 pt-3">
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="user-avatar lg-avatar mr-4">
                    <!-- <img src="../../assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white" alt="Bonnie Green"> -->
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" class="fas fa-times" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation"></a>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item active">
                <a href="<?php echo $dirs[0] . $_GET['UID']; ?>" class="nav-link">
                    <span class="sidebar-icon"><span class="fas fa-home"></span></span>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?php echo $dirs[1] . $_GET['UID']; ?>" class="nav-link">
                    <span class="sidebar-icon"><span class="fas fa-exclamation-circle"></span></span>
                    <span>Riesgos</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="<?php echo $dirs[2] . $_GET['UID']; ?>" class="nav-link">
                    <span class="sidebar-icon"><span class="fas fa-clipboard"></span></span>
                    <span>Planes</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $dirs[3] . $_GET['UID']; ?>" class="nav-link">
                    <span class="sidebar-icon"><span class="fas fa-table"></span></span>
                    <span>Bitácora</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $dirs[4] . $_GET['UID']; ?>" class="nav-link">
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