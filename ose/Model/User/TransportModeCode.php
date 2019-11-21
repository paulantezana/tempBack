<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class TransportModeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("transport_mode_code","code",$db);
    }
}
