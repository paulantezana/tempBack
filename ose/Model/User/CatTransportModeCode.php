<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatTransportModeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_transport_mode_code","code",$db);
    }
}
