<?php

require_once MODEL_PATH . '/Helper/BaseModel.php';

class BusinessLocal extends BaseModel
{
    public function __construct(PDO $db)
    {
        parent::__construct("business_local","business_local_id",$db);
    }

    public function GetAllByBusinessId($businessId)
    {
        try {
            $sql = 'SELECT * FROM business_local WHERE business_id = :business_id';
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':business_id' => $businessId
            ]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Insert($businessLocal, $userReferId){
        try{
            $currentDate = date('Y-m-d H:i:s');

            $sql = "INSERT INTO business_local (updated_at, created_at, created_user_id, updated_user_id, short_name,
                                                sunat_code, location_code, department, province, district, address,
                                                pdf_invoice_size, pdf_header, description, business_id)
                    VALUES (:updated_at, :created_at, :creation_user_id, :modification_user_id, :short_name,
                            :sunat_code, :location_code, :department, :province, :district, :address, :pdf_invoice_size,
                            :pdf_header, :description, :business_id)";
            $stmt = $this->db->prepare($sql);

            if(!$stmt->execute([
                ':updated_at' => $currentDate,
                ':created_at' => $currentDate,
                ':created_user_id' => $userReferId,
                ':updated_user_id' => $userReferId,

                ':short_name' => $businessLocal['shortName'],
                ':sunat_code' => $businessLocal['sunatCode'],
                ':location_code' => $businessLocal['locationCode'],
                ':department' => $businessLocal['department'],
                ':province' => $businessLocal['province'],
                ':district' => $businessLocal['district'],
                ':address' => $businessLocal['address'],
                ':pdf_invoice_size' => $businessLocal['pdfInvoiceSize'],
                ':pdf_header' => $businessLocal['pdfHeader'],
                ':description' => $businessLocal['description'],
                ':business_id' => $businessLocal['businessId'],
            ])){
                throw new Exception("Error al insertar el registro");
            }
            $businessLocalId = (int)$this->db->lastInsertId();

            foreach ($businessLocal['item'] as $row){
                $sql = "INSERT INTO business_serie (updated_at, business_local_id, serie, document_code, max_correlative, contingency)
                    VALUES (:updated_at, :business_local_id, :serie, :document_code, :max_correlative, :contingency)";
                $stmt = $this->db->prepare($sql);

                if(!$stmt->execute([
                    ':updated_at' => $currentDate,
                    ':business_local_id' => $businessLocalId,
                    ':serie' => $row['serie'],
                    ':document_code' => $row['documentCode'],
                    ':max_correlative' => 0,
                    ':contingency' => 0,
                ])){
                    throw new Exception("Error al insertar el registro");
                }
            }
            return $businessLocalId;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}
