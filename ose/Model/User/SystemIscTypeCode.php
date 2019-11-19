<?php

require_once __DIR__ . '/BaseModel.php';

class SystemIscTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("system_isc_type_code","code",$db);
    }
}