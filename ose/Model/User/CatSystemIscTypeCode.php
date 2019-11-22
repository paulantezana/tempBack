<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatSystemIscTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_system_isc_type_code","code",$db);
    }
}
