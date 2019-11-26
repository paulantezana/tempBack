<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class CatSubjectDetractionCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("cat_subject_detraction_code","code",$db);
    }
}
