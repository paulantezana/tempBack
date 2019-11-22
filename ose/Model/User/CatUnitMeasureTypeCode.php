<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatUnitMeasureTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_unit_measure_type_code","code",$db);
    }
}
