<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class UnitMeasureTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("unit_measure_type_code","code",$db);
    }
}
