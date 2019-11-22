<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatIdentityDocumentTypeCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_identity_document_type_code","code",$db);
    }
}
