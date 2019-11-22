<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatPerceptionTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_perception_type_code","code",$db);
    }
}
