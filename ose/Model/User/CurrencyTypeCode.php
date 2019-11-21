<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CurrencyTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("currency_type_code","code",$db);
    }
}
