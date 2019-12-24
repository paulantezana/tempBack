<?php 
class Paginas{
	public static function enlacesPaginasModel($enlaces){
		// home Principal
		if($enlaces == "home"){$module =  "views/principal/home.php";}
		
		//REGISTRO
		else if($enlaces == "RegistrosUsuario"){$module =  "views/registro/RegistrosUsuario.php";}
		else if($enlaces == "PermisoUsuario"){$module =  "views/registro/PermisoUsuario.php";}
		else if($enlaces == "TipoUsuario"){$module =  "views/registro/TipoUsuario.php";}
		
		//MANTENIMIENTO
		else if($enlaces == "ManteProductos"){$module =  "views/mante/ManteProductos.php";}
		else if($enlaces == "ManteAlmacenProducto"){$module =  "views/mante/ManteAlmacenProducto.php";}
		else if($enlaces == "ManteMarca"){$module =  "views/mante/ManteMarca.php";}
		else if($enlaces == "ManteCategoria"){$module =  "views/mante/ManteCategoria.php";}
		else if($enlaces == "ManteUnidad"){$module =  "views/mante/ManteUnidad.php";}
		else if($enlaces == "ManteProveedor"){$module =  "views/mante/ManteProveedor.php";}
		else if($enlaces == "ManteClienteTarifa"){$module =  "views/mante/ManteClienteTarifa.php";}
		else if($enlaces == "ManteCliente"){$module =  "views/mante/ManteCliente.php";}
		else if($enlaces == "ManteAlmacen"){$module =  "views/mante/ManteAlmacen.php";}
		else if($enlaces == "ManteTipoCambio"){$module =  "views/mante/ManteTipoCambio.php";}
		else if($enlaces == "ManteTipoPlan"){$module =  "views/pago/ManteTipoPlan.php";}
		else if($enlaces == "ImportarPorductos"){$module =  "views/mante/ImportarPorductos.php";}
		
		
		//PROCESO
		else if($enlaces == "RegistroCompra"){$module =  "views/procesos/RegistroCompra.php";}
		else if($enlaces == "RegistroVenta"){$module =  "views/procesos/RegistroVenta.php";}
		else if($enlaces == "RegistroMovimientoAlm"){$module =  "views/procesos/RegistroMovimientoAlm.php";}
		else if($enlaces == "RegistroCompraSimple"){$module =  "views/procesos/RegistroCompraSimple.php";}
		else if($enlaces == "Caja"){$module =  "views/procesos/Caja.php";}
		else if($enlaces == "RegistroNotaPedido"){$module =  "views/procesos/RegistroNotaPedido.php";}
		else if($enlaces == "CompraPago"){$module =  "views/procesos/CompraPago.php";}
		else if($enlaces == "VentaPago"){$module =  "views/procesos/VentaPago.php";}
		else if($enlaces == "Vendedor"){$module =  "views/procesos/Vendedor.php";}
		else if($enlaces == "PagoProveedor"){$module =  "views/procesos/PagoProveedor.php";}
		else if($enlaces == "ProcesarMovAlm"){$module =  "views/procesos/ProcesarMovAlm.php";}
		else if($enlaces == "ProcesarCronogramaPago"){$module =  "views/pago/ProcesarCronogramaPago.php";}
		else if($enlaces == "ResumenCaja"){$module =  "views/procesos/ResumenCaja.php";}
		else if($enlaces == "RegistroVentaRapida"){$module =  "views/procesos/RegistroVentaRapida.php";}
		
		//REPORTES
		else if($enlaces == "ReporteCompra"){$module =  "views/reportes/ReporteCompra.php";}
		else if($enlaces == "ReporteKardex"){$module =  "views/reportes/ReporteKardex.php";}
		else if($enlaces == "ReporteVenta"){$module =  "views/reportes/ReporteVenta.php";}
		else if($enlaces == "ReporteVentaProducto"){$module =  "views/reportes/ReporteVentaProducto.php";}
		else if($enlaces == "ReporteVentaNP"){$module =  "views/reportes/ReporteVentaNP.php";}
		else if($enlaces == "ReporteVentaIngresos"){$module =  "views/reportes/otr/ReporteVentaIngresos.php";}
		else if($enlaces == "ReportePagoVenta"){$module =  "views/reportes/ReportePagoVenta.php";}
		else if($enlaces == "ReporteCompraCredito"){$module =  "views/reportes/otr/ReporteCompraCredito.php";}
		else if($enlaces == "ReporteVentaCredito"){$module =  "views/reportes/otr/ReporteVentaCredito.php";}
		else if($enlaces == "ReporteCompraSimple"){$module =  "views/reportes/ReporteCompraSimple.php";}
		else if($enlaces == "ReporteCaja"){$module =  "views/reportes/ReporteCaja.php";}
		else if($enlaces == "PrecioAlmacen"){$module =  "views/reportes/PrecioAlmacen.php";}
		else if($enlaces == "ReporteCronogramaPago"){$module =  "views/pago/ReporteCronogramaPago.php";}
		else if($enlaces == "VentasProductosEspeciales"){$module =  "views/reportes/ReporteProductosEspeciales.php";}
		
		/* SALIR O IR A LOGIN  */
		else if($enlaces == "salir"){$module =  "views/principal/salir.php";}
		else if($enlaces == "login"){$module =  "views/principal/salir.php";}
		else{$module =  "views/principal/salir.php";}
		return $module;
	}
}
?>