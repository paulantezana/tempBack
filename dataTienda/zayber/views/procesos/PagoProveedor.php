<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Pago Proveedor
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Inicio</span></br>
							<input type="text" class="form_input" id="IdFechaIn_PAGPROV" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Fin</span></br>
							<input type="text" class="form_input" id="IdFechaFn_PAGPROV" readonly>
						</div>
						<!--<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Empresa</span></br>
							<select id="cboEmpresa_PAGV"></select>
						</div>-->
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<!--<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="cboPrint_RCompra"><i class="fas fa-print f-18"></i> IMPRIMIR</button>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnExportarExc" id="cboExportar_RCompra"><i class="fas fa-file-excel f-18"></i> EXPORTAR EXCEL</button>
						</div> -->
						
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_PAGPROV">
								<table class="claTableReport" id="IdTableReportec_PAGPROV">
									<thead><tr class="">
										<th>Pagar</th><th>CC</th><th>Proveedor</th><th>Capital</th><th>Interes</th><th>Total</th>
										<th>Fecha Limt.</th><th>Monto</th><th>Mora</th><th>Total Pagar</th><th>Fecha Pago</th>
										<th>User Pago</th><th>Detail</th>
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

<script src="./views/procesos/PagoProveedor.js"></script>

