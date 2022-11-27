<!-- en produccion se debe quitar la /auditoria/ -->

<?php
include_once('dirs.php');

if ($isProduction) {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/apps/coso/');
} else {
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/auditoria/apps/coso/');
}
// production
// define('CONTROLLER_PATH', ROOT_PATH.'controller/');
define('DB', ROOT_PATH . 'core/');
define('MODEL_PATH', ROOT_PATH . 'core/model/');
define('ACCESS_PATH', ROOT_PATH . 'core/access/');
define('FRONT', ROOT_PATH . 'public/');
define('BACK', ROOT_PATH . 'core/');
define('VIEWS', FRONT . 'view/');
define('VENDOR', FRONT . 'vendor/');
define('ASSETS', FRONT . 'assets/');
define('CSS', FRONT . 'css/');
// define('IMP_PATH', DAO_PATH . 'imp/');
