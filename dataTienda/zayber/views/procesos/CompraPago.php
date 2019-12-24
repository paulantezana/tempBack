<?php
	$controller = new MvcController();$pDatos=$controller->combo_Almacen_Id();
	$IdAlmacen=-1;$Almacen="";
	if(count($pDatos)>0){
		$IdAlmacen=$pDatos[0]["IdAlmacen"];$Almacen=$pDatos[0]["Almacen"];
	}
?>
		<label id="IdAlmRepCPC" style="display:none"><?php  echo $IdAlmacen ?></label>
		<label id="AlmRepCPC" style="display:none"><?php  echo $Almacen ?></label>

<div class="col-md-12 col-sm-12 col-xs-12 marginProceso">
	<div class="row PaddRowP">
		<div class="col-md-12 col-sm-12 col-xs-12 center claTitleProceso">
			Compra Credito Pago
		</div>
		<div class="col-md-12 col-xl-12 p-t-5">
			<div class="row fondoProceso">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Inicio</span></br>
							<input type="text" class="form_input" id="IdFechaIn_COMPPAG" readonly>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">F.Fin</span></br>
							<input type="text" class="form_input" id="IdFechaFn_COMPPAG" readonly>
						</div>
						<!--<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Empresa</span></br>
							<select id="cboEmpresa_VPV"></select>
						</div>-->
						<div class="col-md-2 col-sm-2 col-xs-6">
							<span class="claTexto">Buscar</span></br>
							<input type="text" class="form_input" id="filtrar" placeholder="Buscar...">
						</div>
						<div class="col-md-2 col-sm-2 col-xs-6 center">
							<button class="btnImprimir" id="btnAgruparCPago_COMPPAG"><i class="fas fa-print f-18"></i> Agrupar Pago</button>
						</div>
					</div>
					<div class="row p-t-10">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="table-responsive" id="IdContent_COMPPAG">
								<table class="claTableReport" id="IdTable_ReportCOMPPAG">
									<thead><tr class="">
										<th>Sel</th><th>Pagar</th><th style="display:none">IdP</th>
										<th>Fecha</th><th>Comprobante S/Nro</th><th>Proveedor</th>
										<th>Total</th><th>Usuario</th><th>Estado</th><th>Fecha Pago</th><th>X</th>
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

<script src="./views/procesos/CompraPago.js"></script>

