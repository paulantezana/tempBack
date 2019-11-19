<?php

require_once __DIR__ . '/BaseModel.php';

class AffectationIgvTypeCode extends  BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("affectation_igv_type_code","code",$db);
    }
}