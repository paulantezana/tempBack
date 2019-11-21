<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class IdentityDocumentTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("identity_document_type_code","code",$db);
    }
}
