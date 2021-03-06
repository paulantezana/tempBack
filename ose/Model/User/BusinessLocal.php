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
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage());
        }
    }


    public function Insert($businessLocal, $userReferId){
        try{
            $currentDate = date('Y-m-d H:i:s');

            $sql = "INSERT INTO business_local (updated_at, created_at, created_user_id, updated_user_id, short_name,
                                                sunat_code, location_code, address,
                                                pdf_invoice_size, pdf_header, description, business_id)
                            VALUES (:updated_at, :created_at, :created_user_id, :updated_user_id, :short_name,
                                    :sunat_code, :location_code, :address, :pdf_invoice_size,
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
                    ':contingency' => $row['contingency'],
                ])){
                    throw new Exception("Error al insertar el registro");
                }
            }
            return $businessLocalId;
        } catch (Exception $e) {
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    public function Save($businessLocal,$userReferId){
        try{
            $this->db->beginTransaction();
            $currentDate = date('Y-m-d H:i:s');

            if (((int)$businessLocal['businessLocalId'] ?? 0) >= 1){
                $businessLocalId = (int)$businessLocal['businessLocalId'];
                $this->UpdateById($businessLocalId,[
                    'updated_at' => $currentDate,
                    'modification_user_id' => $userReferId,

                    'short_name' => $businessLocal['shortName'],
                    'sunat_code' => $businessLocal['sunatCode'],
                    'location_code' => $businessLocal['locationCode'],
                    'department' => $businessLocal['department'],
                    'province' => $businessLocal['province'],
                    'district' => $businessLocal['district'],
                    'address' => $businessLocal['address'],
                    'pdf_invoice_size' => $businessLocal['pdfInvoiceSize'],
                    'pdf_header' => $businessLocal['pdfHeader'],
                    'description' => $businessLocal['description'],
                    'business_id' => $businessLocal['businessId'],
                ]);

//                $sql = "DELETE FROM business_serie WHERE business_local_id = :business_local_id";
//                $stmt = $this->db->prepare($sql);
//                if(!$stmt->execute([
//                    ':business_local_id' => $businessLocalId,
//                ])){
//                    throw new Exception("Error al eliminar el registro");
//                }

                foreach ($businessLocal['item'] as $row){
                    if ($row['business_serie_id']>=1){
                        $sql = "UPDATE business_serie SET updated_at = :updated_at, serie=:serie, document_code = :document_code, contingency = :contingency
                                WHERE business_serie_id = :business_serie_id";
                        $stmt = $this->db->prepare($sql);

                        if(!$stmt->execute([
                            ':updated_at' => $currentDate,
                            ':serie' => $row['serie'],
                            ':document_code' => $row['documentCode'],
                            ':contingency' => 0,
                            ':business_serie_id' => $row['businessSerieId'],
                        ])){
                            throw new Exception("Error al actualizar el registro");
                        }
                    } else {
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
                }

                $this->db->commit();
                return $businessLocalId;
            } else {
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

                $this->db->commit();
                return $businessLocalId;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Error in : " . __FUNCTION__ . ' | ' . $e->getMessage());
        }
    }
}
