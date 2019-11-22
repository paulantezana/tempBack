<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatCreditNoteTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_credit_note_type_code","code",$db);
    }
}
