-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-09-2019 a las 17:00:05
-- Versión del servidor: 10.1.40-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ose`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `additional_legend_code`
--

CREATE TABLE `additional_legend_code` (
  `code` varchar(4) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `additional_legend_code`
--

INSERT INTO `additional_legend_code` (`code`, `description`) VALUES
('1000', 'Monto en Letras'),
('1002', 'Leyenda \"TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE\"'),
('2000', 'Leyenda “COMPROBANTE DE PERCEPCIÓN”'),
('2001', 'Leyenda “BIENES TRANSFERIDOS EN LA AMAZONÍA REGIÓN SELVAPARA SER CONSUMIDOS EN LA MISMA\"'),
('2002', 'Leyenda “SERVICIOS PRESTADOS EN LA AMAZONÍA  REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA”'),
('2003', 'Leyenda “CONTRATOS DE CONSTRUCCIÓN EJECUTADOS  EN LA AMAZONÍA REGIÓN SELVA”'),
('2004', 'Leyenda “Agencia de Viaje - Paquete turístico”'),
('2005', 'Leyenda “Venta realizada por emisor itinerante”'),
('2006', 'Leyenda: Operación sujeta a detracción'),
('2007', 'Leyenda: Operación sujeta a IVAP'),
('3000', 'Detracciones: CODIGO DE BB Y SS SUJETOS A DETRACCION'),
('3001', 'Detracciones: NUMERO DE CTA EN EL BN'),
('3002', 'Detracciones: Recursos Hidrobiológicos-Nombre y matrícula de la embarcación'),
('3003', 'Detracciones: Recursos Hidrobiológicos-Tipo y cantidad de especie vendida'),
('3004', 'Detracciones: Recursos Hidrobiológicos -Lugar de descarga'),
('3005', 'Detracciones: Recursos Hidrobiológicos -Fecha de descarga'),
('3006', 'Detracciones: Transporte Bienes vía terrestre – Numero Registro MTC'),
('3007', 'Detracciones: Transporte Bienes vía terrestre – configuración vehicular'),
('3008', 'Detracciones: Transporte Bienes vía terrestre – punto de origen'),
('3009', 'Detracciones: Transporte Bienes vía terrestre – punto destino'),
('3010', 'Detracciones: Transporte Bienes vía terrestre – valor referencial preliminar'),
('4000', 'Beneficio hospedajes: Código País de emisión del pasaporte'),
('4001', 'Beneficio hospedajes: Código País de residencia del sujeto no domiciliado'),
('4002', 'Beneficio Hospedajes: Fecha de ingreso al país'),
('4003', 'Beneficio Hospedajes: Fecha de ingreso al establecimiento'),
('4004', 'Beneficio Hospedajes: Fecha de salida del establecimiento'),
('4005', 'Beneficio Hospedajes: Número de días de permanencia'),
('4006', 'Beneficio Hospedajes: Fecha de consumo'),
('4007', 'Beneficio Hospedajes: Paquete turístico - Nombres y Apellidos del Huésped'),
('4008', 'Beneficio Hospedajes: Paquete turístico – Tipo documento identidad del huésped'),
('4009', 'Beneficio Hospedajes: Paquete turístico – Numero de documento identidad de huésped'),
('5000', 'Proveedores Estado: Número de Expediente'),
('5001', 'Proveedores Estado : Código de unidad ejecutora'),
('5002', 'Proveedores Estado : N° de proceso de selección'),
('5003', 'Proveedores Estado : N° de contrato'),
('6000', 'Comercialización de Oro :  Código Unico Concesión Minera'),
('6001', 'Comercialización de Oro :  N° declaración compromiso'),
('6002', 'Comercialización de Oro :  N° Reg. Especial .Comerci. Oro'),
('6003', 'Comercialización de Oro :  N° Resolución que autoriza Planta de Beneficio'),
('6004', 'Comercialización de Oro : Ley Mineral (% concent. oro)'),
('7000', 'Primera venta de mercancia identificable entre usuarios de la zona comercial'),
('7001', 'Venta exonerada del IGV-ISC-IPM. Prohibida la venta fuera de la zona comercial de Tacna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `affectation_igv_type_code`
--

CREATE TABLE `affectation_igv_type_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `tribute_code` varchar(4) DEFAULT NULL,
  `onerous` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `affectation_igv_type_code`
--

