<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class DebitNoteTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("debit_note_type_code","code",$db);
    }
}
