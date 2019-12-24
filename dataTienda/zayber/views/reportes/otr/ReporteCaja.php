<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmRCaja" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRCaja" style="display:none"><?php  echo $Almacen ?></label>
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Reporte Caja
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Inicio</span></br>
							<input type="text" class="form_input" id="IdFechaIn_ReportCaja" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Fin</span></br>
							<input type="text" class="form_input" id="IdFechaFn_ReportCaja" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="cboPrint_RCaja"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="cboExportar_RCaja"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div>
						<!--<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnAgruparGR" id="btnGroupGR_RVenta"><i class="fas fa-object-group f-18"></i> AGRUPAR GUIA REMIS.</button>
						</div>-->
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_RCaja">
								<table class="claTableReport" id="IdTableReportec_ReportCaja">
									<thead><tr class="">
										<th>Nro</th><th>Tipo</th><th>Tipo Servicio</th><th>S/.</th><th>$.</th><th>Fecha Reg.</th>
										<th>Usuario</th><th>Saldo S/.</th><th>Saldo $.</th><th>Descripcion</th><th>Obs</th>
									</tr></thead><tbody class="buscar"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="./views/reportes/ReporteCaja.js"></script>
