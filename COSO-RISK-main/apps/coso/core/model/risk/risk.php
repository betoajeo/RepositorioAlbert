<?php
 
include_once('../../../../../helpers/vars.php');

if ($isProduction) { 
    include_once($_SERVER['DOCUMENT_ROOT'] . '/helpers/dirs.php');
} else {
    include_once($_SERVER['DOCUMENT_ROOT'] . '/auditoria/helpers/dirs.php');
}
include_once(ACCESS_PATH . 'mysql_layer.php');


class RiskDTO extends InternalCALL
{
    public $IdRisk;
    public $RiskName;
    public $RiskTypeName;
    public $Responsable;
    public $RiskProbabilityAcceptable;
    public $RiskDescription;
    public $RiskLevel;
    public $IdPlan;
}

class RiskSingle extends InternalCALL
{
    public $RiskName;
    public $RiskDescription;
    public $RiskProbabilityAcceptable;
    public $RiskLevel;
    public $Responsable;
    public $RiskTypeName;
    public $IdPlan;
}

class RiskSingleDTO extends InternalCALL
{
    public $RsikId;
    public $RiskName;
    public $RiskDescription;
    public $RiskProbabilityAcceptable;
    public $RiskLevel;
    public $Responsable;
    public $RiskType;
}

class RiskInsert extends InternalCALL {
    public $RiskName;
    public $RiskResponsable;
    public $RiskProbabilityAcceptable;
    public $RiskDescription;
    public $RiskTypeName;
    public $RiskLevel;

    public function __toString()
    {
        return $this->RiskName . " " . $this->RiskResponsable . " " . $this->RiskProbabilityAcceptable . " " .
                $this->RiskDescription . " " . $this->RiskTypeName . " " . $this->RiskLevel;
    }
}

class RiskView extends InternalCALL {
    public $IdRisk;
    public $RiskName;
    public $Responsable;
    public $RiskTypeName;
    public $RiskProbabilityAcceptable;
    public $RiskDescription;
    public $RiskLevel;
    public $IdPlan; 
}


class DeleteRisk extends InternalCALL {
    public $RiskId;
}