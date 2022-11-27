<?php
ob_start();

include_once('../../../../../helpers/vars.php');

if ($isProduction) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else { 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include(DB . 'connection_db.php');

$Connection = new Connection();
$conn = $Connection->getConnection();

if (isset($_GET['UID'])) {
    // close the session
    $conn->query("CALL CloseSession('" . $_GET['UID'] . "')");
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
    <main>
        <!-- Section -->
        <section class="vh-lg-100 d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image" data-background-lg="../../assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="signin-inner my-3 my-lg-0 bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Coso Risk App</h1>
                            </div>

                            <form action="" method="post" class="mt-4">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="email">Correo</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"><span class="fas fa-envelope"></span></span>
                                        <input type="email" class="form-control" placeholder="ejemplo@3clics.com" id="email" autofocus name="email" required>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2"><span class="fas fa-unlock-alt"></span></span>
                                            <input type="password" placeholder="Contraseña" class="form-control" id="password" name="password" required>
                                        </div>
                                    </div>
                                    <!-- End of Form -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-block btn-primary">Iniciar</button>
                            </form>

                            <?php

                            if (isset($_POST["password"])) {

                                if ($result = $conn->query("CALL InsertUID( '" . $_POST['email'] . "' ,'" . $_POST['password'] . "')")) {
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_row();
                                        if ($row[0] == 1) {
                                            $conn->close();
                                            header("location:../main/dashboard.php?UID=" . $row[5]);
                                        } else {
                                            print "Correo o Contraseña erróneos";
                                        }
                                    }
                                }
                            }

                            $Connection->closeConnection();
                            ?>
                            <div class="btn-wrapper my-4 text-center">
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php

    include(VIEWS . "scripts.php");
    ?>
</body>

</html>
<?php
ob_end_flush();
?>