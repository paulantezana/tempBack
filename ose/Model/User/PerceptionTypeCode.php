<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class PerceptionTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("perception_type_code","code",$db);
    }
}
