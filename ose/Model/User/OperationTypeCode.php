<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class OperationTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("operation_type_code","code",$db);
    }
}
