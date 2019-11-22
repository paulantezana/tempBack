<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatAffectationIgvTypeCode extends  BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_affectation_igv_type_code","code",$db);
    }
}
