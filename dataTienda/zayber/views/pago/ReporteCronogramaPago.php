
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Reporte Cronograma Pago
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-1 col-sm-2 col-xs-6 p-2">
							<span class="claTexto">F.Inicio</span></br>
							<input type="text" class="form_input" id="IdFechaIn_ReportPago" readonly>
						</div>
						<div class="col-md-1 col-sm-2 col-xs-6 p-2">
							<span class="claTexto">F.Fin</span></br>
							<input type="text" class="form_input" id="IdFechaFn_ReportPago" readonly>
						</div>
						<div class="col-md-4 col-sm-2 col-xs-6">
							<span class="claTexto">Cliente</span></br>
							<select id="cboCliente_RepVent"></select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="cboPrint_RPago"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="cboExportar_RPago"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContentRPago">
								<table class="claTableReport" id="IdTableReportec_ReportPago">
									<thead><tr class="">
										<th>N°</th>
										<th>Mes</th><th>Cliente</th><th>Fecha Pago</th><th>Monto</th><th>Tipo Pago</th><th>Obs</th><th>Usuario</th>
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

<script src="./views/pago/ReporteCronogramaPago.js"></script>
