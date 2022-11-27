<?php

include_once('../../../../../helpers/vars.php');

if ($isProduction) { 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include(ACCESS_PATH . 'mysql_layer.php');

class UserReference extends InternalCALL
{
    public $CompanyName;
    public $Name;
    public $RolLevel;
    public $RolName;
    public $UID;

    function charger($valCompany, $valName, $valLevel, $valRName, $valUID)
    {
        $this->CompanyName = $valCompany;
        $this->Name = $valName;
        $this->RolLevel = $valLevel;
        $this->RolName = $valRName;
        $this->UID = $valUID;
    }
}
