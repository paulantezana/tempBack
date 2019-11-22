<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatCurrencyTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_currency_type_code","code",$db);
    }
}
