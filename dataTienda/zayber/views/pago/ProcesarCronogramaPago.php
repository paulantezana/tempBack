	
<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Cronograma Pago Cliente
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<span class="claTexto">Cliente</span></br>
					<select id="cboCliente_ProcPago"><option value="-1">Seleccione</option></select>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6 right">
					</br><button class="btnProceso" id="btnNewCliente_ProcPago"><i class="fas fa-file"></i> Nuevo</button>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive" id="IdContent_ClientePago">
						<table class="claTableProceso" id="IdTable_ClientePago">
							<thead><tr>
								<th>N</th><th>Mes</th><th>Fecha Vec</th><th>Monto</th><th>Plan</th><th>Estado</th>
								<th>Pagar</th><th>Print</th>
							</tr></thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="./views/pago/ProcesarCronogramaPago.js"></script>
