<?php


include_once('../../../../../helpers/vars.php');

if ($isProduction) { 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(ACCESS_PATH . 'mysql_layer.php');


class User
{

    public $IdUser;
    public $Name;
    public $Email;
    public $Password;
    public $State;
    public $IdPersonal;
}


class UserDTO extends InternalCALL
{   
    var $Exists;
    var $CompanyName;
    var $Name;
    var $RolLevel;
    var $RolName;
    var $UID; 

}
