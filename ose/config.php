<?php
	require_once("Model/DataBase/db.php");
	require_once("router.php");
	require_once("Controller/Helper/Common.php");

	date_default_timezone_set('America/Lima');

	set_error_handler('exceptions_error_handler');

	define('SESS',"UserId");
	define('SESS_ROLE',"UserRoleId");
	define('CURRENT_LOCAL','CurrentLocalId');

	define('CONTROLLER_GROUP',"ControllerGroup");
	define('REQUEST_METHOD', $_SERVER['REQUEST_METHOD']);

	/*  Valores de rutas   */
	define('FOLDER_NAME', '/OSE-skynet/ose');
	define('FOLDER_PATH', $_SERVER["DOCUMENT_ROOT"] . FOLDER_NAME);
	define('CONTROLLER_PATH', FOLDER_PATH.'/Controller/');
	define('MODEL_PATH', FOLDER_PATH.'/Model/');
	define('VIEW_PATH', FOLDER_PATH.'/View/');
	define('XML_FOLDER_PATH', '/XmlFiles/');
	define('PDF_FOLDER_PATH', '/PdfFiles/');

	define('DEFAULT_CONTROLLER', 'Home');
	define('DEFAULT_METHOD', 'Exec');

	define('DEFAULT_URL', 'http://localhost/');
//	define('DEFAULT_URL', 'http://corporacionskynet.com/');
	define('SUNAT_SERVICE_URL', 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl');
    define('SUNAT_GUIDE_SERVICE_URL', 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl');
?>
