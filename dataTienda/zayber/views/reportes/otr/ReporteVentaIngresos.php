<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmRepVentaIE" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRepVentaIE" style="display:none"><?php  echo $Almacen ?></label>
		
		<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row claTitleMante">
				<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
					<h2>Resporte Ventas e Ingresos</h2>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
			<div class="row claPadd5">
				<div class="col-lg-1 col-md-1 col-ms-3 col-xs-4 p-b-5">F.In</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-8 p-b-5">
					<input type="text" class="form_input" id="IdFechaIn_ReportVentaIE" readonly>
				</div>
				<div class="col-lg-1 col-md-1 col-ms-3 col-xs-4 p-b-5">F.Fn</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-8 p-b-5">
					<input type="text" class="form_input" id="IdFechaFn_ReportVentaIE" readonly>
				</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-6">
					<button id="cboPrint_RVentaIE" class="btn btn-success btn-sm f-14">Imprimir</button>
				</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-6">
					<button id="cboExportar_RVentaIE" class="btn btn-success btn-sm f-14">Exportar Excel</button>
				</div>
			</div>
		</div>
		<div class="row p-l-15 p-r-15">
					<div class="input-group">
					  <span class="input-group-addon">Buscar</span>
					  <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
					</div>
		</div>
		<div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
			<div class="row p-l-5 p-r-5">
				<div class="table-responsive" id="IdContentRVentaIE">
					<table class="claTableRegD" id="IdTableReportec_ReportVentaIE">
						<thead><tr class="">
							<th>N°</th>
							<th>Fecha Emision</th><th>Fecha Vencimiento</th><th>Estado</th><th>Comp</th><th>Serie</th><th>Numero</th><th>Tipo Doc</th>
							<th>RUC/DNI</th><th>Razon Social/Nombres</th><th>Base Imponible</th><th>Exonerada</th><th>I.G.V.</th><th>Importe Total</th>
							<th>Fecha Pago</th><th>Tipo Bien</th><th style="color:red">Fecha Detraccion</th><th>Monto</th><th>Tipo Pago</th>
						</tr></thead><tbody class="buscar"></tbody>
					</table>
				</div>
			</div>
		</div>

<script src="./views/reportes/ReporteVentaIngresos.js"></script>
<!--<script src="./views/procesos/RegistroPrint.js"></script> -->
