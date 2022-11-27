<?php

include_once('../../../../../helpers/vars.php');

if ($isProduction) {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(ACCESS_PATH . 'mysql_layer.php');


class Control extends InternalCALL
{
    public $ControlId;
    public $ControlName;
    public $ControlDescription;
    public $Responsable;
}

class ControlDTO extends InternalCALL {
public $RiskId;
}

class ControlInsert extends InternalCALL {
    public $Name;
    public $Description;
    public $Responsable;
    public $RiskId;
}

class ControlToRisk extends InternalCALL {
    public $control;
}