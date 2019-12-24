<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmRepVentaPag" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRepVentaPag" style="display:none"><?php  echo $Almacen ?></label>
		
		<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row claTitleMante">
				<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12">
					<h2>Reporte Clientes Pago</h2>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
			<div class="row claPadd5">
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-8 p-b-5">
					Fecha Inicio </br>
					<input type="text" class="form_input" id="IdFechaIn_ReportVentaPago" readonly>
				</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-8 p-b-5">
					Fecha Fin </br>
					<input type="text" class="form_input" id="IdFechaFn_ReportVentaPago" readonly>
				</div>
				<div class="col-lg-4 col-md-4 col-ms-6 col-xs-8 p-b-5">
					Cliente </br>
					<select id="cboCliente_ProcVentaPago"></select>
				</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-6">
					<button id="cboPrint_RVentaPago" class="btn btn-success btn-sm f-14">Imprimir</button>
				</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-6">
					<button id="cboExportar_RVentaPago" class="btn btn-success btn-sm f-14">Exportar Excel</button>
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
				<div class="table-responsive" id="IdContentRVentaPago">
					<table class="claTableRegD" id="IdTableReportec_ReportVentaPago">
						<thead><tr class="">
							<th>P</th><th>Sel</th>
							<th>Fecha</th><th>Comprobante</th><th>Serie</th><th>Numero</th><th>Nro Doc</th><th>Rs/Nombres</th><th>Direccion</th>
							<th>Total</th><th>SubTotal</th><th>IGV</th><th>Usuario</th><th>Obs</th><th>Tipo</th><th>Estado</th>
						</tr></thead><tbody class="buscar"></tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-ms-12 col-xs-12">
			<div class="row claPadd5">
				<div class="col-lg-6 col-md-6 col-ms-6 col-xs-12 p-b-5">
				</div>
				<div class="col-lg-2 col-md-2 col-ms-3 col-xs-12 center">
					<button id="cboPagar_RVentaPago" class="btn btn-primary btn-sm f-14">Pagar Comprobante</button>
				</div>
			</div>
		</div>
<script src="./views/reportes/ReportePagoVenta.js"></script>
<script src="./views/procesos/RegistroPrint.js"></script>
