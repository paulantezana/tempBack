# -------------------------------------------------------------------------------
# -------------------------------------------------------------------------------
# CATALOGUES SUNAT
DROP DATABASE ose;
CREATE DATABASE ose;
USE ose;

# Catalogue 01
CREATE TABLE cat_document_type_code(
                                       code VARCHAR(2) NOT NULL,
                                       description VARCHAR(255) NOT NULL,
                                       CONSTRAINT pk_document_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 02
CREATE TABLE cat_currency_type_code(
                                       code VARCHAR(6) NOT NULL,
                                       description VARCHAR(255) NOT NULL,
                                       entity VARCHAR(510),
                                       symbol VARCHAR(12),
                                       CONSTRAINT pk_currency_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 03
CREATE TABLE cat_unit_measure_type_code(
                                           code VARCHAR(12) NOT NULL,
                                           description VARCHAR(255) NOT NULL,
                                           extend BOOLEAN, # Unit measure extended code
                                           CONSTRAINT pk_unit_measure_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 04
# Catalogue 05
CREATE TABLE cat_tribute_type_code(
                                      code VARCHAR(4) NOT NULL,
                                      description VARCHAR(255) NOT NULL,
                                      international_code VARCHAR(3),
                                      name VARCHAR(6),
                                      CONSTRAINT pk_unit_measure_type_code PRIMARY KEY (code)
) ENGINE = InnoDB;
# Catalogue 06
CREATE TABLE cat_identity_document_type_code(
                                                code VARCHAR(1) NOT NULL,
                                                description VARCHAR(255) NOT NULL,
                                                CONSTRAINT pk_identity_document_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 07
CREATE  TABLE cat_affectation_igv_type_code(
                                               code VARCHAR(2) NOT NULL,
                                               description VARCHAR(255) NOT NULL,
                                               tribute_code VARCHAR(4),
                                               onerous BOOLEAN,
                                               CONSTRAINT pk_affectation_igv_type_code PRIMARY KEY (code),
                                               CONSTRAINT fk_affectation_igv_type_code_tribute_type_code FOREIGN KEY (tribute_code) REFERENCES cat_tribute_type_code (code)
                                                   ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;
# Catalogue 08
CREATE TABLE cat_system_isc_type_code(
                                         code VARCHAR(2) NOT NULL,
                                         description VARCHAR(255) NOT NULL,
                                         CONSTRAINT pk_system_isc_type_code PRIMARY KEY (code)
) ENGINE = InnoDB;
# Catalogue 09
CREATE TABLE cat_credit_note_type_code(
                                          code VARCHAR(2) NOT NULL,
                                          description VARCHAR(255) NOT NULL,
                                          CONSTRAINT pk_credit_note_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 10
CREATE TABLE cat_debit_note_type_code(
                                         code VARCHAR(2) NOT NULL,
                                         description VARCHAR(255) NOT NULL,
                                         CONSTRAINT pk_debit_note_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 11
# Catalogue 12
# Catalogue 13
CREATE TABLE cat_geographical_location_code (
                                                code VARCHAR(6) NOT NULL,
                                                district varchar(64) NOT NULL,
                                                province varchar(64) NOT NULL,
                                                department varchar(64) NOT NULL,
                                                CONSTRAINT pk_geographical_location_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 14
# Catalogue 15
CREATE TABLE cat_additional_legend_code(
                                           code VARCHAR(4) NOT NULL,
                                           description VARCHAR(255) NOT NULL,
                                           CONSTRAINT pk_additional_legend_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 16
# Catalogue 17
# Catalogue 18
CREATE TABLE cat_transport_mode_code(
                                        code VARCHAR(2) NOT NULL,
                                        description VARCHAR(255) NOT NULL,
                                        CONSTRAINT pk_transport_mode_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 19
CREATE TABLE cat_summary_state_code(
                                       code ENUM('1','2','3') NOT NULL,
                                       description VARCHAR(255) NOT NULL,
                                       CONSTRAINT pk_transport_mode_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 20
CREATE TABLE cat_transfer_reason_code(
                                         code VARCHAR(2) NOT NULL,
                                         description VARCHAR(255) NOT NULL,
                                         CONSTRAINT pk_transfer_reason_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 21
# Catalogue 22
CREATE TABLE cat_perception_type_code(
                                         code VARCHAR(2) NOT NULL,
                                         description VARCHAR(255) NOT NULL,
                                         percentage FLOAT NOT NULL,
                                         CONSTRAINT perception_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 23
# Catalogue 24
# Catalogue 25
CREATE TABLE cat_product_code(
                                 code VARCHAR(8) NOT NULL,
                                 description VARCHAR(510) NOT NULL,
                                 CONSTRAINT pk_product_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 26
# Catalogue 27
# Catalogue 28
# Catalogue 29
# Catalogue 30
# ...
# Catalogue 51
CREATE  TABLE cat_operation_type_code(
                                         code VARCHAR(4) NOT NULL,
                                         description VARCHAR(255) NOT NULL,
                                         CONSTRAINT pk_operation_type_code PRIMARY KEY (code)
)ENGINE = InnoDB;
# Catalogue 54
CREATE TABLE cat_subject_detraction_code(
                                            code VARCHAR(3) NOT NULL,
                                            description VARCHAR(255) NOT NULL,
                                            CONSTRAINT subject_detraction_code PRIMARY KEY (code)
)ENGINE = InnoDB;


# -------------------------------------------------------------------------------
# -------------------------------------------------------------------------------
# SYSTEM
CREATE TABLE business(
                         business_id INT AUTO_INCREMENT NOT NULL,
                         include_igv BOOLEAN,
                         continue_payment BOOLEAN,
                         total_calculation_item ENUM('unit_price','amount'),
                         send_email_company BOOLEAN,
                         detraction_bank_account VARCHAR(20),
                         ruc VARCHAR(32),
                         social_reason VARCHAR(255),
                         commercial_reason VARCHAR(255),
                         email VARCHAR(64),
                         phone VARCHAR(32),
                         web_site VARCHAR(64),
                         environment TINYINT,
                         logo VARCHAR(255),
                         UNIQUE KEY uk_company (web_site,email),
                         CONSTRAINT pk_company PRIMARY KEY (business_id)
)ENGINE = InnoDB;

CREATE TABLE business_local(
                               business_local_id INT AUTO_INCREMENT NOT NULL,
                               updated_at DATETIME,
                               created_at DATETIME,
                               created_user_id INT,
                               updated_user_id INT,

                               short_name VARCHAR(64),
                               sunat_code varchar(64),
                               location_code varchar(8),
                               department varchar(64),
                               province varchar(64),
                               district varchar(64),
                               address varchar(255),
                               pdf_invoice_size varchar(8),
                               pdf_header varchar(255),
                               description varchar(255),
                               business_id INT NOT NULL,
                               api_token VARCHAR(255),

                               CONSTRAINT pk_business_local PRIMARY KEY (business_local_id),
                               CONSTRAINT fk_business_local_business FOREIGN KEY (business_id) REFERENCES business (business_id)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE business_serie(
                               business_serie_id INT AUTO_INCREMENT NOT NULL,
                               updated_at DATETIME,
                               delete_at DATETIME,
                               business_local_id INT NOT NULL,
                               serie VARCHAR(4) NOT NULL,
                               document_code VARCHAR(2) NOT NULL,
                               max_correlative INT,
                               contingency BOOLEAN,
                               detraction_bank_account VARCHAR(64),
                               hidden BOOLEAN,
                               CONSTRAINT pk_business_serie PRIMARY KEY (business_serie_id),
                               CONSTRAINT fk_business_serie_document_code FOREIGN KEY (document_code) REFERENCES cat_document_type_code (code)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT,
                               CONSTRAINT fk_business_serie_business_local FOREIGN KEY (business_local_id) REFERENCES business_local (business_local_id)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE business_user(
                              business_id INT NOT NULL,
                              user_id INT NOT NULL,
                              CONSTRAINT fk_business_user_business FOREIGN KEY (business_id) REFERENCES business (business_id)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT
#     CONSTRAINT fk_business_user_user FOREIGN KEY (user_id) REFERENCES users (id_user)
#         ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE product(
                        product_id INT AUTO_INCREMENT NOT NULL,
                        updated_at DATETIME,
                        created_at DATETIME,
                        created_user_id INT,
                        updated_user_id INT,

                        business_id INT,
                        description VARCHAR(255) NOT NULL,
                        unit_price_sale FLOAT,
                        unit_price_sale_igv FLOAT,
                        product_code VARCHAR(12) NOT NULL,
                        unit_measure_code VARCHAR(12) NOT NULL,
                        affectation_code VARCHAR(8),
                        system_isc_code VARCHAR(2),
                        isc FLOAT,
                        CONSTRAINT pk_product PRIMARY KEY (product_id),
                        CONSTRAINT fk_product_cat_unit_measure_type_code FOREIGN KEY (unit_measure_code) REFERENCES cat_unit_measure_type_code (code)
                            ON UPDATE RESTRICT ON DELETE RESTRICT,
                        CONSTRAINT fk_product_cat_product_code FOREIGN KEY (product_code) REFERENCES cat_product_code (code)
                            ON UPDATE RESTRICT ON DELETE RESTRICT,
                        CONSTRAINT fk_product_cat_affectation_igv_type_code FOREIGN KEY (affectation_code) REFERENCES cat_affectation_igv_type_code (code)
                            ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE customer(
                         customer_id INT AUTO_INCREMENT NOT NULL,
                         updated_at DATETIME,
                         created_at DATETIME,
                         created_user_id INT,
                         updated_user_id INT,

                         business_id INT,

                         document_number VARCHAR(16) NOT NULL,
                         identity_document_code VARCHAR(64) NOT NULL,
                         social_reason VARCHAR(255),
                         commercial_reason VARCHAR(255),
                         fiscal_address VARCHAR(255),
                         main_email VARCHAR(64),
                         optional_email_1 VARCHAR(64),
                         optional_email_2 VARCHAR(64),
                         telephone VARCHAR(255),
                         CONSTRAINT pk_customer PRIMARY KEY (customer_id),
                         CONSTRAINT fk_customer_document_type_code FOREIGN KEY (identity_document_code) REFERENCES cat_identity_document_type_code (code)
                             ON UPDATE RESTRICT ON DELETE RESTRICT

)ENGINE = InnoDB;

CREATE TABLE invoice_state (
                               invoice_state_id SMALLINT AUTO_INCREMENT NOT NULL,
                               state VARCHAR(64),
                               CONSTRAINT pk_invoice_state PRIMARY KEY (invoice_state_id)
);

CREATE TABLE invoice(
                        invoice_id INT AUTO_INCREMENT NOT NULL,
                        invoice_key VARCHAR(32) NOT NULL,
                        updated_at DATETIME,
                        created_at DATETIME,
                        created_user_id INT,
                        updated_user_id INT,

                        local_id INT,

                        date_of_issue DATE NOT NULL,            # fecha_de_emision
                        time_of_issue TIME NOT NULL,            # hora_de_emision
                        date_of_due DATE,                       # fecha_de_vencimiento
                        serie VARCHAR(64),                      # serie_documento
                        correlative INT NOT NULL,               # numero_documento
                        observation TEXT,
                        change_type VARCHAR(255),               # TIPO DE CAMBIO
                        document_code VARCHAR(2),               # CODIGO TIPO DE DOCUMENTO
                        currency_code VARCHAR(8),               # CODIGO TIPO DE MONEDA
                        operation_code VARCHAR(8),              # CODIGO TIPO DE OPERACION

                        total_prepayment FLOAT,                 # total_anticipos
                        total_free FLOAT,                       # total_operaciones_gratuitas
                        total_exportation FLOAT,                # total_exportacion
                        total_other_charged FLOAT,              # total_otros_cargos
                        total_discount FLOAT,                   # total_descuentos
                        total_exonerated FLOAT,                 # total_operaciones_exoneradas
                        total_unaffected FLOAT,                 # total_operaciones_inafectas
                        total_taxed FLOAT,                      # total_operaciones_gravadas
                        total_igv FLOAT,                        # total_igv
                        total_base_isc FLOAT,                   # total_base_isc
                        total_isc FLOAT,                        # total_isc
                        total_charge FLOAT,                     # total_cargos
                        total_base_other_taxed FLOAT,           # total_base_otros_impuestos
                        total_other_taxed FLOAT,                # total_otros_impuestos
                        total_value FLOAT,                      # total_valor
                        total_plastic_bag_tax FLOAT,            # total_plastic_bag_tag
                        total FLOAT NOT NULL,                   # total_venta

                        global_discount_percentage FLOAT,
                        purchase_order VARCHAR(255),
                        vehicle_plate VARCHAR(255),
                        term VARCHAR(255),
                        percentage_plastic_bag_tax FLOAT,
                        percentage_igv FLOAT,

                        perception_code VARCHAR(2),     # JSON Array de percepciones
                        detraction TEXT,                # JSON Array de detracciones
                        related TEXT,                   # JSON Array de documentos relacionados
                        guide TEXT,                     # JSON Array de guia de referencia
                        legend TEXT,                    # JSON Array de leyendas // SAVE ONLY LEYEND CODES.

                        pdf_format VARCHAR(16),
                        itinerant_enable BOOLEAN,
                        itinerant_location VARCHAR(6),
                        itinerant_address varchar(255),
                        itinerant_urbanization varchar(255),

                        CONSTRAINT pk_invoice PRIMARY KEY (invoice_id),
                        CONSTRAINT uk_invoice UNIQUE (invoice_key),
                        INDEX (serie,correlative,local_id),
                        CONSTRAINT fk_invoice_currency_type_code FOREIGN KEY (currency_code) REFERENCES cat_currency_type_code (code)
                            ON UPDATE RESTRICT ON DELETE RESTRICT,
                        CONSTRAINT fk_invoice_operation_type_code FOREIGN KEY (operation_code) REFERENCES cat_operation_type_code (code)
                            ON UPDATE RESTRICT ON DELETE RESTRICT,
                        CONSTRAINT fk_invoice_document_type_code FOREIGN KEY (document_code) REFERENCES cat_document_type_code (code)
                            ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_item(
                             invoice_item_id INT AUTO_INCREMENT NOT NULL,
                             invoice_id INT NOT NULL,

                             unit_measure VARCHAR(4) NOT NULL,
                             product_code VARCHAR(255) NOT NULL,
                             description VARCHAR(128) NOT NULL,
                             quantity INT NOT NULL,
                             unit_value FLOAT NOT NULL,
                             unit_price FLOAT NOT NULL,

                             discount FLOAT,
                             charge FLOAT,

                             affectation_code VARCHAR(8) NOT NULL,
                             total_base_igv FLOAT,
                             igv FLOAT, # Igv

                             system_isc_code VARCHAR(2),
                             total_base_isc FLOAT,
                             tax_isc FLOAT,
                             isc FLOAT,

                             total_base_other_taxed FLOAT,
                             percentage_other_taxed FLOAT,
                             other_taxed FLOAT,

                             quantity_plastic_bag FLOAT,
                             plastic_bag_tax FLOAT,

                             prepayment_regulation BOOLEAN,
                             prepayment_serie VARCHAR(4),
                             prepayment_correlative varchar(9),

                             total_value FLOAT,
                             total FLOAT,

                             CONSTRAINT pk_invoice_item PRIMARY KEY (invoice_item_id),
                             CONSTRAINT fk_invoice_item_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                 ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_sunat(
                              invoice_sunat_id INT AUTO_INCREMENT NOT NULL,
                              invoice_state_id SMALLINT,
                              invoice_id INT NOT NULL,
                              send BOOLEAN,
                              response_code VARCHAR(6),
                              response_message VARCHAR(255),
                              other_message VARCHAR(255),
                              pdf_url varchar(255),
                              xml_url VARCHAR(255),
                              cdr_url varchar(255),
                              CONSTRAINT pk_invoice_sunat PRIMARY KEY (invoice_sunat_id),
                              CONSTRAINT uk_invoice_sunat UNIQUE KEY (invoice_id),
                              CONSTRAINT fk_invoice_sunat_invoice_state FOREIGN KEY (invoice_state_id) REFERENCES invoice_state (invoice_state_id)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT,
                              CONSTRAINT fk_invoice_sunat_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE invoice_customer(
                                 invoice_customer_id INT AUTO_INCREMENT NOT NULL,
                                 invoice_id INT NOT NULL,
                                 document_number VARCHAR(16) NOT NULL,
                                 identity_document_code VARCHAR(64) NOT NULL,
                                 social_reason VARCHAR(255),
                                 fiscal_address VARCHAR(255),
                                 email VARCHAR(64),
                                 telephone VARCHAR(255),
                                 sent_to_client BOOLEAN,
                                 CONSTRAINT pk_invoice_customer PRIMARY KEY (invoice_customer_id),
                                 CONSTRAINT uk_invoice_customer_sunat UNIQUE KEY (invoice_id),
                                 CONSTRAINT fk_invoice_customer_identity_document_type_code FOREIGN KEY (identity_document_code) REFERENCES cat_identity_document_type_code (code)
                                     ON UPDATE RESTRICT ON DELETE RESTRICT,
                                 CONSTRAINT fk_invoice_customer_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                     ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE invoice_referral_guide(
                                       invoice_referral_guide_id INT AUTO_INCREMENT NOT NULL,
                                       invoice_id INT NOT NULL,
                                       document_code VARCHAR(2) NOT NULL,
                                       whit_guide BOOLEAN,

                                       transfer_code VARCHAR(2),
                                       transport_code VARCHAR(2),
                                       transfer_start_date DATE,
                                       total_gross_weight FLOAT,

                                       carrier_document_code VARCHAR(1),
                                       carrier_document_number VARCHAR(24),
                                       carrier_denomination VARCHAR(255),
                                       carrier_plate_number VARCHAR(64),

                                       driver_document_code VARCHAR(1),
                                       driver_document_number VARCHAR(24),
                                       driver_full_name VARCHAR(255),

                                       location_starting_code VARCHAR(6),
                                       address_starting_point VARCHAR(128),

                                       location_arrival_code VARCHAR(6),
                                       address_arrival_point VARCHAR(128),
                                       CONSTRAINT pk_invoice_referral_guide PRIMARY KEY (invoice_referral_guide_id),
                                       CONSTRAINT uk_invoice_referral_guide UNIQUE KEY (invoice_id),
                                       CONSTRAINT fk_invoice_referral_guide FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                           ON UPDATE RESTRICT ON DELETE RESTRICT,
                                       CONSTRAINT fk_invoice_referral_guide_location_starting_code FOREIGN KEY (location_starting_code) REFERENCES cat_geographical_location_code (code)
                                           ON UPDATE RESTRICT ON DELETE RESTRICT,
                                       CONSTRAINT fk_invoice_referral_guide_location_arrival_code FOREIGN KEY (location_arrival_code) REFERENCES cat_geographical_location_code (code)
                                           ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_detraction(
                                   invoice_detraction_id INT AUTO_INCREMENT NOT NULL,
                                   invoice_id INT NOT NULL,

                                   whit_detraction BOOLEAN,
                                   detraction_code VARCHAR(3),
                                   percentage FLOAT,
                                   amount FLOAT,

                                   referral_value VARCHAR(1),
                                   effective_load VARCHAR(24),
                                   useful_load VARCHAR(255),
                                   travel_detail VARCHAR(255),
                                   location_starting_code VARCHAR(6),
                                   address_starting_point VARCHAR(128),
                                   location_arrival_code VARCHAR(6),
                                   address_arrival_point VARCHAR(128),

                                   boat_registration VARCHAR(32),
                                   boat_name VARCHAR(32),
                                   species_kind VARCHAR(32),
                                   delivery_address VARCHAR(64),
                                   delivery_date DATETIME,
                                   quantity FLOAT,

                                   CONSTRAINT pk_invoice_detraction PRIMARY KEY (invoice_detraction_id),
                                   CONSTRAINT uk_invoice_detraction UNIQUE KEY (invoice_id),
                                   CONSTRAINT fk_invoice_detraction_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
);

CREATE TABLE invoice_summary(
                                invoice_summary_id INT AUTO_INCREMENT NOT NULL,
                                invoice_summary_key varchar(32) NOT NULL,
                                updated_at DATETIME,
                                created_at DATETIME,
                                created_user_id INT,
                                updated_user_id INT,

                                local_id INT,
                                correlative INT,
                                date_of_issue DATE NOT NULL,
                                date_of_reference DATE NOT NULL,

                                invoice_state_id SMALLINT,
                                send BOOLEAN,
                                ticket VARCHAR(64),
                                response_code BOOLEAN,
                                response_message VARCHAR(15),
                                other_message TEXT,
                                pdf_url varchar(255),
                                xml_url VARCHAR(255),
                                cdr_url varchar(255),

                                CONSTRAINT pk_invoice_summary PRIMARY KEY (invoice_summary_id),
                                CONSTRAINT uk_invoice_summary UNIQUE KEY (invoice_summary_key),
                                CONSTRAINT fk_invoice_summary_invoice_state FOREIGN KEY (invoice_state_id) REFERENCES invoice_state (invoice_state_id)
                                    ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_summary_item(
                                     invoice_summary_item_id INT AUTO_INCREMENT NOT NULL,
                                     invoice_summary_id INT NOT NULL,
                                     invoice_id INT NOT NULL,
                                     local_id INT,

                                     date_of_issue DATE NOT NULL,
                                     date_of_reference DATE NOT NULL,
                                     summary_state_code ENUM('1','2','3') NOT NULL,

                                     sunat_state INT null,
                                     CONSTRAINT pk_invoice_summary_item PRIMARY KEY (invoice_summary_item_id),
                                     CONSTRAINT fk_invoice_summary_item_invoice_summary FOREIGN KEY (invoice_summary_id) REFERENCES invoice_summary (invoice_summary_id)
                                         ON UPDATE RESTRICT ON DELETE RESTRICT,
                                     CONSTRAINT fk_invoice_summary_item_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                         ON UPDATE RESTRICT ON DELETE RESTRICT,
                                     CONSTRAINT fk_invoice_summary_item_summary_state_code FOREIGN KEY (summary_state_code) REFERENCES cat_summary_state_code (code)
                                         ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_voided(
                               invoice_voided_id INT AUTO_INCREMENT NOT NULL,
                               updated_at DATETIME,
                               created_at DATETIME,
                               created_user_id INT,
                               updated_user_id INT,

                               local_id INT,
                               invoice_id INT NOT NULL,
                               reason VARCHAR(255),
                               date_of_issue DATE NOT NULL,
                               correlative INT,

                               invoice_state_id SMALLINT,
                               send BOOLEAN,
                               ticket VARCHAR(64),
                               response_code BOOLEAN,
                               response_message VARCHAR(15),
                               other_message TEXT,
                               pdf_url varchar(255),
                               xml_url VARCHAR(255),
                               cdr_url varchar(255),

                               CONSTRAINT pk_invoice_voided PRIMARY KEY (invoice_voided_id),
                               CONSTRAINT uk_invoice_voided UNIQUE (invoice_id),
                               CONSTRAINT fk_invoice_voided_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT,
                               CONSTRAINT fk_invoice_voided_invoice_state FOREIGN KEY (invoice_state_id) REFERENCES invoice_state (invoice_state_id)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE invoice_note (
                              invoice_note_id INT AUTO_INCREMENT NOT NULL,
                              invoice_note_key VARCHAR(32) NOT NULL,
                              updated_at DATETIME,
                              created_at DATETIME,
                              created_user_id INT,
                              updated_user_id INT,
                              invoice_id INT,
                              reason_update_code VARCHAR(2),

                              local_id INT,

                              date_of_issue DATE NOT NULL,            # fecha_de_emision
                              time_of_issue TIME NOT NULL,            # hora_de_emision
                              date_of_due DATE,                       # fecha_de_vencimiento
                              serie VARCHAR(64),                      # serie_documento
                              correlative INT NOT NULL,               # numero_documento
                              observation TEXT,
                              change_type VARCHAR(255),               # TIPO DE CAMBIO
                              document_code VARCHAR(2),               # CODIGO TIPO DE DOCUMENTO
                              currency_code VARCHAR(8),               # CODIGO TIPO DE MONEDA
                              operation_code VARCHAR(8),              # CODIGO TIPO DE OPERACION

                              total_prepayment FLOAT,                 # total_anticipos
                              total_free FLOAT,                       # total_operaciones_gratuitas
                              total_exportation FLOAT,                # total_exportacion
                              total_other_charged FLOAT,              # total_otros_cargos
                              total_discount FLOAT,                   # total_descuentos
                              total_exonerated FLOAT,                 # total_operaciones_exoneradas
                              total_unaffected FLOAT,                 # total_operaciones_inafectas
                              total_taxed FLOAT,                      # total_operaciones_gravadas
                              total_igv FLOAT,                        # total_igv
                              total_base_isc FLOAT,                   # total_base_isc
                              total_isc FLOAT,                        # total_isc
                              total_charge FLOAT,                     # total_cargos
                              total_base_other_taxed FLOAT,           # total_base_otros_impuestos
                              total_other_taxed FLOAT,                # total_otros_impuestos
                              total_value FLOAT,                      # total_valor
                              total_plastic_bag_tax FLOAT,            # total_plastic_bag_tag
                              total FLOAT NOT NULL,                   # total_venta

                              global_discount_percentage FLOAT,
                              purchase_order VARCHAR(255),
                              vehicle_plate VARCHAR(255),
                              term VARCHAR(255),
                              percentage_plastic_bag_tax FLOAT,
                              percentage_igv FLOAT,

                              perception_code VARCHAR(2),     # JSON Array de percepciones
                              detraction TEXT,                # JSON Array de detracciones
                              related TEXT,                   # JSON Array de documentos relacionados
                              guide TEXT,                     # JSON Array de guia de referencia
                              legend TEXT,                    # JSON Array de leyendas // SAVE ONLY LEYEND CODES.

                              pdf_format VARCHAR(16),
                              itinerant_enable BOOLEAN,
                              itinerant_location VARCHAR(6),
                              itinerant_address varchar(255),
                              itinerant_urbanization varchar(255),

                              CONSTRAINT pk_invoice_note PRIMARY KEY (invoice_note_id),
                              CONSTRAINT uk_invoice_note UNIQUE (invoice_note_key),
                              INDEX (serie,correlative,local_id),
                              CONSTRAINT fk_invoice_note_currency_type_code FOREIGN KEY (currency_code) REFERENCES cat_currency_type_code (code)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT,
                              CONSTRAINT fk_invoice_note_operation_type_code FOREIGN KEY (operation_code) REFERENCES cat_operation_type_code (code)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT,
                              CONSTRAINT fk_invoice_note_document_type_code FOREIGN KEY (document_code) REFERENCES cat_document_type_code (code)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT,
                              CONSTRAINT fk_invoice_note_invoice FOREIGN KEY (invoice_id) REFERENCES invoice (invoice_id)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_note_item (
                                   invoice_note_item_id INT AUTO_INCREMENT NOT NULL,
                                   invoice_note_id INT NOT NULL,

                                   unit_measure VARCHAR(4) NOT NULL,
                                   product_code VARCHAR(255) NOT NULL,
                                   description VARCHAR(128) NOT NULL,
                                   quantity INT NOT NULL,
                                   unit_value FLOAT NOT NULL,
                                   unit_price FLOAT NOT NULL,

                                   discount FLOAT,
                                   charge FLOAT,

                                   affectation_code VARCHAR(8) NOT NULL,
                                   total_base_igv FLOAT,
                                   igv FLOAT, # Igv

                                   system_isc_code VARCHAR(2),
                                   total_base_isc FLOAT,
                                   tax_isc FLOAT,
                                   isc FLOAT,

                                   total_base_other_taxed FLOAT,
                                   percentage_other_taxed FLOAT,
                                   other_taxed FLOAT,

                                   quantity_plastic_bag FLOAT,
                                   plastic_bag_tax FLOAT,

                                   total_value FLOAT,
                                   total FLOAT,

                                   CONSTRAINT pk_invoice_note_item PRIMARY KEY (invoice_note_item_id),
                                   CONSTRAINT fk_invoice_note_item_invoice_note FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
                                       ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_note_sunat(
                                   invoice_note_sunat_id INT AUTO_INCREMENT NOT NULL,
                                   invoice_state_id SMALLINT,
                                   invoice_note_id INT NOT NULL,
                                   send BOOLEAN,
                                   response_code VARCHAR(6),
                                   response_message VARCHAR(255),
                                   other_message VARCHAR(255),
                                   pdf_url varchar(255),
                                   xml_url VARCHAR(255),
                                   cdr_url varchar(255),
                                   CONSTRAINT pk_invoice_note_sunat PRIMARY KEY (invoice_note_sunat_id),
                                   CONSTRAINT uk_invoice_note_sunat UNIQUE KEY (invoice_note_id),
                                   CONSTRAINT fk_invoice_note_sunat_invoice_state FOREIGN KEY (invoice_state_id) REFERENCES invoice_state (invoice_state_id)
                                       ON UPDATE RESTRICT ON DELETE RESTRICT,
                                   CONSTRAINT fk_invoice_note_sunat_invoice_note FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
                                       ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE invoice_note_customer(
                                      invoice_note_customer_id INT AUTO_INCREMENT NOT NULL,
                                      invoice_note_id INT NOT NULL,
                                      document_number VARCHAR(16) NOT NULL,
                                      identity_document_code VARCHAR(64) NOT NULL,
                                      social_reason VARCHAR(255),
                                      fiscal_address VARCHAR(255),
                                      email VARCHAR(64),
                                      telephone VARCHAR(255),
                                      sent_to_client BOOLEAN,
                                      CONSTRAINT pk_invoice_note_customer PRIMARY KEY (invoice_note_customer_id),
                                      CONSTRAINT fk_invoice_note_customer_identity_document_type_code FOREIGN KEY (identity_document_code) REFERENCES cat_identity_document_type_code (code)
                                          ON UPDATE RESTRICT ON DELETE RESTRICT,
                                      CONSTRAINT fk_invoice_note_customer_invoice FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
                                          ON UPDATE RESTRICT ON DELETE RESTRICT
);

CREATE TABLE invoice_note_referral_guide(
                                            invoice_note_referral_guide_id INT AUTO_INCREMENT NOT NULL,
                                            invoice_note_id INT NOT NULL,
                                            document_code VARCHAR(2) NOT NULL,
                                            whit_guide BOOLEAN,

                                            transfer_code VARCHAR(2),
                                            transport_code VARCHAR(2),
                                            transfer_start_date DATE,
                                            total_gross_weight FLOAT,

                                            carrier_document_code VARCHAR(1),
                                            carrier_document_number VARCHAR(24),
                                            carrier_denomination VARCHAR(255),
                                            carrier_plate_number VARCHAR(64),

                                            driver_document_code VARCHAR(1),
                                            driver_document_number VARCHAR(24),
                                            driver_full_name VARCHAR(255),

                                            location_starting_code VARCHAR(6),
                                            address_starting_point VARCHAR(128),

                                            location_arrival_code VARCHAR(6),
                                            address_arrival_point VARCHAR(128),
                                            CONSTRAINT pk_invoice_note_referral_guide PRIMARY KEY (invoice_note_referral_guide_id),
                                            CONSTRAINT uk_invoice_note_referral_guide UNIQUE KEY (invoice_note_id),
                                            CONSTRAINT fk_invoice_note_referral_guide_invoice_note FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
                                                ON UPDATE RESTRICT ON DELETE RESTRICT,
                                            CONSTRAINT fk_invoice_note_referral_guide_location_starting_code FOREIGN KEY (location_starting_code) REFERENCES cat_geographical_location_code (code)
                                                ON UPDATE RESTRICT ON DELETE RESTRICT,
                                            CONSTRAINT fk_invoice_note_referral_guide_location_arrival_code FOREIGN KEY (location_arrival_code) REFERENCES cat_geographical_location_code (code)
                                                ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_note_detraction(
                                        invoice_note_detraction_id BOOLEAN,
                                        invoice_note_id INT NOT NULL,
                                        detraction_code VARCHAR(3),
                                        percentage FLOAT,
                                        amount FLOAT,

                                        referral_value VARCHAR(1),
                                        effective_load VARCHAR(24),
                                        useful_load VARCHAR(255),
                                        travel_detail VARCHAR(255),
                                        location_starting_code VARCHAR(6),
                                        address_starting_point VARCHAR(128),
                                        location_arrival_code VARCHAR(6),
                                        address_arrival_point VARCHAR(128),

                                        boat_registration VARCHAR(32),
                                        boat_name VARCHAR(32),
                                        species_kind VARCHAR(32),
                                        delivery_address VARCHAR(64),
                                        delivery_date DATETIME,
                                        quantity FLOAT,

                                        CONSTRAINT pk_invoice_note_detraction PRIMARY KEY (invoice_note_detraction_id),
                                        CONSTRAINT uk_invoice_note_detraction UNIQUE KEY (invoice_note_id),
                                        CONSTRAINT fk_invoice_note_detraction_invoice_note FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
);

CREATE TABLE invoice_note_summary(
                                     invoice_note_summary_id INT AUTO_INCREMENT NOT NULL,
                                     invoice_note_summary_key varchar(32) NOT NULL,
                                     updated_at DATETIME,
                                     created_at DATETIME,
                                     created_user_id INT,
                                     updated_user_id INT,

                                     local_id INT,
                                     correlative INT,
                                     date_of_issue DATE NOT NULL,
                                     date_of_reference DATE NOT NULL,

                                     invoice_state_id SMALLINT,
                                     send BOOLEAN,
                                     ticket VARCHAR(64),
                                     response_code BOOLEAN,
                                     response_message VARCHAR(15),
                                     other_message TEXT,
                                     pdf_url varchar(255),
                                     xml_url VARCHAR(255),
                                     cdr_url varchar(255),
                                     CONSTRAINT pk_invoice_note_summary PRIMARY KEY (invoice_note_summary_id),
                                     CONSTRAINT uk_invoice_note_summary UNIQUE KEY (invoice_note_summary_key),
                                     CONSTRAINT fk_invoice_note_summary_invoice_state FOREIGN KEY (invoice_state_id) REFERENCES invoice_state (invoice_state_id)
                                         ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_note_summary_item(
                                          invoice_note_summary_item_id INT AUTO_INCREMENT NOT NULL,
                                          invoice_note_summary_id INT NOT NULL,
                                          invoice_note_id INT NOT NULL,
                                          local_id INT,

                                          date_of_issue DATE NOT NULL,
                                          date_of_reference DATE NOT NULL,
                                          summary_state_code ENUM('1','2','3') NOT NULL,

                                          sunat_state INT null,
                                          CONSTRAINT pk_invoice_note_summary_item PRIMARY KEY (invoice_note_summary_item_id),
                                          CONSTRAINT fk_invoice_note_summary_item_invoice_note_summary FOREIGN KEY (invoice_note_summary_id) REFERENCES invoice_note_summary (invoice_note_summary_id)
                                              ON UPDATE RESTRICT ON DELETE RESTRICT,
                                          CONSTRAINT fk_invoice_note_summary_item_invoice_note FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
                                              ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE invoice_note_voided(
                                    invoice_note_voided_id INT AUTO_INCREMENT NOT NULL,
                                    updated_at DATETIME,
                                    created_at DATETIME,
                                    created_user_id INT,
                                    updated_user_id INT,

                                    local_id INT,
                                    invoice_note_id INT NOT NULL,
                                    reason VARCHAR(255),

                                    correlative INT,
                                    date_of_issue DATE NOT NULL,
                                    date_of_reference DATE NOT NULL,

                                    invoice_state_id SMALLINT,
                                    send BOOLEAN,
                                    ticket VARCHAR(64),
                                    response_code BOOLEAN,
                                    response_message VARCHAR(15),
                                    other_message TEXT,
                                    pdf_url varchar(255),
                                    xml_url VARCHAR(255),
                                    cdr_url varchar(255),

                                    CONSTRAINT pk_invoice_note_voided PRIMARY KEY (invoice_note_voided_id),
                                    CONSTRAINT uk_invoice_note_voided UNIQUE (invoice_note_id),
                                    CONSTRAINT fk_invoice_note_voided_invoice FOREIGN KEY (invoice_note_id) REFERENCES invoice_note (invoice_note_id)
                                        ON UPDATE RESTRICT ON DELETE RESTRICT,
                                    CONSTRAINT fk_invoice_note_voided_invoice_state FOREIGN KEY (invoice_state_id) REFERENCES invoice_state (invoice_state_id)
                                        ON UPDATE RESTRICT ON DELETE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE referral_guide(
                               referral_guide_id INT AUTO_INCREMENT NOT NULL,
                               referral_guide_key varchar(32) NOT NULL,
                               updated_at DATETIME,
                               created_at DATETIME,
                               created_user_id INT,
                               updated_user_id INT,

                               local_id INT,
                               customer_id INT NOT NULL,

                               document_code VARCHAR(2) NOT NULL,
                               serie VARCHAR(64),
                               correlative INT NOT NULL,
                               date_of_issue DATE NOT NULL,
                               time_of_issue TIME NOT NULL,

                               transfer_code VARCHAR(2),
                               transport_code VARCHAR(2),
                               transfer_start_date DATE,
                               total_gross_weight FLOAT,
                               number_packages FLOAT,

                               carrier_document_code VARCHAR(1),
                               carrier_document_number VARCHAR(24),
                               carrier_denomination VARCHAR(255),
                               carrier_plate_number VARCHAR(64),

                               driver_document_code VARCHAR(1),
                               driver_document_number VARCHAR(24),
                               driver_full_name VARCHAR(255),

                               location_starting_code VARCHAR(6),
                               address_starting_point VARCHAR(128),

                               location_arrival_code VARCHAR(6),
                               address_arrival_point VARCHAR(128),

                               observations VARCHAR(255),

                               pdf_format VARCHAR(16),         # Se se puede quitar
                               pdf_url varchar(255),
                               xml_url VARCHAR(255),
                               cdr_url varchar(255),
                               sunat_state SMALLINT,
                               sunat_error_message VARCHAR(255),
                               CONSTRAINT pk_referral_guide PRIMARY KEY (referral_guide_id),
                               CONSTRAINT uk_referral_guide UNIQUE KEY (referral_guide_key),
                               INDEX ix_invoice_indexes (serie,correlative,local_id),
                               CONSTRAINT fk_referral_guide_customer FOREIGN KEY (customer_id) REFERENCES customer (customer_id)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT,
                               CONSTRAINT fk_referral_guide_location_starting_code FOREIGN KEY (location_starting_code) REFERENCES cat_geographical_location_code (code)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT,
                               CONSTRAINT fk_referral_guide_location_arrival_code FOREIGN KEY (location_arrival_code) REFERENCES cat_geographical_location_code (code)
                                   ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE referral_guide_item(
                                    referral_guide_item_id INT AUTO_INCREMENT NOT NULL,
                                    quantity FLOAT NOT NULL,
                                    description VARCHAR(128),
                                    product_code VARCHAR(255),
                                    unit_measure VARCHAR(4),
                                    referral_guide_id INT NOT NULL,
                                    CONSTRAINT pk_referral_guide_item_guide PRIMARY KEY (referral_guide_item_id),
                                    CONSTRAINT fk_referral_guide_item_guide_referral_guide FOREIGN KEY (referral_guide_id) REFERENCES referral_guide (referral_guide_id)
                                        ON UPDATE RESTRICT ON DELETE RESTRICT
)ENGINE = InnoDB;

CREATE TABLE api_request(
                            api_request_id INT AUTO_INCREMENT NOT NULL,
                            updated_at DATETIME,
                            created_at DATETIME,
                            creation_user_id INT,
                            modification_user_id INT,

                            origin_ip VARCHAR(32),
                            document varchar(64) NOT NULL,
                            description varchar(255),
                            local_id INT,

                            CONSTRAINT pk_api_request_guide PRIMARY KEY (api_request_id)
);

-- -----------------------------------------------------------------------------------------------------------------
-- -----------------------------------------------------------------------------------------------------------------
-- TRIGGER
-- invoice_correlative_bi_before
DROP TRIGGER IF EXISTS invoice_correlative_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_correlative_bi_before BEFORE INSERT ON invoice FOR EACH ROW
BEGIN
    UPDATE business_serie SET max_correlative = NEW.correlative
    WHERE business_local_id = NEW.local_id
      AND document_code = NEW.document_code
      AND serie = NEW.serie;
END$$
DELIMITER ;

-- invoice_note_correlative_bi_before
DROP TRIGGER IF EXISTS invoice_note_correlative_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_note_correlative_bi_before BEFORE INSERT ON invoice_note FOR EACH ROW
BEGIN
    UPDATE business_serie SET max_correlative = NEW.correlative
    WHERE business_local_id = NEW.local_id
      AND document_code = NEW.document_code
      AND serie = NEW.serie;
END$$
DELIMITER ;

-- invoice_referral_guide_bi_before
DROP TRIGGER IF EXISTS invoice_referral_guide_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_referral_guide_bi_before BEFORE INSERT ON referral_guide FOR EACH ROW
BEGIN
    UPDATE business_serie SET max_correlative = NEW.correlative
    WHERE business_local_id = NEW.local_id
      AND document_code = NEW.document_code
      AND serie = NEW.serie;
END$$
DELIMITER ;

-- ticket_summary_bi_before
DROP TRIGGER IF EXISTS invoice_summary_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_summary_bi_before BEFORE INSERT ON invoice_summary FOR EACH ROW
BEGIN
    DECLARE maxCorrelative INT;
    SET maxCorrelative = 0;
    SELECT max_correlative INTO maxCorrelative FROM business_serie WHERE business_local_id = NEW.local_id AND document_code = '03' AND serie = 'SSUM' LIMIT 1;

    if(maxCorrelative = 0) THEN
        SET maxCorrelative = 1;
        INSERT INTO business_serie (business_local_id, serie, document_code, max_correlative, hidden)
        VALUES (NEW.local_id,'SSUM','03', maxCorrelative, true);
    ELSE
        SET maxCorrelative = maxCorrelative + 1;
        UPDATE business_serie SET max_correlative = maxCorrelative WHERE business_local_id = NEW.local_id AND document_code = '03' AND serie = 'SSUM';
    END IF;

    SET NEW.correlative = maxCorrelative;
END$$
DELIMITER ;

-- invoice_note_summary_bi_before
DROP TRIGGER IF EXISTS invoice_note_summary_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_note_summary_bi_before BEFORE INSERT ON invoice_note_summary FOR EACH ROW
BEGIN
    DECLARE maxCorrelative INT;
    SET maxCorrelative = 0;
    SELECT max_correlative INTO maxCorrelative FROM business_serie WHERE business_local_id = NEW.local_id AND document_code = '03' AND serie = 'SNUM' LIMIT 1;

    if(maxCorrelative = 0) THEN
        SET maxCorrelative = 1;
        INSERT INTO business_serie (business_local_id, serie, document_code, max_correlative, hidden)
        VALUES (NEW.local_id,'SNUM','03', maxCorrelative, true);
    ELSE
        SET maxCorrelative = maxCorrelative + 1;
        UPDATE business_serie SET max_correlative = maxCorrelative WHERE business_local_id = NEW.local_id AND document_code = '03' AND serie = 'SNUM';
    END IF;

    SET NEW.correlative = maxCorrelative;
END$$
DELIMITER ;

-- invoice_voided_bi_before
DROP TRIGGER IF EXISTS invoice_voided_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_voided_bi_before BEFORE INSERT ON invoice_voided FOR EACH ROW
BEGIN
    DECLARE maxCorrelative INT;
    SET maxCorrelative = 0;
    SELECT max_correlative INTO maxCorrelative FROM business_serie WHERE business_local_id = NEW.local_id AND document_code = '01' AND serie = 'SARA' LIMIT 1;

    if(maxCorrelative = 0) THEN
        SET maxCorrelative = 1;
        INSERT INTO business_serie (business_local_id, serie, document_code, max_correlative, hidden)
        VALUES (NEW.local_id,'SARA','01', maxCorrelative, true);
    ELSE
        SET maxCorrelative = maxCorrelative + 1;
        UPDATE business_serie SET max_correlative = maxCorrelative WHERE business_local_id = NEW.local_id AND document_code = '01' AND serie = 'SARA';
    END IF;

    SET NEW.correlative = maxCorrelative;
END$$
DELIMITER ;

-- invoice_voided_bi_before
DROP TRIGGER IF EXISTS invoice_note_voided_bi_before;
DELIMITER $$
CREATE TRIGGER invoice_note_voided_bi_before BEFORE INSERT ON invoice_note_voided FOR EACH ROW
BEGIN
    DECLARE maxCorrelative INT;
    SET maxCorrelative = 0;
    SELECT max_correlative INTO maxCorrelative FROM business_serie WHERE business_local_id = NEW.local_id AND document_code = '01' AND serie = 'SNRA' LIMIT 1;

    if(maxCorrelative = 0) THEN
        SET maxCorrelative = 1;
        INSERT INTO business_serie (business_local_id, serie, document_code, max_correlative, hidden)
        VALUES (NEW.local_id,'SNRA','01', maxCorrelative,true);
    ELSE
        SET maxCorrelative = maxCorrelative + 1;
        UPDATE business_serie SET max_correlative = maxCorrelative WHERE business_local_id = NEW.local_id AND document_code = '01' AND serie = 'SNRA';
    END IF;

    SET NEW.correlative = maxCorrelative;
END$$
DELIMITER ;

-- -----------------------------------------------------------------------------------------------------------------
-- -----------------------------------------------------------------------------------------------------------------
-- INSERT SUNAT DATA

# Catalogue 1
INSERT INTO cat_document_type_code(code, description)VALUES
('01', 'FACTURA'),
('03', 'BOLETA DE VENTA'),
('07', 'NOTA DE CREDITO'),
('08', 'NOTA DE DEBITO'),
('09', 'GUIA DE REMISIÓN REMITENTE');

# Catalogue 2
INSERT INTO cat_currency_type_code(code, description, entity, symbol)VALUES
('PEN','SOLES','PERU','S/'),
('EUR','EURO','','€'),
('JPY','YEN','JAPON','¥'),
('USD','DÓLARES AMERICANOS','AMERICAN SAMOA','$');

# Catalogue 3
INSERT INTO cat_unit_measure_type_code(code, description, extend)VALUES
('4A','BOBINAS',false),
('BJ','BALDE',false),
('BLL','BARRILES',false),
('BG','BOLSA',false),
('BO','BOTELLAS',false),
('BX','CAJA',false),
('CT','CARTONES',false),
('CMK','CENTIMETROCUADRADO',false),
('CMQ','CENTIMETROCUBICO',false),
('CMT','CENTIMETROLINEAL',false),
('CEN','CIENTODEUNIDADES',false),
('CY','CILINDRO',false),
('CJ','CONOS',false),
('DZN','DOCENA',false),
('DZP','DOCENAPOR10**6',false),
('BE','FARDO',false),
('GLI','GALONINGLES(4,545956L)',false),
('GRM','GRAMO',false),
('GRO','GRUESA',false),
('HLT','HECTOLITRO',false),
('LEF','HOJA',false),
('SET','JUEGO',false),
('KGM','KILOGRAMO',false),
('KTM','KILOMETRO',false),
('KWH','KILOVATIOHORA',false),
('KT','KIT',false),
('CA','LATAS',false),
('LBR','LIBRAS',false),
('LTR','LITRO',false),
('MWH','MEGAWATTHORA',false),
('MTR','METRO',false),
('MTK','METROCUADRADO',false),
('MTQ','METROCUBICO',false),
('MGM','MILIGRAMOS',false),
('MLT','MILILITRO',false),
('MMT','MILIMETRO',false),
('MMK','MILIMETROCUADRADO',false),
('MMQ','MILIMETROCUBICO',false),
('MLL','MILLARES',false),
('UM','MILLONDEUNIDADES',false),
('ONZ','ONZAS',false),
('PF','PALETAS',false),
('PK','PAQUETE',false),
('PR','PAR',false),
('FOT','PIES',false),
('FTK','PIESCUADRADOS',false),
('FTQ','PIESCUBICOS',false),
('C62','PIEZAS',false),
('PG','PLACAS',false),
('ST','PLIEGO',false),
('INH','PULGADAS',false),
('RM','RESMA',false),
('DR','TAMBOR',false),
('STN','TONELADACORTA',false),
('LTN','TONELADALARGA',false),
('TNE','TONELADAS',false),
('TU','TUBOS',false),
('NIU','UNIDAD(BIENES)',false),
('ZZ','UNIDAD(SERVICIOS)',false),
('GLL','USGALON(3,7843L)',false),
('YRD','YARDA',false),
('YDK','YARDACUADRADA',false);

# Catalogue 4
# Catalogue 5
INSERT INTO cat_tribute_type_code(code, description, international_code, name)VALUES
('1000','IGV Impuesto General a las Ventas','VAT','IGV'),
('1016','Impuesto a la Venta Arroz Pilado','VAT','IVAP'),
('2000','ISC Impuesto Selectivo al Consumo','EXC','ISC'),
('7152','Impuesto a la bolsa plastica','OTH','ICBPER'),
('9995','Exportación','FRE','EXP'),
('9996','Gratuito','FRE','GRA'),
('9997','Exonerado','VAT','EXO'),
('9998','Inafecto','FRE','INA'),
('9999','Otros tributos','OTH','OTROS');

# Catalogue 6
INSERT INTO cat_identity_document_type_code(code, description)VALUES
('0', '0 NO DOMICILIADO, SIN RUC (EXPORTACIÓN)'),
('1', '1 DNI - DOC. NACIONAL DE IDENTIDAD'),
('4', '4 CARNET DE EXTRANJERIA'),
('6', '6 RUC - REG. UNICO DE CONTRIBUYENTES'),
('7', '7 PASAPORTE'),
('A', 'A CED. DIPLOMATICA DE IDENTIDAD'),
('B', 'B DOC.IDENT.PAIS.RESIDENCIA-NO.D'),
('C', 'C Tax Identification Number - TIN – Doc Trib PP.NN'),
('D', 'D Identification Number - IN – Doc Trib PP. JJ'),
('-','- VARIOS - VENTAS MENORES A S/.700.00 Y OTROS');

# Catalogue 7
INSERT INTO cat_affectation_igv_type_code(description, code, tribute_code, onerous)VALUES
('Gravado - Operación Onerosa','10','1000', 1),
('[Gratuita] Gravado – Retiro por premio','11','9996', 2),
('[Gratuita] Gravado – Retiro por donación','12','9996', 2),
('[Gratuita] Gravado – Retiro','13','9996', 2),
('[Gratuita] Gravado – Retiro por publicidad','14','9996', 2),
('[Gratuita] Gravado – Bonificaciones','15','9996', 2),
('[Gratuita] Gravado – Retiro por entrega a trabajadores','16','9996', 2),
('Exonerado - Operación Onerosa','20','9997', 1),
('Inafecto - Operación Onerosa','30','9998', 1),
('[Gratuita] Inafecto – Retiro por Bonificación','31','9996', 2),
('[Gratuita] Inafecto – Retiro','32','9996', 2),
('[Gratuita] Inafecto – Retiro por Muestras Médicas','33','9996', 2),
('[Gratuita] Inafecto - Retiro por Convenio Colectivo','34','9996', 2),
('[Gratuita] Inafecto – Retiro por premio','35','9996', 2),
('[Gratuita] Inafecto - Retiro por publicidad','36','9996', 2),
('Exportación','40','9995', 1);

# Catalogue 8
INSERT INTO cat_system_isc_type_code(code, description)VALUES
('01','Sistema al valor (Apéndice IV, lit. A – T.U.O IGV e ISC)'),
('02','Aplicación del Monto Fijo ( Sistema específico, bienes en el apéndice III, Apéndice IV, lit. B – T.U.O IGV e ISC)'),
('03','Sistema de Precios de Venta al Público (Apéndice IV, lit. C – T.U.O IGV e ISC)');

# Catalogue 9
INSERT INTO cat_credit_note_type_code(code, description)VALUES
('01', 'Anulación de la operación'),
('02', 'Anulación por error en el RUC'),
('03', 'Corrección por error en la descripción'),
('04', 'Descuento global'),
('05', 'Descuento por ítem'),
('06', 'Devolución total'),
('07', 'Devolución por ítem'),
('08', 'Bonificación'),
('09', 'Disminución en el valor'),
('10', 'Otros Conceptos ');

# Catalogue 10
INSERT INTO cat_debit_note_type_code(code, description)VALUES
('01','Intereses por mora'),
('02','Aumento en el valor'),
('03','Penalidades/ otros conceptos');

# Catalogue 15
INSERT INTO cat_additional_legend_code(code, description)VALUES
('1000','Monto en Letras'),
('1002','Leyenda "TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE"'),
('2000','Leyenda “COMPROBANTE DE PERCEPCIÓN”'),
('2001','Leyenda “BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVAPARA SER CONSUMIDOS EN LA MISMA"'),
('2002','Leyenda “SERVICIOS PRESTADOS EN LA AMAZONÍA  REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA”'),
('2003','Leyenda “CONTRATOS DE CONSTRUCCIÓN EJECUTADOS  EN LA AMAZONÍA REGIÓN SELVA”'),
('2004','Leyenda “Agencia de Viaje - Paquete turístico”'),
('2005','Leyenda “Venta realizada por emisor itinerante”'),
('2006','Leyenda: Operación sujeta a detracción'),
('2007','Leyenda: Operación sujeta a IVAP'),
('3000','Detracciones: CODIGO DE BB Y SS SUJETOS A DETRACCION'),
('3001','Detracciones: NUMERO DE CTA EN EL BN'),
('3002','Detracciones: Recursos Hidrobiológicos-Nombre y matrícula de la embarcación'),
('3003','Detracciones: Recursos Hidrobiológicos-Tipo y cantidad de especie vendida'),
('3004','Detracciones: Recursos Hidrobiológicos -Lugar de descarga'),
('3005','Detracciones: Recursos Hidrobiológicos -Fecha de descarga'),
('3006','Detracciones: Transporte Bienes vía terrestre – Numero Registro MTC'),
('3007','Detracciones: Transporte Bienes vía terrestre – configuración vehicular'),
('3008','Detracciones: Transporte Bienes vía terrestre – punto de origen'),
('3009','Detracciones: Transporte Bienes vía terrestre – punto destino'),
('3010','Detracciones: Transporte Bienes vía terrestre – valor referencial preliminar'),
('4000','Beneficio hospedajes: Código País de emisión del pasaporte'),
('4001','Beneficio hospedajes: Código País de residencia del sujeto no domiciliado'),
('4002','Beneficio Hospedajes: Fecha de ingreso al país'),
('4003','Beneficio Hospedajes: Fecha de ingreso al establecimiento'),
('4004','Beneficio Hospedajes: Fecha de salida del establecimiento'),
('4005','Beneficio Hospedajes: Número de días de permanencia'),
('4006','Beneficio Hospedajes: Fecha de consumo'),
('4007','Beneficio Hospedajes: Paquete turístico - Nombres y Apellidos del Huésped'),
('4008','Beneficio Hospedajes: Paquete turístico – Tipo documento identidad del huésped'),
('4009','Beneficio Hospedajes: Paquete turístico – Numero de documento identidad de huésped'),
('5000','Proveedores Estado: Número de Expediente'),
('5001','Proveedores Estado : Código de unidad ejecutora'),
('5002','Proveedores Estado : N° de proceso de selección'),
('5003','Proveedores Estado : N° de contrato'),
('6000','Comercialización de Oro :  Código Unico Concesión Minera'),
('6001','Comercialización de Oro :  N° declaración compromiso'),
('6002','Comercialización de Oro :  N° Reg. Especial .Comerci. Oro'),
('6003','Comercialización de Oro :  N° Resolución que autoriza Planta de Beneficio'),
('6004','Comercialización de Oro : Ley Mineral (% concent. oro)'),
('7000','Primera venta de mercancia identificable entre usuarios de la zona comercial'),
('7001','Venta exonerada del IGV-ISC-IPM. Prohibida la venta fuera de la zona comercial de Tacna');

# Catalogue 17
INSERT INTO cat_operation_type_code(code,description)VALUES
('0101', 'Venta lnterna'),
#     ('0104', 'Venta Interna – Anticipos'), # Falta verificar la valides en UBL 2.1
('0200', 'Exportación de Bienes'),
('0401', 'Ventas no domiciliados que no califican como exportación'),
('1001', 'Operación Sujeta a Detracción'),
('2001', 'Operación Sujeta a Percepción'),
('1004', 'Operación Sujeta a Detracción- Servicios de Transporte Carga');

# Catalogue 18
INSERT INTO cat_transport_mode_code(code, description)VALUES
('01','Transporte público'),
('02','Transporte privado');

# Catalogue 19
INSERT INTO cat_summary_state_code(code, description)VALUES
('1','Adicionar'),
('2','Modificar'),
('3','Anulado');

# Catalogue 20
INSERT INTO cat_transfer_reason_code (code, description) VALUES
('01', 'Venta'),
('02', 'Compra'),
('04', 'Traslado entre establecimientos de la misma empresa'),
('08', 'Importación'),
('09', 'Exportación'),
('13', 'Otros'),
('14', 'Venta sujeta a confirmación del comprador'),
('18', 'Traslado emisor itinerante CP'),
('19', 'Traslado a zona primaria');

INSERT INTO cat_perception_type_code (code, description, percentage) VALUES
('01','Percepción Venta Interna', 2),
('02','Percepción a la adquisición de combustible', 1),
('03','Percepción realizada al agente de percepción con tasa especial',	0.5);

INSERT INTO invoice_state (state) VALUES
('Pendiente de Envío'),
('Guardado'),
('Aceptado'),
('Comunicación de Baja (Anulado)');

# Catalogue 54
INSERT INTO cat_subject_detraction_code (code, description) VALUES
('001', 'Azúcar y melaza de caña'),
('002', 'Arroz'),
('003', 'Alcohol etílico'),
('004', 'Recursos hidrobiológicos'),
('005', 'Maíz amarillo duro'),
('007', 'Caña de azúcar'),
('008', 'Madera'),
('009', 'Arena y piedra.'),
('010', 'Residuos, subproductos, desechos, recortes y desperdicios'),
('011', 'Bienes gravados con el IGV, o renuncia a la exoneración'),
('012', 'Intermediación laboral y tercerización'),
('013', 'Animales vivos'),
('014', 'Carnes y despojos comestibles'),
('015', 'Abonos, cueros y pieles de origen animal'),
('016', 'Aceite de pescado'),
('017', 'Harina, polvo y “pellets” de pescado, crustáceos, moluscos y demás invertebrados acuáticos'),
('019', 'Arrendamiento de bienes muebles'),
('020', 'Mantenimiento y reparación de bienes muebles'),
('021', 'Movimiento de carga'),
('022', 'Otros servicios empresariales'),
('023', 'Leche'),
('024', 'Comisión mercantil'),
('025', 'Fabricación de bienes por encargo'),
('026', 'Servicio de transporte de personas'),
('027', 'Servicio de transporte de carga'),
('028', 'Transporte de pasajeros'),
('030', 'Contratos de construcción'),
('031', 'Oro gravado con el IGV'),
('032', 'Paprika y otros frutos de los generos capsicum o pimienta'),
('034', 'Minerales metálicos no auríferos'),
('035', 'Bienes exonerados del IGV'),
('036', 'Oro y demás minerales metálicos exonerados del IGV'),
('037', 'Demás servicios gravados con el IGV'),
('039', 'Minerales no metálicos'),
('040', 'Bien inmueble gravado con IGV'),
('041', 'Plomo'),
('099', 'Ley 30737');

-- DATA XML
DROP TABLE IF EXISTS `sunat_summary_response`;

CREATE TABLE `sunat_summary_response` (
                                          `sunat_summary_response_id` int(11) NOT NULL AUTO_INCREMENT,
                                          `sunat_communication_id` int(11) NOT NULL,
                                          `sunat_communication_success` tinyint(1) NOT NULL,
                                          `ticket` varchar(500) NOT NULL,
                                          `response_code` varchar(3) NOT NULL DEFAULT '-',
                                          `enabled` tinyint(1) NOT NULL,
                                          `creation_date` datetime NOT NULL,
                                          `creation_user_id` int(11) NOT NULL,
                                          `modification_user_id` int(11) NOT NULL,
                                          `modification_date` datetime NOT NULL,
                                          `observation` varchar(500) NOT NULL DEFAULT '',
                                          PRIMARY KEY (`sunat_summary_response_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- DATOS ADICIONALES
INSERT INTO roles (name, description)
VALUES ('cliente','Cliente final que emite los comprobantes electrónicos');

INSERT INTO users(id_rol, names, email, phone, ruc, address, id_document_type, password, state) VALUES
(1,'cliente','cliente@gmail.com','999999999','20553476462','','','34e422278ea745b5d87ba6592f0ea3fe32a2eb7593f5960ac72d7094fb121f3d',1);

INSERT INTO business(include_igv, continue_payment, total_calculation_item, send_email_company, ruc, social_reason, commercial_reason, email, phone, web_site, logo)
VALUES (true,false,'amount','abc@gmail.com','99999999999','abc company','abc','abc@gmail.com','966254123','abc.com','');

INSERT INTO business_user (business_id, user_id) VALUES (1,3);

INSERT INTO business_local(updated_at, created_at, created_user_id, updated_user_id, short_name, sunat_code, location_code, department, province, district, address, pdf_invoice_size, pdf_header, description, business_id)
VALUES (now(),now(),1,1,'Local principal','','080800','cusco','cusco','cusco','','A4','','',1);

INSERT INTO business_serie(updated_at, delete_at, business_local_id, serie, document_code, max_correlative, contingency)
VALUES (now(),null,1,'F001','01',0,false),
       (now(),null,1,'B001','03',0,false),
       (now(),null,1,'FP01','07',0,false),
       (now(),null,1,'FP01','08',0,false),
       (now(),null,1,'T001','09',0,false);
