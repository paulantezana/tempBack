<?php

require_once __DIR__ . '/BaseModel.php';

class OperationTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("operation_type_code","code",$db);
    }
}