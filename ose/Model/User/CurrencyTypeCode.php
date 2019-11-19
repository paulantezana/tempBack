<?php

require_once __DIR__ . '/BaseModel.php';

class CurrencyTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("currency_type_code","code",$db);
    }
}