<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_ReportVenta();
	$Alm=$pDatos["Alm"];
	$Empresa=$pDatos["Empresa"];
	$IdAlmacen=-1;$Almacen="";
	if(count($Alm)>0){
		$IdAlmacen=$Alm[0]["IdAlmacen"];$Almacen=$Alm[0]["Almacen"];
	}
?>
		<label id="IdAlmRepVenta" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRepVenta" style="display:none"><?php  echo $Almacen ?></label>
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Resumen de Movimiento de caja
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-1 col-sm-2 col-xs-6 p-2">
							<span class="claTexto">Fecha</span></br>
							<input type="text" class="form_input" id="IdFechaIn_ReportVenta" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6" style="display:none">
							<span class="claTexto">Empresa</span></br>
							<select id="cboEmpresa_RepVent"><?php echo $Empresa ?></select>
						</div>
                        <div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Usuario</span></br>
							<select id="cboUsuario"></select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="cboPrint_RVenta"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="cboExportar_RVenta"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div>
						<!--<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnAgruparGR" id="btnGroupGR_RVenta"><i class="fas fa-object-group f-18"></i> AGRUPAR GUIA REMIS.</button>
						</div> -->
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContentRVenta">
								<table class="claTableReport" id="IdTableReportec_ReportVenta">
									<thead><tr>
										<th>Ventas</th><th>Anuladas</th><th>Total Soles</th>
									</tr></thead><tbody class="buscar"></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContentRVenta">
								<table class="claTableReport" id="IdTableIngresosGastos">
									<thead><tr>
										<th>Proceso</th><th>Monto</th>
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

		

<script src="./views/procesos/ResumenCaja.js"></script>
<script src="./views/procesos/RegistroPrint.js"></script>
