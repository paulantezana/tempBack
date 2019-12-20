<?php

require_once __DIR__ . '/SunatRUC.php';
require_once __DIR__ . '/BuscaRUC.php';
require_once __DIR__ . '/EsaludDNI.php';

class PeruService
{
    static public function queryDNI($dni){
        $esalud = new EsaludDNI();
        $result = $esalud->Query($dni);
        return $result;
    }

   static public function queryRUC($ruc){
        $buscaRUC = new BuscaRUC();
        $result = $buscaRUC->Query($ruc);
        if ($result->success){
            return $result;
        }

        $sunatRUC = new SunatRUC();
        $result = $sunatRUC->Query($ruc);
        return $result;
    }
}
