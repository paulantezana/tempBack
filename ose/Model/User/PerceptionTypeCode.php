<?php

require_once __DIR__ . '/BaseModel.php';

class PerceptionTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("perception_type_code","code",$db);
    }
}