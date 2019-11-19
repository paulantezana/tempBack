<?php

require_once __DIR__ . '/BaseModel.php';

class TransportModeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("transport_mode_code","code",$db);
    }
}