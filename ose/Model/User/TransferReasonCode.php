<?php

require_once __DIR__ . '/BaseModel.php';

class TransferReasonCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("transfer_reason_code","code",$db);
    }
}