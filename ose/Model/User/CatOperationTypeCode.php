<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatOperationTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_operation_type_code","code",$db);
    }
}