INSERT INTO `affectation_igv_type_code` (`code`, `description`, `tribute_code`, `onerous`) VALUES
('10', 'Gravado - Operación Onerosa', '1000', 1),
('11', '[Gratuita] Gravado – Retiro por premio', '9996', 2),
('12', '[Gratuita] Gravado – Retiro por donación', '9996', 2),
('13', '[Gratuita] Gravado – Retiro', '9996', 2),
('14', '[Gratuita] Gravado – Retiro por publicidad', '9996', 2),
('15', '[Gratuita] Gravado – Bonificaciones', '9996', 2),
('16', '[Gratuita] Gravado – Retiro por entrega a trabajadores', '9996', 2),
('20', 'Exonerado - Operación Onerosa', '9997', 1),
('30', 'Inafecto - Operación Onerosa', '9998', 1),
('31', '[Gratuita] Inafecto – Retiro por Bonificación', '9996', 2),
('32', '[Gratuita] Inafecto – Retiro', '9996', 2),
('33', '[Gratuita] Inafecto – Retiro por Muestras Médicas', '9996', 2),
('34', '[Gratuita] Inafecto - Retiro por Convenio Colectivo', '9996', 2),
('35', '[Gratuita] Inafecto – Retiro por premio', '9996', 2),
('36', '[Gratuita] Inafecto - Retiro por publicidad', '9996', 2),
('40', 'Exportación', '9995', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business`
--

CREATE TABLE `business` (
  `business_id` int(11) NOT NULL,
  `include_igv` tinyint(1) DEFAULT NULL,
  `continue_payment` tinyint(1) DEFAULT NULL,
  `total_calculation_item` enum('unit_price','amount') DEFAULT NULL,
  `send_email_company` tinyint(1) DEFAULT NULL,
  `ruc` varchar(32) DEFAULT NULL,
  `social_reason` varchar(255) DEFAULT NULL,
  `commercial_reason` varchar(255) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `web_site` varchar(64) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business`
--

INSERT INTO `business` (`business_id`, `include_igv`, `continue_payment`, `total_calculation_item`, `send_email_company`, `ruc`, `social_reason`, `commercial_reason`, `email`, `phone`, `web_site`, `logo`) VALUES
(1, 1, 0, 'amount', 0, '20490086278', 'ABC Company', 'abc company', 'abc@gmail.com', '977898402', 'abc.com', '../Assets/Images/L-20490086278-1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business_user`
--

CREATE TABLE `business_user` (
  `business_user_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `business_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `business_user`
--

INSERT INTO `business_user` (`business_user_id`, `updated_at`, `created_at`, `creation_user_id`, `modification_user_id`, `business_id`, `user_id`) VALUES
(1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credit_note_type_code`
--

CREATE TABLE `credit_note_type_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `credit_note_type_code`
--

INSERT INTO `credit_note_type_code` (`code`, `description`) VALUES
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `currency_type_code`
--

CREATE TABLE `currency_type_code` (
  `code` varchar(6) NOT NULL,
  `description` varchar(255) NOT NULL,
  `entity` varchar(510) DEFAULT NULL,
  `symbol` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `currency_type_code`
--

INSERT INTO `currency_type_code` (`code`, `description`, `entity`, `symbol`) VALUES
('PEN', 'SOLES (S/)', 'PERU', 'S/'),
('USD', 'DÓLARES AMERICANOS ($)', 'AMERICAN SAMOA', '$');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `document_number` varchar(16) NOT NULL,
  `identity_document_code` varchar(64) NOT NULL,
  `social_reason` varchar(255) DEFAULT NULL,
  `commercial_reason` varchar(255) DEFAULT NULL,
  `fiscal_address` varchar(255) DEFAULT NULL,
  `main_email` varchar(64) DEFAULT NULL,
  `optional_email_1` varchar(64) DEFAULT NULL,
  `optional_email_2` varchar(64) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`customer_id`, `updated_at`, `created_at`, `creation_user_id`, `modification_user_id`, `user_id`, `document_number`, `identity_document_code`, `social_reason`, `commercial_reason`, `fiscal_address`, `main_email`, `optional_email_1`, `optional_email_2`, `telephone`) VALUES
(1, '2019-09-24 09:55:43', '2019-09-24 09:55:43', 3, 3, 3, '73975755', '1', 'ANTEZANA YANA PAUL YOEL', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `debit_note_type_code`
--

CREATE TABLE `debit_note_type_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `debit_note_type_code`
--

INSERT INTO `debit_note_type_code` (`code`, `description`) VALUES
('01', 'Intereses por mora'),
('02', 'Aumento en el valor'),
('03', 'Penalidades/ otros conceptos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_referral_guide`
--

CREATE TABLE `detail_referral_guide` (
  `detail_referral_guide_id` int(11) NOT NULL,
  `detail` varchar(128) DEFAULT NULL,
  `quantity` float NOT NULL,
  `product_id` int(11) NOT NULL,
  `referral_guide_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_sale`
--

CREATE TABLE `detail_sale` (
  `detail_sale_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_value` float NOT NULL,
  `unit_price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `affectation_code` varchar(8) NOT NULL,
  `total_base_igv` float DEFAULT NULL,
  `percentage_igv` float DEFAULT NULL,
  `igv` float DEFAULT NULL,
  `system_isc_code` varchar(2) DEFAULT NULL,
  `total_base_isc` float DEFAULT NULL,
  `tax_isc` float DEFAULT NULL,
  `isc` float DEFAULT NULL,
  `total_base_other_taxed` float DEFAULT NULL,
  `percentage_other_taxed` float DEFAULT NULL,
  `total_other_taxed` float DEFAULT NULL,
  `quantity_plastic_bag` float DEFAULT NULL,
  `plastic_bag_tax` float DEFAULT NULL,
  `total_taxed` float DEFAULT NULL,
  `total_value` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_sale_note`
--

CREATE TABLE `detail_sale_note` (
  `detail_sale_note_id` int(11) NOT NULL,
  `sale_note_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_value` float NOT NULL,
  `unit_price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `affectation_code` varchar(8) NOT NULL,
  `total_base_igv` float DEFAULT NULL,
  `percentage_igv` float DEFAULT NULL,
  `igv` float DEFAULT NULL,
  `system_isc_code` varchar(2) DEFAULT NULL,
  `total_base_isc` float DEFAULT NULL,
  `tax_isc` float DEFAULT NULL,
  `isc` float DEFAULT NULL,
  `total_base_other_taxed` float DEFAULT NULL,
  `percentage_other_taxed` float DEFAULT NULL,
  `total_other_taxed` float DEFAULT NULL,
  `quantity_plastic_bag` float DEFAULT NULL,
  `plastic_bag_tax` float DEFAULT NULL,
  `total_taxed` float DEFAULT NULL,
  `total_value` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_sale_note_summary`
--

CREATE TABLE `detail_sale_note_summary` (
  `detail_sale_note_summary_id` int(11) NOT NULL,
  `sale_note_summary_id` int(11) NOT NULL,
  `sale_note_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detail_ticket_summary`
--

CREATE TABLE `detail_ticket_summary` (
  `detail_ticket_summary_id` int(11) NOT NULL,
  `ticket_summary_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `date_of_reference` date NOT NULL,
  `summary_state_code` enum('1','2','3') NOT NULL,
  `sunat_state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document_correlative`
--

CREATE TABLE `document_correlative` (
  `document_correlative_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `document_code` varchar(2) NOT NULL,
  `max_correlative` int(11) DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document_type_code`
--

CREATE TABLE `document_type_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `document_type_code`
--

INSERT INTO `document_type_code` (`code`, `description`) VALUES
('01', 'FACTURA'),
('03', 'BOLETA DE VENTA'),
('07', 'NOTA DE CREDITO'),
('08', 'NOTA DE DEBITO'),
('09', 'GUIA DE REMISIÓN REMITENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `geographical_location_code`
--

CREATE TABLE `geographical_location_code` (
  `code` varchar(6) NOT NULL,
  `district` varchar(64) NOT NULL,
  `province` varchar(64) NOT NULL,
  `department` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `identity_document_type_code`
--

CREATE TABLE `identity_document_type_code` (
  `code` varchar(1) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `identity_document_type_code`
--

INSERT INTO `identity_document_type_code` (`code`, `description`) VALUES
('-', '- VARIOS - VENTAS MENORES A S/.700.00 Y OTROS'),
('0', '0 NO DOMICILIADO, SIN RUC (EXPORTACIÓN)'),
('1', '1 DNI - DOC. NACIONAL DE IDENTIDAD'),
('4', '4 CARNET DE EXTRANJERIA'),
('6', '6 RUC - REG. UNICO DE CONTRIBUYENTES'),
('7', '7 PASAPORTE'),
('A', 'A CED. DIPLOMATICA DE IDENTIDAD'),
('B', 'B DOC.IDENT.PAIS.RESIDENCIA-NO.D'),
('C', 'C Tax Identification Number - TIN – Doc Trib PP.NN'),
('D', 'D Identification Number - IN – Doc Trib PP. JJ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_state`
--

CREATE TABLE `invoice_state` (
  `invoice_state_id` int(11) NOT NULL,
  `state` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `invoice_state`
--

INSERT INTO `invoice_state` (`invoice_state_id`, `state`) VALUES
(1, 'Pendiente de Envío'),
(2, 'Guardado'),
(3, 'Aceptado'),
(4, 'Comunicación de Baja (Anulado)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module`
--

CREATE TABLE `module` (
  `idModule` int(11) NOT NULL,
  `nameModule` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `orderMenu` int(5) NOT NULL,
  `typeModule` int(5) NOT NULL,
  `stateModule` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operation_type_code`
--

CREATE TABLE `operation_type_code` (
  `code` varchar(4) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `operation_type_code`
--

INSERT INTO `operation_type_code` (`code`, `description`) VALUES
('0101', 'Venta lnterna'),
('0102', 'Exportación'),
('0104', 'Venta Interna – Anticipos'),
('0401', 'Ventas no domiciliados que no califican como exportación'),
('1001', 'Operación Sujeta a Detracción'),
('1004', 'Operación Sujeta a Detracción- Servicios de Transporte Carga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id_permission` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `function` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id_permission`, `name`, `module`, `function`, `description`, `created_at`) VALUES
(1, 'Listar Usuarios', 'usuario', 'index', '\r\nsee the list of users', '2019-07-26 21:57:40'),
(2, 'Ver Detalle de Usuario', 'usuario', 'ver', 'Muestra el detalle de cada usuario', '2019-07-26 21:58:19'),
(3, 'Editar Ususario', 'usuario', 'editar', 'Permite modificar los usuarios', '2019-07-26 21:58:33'),
(4, 'Eliminar Usuarios', 'usuario', 'eliminar', 'Permite Eliminar usuarios', '2019-07-26 21:58:57'),
(5, 'Listar Roles', 'roles', 'index', 'Ver los permisos', '2019-08-08 14:41:31'),
(6, 'Agregar Usuarios', 'usuario', 'agregar', 'Agregar un usuario', '2019-08-07 15:06:41'),
(7, 'Editar Roles', 'roles', 'editar', 'Modificar los permisos de un rol', '2019-08-08 14:41:40'),
(8, 'Eliminar Roles', 'roles', 'eliminar', 'Permite eliminar un rol', '2019-08-08 14:42:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `id_permission` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`id_permission`, `id_rol`) VALUES
(1, 2),
(1, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `unit_price_purchase` float DEFAULT NULL,
  `unit_price_sale` float DEFAULT NULL,
  `unit_price_purchase_igv` float DEFAULT NULL,
  `unit_price_sale_igv` float DEFAULT NULL,
  `product_code_inner` varchar(32) NOT NULL,
  `product_code` varchar(12) NOT NULL,
  `unit_measure_code` varchar(12) NOT NULL,
  `affectation_code` varchar(8) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `currency_code` varchar(8) DEFAULT NULL,
  `system_isc_code` varchar(2) DEFAULT NULL,
  `isc` float DEFAULT NULL,
  `type` enum('NIU','ZZ') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`product_id`, `updated_at`, `created_at`, `creation_user_id`, `modification_user_id`, `user_id`, `description`, `unit_price_purchase`, `unit_price_sale`, `unit_price_purchase_igv`, `unit_price_sale_igv`, `product_code_inner`, `product_code`, `unit_measure_code`, `affectation_code`, `stock`, `currency_code`, `system_isc_code`, `isc`, `type`) VALUES
(1, '2019-09-24 09:58:55', '2019-09-24 09:58:55', 3, 3, 3, 'Item 1 a', 15, 15, 17.7, 17.7, '', '10000000', 'NIU', '10', 0, 'PEN', '', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_code`
--

CREATE TABLE `product_code` (
  `code` varchar(8) NOT NULL,
  `description` varchar(510) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `product_code`
--

INSERT INTO `product_code` (`code`, `description`) VALUES
('10000000', 'MATERIAL VIVO VEGETAL Y ANIMAL, ACCESORIOS Y SUMINISTROS'),
('11000000', 'MATERIAL MINERAL, TEXTIL Y  VEGETAL Y ANIMAL NO COMESTIBLE'),
('12000000', 'MATERIAL QUÍMICO INCLUYENDO BIOQUÍMICOS Y MATERIALES DE GAS'),
('13000000', 'MATERIALES DE RESINA, COLOFONIA, CAUCHO, ESPUMA, PELÍCULA Y ELASTÓMERICOS'),
('14000000', 'MATERIALES Y PRODUCTOS DE PAPEL'),
('15000000', 'MATERIALES COMBUSTIBLES, ADITIVOS PARA COMBUSTIBLES, LUBRICANTES Y ANTICORROSIVOS'),
('20000000', 'MAQUINARIA Y ACCESORIOS DE MINERÍA Y PERFORACIÓN DE POZOS'),
('21000000', 'MAQUINARIA Y ACCESORIOS PARA AGRICULTURA, PESCA, SILVICULTURA Y FAUNA'),
('22000000', 'MAQUINARIA Y ACCESORIOS PARA CONSTRUCCIÓN Y EDIFICACIÓN'),
('23000000', 'MAQUINARIA Y ACCESORIOS PARA MANUFACTURA Y PROCESAMIENTO INDUSTRIAL'),
('24000000', 'MAQUINARIA, ACCESORIOS Y SUMINISTROS PARA MANEJO, ACONDICIONAMIENTO Y ALMACENAMIENTO DE MATERIALES'),
('25000000', 'VEHÍCULOS COMERCIALES, MILITARES Y PARTICULARES, ACCESORIOS Y COMPONENTES'),
('26000000', 'MAQUINARIA Y ACCESORIOS PARA GENERACIÓN Y DISTRIBUCIÓN DE ENERGÍA'),
('27000000', 'HERRAMIENTAS Y MAQUINARIA GENERAL'),
('30000000', 'COMPONENTES Y SUMINISTROS PARA ESTRUCTURAS, EDIFICACIÓN, CONSTRUCCIÓN Y OBRAS CIVILES'),
('31000000', 'COMPONENTES Y SUMINISTROS DE MANUFACTURA'),
('32000000', 'COMPONENTES Y SUMINISTROS ELECTRÓNICOS'),
('39000000', 'COMPONENTES, ACCESORIOS Y SUMINISTROS DE SISTEMAS ELÉCTRICOS E ILUMINACIÓN'),
('40000000', 'COMPONENTES Y EQUIPOS PARA DISTRIBUCIÓN Y SISTEMAS DE ACONDICIONAMIENTO'),
('41000000', 'EQUIPOS Y SUMINISTROS DE LABORATORIO, DE MEDICIÓN, DE OBSERVACIÓN Y DE PRUEBAS'),
('42000000', 'EQUIPO MÉDICO, ACCESORIOS Y SUMINISTROS'),
('43000000', 'DIFUSIÓN DE TECNOLOGÍAS DE INFORMACIÓN Y TELECOMUNICACIONES'),
('44000000', 'EQUIPOS DE OFICINA, ACCESORIOS Y SUMINISTROS'),
('45000000', 'EQUIPOS Y SUMINISTROS PARA IMPRESIÓN, FOTOGRAFIA Y AUDIOVISUALES'),
('46000000', 'EQUIPOS Y SUMINISTROS DE DEFENSA, ORDEN PUBLICO, PROTECCION, VIGILANCIA Y SEGURIDAD'),
('47000000', 'EQUIPOS DE LIMPIEZA Y SUMINISTROS'),
('48000000', 'MAQUINARIA, EQUIPO Y SUMINISTROS PARA LA INDUSTRIA DE SERVICIOS'),
('49000000', 'EQUIPOS, SUMINISTROS Y ACCESORIOS PARA DEPORTES Y RECREACIÓN'),
('50000000', 'ALIMENTOS, BEBIDAS Y TABACO'),
('51000000', 'MEDICAMENTOS Y PRODUCTOS FARMACÉUTICOS'),
('52000000', 'ARTÍCULOS DOMÉSTICOS, SUMINISTROS Y PRODUCTOS ELECTRÓNICOS DE CONSUMO'),
('53000000', 'ROPA, MALETAS Y PRODUCTOS DE ASEO PERSONAL'),
('54000000', 'PRODUCTOS PARA RELOJERÍA, JOYERÍA Y PIEDRAS PRECIOSAS'),
('55000000', 'PUBLICACIONES IMPRESAS, PUBLICACIONES ELECTRÓNICAS Y ACCESORIOS'),
('56000000', 'MUEBLES, MOBILIARIO Y DECORACIÓN'),
('60000000', 'INSTRUMENTOS MUSICALES, JUEGOS, JUGUETES, ARTES, ARTESANÍAS Y EQUIPO EDUCATIVO, MATERIALES, ACCESORIOS Y SUMINISTROS'),
('70000000', 'SERVICIOS DE CONTRATACION AGRÍCOLA, PESQUERA, FORESTAL Y DE FAUNA'),
('71000000', 'SERVICIOS DE MINERÍA, PETRÓLEO Y GAS'),
('72000000', 'SERVICIOS DE EDIFICACIÓN, CONSTRUCCIÓN DE INSTALACIONES Y MANTENIMIENTO'),
('73000000', 'SERVICIOS DE PRODUCCIÓN INDUSTRIAL Y MANUFACTURA'),
('76000000', 'SERVICIOS DE LIMPIEZA, DESCONTAMINACIÓN Y TRATAMIENTO DE RESIDUOS'),
('77000000', 'SERVICIOS MEDIOAMBIENTALES'),
('78000000', 'SERVICIOS DE TRANSPORTE, ALMACENAJE Y CORREO'),
('80000000', 'SERVICIOS DE GESTIÓN, SERVICIOS PROFESIONALES DE EMPRESA Y SERVICIOS ADMINISTRATIVOS'),
('81000000', 'SERVICIOS BASADOS EN INGENIERÍA, INVESTIGACIÓN Y TECNOLOGÍA'),
('82000000', 'SERVICIOS EDITORIALES, DE DISE?O, DE ARTES GRAFICAS Y BELLAS ARTES'),
('83000000', 'SERVICIOS PÚBLICOS Y SERVICIOS RELACIONADOS CON EL SECTOR PÚBLICO'),
('84000000', 'SERVICIOS FINANCIEROS Y DE SEGUROS'),
('85000000', 'SERVICIOS DE SALUD'),
('86000000', 'SERVICIOS EDUCATIVOS Y DE FORMACIÓN'),
('90000000', 'SERVICIOS DE VIAJES, ALIMENTACIÓN, ALOJAMIENTO Y ENTRETENIMIENTO'),
('91000000', 'SERVICIOS PERSONALES Y DOMÉSTICOS'),
('92000000', 'SERVICIOS DE DEFENSA NACIONAL, ORDEN PUBLICO, SEGURIDAD Y VIGILANCIA'),
('93000000', 'SERVICIOS POLÍTICOS Y DE ASUNTOS CÍVICOS'),
('94000000', 'ORGANIZACIONES Y CLUBES'),
('95000000', 'TERRENOS, EDIFICIOS, ESTRUCTURAS Y VÍAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `referral_guide`
--

CREATE TABLE `referral_guide` (
  `referral_guide_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `document_code` varchar(2) NOT NULL,
  `serie` varchar(64) DEFAULT NULL,
  `correlative` int(11) NOT NULL,
  `date_of_issue` date NOT NULL,
  `time_of_issue` time NOT NULL,
  `transfer_code` varchar(2) DEFAULT NULL,
  `transport_code` varchar(2) DEFAULT NULL,
  `transfer_start_date` datetime DEFAULT NULL,
  `total_gross_weight` float DEFAULT NULL,
  `number_packages` float DEFAULT NULL,
  `carrier_document_code` varchar(1) DEFAULT NULL,
  `carrier_document_number` varchar(24) DEFAULT NULL,
  `carrier_denomination` varchar(255) DEFAULT NULL,
  `carrier_plate_number` varchar(64) DEFAULT NULL,
  `driver_document_code` varchar(1) DEFAULT NULL,
  `driver_document_number` varchar(24) DEFAULT NULL,
  `driver_full_name` varchar(255) DEFAULT NULL,
  `location_starting_code` varchar(6) DEFAULT NULL,
  `address_starting_point` varchar(128) DEFAULT NULL,
  `location_arrival_code` varchar(6) DEFAULT NULL,
  `address_arrival_point` varchar(128) DEFAULT NULL,
  `observations` varchar(255) DEFAULT NULL,
  `pdf_format` varchar(16) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `referral_guide`
--
DELIMITER $$
CREATE TRIGGER `sale_referral_guide_bi_before` BEFORE INSERT ON `referral_guide` FOR EACH ROW BEGIN
    IF((SELECT count(*) FROM referral_guide WHERE document_code = NEW.document_code AND
            correlative = NEW.correlative AND serie = NEW.serie AND
            user_id = NEW.user_id) > 0) then
        SET NEW.correlative = (SELECT max_correlative FROM document_correlative WHERE
                user_id = NEW.user_id AND serie = NEW.serie AND
                document_code = NEW.document_code) + 1;
    END IF;
    UPDATE document_correlative SET max_correlative = NEW.correlative WHERE user_id = NEW.user_id AND document_code = NEW.document_code AND serie = NEW.serie;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `especial` enum('all-access','no-access') COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `name`, `description`, `especial`) VALUES
(1, 'admin', 'administrador General', NULL),
(2, 'cajero', 'antencion en caja', NULL),
(3, 'cliente', 'Cliente final que emite los comprobantes electrónicos', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `time_of_issue` time NOT NULL,
  `date_of_due` date DEFAULT NULL,
  `serie` varchar(64) DEFAULT NULL,
  `correlative` int(11) NOT NULL,
  `observation` text,
  `sunat_state` tinyint(1) DEFAULT NULL,
  `change_type` varchar(255) DEFAULT NULL,
  `document_code` varchar(2) DEFAULT NULL,
  `currency_code` varchar(8) DEFAULT NULL,
  `operation_code` varchar(8) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `total_prepayment` float DEFAULT NULL,
  `total_free` float DEFAULT NULL,
  `total_exportation` float DEFAULT NULL,
  `total_other_charged` float DEFAULT NULL,
  `total_discount` float DEFAULT NULL,
  `total_exonerated` float DEFAULT NULL,
  `total_unaffected` float DEFAULT NULL,
  `total_taxed` float DEFAULT NULL,
  `total_igv` float DEFAULT NULL,
  `total_base_isc` float DEFAULT NULL,
  `total_isc` float DEFAULT NULL,
  `total_charge` float DEFAULT NULL,
  `total_base_other_taxed` float DEFAULT NULL,
  `total_other_taxed` float DEFAULT NULL,
  `total_tax` float DEFAULT NULL,
  `total_value` float DEFAULT NULL,
  `total_plastic_bag_tax` float DEFAULT NULL,
  `total` float NOT NULL,
  `global_discount_percentage` float DEFAULT NULL,
  `purchase_order` varchar(255) DEFAULT NULL,
  `vehicle_plate` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `percentage_plastic_bag_tax` float DEFAULT NULL,
  `percentage_igv` float DEFAULT NULL,
  `perception` text,
  `detraction` text,
  `prepayment` text,
  `discount` text,
  `charged` text,
  `related` text,
  `guide` text,
  `legend` text,
  `pdf_format` varchar(16) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `cdr_url` varchar(255) DEFAULT NULL,
  `sent_to_client` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `sale`
--
DELIMITER $$
CREATE TRIGGER `sale_correlative_bi_before` BEFORE INSERT ON `sale` FOR EACH ROW BEGIN
        IF((SELECT count(*) FROM sale WHERE document_code = NEW.document_code AND
                                            correlative = NEW.correlative AND serie = NEW.serie AND
                                            user_id = NEW.user_id) > 0) then
            SET NEW.correlative = (SELECT max_correlative FROM document_correlative WHERE
                                            user_id = NEW.user_id AND serie = NEW.serie AND
                                            document_code = NEW.document_code) + 1;
        END IF;
        UPDATE document_correlative SET max_correlative = NEW.correlative WHERE user_id = NEW.user_id AND document_code = NEW.document_code AND serie = NEW.serie;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_note`
--

CREATE TABLE `sale_note` (
  `sale_note_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `time_of_issue` time NOT NULL,
  `date_of_due` date DEFAULT NULL,
  `serie` varchar(64) DEFAULT NULL,
  `correlative` int(11) NOT NULL,
  `observation` text,
  `sunat_state` tinyint(1) DEFAULT NULL,
  `change_type` varchar(255) DEFAULT NULL,
  `document_code` varchar(2) DEFAULT NULL,
  `currency_code` varchar(8) DEFAULT NULL,
  `operation_code` varchar(8) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `total_prepayment` float DEFAULT NULL,
  `total_free` float DEFAULT NULL,
  `total_exportation` float DEFAULT NULL,
  `total_other_charged` float DEFAULT NULL,
  `total_discount` float DEFAULT NULL,
  `total_exonerated` float DEFAULT NULL,
  `total_unaffected` float DEFAULT NULL,
  `total_taxed` float DEFAULT NULL,
  `total_igv` float DEFAULT NULL,
  `total_base_isc` float DEFAULT NULL,
  `total_isc` float DEFAULT NULL,
  `total_charge` float DEFAULT NULL,
  `total_base_other_taxed` float DEFAULT NULL,
  `total_other_taxed` float DEFAULT NULL,
  `total_tax` float DEFAULT NULL,
  `total_value` float DEFAULT NULL,
  `total_plastic_bag_tax` float DEFAULT NULL,
  `total` float NOT NULL,
  `global_discount_percentage` float DEFAULT NULL,
  `purchase_order` varchar(255) DEFAULT NULL,
  `vehicle_plate` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `percentage_plastic_bag_tax` float DEFAULT NULL,
  `percentage_igv` float DEFAULT NULL,
  `perception` text,
  `detraction` text,
  `prepayment` text,
  `discount` text,
  `charged` text,
  `related` text,
  `guide` text,
  `legend` text,
  `pdf_format` varchar(16) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `cdr_url` varchar(255) DEFAULT NULL,
  `sent_to_client` tinyint(1) DEFAULT NULL,
  `reason_update_code` varchar(16) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `sale_note`
--
DELIMITER $$
CREATE TRIGGER `sale_note_correlative_bi_before` BEFORE INSERT ON `sale_note` FOR EACH ROW BEGIN
    IF((SELECT count(*) FROM sale_note WHERE document_code = NEW.document_code AND
            correlative = NEW.correlative AND serie = NEW.serie AND
            user_id = NEW.user_id) > 0) then
        SET NEW.correlative = (SELECT max_correlative FROM document_correlative WHERE
                user_id = NEW.user_id AND serie = NEW.serie AND
                document_code = NEW.document_code) + 1;
    END IF;
    UPDATE document_correlative SET max_correlative = NEW.correlative WHERE user_id = NEW.user_id AND document_code = NEW.document_code AND serie = NEW.serie;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_note_summary`
--

CREATE TABLE `sale_note_summary` (
  `sale_note_summary_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `date_of_reference` date NOT NULL,
  `ticket` varchar(255) DEFAULT NULL,
  `pdf_format` varchar(16) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_note_voided`
--

CREATE TABLE `sale_note_voided` (
  `sale_note_voided_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sale_note_id` int(11) NOT NULL,
  `ticket` varchar(64) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `date_of_reference` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_referral_guide`
--

CREATE TABLE `sale_referral_guide` (
  `sale_id` int(11) NOT NULL,
  `referral_guide_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_voided`
--

CREATE TABLE `sale_voided` (
  `sale_voided_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sale_id` int(11) NOT NULL,
  `ticket` varchar(64) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `date_of_reference` date NOT NULL,
  `number` int(11) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `cdr_url` varchar(255) DEFAULT NULL,
  `sunat_state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `summary_state_code`
--

CREATE TABLE `summary_state_code` (
  `code` enum('1','2','3') NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `summary_state_code`
--

INSERT INTO `summary_state_code` (`code`, `description`) VALUES
('1', 'Adicionar'),
('2', 'Modificar'),
('3', 'Anulado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_communication`
--

CREATE TABLE `sunat_communication` (
  `sunat_communication_id` int(10) NOT NULL,
  `sunat_communication_type_id` char(2) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL,
  `creation_user_id` int(11) NOT NULL,
  `modification_user_id` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  `observation` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sunat_communication`
--

INSERT INTO `sunat_communication` (`sunat_communication_id`, `sunat_communication_type_id`, `reference_id`, `enabled`, `creation_date`, `creation_user_id`, `modification_user_id`, `modification_date`, `observation`) VALUES
(1, '1', 1, 1, '2019-08-26 12:22:18', 999, 999, '2019-08-26 12:22:18', ''),
(2, '1', 1, 1, '2019-08-26 12:23:47', 999, 999, '2019-08-26 12:23:47', ''),
(3, '1', 1, 1, '2019-08-26 12:30:14', 999, 999, '2019-08-26 12:30:14', ''),
(4, '1', 1, 1, '2019-08-26 12:30:37', 999, 999, '2019-08-26 12:30:37', ''),
(5, '1', 1, 1, '2019-08-26 12:30:39', 999, 999, '2019-08-26 12:30:39', ''),
(6, '1', 1, 1, '2019-08-26 12:31:35', 999, 999, '2019-08-26 12:31:35', ''),
(7, '1', 1, 1, '2019-08-26 12:32:29', 999, 999, '2019-08-26 12:32:29', ''),
(8, '1', 1, 1, '2019-08-26 12:42:01', 999, 999, '2019-08-26 12:42:01', ''),
(9, '1', 1, 1, '2019-08-26 12:42:10', 999, 999, '2019-08-26 12:42:10', ''),
(10, '1', 1, 1, '2019-08-26 12:43:14', 999, 999, '2019-08-26 12:43:14', ''),
(11, '1', 1, 1, '2019-08-26 12:46:33', 999, 999, '2019-08-26 12:46:33', ''),
(12, '1', 7, 1, '2019-08-27 10:48:09', 3, 3, '2019-08-27 10:48:09', ''),
(13, '1', 8, 1, '2019-08-27 10:53:24', 3, 3, '2019-08-27 10:53:24', ''),
(14, '1', 9, 1, '2019-08-27 10:56:01', 3, 3, '2019-08-27 10:56:01', ''),
(15, '1', 10, 1, '2019-08-27 10:57:27', 3, 3, '2019-08-27 10:57:27', ''),
(16, '1', 11, 1, '2019-08-27 11:00:33', 3, 3, '2019-08-27 11:00:33', ''),
(17, '1', 12, 1, '2019-08-27 11:23:22', 3, 3, '2019-08-27 11:23:22', ''),
(18, '1', 13, 1, '2019-08-27 11:29:16', 3, 3, '2019-08-27 11:29:16', ''),
(19, '1', 14, 1, '2019-08-27 11:31:41', 3, 3, '2019-08-27 11:31:41', ''),
(20, '1', 15, 1, '2019-08-27 11:31:50', 3, 3, '2019-08-27 11:31:50', ''),
(21, '1', 16, 1, '2019-08-27 11:32:22', 3, 3, '2019-08-27 11:32:22', ''),
(22, '1', 17, 1, '2019-08-27 11:34:20', 3, 3, '2019-08-27 11:34:20', ''),
(23, '1', 18, 1, '2019-08-27 11:36:41', 3, 3, '2019-08-27 11:36:41', ''),
(24, '1', 19, 1, '2019-08-27 11:39:35', 3, 3, '2019-08-27 11:39:35', ''),
(25, '1', 21, 1, '2019-08-27 11:50:11', 3, 3, '2019-08-27 11:50:11', ''),
(26, '1', 22, 1, '2019-08-27 12:22:29', 3, 3, '2019-08-27 12:22:29', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_communication_type`
--

CREATE TABLE `sunat_communication_type` (
  `sunat_communication_type_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sunat_communication_type`
--

INSERT INTO `sunat_communication_type` (`sunat_communication_type_id`, `name`) VALUES
(1, 'SendBill'),
(2, 'SendSummary');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_response`
--

CREATE TABLE `sunat_response` (
  `sunat_response_id` int(11) NOT NULL,
  `sunat_communication_id` int(11) NOT NULL,
  `sunat_communication_success` tinyint(1) NOT NULL,
  `reader_success` tinyint(1) NOT NULL DEFAULT '0',
  `sunat_response_code` varchar(4) NOT NULL DEFAULT '',
  `sunat_response_description` varchar(500) NOT NULL DEFAULT '',
  `enabled` tinyint(1) NOT NULL,
  `creation_date` datetime NOT NULL,
  `creation_user_id` int(11) NOT NULL,
  `modification_user_id` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  `observation` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sunat_response`
--

INSERT INTO `sunat_response` (`sunat_response_id`, `sunat_communication_id`, `sunat_communication_success`, `reader_success`, `sunat_response_code`, `sunat_response_description`, `enabled`, `creation_date`, `creation_user_id`, `modification_user_id`, `modification_date`, `observation`) VALUES
(1, 7, 1, 1, '0', 'La Factura numero FPP1-1, ha sido aceptada', 1, '2019-08-26 12:32:30', 999, 999, '2019-08-26 12:32:30', ''),
(2, 8, 1, 1, '0', 'La Factura numero FPP1-1, ha sido aceptada', 1, '2019-08-26 12:42:02', 999, 999, '2019-08-26 12:42:02', ''),
(3, 9, 1, 1, '0', 'La Factura numero FPP1-1, ha sido aceptada', 1, '2019-08-26 12:42:12', 999, 999, '2019-08-26 12:42:12', ''),
(4, 10, 1, 1, '0', 'La Factura numero FPP1-1, ha sido aceptada', 1, '2019-08-26 12:43:15', 999, 999, '2019-08-26 12:43:15', ''),
(5, 11, 1, 1, '0', 'La Factura numero FPP1-1, ha sido aceptada', 1, '2019-08-26 12:46:34', 999, 999, '2019-08-26 12:46:34', ''),
(6, 25, 1, 1, '0', 'La Factura numero FPP1-21, ha sido aceptada', 21, '2019-08-27 11:50:12', 3, 3, '2019-08-27 11:50:12', ''),
(7, 26, 1, 1, '0', 'La Factura numero FPP1-22, ha sido aceptada', 22, '2019-08-27 12:22:30', 3, 3, '2019-08-27 12:22:30', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_xml`
--

CREATE TABLE `sunat_xml` (
  `sunat_xml_id` int(11) NOT NULL,
  `sunat_xml_type_id` int(11) NOT NULL,
  `reference_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `creation_date` datetime NOT NULL,
  `creation_user_id` int(11) NOT NULL,
  `modification_user_id` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  `observation` varchar(500) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sunat_xml`
--

INSERT INTO `sunat_xml` (`sunat_xml_id`, `sunat_xml_type_id`, `reference_id`, `enabled`, `creation_date`, `creation_user_id`, `modification_user_id`, `modification_date`, `observation`) VALUES
(1, 1, 1, 1, '2019-08-26 12:46:33', 999, 999, '2019-08-26 12:46:33', ''),
(2, 1, 17, 1, '2019-08-27 11:34:20', 3, 3, '2019-08-27 11:34:20', ''),
(3, 1, 18, 1, '2019-08-27 11:36:41', 3, 3, '2019-08-27 11:36:41', ''),
(4, 1, 19, 1, '2019-08-27 11:39:35', 3, 3, '2019-08-27 11:39:35', ''),
(5, 1, 21, 1, '2019-08-27 11:50:11', 3, 3, '2019-08-27 11:50:11', ''),
(6, 1, 22, 1, '2019-08-27 12:22:29', 3, 3, '2019-08-27 12:22:29', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sunat_xml_type`
--

CREATE TABLE `sunat_xml_type` (
  `sunat_xml_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sunat_xml_type`
--

INSERT INTO `sunat_xml_type` (`sunat_xml_type_id`, `name`) VALUES
(1, 'FACTURA'),
(2, 'BOLETA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_isc_type_code`
--

CREATE TABLE `system_isc_type_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `system_isc_type_code`
--

INSERT INTO `system_isc_type_code` (`code`, `description`) VALUES
('01', 'Sistema al valor (Apéndice IV, lit. A – T.U.O IGV e ISC)'),
('02', 'Aplicación del Monto Fijo ( Sistema específico, bienes en el apéndice III, Apéndice IV, lit. B – T.U.O IGV e ISC)'),
('03', 'Sistema de Precios de Venta al Público (Apéndice IV, lit. C – T.U.O IGV e ISC)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_summary`
--

CREATE TABLE `ticket_summary` (
  `ticket_summary_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `creation_user_id` int(11) DEFAULT NULL,
  `modification_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `date_of_issue` date NOT NULL,
  `date_of_reference` date NOT NULL,
  `ticket` varchar(255) DEFAULT NULL,
  `pdf_format` varchar(16) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `xml_url` varchar(255) DEFAULT NULL,
  `cdr_url` varchar(255) DEFAULT NULL,
  `sunat_state` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Disparadores `ticket_summary`
--
DELIMITER $$
CREATE TRIGGER `ticket_summary_bi_before` BEFORE INSERT ON `ticket_summary` FOR EACH ROW BEGIN
    DECLARE maxCorrelative INT;
    SET maxCorrelative = 0;
    SELECT max_correlative INTO maxCorrelative FROM document_correlative WHERE user_id = NEW.user_id AND document_code = '03' AND serie = '-' LIMIT 1;

    if(maxCorrelative = 0) THEN
        SET maxCorrelative = 1;
        INSERT INTO document_correlative (user_id, serie, document_code, max_correlative, state) VALUES (NEW.user_id,'-','03', maxCorrelative, true);
    ELSE
        UPDATE document_correlative SET max_correlative = maxCorrelative WHERE user_id = NEW.user_id AND document_code = '03' AND serie = '-';
    END IF;

    SET NEW.number = maxCorrelative;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transfer_reason_code`
--

CREATE TABLE `transfer_reason_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transfer_reason_code`
--

INSERT INTO `transfer_reason_code` (`code`, `description`) VALUES
('01', 'Venta'),
('02', 'Compra'),
('04', 'Traslado entre establecimientos de la misma empresa'),
('08', 'Importación'),
('09', 'Exportación'),
('13', 'Otros'),
('14', 'Venta sujeta a confirmación del comprador'),
('18', 'Traslado emisor itinerante CP'),
('19', 'Traslado a zona primaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transport_mode_code`
--

CREATE TABLE `transport_mode_code` (
  `code` varchar(2) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transport_mode_code`
--

INSERT INTO `transport_mode_code` (`code`, `description`) VALUES
('01', 'Transporte público'),
('02', 'Transporte privado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tribute_type_code`
--

CREATE TABLE `tribute_type_code` (
  `code` varchar(4) NOT NULL,
  `description` varchar(255) NOT NULL,
  `international_code` varchar(3) DEFAULT NULL,
  `name` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tribute_type_code`
--

INSERT INTO `tribute_type_code` (`code`, `description`, `international_code`, `name`) VALUES
('1000', 'IGV Impuesto General a las Ventas', 'VAT', 'IGV'),
('1016', 'Impuesto a la Venta Arroz Pilado', 'VAT', 'IVAP'),
('2000', 'ISC Impuesto Selectivo al Consumo', 'EXC', 'ISC'),
('7152', 'Impuesto a la bolsa plastica', 'OTH', 'ICBPER'),
('9995', 'Exportación', 'FRE', 'EXP'),
('9996', 'Gratuito', 'FRE', 'GRA'),
('9997', 'Exonerado', 'VAT', 'EXO'),
('9998', 'Inafecto', 'FRE', 'INA'),
('9999', 'Otros tributos', 'OTH', 'OTROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unit_measure_type_code`
--

CREATE TABLE `unit_measure_type_code` (
  `code` varchar(12) NOT NULL,
  `description` varchar(255) NOT NULL,
  `extend` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unit_measure_type_code`
--

INSERT INTO `unit_measure_type_code` (`code`, `description`, `extend`) VALUES
('4A', 'BOBINAS', 0),
('BE', 'FARDO', 0),
('BG', 'BOLSA', 0),
('BJ', 'BALDE', 0),
('BLL', 'BARRILES', 0),
('BO', 'BOTELLAS', 0),
('BX', 'CAJA', 0),
('C62', 'PIEZAS', 0),
('CA', 'LATAS', 0),
('CEN', 'CIENTODEUNIDADES', 0),
('CJ', 'CONOS', 0),
('CMK', 'CENTIMETROCUADRADO', 0),
('CMQ', 'CENTIMETROCUBICO', 0),
('CMT', 'CENTIMETROLINEAL', 0),
('CT', 'CARTONES', 0),
('CY', 'CILINDRO', 0),
('DR', 'TAMBOR', 0),
('DZN', 'DOCENA', 0),
('DZP', 'DOCENAPOR10**6', 0),
('FOT', 'PIES', 0),
('FTK', 'PIESCUADRADOS', 0),
('FTQ', 'PIESCUBICOS', 0),
('GLI', 'GALONINGLES(4,545956L)', 0),
('GLL', 'USGALON(3,7843L)', 0),
('GRM', 'GRAMO', 0),
('GRO', 'GRUESA', 0),
('HLT', 'HECTOLITRO', 0),
('INH', 'PULGADAS', 0),
('KGM', 'KILOGRAMO', 0),
('KT', 'KIT', 0),
('KTM', 'KILOMETRO', 0),
('KWH', 'KILOVATIOHORA', 0),
('LBR', 'LIBRAS', 0),
('LEF', 'HOJA', 0),
('LTN', 'TONELADALARGA', 0),
('LTR', 'LITRO', 0),
('MGM', 'MILIGRAMOS', 0),
('MLL', 'MILLARES', 0),
('MLT', 'MILILITRO', 0),
('MMK', 'MILIMETROCUADRADO', 0),
('MMQ', 'MILIMETROCUBICO', 0),
('MMT', 'MILIMETRO', 0),
('MTK', 'METROCUADRADO', 0),
('MTQ', 'METROCUBICO', 0),
('MTR', 'METRO', 0),
('MWH', 'MEGAWATTHORA', 0),
('NIU', 'UNIDAD(BIENES)', 0),
('ONZ', 'ONZAS', 0),
('PF', 'PALETAS', 0),
('PG', 'PLACAS', 0),
('PK', 'PAQUETE', 0),
('PR', 'PAR', 0),
('RM', 'RESMA', 0),
('SET', 'JUEGO', 0),
('ST', 'PLIEGO', 0),
('STN', 'TONELADACORTA', 0),
('TNE', 'TONELADAS', 0),
('TU', 'TUBOS', 0),
('UM', 'MILLONDEUNIDADES', 0),
('YDK', 'YARDACUADRADA', 0),
('YRD', 'YARDA', 0),
('ZZ', 'UNIDAD(SERVICIOS)', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `names` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ruc` bigint(13) DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_document_type` int(11) NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `state` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `id_rol`, `names`, `email`, `phone`, `ruc`, `address`, `id_document_type`, `password`, `created_at`, `updated_at`, `state`) VALUES
(1, 1, 'JOSUE', 'josue_luistj@hotmail.com', '974288773', NULL, NULL, 1, 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2019-07-17 16:30:37', NULL, 1),
(2, 2, 'prueba', 'josue_luistj@hotmail.co', '212332', 10703530554, '1234', 0, 'f09b64f480ff117331ed88334da5924682d8615e3f6d166b34d0fdfd3c6dc076', '2019-08-08 17:03:14', '2019-08-08 17:03:14', 1),
(3, 3, 'cliente', 'cliente@gmail.com', '516516516', 16516516, 'av. la calle', 3, '34e422278ea745b5d87ba6592f0ea3fe32a2eb7593f5960ac72d7094fb121f3d', '2019-09-24 14:54:04', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `additional_legend_code`
--
ALTER TABLE `additional_legend_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `affectation_igv_type_code`
--
ALTER TABLE `affectation_igv_type_code`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_affectation_igv_type_code_tribute_type_code` (`tribute_code`);

--
-- Indices de la tabla `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`business_id`),
  ADD UNIQUE KEY `uk_company` (`web_site`,`email`);

--
-- Indices de la tabla `business_user`
--
ALTER TABLE `business_user`
  ADD PRIMARY KEY (`business_user_id`),
  ADD KEY `fk_business_user_business` (`business_id`);

--
-- Indices de la tabla `credit_note_type_code`
--
ALTER TABLE `credit_note_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `currency_type_code`
--
ALTER TABLE `currency_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indices de la tabla `debit_note_type_code`
--
ALTER TABLE `debit_note_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `detail_referral_guide`
--
ALTER TABLE `detail_referral_guide`
  ADD PRIMARY KEY (`detail_referral_guide_id`),
  ADD KEY `fk_detail_referral_guide_product` (`product_id`),
  ADD KEY `fk_detail_referral_guide_referral_guide` (`referral_guide_id`);

--
-- Indices de la tabla `detail_sale`
--
ALTER TABLE `detail_sale`
  ADD PRIMARY KEY (`detail_sale_id`),
  ADD KEY `fk_detail_sale_sale` (`sale_id`),
  ADD KEY `fk_detail_sale_product` (`product_id`);

--
-- Indices de la tabla `detail_sale_note`
--
ALTER TABLE `detail_sale_note`
  ADD PRIMARY KEY (`detail_sale_note_id`),
  ADD KEY `fk_detail_sale_note_sale_note` (`sale_note_id`),
  ADD KEY `fk_detail_sale_note_product` (`product_id`);

--
-- Indices de la tabla `detail_sale_note_summary`
--
ALTER TABLE `detail_sale_note_summary`
  ADD PRIMARY KEY (`detail_sale_note_summary_id`),
  ADD KEY `fk_detail_sale_note_summary_sale_note_summary` (`sale_note_summary_id`),
  ADD KEY `fk_detail_sale_note_summary_sale_note` (`sale_note_id`);

--
-- Indices de la tabla `detail_ticket_summary`
--
ALTER TABLE `detail_ticket_summary`
  ADD PRIMARY KEY (`detail_ticket_summary_id`),
  ADD KEY `fk_detail_ticket_summary_ticket_summary` (`ticket_summary_id`),
  ADD KEY `fk_detail_ticket_summary_sale` (`sale_id`),
  ADD KEY `fk_detail_ticket_summary_summary_state_code` (`summary_state_code`);

--
-- Indices de la tabla `document_correlative`
--
ALTER TABLE `document_correlative`
  ADD PRIMARY KEY (`document_correlative_id`),
  ADD KEY `fk_document_correlative_document_code` (`document_code`);

--
-- Indices de la tabla `document_type_code`
--
ALTER TABLE `document_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `geographical_location_code`
--
ALTER TABLE `geographical_location_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `identity_document_type_code`
--
ALTER TABLE `identity_document_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `invoice_state`
--
ALTER TABLE `invoice_state`
  ADD PRIMARY KEY (`invoice_state_id`);

--
-- Indices de la tabla `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`idModule`);

--
-- Indices de la tabla `operation_type_code`
--
ALTER TABLE `operation_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_unit_measure_code` (`unit_measure_code`),
  ADD KEY `fk_product_product_code` (`product_code`);

--
-- Indices de la tabla `product_code`
--
ALTER TABLE `product_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `referral_guide`
--
ALTER TABLE `referral_guide`
  ADD PRIMARY KEY (`referral_guide_id`),
  ADD KEY `fk_referral_guide_customer` (`customer_id`),
  ADD KEY `fk_referral_guide_location_starting_code` (`location_starting_code`),
  ADD KEY `fk_referral_guide_location_arrival_code` (`location_arrival_code`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `fk_sale_customer` (`customer_id`),
  ADD KEY `fk_sale_currency_type_code` (`currency_code`),
  ADD KEY `fk_sale_operation_type_code` (`operation_code`),
  ADD KEY `fk_sale_document_type_code` (`document_code`),
  ADD KEY `in_sale_indexes` (`serie`,`correlative`,`user_id`);

--
-- Indices de la tabla `sale_note`
--
ALTER TABLE `sale_note`
  ADD PRIMARY KEY (`sale_note_id`),
  ADD KEY `fk_sale_note_customer` (`customer_id`),
  ADD KEY `fk_sale_note_currency_type_code` (`currency_code`),
  ADD KEY `fk_sale_note_operation_type_code` (`operation_code`),
  ADD KEY `fk_sale_note_document_type_code` (`document_code`),
  ADD KEY `in_sale_note_indexes` (`serie`,`correlative`,`user_id`);

--
-- Indices de la tabla `sale_note_summary`
--
ALTER TABLE `sale_note_summary`
  ADD PRIMARY KEY (`sale_note_summary_id`);

--
-- Indices de la tabla `sale_note_voided`
--
ALTER TABLE `sale_note_voided`
  ADD PRIMARY KEY (`sale_note_voided_id`),
  ADD KEY `fk_sale_note_voided_sale` (`sale_note_id`);

--
-- Indices de la tabla `sale_referral_guide`
--
ALTER TABLE `sale_referral_guide`
  ADD KEY `fk_sale_referral_guide` (`sale_id`),
  ADD KEY `fk_sale_referral_guide_referral_guide` (`referral_guide_id`);

--
-- Indices de la tabla `sale_voided`
--
ALTER TABLE `sale_voided`
  ADD PRIMARY KEY (`sale_voided_id`),
  ADD UNIQUE KEY `uk_sale` (`sale_id`);

--
-- Indices de la tabla `summary_state_code`
--
ALTER TABLE `summary_state_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `sunat_communication`
--
ALTER TABLE `sunat_communication`
  ADD PRIMARY KEY (`sunat_communication_id`);

--
-- Indices de la tabla `sunat_communication_type`
--
ALTER TABLE `sunat_communication_type`
  ADD PRIMARY KEY (`sunat_communication_type_id`);

--
-- Indices de la tabla `sunat_response`
--
ALTER TABLE `sunat_response`
  ADD PRIMARY KEY (`sunat_response_id`);

--
-- Indices de la tabla `sunat_xml`
--
ALTER TABLE `sunat_xml`
  ADD PRIMARY KEY (`sunat_xml_id`);

--
-- Indices de la tabla `sunat_xml_type`
--
ALTER TABLE `sunat_xml_type`
  ADD PRIMARY KEY (`sunat_xml_type_id`);

--
-- Indices de la tabla `system_isc_type_code`
--
ALTER TABLE `system_isc_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `ticket_summary`
--
ALTER TABLE `ticket_summary`
  ADD PRIMARY KEY (`ticket_summary_id`);

--
-- Indices de la tabla `transfer_reason_code`
--
ALTER TABLE `transfer_reason_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `transport_mode_code`
--
ALTER TABLE `transport_mode_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `tribute_type_code`
--
ALTER TABLE `tribute_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `unit_measure_type_code`
--
ALTER TABLE `unit_measure_type_code`
  ADD PRIMARY KEY (`code`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `business`
--
ALTER TABLE `business`
  MODIFY `business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `business_user`
--
ALTER TABLE `business_user`
  MODIFY `business_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detail_referral_guide`
--
ALTER TABLE `detail_referral_guide`
  MODIFY `detail_referral_guide_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detail_sale`
--
ALTER TABLE `detail_sale`
  MODIFY `detail_sale_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detail_sale_note`
--
ALTER TABLE `detail_sale_note`
  MODIFY `detail_sale_note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detail_sale_note_summary`
--
ALTER TABLE `detail_sale_note_summary`
  MODIFY `detail_sale_note_summary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detail_ticket_summary`
--
ALTER TABLE `detail_ticket_summary`
  MODIFY `detail_ticket_summary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `document_correlative`
--
ALTER TABLE `document_correlative`
  MODIFY `document_correlative_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invoice_state`
--
ALTER TABLE `invoice_state`
  MODIFY `invoice_state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `module`
--
ALTER TABLE `module`
  MODIFY `idModule` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id_permission` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `referral_guide`
--
ALTER TABLE `referral_guide`
  MODIFY `referral_guide_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sale_note`
--
ALTER TABLE `sale_note`
  MODIFY `sale_note_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sale_note_summary`
--
ALTER TABLE `sale_note_summary`
  MODIFY `sale_note_summary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sale_note_voided`
--
ALTER TABLE `sale_note_voided`
  MODIFY `sale_note_voided_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sale_voided`
--
ALTER TABLE `sale_voided`
  MODIFY `sale_voided_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sunat_communication`
--
ALTER TABLE `sunat_communication`
  MODIFY `sunat_communication_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `sunat_communication_type`
--
ALTER TABLE `sunat_communication_type`
  MODIFY `sunat_communication_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sunat_response`
--
ALTER TABLE `sunat_response`
  MODIFY `sunat_response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sunat_xml`
--
ALTER TABLE `sunat_xml`
  MODIFY `sunat_xml_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `sunat_xml_type`
--
ALTER TABLE `sunat_xml_type`
  MODIFY `sunat_xml_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ticket_summary`
--
ALTER TABLE `ticket_summary`
  MODIFY `ticket_summary_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `affectation_igv_type_code`
--
ALTER TABLE `affectation_igv_type_code`
  ADD CONSTRAINT `fk_affectation_igv_type_code_tribute_type_code` FOREIGN KEY (`tribute_code`) REFERENCES `tribute_type_code` (`code`);

--
-- Filtros para la tabla `business_user`
--
ALTER TABLE `business_user`
  ADD CONSTRAINT `fk_business_user_business` FOREIGN KEY (`business_id`) REFERENCES `business` (`business_id`);

--
-- Filtros para la tabla `detail_referral_guide`
--
ALTER TABLE `detail_referral_guide`
  ADD CONSTRAINT `fk_detail_referral_guide_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_detail_referral_guide_referral_guide` FOREIGN KEY (`referral_guide_id`) REFERENCES `referral_guide` (`referral_guide_id`);

--
-- Filtros para la tabla `detail_sale`
--
ALTER TABLE `detail_sale`
  ADD CONSTRAINT `fk_detail_sale_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_detail_sale_sale` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`);

--
-- Filtros para la tabla `detail_sale_note`
--
ALTER TABLE `detail_sale_note`
  ADD CONSTRAINT `fk_detail_sale_note_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_detail_sale_note_sale_note` FOREIGN KEY (`sale_note_id`) REFERENCES `sale_note` (`sale_note_id`);

--
-- Filtros para la tabla `detail_sale_note_summary`
--
ALTER TABLE `detail_sale_note_summary`
  ADD CONSTRAINT `fk_detail_sale_note_summary_sale_note` FOREIGN KEY (`sale_note_id`) REFERENCES `sale_note` (`sale_note_id`),
  ADD CONSTRAINT `fk_detail_sale_note_summary_sale_note_summary` FOREIGN KEY (`sale_note_summary_id`) REFERENCES `sale_note_summary` (`sale_note_summary_id`);

--
-- Filtros para la tabla `detail_ticket_summary`
--
ALTER TABLE `detail_ticket_summary`
  ADD CONSTRAINT `fk_detail_ticket_summary_sale` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`),
  ADD CONSTRAINT `fk_detail_ticket_summary_summary_state_code` FOREIGN KEY (`summary_state_code`) REFERENCES `summary_state_code` (`code`),
  ADD CONSTRAINT `fk_detail_ticket_summary_ticket_summary` FOREIGN KEY (`ticket_summary_id`) REFERENCES `ticket_summary` (`ticket_summary_id`);

--
-- Filtros para la tabla `document_correlative`
--
ALTER TABLE `document_correlative`
  ADD CONSTRAINT `fk_document_correlative_document_code` FOREIGN KEY (`document_code`) REFERENCES `document_type_code` (`code`);

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_product_code` FOREIGN KEY (`product_code`) REFERENCES `product_code` (`code`),
  ADD CONSTRAINT `fk_product_unit_measure_code` FOREIGN KEY (`unit_measure_code`) REFERENCES `unit_measure_type_code` (`code`);

--
-- Filtros para la tabla `referral_guide`
--
ALTER TABLE `referral_guide`
  ADD CONSTRAINT `fk_referral_guide_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fk_referral_guide_location_arrival_code` FOREIGN KEY (`location_arrival_code`) REFERENCES `geographical_location_code` (`code`),
  ADD CONSTRAINT `fk_referral_guide_location_starting_code` FOREIGN KEY (`location_starting_code`) REFERENCES `geographical_location_code` (`code`);

--
-- Filtros para la tabla `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `fk_sale_currency_type_code` FOREIGN KEY (`currency_code`) REFERENCES `currency_type_code` (`code`),
  ADD CONSTRAINT `fk_sale_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fk_sale_document_type_code` FOREIGN KEY (`document_code`) REFERENCES `document_type_code` (`code`),
  ADD CONSTRAINT `fk_sale_operation_type_code` FOREIGN KEY (`operation_code`) REFERENCES `operation_type_code` (`code`);

--
-- Filtros para la tabla `sale_note`
--
ALTER TABLE `sale_note`
  ADD CONSTRAINT `fk_sale_note_currency_type_code` FOREIGN KEY (`currency_code`) REFERENCES `currency_type_code` (`code`),
  ADD CONSTRAINT `fk_sale_note_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `fk_sale_note_document_type_code` FOREIGN KEY (`document_code`) REFERENCES `document_type_code` (`code`),
  ADD CONSTRAINT `fk_sale_note_operation_type_code` FOREIGN KEY (`operation_code`) REFERENCES `operation_type_code` (`code`);

--
-- Filtros para la tabla `sale_note_voided`
--
ALTER TABLE `sale_note_voided`
  ADD CONSTRAINT `fk_sale_note_voided_sale` FOREIGN KEY (`sale_note_id`) REFERENCES `sale_note` (`sale_note_id`);

--
-- Filtros para la tabla `sale_referral_guide`
--
ALTER TABLE `sale_referral_guide`
  ADD CONSTRAINT `fk_sale_referral_guide` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`),
  ADD CONSTRAINT `fk_sale_referral_guide_referral_guide` FOREIGN KEY (`referral_guide_id`) REFERENCES `referral_guide` (`referral_guide_id`);

--
-- Filtros para la tabla `sale_voided`
--
ALTER TABLE `sale_voided`
  ADD CONSTRAINT `fk_sale_voided_sale` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
