<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class SystemIscTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("system_isc_type_code","code",$db);
    }
}
