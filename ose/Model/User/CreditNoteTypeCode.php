<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CreditNoteTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("credit_note_type_code","code",$db);
    }
}
