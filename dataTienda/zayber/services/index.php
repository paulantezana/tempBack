<?php
	session_start();
	if(!isset($_SESSION["UserTRPE"]))die();	
	require_once("../model/functions_query.php");	
	require_once("Registro.php");
	require_once("Mante.php");
	require_once("Procesos.php");
	require_once("Reporte.php");
	require_once("RucNubefact.php");
	require_once("Pago.php");
	
	if(isset($_POST["object"]))
	{
		if($_POST["object"]=='objRegistro'){
			
			//TIPO USUARIO
			if($_POST["action"]=='getList_Mante_TipoUsuario'){
				echo json_encode(ClaRegistro::getList_Mante_TipoUsuario($_SESSION["UserTRPE"]["IdCompany"]));
			}
			
			//REGISTRO USUARIO
			else if($_POST["action"]=='getList_Mante_UserSystem'){
				echo json_encode(ClaRegistro::getList_Mante_UserSystem($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_UserSystem_Edit'){
				echo json_encode(ClaRegistro::getList_Mante_UserSystem_Edit($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Mante_UserSystem'){
				echo json_encode(ClaRegistro::Save_Mante_UserSystem($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_UserSystem_Venta'){
				echo json_encode(ClaRegistro::getList_Mante_UserSystem_Venta($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Config_UserSystem_Alm'){
				echo json_encode(ClaRegistro::Save_Config_UserSystem_Alm($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}
			
			//PERMISO USUARIO 
			else if($_POST["action"]=='getList_Config_PermisoUser'){
				echo json_encode(ClaRegistro::getList_Config_PermisoUser($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Config_PermisoUserDatos'){
				echo json_encode(ClaRegistro::getList_Config_PermisoUserDatos($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Config_PermisoUser'){
				echo json_encode(ClaRegistro::Save_Config_PermisoUser($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}
	
		}
		else if($_POST["object"]=='objMante'){
			
			//ALMACEN
			if($_POST["action"]=='getList_Mante_Almacen'){
				echo json_encode(ClaMante::getList_Mante_Almacen($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_Almacen_Edit'){
				echo json_encode(ClaMante::getList_Mante_Almacen_Edit($_POST["array"]));
			}else if($_POST["action"]=='Save_Mante_Almacen'){
				echo json_encode(ClaMante::Save_Mante_Almacen($_POST["array"]));
			}
			
			//UNIDAD
			else if($_POST["action"]=='getList_Mante_Unidad'){
				echo json_encode(ClaMante::getList_Mante_Unidad($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_Unidad_Edit'){
				echo json_encode(ClaMante::getList_Mante_Unidad_Edit($_POST["array"]));
			}else if($_POST["action"]=='Save_Mante_Unidad'){
				echo json_encode(ClaMante::Save_Mante_Unidad($_POST["array"]));
			}
			
			//MARCA
			else if($_POST["action"]=='getList_Mante_Marca'){
				echo json_encode(ClaMante::getList_Mante_Marca($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_Marca_Edit'){
				echo json_encode(ClaMante::getList_Mante_Marca_Edit($_POST["array"]));
			}else if($_POST["action"]=='Save_Mante_Marca'){
				echo json_encode(ClaMante::Save_Mante_Marca($_POST["array"]));
			}
			
			//MODELO
			else if($_POST["action"]=='getList_Mante_Categoria'){
				echo json_encode(ClaMante::getList_Mante_Categoria($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_Categoria_Edit'){
				echo json_encode(ClaMante::getList_Mante_Categoria_Edit($_POST["array"]));
			}else if($_POST["action"]=='Save_Mante_Categoria'){
				echo json_encode(ClaMante::Save_Mante_Categoria($_POST["array"]));
			}
			
			//PRODUCTOS
			else if($_POST["action"]=='getList_Mante_Productos'){
				echo json_encode(ClaMante::getList_Mante_Productos($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_ManteProductos_Edit'){
				echo json_encode(ClaMante::getList_ManteProductos_Edit($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Mante_Productos'){
				echo json_encode(ClaMante::Save_Mante_Productos($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}
			
			//PRODUCTOS ALMACEN
			else if($_POST["action"]=='getList_Mante_ProductoAlm'){
				echo json_encode(ClaMante::getList_Mante_ProductoAlm($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Datos_ProductoAlm'){
				echo json_encode(ClaMante::getList_Datos_ProductoAlm($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_ProductoAlm_Edit'){
				echo json_encode(ClaMante::getList_Mante_ProductoAlm_Edit($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Mante_ProductoAlm'){
				echo json_encode(ClaMante::Save_Mante_ProductoAlm($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_cbo_ProductoAlm_IdProd'){
				echo json_encode(ClaMante::getList_cbo_ProductoAlm_IdProd($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}
			
			//PROVEEDOR
			else if($_POST["action"]=='getList_Mante_Proveedor'){
				echo json_encode(ClaMante::getList_Mante_Proveedor($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_Proveedor_Edit'){
				echo json_encode(ClaMante::getList_Mante_Proveedor_Edit($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Mante_Proveedor'){
				echo json_encode(ClaMante::Save_Mante_Proveedor($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}
			
			//CLIENTE
			else if($_POST["action"]=='getList_Mante_Cliente'){
				echo json_encode(ClaMante::getList_Mante_Cliente($_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_Mante_Cliente_Edit'){
				echo json_encode(ClaMante::getList_Mante_Cliente_Edit($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='Save_Mante_Cliente'){
				echo json_encode(ClaMante::Save_Mante_Cliente($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"]));
			}else if($_POST["action"]=='getList_NroRuc_Client'){
				echo json_encode(ClaMante::getList_NroRuc_Client($_POST["array"]));
			}
			
			//TC
			else if($_POST["action"]=='getList_Mante_TC'){
				echo json_encode(ClaMante::getList_Mante_TC());
			}else if($_POST["action"]=='Save_Mante_TC'){
				echo json_encode(ClaMante::Save_Mante_TC($_POST["array"]));
			}
			
			//EXPORTAR PRODUCTO ALMACEN
			else if($_POST["action"]=='getList_Datos_ExportarProduct'){
				echo json_encode(ClaMante::getList_Datos_ExportarProduct($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_ImportarProduct'){
				echo json_encode(ClaMante::getList_Datos_ImportarProduct());
			}else if($_POST["action"]=='Save_Marca_ImportarProduct'){
				echo json_encode(ClaMante::Save_Marca_ImportarProduct($_POST["array"]));
			}else if($_POST["action"]=='Save_Modelo_ImportarProduct'){
				echo json_encode(ClaMante::Save_Modelo_ImportarProduct($_POST["array"]));
			}else if($_POST["action"]=='Save_Producto_ImportarProduct'){
				echo json_encode(ClaMante::Save_Producto_ImportarProduct($_POST["array"]));
			}
		}
		else if($_POST["object"]=='objProceso'){
			
			//Compra
			if($_POST["action"]=='getList_combo_Compra'){
				echo json_encode(ClaProceso::getList_combo_Compra($_POST["array"]));
			}else if($_POST["action"]=='getList_Producto_Id'){
				echo json_encode(ClaProceso::getList_Producto_Id($_POST["array"]));
			}else if($_POST["action"]=='getList_Proveedor_Id'){
				echo json_encode(ClaProceso::getList_Proveedor_Id($_POST["array"]));
			}else if($_POST["action"]=='getList_Mante_Proveedor_Update'){
				echo json_encode(ClaProceso::getList_Mante_Proveedor_Update());
			}else if($_POST["action"]=='getList_Productos_AlmComp'){
				echo json_encode(ClaProceso::getList_Productos_AlmComp($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_Compra'){
				echo json_encode(ClaProceso::Save_Datos_Compra($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//VENTA
			else if($_POST["action"]=='getList_Documentos_Venta'){
				echo json_encode(ClaProceso::getList_Documentos_Venta($_POST["array"]));
			}
			//VENTA RAPIDA
			else if($_POST["action"]=='RecuperarListaProductos'){
				echo json_encode(ClaProceso::RecuperarListaProductos($_POST["array"]));
			}else if($_POST["action"]=='RecuperarProductosEspeciales'){
				echo json_encode(ClaProceso::RecuperarProductosEspeciales($_POST["array"]));
			}else if($_POST["action"]=='ObtenerStockAlmacenes'){
				echo json_encode(ClaProceso::ObtenerStockAlmacenes($_POST["array"]));
			}

			//NOTA PEDIDO 
			else if($_POST["action"]=='getList_User_Alm'){
				echo json_encode(ClaProceso::getList_User_Alm($_SESSION["UserTRPE"]["IdUser"],$_SESSION["UserTRPE"]["IdCompany"]));
			} else if($_POST["action"]=='getList_combo_VentaNP'){
				echo json_encode(ClaProceso::getList_combo_VentaNP($_POST["array"]));
			}else if($_POST["action"]=='getList_Serie_Numero_VentaNP'){
				echo json_encode(ClaProceso::getList_Serie_Numero_VentaNP($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_Venta_NP'){
				echo json_encode(ClaProceso::Save_Datos_Venta_NP($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//COMPRA SIMPLE 
			else if($_POST["action"]=='getList_Producto_Codigo_CS'){
				echo json_encode(ClaProceso::getList_Producto_Codigo_CS($_POST["array"]));
			}else if($_POST["action"]=='getList_Productos_AlmComp_CS'){
				echo json_encode(ClaProceso::getList_Productos_AlmComp_CS($_POST["array"]));
			}else if($_POST["action"]=='getList_Producto_Id_CS'){
				echo json_encode(ClaProceso::getList_Producto_Id_CS($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_CompraSimple'){
				echo json_encode(ClaProceso::Save_Datos_CompraSimple($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			
			
			else if($_POST["action"]=='getList_Clientes_ProcVenta'){
				echo json_encode(ClaProceso::getList_Clientes_ProcVenta());
			}else if($_POST["action"]=='getList_Datos_VentaNP'){
				echo json_encode(ClaProceso::getList_Datos_VentaNP($_POST["array"]));
			}else if($_POST["action"]=='getList_RecuperarDetail_VentaNP'){
				echo json_encode(ClaProceso::getList_RecuperarDetail_VentaNP($_POST["array"]));
			}else if($_POST["action"]=='getList_Producto_Codigo'){
				echo json_encode(ClaProceso::getList_Producto_Codigo($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_Venta'){
				echo json_encode(ClaProceso::Save_Datos_Venta($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			/* buscar ruc con nubefact */
			else if($_POST["action"]=='getList_RecuperarRS_Nubefact'){
				echo json_encode(ClaRucNubefact::getList_Ruc_NubeFact($_POST["array"]));
			}
			
			
			
			
			
			//PAGO PROVEEDOR  
			else if($_POST["action"]=='getList_Datos_PAGV'){
				echo json_encode(ClaProceso::getList_Datos_PAGV($_POST["array"]));
			}else if($_POST["action"]=='getList_Ids_PayCreditoProv'){
				echo json_encode(ClaProceso::getList_Ids_PayCreditoProv($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_PayCreditoProv'){
				echo json_encode(ClaProceso::getList_Datos_PayCreditoProv($_POST["array"]));
			}else if($_POST["action"]=='Save_Pago_CompraCrdProve'){
				echo json_encode(ClaProceso::Save_Pago_CompraCrdProve($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			
			
			//Movimiento Almacenes
			else if($_POST["action"]=='getList_combo_MovAlm'){
				echo json_encode(ClaProceso::getList_combo_MovAlm());
			}else if($_POST["action"]=='getList_Productos_IdAlm'){
				echo json_encode(ClaProceso::getList_Productos_IdAlm($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_MovAlm'){
				echo json_encode(ClaProceso::Save_Datos_MovAlm($_POST["array"],$_SESSION["UserTRPE"]["IdCompany"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//CAJA
			else if($_POST["action"]=='getList_Datos_Caja'){
				echo json_encode(ClaProceso::getList_Datos_Caja($_POST["array"],$_POST["fecha"],$_SESSION["UserTRPE"]["IdCompany"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Save_Ingreso_Caja'){
				echo json_encode(ClaProceso::Save_Ingreso_Caja($_POST["array"],$_POST["fecha"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_combo_CajaEgreso'){
				echo json_encode(ClaProceso::getList_combo_CajaEgreso($_SESSION["UserTRPE"]["IdCompany"]));
			}
			
			//procesar mov alm 
			else if($_POST["action"]=='getList_Datos_RMovAlm'){
				echo json_encode(ClaProceso::getList_Datos_RMovAlm($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_AprobMovAlm_Detalle'){
				echo json_encode(ClaProceso::getList_Datos_AprobMovAlm_Detalle($_POST["array"]));
			}else if($_POST["action"]=='Procesar_MovALm'){
				echo json_encode(ClaProceso::Procesar_MovALm($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Anular_MovALm'){
				echo json_encode(ClaProceso::Anular_MovALm($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
		}
		else if($_POST["object"]=='objReport'){
			//PRINT TICKET 
			if($_POST["action"]=='getList_Datos_printTICKETS'){
				echo json_encode(ClaReport::getList_Datos_printTICKETS($_POST["array"]));
			}
			
			//PRINT factura y boleta 
			else if($_POST["action"]=='getList_Print_FacturaBoleta'){
				echo json_encode(ClaReport::getList_Print_FacturaBoleta($_POST["array"]));
			}
			
			//REOORTE VENTA
			else if($_POST["action"]=='getList_Datos_RVenta'){
				echo json_encode(ClaReport::getList_Datos_RVenta($_POST["array"]));
			}
			
			
			//RECPORTE COMPRA SIMPLE
			if($_POST["action"]=='getList_Datos_RCompraS'){
				echo json_encode(ClaReport::getList_Datos_RCompraS($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_CompraS_Detalle'){
				echo json_encode(ClaReport::getList_Datos_CompraS_Detalle($_POST["array"]));
			}else if($_POST["action"]=='Anular_CompraS'){
				echo json_encode(ClaReport::Anular_CompraS($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			
			
			
			
			
			//RECPORTE COMPRA
			else if($_POST["action"]=='getList_Datos_RCompra'){
				echo json_encode(ClaReport::getList_Datos_RCompra($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_Compra_Detalle'){
				echo json_encode(ClaReport::getList_Datos_Compra_Detalle($_POST["array"]));
			}else if($_POST["action"]=='Anular_Compra'){
				echo json_encode(ClaReport::Anular_Compra($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//NOTA PEDIDO 
			else if($_POST["action"]=='getList_Datos_RNP'){
				echo json_encode(ClaReport::getList_Datos_RNP($_POST["array"]));
			}else if($_POST["action"]=='Anular_Venta_NP'){
				echo json_encode(ClaReport::Anular_Venta_NP($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_Datos_NotaPedido_Detalle'){
				echo json_encode(ClaReport::getList_Datos_NotaPedido_Detalle($_POST["array"]));
			}
			
			//REPORT VENTA PAGO VENDEDOR
			else if($_POST["action"]=='getList_cbo_VPV'){
				echo json_encode(ClaReport::getList_cbo_VPV());
			}else if($_POST["action"]=='getList_cbo_VentCrd_VPV'){
				echo json_encode(ClaReport::getList_cbo_VentCrd_VPV());
			}else if($_POST["action"]=='getList_Datos_VPV'){
				echo json_encode(ClaReport::getList_Datos_VPV($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_VentaCredito'){
				echo json_encode(ClaReport::Save_Datos_VentaCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Save_PagarSimple_VentaCreditoS'){
				echo json_encode(ClaReport::Save_PagarSimple_VentaCreditoS($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Build_Modal_Delete_VentaCredito'){
				echo json_encode(ClaReport::Build_Modal_Delete_VentaCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_combo_RVenta'){
				echo json_encode(ClaReport::getList_combo_RVenta($_POST["array"]));
			}
			
			//PAGO VENTA VENDEDOR
			else if($_POST["action"]=='getList_cbo_PAGV'){
				echo json_encode(ClaReport::getList_cbo_PAGV());
			}else if($_POST["action"]=='getList_Datos_PAGV'){
				echo json_encode(ClaReport::getList_Datos_PAGV($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_Datos_PayCredito'){
				echo json_encode(ClaReport::getList_Datos_PayCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Save_Pago_VentaCredito'){
				echo json_encode(ClaReport::Save_Pago_VentaCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_Ids_PayCredito'){
				echo json_encode(ClaReport::getList_Ids_PayCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Delete_Pago_VentaCredito'){
				echo json_encode(ClaReport::Delete_Pago_VentaCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//PAGO COMPRA CREDITO 
			else if($_POST["action"]=='getList_Datos_CPC'){
				echo json_encode(ClaReport::getList_Datos_CPC($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_CompraCredito'){
				echo json_encode(ClaReport::Save_Datos_CompraCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Save_PagarSimple_CompraCredito'){
				echo json_encode(ClaReport::Save_PagarSimple_CompraCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Build_Modal_Delete_CompraCredito'){
				echo json_encode(ClaReport::Build_Modal_Delete_CompraCredito($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_Datos_CompraCredito_Edit'){
				echo json_encode(ClaReport::getList_Datos_CompraCredito_Edit($_POST["array"]));
			}
			
			//REPORT VENTA Y COMPRA CREDITO
			else if($_POST["action"]=='getList_Datos_RVENTCRD'){
				echo json_encode(ClaReport::getList_Datos_RVENTCRD($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_RCOMPCRD'){
				echo json_encode(ClaReport::getList_Datos_RCOMPCRD($_POST["array"]));
			}
			
			//GENERAR GUIA REMISION
			else if($_POST["action"]=='getList_Gnerar_Guia_Factura'){
				echo json_encode(ClaReport::getList_Gnerar_Guia_Factura($_POST["array"]));
			}else if($_POST["action"]=='Save_GuiaRemis_Factura'){
				echo json_encode(ClaReport::Save_GuiaRemis_Factura($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			//GROUP GUIA REMISION
			else if($_POST["action"]=='getList_Gnerar_Guia_Factura_Group'){
				echo json_encode(ClaReport::getList_Gnerar_Guia_Factura_Group($_POST["array"]));
			}else if($_POST["action"]=='Save_GuiaRemis_Factura_Group'){
				echo json_encode(ClaReport::Save_GuiaRemis_Factura_Group($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//ANULAR VENTA 
			else if($_POST["action"]=='Anular_Datos_Factura'){
				echo json_encode(ClaReport::Anular_Datos_Factura($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}
			
			//KARDEX
			else if($_POST["action"]=='getList_combo_Kardex'){
				echo json_encode(ClaReport::getList_combo_Kardex($_POST["array"]));
			}else if($_POST["action"]=='getList_Datos_Kardex'){
				echo json_encode(ClaReport::getList_Datos_Kardex($_POST["array"]));
			}
			
			//REOORTE CAJA
			else if($_POST["action"]=='getList_Datos_RCaja'){
				echo json_encode(ClaReport::getList_Datos_RCaja($_POST["array"]));
			}
			
			
			
			//PRINT VENTA
			else if($_POST["action"]=='getList_Datos_ReportVentta_Print'){
				echo json_encode(ClaReport::getList_Datos_ReportVentta_Print($_POST["array"]));
			}
			//PRECIO POR ALMACEN
			else if($_POST["action"]=='getList_combo_RPrecioAlm'){
				echo json_encode(ClaReport::getList_combo_RPrecioAlm());
			}else if($_POST["action"]=='getList_Datos_RPrecioAlm'){
				echo json_encode(ClaReport::getList_Datos_RPrecioAlm($_POST["array"]));
			}
			//RESUMEN DE CAJAS
			else if($_POST["action"]=='getList_Usuarios'){
				echo json_encode(ClaReport::getList_Usuarios());
			}else if($_POST["action"]=='getList_DatosCaja'){
				echo json_encode(ClaReport::getList_DatosCaja($_POST["fecha"],$_POST["idAlmacen"],$_POST["IdEmpresa"],$_POST["idUser"]));
			}

			//REPORTE DE VENTA ESPECIAL
			else if($_POST["action"]=='ProductosEspecialesVendidos'){
				echo json_encode(ClaReport::ProductosEspecialesVendidos($_POST["fechaInicio"],$_POST["fechaFin"],$_POST["idAlmacen"]));
			}
		}
		else if($_POST["object"]=='objPago'){
			//cbo
			if($_POST["action"]=='getList_cbo_CronoPago'){
				echo json_encode(ClaPago::getList_cbo_CronoPago());
			}else if($_POST["action"]=='getList_combo_CronoPay'){
				echo json_encode(ClaPago::getList_combo_CronoPay($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_CronoPay'){
				echo json_encode(ClaPago::Save_Datos_CronoPay($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_Datos_CronoPago'){
				echo json_encode(ClaPago::getList_Datos_CronoPago($_POST["array"]));
			}else if($_POST["action"]=='Save_Datos_EditMonto_CronoPay'){
				echo json_encode(ClaPago::Save_Datos_EditMonto_CronoPay($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='Save_Pagar_CronoPay'){
				echo json_encode(ClaPago::Save_Pagar_CronoPay($_POST["array"],$_SESSION["UserTRPE"]["IdUser"]));
			}else if($_POST["action"]=='getList_Tarifa_IdPlan'){
				echo json_encode(ClaPago::getList_Tarifa_IdPlan($_POST["array"]));
			}else if($_POST["action"]=='RePrint_Ticket_Pago'){
				echo json_encode(ClaPago::RePrint_Ticket_Pago($_POST["array"]));
			}
			
			//Report 
			else if($_POST["action"]=='getList_cbo_ReportCronoPago'){
				echo json_encode(ClaPago::getList_cbo_ReportCronoPago());
			}else if($_POST["action"]=='getList_Datos_RPago'){
				echo json_encode(ClaPago::getList_Datos_RPago($_POST["array"]));
			}
			
			//tipo plan
			else if($_POST["action"]=='getList_Mante_Plan'){
				echo json_encode(ClaPago::getList_Mante_Plan());
			}else if($_POST["action"]=='getList_Mante_Plan_Edit'){
				echo json_encode(ClaPago::getList_Mante_Plan_Edit($_POST["array"]));
			}else if($_POST["action"]=='Save_Mante_Plan'){
				echo json_encode(ClaPago::Save_Mante_Plan($_POST["array"]));
			}
		}
		else
			die();
	}
	else
	{
		//$page = $_SERVER['PHP_SELF'];
		//$sec = "2";
		//header("Refresh: $sec; url=$page");
		echo "<script languaje='javascript'>alert('Buscabas algo?\n *Mejor Busca un viajecito');</script>";
	}		
?>