<?php

include_once('../../../../../helpers/vars.php');

if ($isProduction) { 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(ACCESS_PATH . 'mysql_layer.php');


class Personal extends InternalCALL {

    public $IdPersonal;
    public $FirstName;
    public $SecondName;
    public $Surname;
    public $SecondSurname;
    public $Position;
    public $State;

     
}

class PersonalCompanyDTO extends InternalCALL {
    public $IdPersonal;
    public $Name;
}