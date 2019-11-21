<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class TransferReasonCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("transfer_reason_code","code",$db);
    }
}
