<?php

require_once __DIR__ . '/BaseModel.php';

class SubjectDetractionCode extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("subject_detraction_code","code",$db);
    }
}
