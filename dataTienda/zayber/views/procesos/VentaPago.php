

<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Venta Pago Vendedor
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Inicio</span></br>
							<input type="text" class="form_input" id="IdFechaIn_VPV" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Fin</span></br>
							<input type="text" class="form_input" id="IdFechaFn_VPV" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Empresa</span></br>
							<select id="cboEmpresa_VPV"></select>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnAgruparCredito_VPV"><i class="fas fa-print f-18"></i> Agrupar Credito</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContentRVPV">
								<table class="claTableReport" id="IdTableReportec_ReportVPV">
									<thead><tr class="">
										<th>Sel</th><th>Pagar</th><th style="display:none">IdClient</th>
										<th>Empresa</th><th>Fecha</th><th>Comprobante S/Nro</th><th>Nro Doc</th><th>Rs/Nombres</th>
										<th>Total</th><th>Usuario</th><th>Email</th><th>Estado</th><th>Fecha Pago</th><th>X</th>
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

<script src="./views/procesos/VentaPago.js"></script>
<script src="./views/procesos/RegistroPrint.js"></script>
