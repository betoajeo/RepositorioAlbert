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
            // insert the manu
            include(VIEWS . "menu.php");
            ?>

            <main class="content">

                <!-- <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark pl-0 pr-2 pb-0">
                    <div class="container-fluid px-0">
                        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
                            <div class="d-flex">
                                <form class="navbar-search form-inline" id="navbar-search-main">
                                    <div class="input-group input-group-merge search-bar">
                                        <span class="input-group-text" id="topbar-addon"><span class="fas fa-search"></span></span>
                                        <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Search" aria-label="Search" aria-describedby="topbar-addon">
                                    </div>
                                </form>
                            </div>
                            <ul class="navbar-nav align-items-center">
                                <li class="nav-item dropdown">
                                    <a class="nav-link text-dark mr-lg-3 icon-notifications" data-unread-notifications="true" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="icon icon-sm">
                                            <span class="fas fa-bell bell-shake"></span>
                                            <span class="icon-badge rounded-circle unread-notifications"></span>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-lg dropdown-menu-center mt-2 py-0">
                                        <div class="list-group list-group-flush">
                                            <a href="#" class="text-center text-primary font-weight-bold border-bottom border-light py-3">Notifications</a>
                                            <a href="../../pages/calendar.html" class="list-group-item list-group-item-action border-bottom border-light">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-1.jpg" class="user-avatar lg-avatar rounded-circle">
                                                    </div>
                                                    <div class="col pl-0 ml--2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h4 class="h6 mb-0 text-small">Jose Leos</h4>
                                                            </div>
                                                            <div class="text-right">
                                                                <small class="text-danger">a few moments ago</small>
                                                            </div>
                                                        </div>
                                                        <p class="font-small mt-1 mb-0">Added you to an event "Project stand-up" tomorrow at 12:30 AM.</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="../../pages/tasks.html" class="list-group-item list-group-item-action border-bottom border-light">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-2.jpg" class="user-avatar lg-avatar rounded-circle">
                                                    </div>
                                                    <div class="col pl-0 ml--2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h4 class="h6 mb-0 text-small">Neil Sims</h4>
                                                            </div>
                                                            <div class="text-right">
                                                                <small class="text-danger">2 hrs ago</small>
                                                            </div>
                                                        </div>
                                                        <p class="font-small mt-1 mb-0">You've been assigned a task for "Awesome new project".</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="../../pages/tasks.html" class="list-group-item list-group-item-action border-bottom border-light">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-3.jpg" class="user-avatar lg-avatar rounded-circle">
                                                    </div>
                                                    <div class="col pl-0 ml--2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h4 class="h6 mb-0 text-small">Roberta Casas</h4>
                                                            </div>
                                                            <div class="text-right">
                                                                <small>5 hrs ago</small>
                                                            </div>
                                                        </div>
                                                        <p class="font-small mt-1 mb-0">Tagged you in a document called "First quarter financial plans",</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="../../pages/single-message.html" class="list-group-item list-group-item-action border-bottom border-light">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-4.jpg" class="user-avatar lg-avatar rounded-circle">
                                                    </div>
                                                    <div class="col pl-0 ml--2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h4 class="h6 mb-0 text-small">Joseph Garth</h4>
                                                            </div>
                                                            <div class="text-right">
                                                                <small>1 d ago</small>
                                                            </div>
                                                        </div>
                                                        <p class="font-small mt-1 mb-0">New message: "Hey, what's up? All set for the presentation?"</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="../../pages/single-message.html" class="list-group-item list-group-item-action border-bottom border-light">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <img alt="Image placeholder" src="../../assets/img/team/profile-picture-5.jpg" class="user-avatar lg-avatar rounded-circle">
                                                    </div>
                                                    <div class="col pl-0 ml--2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h4 class="h6 mb-0 text-small">Bonnie Green</h4>
                                                            </div>
                                                            <div class="text-right">
                                                                <small>2 hrs ago</small>
                                                            </div>
                                                        </div>
                                                        <p class="font-small mt-1 mb-0">New message: "We need to improve the UI/UX for the landing page."</p>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link pt-1 px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <div class="media d-flex align-items-center">
                                            <img class="user-avatar md-avatar rounded-circle" alt="Image placeholder" src="../../assets/img/team/profile-picture-3.jpg">
                                            <div class="media-body ml-2 text-dark align-items-center d-none d-lg-block">
                                                <span class="mb-0 font-small font-weight-bold">Bonnie Green</span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-right mt-2">
                                        <a class="dropdown-item font-weight-bold" href="#"><span class="far fa-user-circle"></span>My Profile</a>
                                        <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-cog"></span>Settings</a>
                                        <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-envelope-open-text"></span>Messages</a>
                                        <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-user-shield"></span>Support</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item font-weight-bold" href="#"><span class="fas fa-sign-out-alt text-danger"></span>Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav> -->
                <?php
                // insert the nav of the user
                include(VIEWS . "nav.php");
                ?>


                <div class="py-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                            <li class="breadcrumb-item"><a href="#"><span class="fas fa-home"></span></a></li>
                            <li class="breadcrumb-item"><a href="#">Tables</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Bootstrap tables</li>
                        </ol>
                    </nav>
                    <div class="d-flex justify-content-between w-100 flex-wrap">
                        <div class="mb-3 mb-lg-0">
                            <h1 class="h4">Bootstrap tables</h1>
                            <p class="mb-0">Dozens of reusable components built to provide buttons, alerts, popovers,
                                and more.</p>
                        </div>
                        <div>
                            <a href="https://themesberg.com/docs/volt-bootstrap-5-dashboard/components/tables/"
                               class="btn btn-outline-gray"><i class="far fa-question-circle mr-1"></i> Bootstrap Tables
                                Docs</a>
                        </div>
                    </div>
                </div>

                <div class="card border-light shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0">Traffic Source</th>
                                    <th class="border-0">Source Type</th>
                                    <th class="border-0">Category</th>
                                    <th class="border-0">Global Rank</th>
                                    <th class="border-0">Traffic Share</th>
                                    <th class="border-0">Change</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Item -->
                                <tr>
                                    <td class="border-0"><a href="#" class="text-primary font-weight-bold">1</a></td>
                                    <td class="border-0 font-weight-bold"><span
                                                class="icon icon-xs icon-gray w-30"><span
                                                    class="fas fa-globe-europe"></span></span>Direct
                                    </td>
                                    <td class="border-0">
                                        Direct
                                    </td>
                                    <td class="border-0">
                                        -
                                    </td>
                                    <td class="border-0">
                                        --
                                    </td>
                                    <td class="border-0">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12 col-xl-2 px-0">
                                                <div class="small font-weight-bold">51%</div>
                                            </div>
                                            <div class="col-12 col-xl-10 px-0 px-xl-1">
                                                <div class="progress progress-lg mb-0">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                         aria-valuenow="51" aria-valuemin="0" aria-valuemax="100"
                                                         style="width: 51%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">2.45%</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td><a href="#" class="text-primary font-weight-bold">2</a></td>
                                    <td class="font-weight-bold"><span class="icon icon-xs icon-info w-30"><span
                                                    class="fab fa-google"></span></span>Google Search
                                    </td>
                                    <td>
                                        Search / Organic
                                    </td>
                                    <td>
                                        -
                                    </td>
                                    <td>
                                        --
                                    </td>
                                    <td>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12 col-xl-2 px-0">
                                                <div class="small font-weight-bold">18%</div>
                                            </div>
                                            <div class="col-12 col-xl-10 px-0 px-xl-1">
                                                <div class="progress progress-lg mb-0">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                         aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"
                                                         style="width: 18%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">17.67%</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td><a href="#" class="text-primary font-weight-bold">3</a></td>
                                    <td class="font-weight-bold"><span class="icon icon-xs icon-danger w-30"><span
                                                    class="fab fa-youtube"></span></span> youtube.com
                                    </td>
                                    <td>
                                        Social
                                    </td>
                                    <td>
                                        <a class="small font-weight-bold" href="#">Arts and Entertainment</a>
                                    </td>
                                    <td>
                                        #2
                                    </td>
                                    <td>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12 col-xl-2 px-0">
                                                <div class="small font-weight-bold">18%</div>
                                            </div>
                                            <div class="col-12 col-xl-10 px-0 px-xl-1">
                                                <div class="progress progress-lg mb-0">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                         aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"
                                                         style="width: 18%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        -
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td><a href="#" class="text-primary font-weight-bold">4</a></td>
                                    <td class="font-weight-bold"><span class="icon icon-xs icon-purple w-30"><span
                                                    class="fab fa-yahoo"></span></span> yahoo.com
                                    </td>
                                    <td>
                                        Referral
                                    </td>
                                    <td>
                                        <a class="small font-weight-bold" href="#">News and Media</a>
                                    </td>
                                    <td>
                                        #11
                                    </td>
                                    <td>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12 col-xl-2 px-0">
                                                <div class="small font-weight-bold">8%</div>
                                            </div>
                                            <div class="col-12 col-xl-10 px-0 px-xl-1">
                                                <div class="progress progress-lg mb-0">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                         aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"
                                                         style="width: 8%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">9.30%</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td><a href="#" class="text-primary font-weight-bold">5</a></td>
                                    <td class="font-weight-bold"><span class="icon icon-xs icon-info w-30"><span
                                                    class="fab fa-twitter"></span></span> twitter.com
                                    </td>
                                    <td>
                                        Social
                                    </td>
                                    <td>
                                        <a class="small font-weight-bold" href="#">Social Networks</a>
                                    </td>
                                    <td>
                                        #4
                                    </td>
                                    <td>
                                        <div class="row d-flex align-items-center">
                                            <div class="col-12 col-xl-2 px-0">
                                                <div class="small font-weight-bold">4%</div>
                                            </div>
                                            <div class="col-12 col-xl-10 px-0 px-xl-1">
                                                <div class="progress progress-lg mb-0">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                         aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"
                                                         style="width: 4%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        -
                                    </td>
                                </tr>
                                <!-- End of Item -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Country</th>
                                    <th class="border-0">All</th>
                                    <th class="border-0">All Change</th>
                                    <th class="border-0">Travel & Local</th>
                                    <th class="border-0">Travel & Local Change</th>
                                    <th class="border-0">Widgets</th>
                                    <th class="border-0">Widgets Change</th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- Item -->
                                <tr>
                                    <td class="border-0">
                                        <a href="#" class="d-flex align-items-center">
                                            <img class="mr-2 image image-small rounded-circle" alt="Image placeholder"
                                                 src="../../assets/img/flags/united-states-of-america.svg">
                                            <div><span class="h6">United States</span></div>
                                        </a>
                                    </td>
                                    <td class="border-0 font-weight-bold">106</td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">5</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        3
                                    </td>
                                    <td class="border-0">
                                        =
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        32
                                    </td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">3</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td class="border-0">
                                        <a href="#" class="d-flex align-items-center">
                                            <img class="mr-2 image image-small rounded-circle" alt="Image placeholder"
                                                 src="../../assets/img/flags/canada.svg">
                                            <div><span class="h6">Canada</span></div>
                                        </a>
                                    </td>
                                    <td class="border-0 font-weight-bold">76</td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">17</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        4
                                    </td>
                                    <td class="border-0">
                                        =
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        30
                                    </td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">3</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td class="border-0">
                                        <a href="#" class="d-flex align-items-center">
                                            <img class="mr-2 image image-small rounded-circle" alt="Image placeholder"
                                                 src="../../assets/img/flags/united-kingdom.svg">
                                            <div><span class="h6">United Kingdom</span></div>
                                        </a>
                                    </td>
                                    <td class="border-0 font-weight-bold">147</td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">10</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        5
                                    </td>
                                    <td class="border-0">
                                        =
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        34
                                    </td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">7</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td class="border-0">
                                        <a href="#" class="d-flex align-items-center">
                                            <img class="mr-2 image image-small rounded-circle" alt="Image placeholder"
                                                 src="../../assets/img/flags/france.svg">
                                            <div><span class="h6">France</span></div>
                                        </a>
                                    </td>
                                    <td class="border-0 font-weight-bold">112</td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">3</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        5
                                    </td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">1</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        34
                                    </td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">2</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td class="border-0">
                                        <a href="#" class="d-flex align-items-center">
                                            <img class="mr-2 image image-small rounded-circle" alt="Image placeholder"
                                                 src="../../assets/img/flags/japan.svg">
                                            <div><span class="h6">Japan</span></div>
                                        </a>
                                    </td>
                                    <td class="border-0 font-weight-bold">115</td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">12</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        6
                                    </td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">1</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        37
                                    </td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">5</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->

                                <!-- Item -->
                                <tr>
                                    <td class="border-0">
                                        <a href="#" class="d-flex align-items-center">
                                            <img class="mr-2 image image-small rounded-circle" alt="Image placeholder"
                                                 src="../../assets/img/flags/germany.svg">
                                            <div><span class="h6">Germany</span></div>
                                        </a>
                                    </td>
                                    <td class="border-0 font-weight-bold">220</td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">56</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        7
                                    </td>
                                    <td class="border-0 text-danger">
                                        <span class="fas fa-angle-down"></span>
                                        <span class="font-weight-bold">3</span>
                                    </td>
                                    <td class="border-0 font-weight-bold">
                                        30
                                    </td>
                                    <td class="border-0 text-success">
                                        <span class="fas fa-angle-up"></span>
                                        <span class="font-weight-bold">2</span>
                                    </td>
                                </tr>
                                <!-- End of Item -->
                                </tbody>
                            </table>
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
    navs[3].className += " active";
    navs[0].className = "nav-item";
</script>


</body>

</html>