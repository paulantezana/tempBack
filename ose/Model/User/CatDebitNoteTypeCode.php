<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatDebitNoteTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_debit_note_type_code","code",$db);
    }
}
