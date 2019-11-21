<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class AffectationIgvTypeCode extends  BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("affectation_igv_type_code","code",$db);
    }
}
