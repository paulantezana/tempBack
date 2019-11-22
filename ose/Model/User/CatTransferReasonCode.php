<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatTransferReasonCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_transfer_reason_code","code",$db);
    }
}
